<?php

namespace App\Services;

use App\Models\Cluster;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * 出発地から適切なクラスターを選定するサービス
 *
 * Phase 6: PostGISを活用した本実装
 * - ST_Distanceで距離計算
 * - 50km〜150kmの範囲を優先
 * - 多様性を考慮した選定
 */
class ClusterSelectorService
{
    // 距離の定数（メートル単位）
    private const MIN_DISTANCE_METERS = 50000;  // 50km
    private const MAX_DISTANCE_METERS = 150000; // 150km

    // 多様性確保のための最小距離（メートル単位）
    private const DIVERSITY_MIN_DISTANCE_METERS = 30000; // 30km

    /**
     * 出発地（緯度経度）から適切なクラスターを選定
     *
     * アルゴリズム:
     * 1. 出発地から150km以内のpublishedクラスターを抽出
     * 2. 50km〜150kmの範囲を優先してソート
     * 3. 多様性を考慮して最終的にN件を選定（選定済みクラスターから30km以上離れているものを優先）
     *
     * @param float $latitude 出発地の緯度
     * @param float $longitude 出発地の経度
     * @param int $limit 取得件数（デフォルト3件）
     * @return Collection<int, Cluster>
     */
    public function selectClusters(float $latitude, float $longitude, int $limit = 3): Collection
    {
        // Step 1: 出発地から150km以内のクラスターを距離順で取得
        $candidateClusters = $this->getCandidateClusters($latitude, $longitude);

        // 候補が0件の場合は空のコレクションを返す
        if ($candidateClusters->isEmpty()) {
            return collect();
        }

        // Step 2: 多様性を考慮して最終的なクラスターを選定
        return $this->selectDiverseClusters($candidateClusters, $limit);
    }

    /**
     * 出発地から150km以内の候補クラスターを取得
     *
     * @param float $latitude 出発地の緯度
     * @param float $longitude 出発地の経度
     * @return Collection<int, Cluster>
     */
    private function getCandidateClusters(float $latitude, float $longitude): Collection
    {
        // PostGISを使用して距離計算を行うクエリ
        $clusters = Cluster::select([
            'clusters.*',
            DB::raw("
                ST_Distance(
                    ST_MakePoint(?, ?)::geography,
                    location::geography
                ) as distance_meters
            ")
        ])
        ->where('status', 'published')
        ->whereNotNull('location')
        ->whereRaw("
            ST_DWithin(
                ST_MakePoint(?, ?)::geography,
                location::geography,
                ?
            )
        ", [$longitude, $latitude, self::MAX_DISTANCE_METERS])
        ->setBindings([
            $longitude, $latitude,  // SELECT句のST_MakePoint用
            $longitude, $latitude, self::MAX_DISTANCE_METERS  // WHERE句のST_DWithin用
        ])
        ->get();

        // 50km〜150kmの範囲を優先してソート
        return $clusters->sortBy(function ($cluster) {
            $distance = $cluster->distance_meters;

            // 50km〜150kmの範囲内ならそのまま距離を返す（昇順優先）
            if ($distance >= self::MIN_DISTANCE_METERS && $distance <= self::MAX_DISTANCE_METERS) {
                return $distance;
            }

            // 50km未満の場合はペナルティを付けて後回し
            if ($distance < self::MIN_DISTANCE_METERS) {
                return self::MAX_DISTANCE_METERS + (self::MIN_DISTANCE_METERS - $distance);
            }

            // 150km超の場合は除外（この分岐には到達しないはず）
            return $distance;
        })->values();
    }

    /**
     * 多様性を考慮してクラスターを選定
     *
     * 既に選定されたクラスターから30km以上離れているものを優先的に選択
     *
     * @param Collection<int, Cluster> $candidates 候補クラスター（距離順ソート済み）
     * @param int $limit 選定件数
     * @return Collection<int, Cluster>
     */
    private function selectDiverseClusters(Collection $candidates, int $limit): Collection
    {
        $selected = collect();

        foreach ($candidates as $candidate) {
            // 選定数が上限に達したら終了
            if ($selected->count() >= $limit) {
                break;
            }

            // 最初のクラスターは無条件で選定
            if ($selected->isEmpty()) {
                $selected->push($candidate);
                continue;
            }

            // 既に選定されたクラスターとの距離をチェック
            $isDiverse = $selected->every(function ($selectedCluster) use ($candidate) {
                return $this->calculateDistance($candidate, $selectedCluster) >= self::DIVERSITY_MIN_DISTANCE_METERS;
            });

            // 多様性の条件を満たす場合に選定
            if ($isDiverse) {
                $selected->push($candidate);
            }
        }

        // 多様性条件で選定数が不足した場合、残りは距離順で追加
        if ($selected->count() < $limit) {
            foreach ($candidates as $candidate) {
                if ($selected->count() >= $limit) {
                    break;
                }

                // 既に選定済みでなければ追加
                if (!$selected->contains('id', $candidate->id)) {
                    $selected->push($candidate);
                }
            }
        }

        return $selected;
    }

    /**
     * 2つのクラスター間の距離を計算（メートル単位）
     *
     * @param Cluster $cluster1
     * @param Cluster $cluster2
     * @return float 距離（メートル）
     */
    private function calculateDistance(Cluster $cluster1, Cluster $cluster2): float
    {
        // PostGISのST_Distanceを使用して距離を計算
        $result = DB::selectOne("
            SELECT ST_Distance(
                ?::geography,
                ?::geography
            ) as distance
        ", [
            $cluster1->location,
            $cluster2->location
        ]);

        return $result->distance ?? 0.0;
    }
}
