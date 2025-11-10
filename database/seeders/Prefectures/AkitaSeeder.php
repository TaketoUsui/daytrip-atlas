<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 秋田県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class AkitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array (
  0 => 
  array (
    'admin_code' => '05201',
    'name' => '秋田県秋田市',
    'lat' => 39.719929,
    'lon' => 140.102512,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  1 => 
  array (
    'admin_code' => '05202',
    'name' => '秋田県能代市',
    'lat' => 40.212131,
    'lon' => 140.026641,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  2 => 
  array (
    'admin_code' => '05203',
    'name' => '秋田県横手市',
    'lat' => 39.313777,
    'lon' => 140.566636,
    'office_count' => 10,
    'main_office_count' => 1,
  ),
  3 => 
  array (
    'admin_code' => '05204',
    'name' => '秋田県大館市',
    'lat' => 40.27137212,
    'lon' => 140.56436294,
    'office_count' => 13,
    'main_office_count' => 1,
  ),
  4 => 
  array (
    'admin_code' => '05206',
    'name' => '秋田県男鹿市',
    'lat' => 39.886721,
    'lon' => 139.8475,
    'office_count' => 9,
    'main_office_count' => 1,
  ),
  5 => 
  array (
    'admin_code' => '05207',
    'name' => '秋田県湯沢市',
    'lat' => 39.164074,
    'lon' => 140.494683,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  6 => 
  array (
    'admin_code' => '05209',
    'name' => '秋田県鹿角市',
    'lat' => 40.215789,
    'lon' => 140.788519,
    'office_count' => 6,
    'main_office_count' => 1,
  ),
  7 => 
  array (
    'admin_code' => '05211',
    'name' => '秋田県潟上市',
    'lat' => 39.883243,
    'lon' => 139.988623,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  8 => 
  array (
    'admin_code' => '05212',
    'name' => '秋田県大仙市',
    'lat' => 39.45309,
    'lon' => 140.475448,
    'office_count' => 9,
    'main_office_count' => 1,
  ),
  9 => 
  array (
    'admin_code' => '05213',
    'name' => '秋田県北秋田市',
    'lat' => 40.226046,
    'lon' => 140.370728,
    'office_count' => 7,
    'main_office_count' => 1,
  ),
  10 => 
  array (
    'admin_code' => '05214',
    'name' => '秋田県にかほ市',
    'lat' => 39.203067,
    'lon' => 139.907649,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  11 => 
  array (
    'admin_code' => '05215',
    'name' => '秋田県仙北市',
    'lat' => 39.700044,
    'lon' => 140.730728,
    'office_count' => 7,
    'main_office_count' => 1,
  ),
  12 => 
  array (
    'admin_code' => '05303',
    'name' => '秋田県小坂町',
    'lat' => 40.332926,
    'lon' => 140.736191,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  13 => 
  array (
    'admin_code' => '05327',
    'name' => '秋田県上小阿仁村',
    'lat' => 40.063263,
    'lon' => 140.295736,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  14 => 
  array (
    'admin_code' => '05346',
    'name' => '秋田県藤里町',
    'lat' => 40.278399,
    'lon' => 140.261879,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  15 => 
  array (
    'admin_code' => '05348',
    'name' => '秋田県三種町',
    'lat' => 40.101615,
    'lon' => 140.004981,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  16 => 
  array (
    'admin_code' => '05349',
    'name' => '秋田県八峰町',
    'lat' => 40.318715,
    'lon' => 140.038618,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  17 => 
  array (
    'admin_code' => '05361',
    'name' => '秋田県五城目町',
    'lat' => 39.943895,
    'lon' => 140.111309,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  18 => 
  array (
    'admin_code' => '05363',
    'name' => '秋田県八郎潟町',
    'lat' => 39.949355,
    'lon' => 140.073335,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  19 => 
  array (
    'admin_code' => '05366',
    'name' => '秋田県井川町',
    'lat' => 39.914188,
    'lon' => 140.081265,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  20 => 
  array (
    'admin_code' => '05368',
    'name' => '秋田県大潟村',
    'lat' => 40.017788,
    'lon' => 139.960064,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  21 => 
  array (
    'admin_code' => '05434',
    'name' => '秋田県美郷町',
    'lat' => 39.461633,
    'lon' => 140.582127,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  22 => 
  array (
    'admin_code' => '05463',
    'name' => '秋田県羽後町',
    'lat' => 39.199323,
    'lon' => 140.412881,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  23 => 
  array (
    'admin_code' => '05464',
    'name' => '秋田県東成瀬村',
    'lat' => 39.179185,
    'lon' => 140.648892,
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
