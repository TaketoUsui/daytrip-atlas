<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 鳥取県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class TottoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = [
            0 => [
                'admin_code' => '31201',
                'name' => '鳥取県鳥取市',
                'lat' => 35.501133,
                'lon' => 134.235091,
                'office_count' => 10,
                'main_office_count' => 1,
            ],
            1 => [
                'admin_code' => '31202',
                'name' => '鳥取県米子市',
                'lat' => 35.428136,
                'lon' => 133.330939,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            2 => [
                'admin_code' => '31203',
                'name' => '鳥取県倉吉市',
                'lat' => 35.430182,
                'lon' => 133.825561,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            3 => [
                'admin_code' => '31204',
                'name' => '鳥取県境港市',
                'lat' => 35.539606,
                'lon' => 133.2316,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            4 => [
                'admin_code' => '31302',
                'name' => '鳥取県岩美町',
                'lat' => 35.575896,
                'lon' => 134.332087,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            5 => [
                'admin_code' => '31325',
                'name' => '鳥取県若桜町',
                'lat' => 35.340149,
                'lon' => 134.400992,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            6 => [
                'admin_code' => '31328',
                'name' => '鳥取県智頭町',
                'lat' => 35.265081,
                'lon' => 134.226587,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            7 => [
                'admin_code' => '31329',
                'name' => '鳥取県八頭町',
                'lat' => 35.409211,
                'lon' => 134.250526,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            8 => [
                'admin_code' => '31364',
                'name' => '鳥取県三朝町',
                'lat' => 35.408461,
                'lon' => 133.861742,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            9 => [
                'admin_code' => '31371',
                'name' => '鳥取県琴浦町',
                'lat' => 35.495184,
                'lon' => 133.692779,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            10 => [
                'admin_code' => '31372',
                'name' => '鳥取県北栄町',
                'lat' => 35.490011,
                'lon' => 133.758294,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            11 => [
                'admin_code' => '31384',
                'name' => '鳥取県日吉津村',
                'lat' => 35.440179,
                'lon' => 133.380808,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            12 => [
                'admin_code' => '31386',
                'name' => '鳥取県大山町',
                'lat' => 35.510779,
                'lon' => 133.496123,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            13 => [
                'admin_code' => '31389',
                'name' => '鳥取県南部町',
                'lat' => 35.34033,
                'lon' => 133.326829,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            14 => [
                'admin_code' => '31390',
                'name' => '鳥取県伯耆町',
                'lat' => 35.38523,
                'lon' => 133.407384,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            15 => [
                'admin_code' => '31401',
                'name' => '鳥取県日南町',
                'lat' => 35.163311,
                'lon' => 133.306255,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            16 => [
                'admin_code' => '31402',
                'name' => '鳥取県日野町',
                'lat' => 35.240793,
                'lon' => 133.442659,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            17 => [
                'admin_code' => '31403',
                'name' => '鳥取県江府町',
                'lat' => 35.283187,
                'lon' => 133.488578,
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
