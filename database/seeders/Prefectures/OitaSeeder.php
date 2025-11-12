<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 大分県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class OitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = [
            0 => [
                'admin_code' => '44201',
                'name' => '大分県大分市',
                'lat' => 33.239526,
                'lon' => 131.609377,
                'office_count' => 12,
                'main_office_count' => 1,
            ],
            1 => [
                'admin_code' => '44202',
                'name' => '大分県別府市',
                'lat' => 33.284642,
                'lon' => 131.491328,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            2 => [
                'admin_code' => '44203',
                'name' => '大分県中津市',
                'lat' => 33.598302,
                'lon' => 131.18824,
                'office_count' => 5,
                'main_office_count' => 1,
            ],
            3 => [
                'admin_code' => '44204',
                'name' => '大分県日田市',
                'lat' => 33.321041,
                'lon' => 130.94131,
                'office_count' => 8,
                'main_office_count' => 1,
            ],
            4 => [
                'admin_code' => '44205',
                'name' => '大分県佐伯市',
                'lat' => 32.960204,
                'lon' => 131.899499,
                'office_count' => 15,
                'main_office_count' => 1,
            ],
            5 => [
                'admin_code' => '44206',
                'name' => '大分県臼杵市',
                'lat' => 33.125948,
                'lon' => 131.804638,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            6 => [
                'admin_code' => '44207',
                'name' => '大分県津久見市',
                'lat' => 33.072339,
                'lon' => 131.861219,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            7 => [
                'admin_code' => '44208',
                'name' => '大分県竹田市',
                'lat' => 32.973673,
                'lon' => 131.397838,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            8 => [
                'admin_code' => '44209',
                'name' => '大分県豊後高田市',
                'lat' => 33.557257,
                'lon' => 131.444697,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            9 => [
                'admin_code' => '44211',
                'name' => '大分県宇佐市',
                'lat' => 33.531972,
                'lon' => 131.349545,
                'office_count' => 5,
                'main_office_count' => 1,
            ],
            10 => [
                'admin_code' => '44212',
                'name' => '大分県豊後大野市',
                'lat' => 32.978152,
                'lon' => 131.585011,
                'office_count' => 7,
                'main_office_count' => 1,
            ],
            11 => [
                'admin_code' => '44213',
                'name' => '大分県由布市',
                'lat' => 33.179996,
                'lon' => 131.426792,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            12 => [
                'admin_code' => '44214',
                'name' => '大分県国東市',
                'lat' => 33.565302,
                'lon' => 131.731676,
                'office_count' => 10,
                'main_office_count' => 1,
            ],
            13 => [
                'admin_code' => '44322',
                'name' => '大分県姫島村',
                'lat' => 33.724536,
                'lon' => 131.645143,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            14 => [
                'admin_code' => '44341',
                'name' => '大分県日出町',
                'lat' => 33.369442,
                'lon' => 131.532536,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            15 => [
                'admin_code' => '44461',
                'name' => '大分県九重町',
                'lat' => 33.228521,
                'lon' => 131.188797,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            16 => [
                'admin_code' => '44462',
                'name' => '大分県玖珠町',
                'lat' => 33.283135,
                'lon' => 131.151553,
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
