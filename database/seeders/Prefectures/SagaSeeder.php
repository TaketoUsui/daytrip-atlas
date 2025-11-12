<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 佐賀県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class SagaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = [
            0 => [
                'admin_code' => '41201',
                'name' => '佐賀県佐賀市',
                'lat' => 33.263543,
                'lon' => 130.300835,
                'office_count' => 8,
                'main_office_count' => 1,
            ],
            1 => [
                'admin_code' => '41202',
                'name' => '佐賀県唐津市',
                'lat' => 33.450103,
                'lon' => 129.96797,
                'office_count' => 12,
                'main_office_count' => 1,
            ],
            2 => [
                'admin_code' => '41203',
                'name' => '佐賀県鳥栖市',
                'lat' => 33.377758,
                'lon' => 130.506244,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            3 => [
                'admin_code' => '41204',
                'name' => '佐賀県多久市',
                'lat' => 33.288513,
                'lon' => 130.110061,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            4 => [
                'admin_code' => '41205',
                'name' => '佐賀県伊万里市',
                'lat' => 33.264741,
                'lon' => 129.880702,
                'office_count' => 13,
                'main_office_count' => 1,
            ],
            5 => [
                'admin_code' => '41206',
                'name' => '佐賀県武雄市',
                'lat' => 33.193751,
                'lon' => 130.01915,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            6 => [
                'admin_code' => '41207',
                'name' => '佐賀県鹿島市',
                'lat' => 33.103804,
                'lon' => 130.098603,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            7 => [
                'admin_code' => '41208',
                'name' => '佐賀県小城市',
                'lat' => 33.273776,
                'lon' => 130.21728,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            8 => [
                'admin_code' => '41209',
                'name' => '佐賀県嬉野市',
                'lat' => 33.128092,
                'lon' => 130.06012,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            9 => [
                'admin_code' => '41210',
                'name' => '佐賀県神埼市',
                'lat' => 33.310732,
                'lon' => 130.373057,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            10 => [
                'admin_code' => '41327',
                'name' => '佐賀県吉野ヶ里町',
                'lat' => 33.321148,
                'lon' => 130.398753,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            11 => [
                'admin_code' => '41341',
                'name' => '佐賀県基山町',
                'lat' => 33.426944,
                'lon' => 130.523052,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            12 => [
                'admin_code' => '41345',
                'name' => '佐賀県上峰町',
                'lat' => 33.319626,
                'lon' => 130.426137,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            13 => [
                'admin_code' => '41346',
                'name' => '佐賀県みやき町',
                'lat' => 33.324943,
                'lon' => 130.45459,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            14 => [
                'admin_code' => '41387',
                'name' => '佐賀県玄海町',
                'lat' => 33.472164,
                'lon' => 129.874689,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            15 => [
                'admin_code' => '41401',
                'name' => '佐賀県有田町',
                'lat' => 33.210574,
                'lon' => 129.849014,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            16 => [
                'admin_code' => '41423',
                'name' => '佐賀県大町町',
                'lat' => 33.213871,
                'lon' => 130.116032,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            17 => [
                'admin_code' => '41424',
                'name' => '佐賀県江北町',
                'lat' => 33.220464,
                'lon' => 130.15731,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            18 => [
                'admin_code' => '41425',
                'name' => '佐賀県白石町',
                'lat' => 33.181082,
                'lon' => 130.143493,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            19 => [
                'admin_code' => '41441',
                'name' => '佐賀県太良町',
                'lat' => 33.019436,
                'lon' => 130.179126,
                'office_count' => 2,
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
