<?php

namespace Database\Seeders;

use App\Enums\TravelMode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * モデルプランにスポットを紐付ける
 */
class ModelPlanItemSeeder extends Seeder
{
    public function run(): void
    {
        // 開発環境での再実行を考慮し、既存データをクリア
        DB::table('model_plan_items')->truncate();

        // プラン情報を取得（クラスター名経由）
        $plans = DB::table('model_plans')
            ->join('clusters', 'model_plans.cluster_id', '=', 'clusters.id')
            ->select('model_plans.id as plan_id', 'clusters.name as cluster_name')
            ->get()
            ->keyBy('cluster_name');

        // スポット情報を取得
        $spots = DB::table('spots')->select('id', 'slug')->get()->keyBy('slug');

        /**
         * 各プランのアイテムデータ
         * display_order: 訪問順序
         * duration_minutes: そのスポットでの滞在時間
         * travel_time_to_next_minutes: 次のスポットまでの移動時間（最後のスポットは0）
         * travel_mode: 移動手段
         */
        $planItems = [
            // 神戸港と有馬温泉満喫プラン
            '兵庫県神戸市' => [
                [
                    'spot_slug' => 'kobe-harborland',
                    'display_order' => 1,
                    'duration_minutes' => 90,
                    'travel_time_to_next_minutes' => 15,
                    'travel_mode' => TravelMode::Walk->value,
                    'description' => 'ハーバーランドでショッピングと景色を楽しむ',
                ],
                [
                    'spot_slug' => 'nankinmachi',
                    'display_order' => 2,
                    'duration_minutes' => 60,
                    'travel_time_to_next_minutes' => 45,
                    'travel_mode' => TravelMode::Train->value,
                    'description' => '南京町で中華グルメを満喫',
                ],
                [
                    'spot_slug' => 'arima-onsen',
                    'display_order' => 3,
                    'duration_minutes' => 180,
                    'travel_time_to_next_minutes' => 0,
                    'travel_mode' => null,
                    'description' => '有馬温泉で日帰り入浴と温泉街散策',
                ],
            ],

            // 大阪城と道頓堀グルメ旅
            '大阪府大阪市' => [
                [
                    'spot_slug' => 'osaka-castle',
                    'display_order' => 1,
                    'duration_minutes' => 120,
                    'travel_time_to_next_minutes' => 30,
                    'travel_mode' => TravelMode::Train->value,
                    'description' => '大阪城を散策し、歴史を感じる',
                ],
                [
                    'spot_slug' => 'dotonbori',
                    'display_order' => 2,
                    'duration_minutes' => 90,
                    'travel_time_to_next_minutes' => 0,
                    'travel_mode' => null,
                    'description' => '道頓堀でたこ焼きやお好み焼きを堪能',
                ],
            ],

            // 京都東山・嵐山周遊プラン
            '京都府京都市' => [
                [
                    'spot_slug' => 'kiyomizu-dera',
                    'display_order' => 1,
                    'duration_minutes' => 120,
                    'travel_time_to_next_minutes' => 60,
                    'travel_mode' => TravelMode::Bus->value,
                    'description' => '清水寺から京都市街を一望',
                ],
                [
                    'spot_slug' => 'togetsukyo',
                    'display_order' => 2,
                    'duration_minutes' => 45,
                    'travel_time_to_next_minutes' => 10,
                    'travel_mode' => TravelMode::Walk->value,
                    'description' => '渡月橋で桂川の景色を楽しむ',
                ],
                [
                    'spot_slug' => 'arashiyama',
                    'display_order' => 3,
                    'duration_minutes' => 120,
                    'travel_time_to_next_minutes' => 0,
                    'travel_mode' => null,
                    'description' => '嵐山の竹林散策とカフェタイム',
                ],
            ],

            // 奈良公園と古都散策
            '奈良県奈良市' => [
                [
                    'spot_slug' => 'nara-park',
                    'display_order' => 1,
                    'duration_minutes' => 90,
                    'travel_time_to_next_minutes' => 10,
                    'travel_mode' => TravelMode::Walk->value,
                    'description' => '奈良公園で鹿と触れ合う',
                ],
                [
                    'spot_slug' => 'todai-ji',
                    'display_order' => 2,
                    'duration_minutes' => 90,
                    'travel_time_to_next_minutes' => 0,
                    'travel_mode' => null,
                    'description' => '東大寺の大仏を拝観',
                ],
            ],

            // 世界遺産姫路城じっくり観光
            '兵庫県姫路市' => [
                [
                    'spot_slug' => 'himeji-castle',
                    'display_order' => 1,
                    'duration_minutes' => 150,
                    'travel_time_to_next_minutes' => 0,
                    'travel_mode' => null,
                    'description' => '姫路城の天守閣まで登り、白鷺城の美しさを堪能',
                ],
            ],

            // 宇治抹茶と平等院
            '京都府宇治市' => [
                [
                    'spot_slug' => 'byodoin',
                    'display_order' => 1,
                    'duration_minutes' => 90,
                    'travel_time_to_next_minutes' => 10,
                    'travel_mode' => TravelMode::Walk->value,
                    'description' => '平等院鳳凰堂を鑑賞',
                ],
                [
                    'spot_slug' => 'uji-river',
                    'display_order' => 2,
                    'duration_minutes' => 60,
                    'travel_time_to_next_minutes' => 0,
                    'travel_mode' => null,
                    'description' => '宇治川沿いのカフェで抹茶スイーツ',
                ],
            ],

            // 和歌山城歴史探訪
            '和歌山県和歌山市' => [
                [
                    'spot_slug' => 'wakayama-castle',
                    'display_order' => 1,
                    'duration_minutes' => 120,
                    'travel_time_to_next_minutes' => 0,
                    'travel_mode' => null,
                    'description' => '和歌山城の天守閣から市街地を眺望',
                ],
            ],

            // 琵琶湖畔リラックス旅
            '滋賀県大津市' => [
                [
                    'spot_slug' => 'biwako',
                    'display_order' => 1,
                    'duration_minutes' => 180,
                    'travel_time_to_next_minutes' => 0,
                    'travel_mode' => null,
                    'description' => '琵琶湖畔でのんびりと散策やカフェタイム',
                ],
            ],
        ];

        foreach ($planItems as $clusterName => $items) {
            $plan = $plans->get($clusterName);
            if (! $plan) {
                continue;
            }

            foreach ($items as $item) {
                $spot = $spots->get($item['spot_slug']);
                if (! $spot) {
                    continue;
                }

                DB::table('model_plan_items')->insert([
                    'model_plan_id' => $plan->plan_id,
                    'display_order' => $item['display_order'],
                    'spot_id' => $spot->id,
                    'duration_minutes' => $item['duration_minutes'],
                    'travel_time_to_next_minutes' => $item['travel_time_to_next_minutes'],
                    'travel_mode' => $item['travel_mode'],
                    'description' => $item['description'],
                ]);
            }
        }
    }
}
