<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 青森県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class AomoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array(
            0 =>
                array(
                    'admin_code' => '02201',
                    'name' => '青森県青森市',
                    'lat' => 40.822358,
                    'lon' => 140.74732,
                    'office_count' => 9,
                    'main_office_count' => 1,
                ),
            1 =>
                array(
                    'admin_code' => '02202',
                    'name' => '青森県弘前市',
                    'lat' => 40.602965,
                    'lon' => 140.464008,
                    'office_count' => 11,
                    'main_office_count' => 1,
                ),
            2 =>
                array(
                    'admin_code' => '02203',
                    'name' => '青森県八戸市',
                    'lat' => 40.512278,
                    'lon' => 141.488404,
                    'office_count' => 10,
                    'main_office_count' => 1,
                ),
            3 =>
                array(
                    'admin_code' => '02204',
                    'name' => '青森県黒石市',
                    'lat' => 40.642608,
                    'lon' => 140.594547,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            4 =>
                array(
                    'admin_code' => '02205',
                    'name' => '青森県五所川原市',
                    'lat' => 40.808101,
                    'lon' => 140.440007,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            5 =>
                array(
                    'admin_code' => '02206',
                    'name' => '青森県十和田市',
                    'lat' => 40.612703,
                    'lon' => 141.20591,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            6 =>
                array(
                    'admin_code' => '02207',
                    'name' => '青森県三沢市',
                    'lat' => 40.683078,
                    'lon' => 141.369093,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            7 =>
                array(
                    'admin_code' => '02208',
                    'name' => '青森県むつ市',
                    'lat' => 41.292835,
                    'lon' => 141.183174,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            8 =>
                array(
                    'admin_code' => '02209',
                    'name' => '青森県つがる市',
                    'lat' => 40.808836,
                    'lon' => 140.380195,
                    'office_count' => 6,
                    'main_office_count' => 1,
                ),
            9 =>
                array(
                    'admin_code' => '02210',
                    'name' => '青森県平川市',
                    'lat' => 40.584114,
                    'lon' => 140.566506,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            10 =>
                array(
                    'admin_code' => '02301',
                    'name' => '青森県平内町',
                    'lat' => 40.926023,
                    'lon' => 140.955884,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            11 =>
                array(
                    'admin_code' => '02303',
                    'name' => '青森県今別町',
                    'lat' => 41.181875,
                    'lon' => 140.48161,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            12 =>
                array(
                    'admin_code' => '02304',
                    'name' => '青森県蓬田村',
                    'lat' => 40.971779,
                    'lon' => 140.656053,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            13 =>
                array(
                    'admin_code' => '02307',
                    'name' => '青森県外ヶ浜町',
                    'lat' => 41.043159,
                    'lon' => 140.632243,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            14 =>
                array(
                    'admin_code' => '02321',
                    'name' => '青森県鰺ヶ沢町',
                    'lat' => 40.779875,
                    'lon' => 140.208569,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            15 =>
                array(
                    'admin_code' => '02323',
                    'name' => '青森県深浦町',
                    'lat' => 40.647876,
                    'lon' => 139.927431,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            16 =>
                array(
                    'admin_code' => '02343',
                    'name' => '青森県西目屋村',
                    'lat' => 40.57684,
                    'lon' => 140.296285,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            17 =>
                array(
                    'admin_code' => '02361',
                    'name' => '青森県藤崎町',
                    'lat' => 40.656064,
                    'lon' => 140.502824,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            18 =>
                array(
                    'admin_code' => '02362',
                    'name' => '青森県大鰐町',
                    'lat' => 40.518356,
                    'lon' => 140.567878,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            19 =>
                array(
                    'admin_code' => '02367',
                    'name' => '青森県田舎館村',
                    'lat' => 40.631259,
                    'lon' => 140.550198,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            20 =>
                array(
                    'admin_code' => '02381',
                    'name' => '青森県板柳町',
                    'lat' => 40.695896,
                    'lon' => 140.457414,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            21 =>
                array(
                    'admin_code' => '02384',
                    'name' => '青森県鶴田町',
                    'lat' => 40.758819,
                    'lon' => 140.428702,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            22 =>
                array(
                    'admin_code' => '02387',
                    'name' => '青森県中泊町',
                    'lat' => 40.965181,
                    'lon' => 140.439831,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            23 =>
                array(
                    'admin_code' => '02401',
                    'name' => '青森県野辺地町',
                    'lat' => 40.864447,
                    'lon' => 141.128685,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            24 =>
                array(
                    'admin_code' => '02402',
                    'name' => '青森県七戸町',
                    'lat' => 40.744714,
                    'lon' => 141.157991,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            25 =>
                array(
                    'admin_code' => '02405',
                    'name' => '青森県六戸町',
                    'lat' => 40.609526,
                    'lon' => 141.324958,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            26 =>
                array(
                    'admin_code' => '02406',
                    'name' => '青森県横浜町',
                    'lat' => 41.083155,
                    'lon' => 141.247782,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            27 =>
                array(
                    'admin_code' => '02408',
                    'name' => '青森県東北町',
                    'lat' => 40.727871,
                    'lon' => 141.257888,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            28 =>
                array(
                    'admin_code' => '02411',
                    'name' => '青森県六ヶ所村',
                    'lat' => 40.967375,
                    'lon' => 141.374434,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            29 =>
                array(
                    'admin_code' => '02412',
                    'name' => '青森県おいらせ町',
                    'lat' => 40.599104,
                    'lon' => 141.397822,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            30 =>
                array(
                    'admin_code' => '02423',
                    'name' => '青森県大間町',
                    'lat' => 41.526765,
                    'lon' => 140.907438,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            31 =>
                array(
                    'admin_code' => '02424',
                    'name' => '青森県東通村',
                    'lat' => 41.277726,
                    'lon' => 141.3289,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            32 =>
                array(
                    'admin_code' => '02425',
                    'name' => '青森県風間浦村',
                    'lat' => 41.487487,
                    'lon' => 140.995534,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            33 =>
                array(
                    'admin_code' => '02426',
                    'name' => '青森県佐井村',
                    'lat' => 41.429718,
                    'lon' => 140.859175,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            34 =>
                array(
                    'admin_code' => '02441',
                    'name' => '青森県三戸町',
                    'lat' => 40.378423,
                    'lon' => 141.25874,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            35 =>
                array(
                    'admin_code' => '02442',
                    'name' => '青森県五戸町',
                    'lat' => 40.531208,
                    'lon' => 141.307813,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            36 =>
                array(
                    'admin_code' => '02443',
                    'name' => '青森県田子町',
                    'lat' => 40.34003,
                    'lon' => 141.15215,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            37 =>
                array(
                    'admin_code' => '02445',
                    'name' => '青森県南部町',
                    'lat' => 40.4668,
                    'lon' => 141.381912,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            38 =>
                array(
                    'admin_code' => '02446',
                    'name' => '青森県階上町',
                    'lat' => 40.452454,
                    'lon' => 141.621001,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            39 =>
                array(
                    'admin_code' => '02450',
                    'name' => '青森県新郷村',
                    'lat' => 40.465784,
                    'lon' => 141.1734,
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
