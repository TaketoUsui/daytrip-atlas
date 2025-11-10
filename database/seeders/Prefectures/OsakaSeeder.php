<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 大阪府のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class OsakaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array (
  0 => 
  array (
    'admin_code' => 27102,
    'name' => '大阪府大阪市都島区',
    'lat' => 34.701279,
    'lon' => 135.52809,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  1 => 
  array (
    'admin_code' => 27103,
    'name' => '大阪府大阪市福島区',
    'lat' => 34.692357,
    'lon' => 135.472232,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  2 => 
  array (
    'admin_code' => 27104,
    'name' => '大阪府大阪市此花区',
    'lat' => 34.683038,
    'lon' => 135.452225,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  3 => 
  array (
    'admin_code' => 27106,
    'name' => '大阪府大阪市西区',
    'lat' => 34.676384,
    'lon' => 135.486111,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  4 => 
  array (
    'admin_code' => 27107,
    'name' => '大阪府大阪市港区',
    'lat' => 34.663918,
    'lon' => 135.460611,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  5 => 
  array (
    'admin_code' => 27108,
    'name' => '大阪府大阪市大正区',
    'lat' => 34.650417,
    'lon' => 135.472694,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  6 => 
  array (
    'admin_code' => 27109,
    'name' => '大阪府大阪市天王寺区',
    'lat' => 34.657869,
    'lon' => 135.51937,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  7 => 
  array (
    'admin_code' => 27111,
    'name' => '大阪府大阪市浪速区',
    'lat' => 34.659419,
    'lon' => 135.49955,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  8 => 
  array (
    'admin_code' => 27113,
    'name' => '大阪府大阪市西淀川区',
    'lat' => 34.711409,
    'lon' => 135.456202,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  9 => 
  array (
    'admin_code' => 27114,
    'name' => '大阪府大阪市東淀川区',
    'lat' => 34.741313,
    'lon' => 135.52934,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  10 => 
  array (
    'admin_code' => 27115,
    'name' => '大阪府大阪市東成区',
    'lat' => 34.669996,
    'lon' => 135.541223,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  11 => 
  array (
    'admin_code' => 27116,
    'name' => '大阪府大阪市生野区',
    'lat' => 34.653745,
    'lon' => 135.534447,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  12 => 
  array (
    'admin_code' => 27117,
    'name' => '大阪府大阪市旭区',
    'lat' => 34.721266,
    'lon' => 135.544142,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  13 => 
  array (
    'admin_code' => 27118,
    'name' => '大阪府大阪市城東区',
    'lat' => 34.702013,
    'lon' => 135.545987,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  14 => 
  array (
    'admin_code' => 27119,
    'name' => '大阪府大阪市阿倍野区',
    'lat' => 34.638969,
    'lon' => 135.518499,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  15 => 
  array (
    'admin_code' => 27121,
    'name' => '大阪府大阪市東住吉区',
    'lat' => 34.622118,
    'lon' => 135.526612,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  16 => 
  array (
    'admin_code' => 27122,
    'name' => '大阪府大阪市西成区',
    'lat' => 34.635058,
    'lon' => 135.494587,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  17 => 
  array (
    'admin_code' => 27123,
    'name' => '大阪府大阪市淀川区',
    'lat' => 34.721006,
    'lon' => 135.486746,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  18 => 
  array (
    'admin_code' => 27124,
    'name' => '大阪府大阪市鶴見区',
    'lat' => 34.704566,
    'lon' => 135.57419,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  19 => 
  array (
    'admin_code' => 27125,
    'name' => '大阪府大阪市住之江区',
    'lat' => 34.60967,
    'lon' => 135.482717,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  20 => 
  array (
    'admin_code' => 27126,
    'name' => '大阪府大阪市平野区',
    'lat' => 34.62116,
    'lon' => 135.545999,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  21 => 
  array (
    'admin_code' => 27127,
    'name' => '大阪府大阪市北区',
    'lat' => 34.705581,
    'lon' => 135.510095,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  22 => 
  array (
    'admin_code' => 27128,
    'name' => '大阪府大阪市中央区',
    'lat' => 34.681225,
    'lon' => 135.509687,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  23 => 
  array (
    'admin_code' => 27141,
    'name' => '大阪府堺市堺区',
    'lat' => 34.573354,
    'lon' => 135.48302,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  24 => 
  array (
    'admin_code' => 27142,
    'name' => '大阪府堺市中区',
    'lat' => 34.528312,
    'lon' => 135.498724,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  25 => 
  array (
    'admin_code' => 27143,
    'name' => '大阪府堺市東区',
    'lat' => 34.538228,
    'lon' => 135.536474,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  26 => 
  array (
    'admin_code' => 27144,
    'name' => '大阪府堺市西区',
    'lat' => 34.535063,
    'lon' => 135.464014,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  27 => 
  array (
    'admin_code' => 27145,
    'name' => '大阪府堺市南区',
    'lat' => 34.486444,
    'lon' => 135.49054,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  28 => 
  array (
    'admin_code' => 27146,
    'name' => '大阪府堺市北区',
    'lat' => 34.565478,
    'lon' => 135.517192,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  29 => 
  array (
    'admin_code' => 27147,
    'name' => '大阪府堺市美原区',
    'lat' => 34.538483,
    'lon' => 135.559827,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  30 => 
  array (
    'admin_code' => 27202,
    'name' => '大阪府岸和田市',
    'lat' => 34.460597,
    'lon' => 135.370871,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  31 => 
  array (
    'admin_code' => 27203,
    'name' => '大阪府豊中市',
    'lat' => 34.781239,
    'lon' => 135.469889,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  32 => 
  array (
    'admin_code' => 27204,
    'name' => '大阪府池田市',
    'lat' => 34.821686,
    'lon' => 135.428555,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  33 => 
  array (
    'admin_code' => 27205,
    'name' => '大阪府吹田市',
    'lat' => 34.759405,
    'lon' => 135.516799,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  34 => 
  array (
    'admin_code' => 27206,
    'name' => '大阪府泉大津市',
    'lat' => 34.504268,
    'lon' => 135.410472,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  35 => 
  array (
    'admin_code' => 27207,
    'name' => '大阪府高槻市',
    'lat' => 34.8461,
    'lon' => 135.617216,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  36 => 
  array (
    'admin_code' => 27208,
    'name' => '大阪府貝塚市',
    'lat' => 34.437686,
    'lon' => 135.358431,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  37 => 
  array (
    'admin_code' => 27209,
    'name' => '大阪府守口市',
    'lat' => 34.73768,
    'lon' => 135.563971,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  38 => 
  array (
    'admin_code' => 27211,
    'name' => '大阪府茨木市',
    'lat' => 34.816153,
    'lon' => 135.568503,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  39 => 
  array (
    'admin_code' => 27212,
    'name' => '大阪府八尾市',
    'lat' => 34.626884,
    'lon' => 135.600948,
    'office_count' => 11,
    'main_office_count' => 1,
  ),
  40 => 
  array (
    'admin_code' => 27213,
    'name' => '大阪府泉佐野市',
    'lat' => 34.406839,
    'lon' => 135.327337,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  41 => 
  array (
    'admin_code' => 27214,
    'name' => '大阪府富田林市',
    'lat' => 34.499675,
    'lon' => 135.59728,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  42 => 
  array (
    'admin_code' => 27215,
    'name' => '大阪府寝屋川市',
    'lat' => 34.766079,
    'lon' => 135.628008,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  43 => 
  array (
    'admin_code' => 27216,
    'name' => '大阪府河内長野市',
    'lat' => 34.458107,
    'lon' => 135.564119,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  44 => 
  array (
    'admin_code' => 27217,
    'name' => '大阪府松原市',
    'lat' => 34.577901,
    'lon' => 135.551786,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  45 => 
  array (
    'admin_code' => 27218,
    'name' => '大阪府大東市',
    'lat' => 34.712013,
    'lon' => 135.623471,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  46 => 
  array (
    'admin_code' => 27219,
    'name' => '大阪府和泉市',
    'lat' => 34.483635,
    'lon' => 135.423624,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  47 => 
  array (
    'admin_code' => 27221,
    'name' => '大阪府柏原市',
    'lat' => 34.579305,
    'lon' => 135.628642,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  48 => 
  array (
    'admin_code' => 27222,
    'name' => '大阪府羽曳野市',
    'lat' => 34.558002,
    'lon' => 135.606226,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  49 => 
  array (
    'admin_code' => 27223,
    'name' => '大阪府門真市',
    'lat' => 34.739145,
    'lon' => 135.586899,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  50 => 
  array (
    'admin_code' => 27224,
    'name' => '大阪府摂津市',
    'lat' => 34.777387,
    'lon' => 135.561886,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  51 => 
  array (
    'admin_code' => 27225,
    'name' => '大阪府高石市',
    'lat' => 34.520673,
    'lon' => 135.442395,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  52 => 
  array (
    'admin_code' => 27226,
    'name' => '大阪府藤井寺市',
    'lat' => 34.574283,
    'lon' => 135.597476,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  53 => 
  array (
    'admin_code' => 27227,
    'name' => '大阪府東大阪市',
    'lat' => 34.679324,
    'lon' => 135.600898,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  54 => 
  array (
    'admin_code' => 27228,
    'name' => '大阪府泉南市',
    'lat' => 34.366007,
    'lon' => 135.2733,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  55 => 
  array (
    'admin_code' => 27229,
    'name' => '大阪府四條畷市',
    'lat' => 34.740064,
    'lon' => 135.639727,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  56 => 
  array (
    'admin_code' => 27231,
    'name' => '大阪府大阪狭山市',
    'lat' => 34.503718,
    'lon' => 135.555748,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  57 => 
  array (
    'admin_code' => 27232,
    'name' => '大阪府阪南市',
    'lat' => 34.359594,
    'lon' => 135.239656,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  58 => 
  array (
    'admin_code' => 27301,
    'name' => '大阪府島本町',
    'lat' => 34.883819,
    'lon' => 135.663009,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  59 => 
  array (
    'admin_code' => 27321,
    'name' => '大阪府豊能町',
    'lat' => 34.91885,
    'lon' => 135.494096,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  60 => 
  array (
    'admin_code' => 27322,
    'name' => '大阪府能勢町',
    'lat' => 34.972445,
    'lon' => 135.414189,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  61 => 
  array (
    'admin_code' => 27341,
    'name' => '大阪府忠岡町',
    'lat' => 34.487125,
    'lon' => 135.401497,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  62 => 
  array (
    'admin_code' => 27361,
    'name' => '大阪府熊取町',
    'lat' => 34.401308,
    'lon' => 135.355863,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  63 => 
  array (
    'admin_code' => 27362,
    'name' => '大阪府田尻町',
    'lat' => 34.393782,
    'lon' => 135.291176,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  64 => 
  array (
    'admin_code' => 27366,
    'name' => '大阪府岬町',
    'lat' => 34.3169,
    'lon' => 135.142085,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  65 => 
  array (
    'admin_code' => 27381,
    'name' => '大阪府太子町',
    'lat' => 34.518656,
    'lon' => 135.647734,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  66 => 
  array (
    'admin_code' => 27382,
    'name' => '大阪府河南町',
    'lat' => 34.491637,
    'lon' => 135.62988,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  67 => 
  array (
    'admin_code' => 27383,
    'name' => '大阪府千早赤阪村',
    'lat' => 34.464601,
    'lon' => 135.622531,
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
