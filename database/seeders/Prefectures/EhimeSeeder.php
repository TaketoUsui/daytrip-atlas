<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 愛媛県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class EhimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = [
            0 => [
                'admin_code' => '38201',
                'name' => '愛媛県松山市',
                'lat' => 33.839157,
                'lon' => 132.765556,
                'office_count' => 30,
                'main_office_count' => 1,
            ],
            1 => [
                'admin_code' => '38202',
                'name' => '愛媛県今治市',
                'lat' => 34.066043,
                'lon' => 132.997658,
                'office_count' => 12,
                'main_office_count' => 1,
            ],
            2 => [
                'admin_code' => '38203',
                'name' => '愛媛県宇和島市',
                'lat' => 33.22334,
                'lon' => 132.560563,
                'office_count' => 8,
                'main_office_count' => 1,
            ],
            3 => [
                'admin_code' => '38204',
                'name' => '愛媛県八幡浜市',
                'lat' => 33.462898,
                'lon' => 132.423334,
                'office_count' => 7,
                'main_office_count' => 1,
            ],
            4 => [
                'admin_code' => '38205',
                'name' => '愛媛県新居浜市',
                'lat' => 33.960329,
                'lon' => 133.283379,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            5 => [
                'admin_code' => '38206',
                'name' => '愛媛県西条市',
                'lat' => 33.919615,
                'lon' => 133.181186,
                'office_count' => 8,
                'main_office_count' => 1,
            ],
            6 => [
                'admin_code' => '38207',
                'name' => '愛媛県大洲市',
                'lat' => 33.506285,
                'lon' => 132.544514,
                'office_count' => 20,
                'main_office_count' => 1,
            ],
            7 => [
                'admin_code' => '38213',
                'name' => '愛媛県四国中央市',
                'lat' => 33.980694,
                'lon' => 133.549188,
                'office_count' => 9,
                'main_office_count' => 1,
            ],
            8 => [
                'admin_code' => '38214',
                'name' => '愛媛県西予市',
                'lat' => 33.363017,
                'lon' => 132.510967,
                'office_count' => 15,
                'main_office_count' => 1,
            ],
            9 => [
                'admin_code' => '38215',
                'name' => '愛媛県東温市',
                'lat' => 33.791027,
                'lon' => 132.872299,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            10 => [
                'admin_code' => '38356',
                'name' => '愛媛県上島町',
                'lat' => 34.257467,
                'lon' => 133.204492,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            11 => [
                'admin_code' => '38386',
                'name' => '愛媛県久万高原町',
                'lat' => 33.655603,
                'lon' => 132.901665,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            12 => [
                'admin_code' => '38401',
                'name' => '愛媛県松前町',
                'lat' => 33.787479,
                'lon' => 132.711364,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            13 => [
                'admin_code' => '38402',
                'name' => '愛媛県砥部町',
                'lat' => 33.74926,
                'lon' => 132.792233,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            14 => [
                'admin_code' => '38422',
                'name' => '愛媛県内子町',
                'lat' => 33.532937,
                'lon' => 132.658083,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            15 => [
                'admin_code' => '38442',
                'name' => '愛媛県伊方町',
                'lat' => 33.488593,
                'lon' => 132.353998,
                'office_count' => 6,
                'main_office_count' => 1,
            ],
            16 => [
                'admin_code' => '38484',
                'name' => '愛媛県松野町',
                'lat' => 33.22715,
                'lon' => 132.710935,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            17 => [
                'admin_code' => '38488',
                'name' => '愛媛県鬼北町',
                'lat' => 33.255792,
                'lon' => 132.684032,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            18 => [
                'admin_code' => '38506',
                'name' => '愛媛県愛南町',
                'lat' => 32.962168,
                'lon' => 132.583326,
                'office_count' => 5,
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
