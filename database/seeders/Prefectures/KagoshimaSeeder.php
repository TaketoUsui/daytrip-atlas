<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 鹿児島県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class KagoshimaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array (
  0 => 
  array (
    'admin_code' => 46201,
    'name' => '鹿児島県鹿児島市',
    'lat' => 31.596789,
    'lon' => 130.557339,
    'office_count' => 10,
    'main_office_count' => 1,
  ),
  1 => 
  array (
    'admin_code' => 46203,
    'name' => '鹿児島県鹿屋市',
    'lat' => 31.378268,
    'lon' => 130.852223,
    'office_count' => 9,
    'main_office_count' => 1,
  ),
  2 => 
  array (
    'admin_code' => 46204,
    'name' => '鹿児島県枕崎市',
    'lat' => 31.272922,
    'lon' => 130.296991,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  3 => 
  array (
    'admin_code' => 46206,
    'name' => '鹿児島県阿久根市',
    'lat' => 32.014364,
    'lon' => 130.192622,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  4 => 
  array (
    'admin_code' => 46208,
    'name' => '鹿児島県出水市',
    'lat' => 32.090458,
    'lon' => 130.352647,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  5 => 
  array (
    'admin_code' => 46213,
    'name' => '鹿児島県西之表市',
    'lat' => 30.732453,
    'lon' => 130.997035,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  6 => 
  array (
    'admin_code' => 46214,
    'name' => '鹿児島県垂水市',
    'lat' => 31.492758,
    'lon' => 130.70093,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  7 => 
  array (
    'admin_code' => 46215,
    'name' => '鹿児島県薩摩川内市',
    'lat' => 31.813486,
    'lon' => 130.30395,
    'office_count' => 12,
    'main_office_count' => 1,
  ),
  8 => 
  array (
    'admin_code' => 46216,
    'name' => '鹿児島県日置市',
    'lat' => 31.633709,
    'lon' => 130.402436,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  9 => 
  array (
    'admin_code' => 46217,
    'name' => '鹿児島県曽於市',
    'lat' => 31.653622,
    'lon' => 131.019255,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  10 => 
  array (
    'admin_code' => 46218,
    'name' => '鹿児島県霧島市',
    'lat' => 31.741015,
    'lon' => 130.763136,
    'office_count' => 7,
    'main_office_count' => 1,
  ),
  11 => 
  array (
    'admin_code' => 46219,
    'name' => '鹿児島県いちき串木野市',
    'lat' => 31.714542,
    'lon' => 130.271934,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  12 => 
  array (
    'admin_code' => 46221,
    'name' => '鹿児島県志布志市',
    'lat' => 31.495447,
    'lon' => 131.045349,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  13 => 
  array (
    'admin_code' => 46222,
    'name' => '鹿児島県奄美市',
    'lat' => 28.377273,
    'lon' => 129.49378,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  14 => 
  array (
    'admin_code' => 46223,
    'name' => '鹿児島県南九州市',
    'lat' => 31.378251,
    'lon' => 130.441623,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  15 => 
  array (
    'admin_code' => 46224,
    'name' => '鹿児島県伊佐市',
    'lat' => 32.057152,
    'lon' => 130.612934,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  16 => 
  array (
    'admin_code' => 46225,
    'name' => '鹿児島県姶良市',
    'lat' => 31.728213,
    'lon' => 130.627758,
    'office_count' => 7,
    'main_office_count' => 1,
  ),
  17 => 
  array (
    'admin_code' => 46303,
    'name' => '鹿児島県三島村',
    'lat' => 31.594533,
    'lon' => 130.560735,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  18 => 
  array (
    'admin_code' => 46304,
    'name' => '鹿児島県十島村',
    'lat' => 31.593157,
    'lon' => 130.560588,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  19 => 
  array (
    'admin_code' => 46392,
    'name' => '鹿児島県さつま町',
    'lat' => 31.906331,
    'lon' => 130.45534,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  20 => 
  array (
    'admin_code' => 46404,
    'name' => '鹿児島県長島町',
    'lat' => 32.19932,
    'lon' => 130.176919,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  21 => 
  array (
    'admin_code' => 46452,
    'name' => '鹿児島県湧水町',
    'lat' => 31.951654,
    'lon' => 130.721025,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  22 => 
  array (
    'admin_code' => 46468,
    'name' => '鹿児島県大崎町',
    'lat' => 31.429102,
    'lon' => 131.005592,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  23 => 
  array (
    'admin_code' => 46482,
    'name' => '鹿児島県東串良町',
    'lat' => 31.38579,
    'lon' => 130.973339,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  24 => 
  array (
    'admin_code' => 46491,
    'name' => '鹿児島県南大隅町',
    'lat' => 31.217205,
    'lon' => 130.768061,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  25 => 
  array (
    'admin_code' => 46492,
    'name' => '鹿児島県肝付町',
    'lat' => 31.344362,
    'lon' => 130.945223,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  26 => 
  array (
    'admin_code' => 46501,
    'name' => '鹿児島県中種子町',
    'lat' => 30.532821,
    'lon' => 130.958847,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  27 => 
  array (
    'admin_code' => 46502,
    'name' => '鹿児島県南種子町',
    'lat' => 30.413916,
    'lon' => 130.900867,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  28 => 
  array (
    'admin_code' => 46505,
    'name' => '鹿児島県屋久島町',
    'lat' => 30.371155,
    'lon' => 130.665043,
    'office_count' => 7,
    'main_office_count' => 1,
  ),
  29 => 
  array (
    'admin_code' => 46523,
    'name' => '鹿児島県大和村',
    'lat' => 28.358076,
    'lon' => 129.395262,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  30 => 
  array (
    'admin_code' => 46524,
    'name' => '鹿児島県宇検村',
    'lat' => 28.280773,
    'lon' => 129.297208,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  31 => 
  array (
    'admin_code' => 46525,
    'name' => '鹿児島県瀬戸内町',
    'lat' => 28.146484,
    'lon' => 129.314734,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  32 => 
  array (
    'admin_code' => 46527,
    'name' => '鹿児島県龍郷町',
    'lat' => 28.4133,
    'lon' => 129.589355,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  33 => 
  array (
    'admin_code' => 46529,
    'name' => '鹿児島県喜界町',
    'lat' => 28.316838,
    'lon' => 129.940035,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  34 => 
  array (
    'admin_code' => 46531,
    'name' => '鹿児島県天城町',
    'lat' => 27.81166,
    'lon' => 128.897749,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  35 => 
  array (
    'admin_code' => 46532,
    'name' => '鹿児島県伊仙町',
    'lat' => 27.673583,
    'lon' => 128.937584,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  36 => 
  array (
    'admin_code' => 46533,
    'name' => '鹿児島県和泊町',
    'lat' => 27.392559,
    'lon' => 128.655253,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  37 => 
  array (
    'admin_code' => 46534,
    'name' => '鹿児島県知名町',
    'lat' => 27.333676,
    'lon' => 128.573732,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  38 => 
  array (
    'admin_code' => 46535,
    'name' => '鹿児島県与論町',
    'lat' => 27.04853,
    'lon' => 128.414835,
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
