<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 福井県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class FukuiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array(
            0 =>
                array(
                    'admin_code' => '18201',
                    'name' => '福井県福井市',
                    'lat' => 36.06412,
                    'lon' => 136.219452,
                    'office_count' => 9,
                    'main_office_count' => 1,
                ),
            1 =>
                array(
                    'admin_code' => '18202',
                    'name' => '福井県敦賀市',
                    'lat' => 35.645222,
                    'lon' => 136.055544,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            2 =>
                array(
                    'admin_code' => '18204',
                    'name' => '福井県小浜市',
                    'lat' => 35.495593,
                    'lon' => 135.746647,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            3 =>
                array(
                    'admin_code' => '18205',
                    'name' => '福井県大野市',
                    'lat' => 35.980564,
                    'lon' => 136.487692,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            4 =>
                array(
                    'admin_code' => '18206',
                    'name' => '福井県勝山市',
                    'lat' => 36.060917,
                    'lon' => 136.500542,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            5 =>
                array(
                    'admin_code' => '18207',
                    'name' => '福井県鯖江市',
                    'lat' => 35.956565,
                    'lon' => 136.184238,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            6 =>
                array(
                    'admin_code' => '18208',
                    'name' => '福井県あわら市',
                    'lat' => 36.211361,
                    'lon' => 136.229012,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            7 =>
                array(
                    'admin_code' => '18209',
                    'name' => '福井県越前市',
                    'lat' => 35.903471,
                    'lon' => 136.168672,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            8 =>
                array(
                    'admin_code' => '18210',
                    'name' => '福井県坂井市',
                    'lat' => 36.166902,
                    'lon' => 136.231287,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            9 =>
                array(
                    'admin_code' => '18322',
                    'name' => '福井県永平寺町',
                    'lat' => 36.092248,
                    'lon' => 136.298724,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            10 =>
                array(
                    'admin_code' => '18382',
                    'name' => '福井県池田町',
                    'lat' => 35.890383,
                    'lon' => 136.344079,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            11 =>
                array(
                    'admin_code' => '18404',
                    'name' => '福井県南越前町',
                    'lat' => 35.83515,
                    'lon' => 136.194435,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            12 =>
                array(
                    'admin_code' => '18423',
                    'name' => '福井県越前町',
                    'lat' => 35.974264,
                    'lon' => 136.129765,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            13 =>
                array(
                    'admin_code' => '18442',
                    'name' => '福井県美浜町',
                    'lat' => 35.6006,
                    'lon' => 135.940619,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            14 =>
                array(
                    'admin_code' => '18481',
                    'name' => '福井県高浜町',
                    'lat' => 35.490392,
                    'lon' => 135.550968,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            15 =>
                array(
                    'admin_code' => '18483',
                    'name' => '福井県おおい町',
                    'lat' => 35.481128,
                    'lon' => 135.617885,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            16 =>
                array(
                    'admin_code' => '18501',
                    'name' => '福井県若狭町役場三方庁舎',
                    'lat' => 35.548882,
                    'lon' => 135.908384,
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
