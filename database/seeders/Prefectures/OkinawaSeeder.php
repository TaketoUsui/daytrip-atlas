<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 沖縄県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class OkinawaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array(
            0 =>
                array(
                    'admin_code' => '47201',
                    'name' => '沖縄県那覇市',
                    'lat' => 26.212295,
                    'lon' => 127.679218,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            1 =>
                array(
                    'admin_code' => '47205',
                    'name' => '沖縄県宜野湾市',
                    'lat' => 26.281581,
                    'lon' => 127.778637,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            2 =>
                array(
                    'admin_code' => '47207',
                    'name' => '沖縄県石垣市',
                    'lat' => 24.340666,
                    'lon' => 124.155539,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            3 =>
                array(
                    'admin_code' => '47208',
                    'name' => '沖縄県浦添市',
                    'lat' => 26.245816,
                    'lon' => 127.721804,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            4 =>
                array(
                    'admin_code' => '47209',
                    'name' => '沖縄県名護市',
                    'lat' => 26.591555,
                    'lon' => 127.977474,
                    'office_count' => 5,
                    'main_office_count' => 1,
                ),
            5 =>
                array(
                    'admin_code' => '47211',
                    'name' => '沖縄県沖縄市',
                    'lat' => 26.334354,
                    'lon' => 127.805694,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            6 =>
                array(
                    'admin_code' => '47212',
                    'name' => '沖縄県豊見城市',
                    'lat' => 26.161026,
                    'lon' => 127.668883,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            7 =>
                array(
                    'admin_code' => '47213',
                    'name' => '沖縄県うるま市',
                    'lat' => 26.379151,
                    'lon' => 127.85748,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            8 =>
                array(
                    'admin_code' => '47214',
                    'name' => '沖縄県宮古島市',
                    'lat' => 24.80549,
                    'lon' => 125.281162,
                    'office_count' => 6,
                    'main_office_count' => 1,
                ),
            9 =>
                array(
                    'admin_code' => '47215',
                    'name' => '沖縄県南城市',
                    'lat' => 26.144402,
                    'lon' => 127.766922,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            10 =>
                array(
                    'admin_code' => '47301',
                    'name' => '沖縄県国頭村',
                    'lat' => 26.745638,
                    'lon' => 128.177907,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            11 =>
                array(
                    'admin_code' => '47302',
                    'name' => '沖縄県大宜味村',
                    'lat' => 26.701712,
                    'lon' => 128.120159,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            12 =>
                array(
                    'admin_code' => '47303',
                    'name' => '沖縄県東村',
                    'lat' => 26.633284,
                    'lon' => 128.15687,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            13 =>
                array(
                    'admin_code' => '47306',
                    'name' => '沖縄県今帰仁村',
                    'lat' => 26.682527,
                    'lon' => 127.972739,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            14 =>
                array(
                    'admin_code' => '47308',
                    'name' => '沖縄県本部町',
                    'lat' => 26.658035,
                    'lon' => 127.898175,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            15 =>
                array(
                    'admin_code' => '47311',
                    'name' => '沖縄県恩納村',
                    'lat' => 26.497502,
                    'lon' => 127.85357,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            16 =>
                array(
                    'admin_code' => '47313',
                    'name' => '沖縄県宜野座村',
                    'lat' => 26.481585,
                    'lon' => 127.975615,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            17 =>
                array(
                    'admin_code' => '47314',
                    'name' => '沖縄県金武町',
                    'lat' => 26.456137,
                    'lon' => 127.926011,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            18 =>
                array(
                    'admin_code' => '47315',
                    'name' => '沖縄県伊江村',
                    'lat' => 26.71349,
                    'lon' => 127.807014,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            19 =>
                array(
                    'admin_code' => '47324',
                    'name' => '沖縄県読谷村',
                    'lat' => 26.396154,
                    'lon' => 127.744424,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            20 =>
                array(
                    'admin_code' => '47325',
                    'name' => '沖縄県嘉手納町',
                    'lat' => 26.361723,
                    'lon' => 127.75538,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            21 =>
                array(
                    'admin_code' => '47326',
                    'name' => '沖縄県北谷町',
                    'lat' => 26.320069,
                    'lon' => 127.763901,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            22 =>
                array(
                    'admin_code' => '47327',
                    'name' => '沖縄県北中城村',
                    'lat' => 26.301079,
                    'lon' => 127.793027,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            23 =>
                array(
                    'admin_code' => '47328',
                    'name' => '沖縄県中城村',
                    'lat' => 26.267379,
                    'lon' => 127.791146,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            24 =>
                array(
                    'admin_code' => '47329',
                    'name' => '沖縄県西原町',
                    'lat' => 26.222856,
                    'lon' => 127.758819,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            25 =>
                array(
                    'admin_code' => '47348',
                    'name' => '沖縄県与那原町',
                    'lat' => 26.199502,
                    'lon' => 127.754794,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            26 =>
                array(
                    'admin_code' => '47353',
                    'name' => '沖縄県渡嘉敷村',
                    'lat' => 26.197331,
                    'lon' => 127.364289,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            27 =>
                array(
                    'admin_code' => '47354',
                    'name' => '沖縄県座間味村',
                    'lat' => 26.228949,
                    'lon' => 127.303205,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            28 =>
                array(
                    'admin_code' => '47355',
                    'name' => '沖縄県粟国村',
                    'lat' => 26.582431,
                    'lon' => 127.226965,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            29 =>
                array(
                    'admin_code' => '47356',
                    'name' => '沖縄県渡名喜村',
                    'lat' => 26.37211,
                    'lon' => 127.141122,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            30 =>
                array(
                    'admin_code' => '47357',
                    'name' => '沖縄県南大東村',
                    'lat' => 25.828903,
                    'lon' => 131.231872,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            31 =>
                array(
                    'admin_code' => '47358',
                    'name' => '沖縄県北大東村',
                    'lat' => 25.945712,
                    'lon' => 131.298917,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            32 =>
                array(
                    'admin_code' => '47359',
                    'name' => '沖縄県伊平屋村',
                    'lat' => 27.039169,
                    'lon' => 127.96862,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            33 =>
                array(
                    'admin_code' => '47361',
                    'name' => '沖縄県久米島町',
                    'lat' => 26.340669,
                    'lon' => 126.805021,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            34 =>
                array(
                    'admin_code' => '47362',
                    'name' => '沖縄県八重瀬町',
                    'lat' => 26.121875,
                    'lon' => 127.742675,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            35 =>
                array(
                    'admin_code' => '47375',
                    'name' => '沖縄県多良間村',
                    'lat' => 24.669449,
                    'lon' => 124.701693,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            36 =>
                array(
                    'admin_code' => '47381',
                    'name' => '沖縄県竹富町',
                    'lat' => 24.339763,
                    'lon' => 124.154437,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            37 =>
                array(
                    'admin_code' => '47382',
                    'name' => '沖縄県与那国町',
                    'lat' => 24.468034,
                    'lon' => 123.004496,
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
