<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 三重県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class MieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = [
            0 => [
                'admin_code' => '24201',
                'name' => '三重県津市',
                'lat' => 34.718563,
                'lon' => 136.505443,
                'office_count' => 37,
                'main_office_count' => 1,
            ],
            1 => [
                'admin_code' => '24202',
                'name' => '三重県四日市市',
                'lat' => 34.965092,
                'lon' => 136.624427,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            2 => [
                'admin_code' => '24203',
                'name' => '三重県伊勢市',
                'lat' => 34.487506,
                'lon' => 136.709286,
                'office_count' => 13,
                'main_office_count' => 1,
            ],
            3 => [
                'admin_code' => '24204',
                'name' => '三重県松阪市',
                'lat' => 34.577974,
                'lon' => 136.527595,
                'office_count' => 11,
                'main_office_count' => 1,
            ],
            4 => [
                'admin_code' => '24205',
                'name' => '三重県桑名市',
                'lat' => 35.062288,
                'lon' => 136.683539,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            5 => [
                'admin_code' => '24207',
                'name' => '三重県鈴鹿市',
                'lat' => 34.881866,
                'lon' => 136.584185,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            6 => [
                'admin_code' => '24208',
                'name' => '三重県名張市',
                'lat' => 34.627662,
                'lon' => 136.108299,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            7 => [
                'admin_code' => '24209',
                'name' => '三重県尾鷲市',
                'lat' => 34.070799,
                'lon' => 136.190998,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            8 => [
                'admin_code' => '24211',
                'name' => '三重県鳥羽市',
                'lat' => 34.481432,
                'lon' => 136.843378,
                'office_count' => 9,
                'main_office_count' => 1,
            ],
            9 => [
                'admin_code' => '24212',
                'name' => '三重県熊野市',
                'lat' => 33.88862,
                'lon' => 136.100288,
                'office_count' => 10,
                'main_office_count' => 1,
            ],
            10 => [
                'admin_code' => '24214',
                'name' => '三重県いなべ市',
                'lat' => 35.115709,
                'lon' => 136.561379,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            11 => [
                'admin_code' => '24215',
                'name' => '三重県志摩市',
                'lat' => 34.328218,
                'lon' => 136.829655,
                'office_count' => 5,
                'main_office_count' => 1,
            ],
            12 => [
                'admin_code' => '24216',
                'name' => '三重県伊賀市',
                'lat' => 34.768829,
                'lon' => 136.129908,
                'office_count' => 6,
                'main_office_count' => 1,
            ],
            13 => [
                'admin_code' => '24303',
                'name' => '三重県木曽岬町',
                'lat' => 35.075958,
                'lon' => 136.731353,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            14 => [
                'admin_code' => '24324',
                'name' => '三重県東員町',
                'lat' => 35.074125,
                'lon' => 136.583756,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            15 => [
                'admin_code' => '24341',
                'name' => '三重県菰野町',
                'lat' => 35.020001,
                'lon' => 136.507346,
                'office_count' => 6,
                'main_office_count' => 1,
            ],
            16 => [
                'admin_code' => '24343',
                'name' => '三重県朝日町',
                'lat' => 35.034221,
                'lon' => 136.664366,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            17 => [
                'admin_code' => '24344',
                'name' => '三重県川越町',
                'lat' => 35.02295,
                'lon' => 136.673971,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            18 => [
                'admin_code' => '24441',
                'name' => '三重県多気町',
                'lat' => 34.496156,
                'lon' => 136.546149,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            19 => [
                'admin_code' => '24442',
                'name' => '三重県明和町',
                'lat' => 34.547528,
                'lon' => 136.623251,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            20 => [
                'admin_code' => '24443',
                'name' => '三重県大台町',
                'lat' => 34.39337,
                'lon' => 136.407876,
                'office_count' => 6,
                'main_office_count' => 1,
            ],
            21 => [
                'admin_code' => '24461',
                'name' => '三重県玉城町',
                'lat' => 34.490276,
                'lon' => 136.630932,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            22 => [
                'admin_code' => '24471',
                'name' => '三重県大紀町',
                'lat' => 34.358023,
                'lon' => 136.415798,
                'office_count' => 5,
                'main_office_count' => 1,
            ],
            23 => [
                'admin_code' => '24472',
                'name' => '三重県南伊勢町',
                'lat' => 34.352059,
                'lon' => 136.70365,
                'office_count' => 6,
                'main_office_count' => 1,
            ],
            24 => [
                'admin_code' => '24543',
                'name' => '三重県紀北町',
                'lat' => 34.211199,
                'lon' => 136.336852,
                'office_count' => 7,
                'main_office_count' => 1,
            ],
            25 => [
                'admin_code' => '24561',
                'name' => '三重県御浜町',
                'lat' => 33.814505,
                'lon' => 136.048677,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            26 => [
                'admin_code' => '24562',
                'name' => '三重県紀宝町',
                'lat' => 33.73387,
                'lon' => 136.009715,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
        ];

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
