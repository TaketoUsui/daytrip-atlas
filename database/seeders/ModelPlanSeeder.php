<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * 各クラスターにデフォルトのモデルプランを作成
 */
class ModelPlanSeeder extends Seeder
{
    public function run(): void
    {
        // 開発環境での再実行を考慮し、既存データをクリア
        DB::table('model_plans')->truncate();

        $now = Carbon::now();

        // クラスター情報を取得
        $clusters = DB::table('clusters')->select('id', 'name')->get()->keyBy('name');

        /**
         * 各クラスターのデフォルトプランデータ
         */
        $modelPlans = [
            [
                'cluster_name' => '兵庫県神戸市',
                'name' => '神戸港と有馬温泉満喫プラン',
                'description' => '神戸の港町と日本三古湯を楽しむ充実コース',
                'total_duration_minutes' => 390,
                'is_default' => true,
            ],
            [
                'cluster_name' => '大阪府大阪市',
                'name' => '大阪城と道頓堀グルメ旅',
                'description' => '歴史と食を楽しむ大阪の王道コース',
                'total_duration_minutes' => 240,
                'is_default' => true,
            ],
            [
                'cluster_name' => '京都府京都市',
                'name' => '京都東山・嵐山周遊プラン',
                'description' => '京都の代表的な観光地を巡る充実コース',
                'total_duration_minutes' => 355,
                'is_default' => true,
            ],
            [
                'cluster_name' => '奈良県奈良市',
                'name' => '奈良公園と古都散策',
                'description' => '鹿と戯れ、歴史ある寺社を訪ねる',
                'total_duration_minutes' => 190,
                'is_default' => true,
            ],
            [
                'cluster_name' => '兵庫県姫路市',
                'name' => '世界遺産姫路城じっくり観光',
                'description' => '白鷺城をゆっくり堪能するプラン',
                'total_duration_minutes' => 150,
                'is_default' => true,
            ],
            [
                'cluster_name' => '京都府宇治市',
                'name' => '宇治抹茶と平等院',
                'description' => '宇治の文化と抹茶スイーツを楽しむ',
                'total_duration_minutes' => 160,
                'is_default' => true,
            ],
            [
                'cluster_name' => '和歌山県和歌山市',
                'name' => '和歌山城歴史探訪',
                'description' => '和歌山城を中心とした歴史散策',
                'total_duration_minutes' => 120,
                'is_default' => true,
            ],
            [
                'cluster_name' => '滋賀県大津市',
                'name' => '琵琶湖畔リラックス旅',
                'description' => '日本最大の湖でゆったり過ごす',
                'total_duration_minutes' => 180,
                'is_default' => true,
            ],
        ];

        foreach ($modelPlans as $plan) {
            $cluster = $clusters->get($plan['cluster_name']);
            if ($cluster) {
                DB::table('model_plans')->insert([
                    'cluster_id' => $cluster->id,
                    'name' => $plan['name'],
                    'description' => $plan['description'],
                    'total_duration_minutes' => $plan['total_duration_minutes'],
                    'is_default' => $plan['is_default'],
                    'created_at' => $now,
                ]);
            }
        }
    }
}
