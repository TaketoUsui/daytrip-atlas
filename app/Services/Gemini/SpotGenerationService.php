<?php

namespace App\Services\Gemini;

use App\Enums\CoordinateReliability;
use App\Enums\SpotRole;
use App\Models\Cluster;
use App\Models\Spot;
use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

/**
 * AIによるスポット群の生成とDB保存を担当するサービス。
 *
 * @see MVP_旅先提案アルゴリズム設計 C. インフラストラクチャサービス
 */
class SpotGenerationService extends BaseGeminiClient
{
    /**
     * 特定のクラスター（観光地域）に関連するスポット群をAIで生成し、DBに保存する。
     *
     * @param Cluster $cluster スポットを生成する対象のクラスター
     * @param int $count 生成するスポットの件数 (デフォルト: 5)
     * @return Collection<int, Spot> 生成または更新されたSpotモデルのコレクション
     * @throws Throwable AIのレスポンスが不正、またはDB保存に失敗した場合
     */
    public function generateSpotsForCluster(Cluster $cluster, int $count = 5): Collection
    {
        Log::info(
            "[SpotGeneration] Generating {$count} spots for cluster: {$cluster->name} (ID: {$cluster->id})"
        );

        $prompt = $this->buildPrompt($cluster->name, $count);

        // BaseGeminiClientのメソッドを呼び出し、AIからJSON配列を取得
        $spotsArray = $this->generateContent($prompt);

        if (!is_array($spotsArray) || empty($spotsArray)) {
            Log::warning("[SpotGeneration] AI returned empty or invalid array.", [
                'cluster_id' => $cluster->id,
                'prompt' => $prompt,
            ]);
            // 空のコレクションを返す (後続の処理でプランが作れないかもしれないが、ジョブは続行)
            return new Collection();
        }

        $generatedSpots = new Collection();

        // 取得したスポット情報をDBに保存
        foreach ($spotsArray as $spotData) {
            try {
                $spot = $this->createOrUpdateSpot($spotData, $cluster);
                $generatedSpots->push($spot);
            } catch (Throwable $e) {
                Log::error("[SpotGeneration] Failed to create spot from AI data.", [
                    'cluster_id' => $cluster->id,
                    'spot_data' => $spotData ?? null,
                    'error' => $e->getMessage()
                ]);
                // 1件でも失敗したら即時例外をスローする
                // 呼び出し元のGenerateSuggestionsJobでトランザクションがロールバックされる
                throw $e;
            }
        }

        Log::info(
            "[SpotGeneration] Successfully generated {$generatedSpots->count()} spots for cluster: {$cluster->name}"
        );
        return $generatedSpots;
    }

    /**
     * AIから受け取ったデータに基づき、Spotレコードを作成または更新し、Clusterに紐付ける
     *
     * @param array $data AIが生成した単一スポットのデータ
     * @param Cluster $cluster 紐付け先のクラスター
     * @return Spot
     */
    private function createOrUpdateSpot(array $data, Cluster $cluster): Spot
    {
        // スラッグを生成 (名前 + 4桁のランダム英数字で重複を回避)
        // slugはUnique (UK) 制約
        $slug = Str::slug($data['name']) . '-' . Str::lower(Str::random(4));

        // 緯度経度からPostGISのPointオブジェクトを作成
        // laravel-magellan は (Longitude, Latitude) の順序
        $location = Point::make($data['longitude'], $data['latitude']);

        // DBスキーマ とアルゴリズム設計 に基づきデータをマッピング
        $spot = Spot::updateOrCreate(
            [
                'slug' => $slug, // slugをキーにすることで、ジョブがリトライされても重複作成しない
            ],
            [
                'name' => $data['name'],
                'location' => $location, // GEOGRAPHY型
                'prefecture' => $data['prefecture'] ?? null,
                'municipality' => $data['municipality'] ?? null,
                'address_detail' => $data['address_detail'] ?? null,
                'min_duration_minutes' => $data['duration_minutes'],
                // MVPではmin/maxをAIの指定した同値で設定
                'max_duration_minutes' => $data['duration_minutes'],
                // spots.spot_role ENUM
                'spot_role' => $this->parseSpotRole($data['spot_role']),
                // 座標信頼性を 'llm_estimated' に設定
                'coordinate_reliability' => CoordinateReliability::LlmEstimated,
            ]
        );

        // 中間テーブル (cluster_spot) に紐付け
        $spot->clusters()->syncWithoutDetaching($cluster->id);

        return $spot;
    }

    /**
     * AIへの指示（プロンプト）を構築する
     *
     * @param string $clusterName
     * @param int $count
     * @return string
     */
    private function buildPrompt(string $clusterName, int $count): string
    {
        // DB設計のspotsテーブル定義 に基づき、必要なカラムを厳密に指定する
        return <<<PROMPT
        「{$clusterName}」の主要な観光スポットを{$count}件、JSON配列形式で生成してください。

        各スポットは以下のキーを持つオブジェクトとしてください。
        - "name": スポットの正式名称 (例: "鶴岡八幡宮")
        - "latitude": 緯度 (float, 例: 35.3250)
        - "longitude": 経度 (float, 例: 139.5562)
        - "prefecture": 都道府県 (例: "神奈川県")
        - "municipality": 市区町村 (例: "鎌倉市")
        - "address_detail": それ以下の詳細住所 (例: "雪ノ下2-1-31")
        - "duration_minutes": 推奨滞在時間（分） (int, 例: 60)
        - "spot_role": そのスポットの役割。'main_destination' (主要目的地) または 'sub_destination' (ついでに寄る場所) のいずれか。 (string)

        JSON配列のみを返し、前後に説明文や ```json タグは不要です。
        PROMPT;
    }

    /**
     * AIが返しうるspot_roleの文字列を、安全にEnum Caseに変換する
     *
     * @param string $roleString
     * @return SpotRole
     */
    private function parseSpotRole(string $roleString): SpotRole
    {
        return match (strtolower(trim($roleString))) {
            'main_destination' => SpotRole::MainDestination,
            'sub_destination' => SpotRole::SubDestination,
            // AIが 'connector_spot' を返した場合にも対応
            'connector_spot' => SpotRole::ConnectorSpot,
            // 不明な値が来た場合は、デフォルトで SubDestination にフォールバックする
            default => SpotRole::SubDestination,
        };
    }
}
