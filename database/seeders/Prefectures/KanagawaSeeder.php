<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 神奈川県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class KanagawaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = [
            0 => [
                'admin_code' => '14301',
                'name' => '神奈川県葉山町',
                'lat' => 35.272025,
                'lon' => 139.586275,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            1 => [
                'admin_code' => '14321',
                'name' => '神奈川県寒川町',
                'lat' => 35.372963,
                'lon' => 139.384188,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            2 => [
                'admin_code' => '14341',
                'name' => '神奈川県大磯町',
                'lat' => 35.30694,
                'lon' => 139.311348,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            3 => [
                'admin_code' => '14342',
                'name' => '神奈川県二宮町',
                'lat' => 35.299494,
                'lon' => 139.255525,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            4 => [
                'admin_code' => '14361',
                'name' => '神奈川県中井町',
                'lat' => 35.330751,
                'lon' => 139.218766,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            5 => [
                'admin_code' => '14362',
                'name' => '神奈川県大井町',
                'lat' => 35.326619,
                'lon' => 139.156649,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            6 => [
                'admin_code' => '14363',
                'name' => '神奈川県松田町',
                'lat' => 35.348199,
                'lon' => 139.139337,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            7 => [
                'admin_code' => '14364',
                'name' => '神奈川県山北町',
                'lat' => 35.360631,
                'lon' => 139.083806,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            8 => [
                'admin_code' => '14366',
                'name' => '神奈川県開成町',
                'lat' => 35.33643,
                'lon' => 139.123183,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            9 => [
                'admin_code' => '14382',
                'name' => '神奈川県箱根町',
                'lat' => 35.232301,
                'lon' => 139.106886,
                'office_count' => 5,
                'main_office_count' => 1,
            ],
            10 => [
                'admin_code' => '14383',
                'name' => '神奈川県真鶴町',
                'lat' => 35.158399,
                'lon' => 139.137233,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            11 => [
                'admin_code' => '14384',
                'name' => '神奈川県湯河原町',
                'lat' => 35.147931,
                'lon' => 139.108336,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            12 => [
                'admin_code' => '14401',
                'name' => '神奈川県愛川町',
                'lat' => 35.528746,
                'lon' => 139.32172,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            13 => [
                'admin_code' => '14402',
                'name' => '神奈川県清川村',
                'lat' => 35.48233,
                'lon' => 139.276374,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            14 => [
                'admin_code' => '14100',
                'name' => '神奈川県横浜市',
                'lat' => 35.444035,
                'lon' => 139.637954,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            15 => [
                'admin_code' => '14130',
                'name' => '神奈川県川崎市',
                'lat' => 35.530806,
                'lon' => 139.703012,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            16 => [
                'admin_code' => '14150',
                'name' => '神奈川県相模原市',
                'lat' => 35.571376,
                'lon' => 139.373268,
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
