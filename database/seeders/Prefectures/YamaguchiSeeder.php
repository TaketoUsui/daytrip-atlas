<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 山口県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class YamaguchiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = [
            0 => [
                'admin_code' => '35201',
                'name' => '山口県下関市',
                'lat' => 33.957828,
                'lon' => 130.941459,
                'office_count' => 28,
                'main_office_count' => 1,
            ],
            1 => [
                'admin_code' => '35202',
                'name' => '山口県宇部市',
                'lat' => 33.951623,
                'lon' => 131.246761,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            2 => [
                'admin_code' => '35203',
                'name' => '山口県山口市',
                'lat' => 34.178178,
                'lon' => 131.473511,
                'office_count' => 6,
                'main_office_count' => 1,
            ],
            3 => [
                'admin_code' => '35204',
                'name' => '山口県萩市',
                'lat' => 34.408107,
                'lon' => 131.399104,
                'office_count' => 16,
                'main_office_count' => 1,
            ],
            4 => [
                'admin_code' => '35206',
                'name' => '山口県防府市',
                'lat' => 34.051756,
                'lon' => 131.562627,
                'office_count' => 11,
                'main_office_count' => 1,
            ],
            5 => [
                'admin_code' => '35207',
                'name' => '山口県下松市',
                'lat' => 34.015038,
                'lon' => 131.870317,
                'office_count' => 6,
                'main_office_count' => 1,
            ],
            6 => [
                'admin_code' => '35208',
                'name' => '山口県岩国市',
                'lat' => 34.1665,
                'lon' => 132.218942,
                'office_count' => 29,
                'main_office_count' => 1,
            ],
            7 => [
                'admin_code' => '35211',
                'name' => '山口県長門市',
                'lat' => 34.370959,
                'lon' => 131.182198,
                'office_count' => 9,
                'main_office_count' => 1,
            ],
            8 => [
                'admin_code' => '35212',
                'name' => '山口県柳井市',
                'lat' => 33.963839,
                'lon' => 132.101597,
                'office_count' => 10,
                'main_office_count' => 1,
            ],
            9 => [
                'admin_code' => '35213',
                'name' => '山口県美祢市',
                'lat' => 34.16667,
                'lon' => 131.205703,
                'office_count' => 12,
                'main_office_count' => 1,
            ],
            10 => [
                'admin_code' => '35215',
                'name' => '山口県周南市',
                'lat' => 34.055135,
                'lon' => 131.806293,
                'office_count' => 19,
                'main_office_count' => 1,
            ],
            11 => [
                'admin_code' => '35216',
                'name' => '山口県山陽小野田市',
                'lat' => 34.003089,
                'lon' => 131.181786,
                'office_count' => 6,
                'main_office_count' => 1,
            ],
            12 => [
                'admin_code' => '35305',
                'name' => '山口県周防大島町',
                'lat' => 33.927628,
                'lon' => 132.19532,
                'office_count' => 11,
                'main_office_count' => 1,
            ],
            13 => [
                'admin_code' => '35321',
                'name' => '山口県和木町',
                'lat' => 34.202408,
                'lon' => 132.220405,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            14 => [
                'admin_code' => '35341',
                'name' => '山口県上関町',
                'lat' => 33.831093,
                'lon' => 132.110772,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            15 => [
                'admin_code' => '35343',
                'name' => '山口県田布施町',
                'lat' => 33.954677,
                'lon' => 132.041366,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            16 => [
                'admin_code' => '35344',
                'name' => '山口県平生町',
                'lat' => 33.937969,
                'lon' => 132.073057,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            17 => [
                'admin_code' => '35502',
                'name' => '山口県阿武町',
                'lat' => 34.503352,
                'lon' => 131.47136,
                'office_count' => 3,
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
