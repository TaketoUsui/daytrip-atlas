<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 岡山県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class OkayamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = [
            0 => [
                'admin_code' => '33202',
                'name' => '岡山県倉敷市',
                'lat' => 34.584677,
                'lon' => 133.772281,
                'office_count' => 9,
                'main_office_count' => 1,
            ],
            1 => [
                'admin_code' => '33203',
                'name' => '岡山県津山市',
                'lat' => 35.069118,
                'lon' => 134.004543,
                'office_count' => 5,
                'main_office_count' => 1,
            ],
            2 => [
                'admin_code' => '33204',
                'name' => '岡山県玉野市',
                'lat' => 34.491979,
                'lon' => 133.946012,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            3 => [
                'admin_code' => '33205',
                'name' => '岡山県笠岡市',
                'lat' => 34.507182,
                'lon' => 133.507441,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            4 => [
                'admin_code' => '33207',
                'name' => '岡山県井原市',
                'lat' => 34.597709,
                'lon' => 133.463798,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            5 => [
                'admin_code' => '33208',
                'name' => '岡山県総社市',
                'lat' => 34.67281,
                'lon' => 133.746531,
                'office_count' => 6,
                'main_office_count' => 1,
            ],
            6 => [
                'admin_code' => '33209',
                'name' => '岡山県高梁市',
                'lat' => 34.791361,
                'lon' => 133.616678,
                'office_count' => 8,
                'main_office_count' => 1,
            ],
            7 => [
                'admin_code' => '33211',
                'name' => '岡山県備前市',
                'lat' => 34.745129,
                'lon' => 134.188137,
                'office_count' => 5,
                'main_office_count' => 1,
            ],
            8 => [
                'admin_code' => '33212',
                'name' => '岡山県瀬戸内市',
                'lat' => 34.664893,
                'lon' => 134.092849,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            9 => [
                'admin_code' => '33213',
                'name' => '岡山県赤磐市',
                'lat' => 34.755396,
                'lon' => 134.018848,
                'office_count' => 6,
                'main_office_count' => 1,
            ],
            10 => [
                'admin_code' => '33214',
                'name' => '岡山県真庭市',
                'lat' => 35.075591,
                'lon' => 133.752756,
                'office_count' => 8,
                'main_office_count' => 1,
            ],
            11 => [
                'admin_code' => '33215',
                'name' => '岡山県美作市',
                'lat' => 35.008594,
                'lon' => 134.148578,
                'office_count' => 8,
                'main_office_count' => 1,
            ],
            12 => [
                'admin_code' => '33216',
                'name' => '岡山県浅口市',
                'lat' => 34.527834,
                'lon' => 133.584911,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            13 => [
                'admin_code' => '33346',
                'name' => '岡山県和気町',
                'lat' => 34.802882,
                'lon' => 134.157539,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            14 => [
                'admin_code' => '33423',
                'name' => '岡山県早島町',
                'lat' => 34.600822,
                'lon' => 133.828304,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            15 => [
                'admin_code' => '33445',
                'name' => '岡山県里庄町',
                'lat' => 34.51374,
                'lon' => 133.556886,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            16 => [
                'admin_code' => '33461',
                'name' => '岡山県矢掛町',
                'lat' => 34.627596,
                'lon' => 133.587085,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            17 => [
                'admin_code' => '33586',
                'name' => '岡山県新庄村',
                'lat' => 35.179367,
                'lon' => 133.567638,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            18 => [
                'admin_code' => '33606',
                'name' => '岡山県鏡野町',
                'lat' => 35.091772,
                'lon' => 133.93303,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            19 => [
                'admin_code' => '33622',
                'name' => '岡山県勝央町',
                'lat' => 35.04179,
                'lon' => 134.116172,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            20 => [
                'admin_code' => '33623',
                'name' => '岡山県奈義町',
                'lat' => 35.123024,
                'lon' => 134.177427,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            21 => [
                'admin_code' => '33643',
                'name' => '岡山県西粟倉村',
                'lat' => 35.171331,
                'lon' => 134.336275,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            22 => [
                'admin_code' => '33663',
                'name' => '岡山県久米南町',
                'lat' => 34.929179,
                'lon' => 133.960647,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            23 => [
                'admin_code' => '33666',
                'name' => '岡山県美咲町',
                'lat' => 34.997967,
                'lon' => 133.958149,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            24 => [
                'admin_code' => '33681',
                'name' => '岡山県吉備中央町',
                'lat' => 34.863404,
                'lon' => 133.6935,
                'office_count' => 5,
                'main_office_count' => 1,
            ],
            25 => [
                'admin_code' => '33100',
                'name' => '岡山県岡山市',
                'lat' => 34.655107,
                'lon' => 133.919566,
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
