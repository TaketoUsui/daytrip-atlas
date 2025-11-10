<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 静岡県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class ShizuokaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array(
            0 =>
                array(
                    'admin_code' => '22301',
                    'name' => '静岡県東伊豆町',
                    'lat' => 34.772816,
                    'lon' => 139.041265,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            1 =>
                array(
                    'admin_code' => '22302',
                    'name' => '静岡県河津町',
                    'lat' => 34.757018,
                    'lon' => 138.987622,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            2 =>
                array(
                    'admin_code' => '22304',
                    'name' => '静岡県南伊豆町',
                    'lat' => 34.651089,
                    'lon' => 138.858533,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            3 =>
                array(
                    'admin_code' => '22305',
                    'name' => '静岡県松崎町',
                    'lat' => 34.752763,
                    'lon' => 138.778757,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            4 =>
                array(
                    'admin_code' => '22306',
                    'name' => '静岡県西伊豆町',
                    'lat' => 34.771693,
                    'lon' => 138.775334,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            5 =>
                array(
                    'admin_code' => '22325',
                    'name' => '静岡県函南町',
                    'lat' => 35.088937,
                    'lon' => 138.953348,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            6 =>
                array(
                    'admin_code' => '22341',
                    'name' => '静岡県清水町',
                    'lat' => 35.099015,
                    'lon' => 138.90272,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            7 =>
                array(
                    'admin_code' => '22342',
                    'name' => '静岡県長泉町',
                    'lat' => 35.137712,
                    'lon' => 138.897258,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            8 =>
                array(
                    'admin_code' => '22344',
                    'name' => '静岡県小山町',
                    'lat' => 35.36011,
                    'lon' => 138.987296,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            9 =>
                array(
                    'admin_code' => '22424',
                    'name' => '静岡県吉田町',
                    'lat' => 34.77087,
                    'lon' => 138.251943,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            10 =>
                array(
                    'admin_code' => '22429',
                    'name' => '静岡県川根本町',
                    'lat' => 35.046822,
                    'lon' => 138.081695,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            11 =>
                array(
                    'admin_code' => '22461',
                    'name' => '静岡県森町',
                    'lat' => 34.835601,
                    'lon' => 137.927088,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            12 =>
                array(
                    'admin_code' => '22100',
                    'name' => '静岡県静岡市',
                    'lat' => 34.975473,
                    'lon' => 138.382388,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            13 =>
                array(
                    'admin_code' => '22130',
                    'name' => '静岡県浜松市',
                    'lat' => 34.710865,
                    'lon' => 137.726117,
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
