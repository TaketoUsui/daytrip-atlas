<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 島根県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class ShimaneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array (
  0 => 
  array (
    'admin_code' => 32201,
    'name' => '島根県松江市',
    'lat' => 35.468039,
    'lon' => 133.048527,
    'office_count' => 10,
    'main_office_count' => 1,
  ),
  1 => 
  array (
    'admin_code' => 32202,
    'name' => '島根県浜田市',
    'lat' => 34.899255,
    'lon' => 132.079883,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  2 => 
  array (
    'admin_code' => 32203,
    'name' => '島根県出雲市',
    'lat' => 35.366917,
    'lon' => 132.754712,
    'office_count' => 7,
    'main_office_count' => 1,
  ),
  3 => 
  array (
    'admin_code' => 32204,
    'name' => '島根県益田市',
    'lat' => 34.674814,
    'lon' => 131.842862,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  4 => 
  array (
    'admin_code' => 32205,
    'name' => '島根県大田市',
    'lat' => 35.19209,
    'lon' => 132.499351,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  5 => 
  array (
    'admin_code' => 32206,
    'name' => '島根県安来市',
    'lat' => 35.431451,
    'lon' => 133.250851,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  6 => 
  array (
    'admin_code' => 32207,
    'name' => '島根県江津市',
    'lat' => 35.011148,
    'lon' => 132.221206,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  7 => 
  array (
    'admin_code' => 32209,
    'name' => '島根県雲南市',
    'lat' => 35.287787,
    'lon' => 132.900475,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  8 => 
  array (
    'admin_code' => 32343,
    'name' => '島根県奥出雲町',
    'lat' => 35.197428,
    'lon' => 133.002549,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  9 => 
  array (
    'admin_code' => 32386,
    'name' => '島根県飯南町',
    'lat' => 35.00004,
    'lon' => 132.713872,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  10 => 
  array (
    'admin_code' => 32441,
    'name' => '島根県川本町',
    'lat' => 34.994002,
    'lon' => 132.495388,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  11 => 
  array (
    'admin_code' => 32448,
    'name' => '島根県美郷町',
    'lat' => 35.076512,
    'lon' => 132.590543,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  12 => 
  array (
    'admin_code' => 32449,
    'name' => '島根県邑南町',
    'lat' => 34.893934,
    'lon' => 132.437976,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  13 => 
  array (
    'admin_code' => 32501,
    'name' => '島根県津和野町',
    'lat' => 34.543668,
    'lon' => 131.838311,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  14 => 
  array (
    'admin_code' => 32505,
    'name' => '島根県吉賀町',
    'lat' => 34.35351,
    'lon' => 131.935137,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  15 => 
  array (
    'admin_code' => 32525,
    'name' => '島根県海士町',
    'lat' => 36.096561,
    'lon' => 133.096701,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  16 => 
  array (
    'admin_code' => 32526,
    'name' => '島根県西ノ島町',
    'lat' => 36.093158,
    'lon' => 132.994378,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  17 => 
  array (
    'admin_code' => 32527,
    'name' => '島根県知夫村',
    'lat' => 36.013927,
    'lon' => 133.039372,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  18 => 
  array (
    'admin_code' => 32528,
    'name' => '島根県隠岐の島町',
    'lat' => 36.20902,
    'lon' => 133.32178,
    'office_count' => 5,
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
