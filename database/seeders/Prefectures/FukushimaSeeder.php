<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 福島県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class FukushimaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array (
  0 => 
  array (
    'admin_code' => '07201',
    'name' => '福島県福島市',
    'lat' => 37.760759,
    'lon' => 140.473269,
    'office_count' => 19,
    'main_office_count' => 1,
  ),
  1 => 
  array (
    'admin_code' => '07202',
    'name' => '福島県会津若松市',
    'lat' => 37.494842,
    'lon' => 139.929707,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  2 => 
  array (
    'admin_code' => '07203',
    'name' => '福島県郡山市',
    'lat' => 37.400455,
    'lon' => 140.35965,
    'office_count' => 19,
    'main_office_count' => 1,
  ),
  3 => 
  array (
    'admin_code' => '07204',
    'name' => '福島県いわき市',
    'lat' => 37.050456,
    'lon' => 140.887687,
    'office_count' => 14,
    'main_office_count' => 1,
  ),
  4 => 
  array (
    'admin_code' => '07205',
    'name' => '福島県白河市',
    'lat' => 37.126379,
    'lon' => 140.210923,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  5 => 
  array (
    'admin_code' => '07207',
    'name' => '福島県須賀川市',
    'lat' => 37.289441,
    'lon' => 140.354272,
    'office_count' => 6,
    'main_office_count' => 1,
  ),
  6 => 
  array (
    'admin_code' => '07208',
    'name' => '福島県喜多方市',
    'lat' => 37.651134,
    'lon' => 139.874484,
    'office_count' => 6,
    'main_office_count' => 1,
  ),
  7 => 
  array (
    'admin_code' => '07209',
    'name' => '福島県相馬市',
    'lat' => 37.796525,
    'lon' => 140.919628,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  8 => 
  array (
    'admin_code' => '07211',
    'name' => '福島県田村市',
    'lat' => 37.441366,
    'lon' => 140.569098,
    'office_count' => 12,
    'main_office_count' => 1,
  ),
  9 => 
  array (
    'admin_code' => '07212',
    'name' => '福島県南相馬市',
    'lat' => 37.642197,
    'lon' => 140.957237,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  10 => 
  array (
    'admin_code' => '07213',
    'name' => '福島県伊達市',
    'lat' => 37.819095,
    'lon' => 140.562894,
    'office_count' => 5,
    'main_office_count' => 1,
  ),
  11 => 
  array (
    'admin_code' => '07214',
    'name' => '福島県本宮市',
    'lat' => 37.513162,
    'lon' => 140.393877,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  12 => 
  array (
    'admin_code' => '07301',
    'name' => '福島県桑折町',
    'lat' => 37.849373,
    'lon' => 140.516424,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  13 => 
  array (
    'admin_code' => '07303',
    'name' => '福島県国見町',
    'lat' => 37.877097,
    'lon' => 140.542346,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  14 => 
  array (
    'admin_code' => '07308',
    'name' => '福島県川俣町',
    'lat' => 37.664989,
    'lon' => 140.598244,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  15 => 
  array (
    'admin_code' => '07322',
    'name' => '福島県大玉村',
    'lat' => 37.534362,
    'lon' => 140.371058,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  16 => 
  array (
    'admin_code' => '07342',
    'name' => '福島県鏡石町',
    'lat' => 37.252858,
    'lon' => 140.343405,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  17 => 
  array (
    'admin_code' => '07344',
    'name' => '福島県天栄村',
    'lat' => 37.255576,
    'lon' => 140.247165,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  18 => 
  array (
    'admin_code' => '07362',
    'name' => '福島県下郷町',
    'lat' => 37.255571,
    'lon' => 139.872084,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  19 => 
  array (
    'admin_code' => '07364',
    'name' => '福島県檜枝岐村',
    'lat' => 37.024141,
    'lon' => 139.388941,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  20 => 
  array (
    'admin_code' => '07367',
    'name' => '福島県只見町',
    'lat' => 37.348657,
    'lon' => 139.315789,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  21 => 
  array (
    'admin_code' => '07368',
    'name' => '福島県南会津町',
    'lat' => 37.200389,
    'lon' => 139.773215,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  22 => 
  array (
    'admin_code' => '07402',
    'name' => '福島県北塩原村',
    'lat' => 37.655673,
    'lon' => 139.937383,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  23 => 
  array (
    'admin_code' => '07405',
    'name' => '福島県西会津町',
    'lat' => 37.588823,
    'lon' => 139.647522,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  24 => 
  array (
    'admin_code' => '07407',
    'name' => '福島県磐梯町',
    'lat' => 37.562099,
    'lon' => 139.988766,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  25 => 
  array (
    'admin_code' => '07408',
    'name' => '福島県猪苗代町',
    'lat' => 37.557799,
    'lon' => 140.104794,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  26 => 
  array (
    'admin_code' => '07421',
    'name' => '福島県会津坂下町',
    'lat' => 37.561457,
    'lon' => 139.821732,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  27 => 
  array (
    'admin_code' => '07422',
    'name' => '福島県湯川村',
    'lat' => 37.565657,
    'lon' => 139.886738,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  28 => 
  array (
    'admin_code' => '07423',
    'name' => '福島県柳津町',
    'lat' => 37.526035,
    'lon' => 139.719552,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  29 => 
  array (
    'admin_code' => '07444',
    'name' => '福島県三島町',
    'lat' => 37.470292,
    'lon' => 139.644441,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  30 => 
  array (
    'admin_code' => '07445',
    'name' => '福島県金山町',
    'lat' => 37.453735,
    'lon' => 139.524524,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  31 => 
  array (
    'admin_code' => '07446',
    'name' => '福島県昭和村',
    'lat' => 37.335446,
    'lon' => 139.610666,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  32 => 
  array (
    'admin_code' => '07447',
    'name' => '福島県会津美里町',
    'lat' => 37.459835,
    'lon' => 139.841143,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  33 => 
  array (
    'admin_code' => '07461',
    'name' => '福島県西郷村',
    'lat' => 37.141767,
    'lon' => 140.155299,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  34 => 
  array (
    'admin_code' => '07464',
    'name' => '福島県泉崎村',
    'lat' => 37.157052,
    'lon' => 140.295257,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  35 => 
  array (
    'admin_code' => '07465',
    'name' => '福島県中島村',
    'lat' => 37.148756,
    'lon' => 140.35023,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  36 => 
  array (
    'admin_code' => '07466',
    'name' => '福島県矢吹町',
    'lat' => 37.201221,
    'lon' => 140.338493,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  37 => 
  array (
    'admin_code' => '07481',
    'name' => '福島県棚倉町',
    'lat' => 37.029867,
    'lon' => 140.379591,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  38 => 
  array (
    'admin_code' => '07482',
    'name' => '福島県矢祭町',
    'lat' => 36.871334,
    'lon' => 140.424755,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  39 => 
  array (
    'admin_code' => '07483',
    'name' => '福島県塙町',
    'lat' => 36.957238,
    'lon' => 140.409647,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  40 => 
  array (
    'admin_code' => '07484',
    'name' => '福島県鮫川村',
    'lat' => 37.042229,
    'lon' => 140.509699,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  41 => 
  array (
    'admin_code' => '07501',
    'name' => '福島県石川町',
    'lat' => 37.144301,
    'lon' => 140.452117,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  42 => 
  array (
    'admin_code' => '07502',
    'name' => '福島県玉川村',
    'lat' => 37.210718,
    'lon' => 140.408939,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  43 => 
  array (
    'admin_code' => '07503',
    'name' => '福島県平田村',
    'lat' => 37.217885,
    'lon' => 140.570258,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  44 => 
  array (
    'admin_code' => '07504',
    'name' => '福島県浅川町',
    'lat' => 37.080947,
    'lon' => 140.412852,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  45 => 
  array (
    'admin_code' => '07505',
    'name' => '福島県古殿町',
    'lat' => 37.089182,
    'lon' => 140.555692,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  46 => 
  array (
    'admin_code' => '07521',
    'name' => '福島県三春町',
    'lat' => 37.441047,
    'lon' => 140.492575,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  47 => 
  array (
    'admin_code' => '07522',
    'name' => '福島県小野町',
    'lat' => 37.286823,
    'lon' => 140.62628,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  48 => 
  array (
    'admin_code' => '07541',
    'name' => '福島県広野町',
    'lat' => 37.214403,
    'lon' => 140.994561,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  49 => 
  array (
    'admin_code' => '07542',
    'name' => '福島県楢葉町役場（移転中）',
    'lat' => 37.282605,
    'lon' => 140.993465,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  50 => 
  array (
    'admin_code' => '07543',
    'name' => '福島県富岡町役場（移転中）',
    'lat' => 37.345496,
    'lon' => 141.008652,
    'office_count' => 6,
    'main_office_count' => 1,
  ),
  51 => 
  array (
    'admin_code' => '07544',
    'name' => '福島県川内村',
    'lat' => 37.33768,
    'lon' => 140.809266,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  52 => 
  array (
    'admin_code' => '07545',
    'name' => '福島県大熊町役場（移転中）',
    'lat' => 37.404434,
    'lon' => 140.9834,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  53 => 
  array (
    'admin_code' => '07546',
    'name' => '福島県双葉町役場（移転中）',
    'lat' => 37.449126,
    'lon' => 141.012273,
    'office_count' => 7,
    'main_office_count' => 1,
  ),
  54 => 
  array (
    'admin_code' => '07547',
    'name' => '福島県浪江町役場（移転中）',
    'lat' => 37.49459414,
    'lon' => 141.00074586,
    'office_count' => 8,
    'main_office_count' => 1,
  ),
  55 => 
  array (
    'admin_code' => '07548',
    'name' => '福島県葛尾村役場（移転中）',
    'lat' => 37.503547,
    'lon' => 140.764518,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  56 => 
  array (
    'admin_code' => '07561',
    'name' => '福島県新地町',
    'lat' => 37.876379,
    'lon' => 140.919591,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  57 => 
  array (
    'admin_code' => '07564',
    'name' => '福島県飯舘村役場（移転中）',
    'lat' => 37.678947,
    'lon' => 140.735091,
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
