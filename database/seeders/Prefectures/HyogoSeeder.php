<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 兵庫県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class HyogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array (
  0 => 
  array (
    'admin_code' => 28101,
    'name' => '兵庫県神戸市東灘区',
    'lat' => 34.720159,
    'lon' => 135.265429,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  1 => 
  array (
    'admin_code' => 28102,
    'name' => '兵庫県神戸市灘区',
    'lat' => 34.712356,
    'lon' => 135.239571,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  2 => 
  array (
    'admin_code' => 28105,
    'name' => '兵庫県神戸市兵庫区',
    'lat' => 34.680584,
    'lon' => 135.165383,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  3 => 
  array (
    'admin_code' => 28106,
    'name' => '兵庫県神戸市長田区',
    'lat' => 34.665686,
    'lon' => 135.150854,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  4 => 
  array (
    'admin_code' => 28107,
    'name' => '兵庫県神戸市須磨区',
    'lat' => 34.658634,
    'lon' => 135.133702,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  5 => 
  array (
    'admin_code' => 28108,
    'name' => '兵庫県神戸市垂水区',
    'lat' => 34.63061,
    'lon' => 135.056919,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  6 => 
  array (
    'admin_code' => 28109,
    'name' => '兵庫県神戸市北区',
    'lat' => 34.727256,
    'lon' => 135.144387,
    'office_count' => 9,
    'main_office_count' => 1,
  ),
  7 => 
  array (
    'admin_code' => 28111,
    'name' => '兵庫県神戸市西区',
    'lat' => 34.68325,
    'lon' => 134.981654,
    'office_count' => 8,
    'main_office_count' => 1,
  ),
  8 => 
  array (
    'admin_code' => 28201,
    'name' => '兵庫県姫路市',
    'lat' => 34.815496,
    'lon' => 134.685458,
    'office_count' => 16,
    'main_office_count' => 1,
  ),
  9 => 
  array (
    'admin_code' => 28202,
    'name' => '兵庫県尼崎市',
    'lat' => 34.733554,
    'lon' => 135.406394,
    'office_count' => 7,
    'main_office_count' => 1,
  ),
  10 => 
  array (
    'admin_code' => 28203,
    'name' => '兵庫県明石市',
    'lat' => 34.643109,
    'lon' => 134.997182,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  11 => 
  array (
    'admin_code' => 28204,
    'name' => '兵庫県西宮市',
    'lat' => 34.737691,
    'lon' => 135.34183,
    'office_count' => 10,
    'main_office_count' => 1,
  ),
  12 => 
  array (
    'admin_code' => 28205,
    'name' => '兵庫県洲本市',
    'lat' => 34.342522,
    'lon' => 134.895653,
    'office_count' => 6,
    'main_office_count' => 1,
  ),
  13 => 
  array (
    'admin_code' => 28206,
    'name' => '兵庫県芦屋市',
    'lat' => 34.726522,
    'lon' => 135.304179,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  14 => 
  array (
    'admin_code' => 28207,
    'name' => '兵庫県伊丹市',
    'lat' => 34.784295,
    'lon' => 135.400933,
    'office_count' => 6,
    'main_office_count' => 1,
  ),
  15 => 
  array (
    'admin_code' => 28208,
    'name' => '兵庫県相生市',
    'lat' => 34.803662,
    'lon' => 134.468193,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  16 => 
  array (
    'admin_code' => 28209,
    'name' => '兵庫県豊岡市',
    'lat' => 35.544475,
    'lon' => 134.820187,
    'office_count' => 6,
    'main_office_count' => 1,
  ),
  17 => 
  array (
    'admin_code' => 28212,
    'name' => '兵庫県赤穂市',
    'lat' => 34.754974,
    'lon' => 134.390354,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  18 => 
  array (
    'admin_code' => 28213,
    'name' => '兵庫県西脇市',
    'lat' => 34.993428,
    'lon' => 134.969284,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  19 => 
  array (
    'admin_code' => 28214,
    'name' => '兵庫県宝塚市',
    'lat' => 34.799817,
    'lon' => 135.360098,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  20 => 
  array (
    'admin_code' => 28215,
    'name' => '兵庫県三木市',
    'lat' => 34.796922,
    'lon' => 134.990188,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  21 => 
  array (
    'admin_code' => 28216,
    'name' => '兵庫県高砂市',
    'lat' => 34.766248,
    'lon' => 134.790478,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  22 => 
  array (
    'admin_code' => 28217,
    'name' => '兵庫県川西市',
    'lat' => 34.830132,
    'lon' => 135.417222,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  23 => 
  array (
    'admin_code' => 28218,
    'name' => '兵庫県小野市',
    'lat' => 34.853183,
    'lon' => 134.931545,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  24 => 
  array (
    'admin_code' => 28219,
    'name' => '兵庫県三田市',
    'lat' => 34.889672,
    'lon' => 135.22529,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  25 => 
  array (
    'admin_code' => 28221,
    'name' => '兵庫県篠山市',
    'lat' => 35.075673,
    'lon' => 135.219002,
    'office_count' => 6,
    'main_office_count' => 1,
  ),
  26 => 
  array (
    'admin_code' => 28222,
    'name' => '兵庫県養父市',
    'lat' => 35.40464,
    'lon' => 134.767668,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  27 => 
  array (
    'admin_code' => 28223,
    'name' => '兵庫県丹波市',
    'lat' => 35.177259,
    'lon' => 135.035816,
    'office_count' => 6,
    'main_office_count' => 1,
  ),
  28 => 
  array (
    'admin_code' => 28224,
    'name' => '兵庫県南あわじ市',
    'lat' => 34.295807,
    'lon' => 134.779083,
    'office_count' => 11,
    'main_office_count' => 1,
  ),
  29 => 
  array (
    'admin_code' => 28225,
    'name' => '兵庫県朝来市',
    'lat' => 35.339835,
    'lon' => 134.853117,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  30 => 
  array (
    'admin_code' => 28226,
    'name' => '兵庫県淡路市',
    'lat' => 34.439847,
    'lon' => 134.914633,
    'office_count' => 6,
    'main_office_count' => 1,
  ),
  31 => 
  array (
    'admin_code' => 28227,
    'name' => '兵庫県宍粟市',
    'lat' => 35.004435,
    'lon' => 134.549377,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  32 => 
  array (
    'admin_code' => 28228,
    'name' => '兵庫県加東市',
    'lat' => 34.91737,
    'lon' => 134.973345,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  33 => 
  array (
    'admin_code' => 28229,
    'name' => '兵庫県たつの市',
    'lat' => 34.857847,
    'lon' => 134.545397,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  34 => 
  array (
    'admin_code' => 28301,
    'name' => '兵庫県猪名川町',
    'lat' => 34.894966,
    'lon' => 135.376164,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  35 => 
  array (
    'admin_code' => 28365,
    'name' => '兵庫県多可町',
    'lat' => 35.050315,
    'lon' => 134.923359,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  36 => 
  array (
    'admin_code' => 28381,
    'name' => '兵庫県稲美町',
    'lat' => 34.748627,
    'lon' => 134.913384,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  37 => 
  array (
    'admin_code' => 28382,
    'name' => '兵庫県播磨町',
    'lat' => 34.715302,
    'lon' => 134.867911,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  38 => 
  array (
    'admin_code' => 28442,
    'name' => '兵庫県市川町',
    'lat' => 34.989365,
    'lon' => 134.763289,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  39 => 
  array (
    'admin_code' => 28443,
    'name' => '兵庫県福崎町',
    'lat' => 34.950319,
    'lon' => 134.760245,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  40 => 
  array (
    'admin_code' => 28446,
    'name' => '兵庫県神河町',
    'lat' => 35.064235,
    'lon' => 134.739856,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  41 => 
  array (
    'admin_code' => 28464,
    'name' => '兵庫県太子町',
    'lat' => 34.833469,
    'lon' => 134.57781,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  42 => 
  array (
    'admin_code' => 28481,
    'name' => '兵庫県上郡町',
    'lat' => 34.873583,
    'lon' => 134.356098,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  43 => 
  array (
    'admin_code' => 28501,
    'name' => '兵庫県佐用町',
    'lat' => 35.004296,
    'lon' => 134.355771,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  44 => 
  array (
    'admin_code' => 28585,
    'name' => '兵庫県香美町',
    'lat' => 35.632169,
    'lon' => 134.629175,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  45 => 
  array (
    'admin_code' => 28586,
    'name' => '兵庫県新温泉町',
    'lat' => 35.623509,
    'lon' => 134.448942,
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
