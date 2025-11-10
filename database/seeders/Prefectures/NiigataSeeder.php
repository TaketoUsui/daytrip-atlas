<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 新潟県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class NiigataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array(
            0 =>
                array(
                    'admin_code' => '15202',
                    'name' => '新潟県長岡市',
                    'lat' => 37.446587,
                    'lon' => 138.851224,
                    'office_count' => 12,
                    'main_office_count' => 1,
                ),
            1 =>
                array(
                    'admin_code' => '15204',
                    'name' => '新潟県三条市',
                    'lat' => 37.636768,
                    'lon' => 138.9617,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            2 =>
                array(
                    'admin_code' => '15205',
                    'name' => '新潟県柏崎市',
                    'lat' => 37.371968,
                    'lon' => 138.558835,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            3 =>
                array(
                    'admin_code' => '15206',
                    'name' => '新潟県新発田市',
                    'lat' => 37.950883,
                    'lon' => 139.327898,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            4 =>
                array(
                    'admin_code' => '15208',
                    'name' => '新潟県小千谷市',
                    'lat' => 37.31435,
                    'lon' => 138.795097,
                    'office_count' => 6,
                    'main_office_count' => 1,
                ),
            5 =>
                array(
                    'admin_code' => '15209',
                    'name' => '新潟県加茂市',
                    'lat' => 37.666335,
                    'lon' => 139.04022,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            6 =>
                array(
                    'admin_code' => '15211',
                    'name' => '新潟県見附市',
                    'lat' => 37.531496,
                    'lon' => 138.912724,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            7 =>
                array(
                    'admin_code' => '15212',
                    'name' => '新潟県村上市',
                    'lat' => 38.22399,
                    'lon' => 139.48004,
                    'office_count' => 7,
                    'main_office_count' => 1,
                ),
            8 =>
                array(
                    'admin_code' => '15213',
                    'name' => '新潟県燕市',
                    'lat' => 37.673149,
                    'lon' => 138.882249,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            9 =>
                array(
                    'admin_code' => '15216',
                    'name' => '新潟県糸魚川市',
                    'lat' => 37.039025,
                    'lon' => 137.862658,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            10 =>
                array(
                    'admin_code' => '15217',
                    'name' => '新潟県妙高市',
                    'lat' => 37.025265,
                    'lon' => 138.253485,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            11 =>
                array(
                    'admin_code' => '15218',
                    'name' => '新潟県五泉市',
                    'lat' => 37.744483,
                    'lon' => 139.182568,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            12 =>
                array(
                    'admin_code' => '15222',
                    'name' => '新潟県上越市',
                    'lat' => 37.147873,
                    'lon' => 138.236039,
                    'office_count' => 16,
                    'main_office_count' => 1,
                ),
            13 =>
                array(
                    'admin_code' => '15223',
                    'name' => '新潟県阿賀野市',
                    'lat' => 37.834509,
                    'lon' => 139.226002,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            14 =>
                array(
                    'admin_code' => '15224',
                    'name' => '新潟県佐渡市',
                    'lat' => 38.018302,
                    'lon' => 138.368138,
                    'office_count' => 8,
                    'main_office_count' => 1,
                ),
            15 =>
                array(
                    'admin_code' => '15225',
                    'name' => '新潟県魚沼市',
                    'lat' => 37.230103,
                    'lon' => 138.961434,
                    'office_count' => 6,
                    'main_office_count' => 1,
                ),
            16 =>
                array(
                    'admin_code' => '15226',
                    'name' => '新潟県南魚沼市',
                    'lat' => 37.065522,
                    'lon' => 138.876081,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            17 =>
                array(
                    'admin_code' => '15227',
                    'name' => '新潟県胎内市',
                    'lat' => 38.059708,
                    'lon' => 139.41035,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            18 =>
                array(
                    'admin_code' => '15307',
                    'name' => '新潟県聖籠町',
                    'lat' => 37.974526,
                    'lon' => 139.274374,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            19 =>
                array(
                    'admin_code' => '15342',
                    'name' => '新潟県弥彦村',
                    'lat' => 37.691007,
                    'lon' => 138.855252,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            20 =>
                array(
                    'admin_code' => '15361',
                    'name' => '新潟県田上町',
                    'lat' => 37.698857,
                    'lon' => 139.057993,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            21 =>
                array(
                    'admin_code' => '15385',
                    'name' => '新潟県阿賀町',
                    'lat' => 37.675487,
                    'lon' => 139.458781,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            22 =>
                array(
                    'admin_code' => '15405',
                    'name' => '新潟県出雲崎町',
                    'lat' => 37.530715,
                    'lon' => 138.709361,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            23 =>
                array(
                    'admin_code' => '15461',
                    'name' => '新潟県湯沢町',
                    'lat' => 36.934007,
                    'lon' => 138.817424,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            24 =>
                array(
                    'admin_code' => '15482',
                    'name' => '新潟県津南町',
                    'lat' => 37.014313,
                    'lon' => 138.652547,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            25 =>
                array(
                    'admin_code' => '15504',
                    'name' => '新潟県刈羽村',
                    'lat' => 37.422361,
                    'lon' => 138.622442,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            26 =>
                array(
                    'admin_code' => '15581',
                    'name' => '新潟県関川村',
                    'lat' => 38.089412,
                    'lon' => 139.564957,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            27 =>
                array(
                    'admin_code' => '15586',
                    'name' => '新潟県粟島浦村',
                    'lat' => 38.468213,
                    'lon' => 139.25436,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            28 =>
                array(
                    'admin_code' => '15100',
                    'name' => '新潟県新潟市',
                    'lat' => 37.916128,
                    'lon' => 139.036402,
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
