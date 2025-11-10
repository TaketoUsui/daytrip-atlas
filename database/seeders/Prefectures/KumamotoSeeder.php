<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 熊本県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class KumamotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array(
            0 =>
                array(
                    'admin_code' => '43202',
                    'name' => '熊本県八代市',
                    'lat' => 32.507412,
                    'lon' => 130.601888,
                    'office_count' => 8,
                    'main_office_count' => 1,
                ),
            1 =>
                array(
                    'admin_code' => '43203',
                    'name' => '熊本県人吉市',
                    'lat' => 32.210038,
                    'lon' => 130.762554,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            2 =>
                array(
                    'admin_code' => '43204',
                    'name' => '熊本県荒尾市',
                    'lat' => 32.986838,
                    'lon' => 130.433036,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            3 =>
                array(
                    'admin_code' => '43205',
                    'name' => '熊本県水俣市',
                    'lat' => 32.211883,
                    'lon' => 130.408725,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            4 =>
                array(
                    'admin_code' => '43206',
                    'name' => '熊本県玉名市',
                    'lat' => 32.928141,
                    'lon' => 130.559619,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            5 =>
                array(
                    'admin_code' => '43208',
                    'name' => '熊本県山鹿市',
                    'lat' => 33.016728,
                    'lon' => 130.691297,
                    'office_count' => 5,
                    'main_office_count' => 1,
                ),
            6 =>
                array(
                    'admin_code' => '43211',
                    'name' => '熊本県宇土市',
                    'lat' => 32.687292,
                    'lon' => 130.658562,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            7 =>
                array(
                    'admin_code' => '43212',
                    'name' => '熊本県上天草市',
                    'lat' => 32.587422,
                    'lon' => 130.430405,
                    'office_count' => 10,
                    'main_office_count' => 1,
                ),
            8 =>
                array(
                    'admin_code' => '43213',
                    'name' => '熊本県宇城市',
                    'lat' => 32.647814,
                    'lon' => 130.684287,
                    'office_count' => 6,
                    'main_office_count' => 1,
                ),
            9 =>
                array(
                    'admin_code' => '43214',
                    'name' => '熊本県阿蘇市',
                    'lat' => 32.951869,
                    'lon' => 131.121031,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            10 =>
                array(
                    'admin_code' => '43215',
                    'name' => '熊本県天草市',
                    'lat' => 32.458621,
                    'lon' => 130.19301,
                    'office_count' => 34,
                    'main_office_count' => 1,
                ),
            11 =>
                array(
                    'admin_code' => '43216',
                    'name' => '熊本県合志市',
                    'lat' => 32.885996,
                    'lon' => 130.789726,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            12 =>
                array(
                    'admin_code' => '43348',
                    'name' => '熊本県美里町',
                    'lat' => 32.639609,
                    'lon' => 130.789007,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            13 =>
                array(
                    'admin_code' => '43364',
                    'name' => '熊本県玉東町',
                    'lat' => 32.918905,
                    'lon' => 130.628593,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            14 =>
                array(
                    'admin_code' => '43367',
                    'name' => '熊本県南関町',
                    'lat' => 33.061599,
                    'lon' => 130.541126,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            15 =>
                array(
                    'admin_code' => '43368',
                    'name' => '熊本県長洲町',
                    'lat' => 32.929756,
                    'lon' => 130.4527,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            16 =>
                array(
                    'admin_code' => '43369',
                    'name' => '熊本県和水町',
                    'lat' => 32.978158,
                    'lon' => 130.605813,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            17 =>
                array(
                    'admin_code' => '43403',
                    'name' => '熊本県大津町',
                    'lat' => 32.87899,
                    'lon' => 130.868284,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            18 =>
                array(
                    'admin_code' => '43404',
                    'name' => '熊本県菊陽町',
                    'lat' => 32.862515,
                    'lon' => 130.828654,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            19 =>
                array(
                    'admin_code' => '43423',
                    'name' => '熊本県南小国町',
                    'lat' => 33.098192,
                    'lon' => 131.070724,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            20 =>
                array(
                    'admin_code' => '43424',
                    'name' => '熊本県小国町',
                    'lat' => 33.121568,
                    'lon' => 131.068157,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            21 =>
                array(
                    'admin_code' => '43425',
                    'name' => '熊本県産山村',
                    'lat' => 32.995747,
                    'lon' => 131.216799,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            22 =>
                array(
                    'admin_code' => '43428',
                    'name' => '熊本県高森町',
                    'lat' => 32.827271,
                    'lon' => 131.122023,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            23 =>
                array(
                    'admin_code' => '43432',
                    'name' => '熊本県西原村',
                    'lat' => 32.834719,
                    'lon' => 130.903036,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            24 =>
                array(
                    'admin_code' => '43433',
                    'name' => '熊本県南阿蘇村',
                    'lat' => 32.821978,
                    'lon' => 131.031444,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            25 =>
                array(
                    'admin_code' => '43441',
                    'name' => '熊本県御船町',
                    'lat' => 32.714585,
                    'lon' => 130.801821,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            26 =>
                array(
                    'admin_code' => '43442',
                    'name' => '熊本県嘉島町',
                    'lat' => 32.74007245,
                    'lon' => 130.75730338,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            27 =>
                array(
                    'admin_code' => '43443',
                    'name' => '熊本県益城町',
                    'lat' => 32.791397,
                    'lon' => 130.816418,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            28 =>
                array(
                    'admin_code' => '43444',
                    'name' => '熊本県甲佐町',
                    'lat' => 32.651356,
                    'lon' => 130.811466,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            29 =>
                array(
                    'admin_code' => '43447',
                    'name' => '熊本県山都町',
                    'lat' => 32.685795,
                    'lon' => 130.985998,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            30 =>
                array(
                    'admin_code' => '43468',
                    'name' => '熊本県氷川町',
                    'lat' => 32.582402,
                    'lon' => 130.673753,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            31 =>
                array(
                    'admin_code' => '43482',
                    'name' => '熊本県芦北町',
                    'lat' => 32.299102,
                    'lon' => 130.493119,
                    'office_count' => 5,
                    'main_office_count' => 1,
                ),
            32 =>
                array(
                    'admin_code' => '43484',
                    'name' => '熊本県津奈木町',
                    'lat' => 32.233892,
                    'lon' => 130.439621,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            33 =>
                array(
                    'admin_code' => '43501',
                    'name' => '熊本県錦町',
                    'lat' => 32.200987,
                    'lon' => 130.840902,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            34 =>
                array(
                    'admin_code' => '43505',
                    'name' => '熊本県多良木町',
                    'lat' => 32.264039,
                    'lon' => 130.935795,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            35 =>
                array(
                    'admin_code' => '43506',
                    'name' => '熊本県湯前町',
                    'lat' => 32.276144,
                    'lon' => 130.980987,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            36 =>
                array(
                    'admin_code' => '43507',
                    'name' => '熊本県水上村',
                    'lat' => 32.314379,
                    'lon' => 131.009541,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            37 =>
                array(
                    'admin_code' => '43511',
                    'name' => '熊本県五木村',
                    'lat' => 32.397343,
                    'lon' => 130.827833,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            38 =>
                array(
                    'admin_code' => '43512',
                    'name' => '熊本県山江村',
                    'lat' => 32.246465,
                    'lon' => 130.767136,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            39 =>
                array(
                    'admin_code' => '43513',
                    'name' => '熊本県球磨村',
                    'lat' => 32.252621,
                    'lon' => 130.651274,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            40 =>
                array(
                    'admin_code' => '43514',
                    'name' => '熊本県あさぎり町',
                    'lat' => 32.240321,
                    'lon' => 130.897827,
                    'office_count' => 5,
                    'main_office_count' => 1,
                ),
            41 =>
                array(
                    'admin_code' => '43531',
                    'name' => '熊本県苓北町',
                    'lat' => 32.513413,
                    'lon' => 130.05472,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            42 =>
                array(
                    'admin_code' => '43100',
                    'name' => '熊本県熊本市',
                    'lat' => 32.803078,
                    'lon' => 130.707897,
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
