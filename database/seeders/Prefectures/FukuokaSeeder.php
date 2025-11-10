<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 福岡県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class FukuokaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array (
  0 => 
  array (
    'admin_code' => 40101,
    'name' => '福岡県北九州市門司区',
    'lat' => 33.941238,
    'lon' => 130.959546,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  1 => 
  array (
    'admin_code' => 40103,
    'name' => '福岡県北九州市若松区',
    'lat' => 33.905435,
    'lon' => 130.811221,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  2 => 
  array (
    'admin_code' => 40105,
    'name' => '福岡県北九州市戸畑区',
    'lat' => 33.893442,
    'lon' => 130.8298,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  3 => 
  array (
    'admin_code' => 40106,
    'name' => '福岡県北九州市小倉北区',
    'lat' => 33.88089,
    'lon' => 130.873361,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  4 => 
  array (
    'admin_code' => 40107,
    'name' => '福岡県北九州市小倉南区',
    'lat' => 33.846525,
    'lon' => 130.884808,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  5 => 
  array (
    'admin_code' => 40108,
    'name' => '福岡県北九州市八幡東区',
    'lat' => 33.86354,
    'lon' => 130.811892,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  6 => 
  array (
    'admin_code' => 40109,
    'name' => '福岡県北九州市八幡西区',
    'lat' => 33.866505,
    'lon' => 130.765167,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  7 => 
  array (
    'admin_code' => 40131,
    'name' => '福岡県福岡市東区',
    'lat' => 33.617744,
    'lon' => 130.417363,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  8 => 
  array (
    'admin_code' => 40132,
    'name' => '福岡県福岡市博多区',
    'lat' => 33.591505,
    'lon' => 130.414781,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  9 => 
  array (
    'admin_code' => 40133,
    'name' => '福岡県福岡市中央区',
    'lat' => 33.589238,
    'lon' => 130.392819,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  10 => 
  array (
    'admin_code' => 40134,
    'name' => '福岡県福岡市南区',
    'lat' => 33.561561,
    'lon' => 130.426442,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  11 => 
  array (
    'admin_code' => 40135,
    'name' => '福岡県福岡市西区',
    'lat' => 33.582917,
    'lon' => 130.323133,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  12 => 
  array (
    'admin_code' => 40136,
    'name' => '福岡県福岡市城南区',
    'lat' => 33.575686,
    'lon' => 130.369912,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  13 => 
  array (
    'admin_code' => 40137,
    'name' => '福岡県福岡市早良区',
    'lat' => 33.581944,
    'lon' => 130.348409,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  14 => 
  array (
    'admin_code' => 40202,
    'name' => '福岡県大牟田市',
    'lat' => 33.030248,
    'lon' => 130.446058,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  15 => 
  array (
    'admin_code' => 40203,
    'name' => '福岡県久留米市',
    'lat' => 33.319286,
    'lon' => 130.508371,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  16 => 
  array (
    'admin_code' => 40204,
    'name' => '福岡県直方市',
    'lat' => 33.744181,
    'lon' => 130.729652,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  17 => 
  array (
    'admin_code' => 40205,
    'name' => '福岡県飯塚市',
    'lat' => 33.646083,
    'lon' => 130.691422,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  18 => 
  array (
    'admin_code' => 40206,
    'name' => '福岡県田川市',
    'lat' => 33.63876,
    'lon' => 130.806298,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  19 => 
  array (
    'admin_code' => 40207,
    'name' => '福岡県柳川市',
    'lat' => 33.163064,
    'lon' => 130.405739,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  20 => 
  array (
    'admin_code' => 40211,
    'name' => '福岡県筑後市',
    'lat' => 33.212246,
    'lon' => 130.502151,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  21 => 
  array (
    'admin_code' => 40212,
    'name' => '福岡県大川市',
    'lat' => 33.206622,
    'lon' => 130.383922,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  22 => 
  array (
    'admin_code' => 40213,
    'name' => '福岡県行橋市',
    'lat' => 33.72876191,
    'lon' => 130.98296333,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  23 => 
  array (
    'admin_code' => 40214,
    'name' => '福岡県豊前市',
    'lat' => 33.611538,
    'lon' => 131.129941,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  24 => 
  array (
    'admin_code' => 40215,
    'name' => '福岡県中間市',
    'lat' => 33.816699,
    'lon' => 130.709026,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  25 => 
  array (
    'admin_code' => 40216,
    'name' => '福岡県小郡市',
    'lat' => 33.39645,
    'lon' => 130.555541,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  26 => 
  array (
    'admin_code' => 40217,
    'name' => '福岡県筑紫野市',
    'lat' => 33.496314,
    'lon' => 130.515594,
    'office_count' => 6,
    'main_office_count' => 1,
  ),
  27 => 
  array (
    'admin_code' => 40218,
    'name' => '福岡県春日市',
    'lat' => 33.532629,
    'lon' => 130.470368,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  28 => 
  array (
    'admin_code' => 40219,
    'name' => '福岡県大野城市',
    'lat' => 33.53629,
    'lon' => 130.478697,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  29 => 
  array (
    'admin_code' => 40221,
    'name' => '福岡県太宰府市',
    'lat' => 33.512835,
    'lon' => 130.523876,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  30 => 
  array (
    'admin_code' => 40223,
    'name' => '福岡県古賀市',
    'lat' => 33.728664,
    'lon' => 130.469995,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  31 => 
  array (
    'admin_code' => 40224,
    'name' => '福岡県福津市',
    'lat' => 33.766897,
    'lon' => 130.491038,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  32 => 
  array (
    'admin_code' => 40225,
    'name' => '福岡県うきは市',
    'lat' => 33.347305,
    'lon' => 130.754928,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  33 => 
  array (
    'admin_code' => 40226,
    'name' => '福岡県宮若市',
    'lat' => 33.723523,
    'lon' => 130.666716,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  34 => 
  array (
    'admin_code' => 40227,
    'name' => '福岡県嘉麻市',
    'lat' => 33.563283,
    'lon' => 130.71151,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  35 => 
  array (
    'admin_code' => 40228,
    'name' => '福岡県朝倉市',
    'lat' => 33.423412,
    'lon' => 130.665573,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  36 => 
  array (
    'admin_code' => 40229,
    'name' => '福岡県みやま市',
    'lat' => 33.152434,
    'lon' => 130.474734,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  37 => 
  array (
    'admin_code' => 40230,
    'name' => '福岡県糸島市',
    'lat' => 33.55745,
    'lon' => 130.1955,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  38 => 
  array (
    'admin_code' => 40305,
    'name' => '福岡県那珂川町',
    'lat' => 33.499597,
    'lon' => 130.4222,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  39 => 
  array (
    'admin_code' => 40341,
    'name' => '福岡県宇美町',
    'lat' => 33.567768,
    'lon' => 130.511208,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  40 => 
  array (
    'admin_code' => 40342,
    'name' => '福岡県篠栗町',
    'lat' => 33.623869,
    'lon' => 130.526207,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  41 => 
  array (
    'admin_code' => 40343,
    'name' => '福岡県志免町',
    'lat' => 33.591503,
    'lon' => 130.479807,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  42 => 
  array (
    'admin_code' => 40344,
    'name' => '福岡県須恵町',
    'lat' => 33.587268,
    'lon' => 130.507234,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  43 => 
  array (
    'admin_code' => 40345,
    'name' => '福岡県新宮町',
    'lat' => 33.715313,
    'lon' => 130.446567,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  44 => 
  array (
    'admin_code' => 40348,
    'name' => '福岡県久山町',
    'lat' => 33.646726,
    'lon' => 130.499906,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  45 => 
  array (
    'admin_code' => 40349,
    'name' => '福岡県粕屋町',
    'lat' => 33.610854,
    'lon' => 130.480582,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  46 => 
  array (
    'admin_code' => 40381,
    'name' => '福岡県芦屋町',
    'lat' => 33.893862,
    'lon' => 130.663874,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  47 => 
  array (
    'admin_code' => 40382,
    'name' => '福岡県水巻町',
    'lat' => 33.85485,
    'lon' => 130.694783,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  48 => 
  array (
    'admin_code' => 40383,
    'name' => '福岡県岡垣町',
    'lat' => 33.853491,
    'lon' => 130.611749,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  49 => 
  array (
    'admin_code' => 40384,
    'name' => '福岡県遠賀町',
    'lat' => 33.848166,
    'lon' => 130.668341,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  50 => 
  array (
    'admin_code' => 40401,
    'name' => '福岡県小竹町',
    'lat' => 33.692418,
    'lon' => 130.712691,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  51 => 
  array (
    'admin_code' => 40402,
    'name' => '福岡県鞍手町',
    'lat' => 33.792112,
    'lon' => 130.674008,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  52 => 
  array (
    'admin_code' => 40421,
    'name' => '福岡県桂川町',
    'lat' => 33.578889,
    'lon' => 130.678118,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  53 => 
  array (
    'admin_code' => 40447,
    'name' => '福岡県筑前町',
    'lat' => 33.457033,
    'lon' => 130.595183,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  54 => 
  array (
    'admin_code' => 40448,
    'name' => '福岡県東峰村',
    'lat' => 33.397314,
    'lon' => 130.869919,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  55 => 
  array (
    'admin_code' => 40503,
    'name' => '福岡県大刀洗町',
    'lat' => 33.372425,
    'lon' => 130.622454,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  56 => 
  array (
    'admin_code' => 40522,
    'name' => '福岡県大木町',
    'lat' => 33.210453,
    'lon' => 130.439806,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  57 => 
  array (
    'admin_code' => 40544,
    'name' => '福岡県広川町',
    'lat' => 33.241499,
    'lon' => 130.551416,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  58 => 
  array (
    'admin_code' => 40601,
    'name' => '福岡県香春町',
    'lat' => 33.668006,
    'lon' => 130.847401,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  59 => 
  array (
    'admin_code' => 40602,
    'name' => '福岡県添田町',
    'lat' => 33.571816,
    'lon' => 130.854088,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  60 => 
  array (
    'admin_code' => 40604,
    'name' => '福岡県糸田町',
    'lat' => 33.652736,
    'lon' => 130.778958,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  61 => 
  array (
    'admin_code' => 40605,
    'name' => '福岡県川崎町',
    'lat' => 33.599956,
    'lon' => 130.814915,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  62 => 
  array (
    'admin_code' => 40608,
    'name' => '福岡県大任町',
    'lat' => 33.612164,
    'lon' => 130.853742,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  63 => 
  array (
    'admin_code' => 40609,
    'name' => '福岡県赤村',
    'lat' => 33.616692,
    'lon' => 130.870855,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  64 => 
  array (
    'admin_code' => 40610,
    'name' => '福岡県福智町',
    'lat' => 33.683263,
    'lon' => 130.78012,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  65 => 
  array (
    'admin_code' => 40621,
    'name' => '福岡県苅田町',
    'lat' => 33.776006,
    'lon' => 130.980475,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  66 => 
  array (
    'admin_code' => 40625,
    'name' => '福岡県みやこ町',
    'lat' => 33.699236,
    'lon' => 130.920096,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  67 => 
  array (
    'admin_code' => 40642,
    'name' => '福岡県吉富町',
    'lat' => 33.602643,
    'lon' => 131.175951,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  68 => 
  array (
    'admin_code' => 40646,
    'name' => '福岡県上毛町',
    'lat' => 33.578425,
    'lon' => 131.164207,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  69 => 
  array (
    'admin_code' => 40647,
    'name' => '福岡県築上町',
    'lat' => 33.656146,
    'lon' => 131.05604,
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
