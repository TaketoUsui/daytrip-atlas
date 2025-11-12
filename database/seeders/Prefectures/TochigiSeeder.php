<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 栃木県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class TochigiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = [
            0 => [
                'admin_code' => '09201',
                'name' => '栃木県宇都宮市',
                'lat' => 36.555115,
                'lon' => 139.882807,
                'office_count' => 7,
                'main_office_count' => 1,
            ],
            1 => [
                'admin_code' => '09202',
                'name' => '栃木県足利市',
                'lat' => 36.340146,
                'lon' => 139.449696,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            2 => [
                'admin_code' => '09203',
                'name' => '栃木県栃木市',
                'lat' => 36.38241388,
                'lon' => 139.73411109,
                'office_count' => 15,
                'main_office_count' => 1,
            ],
            3 => [
                'admin_code' => '09204',
                'name' => '栃木県佐野市',
                'lat' => 36.308603,
                'lon' => 139.593134,
                'office_count' => 7,
                'main_office_count' => 1,
            ],
            4 => [
                'admin_code' => '09205',
                'name' => '栃木県鹿沼市',
                'lat' => 36.56712,
                'lon' => 139.745098,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            5 => [
                'admin_code' => '09206',
                'name' => '栃木県日光市',
                'lat' => 36.719861,
                'lon' => 139.698204,
                'office_count' => 14,
                'main_office_count' => 1,
            ],
            6 => [
                'admin_code' => 'P05_0',
                'name' => '栃木県足尾総合支所',
                'lat' => 36.633857,
                'lon' => 139.440594,
                'office_count' => 1,
                'main_office_count' => 0,
            ],
            7 => [
                'admin_code' => '09208',
                'name' => '栃木県小山市',
                'lat' => 36.314477,
                'lon' => 139.800132,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            8 => [
                'admin_code' => '09209',
                'name' => '栃木県真岡市',
                'lat' => 36.440427,
                'lon' => 140.013428,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            9 => [
                'admin_code' => '09211',
                'name' => '栃木県矢板市',
                'lat' => 36.806732,
                'lon' => 139.924226,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            10 => [
                'admin_code' => '09213',
                'name' => '栃木県那須塩原市',
                'lat' => 36.96169,
                'lon' => 140.046044,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            11 => [
                'admin_code' => '09214',
                'name' => '栃木県さくら市',
                'lat' => 36.685295,
                'lon' => 139.966474,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            12 => [
                'admin_code' => '09215',
                'name' => '栃木県那須烏山市',
                'lat' => 36.656891,
                'lon' => 140.151376,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            13 => [
                'admin_code' => '09216',
                'name' => '栃木県下野市',
                'lat' => 36.387167,
                'lon' => 139.841942,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            14 => [
                'admin_code' => '09301',
                'name' => '栃木県上三川町',
                'lat' => 36.439268,
                'lon' => 139.910214,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            15 => [
                'admin_code' => '09342',
                'name' => '栃木県益子町',
                'lat' => 36.467353,
                'lon' => 140.093381,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            16 => [
                'admin_code' => '09343',
                'name' => '栃木県茂木町',
                'lat' => 36.532184,
                'lon' => 140.187535,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            17 => [
                'admin_code' => '09344',
                'name' => '栃木県市貝町',
                'lat' => 36.543242,
                'lon' => 140.102113,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            18 => [
                'admin_code' => '09345',
                'name' => '栃木県芳賀町',
                'lat' => 36.548212,
                'lon' => 140.058199,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            19 => [
                'admin_code' => '09361',
                'name' => '栃木県壬生町',
                'lat' => 36.427058,
                'lon' => 139.803935,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            20 => [
                'admin_code' => '09364',
                'name' => '栃木県野木町',
                'lat' => 36.233263,
                'lon' => 139.740818,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            21 => [
                'admin_code' => '09384',
                'name' => '栃木県塩谷町',
                'lat' => 36.777605,
                'lon' => 139.850578,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            22 => [
                'admin_code' => '09386',
                'name' => '栃木県高根沢町',
                'lat' => 36.630976,
                'lon' => 139.986672,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            23 => [
                'admin_code' => '09407',
                'name' => '栃木県那須町',
                'lat' => 37.01977,
                'lon' => 140.121008,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            24 => [
                'admin_code' => '09411',
                'name' => '栃木県那珂川町',
                'lat' => 36.738145,
                'lon' => 140.171398,
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
