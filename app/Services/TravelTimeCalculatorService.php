<?php

namespace App\Services;

use App\Models\Cluster;
use Illuminate\Support\Facades\DB;

/**
 * 出発地からクラスターまでの移動時間を計算するサービス
 *
 * Phase 6: PostGISを使用した距離ベース推定アルゴリズム
 * - ST_Distanceで正確な距離計算
 * - 道路状況を考慮した補正係数適用
 * - 現実的な平均時速で移動時間を推定
 */
class TravelTimeCalculatorService
{
    // 平均時速（km/h）: 高速道路と一般道の混在を想定
    private const AVERAGE_SPEED_KMH = 60;

    // 道路距離補正係数: 直線距離×1.3が実際の走行距離に近い
    private const ROAD_DISTANCE_MULTIPLIER = 1.3;

    // 出発準備時間（分）
    private const PREPARATION_TIME_MINUTES = 15;

    /**
     * 出発地からクラスターまでの移動時間（分）を計算
     *
     * アルゴリズム:
     * 1. PostGIS ST_Distanceで直線距離を計算
     * 2. 道路距離補正係数（1.3倍）を適用
     * 3. 平均時速60km/hで移動時間を計算
     * 4. 出発準備時間（15分）を加算
     *
     * @param  float  $fromLatitude  出発地の緯度
     * @param  float  $fromLongitude  出発地の経度
     * @param  Cluster  $cluster  目的地クラスター
     * @return int 移動時間（分）
     */
    public function calculateTravelTime(float $fromLatitude, float $fromLongitude, Cluster $cluster): int
    {
        // クラスターの座標を取得
        $clusterLocation = $cluster->location;

        if (! $clusterLocation) {
            // 座標情報がない場合はデフォルト値を返す
            return 60;
        }

        // PostGISを使用して直線距離を計算（メートル単位）
        $distanceMeters = $this->calculateDistanceWithPostGIS(
            $fromLatitude,
            $fromLongitude,
            $clusterLocation
        );

        // メートルをキロメートルに変換
        $straightDistanceKm = $distanceMeters / 1000;

        // 道路距離を推定（直線距離×1.3）
        $roadDistanceKm = $straightDistanceKm * self::ROAD_DISTANCE_MULTIPLIER;

        // 移動時間を計算（時速60km）
        $drivingTimeMinutes = ($roadDistanceKm / self::AVERAGE_SPEED_KMH) * 60;

        // 出発準備時間を加算
        $totalTimeMinutes = $drivingTimeMinutes + self::PREPARATION_TIME_MINUTES;

        // 整数に丸める
        $travelTimeMinutes = (int) round($totalTimeMinutes);

        // 最小20分、最大240分（4時間）で制限
        return min(max($travelTimeMinutes, 20), 240);
    }

    /**
     * PostGISを使用して2地点間の距離を計算（メートル単位）
     *
     * @param  float  $fromLatitude  出発地の緯度
     * @param  float  $fromLongitude  出発地の経度
     * @param  mixed  $toLocation  目的地のlocation（Point型）
     * @return float 距離（メートル）
     */
    private function calculateDistanceWithPostGIS(float $fromLatitude, float $fromLongitude, $toLocation): float
    {
        $result = DB::selectOne('
            SELECT ST_Distance(
                ST_MakePoint(?, ?)::geography,
                ?::geography
            ) as distance
        ', [
            $fromLongitude,
            $fromLatitude,
            $toLocation,
        ]);

        return $result->distance ?? 0.0;
    }

    /**
     * 出発地からクラスターまでの移動時間を人間が読みやすいテキストに変換
     *
     * @param  int  $travelTimeMinutes  移動時間（分）
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
     * @param  float  $lat1  地点1の緯度
     * @param  float  $lon1  地点1の経度
     * @param  float  $lat2  地点2の緯度
     * @param  float  $lon2  地点2の経度
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
