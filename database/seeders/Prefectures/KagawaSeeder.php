<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 香川県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class KagawaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array (
  0 => 
  array (
    'admin_code' => 37201,
    'name' => '香川県高松市',
    'lat' => 34.342791,
    'lon' => 134.046574,
    'office_count' => 31,
    'main_office_count' => 1,
  ),
  1 => 
  array (
    'admin_code' => 37202,
    'name' => '香川県丸亀市',
    'lat' => 34.289482,
    'lon' => 133.797716,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  2 => 
  array (
    'admin_code' => 37203,
    'name' => '香川県坂出市',
    'lat' => 34.316478,
    'lon' => 133.860502,
    'office_count' => 8,
    'main_office_count' => 1,
  ),
  3 => 
  array (
    'admin_code' => 37204,
    'name' => '香川県善通寺市',
    'lat' => 34.228417,
    'lon' => 133.787153,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  4 => 
  array (
    'admin_code' => 37205,
    'name' => '香川県観音寺市',
    'lat' => 34.12737,
    'lon' => 133.661597,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  5 => 
  array (
    'admin_code' => 37206,
    'name' => '香川県さぬき市',
    'lat' => 34.32521,
    'lon' => 134.171989,
    'office_count' => 10,
    'main_office_count' => 1,
  ),
  6 => 
  array (
    'admin_code' => 37207,
    'name' => '香川県東かがわ市',
    'lat' => 34.243803,
    'lon' => 134.358837,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  7 => 
  array (
    'admin_code' => 37208,
    'name' => '香川県三豊市',
    'lat' => 34.182556,
    'lon' => 133.715203,
    'office_count' => 10,
    'main_office_count' => 1,
  ),
  8 => 
  array (
    'admin_code' => 37322,
    'name' => '香川県土庄町',
    'lat' => 34.485987,
    'lon' => 134.185594,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  9 => 
  array (
    'admin_code' => 37324,
    'name' => '香川県小豆島町',
    'lat' => 34.482032,
    'lon' => 134.233548,
    'office_count' => 6,
    'main_office_count' => 1,
  ),
  10 => 
  array (
    'admin_code' => 37341,
    'name' => '香川県三木町',
    'lat' => 34.268355,
    'lon' => 134.134363,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  11 => 
  array (
    'admin_code' => 37364,
    'name' => '香川県直島町',
    'lat' => 34.45983,
    'lon' => 133.995638,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  12 => 
  array (
    'admin_code' => 37386,
    'name' => '香川県宇多津町',
    'lat' => 34.310301,
    'lon' => 133.825566,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  13 => 
  array (
    'admin_code' => 37387,
    'name' => '香川県綾川町',
    'lat' => 34.249613,
    'lon' => 133.923099,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  14 => 
  array (
    'admin_code' => 37403,
    'name' => '香川県琴平町',
    'lat' => 34.19142,
    'lon' => 133.823303,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  15 => 
  array (
    'admin_code' => 37404,
    'name' => '香川県多度津町',
    'lat' => 34.272474,
    'lon' => 133.753569,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  16 => 
  array (
    'admin_code' => 37406,
    'name' => '香川県まんのう町',
    'lat' => 34.192334,
    'lon' => 133.841393,
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
