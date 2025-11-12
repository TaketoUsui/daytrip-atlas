<?php

namespace App\Services;

use App\Enums\SpotRole;
use App\Models\Cluster;
use App\Models\Spot;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * クラスターに紐づくスポットをAIでリストアップするサービス
 */
class SpotListingService
{
    public function __construct(
        private readonly PromptLoaderService $promptLoader,
        private readonly GeminiClientService $geminiClient,
        private readonly LocationParserService $locationParser
    ) {}

    /**
     * クラスターに紐づくスポットをリストアップして仮作成
     *
     * @param  Cluster  $cluster  対象クラスター
     * @return Collection<int, Spot> 作成されたスポットのコレクション
     *
     * @throws Exception API呼び出しまたはデータ作成に失敗した場合
     */
    public function listSpots(Cluster $cluster): Collection
    {
        try {
            // プロンプトを読み込み
            $prompt = $this->promptLoader->load('spot_listing.txt', [
                'cluster_name' => $cluster->name,
            ]);

            // Gemini APIでスポット名をリストアップ
            $response = $this->geminiClient->generateContent(
                $prompt,
                model: 'gemini-2.5-flash'
            );

            // JSONレスポンスをパース
            $data = $this->geminiClient->parseJsonResponse($response);

            if (! isset($data['spots']) || ! is_array($data['spots'])) {
                throw new Exception('Invalid response format: missing "spots" array');
            }

            // スポットを仮作成
            return $this->createPreliminarySpots($cluster, $data['spots']);

        } catch (Exception $e) {
            Log::error('Failed to list spots', [
                'cluster_id' => $cluster->id,
                'cluster_name' => $cluster->name,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * スポットを仮作成（spot_role=Generating で作成）
     *
     * @param  Cluster  $cluster  対象クラスター
     * @param  array<int, array{name: string}>  $spotNames  スポット名の配列
     * @return Collection<int, Spot> 作成されたスポットのコレクション
     */
    private function createPreliminarySpots(Cluster $cluster, array $spotNames): Collection
    {
        $spots = collect();

        // クラスター名から都道府県・市区町村を抽出
        $location = $this->locationParser->parseClusterName($cluster->name);
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
                'spot_role' => SpotRole::Generating,
                // その他のフィールドはnullのまま（詳細分析で埋める）
            ]);

            // クラスターと紐づけ
            $cluster->spots()->attach($spot->id);

            $spots->push($spot);

            Log::info('Created preliminary spot', [
                'spot_id' => $spot->id,
                'spot_name' => $spot->name,
                'cluster_id' => $cluster->id,
            ]);
        }

        return $spots;
    }
}
