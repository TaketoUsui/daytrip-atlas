<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 徳島県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class TokushimaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array(
            0 =>
                array(
                    'admin_code' => '36201',
                    'name' => '徳島県徳島市',
                    'lat' => 34.070234,
                    'lon' => 134.554713,
                    'office_count' => 15,
                    'main_office_count' => 1,
                ),
            1 =>
                array(
                    'admin_code' => '36202',
                    'name' => '徳島県鳴門市',
                    'lat' => 34.17259,
                    'lon' => 134.6088,
                    'office_count' => 7,
                    'main_office_count' => 1,
                ),
            2 =>
                array(
                    'admin_code' => '36203',
                    'name' => '徳島県小松島市',
                    'lat' => 34.004713,
                    'lon' => 134.590603,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            3 =>
                array(
                    'admin_code' => '36204',
                    'name' => '徳島県阿南市',
                    'lat' => 33.921762,
                    'lon' => 134.659566,
                    'office_count' => 5,
                    'main_office_count' => 1,
                ),
            4 =>
                array(
                    'admin_code' => '36205',
                    'name' => '徳島県吉野川市',
                    'lat' => 34.066235,
                    'lon' => 134.358667,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            5 =>
                array(
                    'admin_code' => '36206',
                    'name' => '徳島県阿波市',
                    'lat' => 34.082354,
                    'lon' => 134.235779,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            6 =>
                array(
                    'admin_code' => '36207',
                    'name' => '徳島県美馬市',
                    'lat' => 34.053387,
                    'lon' => 134.169725,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            7 =>
                array(
                    'admin_code' => '36208',
                    'name' => '徳島県三好市',
                    'lat' => 34.026044,
                    'lon' => 133.80718,
                    'office_count' => 6,
                    'main_office_count' => 1,
                ),
            8 =>
                array(
                    'admin_code' => '36301',
                    'name' => '徳島県勝浦町',
                    'lat' => 33.931453,
                    'lon' => 134.511251,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            9 =>
                array(
                    'admin_code' => '36302',
                    'name' => '徳島県上勝町',
                    'lat' => 33.888841,
                    'lon' => 134.401819,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            10 =>
                array(
                    'admin_code' => '36321',
                    'name' => '徳島県佐那河内村',
                    'lat' => 33.993141,
                    'lon' => 134.453294,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            11 =>
                array(
                    'admin_code' => '36341',
                    'name' => '徳島県石井町',
                    'lat' => 34.074698,
                    'lon' => 134.440764,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            12 =>
                array(
                    'admin_code' => '36342',
                    'name' => '徳島県神山町',
                    'lat' => 33.967225,
                    'lon' => 134.350531,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            13 =>
                array(
                    'admin_code' => '36368',
                    'name' => '徳島県那賀町',
                    'lat' => 33.857497,
                    'lon' => 134.496736,
                    'office_count' => 8,
                    'main_office_count' => 1,
                ),
            14 =>
                array(
                    'admin_code' => '36383',
                    'name' => '徳島県牟岐町',
                    'lat' => 33.668312,
                    'lon' => 134.420661,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            15 =>
                array(
                    'admin_code' => '36387',
                    'name' => '徳島県美波町',
                    'lat' => 33.734573,
                    'lon' => 134.535413,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            16 =>
                array(
                    'admin_code' => '36388',
                    'name' => '徳島県海陽町',
                    'lat' => 33.602043,
                    'lon' => 134.351866,
                    'office_count' => 5,
                    'main_office_count' => 1,
                ),
            17 =>
                array(
                    'admin_code' => '36401',
                    'name' => '徳島県松茂町',
                    'lat' => 34.133849,
                    'lon' => 134.580537,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            18 =>
                array(
                    'admin_code' => '36402',
                    'name' => '徳島県北島町',
                    'lat' => 34.125594,
                    'lon' => 134.546985,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            19 =>
                array(
                    'admin_code' => '36403',
                    'name' => '徳島県藍住町',
                    'lat' => 34.126776,
                    'lon' => 134.495112,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            20 =>
                array(
                    'admin_code' => '36404',
                    'name' => '徳島県板野町',
                    'lat' => 34.144364,
                    'lon' => 134.462616,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            21 =>
                array(
                    'admin_code' => '36405',
                    'name' => '徳島県上板町',
                    'lat' => 34.121365,
                    'lon' => 134.404999,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            22 =>
                array(
                    'admin_code' => '36468',
                    'name' => '徳島県つるぎ町',
                    'lat' => 34.037307,
                    'lon' => 134.064051,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            23 =>
                array(
                    'admin_code' => '36489',
                    'name' => '徳島県東みよし町',
                    'lat' => 34.036785,
                    'lon' => 133.93676,
                    'office_count' => 2,
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
