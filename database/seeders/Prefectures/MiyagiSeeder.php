<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 宮城県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class MiyagiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = [
            0 => [
                'admin_code' => '04202',
                'name' => '宮城県石巻市',
                'lat' => 38.434457,
                'lon' => 141.302906,
                'office_count' => 12,
                'main_office_count' => 1,
            ],
            1 => [
                'admin_code' => '04203',
                'name' => '宮城県塩竈市',
                'lat' => 38.31436,
                'lon' => 141.02203,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            2 => [
                'admin_code' => '04205',
                'name' => '宮城県気仙沼市',
                'lat' => 38.908127,
                'lon' => 141.570044,
                'office_count' => 5,
                'main_office_count' => 1,
            ],
            3 => [
                'admin_code' => '04206',
                'name' => '宮城県白石市',
                'lat' => 38.002467,
                'lon' => 140.619888,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            4 => [
                'admin_code' => '04207',
                'name' => '宮城県名取市',
                'lat' => 38.171501,
                'lon' => 140.891849,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            5 => [
                'admin_code' => '04208',
                'name' => '宮城県角田市',
                'lat' => 37.977016,
                'lon' => 140.781543,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            6 => [
                'admin_code' => '04209',
                'name' => '宮城県多賀城市',
                'lat' => 38.293803,
                'lon' => 141.004369,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            7 => [
                'admin_code' => '04211',
                'name' => '宮城県岩沼市',
                'lat' => 38.104303,
                'lon' => 140.869949,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            8 => [
                'admin_code' => '04212',
                'name' => '宮城県登米市',
                'lat' => 38.691856,
                'lon' => 141.18772,
                'office_count' => 9,
                'main_office_count' => 1,
            ],
            9 => [
                'admin_code' => '04213',
                'name' => '宮城県栗原市',
                'lat' => 38.730062,
                'lon' => 141.021508,
                'office_count' => 12,
                'main_office_count' => 1,
            ],
            10 => [
                'admin_code' => '04214',
                'name' => '宮城県東松島市',
                'lat' => 38.426134,
                'lon' => 141.210278,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            11 => [
                'admin_code' => '04215',
                'name' => '宮城県大崎市',
                'lat' => 38.577132,
                'lon' => 140.955565,
                'office_count' => 8,
                'main_office_count' => 1,
            ],
            12 => [
                'admin_code' => '04301',
                'name' => '宮城県蔵王町',
                'lat' => 38.098128,
                'lon' => 140.65868,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            13 => [
                'admin_code' => '04302',
                'name' => '宮城県七ケ宿町',
                'lat' => 37.993063,
                'lon' => 140.441615,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            14 => [
                'admin_code' => '04321',
                'name' => '宮城県大河原町',
                'lat' => 38.049412,
                'lon' => 140.730774,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            15 => [
                'admin_code' => '04322',
                'name' => '宮城県村田町',
                'lat' => 38.118589,
                'lon' => 140.722404,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            16 => [
                'admin_code' => '04323',
                'name' => '宮城県柴田町',
                'lat' => 38.056599,
                'lon' => 140.765798,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            17 => [
                'admin_code' => '04324',
                'name' => '宮城県川崎町',
                'lat' => 38.177751,
                'lon' => 140.643188,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            18 => [
                'admin_code' => '04341',
                'name' => '宮城県丸森町',
                'lat' => 37.911536,
                'lon' => 140.765365,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            19 => [
                'admin_code' => '04361',
                'name' => '宮城県亘理町',
                'lat' => 38.037765,
                'lon' => 140.852564,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            20 => [
                'admin_code' => '04362',
                'name' => '宮城県山元町',
                'lat' => 37.962405,
                'lon' => 140.877529,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            21 => [
                'admin_code' => '04401',
                'name' => '宮城県松島町',
                'lat' => 38.380149,
                'lon' => 141.067291,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            22 => [
                'admin_code' => '04404',
                'name' => '宮城県七ヶ浜町',
                'lat' => 38.304554,
                'lon' => 141.059143,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            23 => [
                'admin_code' => '04406',
                'name' => '宮城県利府町',
                'lat' => 38.330355,
                'lon' => 140.975793,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            24 => [
                'admin_code' => '04421',
                'name' => '宮城県大和町',
                'lat' => 38.43733,
                'lon' => 140.886309,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            25 => [
                'admin_code' => '04422',
                'name' => '宮城県大郷町',
                'lat' => 38.424244,
                'lon' => 141.00446,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            26 => [
                'admin_code' => '04423',
                'name' => '宮城県富谷町',
                'lat' => 38.399918,
                'lon' => 140.895485,
                'office_count' => 6,
                'main_office_count' => 1,
            ],
            27 => [
                'admin_code' => '04424',
                'name' => '宮城県大衡村',
                'lat' => 38.467278,
                'lon' => 140.879982,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            28 => [
                'admin_code' => '04444',
                'name' => '宮城県色麻町',
                'lat' => 38.548921,
                'lon' => 140.849876,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            29 => [
                'admin_code' => '04445',
                'name' => '宮城県加美町',
                'lat' => 38.57177,
                'lon' => 140.854759,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            30 => [
                'admin_code' => '04501',
                'name' => '宮城県涌谷町',
                'lat' => 38.539704,
                'lon' => 141.128105,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            31 => [
                'admin_code' => '04505',
                'name' => '宮城県美里町',
                'lat' => 38.5444,
                'lon' => 141.056717,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            32 => [
                'admin_code' => '04581',
                'name' => '宮城県女川町',
                'lat' => 38.445533,
                'lon' => 141.444435,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            33 => [
                'admin_code' => '04606',
                'name' => '宮城県南三陸町',
                'lat' => 38.679144,
                'lon' => 141.460867,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            34 => [
                'admin_code' => '4100',
                'name' => '宮城県仙台市',
                'lat' => 38.268008,
                'lon' => 140.869617,
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
