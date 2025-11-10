<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 滋賀県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class ShigaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array(
            0 =>
                array(
                    'admin_code' => '25201',
                    'name' => '滋賀県大津市',
                    'lat' => 35.018357,
                    'lon' => 135.854666,
                    'office_count' => 37,
                    'main_office_count' => 1,
                ),
            1 =>
                array(
                    'admin_code' => '25202',
                    'name' => '滋賀県彦根市',
                    'lat' => 35.274464,
                    'lon' => 136.259623,
                    'office_count' => 6,
                    'main_office_count' => 1,
                ),
            2 =>
                array(
                    'admin_code' => '25203',
                    'name' => '滋賀県長浜市',
                    'lat' => 35.381447,
                    'lon' => 136.275444,
                    'office_count' => 8,
                    'main_office_count' => 1,
                ),
            3 =>
                array(
                    'admin_code' => '25204',
                    'name' => '滋賀県近江八幡市',
                    'lat' => 35.128214,
                    'lon' => 136.097846,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            4 =>
                array(
                    'admin_code' => '25206',
                    'name' => '滋賀県草津市',
                    'lat' => 35.013123,
                    'lon' => 135.959994,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            5 =>
                array(
                    'admin_code' => '25207',
                    'name' => '滋賀県守山市',
                    'lat' => 35.058663,
                    'lon' => 135.99402,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            6 =>
                array(
                    'admin_code' => '25208',
                    'name' => '滋賀県栗東市',
                    'lat' => 35.021614,
                    'lon' => 135.997993,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            7 =>
                array(
                    'admin_code' => '25209',
                    'name' => '滋賀県甲賀市',
                    'lat' => 34.96612,
                    'lon' => 136.167084,
                    'office_count' => 5,
                    'main_office_count' => 1,
                ),
            8 =>
                array(
                    'admin_code' => '25212',
                    'name' => '滋賀県高島市',
                    'lat' => 35.353052,
                    'lon' => 136.035785,
                    'office_count' => 6,
                    'main_office_count' => 1,
                ),
            9 =>
                array(
                    'admin_code' => '25213',
                    'name' => '滋賀県東近江市',
                    'lat' => 35.112603,
                    'lon' => 136.20762,
                    'office_count' => 8,
                    'main_office_count' => 1,
                ),
            10 =>
                array(
                    'admin_code' => '25214',
                    'name' => '滋賀県米原市',
                    'lat' => 35.315355,
                    'lon' => 136.284013,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            11 =>
                array(
                    'admin_code' => '25383',
                    'name' => '滋賀県日野町',
                    'lat' => 35.018018,
                    'lon' => 136.246023,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            12 =>
                array(
                    'admin_code' => '25384',
                    'name' => '滋賀県竜王町',
                    'lat' => 35.06075,
                    'lon' => 136.124438,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            13 =>
                array(
                    'admin_code' => '25425',
                    'name' => '滋賀県愛荘町',
                    'lat' => 35.168834,
                    'lon' => 136.212306,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            14 =>
                array(
                    'admin_code' => '25441',
                    'name' => '滋賀県豊郷町',
                    'lat' => 35.200382,
                    'lon' => 136.229974,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            15 =>
                array(
                    'admin_code' => '25442',
                    'name' => '滋賀県甲良町',
                    'lat' => 35.204224,
                    'lon' => 136.26135,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            16 =>
                array(
                    'admin_code' => '25443',
                    'name' => '滋賀県多賀町',
                    'lat' => 35.222035,
                    'lon' => 136.292199,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            17 =>
                array(
                    'admin_code' => '25211',
                    'name' => '滋賀県湖南市',
                    'lat' => 35.004106,
                    'lon' => 136.084693,
                    'office_count' => 8,
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
