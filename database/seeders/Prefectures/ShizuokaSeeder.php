<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 静岡県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class ShizuokaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array (
  0 => 
  array (
    'admin_code' => 22101,
    'name' => '静岡県静岡市葵区',
    'lat' => 34.975135,
    'lon' => 138.383259,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  1 => 
  array (
    'admin_code' => 22102,
    'name' => '静岡県静岡市駿河区',
    'lat' => 34.960745,
    'lon' => 138.404047,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  2 => 
  array (
    'admin_code' => 22103,
    'name' => '静岡県静岡市清水区',
    'lat' => 35.01573,
    'lon' => 138.489603,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  3 => 
  array (
    'admin_code' => 22132,
    'name' => '静岡県浜松市東区',
    'lat' => 34.741339,
    'lon' => 137.791742,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  4 => 
  array (
    'admin_code' => 22133,
    'name' => '静岡県浜松市西区',
    'lat' => 34.692706,
    'lon' => 137.645322,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  5 => 
  array (
    'admin_code' => 22134,
    'name' => '静岡県浜松市南区',
    'lat' => 34.667319,
    'lon' => 137.752372,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  6 => 
  array (
    'admin_code' => 22135,
    'name' => '静岡県浜松市北区',
    'lat' => 34.806151,
    'lon' => 137.651104,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  7 => 
  array (
    'admin_code' => 22136,
    'name' => '静岡県浜松市浜北区',
    'lat' => 34.79328,
    'lon' => 137.789994,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  8 => 
  array (
    'admin_code' => 22137,
    'name' => '静岡県浜松市天竜区',
    'lat' => 34.872686,
    'lon' => 137.815924,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  9 => 
  array (
    'admin_code' => 22203,
    'name' => '静岡県沼津市',
    'lat' => 35.095723,
    'lon' => 138.863337,
    'office_count' => 12,
    'main_office_count' => 1,
  ),
  10 => 
  array (
    'admin_code' => 22205,
    'name' => '静岡県熱海市',
    'lat' => 35.095987,
    'lon' => 139.071546,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  11 => 
  array (
    'admin_code' => 22206,
    'name' => '静岡県三島市',
    'lat' => 35.118483,
    'lon' => 138.918501,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  12 => 
  array (
    'admin_code' => 22207,
    'name' => '静岡県富士宮市',
    'lat' => 35.221983,
    'lon' => 138.621656,
    'office_count' => 6,
    'main_office_count' => 1,
  ),
  13 => 
  array (
    'admin_code' => 22208,
    'name' => '静岡県伊東市',
    'lat' => 34.96568,
    'lon' => 139.102048,
    'office_count' => 7,
    'main_office_count' => 1,
  ),
  14 => 
  array (
    'admin_code' => 22209,
    'name' => '静岡県島田市',
    'lat' => 34.836417,
    'lon' => 138.176055,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  15 => 
  array (
    'admin_code' => 22211,
    'name' => '静岡県磐田市',
    'lat' => 34.717881,
    'lon' => 137.851511,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  16 => 
  array (
    'admin_code' => 22212,
    'name' => '静岡県焼津市',
    'lat' => 34.866906,
    'lon' => 138.32326,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  17 => 
  array (
    'admin_code' => 22213,
    'name' => '静岡県掛川市',
    'lat' => 34.768717,
    'lon' => 137.998403,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  18 => 
  array (
    'admin_code' => 22214,
    'name' => '静岡県藤枝市',
    'lat' => 34.867349,
    'lon' => 138.257548,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  19 => 
  array (
    'admin_code' => 22215,
    'name' => '静岡県御殿場市',
    'lat' => 35.308615,
    'lon' => 138.934506,
    'office_count' => 6,
    'main_office_count' => 1,
  ),
  20 => 
  array (
    'admin_code' => 22216,
    'name' => '静岡県袋井市',
    'lat' => 34.75016,
    'lon' => 137.924624,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  21 => 
  array (
    'admin_code' => 22219,
    'name' => '静岡県下田市',
    'lat' => 34.679536,
    'lon' => 138.945316,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  22 => 
  array (
    'admin_code' => 22221,
    'name' => '静岡県湖西市',
    'lat' => 34.718474,
    'lon' => 137.531617,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  23 => 
  array (
    'admin_code' => 22222,
    'name' => '静岡県伊豆市',
    'lat' => 34.976591,
    'lon' => 138.946715,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  24 => 
  array (
    'admin_code' => 22223,
    'name' => '静岡県御前崎市',
    'lat' => 34.637977,
    'lon' => 138.128117,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  25 => 
  array (
    'admin_code' => 22224,
    'name' => '静岡県菊川市',
    'lat' => 34.757721,
    'lon' => 138.084539,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  26 => 
  array (
    'admin_code' => 22225,
    'name' => '静岡県伊豆の国市',
    'lat' => 35.027713,
    'lon' => 138.928885,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  27 => 
  array (
    'admin_code' => 22226,
    'name' => '静岡県牧之原市',
    'lat' => 34.740059,
    'lon' => 138.224641,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  28 => 
  array (
    'admin_code' => 22301,
    'name' => '静岡県東伊豆町',
    'lat' => 34.772816,
    'lon' => 139.041265,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  29 => 
  array (
    'admin_code' => 22302,
    'name' => '静岡県河津町',
    'lat' => 34.757018,
    'lon' => 138.987622,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  30 => 
  array (
    'admin_code' => 22304,
    'name' => '静岡県南伊豆町',
    'lat' => 34.651089,
    'lon' => 138.858533,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  31 => 
  array (
    'admin_code' => 22305,
    'name' => '静岡県松崎町',
    'lat' => 34.752763,
    'lon' => 138.778757,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  32 => 
  array (
    'admin_code' => 22306,
    'name' => '静岡県西伊豆町',
    'lat' => 34.771693,
    'lon' => 138.775334,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  33 => 
  array (
    'admin_code' => 22325,
    'name' => '静岡県函南町',
    'lat' => 35.088937,
    'lon' => 138.953348,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  34 => 
  array (
    'admin_code' => 22341,
    'name' => '静岡県清水町',
    'lat' => 35.099015,
    'lon' => 138.90272,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  35 => 
  array (
    'admin_code' => 22342,
    'name' => '静岡県長泉町',
    'lat' => 35.137712,
    'lon' => 138.897258,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  36 => 
  array (
    'admin_code' => 22344,
    'name' => '静岡県小山町',
    'lat' => 35.36011,
    'lon' => 138.987296,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  37 => 
  array (
    'admin_code' => 22424,
    'name' => '静岡県吉田町',
    'lat' => 34.77087,
    'lon' => 138.251943,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  38 => 
  array (
    'admin_code' => 22429,
    'name' => '静岡県川根本町',
    'lat' => 35.046822,
    'lon' => 138.081695,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  39 => 
  array (
    'admin_code' => 22461,
    'name' => '静岡県森町',
    'lat' => 34.835601,
    'lon' => 137.927088,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  40 => 
  array (
    'admin_code' => 22131,
    'name' => '静岡県浜松市中区',
    'lat' => 34.710865,
    'lon' => 137.726117,
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
