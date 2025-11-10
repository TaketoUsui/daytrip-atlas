<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 高知県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class KochiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array (
  0 => 
  array (
    'admin_code' => 39201,
    'name' => '高知県高知市',
    'lat' => 33.558788,
    'lon' => 133.531166,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  1 => 
  array (
    'admin_code' => 39202,
    'name' => '高知県室戸市',
    'lat' => 33.289955,
    'lon' => 134.151981,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  2 => 
  array (
    'admin_code' => 39203,
    'name' => '高知県安芸市',
    'lat' => 33.502416,
    'lon' => 133.907074,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  3 => 
  array (
    'admin_code' => 39204,
    'name' => '高知県南国市',
    'lat' => 33.575673,
    'lon' => 133.64146,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  4 => 
  array (
    'admin_code' => 39205,
    'name' => '高知県土佐市',
    'lat' => 33.496012,
    'lon' => 133.425326,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  5 => 
  array (
    'admin_code' => 39206,
    'name' => '高知県須崎市',
    'lat' => 33.400745,
    'lon' => 133.282959,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  6 => 
  array (
    'admin_code' => 39208,
    'name' => '高知県宿毛市',
    'lat' => 32.939014,
    'lon' => 132.726269,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  7 => 
  array (
    'admin_code' => 39209,
    'name' => '高知県土佐清水市',
    'lat' => 32.781603,
    'lon' => 132.9551,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  8 => 
  array (
    'admin_code' => 39211,
    'name' => '高知県香南市',
    'lat' => 33.564124,
    'lon' => 133.700543,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  9 => 
  array (
    'admin_code' => 39212,
    'name' => '高知県香美市',
    'lat' => 33.60386,
    'lon' => 133.686245,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  10 => 
  array (
    'admin_code' => 39301,
    'name' => '高知県東洋町',
    'lat' => 33.527976,
    'lon' => 134.279968,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  11 => 
  array (
    'admin_code' => 39302,
    'name' => '高知県奈半利町',
    'lat' => 33.424179,
    'lon' => 134.020957,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  12 => 
  array (
    'admin_code' => 39303,
    'name' => '高知県田野町',
    'lat' => 33.427713,
    'lon' => 134.008209,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  13 => 
  array (
    'admin_code' => 39304,
    'name' => '高知県安田町',
    'lat' => 33.438601,
    'lon' => 133.98108,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  14 => 
  array (
    'admin_code' => 39305,
    'name' => '高知県北川村',
    'lat' => 33.447694,
    'lon' => 134.042069,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  15 => 
  array (
    'admin_code' => 39306,
    'name' => '高知県馬路村',
    'lat' => 33.555347,
    'lon' => 134.048114,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  16 => 
  array (
    'admin_code' => 39307,
    'name' => '高知県芸西村',
    'lat' => 33.526915,
    'lon' => 133.808942,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  17 => 
  array (
    'admin_code' => 39341,
    'name' => '高知県本山町',
    'lat' => 33.757028,
    'lon' => 133.591481,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  18 => 
  array (
    'admin_code' => 39344,
    'name' => '高知県大豊町',
    'lat' => 33.764299,
    'lon' => 133.664288,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  19 => 
  array (
    'admin_code' => 39363,
    'name' => '高知県土佐町',
    'lat' => 33.736896,
    'lon' => 133.532107,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  20 => 
  array (
    'admin_code' => 39364,
    'name' => '高知県大川村',
    'lat' => 33.783927,
    'lon' => 133.466613,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  21 => 
  array (
    'admin_code' => 39386,
    'name' => '高知県いの町',
    'lat' => 33.548689,
    'lon' => 133.427583,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  22 => 
  array (
    'admin_code' => 39387,
    'name' => '高知県仁淀川町',
    'lat' => 33.575331,
    'lon' => 133.168288,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  23 => 
  array (
    'admin_code' => 39401,
    'name' => '高知県中土佐町',
    'lat' => 33.327411,
    'lon' => 133.228122,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  24 => 
  array (
    'admin_code' => 39402,
    'name' => '高知県佐川町',
    'lat' => 33.500809,
    'lon' => 133.286642,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  25 => 
  array (
    'admin_code' => 39403,
    'name' => '高知県越知町',
    'lat' => 33.532848,
    'lon' => 133.252221,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  26 => 
  array (
    'admin_code' => 39405,
    'name' => '高知県檮原町',
    'lat' => 33.39217,
    'lon' => 132.927065,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  27 => 
  array (
    'admin_code' => 39411,
    'name' => '高知県津野町',
    'lat' => 33.446666,
    'lon' => 133.199377,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  28 => 
  array (
    'admin_code' => 39412,
    'name' => '高知県四万十町',
    'lat' => 33.208342,
    'lon' => 133.135546,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  29 => 
  array (
    'admin_code' => 39424,
    'name' => '高知県大月町',
    'lat' => 32.841534,
    'lon' => 132.707092,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  30 => 
  array (
    'admin_code' => 39427,
    'name' => '高知県三原村',
    'lat' => 32.906019,
    'lon' => 132.847233,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  31 => 
  array (
    'admin_code' => 39428,
    'name' => '高知県黒潮町',
    'lat' => 33.024905,
    'lon' => 133.010953,
    'office_count' => 2,
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
