<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 埼玉県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class SaitamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array(
            0 =>
                array(
                    'admin_code' => '11201',
                    'name' => '埼玉県川越市',
                    'lat' => 35.925112,
                    'lon' => 139.48584,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            1 =>
                array(
                    'admin_code' => '11202',
                    'name' => '埼玉県熊谷市',
                    'lat' => 36.147362,
                    'lon' => 139.388664,
                    'office_count' => 16,
                    'main_office_count' => 1,
                ),
            2 =>
                array(
                    'admin_code' => '11203',
                    'name' => '埼玉県川口市',
                    'lat' => 35.807741,
                    'lon' => 139.724171,
                    'office_count' => 8,
                    'main_office_count' => 1,
                ),
            3 =>
                array(
                    'admin_code' => '11206',
                    'name' => '埼玉県行田市',
                    'lat' => 36.138951,
                    'lon' => 139.455646,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            4 =>
                array(
                    'admin_code' => '11207',
                    'name' => '埼玉県秩父市',
                    'lat' => 35.991681,
                    'lon' => 139.085475,
                    'office_count' => 11,
                    'main_office_count' => 1,
                ),
            5 =>
                array(
                    'admin_code' => '11208',
                    'name' => '埼玉県所沢市',
                    'lat' => 35.799672,
                    'lon' => 139.468613,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            6 =>
                array(
                    'admin_code' => '11209',
                    'name' => '埼玉県飯能市',
                    'lat' => 35.85576,
                    'lon' => 139.327791,
                    'office_count' => 14,
                    'main_office_count' => 1,
                ),
            7 =>
                array(
                    'admin_code' => '11211',
                    'name' => '埼玉県本庄市',
                    'lat' => 36.243329,
                    'lon' => 139.190629,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            8 =>
                array(
                    'admin_code' => '11212',
                    'name' => '埼玉県東松山市',
                    'lat' => 36.042162,
                    'lon' => 139.39995,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            9 =>
                array(
                    'admin_code' => '11214',
                    'name' => '埼玉県春日部市',
                    'lat' => 35.975305,
                    'lon' => 139.752409,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            10 =>
                array(
                    'admin_code' => '11215',
                    'name' => '埼玉県狭山市',
                    'lat' => 35.852907,
                    'lon' => 139.412227,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            11 =>
                array(
                    'admin_code' => '11216',
                    'name' => '埼玉県羽生市',
                    'lat' => 36.172667,
                    'lon' => 139.548592,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            12 =>
                array(
                    'admin_code' => '11217',
                    'name' => '埼玉県鴻巣市',
                    'lat' => 36.065758,
                    'lon' => 139.522172,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            13 =>
                array(
                    'admin_code' => '11218',
                    'name' => '埼玉県深谷市',
                    'lat' => 36.197466,
                    'lon' => 139.28147,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            14 =>
                array(
                    'admin_code' => '11219',
                    'name' => '埼玉県上尾市',
                    'lat' => 35.977408,
                    'lon' => 139.593203,
                    'office_count' => 8,
                    'main_office_count' => 1,
                ),
            15 =>
                array(
                    'admin_code' => '11221',
                    'name' => '埼玉県草加市',
                    'lat' => 35.825371,
                    'lon' => 139.805327,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            16 =>
                array(
                    'admin_code' => '11222',
                    'name' => '埼玉県越谷市',
                    'lat' => 35.891087,
                    'lon' => 139.790943,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            17 =>
                array(
                    'admin_code' => '11223',
                    'name' => '埼玉県蕨市',
                    'lat' => 35.825576,
                    'lon' => 139.679758,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            18 =>
                array(
                    'admin_code' => '11224',
                    'name' => '埼玉県戸田市',
                    'lat' => 35.817635,
                    'lon' => 139.677931,
                    'office_count' => 5,
                    'main_office_count' => 1,
                ),
            19 =>
                array(
                    'admin_code' => '11225',
                    'name' => '埼玉県入間市',
                    'lat' => 35.835769,
                    'lon' => 139.391058,
                    'office_count' => 8,
                    'main_office_count' => 1,
                ),
            20 =>
                array(
                    'admin_code' => '11227',
                    'name' => '埼玉県朝霞市',
                    'lat' => 35.797255,
                    'lon' => 139.593919,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            21 =>
                array(
                    'admin_code' => '11228',
                    'name' => '埼玉県志木市',
                    'lat' => 35.836614,
                    'lon' => 139.58023,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            22 =>
                array(
                    'admin_code' => '11229',
                    'name' => '埼玉県和光市',
                    'lat' => 35.781104,
                    'lon' => 139.605693,
                    'office_count' => 5,
                    'main_office_count' => 1,
                ),
            23 =>
                array(
                    'admin_code' => '11231',
                    'name' => '埼玉県桶川市',
                    'lat' => 36.002966,
                    'lon' => 139.558177,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            24 =>
                array(
                    'admin_code' => '11232',
                    'name' => '埼玉県久喜市',
                    'lat' => 36.062059,
                    'lon' => 139.666838,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            25 =>
                array(
                    'admin_code' => '11233',
                    'name' => '埼玉県北本市',
                    'lat' => 36.027026,
                    'lon' => 139.53024,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            26 =>
                array(
                    'admin_code' => '11234',
                    'name' => '埼玉県八潮市',
                    'lat' => 35.822539,
                    'lon' => 139.839175,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            27 =>
                array(
                    'admin_code' => '11235',
                    'name' => '埼玉県富士見市',
                    'lat' => 35.856759,
                    'lon' => 139.549074,
                    'office_count' => 7,
                    'main_office_count' => 1,
                ),
            28 =>
                array(
                    'admin_code' => '11237',
                    'name' => '埼玉県三郷市',
                    'lat' => 35.830132,
                    'lon' => 139.872247,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            29 =>
                array(
                    'admin_code' => '11238',
                    'name' => '埼玉県蓮田市',
                    'lat' => 35.994504,
                    'lon' => 139.6622,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            30 =>
                array(
                    'admin_code' => '11239',
                    'name' => '埼玉県坂戸市',
                    'lat' => 35.957262,
                    'lon' => 139.402983,
                    'office_count' => 8,
                    'main_office_count' => 1,
                ),
            31 =>
                array(
                    'admin_code' => '11241',
                    'name' => '埼玉県鶴ヶ島市',
                    'lat' => 35.934523,
                    'lon' => 139.393126,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            32 =>
                array(
                    'admin_code' => '11242',
                    'name' => '埼玉県日高市',
                    'lat' => 35.907748,
                    'lon' => 139.33914,
                    'office_count' => 5,
                    'main_office_count' => 1,
                ),
            33 =>
                array(
                    'admin_code' => '11243',
                    'name' => '埼玉県吉川市',
                    'lat' => 35.891124,
                    'lon' => 139.841328,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            34 =>
                array(
                    'admin_code' => '11245',
                    'name' => '埼玉県ふじみ野市',
                    'lat' => 35.879396,
                    'lon' => 139.51982,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            35 =>
                array(
                    'admin_code' => '11301',
                    'name' => '埼玉県伊奈町',
                    'lat' => 35.999865,
                    'lon' => 139.623877,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            36 =>
                array(
                    'admin_code' => '11324',
                    'name' => '埼玉県三芳町',
                    'lat' => 35.828347,
                    'lon' => 139.526514,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            37 =>
                array(
                    'admin_code' => '11326',
                    'name' => '埼玉県毛呂山町',
                    'lat' => 35.941596,
                    'lon' => 139.315954,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            38 =>
                array(
                    'admin_code' => '11327',
                    'name' => '埼玉県越生町',
                    'lat' => 35.964478,
                    'lon' => 139.294202,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            39 =>
                array(
                    'admin_code' => '11341',
                    'name' => '埼玉県滑川町',
                    'lat' => 36.06599,
                    'lon' => 139.360919,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            40 =>
                array(
                    'admin_code' => '11342',
                    'name' => '埼玉県嵐山町',
                    'lat' => 36.056568,
                    'lon' => 139.320514,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            41 =>
                array(
                    'admin_code' => '11343',
                    'name' => '埼玉県小川町',
                    'lat' => 36.056657,
                    'lon' => 139.261789,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            42 =>
                array(
                    'admin_code' => '11346',
                    'name' => '埼玉県川島町',
                    'lat' => 35.982039,
                    'lon' => 139.481521,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            43 =>
                array(
                    'admin_code' => '11347',
                    'name' => '埼玉県吉見町',
                    'lat' => 36.039853,
                    'lon' => 139.45373,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            44 =>
                array(
                    'admin_code' => '11348',
                    'name' => '埼玉県鳩山町',
                    'lat' => 35.981468,
                    'lon' => 139.334106,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            45 =>
                array(
                    'admin_code' => '11349',
                    'name' => '埼玉県ときがわ町',
                    'lat' => 36.00857,
                    'lon' => 139.296763,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            46 =>
                array(
                    'admin_code' => '11361',
                    'name' => '埼玉県横瀬町',
                    'lat' => 35.987286,
                    'lon' => 139.100049,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            47 =>
                array(
                    'admin_code' => '11362',
                    'name' => '埼玉県皆野町',
                    'lat' => 36.070845,
                    'lon' => 139.098754,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            48 =>
                array(
                    'admin_code' => '11363',
                    'name' => '埼玉県長瀞町',
                    'lat' => 36.114787,
                    'lon' => 139.10972,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            49 =>
                array(
                    'admin_code' => '11365',
                    'name' => '埼玉県小鹿野町',
                    'lat' => 36.017138,
                    'lon' => 139.008604,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            50 =>
                array(
                    'admin_code' => '11369',
                    'name' => '埼玉県東秩父村',
                    'lat' => 36.058148,
                    'lon' => 139.194573,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            51 =>
                array(
                    'admin_code' => '11381',
                    'name' => '埼玉県美里町',
                    'lat' => 36.177104,
                    'lon' => 139.18141,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            52 =>
                array(
                    'admin_code' => '11383',
                    'name' => '埼玉県神川町',
                    'lat' => 36.213901,
                    'lon' => 139.101578,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            53 =>
                array(
                    'admin_code' => '11385',
                    'name' => '埼玉県上里町',
                    'lat' => 36.251615,
                    'lon' => 139.14487,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            54 =>
                array(
                    'admin_code' => '11408',
                    'name' => '埼玉県寄居町',
                    'lat' => 36.118348,
                    'lon' => 139.193014,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            55 =>
                array(
                    'admin_code' => '11442',
                    'name' => '埼玉県宮代町',
                    'lat' => 36.022593,
                    'lon' => 139.723069,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            56 =>
                array(
                    'admin_code' => '11246',
                    'name' => '埼玉県白岡市',
                    'lat' => 36.01907,
                    'lon' => 139.676861,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            57 =>
                array(
                    'admin_code' => '11464',
                    'name' => '埼玉県杉戸町',
                    'lat' => 36.025618,
                    'lon' => 139.736829,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            58 =>
                array(
                    'admin_code' => '11465',
                    'name' => '埼玉県松伏町',
                    'lat' => 35.925751,
                    'lon' => 139.815139,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            59 =>
                array(
                    'admin_code' => '11100',
                    'name' => '埼玉県さいたま市',
                    'lat' => 35.861515,
                    'lon' => 139.645502,
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
