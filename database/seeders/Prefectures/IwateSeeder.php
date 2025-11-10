<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 岩手県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class IwateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array(
            0 =>
                array(
                    'admin_code' => '03201',
                    'name' => '岩手県盛岡市',
                    'lat' => 39.701795,
                    'lon' => 141.154183,
                    'office_count' => 13,
                    'main_office_count' => 1,
                ),
            1 =>
                array(
                    'admin_code' => '03202',
                    'name' => '岩手県宮古市',
                    'lat' => 39.641456,
                    'lon' => 141.957095,
                    'office_count' => 11,
                    'main_office_count' => 1,
                ),
            2 =>
                array(
                    'admin_code' => '03203',
                    'name' => '岩手県大船渡市',
                    'lat' => 39.081901,
                    'lon' => 141.708547,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            3 =>
                array(
                    'admin_code' => '03205',
                    'name' => '岩手県花巻市',
                    'lat' => 39.388609,
                    'lon' => 141.116854,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            4 =>
                array(
                    'admin_code' => '03206',
                    'name' => '岩手県北上市',
                    'lat' => 39.286817,
                    'lon' => 141.113157,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            5 =>
                array(
                    'admin_code' => '03207',
                    'name' => '岩手県久慈市',
                    'lat' => 40.190466,
                    'lon' => 141.775644,
                    'office_count' => 5,
                    'main_office_count' => 1,
                ),
            6 =>
                array(
                    'admin_code' => '03208',
                    'name' => '岩手県遠野市',
                    'lat' => 39.327657,
                    'lon' => 141.533538,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            7 =>
                array(
                    'admin_code' => '03209',
                    'name' => '岩手県一関市',
                    'lat' => 38.934754,
                    'lon' => 141.126759,
                    'office_count' => 15,
                    'main_office_count' => 1,
                ),
            8 =>
                array(
                    'admin_code' => '03211',
                    'name' => '岩手県釜石市',
                    'lat' => 39.27581,
                    'lon' => 141.885716,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            9 =>
                array(
                    'admin_code' => '03213',
                    'name' => '岩手県二戸市',
                    'lat' => 40.271193,
                    'lon' => 141.304805,
                    'office_count' => 7,
                    'main_office_count' => 1,
                ),
            10 =>
                array(
                    'admin_code' => '03214',
                    'name' => '岩手県八幡平市',
                    'lat' => 39.956511,
                    'lon' => 141.07112,
                    'office_count' => 5,
                    'main_office_count' => 1,
                ),
            11 =>
                array(
                    'admin_code' => '03215',
                    'name' => '岩手県奥州市',
                    'lat' => 39.144506,
                    'lon' => 141.139116,
                    'office_count' => 5,
                    'main_office_count' => 1,
                ),
            12 =>
                array(
                    'admin_code' => '03301',
                    'name' => '岩手県雫石町',
                    'lat' => 39.696319,
                    'lon' => 140.975779,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            13 =>
                array(
                    'admin_code' => '03302',
                    'name' => '岩手県葛巻町',
                    'lat' => 40.03984,
                    'lon' => 141.436719,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            14 =>
                array(
                    'admin_code' => '03303',
                    'name' => '岩手県岩手町',
                    'lat' => 39.972768,
                    'lon' => 141.212166,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            15 =>
                array(
                    'admin_code' => '03216',
                    'name' => '岩手県滝沢市',
                    'lat' => 39.734739,
                    'lon' => 141.077065,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            16 =>
                array(
                    'admin_code' => '03321',
                    'name' => '岩手県紫波町',
                    'lat' => 39.554854,
                    'lon' => 141.167821,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            17 =>
                array(
                    'admin_code' => '03322',
                    'name' => '岩手県矢巾町',
                    'lat' => 39.606006,
                    'lon' => 141.143001,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            18 =>
                array(
                    'admin_code' => '03366',
                    'name' => '岩手県西和賀町',
                    'lat' => 39.317906,
                    'lon' => 140.778754,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            19 =>
                array(
                    'admin_code' => '03381',
                    'name' => '岩手県金ケ崎町',
                    'lat' => 39.195687,
                    'lon' => 141.116408,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            20 =>
                array(
                    'admin_code' => '03402',
                    'name' => '岩手県平泉町',
                    'lat' => 38.986781,
                    'lon' => 141.11398,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            21 =>
                array(
                    'admin_code' => '03441',
                    'name' => '岩手県住田町',
                    'lat' => 39.141905,
                    'lon' => 141.576053,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            22 =>
                array(
                    'admin_code' => '03461',
                    'name' => '岩手県大槌町',
                    'lat' => 39.358196,
                    'lon' => 141.899731,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            23 =>
                array(
                    'admin_code' => '03482',
                    'name' => '岩手県山田町',
                    'lat' => 39.467619,
                    'lon' => 141.948923,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            24 =>
                array(
                    'admin_code' => '03483',
                    'name' => '岩手県岩泉町',
                    'lat' => 39.843204,
                    'lon' => 141.796675,
                    'office_count' => 6,
                    'main_office_count' => 1,
                ),
            25 =>
                array(
                    'admin_code' => '03484',
                    'name' => '岩手県田野畑村',
                    'lat' => 39.930454,
                    'lon' => 141.888864,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            26 =>
                array(
                    'admin_code' => '03485',
                    'name' => '岩手県普代村',
                    'lat' => 40.005164,
                    'lon' => 141.886014,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            27 =>
                array(
                    'admin_code' => '03501',
                    'name' => '岩手県軽米町',
                    'lat' => 40.326678,
                    'lon' => 141.460349,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            28 =>
                array(
                    'admin_code' => '03503',
                    'name' => '岩手県野田村',
                    'lat' => 40.110272,
                    'lon' => 141.817674,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            29 =>
                array(
                    'admin_code' => '03506',
                    'name' => '岩手県九戸村',
                    'lat' => 40.211356,
                    'lon' => 141.418982,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            30 =>
                array(
                    'admin_code' => '03507',
                    'name' => '岩手県洋野町',
                    'lat' => 40.408298,
                    'lon' => 141.71865,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            31 =>
                array(
                    'admin_code' => '03524',
                    'name' => '岩手県一戸町',
                    'lat' => 40.212733,
                    'lon' => 141.29546,
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
