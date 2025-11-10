<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 長崎県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class NagasakiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array (
  0 => 
  array (
    'admin_code' => 42201,
    'name' => '長崎県長崎市',
    'lat' => 32.750311,
    'lon' => 129.877906,
    'office_count' => 29,
    'main_office_count' => 1,
  ),
  1 => 
  array (
    'admin_code' => 42202,
    'name' => '長崎県佐世保市',
    'lat' => 33.17990418,
    'lon' => 129.71509009,
    'office_count' => 19,
    'main_office_count' => 1,
  ),
  2 => 
  array (
    'admin_code' => 42203,
    'name' => '長崎県島原市',
    'lat' => 32.78812,
    'lon' => 130.370526,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  3 => 
  array (
    'admin_code' => 42204,
    'name' => '長崎県諫早市',
    'lat' => 32.844208,
    'lon' => 130.053601,
    'office_count' => 17,
    'main_office_count' => 1,
  ),
  4 => 
  array (
    'admin_code' => 42205,
    'name' => '長崎県大村市',
    'lat' => 32.89996,
    'lon' => 129.958217,
    'office_count' => 8,
    'main_office_count' => 1,
  ),
  5 => 
  array (
    'admin_code' => 42207,
    'name' => '長崎県平戸市',
    'lat' => 33.368065,
    'lon' => 129.553671,
    'office_count' => 8,
    'main_office_count' => 1,
  ),
  6 => 
  array (
    'admin_code' => 42208,
    'name' => '長崎県松浦市',
    'lat' => 33.341023,
    'lon' => 129.709047,
    'office_count' => 7,
    'main_office_count' => 1,
  ),
  7 => 
  array (
    'admin_code' => 42209,
    'name' => '長崎県対馬市',
    'lat' => 34.202643,
    'lon' => 129.287518,
    'office_count' => 6,
    'main_office_count' => 1,
  ),
  8 => 
  array (
    'admin_code' => 42211,
    'name' => '長崎県五島市',
    'lat' => 32.695541,
    'lon' => 128.840815,
    'office_count' => 13,
    'main_office_count' => 1,
  ),
  9 => 
  array (
    'admin_code' => 42212,
    'name' => '長崎県西海市',
    'lat' => 32.933117,
    'lon' => 129.642962,
    'office_count' => 8,
    'main_office_count' => 1,
  ),
  10 => 
  array (
    'admin_code' => 42213,
    'name' => '長崎県雲仙市',
    'lat' => 32.835214,
    'lon' => 130.187508,
    'office_count' => 8,
    'main_office_count' => 1,
  ),
  11 => 
  array (
    'admin_code' => 42214,
    'name' => '長崎県南島原市',
    'lat' => 32.659716,
    'lon' => 130.297783,
    'office_count' => 8,
    'main_office_count' => 1,
  ),
  12 => 
  array (
    'admin_code' => 42307,
    'name' => '長崎県長与町',
    'lat' => 32.82517,
    'lon' => 129.875071,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  13 => 
  array (
    'admin_code' => 42308,
    'name' => '長崎県時津町',
    'lat' => 32.828885,
    'lon' => 129.848527,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  14 => 
  array (
    'admin_code' => 42321,
    'name' => '長崎県東彼杵町',
    'lat' => 33.037031,
    'lon' => 129.917149,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  15 => 
  array (
    'admin_code' => 42322,
    'name' => '長崎県川棚町',
    'lat' => 33.072679,
    'lon' => 129.861562,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  16 => 
  array (
    'admin_code' => 42323,
    'name' => '長崎県波佐見町',
    'lat' => 33.13789,
    'lon' => 129.895548,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  17 => 
  array (
    'admin_code' => 42383,
    'name' => '長崎県小値賀町',
    'lat' => 33.191074,
    'lon' => 129.058766,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  18 => 
  array (
    'admin_code' => 42391,
    'name' => '長崎県佐々町',
    'lat' => 33.238426,
    'lon' => 129.650353,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  19 => 
  array (
    'admin_code' => 42411,
    'name' => '長崎県新上五島町',
    'lat' => 32.984553,
    'lon' => 129.073401,
    'office_count' => 6,
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
