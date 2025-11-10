<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 石川県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class IshikawaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array (
  0 => 
  array (
    'admin_code' => 17201,
    'name' => '石川県金沢市',
    'lat' => 36.561051,
    'lon' => 136.656633,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  1 => 
  array (
    'admin_code' => 17202,
    'name' => '石川県七尾市',
    'lat' => 37.043108,
    'lon' => 136.967296,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  2 => 
  array (
    'admin_code' => 17203,
    'name' => '石川県小松市',
    'lat' => 36.408357,
    'lon' => 136.445588,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  3 => 
  array (
    'admin_code' => 17204,
    'name' => '石川県輪島市',
    'lat' => 37.390557,
    'lon' => 136.899185,
    'office_count' => 6,
    'main_office_count' => 1,
  ),
  4 => 
  array (
    'admin_code' => 17205,
    'name' => '石川県珠洲市',
    'lat' => 37.436369,
    'lon' => 137.260406,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  5 => 
  array (
    'admin_code' => 17206,
    'name' => '石川県加賀市',
    'lat' => 36.302669,
    'lon' => 136.314685,
    'office_count' => 6,
    'main_office_count' => 1,
  ),
  6 => 
  array (
    'admin_code' => 17207,
    'name' => '石川県羽咋市',
    'lat' => 36.893599,
    'lon' => 136.778999,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  7 => 
  array (
    'admin_code' => 17209,
    'name' => '石川県かほく市',
    'lat' => 36.719973,
    'lon' => 136.706668,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  8 => 
  array (
    'admin_code' => 17211,
    'name' => '石川県能美市',
    'lat' => 36.446888,
    'lon' => 136.554028,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  9 => 
  array (
    'admin_code' => 17324,
    'name' => '石川県川北町',
    'lat' => 36.468632,
    'lon' => 136.542276,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  10 => 
  array (
    'admin_code' => 17212,
    'name' => '石川県野々市市',
    'lat' => 36.519466,
    'lon' => 136.609685,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  11 => 
  array (
    'admin_code' => 17361,
    'name' => '石川県津幡町',
    'lat' => 36.669093,
    'lon' => 136.728683,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  12 => 
  array (
    'admin_code' => 17365,
    'name' => '石川県内灘町',
    'lat' => 36.65353,
    'lon' => 136.645125,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  13 => 
  array (
    'admin_code' => 17384,
    'name' => '石川県志賀町',
    'lat' => 37.006187,
    'lon' => 136.77801,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  14 => 
  array (
    'admin_code' => 17386,
    'name' => '石川県宝達志水町',
    'lat' => 36.862759,
    'lon' => 136.797557,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  15 => 
  array (
    'admin_code' => 17407,
    'name' => '石川県中能登町',
    'lat' => 36.98889,
    'lon' => 136.901476,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  16 => 
  array (
    'admin_code' => 17461,
    'name' => '石川県穴水町',
    'lat' => 37.230874,
    'lon' => 136.912479,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  17 => 
  array (
    'admin_code' => 17463,
    'name' => '石川県能登町',
    'lat' => 37.306588,
    'lon' => 137.150052,
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
