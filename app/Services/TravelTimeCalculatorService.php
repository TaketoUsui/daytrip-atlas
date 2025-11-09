<?php

namespace App\Services;

use App\Models\Cluster;

/**
 * 出発地からクラスターまでの移動時間を計算するサービス
 */
class TravelTimeCalculatorService
{
    /**
     * 出発地からクラスターまでの移動時間（分）を計算
     *
     * Phase 2: 簡易計算（直線距離ベース）
     * Phase 6: より精緻な計算に改善予定（Google Distance Matrix API検討）
     *
     * @param float $fromLatitude 出発地の緯度
     * @param float $fromLongitude 出発地の経度
     * @param Cluster $cluster 目的地クラスター
     * @return int 移動時間（分）
     */
    public function calculateTravelTime(float $fromLatitude, float $fromLongitude, Cluster $cluster): int
    {
        // クラスターの座標を取得
        $clusterLocation = $cluster->location;

        if (!$clusterLocation) {
            // 座標情報がない場合はデフォルト値を返す
            return 60;
        }

        // 直線距離を計算（ハバーサイン公式）
        $distanceKm = $this->calculateHaversineDistance(
            $fromLatitude,
            $fromLongitude,
            $clusterLocation->getLatitude(),
            $clusterLocation->getLongitude()
        );

        // 距離を移動時間に変換（時速40kmと仮定）
        $travelTimeMinutes = (int)round(($distanceKm / 40) * 60);

        // 最小15分、最大180分で制限
        return min(max($travelTimeMinutes, 15), 180);
    }

    /**
     * 出発地からクラスターまでの移動時間を人間が読みやすいテキストに変換
     *
     * @param int $travelTimeMinutes 移動時間（分）
     * @return string 移動時間テキスト（例: "車で約1時間30分"）
     */
    public function formatTravelTimeText(int $travelTimeMinutes): string
    {
        $hours = intdiv($travelTimeMinutes, 60);
        $minutes = $travelTimeMinutes % 60;

        if ($hours > 0 && $minutes > 0) {
            return "車で約{$hours}時間{$minutes}分";
        } elseif ($hours > 0) {
            return "車で約{$hours}時間";
        } else {
            return "車で約{$minutes}分";
        }
    }

    /**
     * ハバーサイン公式を使用して2地点間の直線距離（km）を計算
     *
     * @param float $lat1 地点1の緯度
     * @param float $lon1 地点1の経度
     * @param float $lat2 地点2の緯度
     * @param float $lon2 地点2の経度
     * @return float 直線距離（km）
     */
    private function calculateHaversineDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadiusKm = 6371;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadiusKm * $c;
    }
}
