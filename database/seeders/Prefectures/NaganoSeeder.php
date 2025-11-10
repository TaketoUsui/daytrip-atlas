<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 長野県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class NaganoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array(
            0 =>
                array(
                    'admin_code' => '20201',
                    'name' => '長野県長野市',
                    'lat' => 36.648631,
                    'lon' => 138.19428659,
                    'office_count' => 30,
                    'main_office_count' => 1,
                ),
            1 =>
                array(
                    'admin_code' => '20202',
                    'name' => '長野県松本市',
                    'lat' => 36.238096,
                    'lon' => 137.971992,
                    'office_count' => 21,
                    'main_office_count' => 1,
                ),
            2 =>
                array(
                    'admin_code' => '20203',
                    'name' => '長野県上田市',
                    'lat' => 36.401942,
                    'lon' => 138.249069,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            3 =>
                array(
                    'admin_code' => '20204',
                    'name' => '長野県岡谷市',
                    'lat' => 36.067003,
                    'lon' => 138.049557,
                    'office_count' => 5,
                    'main_office_count' => 1,
                ),
            4 =>
                array(
                    'admin_code' => '20205',
                    'name' => '長野県飯田市',
                    'lat' => 35.514703,
                    'lon' => 137.821824,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            5 =>
                array(
                    'admin_code' => '20206',
                    'name' => '長野県諏訪市',
                    'lat' => 36.039175,
                    'lon' => 138.113984,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            6 =>
                array(
                    'admin_code' => '20207',
                    'name' => '長野県須坂市',
                    'lat' => 36.651117,
                    'lon' => 138.307275,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            7 =>
                array(
                    'admin_code' => '20208',
                    'name' => '長野県小諸市',
                    'lat' => 36.326874,
                    'lon' => 138.426021,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            8 =>
                array(
                    'admin_code' => '20209',
                    'name' => '長野県伊那市',
                    'lat' => 35.827478,
                    'lon' => 137.954083,
                    'office_count' => 9,
                    'main_office_count' => 1,
                ),
            9 =>
                array(
                    'admin_code' => '20211',
                    'name' => '長野県中野市',
                    'lat' => 36.742027,
                    'lon' => 138.36947,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            10 =>
                array(
                    'admin_code' => '20212',
                    'name' => '長野県大町市',
                    'lat' => 36.502976,
                    'lon' => 137.851169,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            11 =>
                array(
                    'admin_code' => '20213',
                    'name' => '長野県飯山市',
                    'lat' => 36.851745,
                    'lon' => 138.365498,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            12 =>
                array(
                    'admin_code' => '20214',
                    'name' => '長野県茅野市',
                    'lat' => 35.995571,
                    'lon' => 138.158896,
                    'office_count' => 11,
                    'main_office_count' => 1,
                ),
            13 =>
                array(
                    'admin_code' => '20215',
                    'name' => '長野県塩尻市',
                    'lat' => 36.11502,
                    'lon' => 137.95338,
                    'office_count' => 9,
                    'main_office_count' => 1,
                ),
            14 =>
                array(
                    'admin_code' => '20217',
                    'name' => '長野県佐久市',
                    'lat' => 36.248788,
                    'lon' => 138.476831,
                    'office_count' => 9,
                    'main_office_count' => 1,
                ),
            15 =>
                array(
                    'admin_code' => '20218',
                    'name' => '長野県千曲市',
                    'lat' => 36.533857,
                    'lon' => 138.119904,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            16 =>
                array(
                    'admin_code' => '20219',
                    'name' => '長野県東御市',
                    'lat' => 36.35955,
                    'lon' => 138.330295,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            17 =>
                array(
                    'admin_code' => '20220',
                    'name' => '長野県安曇野市',
                    'lat' => 36.302827,
                    'lon' => 137.899806,
                    'office_count' => 6,
                    'main_office_count' => 1,
                ),
            18 =>
                array(
                    'admin_code' => '20303',
                    'name' => '長野県小海町',
                    'lat' => 36.095241,
                    'lon' => 138.483515,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            19 =>
                array(
                    'admin_code' => '20304',
                    'name' => '長野県川上村',
                    'lat' => 35.975487,
                    'lon' => 138.578605,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            20 =>
                array(
                    'admin_code' => '20305',
                    'name' => '長野県南牧村',
                    'lat' => 36.020907,
                    'lon' => 138.492185,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            21 =>
                array(
                    'admin_code' => '20306',
                    'name' => '長野県南相木村',
                    'lat' => 36.036072,
                    'lon' => 138.54689,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            22 =>
                array(
                    'admin_code' => '20307',
                    'name' => '長野県北相木村',
                    'lat' => 36.059195,
                    'lon' => 138.551203,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            23 =>
                array(
                    'admin_code' => '20309',
                    'name' => '長野県佐久穂町',
                    'lat' => 36.16098,
                    'lon' => 138.483425,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            24 =>
                array(
                    'admin_code' => '20321',
                    'name' => '長野県軽井沢町',
                    'lat' => 36.34831,
                    'lon' => 138.596966,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            25 =>
                array(
                    'admin_code' => '20323',
                    'name' => '長野県御代田町',
                    'lat' => 36.321155,
                    'lon' => 138.508798,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            26 =>
                array(
                    'admin_code' => '20324',
                    'name' => '長野県立科町',
                    'lat' => 36.272089,
                    'lon' => 138.315991,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            27 =>
                array(
                    'admin_code' => '20349',
                    'name' => '長野県青木村',
                    'lat' => 36.369998,
                    'lon' => 138.128698,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            28 =>
                array(
                    'admin_code' => '20350',
                    'name' => '長野県長和町',
                    'lat' => 36.25594,
                    'lon' => 138.267791,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            29 =>
                array(
                    'admin_code' => '20361',
                    'name' => '長野県下諏訪町',
                    'lat' => 36.069577,
                    'lon' => 138.080068,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            30 =>
                array(
                    'admin_code' => '20362',
                    'name' => '長野県富士見町',
                    'lat' => 35.914652,
                    'lon' => 138.24074,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            31 =>
                array(
                    'admin_code' => '20363',
                    'name' => '長野県原村',
                    'lat' => 35.964354,
                    'lon' => 138.217471,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            32 =>
                array(
                    'admin_code' => '20382',
                    'name' => '長野県辰野町',
                    'lat' => 35.982413,
                    'lon' => 137.987428,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            33 =>
                array(
                    'admin_code' => '20383',
                    'name' => '長野県箕輪町',
                    'lat' => 35.91502,
                    'lon' => 137.981992,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            34 =>
                array(
                    'admin_code' => '20384',
                    'name' => '長野県飯島町',
                    'lat' => 35.676622,
                    'lon' => 137.919523,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            35 =>
                array(
                    'admin_code' => '20385',
                    'name' => '長野県南箕輪村',
                    'lat' => 35.872853,
                    'lon' => 137.975084,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            36 =>
                array(
                    'admin_code' => '20386',
                    'name' => '長野県中川村',
                    'lat' => 35.634617,
                    'lon' => 137.945961,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            37 =>
                array(
                    'admin_code' => '20388',
                    'name' => '長野県宮田村',
                    'lat' => 35.768882,
                    'lon' => 137.944209,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            38 =>
                array(
                    'admin_code' => '20402',
                    'name' => '長野県松川町',
                    'lat' => 35.597231,
                    'lon' => 137.909667,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            39 =>
                array(
                    'admin_code' => '20403',
                    'name' => '長野県高森町',
                    'lat' => 35.551542,
                    'lon' => 137.878519,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            40 =>
                array(
                    'admin_code' => '20404',
                    'name' => '長野県阿南町',
                    'lat' => 35.32362,
                    'lon' => 137.81609,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            41 =>
                array(
                    'admin_code' => '20407',
                    'name' => '長野県阿智村',
                    'lat' => 35.443791,
                    'lon' => 137.747444,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            42 =>
                array(
                    'admin_code' => '20409',
                    'name' => '長野県平谷村',
                    'lat' => 35.323279,
                    'lon' => 137.630083,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            43 =>
                array(
                    'admin_code' => '20411',
                    'name' => '長野県下條村',
                    'lat' => 35.39733,
                    'lon' => 137.785926,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            44 =>
                array(
                    'admin_code' => '20412',
                    'name' => '長野県売木村',
                    'lat' => 35.271068,
                    'lon' => 137.711191,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            45 =>
                array(
                    'admin_code' => '20413',
                    'name' => '長野県天龍村',
                    'lat' => 35.276307,
                    'lon' => 137.854244,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            46 =>
                array(
                    'admin_code' => '20414',
                    'name' => '長野県泰阜村',
                    'lat' => 35.377434,
                    'lon' => 137.846157,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            47 =>
                array(
                    'admin_code' => '20415',
                    'name' => '長野県喬木村',
                    'lat' => 35.513823,
                    'lon' => 137.873751,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            48 =>
                array(
                    'admin_code' => '20416',
                    'name' => '長野県豊丘村',
                    'lat' => 35.551497,
                    'lon' => 137.895791,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            49 =>
                array(
                    'admin_code' => '20417',
                    'name' => '長野県大鹿村',
                    'lat' => 35.578234,
                    'lon' => 138.034044,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            50 =>
                array(
                    'admin_code' => '20422',
                    'name' => '長野県上松町',
                    'lat' => 35.78402,
                    'lon' => 137.694153,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            51 =>
                array(
                    'admin_code' => '20423',
                    'name' => '長野県南木曽町',
                    'lat' => 35.603787,
                    'lon' => 137.608936,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            52 =>
                array(
                    'admin_code' => '20425',
                    'name' => '長野県木祖村',
                    'lat' => 35.936307,
                    'lon' => 137.783163,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            53 =>
                array(
                    'admin_code' => '20429',
                    'name' => '長野県王滝村',
                    'lat' => 35.809343,
                    'lon' => 137.551076,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            54 =>
                array(
                    'admin_code' => '20432',
                    'name' => '長野県木曽町',
                    'lat' => 35.842455,
                    'lon' => 137.691534,
                    'office_count' => 5,
                    'main_office_count' => 1,
                ),
            55 =>
                array(
                    'admin_code' => '20446',
                    'name' => '長野県麻績村',
                    'lat' => 36.456086,
                    'lon' => 138.045267,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            56 =>
                array(
                    'admin_code' => '20448',
                    'name' => '長野県生坂村',
                    'lat' => 36.425234,
                    'lon' => 137.927484,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            57 =>
                array(
                    'admin_code' => '20451',
                    'name' => '長野県朝日村',
                    'lat' => 36.123531,
                    'lon' => 137.866114,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            58 =>
                array(
                    'admin_code' => '20452',
                    'name' => '長野県筑北村',
                    'lat' => 36.426355,
                    'lon' => 138.015179,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            59 =>
                array(
                    'admin_code' => '20481',
                    'name' => '長野県池田町',
                    'lat' => 36.421368,
                    'lon' => 137.874499,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            60 =>
                array(
                    'admin_code' => '20482',
                    'name' => '長野県松川村',
                    'lat' => 36.424045,
                    'lon' => 137.854556,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            61 =>
                array(
                    'admin_code' => '20485',
                    'name' => '長野県白馬村',
                    'lat' => 36.69807,
                    'lon' => 137.861969,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            62 =>
                array(
                    'admin_code' => '20486',
                    'name' => '長野県小谷村',
                    'lat' => 36.779206,
                    'lon' => 137.908305,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            63 =>
                array(
                    'admin_code' => '20521',
                    'name' => '長野県坂城町',
                    'lat' => 36.461839,
                    'lon' => 138.180106,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            64 =>
                array(
                    'admin_code' => '20541',
                    'name' => '長野県小布施町',
                    'lat' => 36.697478,
                    'lon' => 138.312146,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            65 =>
                array(
                    'admin_code' => '20543',
                    'name' => '長野県高山村',
                    'lat' => 36.67977,
                    'lon' => 138.363261,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            66 =>
                array(
                    'admin_code' => '20561',
                    'name' => '長野県山ノ内町',
                    'lat' => 36.744606,
                    'lon' => 138.412621,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            67 =>
                array(
                    'admin_code' => '20562',
                    'name' => '長野県木島平村',
                    'lat' => 36.858462,
                    'lon' => 138.406696,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            68 =>
                array(
                    'admin_code' => '20563',
                    'name' => '長野県野沢温泉村',
                    'lat' => 36.922728,
                    'lon' => 138.440456,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            69 =>
                array(
                    'admin_code' => '20583',
                    'name' => '長野県信濃町',
                    'lat' => 36.806379,
                    'lon' => 138.206991,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            70 =>
                array(
                    'admin_code' => '20588',
                    'name' => '長野県小川村',
                    'lat' => 36.617135,
                    'lon' => 137.974801,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            71 =>
                array(
                    'admin_code' => '20590',
                    'name' => '長野県飯綱町',
                    'lat' => 36.754661,
                    'lon' => 138.23553,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            72 =>
                array(
                    'admin_code' => '20602',
                    'name' => '長野県栄村',
                    'lat' => 36.987481,
                    'lon' => 138.577359,
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
