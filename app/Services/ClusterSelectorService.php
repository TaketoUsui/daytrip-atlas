<?php

namespace App\Services;

use App\Models\Cluster;
use Illuminate\Support\Collection;

/**
 * 出発地から適切なクラスターを選定するサービス
 *
 * Phase 2: ダミー実装（固定で最初の3件のクラスターを返す）
 * Phase 6: PostGISを活用した本実装に置き換え予定
 */
class ClusterSelectorService
{
    /**
     * 出発地（緯度経度）から適切なクラスターを選定
     *
     * @param float $latitude 出発地の緯度
     * @param float $longitude 出発地の経度
     * @param int $limit 取得件数（デフォルト3件）
     * @return Collection<int, Cluster>
     */
    public function selectClusters(float $latitude, float $longitude, int $limit = 3): Collection
    {
        // Phase 2: ダミー実装
        // 実際の出発地に関わらず、statusがpublishedの最初の3件を返す
        return Cluster::where('status', 'published')
            ->limit($limit)
            ->get();

        // Phase 6で以下のような実装に置き換え予定:
        // - PostGIS ST_Distance を使用して出発地からの距離を計算
        // - 適切な範囲内（例: 100km以内）のクラスターを抽出
        // - 距離順にソートして上位N件を返す
    }
}
