<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 神奈川県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class KanagawaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array (
  0 => 
  array (
    'admin_code' => 14101,
    'name' => '神奈川県横浜市鶴見区',
    'lat' => 35.508398,
    'lon' => 139.682384,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  1 => 
  array (
    'admin_code' => 14102,
    'name' => '神奈川県横浜市神奈川区',
    'lat' => 35.477051,
    'lon' => 139.629293,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  2 => 
  array (
    'admin_code' => 14103,
    'name' => '神奈川県横浜市西区',
    'lat' => 35.453609,
    'lon' => 139.616877,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  3 => 
  array (
    'admin_code' => 14104,
    'name' => '神奈川県横浜市中区',
    'lat' => 35.444688,
    'lon' => 139.642203,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  4 => 
  array (
    'admin_code' => 14105,
    'name' => '神奈川県横浜市南区',
    'lat' => 35.431335,
    'lon' => 139.608818,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  5 => 
  array (
    'admin_code' => 14106,
    'name' => '神奈川県横浜市保土ケ谷区',
    'lat' => 35.459854,
    'lon' => 139.596029,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  6 => 
  array (
    'admin_code' => 14107,
    'name' => '神奈川県横浜市磯子区',
    'lat' => 35.402489,
    'lon' => 139.618458,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  7 => 
  array (
    'admin_code' => 14108,
    'name' => '神奈川県横浜市金沢区',
    'lat' => 35.337199,
    'lon' => 139.624497,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  8 => 
  array (
    'admin_code' => 14109,
    'name' => '神奈川県横浜市港北区',
    'lat' => 35.519016,
    'lon' => 139.633197,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  9 => 
  array (
    'admin_code' => 14111,
    'name' => '神奈川県横浜市港南区',
    'lat' => 35.400677,
    'lon' => 139.591222,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  10 => 
  array (
    'admin_code' => 14112,
    'name' => '神奈川県横浜市旭区',
    'lat' => 35.474761,
    'lon' => 139.5448,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  11 => 
  array (
    'admin_code' => 14113,
    'name' => '神奈川県横浜市緑区',
    'lat' => 35.512407,
    'lon' => 139.538011,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  12 => 
  array (
    'admin_code' => 14114,
    'name' => '神奈川県横浜市瀬谷区',
    'lat' => 35.466397,
    'lon' => 139.499188,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  13 => 
  array (
    'admin_code' => 14115,
    'name' => '神奈川県横浜市栄区',
    'lat' => 35.36439,
    'lon' => 139.554106,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  14 => 
  array (
    'admin_code' => 14116,
    'name' => '神奈川県横浜市泉区',
    'lat' => 35.417899,
    'lon' => 139.488693,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  15 => 
  array (
    'admin_code' => 14117,
    'name' => '神奈川県横浜市青葉区',
    'lat' => 35.552831,
    'lon' => 139.537092,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  16 => 
  array (
    'admin_code' => 14118,
    'name' => '神奈川県横浜市都筑区',
    'lat' => 35.544937,
    'lon' => 139.57103,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  17 => 
  array (
    'admin_code' => 14131,
    'name' => '神奈川県川崎市川崎区',
    'lat' => 35.529653,
    'lon' => 139.703707,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  18 => 
  array (
    'admin_code' => 14132,
    'name' => '神奈川県川崎市幸区',
    'lat' => 35.543882,
    'lon' => 139.687346,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  19 => 
  array (
    'admin_code' => 14133,
    'name' => '神奈川県川崎市中原区',
    'lat' => 35.576258,
    'lon' => 139.655756,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  20 => 
  array (
    'admin_code' => 14134,
    'name' => '神奈川県川崎市高津区',
    'lat' => 35.599443,
    'lon' => 139.608032,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  21 => 
  array (
    'admin_code' => 14135,
    'name' => '神奈川県川崎市多摩区',
    'lat' => 35.619609,
    'lon' => 139.562113,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  22 => 
  array (
    'admin_code' => 14136,
    'name' => '神奈川県川崎市宮前区',
    'lat' => 35.589216,
    'lon' => 139.57858,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  23 => 
  array (
    'admin_code' => 14137,
    'name' => '神奈川県川崎市麻生区',
    'lat' => 35.603769,
    'lon' => 139.505686,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  24 => 
  array (
    'admin_code' => 14151,
    'name' => '神奈川県相模原市緑区',
    'lat' => 35.595639,
    'lon' => 139.33759,
    'office_count' => 12,
    'main_office_count' => 1,
  ),
  25 => 
  array (
    'admin_code' => 14152,
    'name' => '神奈川県相模原市中央区',
    'lat' => 35.571376,
    'lon' => 139.373268,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  26 => 
  array (
    'admin_code' => 14153,
    'name' => '神奈川県相模原市南区',
    'lat' => 35.530342,
    'lon' => 139.430092,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  27 => 
  array (
    'admin_code' => 14201,
    'name' => '神奈川県横須賀市',
    'lat' => 35.281276,
    'lon' => 139.672284,
    'office_count' => 10,
    'main_office_count' => 1,
  ),
  28 => 
  array (
    'admin_code' => 14203,
    'name' => '神奈川県平塚市',
    'lat' => 35.335502,
    'lon' => 139.349412,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  29 => 
  array (
    'admin_code' => 14204,
    'name' => '神奈川県鎌倉市',
    'lat' => 35.319228,
    'lon' => 139.54669,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  30 => 
  array (
    'admin_code' => 14205,
    'name' => '神奈川県藤沢市',
    'lat' => 35.33894,
    'lon' => 139.491116,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  31 => 
  array (
    'admin_code' => 14206,
    'name' => '神奈川県小田原市',
    'lat' => 35.264694,
    'lon' => 139.152355,
    'office_count' => 10,
    'main_office_count' => 1,
  ),
  32 => 
  array (
    'admin_code' => 14207,
    'name' => '神奈川県茅ヶ崎市',
    'lat' => 35.333879,
    'lon' => 139.404702,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  33 => 
  array (
    'admin_code' => 14208,
    'name' => '神奈川県逗子市',
    'lat' => 35.295592,
    'lon' => 139.580414,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  34 => 
  array (
    'admin_code' => 14211,
    'name' => '神奈川県秦野市',
    'lat' => 35.3748,
    'lon' => 139.219946,
    'office_count' => 12,
    'main_office_count' => 1,
  ),
  35 => 
  array (
    'admin_code' => 14212,
    'name' => '神奈川県厚木市',
    'lat' => 35.443049,
    'lon' => 139.362442,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  36 => 
  array (
    'admin_code' => 14213,
    'name' => '神奈川県大和市',
    'lat' => 35.487515,
    'lon' => 139.45795,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  37 => 
  array (
    'admin_code' => 14214,
    'name' => '神奈川県伊勢原市',
    'lat' => 35.402985,
    'lon' => 139.314906,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  38 => 
  array (
    'admin_code' => 14215,
    'name' => '神奈川県海老名市',
    'lat' => 35.446449,
    'lon' => 139.390803,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  39 => 
  array (
    'admin_code' => 14216,
    'name' => '神奈川県座間市',
    'lat' => 35.48864,
    'lon' => 139.407637,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  40 => 
  array (
    'admin_code' => 14217,
    'name' => '神奈川県南足柄市',
    'lat' => 35.320633,
    'lon' => 139.099729,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  41 => 
  array (
    'admin_code' => 14218,
    'name' => '神奈川県綾瀬市',
    'lat' => 35.437161,
    'lon' => 139.426348,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  42 => 
  array (
    'admin_code' => 14301,
    'name' => '神奈川県葉山町',
    'lat' => 35.272025,
    'lon' => 139.586275,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  43 => 
  array (
    'admin_code' => 14321,
    'name' => '神奈川県寒川町',
    'lat' => 35.372963,
    'lon' => 139.384188,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  44 => 
  array (
    'admin_code' => 14341,
    'name' => '神奈川県大磯町',
    'lat' => 35.30694,
    'lon' => 139.311348,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  45 => 
  array (
    'admin_code' => 14342,
    'name' => '神奈川県二宮町',
    'lat' => 35.299494,
    'lon' => 139.255525,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  46 => 
  array (
    'admin_code' => 14361,
    'name' => '神奈川県中井町',
    'lat' => 35.330751,
    'lon' => 139.218766,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  47 => 
  array (
    'admin_code' => 14362,
    'name' => '神奈川県大井町',
    'lat' => 35.326619,
    'lon' => 139.156649,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  48 => 
  array (
    'admin_code' => 14363,
    'name' => '神奈川県松田町',
    'lat' => 35.348199,
    'lon' => 139.139337,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  49 => 
  array (
    'admin_code' => 14364,
    'name' => '神奈川県山北町',
    'lat' => 35.360631,
    'lon' => 139.083806,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  50 => 
  array (
    'admin_code' => 14366,
    'name' => '神奈川県開成町',
    'lat' => 35.33643,
    'lon' => 139.123183,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  51 => 
  array (
    'admin_code' => 14382,
    'name' => '神奈川県箱根町',
    'lat' => 35.232301,
    'lon' => 139.106886,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  52 => 
  array (
    'admin_code' => 14383,
    'name' => '神奈川県真鶴町',
    'lat' => 35.158399,
    'lon' => 139.137233,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  53 => 
  array (
    'admin_code' => 14384,
    'name' => '神奈川県湯河原町',
    'lat' => 35.147931,
    'lon' => 139.108336,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  54 => 
  array (
    'admin_code' => 14401,
    'name' => '神奈川県愛川町',
    'lat' => 35.528746,
    'lon' => 139.32172,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  55 => 
  array (
    'admin_code' => 14402,
    'name' => '神奈川県清川村',
    'lat' => 35.48233,
    'lon' => 139.276374,
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
