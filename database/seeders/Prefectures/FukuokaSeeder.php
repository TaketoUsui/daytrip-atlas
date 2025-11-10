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
        $clusters = array(
            0 =>
                array(
                    'admin_code' => '40230',
                    'name' => '福岡県糸島市',
                    'lat' => 33.55745,
                    'lon' => 130.1955,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            1 =>
                array(
                    'admin_code' => '40305',
                    'name' => '福岡県那珂川町',
                    'lat' => 33.499597,
                    'lon' => 130.4222,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            2 =>
                array(
                    'admin_code' => '40341',
                    'name' => '福岡県宇美町',
                    'lat' => 33.567768,
                    'lon' => 130.511208,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            3 =>
                array(
                    'admin_code' => '40342',
                    'name' => '福岡県篠栗町',
                    'lat' => 33.623869,
                    'lon' => 130.526207,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            4 =>
                array(
                    'admin_code' => '40343',
                    'name' => '福岡県志免町',
                    'lat' => 33.591503,
                    'lon' => 130.479807,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            5 =>
                array(
                    'admin_code' => '40344',
                    'name' => '福岡県須恵町',
                    'lat' => 33.587268,
                    'lon' => 130.507234,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            6 =>
                array(
                    'admin_code' => '40345',
                    'name' => '福岡県新宮町',
                    'lat' => 33.715313,
                    'lon' => 130.446567,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            7 =>
                array(
                    'admin_code' => '40348',
                    'name' => '福岡県久山町',
                    'lat' => 33.646726,
                    'lon' => 130.499906,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            8 =>
                array(
                    'admin_code' => '40349',
                    'name' => '福岡県粕屋町',
                    'lat' => 33.610854,
                    'lon' => 130.480582,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            9 =>
                array(
                    'admin_code' => '40381',
                    'name' => '福岡県芦屋町',
                    'lat' => 33.893862,
                    'lon' => 130.663874,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            10 =>
                array(
                    'admin_code' => '40382',
                    'name' => '福岡県水巻町',
                    'lat' => 33.85485,
                    'lon' => 130.694783,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            11 =>
                array(
                    'admin_code' => '40383',
                    'name' => '福岡県岡垣町',
                    'lat' => 33.853491,
                    'lon' => 130.611749,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            12 =>
                array(
                    'admin_code' => '40384',
                    'name' => '福岡県遠賀町',
                    'lat' => 33.848166,
                    'lon' => 130.668341,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            13 =>
                array(
                    'admin_code' => '40401',
                    'name' => '福岡県小竹町',
                    'lat' => 33.692418,
                    'lon' => 130.712691,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            14 =>
                array(
                    'admin_code' => '40402',
                    'name' => '福岡県鞍手町',
                    'lat' => 33.792112,
                    'lon' => 130.674008,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            15 =>
                array(
                    'admin_code' => '40421',
                    'name' => '福岡県桂川町',
                    'lat' => 33.578889,
                    'lon' => 130.678118,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            16 =>
                array(
                    'admin_code' => '40447',
                    'name' => '福岡県筑前町',
                    'lat' => 33.457033,
                    'lon' => 130.595183,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            17 =>
                array(
                    'admin_code' => '40448',
                    'name' => '福岡県東峰村',
                    'lat' => 33.397314,
                    'lon' => 130.869919,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            18 =>
                array(
                    'admin_code' => '40503',
                    'name' => '福岡県大刀洗町',
                    'lat' => 33.372425,
                    'lon' => 130.622454,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            19 =>
                array(
                    'admin_code' => '40522',
                    'name' => '福岡県大木町',
                    'lat' => 33.210453,
                    'lon' => 130.439806,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            20 =>
                array(
                    'admin_code' => '40544',
                    'name' => '福岡県広川町',
                    'lat' => 33.241499,
                    'lon' => 130.551416,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            21 =>
                array(
                    'admin_code' => '40601',
                    'name' => '福岡県香春町',
                    'lat' => 33.668006,
                    'lon' => 130.847401,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            22 =>
                array(
                    'admin_code' => '40602',
                    'name' => '福岡県添田町',
                    'lat' => 33.571816,
                    'lon' => 130.854088,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            23 =>
                array(
                    'admin_code' => '40604',
                    'name' => '福岡県糸田町',
                    'lat' => 33.652736,
                    'lon' => 130.778958,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            24 =>
                array(
                    'admin_code' => '40605',
                    'name' => '福岡県川崎町',
                    'lat' => 33.599956,
                    'lon' => 130.814915,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            25 =>
                array(
                    'admin_code' => '40608',
                    'name' => '福岡県大任町',
                    'lat' => 33.612164,
                    'lon' => 130.853742,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            26 =>
                array(
                    'admin_code' => '40609',
                    'name' => '福岡県赤村',
                    'lat' => 33.616692,
                    'lon' => 130.870855,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            27 =>
                array(
                    'admin_code' => '40610',
                    'name' => '福岡県福智町',
                    'lat' => 33.683263,
                    'lon' => 130.78012,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            28 =>
                array(
                    'admin_code' => '40621',
                    'name' => '福岡県苅田町',
                    'lat' => 33.776006,
                    'lon' => 130.980475,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            29 =>
                array(
                    'admin_code' => '40625',
                    'name' => '福岡県みやこ町',
                    'lat' => 33.699236,
                    'lon' => 130.920096,
                    'office_count' => 5,
                    'main_office_count' => 1,
                ),
            30 =>
                array(
                    'admin_code' => '40642',
                    'name' => '福岡県吉富町',
                    'lat' => 33.602643,
                    'lon' => 131.175951,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            31 =>
                array(
                    'admin_code' => '40646',
                    'name' => '福岡県上毛町',
                    'lat' => 33.578425,
                    'lon' => 131.164207,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            32 =>
                array(
                    'admin_code' => '40647',
                    'name' => '福岡県築上町',
                    'lat' => 33.656146,
                    'lon' => 131.05604,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            33 =>
                array(
                    'admin_code' => '40100',
                    'name' => '福岡県福岡市',
                    'lat' => 33.590313,
                    'lon' => 130.401735,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            34 =>
                array(
                    'admin_code' => '40130',
                    'name' => '福岡県北九州市',
                    'lat' => 33.883408,
                    'lon' => 130.875183,
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
