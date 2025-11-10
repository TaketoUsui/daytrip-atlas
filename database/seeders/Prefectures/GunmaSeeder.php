<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 群馬県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class GunmaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array (
  0 => 
  array (
    'admin_code' => 10201,
    'name' => '群馬県前橋市',
    'lat' => 36.389413,
    'lon' => 139.063493,
    'office_count' => 6,
    'main_office_count' => 1,
  ),
  1 => 
  array (
    'admin_code' => 10202,
    'name' => '群馬県高崎市',
    'lat' => 36.32195,
    'lon' => 139.003355,
    'office_count' => 7,
    'main_office_count' => 1,
  ),
  2 => 
  array (
    'admin_code' => 10203,
    'name' => '群馬県桐生市',
    'lat' => 36.40521,
    'lon' => 139.330646,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  3 => 
  array (
    'admin_code' => 10204,
    'name' => '群馬県伊勢崎市',
    'lat' => 36.311341,
    'lon' => 139.19696,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  4 => 
  array (
    'admin_code' => 10205,
    'name' => '群馬県太田市',
    'lat' => 36.291127,
    'lon' => 139.37536,
    'office_count' => 16,
    'main_office_count' => 1,
  ),
  5 => 
  array (
    'admin_code' => 10206,
    'name' => '群馬県沼田市',
    'lat' => 36.646078,
    'lon' => 139.044074,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  6 => 
  array (
    'admin_code' => 10207,
    'name' => '群馬県館林市',
    'lat' => 36.244841,
    'lon' => 139.542057,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  7 => 
  array (
    'admin_code' => 10208,
    'name' => '群馬県渋川市',
    'lat' => 36.48948,
    'lon' => 139.000394,
    'office_count' => 6,
    'main_office_count' => 1,
  ),
  8 => 
  array (
    'admin_code' => 10209,
    'name' => '群馬県藤岡市',
    'lat' => 36.258509,
    'lon' => 139.074564,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  9 => 
  array (
    'admin_code' => 10211,
    'name' => '群馬県安中市',
    'lat' => 36.326298,
    'lon' => 138.887244,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  10 => 
  array (
    'admin_code' => 10212,
    'name' => '群馬県みどり市',
    'lat' => 36.394819,
    'lon' => 139.281076,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  11 => 
  array (
    'admin_code' => 10344,
    'name' => '群馬県榛東村',
    'lat' => 36.438647,
    'lon' => 138.967118,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  12 => 
  array (
    'admin_code' => 10345,
    'name' => '群馬県吉岡町',
    'lat' => 36.447443,
    'lon' => 139.0097,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  13 => 
  array (
    'admin_code' => 10366,
    'name' => '群馬県上野村',
    'lat' => 36.083135,
    'lon' => 138.777334,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  14 => 
  array (
    'admin_code' => 10367,
    'name' => '群馬県神流町',
    'lat' => 36.116013,
    'lon' => 138.916991,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  15 => 
  array (
    'admin_code' => 10382,
    'name' => '群馬県下仁田町',
    'lat' => 36.21247,
    'lon' => 138.789083,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  16 => 
  array (
    'admin_code' => 10383,
    'name' => '群馬県南牧村',
    'lat' => 36.158553,
    'lon' => 138.711406,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  17 => 
  array (
    'admin_code' => 10384,
    'name' => '群馬県甘楽町',
    'lat' => 36.243009,
    'lon' => 138.921752,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  18 => 
  array (
    'admin_code' => 10421,
    'name' => '群馬県中之条町',
    'lat' => 36.589843,
    'lon' => 138.841075,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  19 => 
  array (
    'admin_code' => 10424,
    'name' => '群馬県長野原町',
    'lat' => 36.552434,
    'lon' => 138.637572,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  20 => 
  array (
    'admin_code' => 10425,
    'name' => '群馬県嬬恋村',
    'lat' => 36.516735,
    'lon' => 138.530298,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  21 => 
  array (
    'admin_code' => 10426,
    'name' => '群馬県草津町',
    'lat' => 36.620711,
    'lon' => 138.596127,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  22 => 
  array (
    'admin_code' => 10428,
    'name' => '群馬県高山村',
    'lat' => 36.620809,
    'lon' => 138.943477,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  23 => 
  array (
    'admin_code' => 10429,
    'name' => '群馬県東吾妻町',
    'lat' => 36.571414,
    'lon' => 138.825563,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  24 => 
  array (
    'admin_code' => 10443,
    'name' => '群馬県片品村',
    'lat' => 36.772549,
    'lon' => 139.225241,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  25 => 
  array (
    'admin_code' => 10444,
    'name' => '群馬県川場村',
    'lat' => 36.694683,
    'lon' => 139.106512,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  26 => 
  array (
    'admin_code' => 10448,
    'name' => '群馬県昭和村',
    'lat' => 36.639761,
    'lon' => 139.065881,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  27 => 
  array (
    'admin_code' => 10449,
    'name' => '群馬県みなかみ町',
    'lat' => 36.67865,
    'lon' => 138.999055,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  28 => 
  array (
    'admin_code' => 10464,
    'name' => '群馬県玉村町',
    'lat' => 36.304435,
    'lon' => 139.114916,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  29 => 
  array (
    'admin_code' => 10521,
    'name' => '群馬県板倉町',
    'lat' => 36.222955,
    'lon' => 139.610271,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  30 => 
  array (
    'admin_code' => 10522,
    'name' => '群馬県明和町',
    'lat' => 36.211283,
    'lon' => 139.534228,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  31 => 
  array (
    'admin_code' => 10523,
    'name' => '群馬県千代田町',
    'lat' => 36.217754,
    'lon' => 139.442437,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  32 => 
  array (
    'admin_code' => 10524,
    'name' => '群馬県大泉町',
    'lat' => 36.247862,
    'lon' => 139.404843,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  33 => 
  array (
    'admin_code' => 10525,
    'name' => '群馬県邑楽町',
    'lat' => 36.252392,
    'lon' => 139.4623,
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
