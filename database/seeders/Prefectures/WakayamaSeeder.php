<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 和歌山県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class WakayamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array (
  0 => 
  array (
    'admin_code' => 30201,
    'name' => '和歌山県和歌山市',
    'lat' => 34.230514,
    'lon' => 135.170808,
    'office_count' => 43,
    'main_office_count' => 1,
  ),
  1 => 
  array (
    'admin_code' => 30202,
    'name' => '和歌山県海南市',
    'lat' => 34.155311,
    'lon' => 135.209189,
    'office_count' => 6,
    'main_office_count' => 1,
  ),
  2 => 
  array (
    'admin_code' => 30203,
    'name' => '和歌山県橋本市',
    'lat' => 34.314876,
    'lon' => 135.605208,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  3 => 
  array (
    'admin_code' => 30204,
    'name' => '和歌山県有田市',
    'lat' => 34.083104,
    'lon' => 135.127727,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  4 => 
  array (
    'admin_code' => 30205,
    'name' => '和歌山県御坊市',
    'lat' => 33.891412,
    'lon' => 135.152406,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  5 => 
  array (
    'admin_code' => 30206,
    'name' => '和歌山県田辺市',
    'lat' => 33.72801,
    'lon' => 135.377662,
    'office_count' => 16,
    'main_office_count' => 1,
  ),
  6 => 
  array (
    'admin_code' => 30207,
    'name' => '和歌山県新宮市',
    'lat' => 33.724224,
    'lon' => 135.992525,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  7 => 
  array (
    'admin_code' => 30208,
    'name' => '和歌山県紀の川市',
    'lat' => 34.269538,
    'lon' => 135.362576,
    'office_count' => 6,
    'main_office_count' => 1,
  ),
  8 => 
  array (
    'admin_code' => 30209,
    'name' => '和歌山県岩出市',
    'lat' => 34.256267,
    'lon' => 135.311451,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  9 => 
  array (
    'admin_code' => 30304,
    'name' => '和歌山県紀美野町',
    'lat' => 34.167192,
    'lon' => 135.307575,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  10 => 
  array (
    'admin_code' => 30341,
    'name' => '和歌山県かつらぎ町',
    'lat' => 34.296416,
    'lon' => 135.503802,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  11 => 
  array (
    'admin_code' => 30343,
    'name' => '和歌山県九度山町',
    'lat' => 34.287192,
    'lon' => 135.562242,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  12 => 
  array (
    'admin_code' => 30344,
    'name' => '和歌山県高野町',
    'lat' => 34.216077,
    'lon' => 135.586536,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  13 => 
  array (
    'admin_code' => 30361,
    'name' => '和歌山県湯浅町',
    'lat' => 34.032952,
    'lon' => 135.178567,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  14 => 
  array (
    'admin_code' => 30362,
    'name' => '和歌山県広川町',
    'lat' => 34.029957,
    'lon' => 135.173072,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  15 => 
  array (
    'admin_code' => 30366,
    'name' => '和歌山県有田川町',
    'lat' => 34.057488,
    'lon' => 135.216116,
    'office_count' => 7,
    'main_office_count' => 1,
  ),
  16 => 
  array (
    'admin_code' => 30381,
    'name' => '和歌山県美浜町',
    'lat' => 33.893806,
    'lon' => 135.133265,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  17 => 
  array (
    'admin_code' => 30382,
    'name' => '和歌山県日高町',
    'lat' => 33.925677,
    'lon' => 135.141072,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  18 => 
  array (
    'admin_code' => 30383,
    'name' => '和歌山県由良町',
    'lat' => 33.959251,
    'lon' => 135.118187,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  19 => 
  array (
    'admin_code' => 30391,
    'name' => '和歌山県みなべ町',
    'lat' => 33.772333,
    'lon' => 135.321434,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  20 => 
  array (
    'admin_code' => 30392,
    'name' => '和歌山県日高川町',
    'lat' => 33.911693,
    'lon' => 135.186,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  21 => 
  array (
    'admin_code' => 30401,
    'name' => '和歌山県白浜町',
    'lat' => 33.678188,
    'lon' => 135.348108,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  22 => 
  array (
    'admin_code' => 30404,
    'name' => '和歌山県上富田町',
    'lat' => 33.696352,
    'lon' => 135.428802,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  23 => 
  array (
    'admin_code' => 30406,
    'name' => '和歌山県すさみ町',
    'lat' => 33.550062,
    'lon' => 135.496678,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  24 => 
  array (
    'admin_code' => 30421,
    'name' => '和歌山県那智勝浦町',
    'lat' => 33.625988,
    'lon' => 135.941042,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  25 => 
  array (
    'admin_code' => 30422,
    'name' => '和歌山県太地町',
    'lat' => 33.594037,
    'lon' => 135.943964,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  26 => 
  array (
    'admin_code' => 30424,
    'name' => '和歌山県古座川町',
    'lat' => 33.53199,
    'lon' => 135.814999,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  27 => 
  array (
    'admin_code' => 30427,
    'name' => '和歌山県北山村',
    'lat' => 33.9321,
    'lon' => 135.969303,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  28 => 
  array (
    'admin_code' => 30428,
    'name' => '和歌山県串本町',
    'lat' => 33.472556,
    'lon' => 135.781434,
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
