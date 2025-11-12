<?php

namespace App\Services;

use App\Enums\CoordinateReliability;
use App\Enums\SpotRole;
use App\Models\Cluster;
use App\Models\Spot;
use Clickbar\Magellan\Data\Geometries\Point;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * スポットの詳細情報をAIで分析するサービス
 */
class SpotDetailAnalyzerService
{
    // 座標検証の最大距離（メートル）
    private const MAX_DISTANCE_FROM_CLUSTER_METERS = 50000; // 50km

    public function __construct(
        private readonly PromptLoaderService $promptLoader,
        private readonly GeminiClientService $geminiClient
    ) {}

    /**
     * スポットの詳細情報を分析して更新
     *
     * @param  Spot  $spot  対象スポット
     * @param  Cluster  $cluster  紐づくクラスター
     * @return bool 成功した場合true
     *
     * @throws Exception 分析に失敗した場合
     */
    public function analyzeSpot(Spot $spot, Cluster $cluster): bool
    {
        try {
            // 詳細情報を取得
            $details = $this->fetchSpotDetails($spot);

            // 座標を検証
            if (! $this->validateCoordinates($spot, $cluster, $details['latitude'], $details['longitude'])) {
                // 座標が不正確な場合はリトライ
                Log::warning('Coordinates are too far from cluster, retrying...', [
                    'spot_id' => $spot->id,
                    'spot_name' => $spot->name,
                    'cluster_id' => $cluster->id,
                ]);

                $details = $this->retryCoordinateFetch($spot, $cluster);
            }

            // スポット情報を更新
            $this->updateSpotWithDetails($spot, $details);

            Log::info('Successfully analyzed spot', [
                'spot_id' => $spot->id,
                'spot_name' => $spot->name,
            ]);

            return true;

        } catch (Exception $e) {
            Log::error('Failed to analyze spot', [
                'spot_id' => $spot->id,
                'spot_name' => $spot->name,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * スポットの詳細情報を取得
     *
     * @param  Spot  $spot  対象スポット
     * @return array<string, mixed> 詳細情報の配列
     *
     * @throws Exception API呼び出しに失敗した場合
     */
    private function fetchSpotDetails(Spot $spot): array
    {
        // プロンプトを読み込み
        $prompt = $this->promptLoader->load('spot_detail_analysis.txt', [
            'spot_name' => $spot->name,
            'municipality' => $spot->municipality ?? '',
            'prefecture' => $spot->prefecture ?? '',
        ]);

        // Gemini APIで詳細情報を取得
        $response = $this->geminiClient->generateContent(
            $prompt,
            model: 'gemini-2.5-flash-lite'
        );

        // JSONレスポンスをパース
        $data = $this->geminiClient->parseJsonResponse($response);

        // 必須フィールドのバリデーション
        $requiredFields = ['latitude', 'longitude', 'min_duration_minutes', 'max_duration_minutes', 'spot_role'];
        foreach ($requiredFields as $field) {
            if (! isset($data[$field])) {
                throw new Exception("Missing required field: {$field}");
            }
        }

        // AI生成スポットのため、coordinate_reliabilityは常にllm_estimated
        $data['coordinate_reliability'] = CoordinateReliability::LlmEstimated->value;

        return $data;
    }

    /**
     * 座標を検証（クラスターから50km以上離れていないか）
     *
     * @param  Spot  $spot  対象スポット
     * @param  Cluster  $cluster  紐づくクラスター
     * @param  float  $latitude  緯度
     * @param  float  $longitude  経度
     * @return bool 検証に合格した場合true
     */
    private function validateCoordinates(Spot $spot, Cluster $cluster, float $latitude, float $longitude): bool
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
     * @param  Spot  $spot  対象スポット
     * @param  Cluster  $cluster  紐づくクラスター
     * @return array<string, mixed> 詳細情報の配列
     *
     * @throws Exception リトライに失敗した場合
     */
    private function retryCoordinateFetch(Spot $spot, Cluster $cluster): array
    {
        // リトライ用プロンプトを読み込み
        $prompt = $this->promptLoader->load('spot_coordinate_retry.txt', [
            'spot_name' => $spot->name,
            'municipality' => $spot->municipality ?? '',
            'prefecture' => $spot->prefecture ?? '',
        ]);

        // Gemini APIで座標を再取得
        $response = $this->geminiClient->generateContent(
            $prompt,
            model: 'gemini-2.5-flash-lite'
        );

        // JSONレスポンスをパース
        $data = $this->geminiClient->parseJsonResponse($response);

        // エラーチェック
        if (isset($data['error'])) {
            throw new Exception("Spot not found after retry: {$data['error']}");
        }

        // 詳細情報を再取得（latitude, longitudeのみ更新）
        $originalDetails = $this->fetchSpotDetails($spot);
        $originalDetails['latitude'] = $data['latitude'];
        $originalDetails['longitude'] = $data['longitude'];
        // coordinate_reliabilityは既にfetchSpotDetailsで設定済み

        // 再度検証
        if (! $this->validateCoordinates($spot, $cluster, $data['latitude'], $data['longitude'])) {
            throw new Exception('Coordinates still invalid after retry');
        }

        return $originalDetails;
    }

    /**
     * スポット情報を詳細データで更新
     *
     * @param  Spot  $spot  対象スポット
     * @param  array<string, mixed>  $details  詳細情報
     */
    private function updateSpotWithDetails(Spot $spot, array $details): void
    {
        $spot->update([
            'location' => Point::make($details['latitude'], $details['longitude']),
            'address_detail' => $details['address_detail'] ?? null,
            'min_duration_minutes' => $details['min_duration_minutes'],
            'max_duration_minutes' => $details['max_duration_minutes'],
            'spot_role' => SpotRole::from($details['spot_role']),
            'coordinate_reliability' => CoordinateReliability::from($details['coordinate_reliability']),
        ]);
    }
}
