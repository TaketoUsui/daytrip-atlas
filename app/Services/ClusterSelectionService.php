<?php

namespace App\Services;

use App\Enums\ClusterStatus;
use App\Models\Cluster;
use App\Models\SuggestionSet;
use App\Models\Tag;
use Clickbar\Magellan\Data\Geometries\Point;
use Clickbar\Magellan\Database\PostgisFunctions\ST;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * 提案対象クラスターの選定（ドメインサービス）
 *
 * @see MVP_旅先提案アルゴリズム設計 B. ドメインサービス
 */
class ClusterSelectionService
{
    /**
     * @var int 検索範囲（メートル単位）。150km。
     *
     */
    private const SEARCH_RADIUS_METERS = 150_000;

    /**
     * @var int MVPで提案する最大件数
     *
     */
    private const TARGET_SUGGESTION_COUNT = 5;

    public function __construct()
    {
        // (DIが必要な場合はここに追加)
    }

    /**
     * SuggestionSetに基づき、提案するクラスターを選定する
     *
     * @param SuggestionSet $suggestionSet ユーザーの入力情報
     * @return Collection<int, Cluster> 選定されたClusterモデルのコレクション
     */
    public function selectClusters(SuggestionSet $suggestionSet): Collection
    {
        Log::info("[ClusterSelection] Starting cluster selection.", [
            'suggestion_set_id' => $suggestionSet->id,
            'lat' => $suggestionSet->input_latitude,
            'lon' => $suggestionSet->input_longitude,
        ]);

        // 1. 出発地のPointオブジェクトを作成
        $originPoint = Point::makeGeodetic(
            latitude: $suggestionSet->input_latitude,
            longitude: $suggestionSet->input_longitude
        );

        // 2. PostGIS空間クエリの実行
        //
        $tagIds = $suggestionSet->input_tags_json ?? [];
        // ベースとなるクエリ（公開中のみ）を作成 [!code ++]
        $query = Cluster::query() // [!code ++]
        ->where('status', ClusterStatus::Published);

//        $clusters = Cluster::query()
//            // 公開中のクラスターのみを対象
//            ->where('status', ClusterStatus::Published)
//            // PostGIS (laravel-magellan) の 'stDWithin' 関数を使用
//            // 'location' カラム (Geography) が
//            // $originPoint から $SEARCH_RADIUS_METERS (メートル) 以内にあるか
////            ->where(ST::dWithinGeography(
////                'location',      // 検索対象の (Geography) カラム
////                $originPoint,      // 比較元の Point オブジェクト
////                self::SEARCH_RADIUS_METERS // 距離 (メートル)
////            ))
//            // MVPの要件: ランダム性を加えて選定
//            ->inRandomOrder()
//            ->limit(self::TARGET_SUGGESTION_COUNT)
//            ->get();


//        $tagIds = $suggestionSet->input_tags_json ?? [];
//
//
//        $query = Cluster::query()
//        ->where('status', ClusterStatus::Published)
//
//        ->where(ST::dWithinGeography(
//            'location',
//            $originPoint,
//            self::SEARCH_RADIUS_METERS
//        ));

        if (empty($tagIds)) { // [!code ++]
            // タグが未選択の場合 (従来のMVPロジック: ランダム選定) [!code ++]
            Log::info("[ClusterSelection] No tags provided. Selecting randomly.", ['suggestion_set_id' => $suggestionSet->id]); // [!code ++]
            $clusters = $query->inRandomOrder() // [!code ++]
            ->limit(self::TARGET_SUGGESTION_COUNT) // [!code ++]
            ->get(); // [!code ++]
        } else { // [!code ++]
            // タグが選択された場合 (デモ用ロジック: 関連度順) [!code ++]
            $tagNames = Tag::whereIn('id', $tagIds)->pluck('name')->implode(', '); // [!code ++]
            Log::info("[ClusterSelection] Selecting clusters based on tags: [{$tagNames}] (distance ignored for demo)", ['suggestion_set_id' => $suggestionSet->id]); // [!code ++]

            $clusters = $query // [!code ++]
            // 関連するタグを持つスポットの数をカウントする [!code ++]
            ->withCount(['spots' => function (Builder $spotQuery) use ($tagIds) { // [!code ++]
                // spotsリレーション経由で、さらにtagsリレーションを絞り込む [!code ++]
                $spotQuery->whereHas('tags', function (Builder $tagQuery) use ($tagIds) { // [!code ++]
                    $tagQuery->whereIn('tags.id', $tagIds); // [!code ++]
                }); // [!code ++]
            }]) // [!code ++]
            ->orderByDesc('spots_count') // カウント数で降順ソート [!code ++]
            ->limit(self::TARGET_SUGGESTION_COUNT) // [!code ++]
            ->get(); // [!code ++]
        } // [!code ++]

        Log::info(
            "[ClusterSelection] Found {$clusters->count()} clusters.",
            ['suggestion_set_id' => $suggestionSet->id]
        );

        /*
         * [MVP要件の確認]
         * アルゴリズム設計書 には
         * 「本来はタグで絞り込むが、MVPでは近接しているClusterの中からランダム性も加えて選定する」
         * と記載されているため、ここでは $suggestionSet->input_tags_json を
         * *あえて使用しない* のがMVPの正しい実装となる。
         * タグは、この後の ModelPlanGenerationService や CatchphraseGenerationService で
         * コンテンツをパーソナライズするために使用される。
         */

        return $clusters;
    }
}
