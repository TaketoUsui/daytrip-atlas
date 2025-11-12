<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 京都府のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class KyotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = [
            0 => [
                'admin_code' => '26201',
                'name' => '京都府福知山市',
                'lat' => 35.296725,
                'lon' => 135.126532,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            1 => [
                'admin_code' => '26202',
                'name' => '京都府舞鶴市',
                'lat' => 35.474797,
                'lon' => 135.385992,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            2 => [
                'admin_code' => '26203',
                'name' => '京都府綾部市',
                'lat' => 35.298916,
                'lon' => 135.258812,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            3 => [
                'admin_code' => '26204',
                'name' => '京都府宇治市',
                'lat' => 34.8844,
                'lon' => 135.79978,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            4 => [
                'admin_code' => '26205',
                'name' => '京都府宮津市',
                'lat' => 35.535577,
                'lon' => 135.195567,
                'office_count' => 10,
                'main_office_count' => 1,
            ],
            5 => [
                'admin_code' => '26206',
                'name' => '京都府亀岡市',
                'lat' => 35.013475,
                'lon' => 135.573512,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            6 => [
                'admin_code' => '26207',
                'name' => '京都府城陽市',
                'lat' => 34.852958,
                'lon' => 135.780074,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            7 => [
                'admin_code' => '26208',
                'name' => '京都府向日市',
                'lat' => 34.948699,
                'lon' => 135.698319,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            8 => [
                'admin_code' => '26209',
                'name' => '京都府長岡京市',
                'lat' => 34.926782,
                'lon' => 135.695685,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            9 => [
                'admin_code' => '26211',
                'name' => '京都府京田辺市',
                'lat' => 34.814442,
                'lon' => 135.767842,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            10 => [
                'admin_code' => '26212',
                'name' => '京都府京丹後市',
                'lat' => 35.624169,
                'lon' => 135.060997,
                'office_count' => 6,
                'main_office_count' => 1,
            ],
            11 => [
                'admin_code' => '26213',
                'name' => '京都府南丹市',
                'lat' => 35.10739,
                'lon' => 135.470239,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            12 => [
                'admin_code' => '26214',
                'name' => '京都府木津川市',
                'lat' => 34.737179,
                'lon' => 135.820058,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            13 => [
                'admin_code' => '26303',
                'name' => '京都府大山崎町',
                'lat' => 34.902795,
                'lon' => 135.688476,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            14 => [
                'admin_code' => '26322',
                'name' => '京都府久御山町',
                'lat' => 34.881502,
                'lon' => 135.732564,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            15 => [
                'admin_code' => '26343',
                'name' => '京都府井手町',
                'lat' => 34.798373,
                'lon' => 135.803308,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            16 => [
                'admin_code' => '26344',
                'name' => '京都府宇治田原町',
                'lat' => 34.852665,
                'lon' => 135.85685,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            17 => [
                'admin_code' => '26364',
                'name' => '京都府笠置町',
                'lat' => 34.760497,
                'lon' => 135.93938,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            18 => [
                'admin_code' => '26365',
                'name' => '京都府和束町',
                'lat' => 34.795726,
                'lon' => 135.904866,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            19 => [
                'admin_code' => '26366',
                'name' => '京都府精華町',
                'lat' => 34.760819,
                'lon' => 135.785686,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            20 => [
                'admin_code' => '26367',
                'name' => '京都府南山城村',
                'lat' => 34.772787,
                'lon' => 135.993665,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            21 => [
                'admin_code' => '26407',
                'name' => '京都府京丹波町',
                'lat' => 35.16435,
                'lon' => 135.423267,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            22 => [
                'admin_code' => '26463',
                'name' => '京都府伊根町',
                'lat' => 35.675172,
                'lon' => 135.272853,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            23 => [
                'admin_code' => '26465',
                'name' => '京都府与謝野町',
                'lat' => 35.565375,
                'lon' => 135.152916,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            24 => [
                'admin_code' => '26100',
                'name' => '京都府京都市',
                'lat' => 35.011574,
                'lon' => 135.768181,
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
