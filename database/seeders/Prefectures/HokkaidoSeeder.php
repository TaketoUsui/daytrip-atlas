<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 北海道のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class HokkaidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array(
            0 =>
                array(
                    'admin_code' => '01202',
                    'name' => '北海道函館市',
                    'lat' => 41.768712,
                    'lon' => 140.729108,
                    'office_count' => 8,
                    'main_office_count' => 1,
                ),
            1 =>
                array(
                    'admin_code' => '01203',
                    'name' => '北海道小樽市',
                    'lat' => 43.19075267,
                    'lon' => 140.99460538,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            2 =>
                array(
                    'admin_code' => '01204',
                    'name' => '北海道旭川市',
                    'lat' => 43.770799,
                    'lon' => 142.364798,
                    'office_count' => 11,
                    'main_office_count' => 1,
                ),
            3 =>
                array(
                    'admin_code' => '01205',
                    'name' => '北海道室蘭市',
                    'lat' => 42.315204,
                    'lon' => 140.973784,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            4 =>
                array(
                    'admin_code' => '01206',
                    'name' => '北海道釧路市',
                    'lat' => 42.984856,
                    'lon' => 144.38167,
                    'office_count' => 9,
                    'main_office_count' => 1,
                ),
            5 =>
                array(
                    'admin_code' => '01207',
                    'name' => '北海道帯広市',
                    'lat' => 42.924014,
                    'lon' => 143.196195,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            6 =>
                array(
                    'admin_code' => '01208',
                    'name' => '北海道北見市',
                    'lat' => 43.807823,
                    'lon' => 143.894384,
                    'office_count' => 11,
                    'main_office_count' => 1,
                ),
            7 =>
                array(
                    'admin_code' => '01209',
                    'name' => '北海道夕張市',
                    'lat' => 43.056814,
                    'lon' => 141.974069,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            8 =>
                array(
                    'admin_code' => '01211',
                    'name' => '北海道網走市',
                    'lat' => 44.020631,
                    'lon' => 144.273422,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            9 =>
                array(
                    'admin_code' => '01212',
                    'name' => '北海道留萌市',
                    'lat' => 43.940987,
                    'lon' => 141.637009,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            10 =>
                array(
                    'admin_code' => '01213',
                    'name' => '北海道苫小牧市',
                    'lat' => 42.634094,
                    'lon' => 141.605503,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            11 =>
                array(
                    'admin_code' => '01214',
                    'name' => '北海道稚内市',
                    'lat' => 45.415675,
                    'lon' => 141.673082,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            12 =>
                array(
                    'admin_code' => '01215',
                    'name' => '北海道美唄市',
                    'lat' => 43.332951,
                    'lon' => 141.853986,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            13 =>
                array(
                    'admin_code' => '01216',
                    'name' => '北海道芦別市',
                    'lat' => 43.51821,
                    'lon' => 142.189552,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            14 =>
                array(
                    'admin_code' => '01217',
                    'name' => '北海道江別市',
                    'lat' => 43.103666,
                    'lon' => 141.536103,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            15 =>
                array(
                    'admin_code' => '01218',
                    'name' => '北海道赤平市',
                    'lat' => 43.558039,
                    'lon' => 142.044223,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            16 =>
                array(
                    'admin_code' => '01219',
                    'name' => '北海道紋別市',
                    'lat' => 44.356332,
                    'lon' => 143.354279,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            17 =>
                array(
                    'admin_code' => '01221',
                    'name' => '北海道名寄市',
                    'lat' => 44.355924,
                    'lon' => 142.463134,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            18 =>
                array(
                    'admin_code' => '01222',
                    'name' => '北海道三笠市',
                    'lat' => 43.245622,
                    'lon' => 141.875342,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            19 =>
                array(
                    'admin_code' => '01223',
                    'name' => '北海道根室市',
                    'lat' => 43.330036,
                    'lon' => 145.582903,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            20 =>
                array(
                    'admin_code' => '01224',
                    'name' => '北海道千歳市',
                    'lat' => 42.821124,
                    'lon' => 141.651139,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            21 =>
                array(
                    'admin_code' => '01225',
                    'name' => '北海道滝川市',
                    'lat' => 43.557753,
                    'lon' => 141.910371,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            22 =>
                array(
                    'admin_code' => '01226',
                    'name' => '北海道砂川市',
                    'lat' => 43.494846,
                    'lon' => 141.903465,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            23 =>
                array(
                    'admin_code' => '01227',
                    'name' => '北海道歌志内市',
                    'lat' => 43.521682,
                    'lon' => 142.035353,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            24 =>
                array(
                    'admin_code' => '01228',
                    'name' => '北海道深川市',
                    'lat' => 43.723184,
                    'lon' => 142.053528,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            25 =>
                array(
                    'admin_code' => '01229',
                    'name' => '北海道富良野市',
                    'lat' => 43.342024,
                    'lon' => 142.383104,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            26 =>
                array(
                    'admin_code' => '01231',
                    'name' => '北海道恵庭市',
                    'lat' => 42.882592,
                    'lon' => 141.577799,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            27 =>
                array(
                    'admin_code' => '01233',
                    'name' => '北海道伊達市',
                    'lat' => 42.471898,
                    'lon' => 140.864702,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            28 =>
                array(
                    'admin_code' => '01234',
                    'name' => '北海道北広島市',
                    'lat' => 42.985663,
                    'lon' => 141.563625,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            29 =>
                array(
                    'admin_code' => '01235',
                    'name' => '北海道石狩市',
                    'lat' => 43.171365,
                    'lon' => 141.315514,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            30 =>
                array(
                    'admin_code' => '01236',
                    'name' => '北海道北斗市',
                    'lat' => 41.824174,
                    'lon' => 140.653067,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            31 =>
                array(
                    'admin_code' => '01303',
                    'name' => '北海道当別町',
                    'lat' => 43.22363701,
                    'lon' => 141.51700268,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            32 =>
                array(
                    'admin_code' => '01304',
                    'name' => '北海道新篠津村',
                    'lat' => 43.225368,
                    'lon' => 141.649247,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            33 =>
                array(
                    'admin_code' => '01331',
                    'name' => '北海道松前町',
                    'lat' => 41.429981,
                    'lon' => 140.110403,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            34 =>
                array(
                    'admin_code' => '01332',
                    'name' => '北海道福島町',
                    'lat' => 41.483783,
                    'lon' => 140.251315,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            35 =>
                array(
                    'admin_code' => '01333',
                    'name' => '北海道知内町',
                    'lat' => 41.598377,
                    'lon' => 140.418861,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            36 =>
                array(
                    'admin_code' => '01334',
                    'name' => '北海道木古内町',
                    'lat' => 41.678332,
                    'lon' => 140.437635,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            37 =>
                array(
                    'admin_code' => '01337',
                    'name' => '北海道七飯町',
                    'lat' => 41.895711,
                    'lon' => 140.694405,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            38 =>
                array(
                    'admin_code' => '01343',
                    'name' => '北海道鹿部町',
                    'lat' => 42.038567,
                    'lon' => 140.815907,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            39 =>
                array(
                    'admin_code' => '01345',
                    'name' => '北海道森町',
                    'lat' => 42.104992,
                    'lon' => 140.576446,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            40 =>
                array(
                    'admin_code' => '01346',
                    'name' => '北海道八雲町',
                    'lat' => 42.255918,
                    'lon' => 140.265224,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            41 =>
                array(
                    'admin_code' => '01347',
                    'name' => '北海道長万部町',
                    'lat' => 42.513488,
                    'lon' => 140.380344,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            42 =>
                array(
                    'admin_code' => '01361',
                    'name' => '北海道江差町',
                    'lat' => 41.869244,
                    'lon' => 140.12756,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            43 =>
                array(
                    'admin_code' => '01362',
                    'name' => '北海道上ノ国町',
                    'lat' => 41.801042,
                    'lon' => 140.121398,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            44 =>
                array(
                    'admin_code' => '01363',
                    'name' => '北海道厚沢部町',
                    'lat' => 41.920895,
                    'lon' => 140.225475,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            45 =>
                array(
                    'admin_code' => '01364',
                    'name' => '北海道乙部町',
                    'lat' => 41.968504,
                    'lon' => 140.13546,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            46 =>
                array(
                    'admin_code' => '01367',
                    'name' => '北海道奥尻町',
                    'lat' => 42.17226,
                    'lon' => 139.514121,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            47 =>
                array(
                    'admin_code' => '01371',
                    'name' => '北海道せたな町',
                    'lat' => 42.417145,
                    'lon' => 139.882999,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            48 =>
                array(
                    'admin_code' => '01391',
                    'name' => '北海道島牧村',
                    'lat' => 42.700471,
                    'lon' => 140.061454,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            49 =>
                array(
                    'admin_code' => '01392',
                    'name' => '北海道寿都町',
                    'lat' => 42.790984,
                    'lon' => 140.228891,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            50 =>
                array(
                    'admin_code' => '01393',
                    'name' => '北海道黒松内町',
                    'lat' => 42.667788,
                    'lon' => 140.307739,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            51 =>
                array(
                    'admin_code' => '01394',
                    'name' => '北海道蘭越町',
                    'lat' => 42.809205,
                    'lon' => 140.528346,
                    'office_count' => 5,
                    'main_office_count' => 1,
                ),
            52 =>
                array(
                    'admin_code' => '01395',
                    'name' => '北海道ニセコ町',
                    'lat' => 42.804788,
                    'lon' => 140.68754,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            53 =>
                array(
                    'admin_code' => '01396',
                    'name' => '北海道真狩村',
                    'lat' => 42.762955,
                    'lon' => 140.803669,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            54 =>
                array(
                    'admin_code' => '01397',
                    'name' => '北海道留寿都村',
                    'lat' => 42.737263,
                    'lon' => 140.875574,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            55 =>
                array(
                    'admin_code' => '01398',
                    'name' => '北海道喜茂別町',
                    'lat' => 42.795439,
                    'lon' => 140.934532,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            56 =>
                array(
                    'admin_code' => '01399',
                    'name' => '北海道京極町',
                    'lat' => 42.858216,
                    'lon' => 140.883999,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            57 =>
                array(
                    'admin_code' => '01401',
                    'name' => '北海道共和町',
                    'lat' => 42.980407,
                    'lon' => 140.611175,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            58 =>
                array(
                    'admin_code' => '01402',
                    'name' => '北海道岩内町',
                    'lat' => 42.978778,
                    'lon' => 140.509212,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            59 =>
                array(
                    'admin_code' => '01403',
                    'name' => '北海道泊村',
                    'lat' => 43.063212,
                    'lon' => 140.498857,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            60 =>
                array(
                    'admin_code' => '01404',
                    'name' => '北海道神恵内村',
                    'lat' => 43.143791,
                    'lon' => 140.430817,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            61 =>
                array(
                    'admin_code' => '01405',
                    'name' => '北海道積丹町',
                    'lat' => 43.29871,
                    'lon' => 140.598001,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            62 =>
                array(
                    'admin_code' => '01406',
                    'name' => '北海道古平町',
                    'lat' => 43.265353,
                    'lon' => 140.639078,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            63 =>
                array(
                    'admin_code' => '01407',
                    'name' => '北海道仁木町',
                    'lat' => 43.151675,
                    'lon' => 140.766168,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            64 =>
                array(
                    'admin_code' => '01408',
                    'name' => '北海道余市町',
                    'lat' => 43.195343,
                    'lon' => 140.783542,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            65 =>
                array(
                    'admin_code' => '01409',
                    'name' => '北海道赤井川村',
                    'lat' => 43.083479,
                    'lon' => 140.81364,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            66 =>
                array(
                    'admin_code' => '01423',
                    'name' => '北海道南幌町',
                    'lat' => 43.063739,
                    'lon' => 141.65033,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            67 =>
                array(
                    'admin_code' => '01424',
                    'name' => '北海道奈井江町',
                    'lat' => 43.425353,
                    'lon' => 141.882816,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            68 =>
                array(
                    'admin_code' => '01425',
                    'name' => '北海道上砂川町',
                    'lat' => 43.482538,
                    'lon' => 141.984064,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            69 =>
                array(
                    'admin_code' => '01427',
                    'name' => '北海道由仁町',
                    'lat' => 42.999598,
                    'lon' => 141.790309,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            70 =>
                array(
                    'admin_code' => '01428',
                    'name' => '北海道長沼町',
                    'lat' => 43.01034,
                    'lon' => 141.695367,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            71 =>
                array(
                    'admin_code' => '01429',
                    'name' => '北海道栗山町',
                    'lat' => 43.05629,
                    'lon' => 141.784099,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            72 =>
                array(
                    'admin_code' => '01431',
                    'name' => '北海道浦臼町',
                    'lat' => 43.430363,
                    'lon' => 141.818727,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            73 =>
                array(
                    'admin_code' => '01432',
                    'name' => '北海道新十津川町',
                    'lat' => 43.5485,
                    'lon' => 141.877009,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            74 =>
                array(
                    'admin_code' => '01433',
                    'name' => '北海道妹背牛町',
                    'lat' => 43.700093,
                    'lon' => 141.961606,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            75 =>
                array(
                    'admin_code' => '01434',
                    'name' => '北海道秩父別町',
                    'lat' => 43.767,
                    'lon' => 141.957896,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            76 =>
                array(
                    'admin_code' => '01436',
                    'name' => '北海道雨竜町',
                    'lat' => 43.643943,
                    'lon' => 141.889036,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            77 =>
                array(
                    'admin_code' => '01437',
                    'name' => '北海道北竜町',
                    'lat' => 43.731426,
                    'lon' => 141.879409,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            78 =>
                array(
                    'admin_code' => '01438',
                    'name' => '北海道沼田町',
                    'lat' => 43.80674,
                    'lon' => 141.933817,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            79 =>
                array(
                    'admin_code' => '01452',
                    'name' => '北海道鷹栖町',
                    'lat' => 43.843321,
                    'lon' => 142.354382,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            80 =>
                array(
                    'admin_code' => '01453',
                    'name' => '北海道東神楽町',
                    'lat' => 43.696303,
                    'lon' => 142.451571,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            81 =>
                array(
                    'admin_code' => '01454',
                    'name' => '北海道当麻町',
                    'lat' => 43.828201,
                    'lon' => 142.508388,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            82 =>
                array(
                    'admin_code' => '01455',
                    'name' => '北海道比布町',
                    'lat' => 43.875021,
                    'lon' => 142.477699,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            83 =>
                array(
                    'admin_code' => '01456',
                    'name' => '北海道愛別町',
                    'lat' => 43.906679,
                    'lon' => 142.577822,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            84 =>
                array(
                    'admin_code' => '01457',
                    'name' => '北海道上川町',
                    'lat' => 43.847128,
                    'lon' => 142.770459,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            85 =>
                array(
                    'admin_code' => '01458',
                    'name' => '北海道東川町',
                    'lat' => 43.698877,
                    'lon' => 142.510128,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            86 =>
                array(
                    'admin_code' => '01459',
                    'name' => '北海道美瑛町',
                    'lat' => 43.588279,
                    'lon' => 142.467055,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            87 =>
                array(
                    'admin_code' => '01461',
                    'name' => '北海道中富良野町',
                    'lat' => 43.405576,
                    'lon' => 142.425034,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            88 =>
                array(
                    'admin_code' => '01462',
                    'name' => '北海道南富良野町',
                    'lat' => 43.164088,
                    'lon' => 142.568522,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            89 =>
                array(
                    'admin_code' => '01463',
                    'name' => '北海道占冠村',
                    'lat' => 42.979836,
                    'lon' => 142.398526,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            90 =>
                array(
                    'admin_code' => '01464',
                    'name' => '北海道和寒町',
                    'lat' => 44.023119,
                    'lon' => 142.413383,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            91 =>
                array(
                    'admin_code' => '01465',
                    'name' => '北海道剣淵町',
                    'lat' => 44.095746,
                    'lon' => 142.361007,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            92 =>
                array(
                    'admin_code' => '01468',
                    'name' => '北海道下川町',
                    'lat' => 44.302576,
                    'lon' => 142.635219,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            93 =>
                array(
                    'admin_code' => '01469',
                    'name' => '北海道美深町',
                    'lat' => 44.480994,
                    'lon' => 142.342963,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            94 =>
                array(
                    'admin_code' => '01471',
                    'name' => '北海道中川町',
                    'lat' => 44.811488,
                    'lon' => 142.071409,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            95 =>
                array(
                    'admin_code' => '01472',
                    'name' => '北海道幌加内町',
                    'lat' => 44.009812,
                    'lon' => 142.153828,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            96 =>
                array(
                    'admin_code' => '01481',
                    'name' => '北海道増毛町',
                    'lat' => 43.856063,
                    'lon' => 141.524978,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            97 =>
                array(
                    'admin_code' => '01482',
                    'name' => '北海道小平町',
                    'lat' => 44.015141,
                    'lon' => 141.662828,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            98 =>
                array(
                    'admin_code' => '01483',
                    'name' => '北海道苫前町',
                    'lat' => 44.306086,
                    'lon' => 141.652932,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            99 =>
                array(
                    'admin_code' => '01484',
                    'name' => '北海道羽幌町',
                    'lat' => 44.36061,
                    'lon' => 141.697249,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            100 =>
                array(
                    'admin_code' => '01485',
                    'name' => '北海道初山別村',
                    'lat' => 44.532149,
                    'lon' => 141.766342,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            101 =>
                array(
                    'admin_code' => '01486',
                    'name' => '北海道遠別町',
                    'lat' => 44.722462,
                    'lon' => 141.792322,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            102 =>
                array(
                    'admin_code' => '01487',
                    'name' => '北海道天塩町',
                    'lat' => 44.888121,
                    'lon' => 141.745324,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            103 =>
                array(
                    'admin_code' => '01511',
                    'name' => '北海道猿払村',
                    'lat' => 45.33061,
                    'lon' => 142.108945,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            104 =>
                array(
                    'admin_code' => '01512',
                    'name' => '北海道浜頓別町',
                    'lat' => 45.123716,
                    'lon' => 142.35964,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            105 =>
                array(
                    'admin_code' => '01513',
                    'name' => '北海道中頓別町',
                    'lat' => 44.96971,
                    'lon' => 142.286705,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            106 =>
                array(
                    'admin_code' => '01514',
                    'name' => '北海道枝幸町',
                    'lat' => 44.9387,
                    'lon' => 142.581405,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            107 =>
                array(
                    'admin_code' => '01516',
                    'name' => '北海道豊富町',
                    'lat' => 45.102847,
                    'lon' => 141.777508,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            108 =>
                array(
                    'admin_code' => '01517',
                    'name' => '北海道礼文町',
                    'lat' => 45.303062,
                    'lon' => 141.047717,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            109 =>
                array(
                    'admin_code' => '01518',
                    'name' => '北海道利尻町',
                    'lat' => 45.187041,
                    'lon' => 141.139597,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            110 =>
                array(
                    'admin_code' => '01519',
                    'name' => '北海道利尻富士町',
                    'lat' => 45.247459,
                    'lon' => 141.214719,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            111 =>
                array(
                    'admin_code' => '01520',
                    'name' => '北海道幌延町',
                    'lat' => 45.017635,
                    'lon' => 141.849386,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            112 =>
                array(
                    'admin_code' => '01543',
                    'name' => '北海道美幌町',
                    'lat' => 43.823721,
                    'lon' => 144.107151,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            113 =>
                array(
                    'admin_code' => '01544',
                    'name' => '北海道津別町',
                    'lat' => 43.706316,
                    'lon' => 144.024803,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            114 =>
                array(
                    'admin_code' => '01545',
                    'name' => '北海道斜里町',
                    'lat' => 43.911441,
                    'lon' => 144.670713,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            115 =>
                array(
                    'admin_code' => '01546',
                    'name' => '北海道清里町',
                    'lat' => 43.835224,
                    'lon' => 144.594582,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            116 =>
                array(
                    'admin_code' => '01547',
                    'name' => '北海道小清水町',
                    'lat' => 43.856679,
                    'lon' => 144.462114,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            117 =>
                array(
                    'admin_code' => '01549',
                    'name' => '北海道訓子府町',
                    'lat' => 43.725328,
                    'lon' => 143.741665,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            118 =>
                array(
                    'admin_code' => '01552',
                    'name' => '北海道佐呂間町',
                    'lat' => 44.017859,
                    'lon' => 143.774714,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            119 =>
                array(
                    'admin_code' => '01555',
                    'name' => '北海道遠軽町',
                    'lat' => 44.061947,
                    'lon' => 143.527726,
                    'office_count' => 5,
                    'main_office_count' => 1,
                ),
            120 =>
                array(
                    'admin_code' => '01559',
                    'name' => '北海道湧別町',
                    'lat' => 44.151465,
                    'lon' => 143.572919,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            121 =>
                array(
                    'admin_code' => '01561',
                    'name' => '北海道興部町',
                    'lat' => 44.469874,
                    'lon' => 143.123699,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            122 =>
                array(
                    'admin_code' => '01562',
                    'name' => '北海道西興部村',
                    'lat' => 44.328833,
                    'lon' => 142.944445,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            123 =>
                array(
                    'admin_code' => '01563',
                    'name' => '北海道雄武町',
                    'lat' => 44.582482,
                    'lon' => 142.961863,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            124 =>
                array(
                    'admin_code' => '01564',
                    'name' => '北海道大空町',
                    'lat' => 43.911858,
                    'lon' => 144.172473,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            125 =>
                array(
                    'admin_code' => '01571',
                    'name' => '北海道豊浦町',
                    'lat' => 42.583464,
                    'lon' => 140.711815,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            126 =>
                array(
                    'admin_code' => '01575',
                    'name' => '北海道壮瞥町',
                    'lat' => 42.552556,
                    'lon' => 140.885472,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            127 =>
                array(
                    'admin_code' => '01578',
                    'name' => '北海道白老町',
                    'lat' => 42.551259,
                    'lon' => 141.355861,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            128 =>
                array(
                    'admin_code' => '01581',
                    'name' => '北海道厚真町',
                    'lat' => 42.723566,
                    'lon' => 141.877841,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            129 =>
                array(
                    'admin_code' => '01584',
                    'name' => '北海道洞爺湖町',
                    'lat' => 42.551223,
                    'lon' => 140.764128,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            130 =>
                array(
                    'admin_code' => '01585',
                    'name' => '北海道安平町',
                    'lat' => 42.762798,
                    'lon' => 141.818047,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            131 =>
                array(
                    'admin_code' => '01586',
                    'name' => '北海道むかわ町',
                    'lat' => 42.574741,
                    'lon' => 141.926761,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            132 =>
                array(
                    'admin_code' => '01601',
                    'name' => '北海道日高町',
                    'lat' => 42.480318,
                    'lon' => 142.074359,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            133 =>
                array(
                    'admin_code' => '01602',
                    'name' => '北海道平取町',
                    'lat' => 42.585098,
                    'lon' => 142.128525,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            134 =>
                array(
                    'admin_code' => '01604',
                    'name' => '北海道新冠町',
                    'lat' => 42.362417,
                    'lon' => 142.318315,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            135 =>
                array(
                    'admin_code' => '01607',
                    'name' => '北海道浦河町',
                    'lat' => 42.168355,
                    'lon' => 142.768213,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            136 =>
                array(
                    'admin_code' => '01608',
                    'name' => '北海道様似町',
                    'lat' => 42.127737,
                    'lon' => 142.933797,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            137 =>
                array(
                    'admin_code' => '01609',
                    'name' => '北海道えりも町',
                    'lat' => 42.016298,
                    'lon' => 143.148348,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            138 =>
                array(
                    'admin_code' => '01610',
                    'name' => '北海道新ひだか町',
                    'lat' => 42.341276,
                    'lon' => 142.368588,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            139 =>
                array(
                    'admin_code' => '01631',
                    'name' => '北海道音更町',
                    'lat' => 42.994115,
                    'lon' => 143.197869,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            140 =>
                array(
                    'admin_code' => '01632',
                    'name' => '北海道士幌町',
                    'lat' => 43.168047,
                    'lon' => 143.241344,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            141 =>
                array(
                    'admin_code' => '01633',
                    'name' => '北海道上士幌町',
                    'lat' => 43.232615,
                    'lon' => 143.296243,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            142 =>
                array(
                    'admin_code' => '01634',
                    'name' => '北海道鹿追町',
                    'lat' => 43.098876,
                    'lon' => 142.989028,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            143 =>
                array(
                    'admin_code' => '01635',
                    'name' => '北海道新得町',
                    'lat' => 43.079741,
                    'lon' => 142.838822,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            144 =>
                array(
                    'admin_code' => '01636',
                    'name' => '北海道清水町',
                    'lat' => 43.011423,
                    'lon' => 142.884568,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            145 =>
                array(
                    'admin_code' => '01637',
                    'name' => '北海道芽室町',
                    'lat' => 42.91189,
                    'lon' => 143.050807,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            146 =>
                array(
                    'admin_code' => '01638',
                    'name' => '北海道中札内村',
                    'lat' => 42.697611,
                    'lon' => 143.132443,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            147 =>
                array(
                    'admin_code' => '01639',
                    'name' => '北海道更別村',
                    'lat' => 42.650415,
                    'lon' => 143.187794,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            148 =>
                array(
                    'admin_code' => '01641',
                    'name' => '北海道大樹町',
                    'lat' => 42.497525,
                    'lon' => 143.27891,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            149 =>
                array(
                    'admin_code' => '01642',
                    'name' => '北海道広尾町',
                    'lat' => 42.285841,
                    'lon' => 143.311498,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            150 =>
                array(
                    'admin_code' => '01643',
                    'name' => '北海道幕別町',
                    'lat' => 42.908198,
                    'lon' => 143.356085,
                    'office_count' => 5,
                    'main_office_count' => 1,
                ),
            151 =>
                array(
                    'admin_code' => '01644',
                    'name' => '北海道池田町',
                    'lat' => 42.92898,
                    'lon' => 143.448472,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            152 =>
                array(
                    'admin_code' => '01645',
                    'name' => '北海道豊頃町',
                    'lat' => 42.801023,
                    'lon' => 143.5059,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            153 =>
                array(
                    'admin_code' => '01646',
                    'name' => '北海道本別町',
                    'lat' => 43.124615,
                    'lon' => 143.610962,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            154 =>
                array(
                    'admin_code' => '01647',
                    'name' => '北海道足寄町',
                    'lat' => 43.244786,
                    'lon' => 143.55393,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            155 =>
                array(
                    'admin_code' => '01648',
                    'name' => '北海道陸別町',
                    'lat' => 43.468914,
                    'lon' => 143.747305,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            156 =>
                array(
                    'admin_code' => '01649',
                    'name' => '北海道浦幌町',
                    'lat' => 42.808947,
                    'lon' => 143.658581,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            157 =>
                array(
                    'admin_code' => '01661',
                    'name' => '北海道釧路町',
                    'lat' => 42.996124,
                    'lon' => 144.466081,
                    'office_count' => 4,
                    'main_office_count' => 1,
                ),
            158 =>
                array(
                    'admin_code' => '01662',
                    'name' => '北海道厚岸町',
                    'lat' => 43.051951,
                    'lon' => 144.847443,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            159 =>
                array(
                    'admin_code' => '01663',
                    'name' => '北海道浜中町',
                    'lat' => 43.077087,
                    'lon' => 145.129391,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            160 =>
                array(
                    'admin_code' => '01664',
                    'name' => '北海道標茶町',
                    'lat' => 43.303337,
                    'lon' => 144.600665,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            161 =>
                array(
                    'admin_code' => '01665',
                    'name' => '北海道弟子屈町',
                    'lat' => 43.485352,
                    'lon' => 144.459223,
                    'office_count' => 3,
                    'main_office_count' => 1,
                ),
            162 =>
                array(
                    'admin_code' => '01667',
                    'name' => '北海道鶴居村',
                    'lat' => 43.23016,
                    'lon' => 144.321165,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            163 =>
                array(
                    'admin_code' => '01668',
                    'name' => '北海道白糠町',
                    'lat' => 42.956161,
                    'lon' => 144.071805,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            164 =>
                array(
                    'admin_code' => '01691',
                    'name' => '北海道別海町',
                    'lat' => 43.39399,
                    'lon' => 145.117341,
                    'office_count' => 5,
                    'main_office_count' => 1,
                ),
            165 =>
                array(
                    'admin_code' => '01692',
                    'name' => '北海道中標津町',
                    'lat' => 43.555191,
                    'lon' => 144.971504,
                    'office_count' => 2,
                    'main_office_count' => 1,
                ),
            166 =>
                array(
                    'admin_code' => '01693',
                    'name' => '北海道標津町',
                    'lat' => 43.661309,
                    'lon' => 145.131325,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            167 =>
                array(
                    'admin_code' => '01694',
                    'name' => '北海道羅臼町',
                    'lat' => 44.021953,
                    'lon' => 145.189532,
                    'office_count' => 1,
                    'main_office_count' => 1,
                ),
            168 =>
                array(
                    'admin_code' => '1100',
                    'name' => '北海道札幌市',
                    'lat' => 43.061972,
                    'lon' => 141.354374,
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
