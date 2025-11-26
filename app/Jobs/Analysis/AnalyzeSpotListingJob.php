<?php

namespace App\Jobs\Analysis;

use App\Exceptions\ConcurrentAnalysisException;
use App\Models\AiModel;
use App\Models\Cluster;
use App\Models\Spot;
use App\Services\AI\LockManager;
use App\Services\GeminiClientService;
use App\Services\LocationParserService;
use App\Services\PromptLoaderService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * スポットリストアップ分析ジョブ（Aタイプタスク）
 *
 * クラスターに属するスポットをAIでリストアップし、仮作成する
 */
class AnalyzeSpotListingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** ジョブのタイムアウト時間（秒） */
    public int $timeout = 180;

    /** 最大リトライ回数 */
    public int $tries;

    /** リトライ間隔（秒） */
    public int $backoff;

    public function __construct(
        public Cluster $cluster,
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
        GeminiClientService $geminiClient,
        LocationParserService $locationParser
    ): void {
        $debugLog = config('ai.debug.log_job_execution', false);

        if ($debugLog) {
            Log::info('[AnalyzeSpotListingJob] Starting', [
                'cluster_id' => $this->cluster->id,
                'cluster_name' => $this->cluster->name,
                'model' => $this->model->model_name,
            ]);
        }

        try {
            // ロックを取得
            $lockManager->acquireLock($this->cluster, 'spot_listing', $this->model);

            if ($debugLog) {
                Log::info('[AnalyzeSpotListingJob] Lock acquired', [
                    'cluster_id' => $this->cluster->id,
                ]);
            }

            // プロンプトを読み込み
            $prompt = $promptLoader->load('spot_listing.txt', [
                'cluster_name' => $this->cluster->name,
            ]);

            // Gemini APIでスポット名をリストアップ
            $response = $geminiClient->generateContent(
                $prompt,
                model: $this->model->model_name
            );

            // JSONレスポンスをパース
            $data = $geminiClient->parseJsonResponse($response);

            if (! isset($data['spots']) || ! is_array($data['spots'])) {
                throw new Exception('Invalid response format: missing "spots" array');
            }

            // スポットを仮作成
            $spots = $this->createPreliminarySpots($this->cluster, $data['spots'], $locationParser);

            // ロックを解放（分析完了）
            $lockManager->releaseLock($this->cluster, 'spot_listing', $this->model);

            Log::info('[AnalyzeSpotListingJob] Successfully listed spots', [
                'cluster_id' => $this->cluster->id,
                'cluster_name' => $this->cluster->name,
                'spots_count' => $spots->count(),
                'model' => $this->model->model_name,
            ]);

        } catch (ConcurrentAnalysisException $e) {
            // 並行実行が検出された場合はジョブを終了（リトライしない）
            Log::info('[AnalyzeSpotListingJob] Concurrent execution detected, skipping', [
                'cluster_id' => $this->cluster->id,
                'error' => $e->getMessage(),
            ]);

            return;

        } catch (Exception $e) {
            Log::error('[AnalyzeSpotListingJob] Failed to list spots', [
                'cluster_id' => $this->cluster->id,
                'cluster_name' => $this->cluster->name,
                'error' => $e->getMessage(),
            ]);

            // エラー時はロックを強制解放
            $lockManager->forceReleaseLock($this->cluster, 'spot_listing');

            throw $e;
        }
    }

    /**
     * スポットを仮作成（spot_role='generating' で作成）
     *
     * @param  Cluster  $cluster  対象クラスター
     * @param  array<int, array{name: string}>  $spotNames  スポット名の配列
     * @return Collection<int, Spot> 作成されたスポットのコレクション
     */
    private function createPreliminarySpots(
        Cluster $cluster,
        array $spotNames,
        LocationParserService $locationParser
    ): Collection {
        $spots = collect();

        // クラスター名から都道府県・市区町村を抽出
        $location = $locationParser->parseClusterName($cluster->name);
        $prefecture = $location['prefecture'];
        $municipality = $location['municipality'];

        foreach ($spotNames as $item) {
            if (! isset($item['name']) || empty($item['name'])) {
                continue;
            }

            $spotName = $item['name'];

            // slug生成（ユニーク性を保証するためランダム文字列を追加）
            $slug = Str::slug($spotName).'-'.Str::random(8);

            // 仮スポットを作成
            $spot = Spot::create([
                'name' => $spotName,
                'slug' => $slug,
                'prefecture' => $prefecture,
                'municipality' => $municipality,
                'spot_role' => 'generating', // Now a string instead of enum
                // その他のフィールドはnullのまま（詳細分析で埋める）
            ]);

            // クラスターと紐づけ
            $cluster->spots()->attach($spot->id);

            $spots->push($spot);

            Log::info('[AnalyzeSpotListingJob] Created preliminary spot', [
                'spot_id' => $spot->id,
                'spot_name' => $spot->name,
                'cluster_id' => $cluster->id,
            ]);
        }

        return $spots;
    }
}
