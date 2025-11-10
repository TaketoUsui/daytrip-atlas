<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 宮崎県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class MiyazakiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array(
            0 =>
                array(
                    'admin_code' => '45201',
                    'name' => '宮崎県宮崎市',
                    'lat' => 31.907676,
                    'lon' => 131.420244,
                    'office_count' => 14,
                    'main_office_count' => 1,
                ),
            1 =>
                array(
                    'admin_code' => '45202',
                    'name' => '宮崎県都城市',
                    'lat' => 31.719519,
                    'lon' => 131.061497,
                    'office_count' => 5,
                    'main_office_count' => 1,
                ),
            2 =>
                array(
                    'admin_code' => '45203',
                    'name' => '宮崎県延岡市',
                    'lat' => 32.582401,
                    'lon' => 131.664859,
                    'office_count' => 8,
                    'main_office_count' => 1,
                ),
            3 =>
                array(
                    'admin_code' => '45204',
                    'name' => '宮崎県日南市',
                    'lat' => 31.601932,
                    'lon' => 131.378731,
                    'office_count' => 9,
                    'main_office_count' => 1,
                ),
            4 =>
                array(
                    'admin_code' => '45205',
                    'name' => '宮崎県小林市',
                    'lat' => 31.996657,
                    'lon' => 130.972674,
                    'office_count' => 5,
                    'main_office_count' => 1,
                ),
            5 =>
                array(
                    'admin_code' => '45206',
                    'name' => '宮崎県日向市',
                    'lat' => 32.422947,
                    'lon' => 131.623962,
                    'office_count' => 5,
                    'main_office_count' => 1,
                ),
            6 =>
                array(
                    'admin_code' => '45207',
                    'name' => '宮崎県串間市',
                    'lat' => 31.464539,
                    'lon' => 131.228306,
                    'office_count' => 5,
                    'main_office_count' => 1,
                ),
            7 =>
                array(
                    'admin_code' => '45208',
                    'name' => '宮崎県西都市',
                    'lat' => 32.108562,
                    'lon' => 131.401266,
                    'office_count' => 6,
                    'main_office_count' => 1,
                ),
            8 =>
                array(
                    'admin_code' => '45209',
                    'name' => '宮崎県えびの市',
                    'lat' => 32.045347,
                    'lon' => 130.810841,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            9 =>
                array(
                    'admin_code' => '45341',
                    'name' => '宮崎県三股町',
                    'lat' => 31.730686,
                    'lon' => 131.12492,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            10 =>
                array(
                    'admin_code' => '45361',
                    'name' => '宮崎県高原町',
                    'lat' => 31.928413,
                    'lon' => 131.00787,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            11 =>
                array(
                    'admin_code' => '45382',
                    'name' => '宮崎県国富町',
                    'lat' => 31.990646,
                    'lon' => 131.323535,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            12 =>
                array(
                    'admin_code' => '45383',
                    'name' => '宮崎県綾町',
                    'lat' => 31.999135,
                    'lon' => 131.253182,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            13 =>
                array(
                    'admin_code' => '45401',
                    'name' => '宮崎県高鍋町',
                    'lat' => 32.12799,
                    'lon' => 131.503341,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            14 =>
                array(
                    'admin_code' => '45402',
                    'name' => '宮崎県新富町',
                    'lat' => 32.068937,
                    'lon' => 131.487984,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            15 =>
                array(
                    'admin_code' => '45403',
                    'name' => '宮崎県西米良村',
                    'lat' => 32.226354,
                    'lon' => 131.154452,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            16 =>
                array(
                    'admin_code' => '45404',
                    'name' => '宮崎県木城町',
                    'lat' => 32.163784,
                    'lon' => 131.473354,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            17 =>
                array(
                    'admin_code' => '45405',
                    'name' => '宮崎県川南町',
                    'lat' => 32.192009,
                    'lon' => 131.525816,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            18 =>
                array(
                    'admin_code' => '45406',
                    'name' => '宮崎県都農町',
                    'lat' => 32.256434,
                    'lon' => 131.55969,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            19 =>
                array(
                    'admin_code' => '45421',
                    'name' => '宮崎県門川町',
                    'lat' => 32.46979,
                    'lon' => 131.648722,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            20 =>
                array(
                    'admin_code' => '45429',
                    'name' => '宮崎県諸塚村',
                    'lat' => 32.512184,
                    'lon' => 131.330319,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            21 =>
                array(
                    'admin_code' => '45431',
                    'name' => '宮崎県美郷町',
                    'lat' => 32.440256,
                    'lon' => 131.423106,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            22 =>
                array(
                    'admin_code' => '45441',
                    'name' => '宮崎県高千穂町',
                    'lat' => 32.711651,
                    'lon' => 131.307871,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            23 =>
                array(
                    'admin_code' => '45442',
                    'name' => '宮崎県日之影町',
                    'lat' => 32.653825,
                    'lon' => 131.388112,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            24 =>
                array(
                    'admin_code' => '45443',
                    'name' => '宮崎県五ヶ瀬町',
                    'lat' => 32.682915,
                    'lon' => 131.196247,
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
