<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 大阪府のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class OsakaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array(
            0 =>
                array(
                    'admin_code' => '27301',
                    'name' => '大阪府島本町',
                    'lat' => 34.883819,
                    'lon' => 135.663009,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            1 =>
                array(
                    'admin_code' => '27321',
                    'name' => '大阪府豊能町',
                    'lat' => 34.91885,
                    'lon' => 135.494096,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            2 =>
                array(
                    'admin_code' => '27322',
                    'name' => '大阪府能勢町',
                    'lat' => 34.972445,
                    'lon' => 135.414189,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            3 =>
                array(
                    'admin_code' => '27341',
                    'name' => '大阪府忠岡町',
                    'lat' => 34.487125,
                    'lon' => 135.401497,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            4 =>
                array(
                    'admin_code' => '27361',
                    'name' => '大阪府熊取町',
                    'lat' => 34.401308,
                    'lon' => 135.355863,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            5 =>
                array(
                    'admin_code' => '27362',
                    'name' => '大阪府田尻町',
                    'lat' => 34.393782,
                    'lon' => 135.291176,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            6 =>
                array(
                    'admin_code' => '27366',
                    'name' => '大阪府岬町',
                    'lat' => 34.3169,
                    'lon' => 135.142085,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            7 =>
                array(
                    'admin_code' => '27381',
                    'name' => '大阪府太子町',
                    'lat' => 34.518656,
                    'lon' => 135.647734,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            8 =>
                array(
                    'admin_code' => '27382',
                    'name' => '大阪府河南町',
                    'lat' => 34.491637,
                    'lon' => 135.62988,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            9 =>
                array(
                    'admin_code' => '27383',
                    'name' => '大阪府千早赤阪村',
                    'lat' => 34.464601,
                    'lon' => 135.622531,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            10 =>
                array(
                    'admin_code' => '27100',
                    'name' => '大阪府大阪市',
                    'lat' => 34.693891,
                    'lon' => 135.502046,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            11 =>
                array(
                    'admin_code' => '27140',
                    'name' => '大阪府堺市',
                    'lat' => 34.573354,
                    'lon' => 135.48302,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
        );

        $now = Carbon::now();

        foreach ($clusters as $cluster) {
            DB::table('clusters')->insert([
                'uuid' => Str::uuid()->toString(),
                'name' => $cluster['name'],
                'location' => DB::raw("ST_GeogFromText('POINT({$cluster['lon']} {$cluster['lat']})')"),
                'status' => 'published',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
