<?php

namespace App\Jobs\Analysis;

use App\Exceptions\ConcurrentAnalysisException;
use App\Models\AiModel;
use App\Models\Cluster;
use App\Models\Spot;
use App\Services\AI\LockManager;
use App\Services\GeminiClientService;
use App\Services\PromptLoaderService;
use App\Enums\CoordinateReliability;
use Clickbar\Magellan\Data\Geometries\Point;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * スポット詳細分析ジョブ（Aタイプタスク）
 *
 * 指定されたスポットの詳細情報をAIで分析し、DBに保存する
 * - 座標の取得・検証
 * - 滞在時間の推定
 * - スポット役割の分類
 */
class AnalyzeSpotDetailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** ジョブのタイムアウト時間（秒） */
    public int $timeout = 180;

    /** 最大リトライ回数 */
    public int $tries;

    /** リトライ間隔（秒） */
    public int $backoff;

    /** 座標検証の最大距離（メートル） */
    private const MAX_DISTANCE_FROM_CLUSTER_METERS = 50000; // 50km

    public function __construct(
        public Spot $spot,
        public AiModel $model
    ) {
        $this->tries = config('ai.retry.max_attempts', 3);
        $this->backoff = config('ai.retry.backoff_seconds', 60);
    }

    /**
     * ジョブの実行
     */
    public function handle(
        LockManager $lockManager,
        PromptLoaderService $promptLoader,
        GeminiClientService $geminiClient
    ): void {
        $debugLog = config('ai.debug.log_job_execution', false);

        if ($debugLog) {
            Log::info('[AnalyzeSpotDetailJob] Starting', [
                'spot_id' => $this->spot->id,
                'spot_name' => $this->spot->name,
                'model' => $this->model->model_name,
            ]);
        }

        try {
            // ロックを取得
            $lockManager->acquireLock($this->spot, 'detail', $this->model);

            if ($debugLog) {
                Log::info('[AnalyzeSpotDetailJob] Lock acquired', [
                    'spot_id' => $this->spot->id,
                ]);
            }

            // スポットが属するクラスターを取得
            $cluster = $this->spot->cluster;

            if (! $cluster) {
                throw new Exception('Spot does not belong to any cluster');
            }

            // 詳細情報を取得
            $details = $this->fetchSpotDetails($this->spot, $promptLoader, $geminiClient);

            // 座標を検証
            if (! $this->validateCoordinates($cluster, $details['latitude'], $details['longitude'])) {
                Log::warning('[AnalyzeSpotDetailJob] Coordinates are too far from cluster, retrying...', [
                    'spot_id' => $this->spot->id,
                    'spot_name' => $this->spot->name,
                    'cluster_id' => $cluster->id,
                ]);

                $details = $this->retryCoordinateFetch($this->spot, $promptLoader, $geminiClient, $cluster);
            }

            // スポット情報を更新
            $this->updateSpotWithDetails($this->spot, $details);

            // ロックを解放（分析完了）
            $lockManager->releaseLock($this->spot, 'detail', $this->model);

            // クラスターの分析済みスポット数をインクリメント
            $cluster->increment('analyzed_spots_count');

            Log::info('[AnalyzeSpotDetailJob] Successfully analyzed spot', [
                'spot_id' => $this->spot->id,
                'spot_name' => $this->spot->name,
                'model' => $this->model->model_name,
            ]);

        } catch (ConcurrentAnalysisException $e) {
            // 並行実行が検出された場合はジョブを終了（リトライしない）
            Log::info('[AnalyzeSpotDetailJob] Concurrent execution detected, skipping', [
                'spot_id' => $this->spot->id,
                'error' => $e->getMessage(),
            ]);

            return;

        } catch (Exception $e) {
            Log::error('[AnalyzeSpotDetailJob] Failed to analyze spot', [
                'spot_id' => $this->spot->id,
                'spot_name' => $this->spot->name,
                'error' => $e->getMessage(),
            ]);

            // エラー時はロックを強制解放
            $lockManager->forceReleaseLock($this->spot, 'detail');

            // 失敗カウンターをインクリメント
            $this->spot->increment('detail_analysis_failure_count');

            // 閾値に達したら「分析失敗」として完了扱いにする
            $maxFailureCount = config('ai.task_selection.spot_detail_max_failure_count', 5);
            $this->spot->refresh(); // 最新の failure_count を取得

            if ($this->spot->detail_analysis_failure_count >= $maxFailureCount) {
                $this->spot->update([
                    'spot_role' => 'analysis_failed',
                    'detail_analyzed_by_model_id' => $this->model->id, // 失敗として記録
                ]);

                // クラスターのカウントをインクリメント（失敗としてカウント）
                $cluster = $this->spot->cluster;
                if ($cluster) {
                    $cluster->increment('analyzed_spots_count');
                }

                Log::warning('[AnalyzeSpotDetailJob] Spot marked as failed after max retries', [
                    'spot_id' => $this->spot->id,
                    'spot_name' => $this->spot->name,
                    'failure_count' => $this->spot->detail_analysis_failure_count,
                    'max_failure_count' => $maxFailureCount,
                ]);

                // 閾値に達したのでこれ以上リトライしない
                return;
            }

            throw $e;
        }
    }

    /**
     * スポットの詳細情報を取得
     *
     * @return array<string, mixed> 詳細情報の配列
     */
    private function fetchSpotDetails(
        Spot $spot,
        PromptLoaderService $promptLoader,
        GeminiClientService $geminiClient
    ): array {
        // プロンプトを読み込み
        $prompt = $promptLoader->load('spot_detail_analysis.txt', [
            'spot_name' => $spot->name,
            'municipality' => $spot->municipality ?? '',
            'prefecture' => $spot->prefecture ?? '',
        ]);

        // Gemini APIで詳細情報を取得
        $response = $geminiClient->generateContent(
            $prompt,
            model: $this->model->model_name
        );

        // JSONレスポンスをパース
        $data = $geminiClient->parseJsonResponse($response);

        // 必須フィールドのバリデーション
        $requiredFields = ['latitude', 'longitude', 'min_duration_minutes', 'max_duration_minutes', 'spot_role'];
        foreach ($requiredFields as $field) {
            if (! isset($data[$field])) {
                throw new Exception("Missing required field: {$field}");
            }
        }

        // AI生成スポットのため、coordinate_reliabilityは常にai_analysis
        $data['coordinate_reliability'] = CoordinateReliability::AiAnalysis->value;

        return $data;
    }

    /**
     * 座標を検証（クラスターから50km以上離れていないか）
     */
    private function validateCoordinates(Cluster $cluster, float $latitude, float $longitude): bool
    {
        if (! $cluster->location) {
            // クラスターに座標が設定されていない場合は検証スキップ
            return true;
        }

        // PostGISで距離を計算
        $result = DB::selectOne('
            SELECT ST_Distance(
                ST_MakePoint(?, ?)::geography,
                ?::geography
            ) as distance
        ', [$longitude, $latitude, $cluster->location]);

        $distance = $result->distance ?? 0.0;

        return $distance <= self::MAX_DISTANCE_FROM_CLUSTER_METERS;
    }

    /**
     * 座標の再取得をリトライ
     *
     * @return array<string, mixed> 詳細情報の配列
     */
    private function retryCoordinateFetch(
        Spot $spot,
        PromptLoaderService $promptLoader,
        GeminiClientService $geminiClient,
        Cluster $cluster
    ): array {
        // リトライ用プロンプトを読み込み
        $prompt = $promptLoader->load('spot_coordinate_retry.txt', [
            'spot_name' => $spot->name,
            'municipality' => $spot->municipality ?? '',
            'prefecture' => $spot->prefecture ?? '',
        ]);

        // Gemini APIで座標を再取得
        $response = $geminiClient->generateContent(
            $prompt,
            model: $this->model->model_name
        );

        // JSONレスポンスをパース
        $data = $geminiClient->parseJsonResponse($response);

        // エラーチェック
        if (isset($data['error'])) {
            throw new Exception("Spot not found after retry: {$data['error']}");
        }

        // 詳細情報を再取得（latitude, longitudeのみ更新）
        $originalDetails = $this->fetchSpotDetails($spot, $promptLoader, $geminiClient);
        $originalDetails['latitude'] = $data['latitude'];
        $originalDetails['longitude'] = $data['longitude'];

        // 再度検証
        if (! $this->validateCoordinates($cluster, $data['latitude'], $data['longitude'])) {
            throw new Exception('Coordinates still invalid after retry');
        }

        return $originalDetails;
    }

    /**
     * スポット情報を詳細データで更新
     *
     * @param  array<string, mixed>  $details  詳細情報
     */
    private function updateSpotWithDetails(Spot $spot, array $details): void
    {
        $spot->update([
            'location' => Point::make($details['longitude'], $details['latitude']),
            'address_detail' => $details['address_detail'] ?? null,
            'min_duration_minutes' => $details['min_duration_minutes'],
            'max_duration_minutes' => $details['max_duration_minutes'],
            'spot_role' => $details['spot_role'], // Now a string, not enum
            'coordinate_reliability' => CoordinateReliability::from($details['coordinate_reliability']),
        ]);
    }
}
