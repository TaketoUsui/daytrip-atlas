<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 広島県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class HiroshimaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array (
  0 => 
  array (
    'admin_code' => 34102,
    'name' => '広島県広島市東区',
    'lat' => 34.395333,
    'lon' => 132.482384,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  1 => 
  array (
    'admin_code' => 34103,
    'name' => '広島県広島市南区',
    'lat' => 34.379884,
    'lon' => 132.469061,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  2 => 
  array (
    'admin_code' => 34105,
    'name' => '広島県広島市安佐南区',
    'lat' => 34.45185,
    'lon' => 132.471641,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  3 => 
  array (
    'admin_code' => 34106,
    'name' => '広島県広島市安佐北区',
    'lat' => 34.518282,
    'lon' => 132.507633,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  4 => 
  array (
    'admin_code' => 34107,
    'name' => '広島県広島市安芸区',
    'lat' => 34.371756,
    'lon' => 132.525542,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  5 => 
  array (
    'admin_code' => 34108,
    'name' => '広島県広島市佐伯区',
    'lat' => 34.36446,
    'lon' => 132.36082,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  6 => 
  array (
    'admin_code' => 34104,
    'name' => '広島県広島市西区',
    'lat' => 34.393966,
    'lon' => 132.434426,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  7 => 
  array (
    'admin_code' => 34101,
    'name' => '広島県広島市中区',
    'lat' => 34.386288,
    'lon' => 132.454992,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  8 => 
  array (
    'admin_code' => 34202,
    'name' => '広島県呉市',
    'lat' => 34.249254,
    'lon' => 132.565805,
    'office_count' => 18,
    'main_office_count' => 1,
  ),
  9 => 
  array (
    'admin_code' => 34203,
    'name' => '広島県竹原市',
    'lat' => 34.341794,
    'lon' => 132.907091,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  10 => 
  array (
    'admin_code' => 34204,
    'name' => '広島県三原市',
    'lat' => 34.39747,
    'lon' => 133.078525,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  11 => 
  array (
    'admin_code' => 34205,
    'name' => '広島県尾道市',
    'lat' => 34.408891,
    'lon' => 133.204966,
    'office_count' => 8,
    'main_office_count' => 1,
  ),
  12 => 
  array (
    'admin_code' => 34207,
    'name' => '広島県福山市',
    'lat' => 34.485927,
    'lon' => 133.36234,
    'office_count' => 15,
    'main_office_count' => 1,
  ),
  13 => 
  array (
    'admin_code' => 34208,
    'name' => '広島県府中市',
    'lat' => 34.568349,
    'lon' => 133.236323,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  14 => 
  array (
    'admin_code' => 34209,
    'name' => '広島県三次市',
    'lat' => 34.805627,
    'lon' => 132.85179,
    'office_count' => 8,
    'main_office_count' => 1,
  ),
  15 => 
  array (
    'admin_code' => 34211,
    'name' => '広島県大竹市',
    'lat' => 34.237952,
    'lon' => 132.222361,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  16 => 
  array (
    'admin_code' => 34212,
    'name' => '広島県東広島市',
    'lat' => 34.426787,
    'lon' => 132.743746,
    'office_count' => 9,
    'main_office_count' => 1,
  ),
  17 => 
  array (
    'admin_code' => 34213,
    'name' => '広島県廿日市市',
    'lat' => 34.348416,
    'lon' => 132.331541,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  18 => 
  array (
    'admin_code' => 34214,
    'name' => '広島県安芸高田市',
    'lat' => 34.666099,
    'lon' => 132.703977,
    'office_count' => 6,
    'main_office_count' => 1,
  ),
  19 => 
  array (
    'admin_code' => 34215,
    'name' => '広島県江田島市',
    'lat' => 34.222941,
    'lon' => 132.443794,
    'office_count' => 15,
    'main_office_count' => 1,
  ),
  20 => 
  array (
    'admin_code' => 34302,
    'name' => '広島県府中町',
    'lat' => 34.392589,
    'lon' => 132.504544,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  21 => 
  array (
    'admin_code' => 34304,
    'name' => '広島県海田町',
    'lat' => 34.372159,
    'lon' => 132.536155,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  22 => 
  array (
    'admin_code' => 34307,
    'name' => '広島県熊野町',
    'lat' => 34.335783,
    'lon' => 132.584604,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  23 => 
  array (
    'admin_code' => 34309,
    'name' => '広島県坂町',
    'lat' => 34.341282,
    'lon' => 132.513639,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  24 => 
  array (
    'admin_code' => 34368,
    'name' => '広島県安芸太田町',
    'lat' => 34.576731,
    'lon' => 132.227141,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  25 => 
  array (
    'admin_code' => 34369,
    'name' => '広島県北広島町',
    'lat' => 34.674541,
    'lon' => 132.538427,
    'office_count' => 6,
    'main_office_count' => 1,
  ),
  26 => 
  array (
    'admin_code' => 34431,
    'name' => '広島県大崎上島町',
    'lat' => 34.269552,
    'lon' => 132.914963,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  27 => 
  array (
    'admin_code' => 34462,
    'name' => '広島県世羅町',
    'lat' => 34.586837,
    'lon' => 133.056631,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  28 => 
  array (
    'admin_code' => 34545,
    'name' => '広島県神石高原町',
    'lat' => 34.703654,
    'lon' => 133.247642,
    'office_count' => 4,
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
