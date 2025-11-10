<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 山形県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class YamagataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = array (
  0 => 
  array (
    'admin_code' => '06201',
    'name' => '山形県山形市',
    'lat' => 38.255436,
    'lon' => 140.339605,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  1 => 
  array (
    'admin_code' => '06202',
    'name' => '山形県米沢市',
    'lat' => 37.922242,
    'lon' => 140.116683,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  2 => 
  array (
    'admin_code' => '06203',
    'name' => '山形県鶴岡市',
    'lat' => 38.727183,
    'lon' => 139.826725,
    'office_count' => 7,
    'main_office_count' => 1,
  ),
  3 => 
  array (
    'admin_code' => '06204',
    'name' => '山形県酒田市',
    'lat' => 38.914386,
    'lon' => 139.836513,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  4 => 
  array (
    'admin_code' => '06205',
    'name' => '山形県新庄市',
    'lat' => 38.76496,
    'lon' => 140.301664,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  5 => 
  array (
    'admin_code' => '06206',
    'name' => '山形県寒河江市',
    'lat' => 38.380954,
    'lon' => 140.276068,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  6 => 
  array (
    'admin_code' => '06207',
    'name' => '山形県上山市',
    'lat' => 38.149562,
    'lon' => 140.26783,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  7 => 
  array (
    'admin_code' => '06208',
    'name' => '山形県村山市',
    'lat' => 38.483352,
    'lon' => 140.38038,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  8 => 
  array (
    'admin_code' => '06209',
    'name' => '山形県長井市',
    'lat' => 38.107486,
    'lon' => 140.040535,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  9 => 
  array (
    'admin_code' => '06211',
    'name' => '山形県東根市',
    'lat' => 38.431292,
    'lon' => 140.391021,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  10 => 
  array (
    'admin_code' => '06212',
    'name' => '山形県尾花沢市',
    'lat' => 38.60062,
    'lon' => 140.405693,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  11 => 
  array (
    'admin_code' => '06213',
    'name' => '山形県南陽市',
    'lat' => 38.055116,
    'lon' => 140.148309,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  12 => 
  array (
    'admin_code' => '06301',
    'name' => '山形県山辺町',
    'lat' => 38.289217,
    'lon' => 140.26218,
    'office_count' => 3,
    'main_office_count' => 1,
  ),
  13 => 
  array (
    'admin_code' => '06302',
    'name' => '山形県中山町',
    'lat' => 38.333122,
    'lon' => 140.283051,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  14 => 
  array (
    'admin_code' => '06321',
    'name' => '山形県河北町',
    'lat' => 38.426276,
    'lon' => 140.31431,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  15 => 
  array (
    'admin_code' => '06322',
    'name' => '山形県西川町',
    'lat' => 38.426487,
    'lon' => 140.147661,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  16 => 
  array (
    'admin_code' => '06323',
    'name' => '山形県朝日町',
    'lat' => 38.299293,
    'lon' => 140.145924,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  17 => 
  array (
    'admin_code' => '06324',
    'name' => '山形県大江町',
    'lat' => 38.380713,
    'lon' => 140.206793,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  18 => 
  array (
    'admin_code' => '06341',
    'name' => '山形県大石田町',
    'lat' => 38.593877,
    'lon' => 140.372647,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  19 => 
  array (
    'admin_code' => '06361',
    'name' => '山形県金山町',
    'lat' => 38.88344,
    'lon' => 140.339367,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  20 => 
  array (
    'admin_code' => '06362',
    'name' => '山形県最上町',
    'lat' => 38.758467,
    'lon' => 140.519359,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  21 => 
  array (
    'admin_code' => '06363',
    'name' => '山形県舟形町',
    'lat' => 38.691417,
    'lon' => 140.319988,
    'office_count' => 2,
    'main_office_count' => 1,
  ),
  22 => 
  array (
    'admin_code' => '06364',
    'name' => '山形県真室川町',
    'lat' => 38.857899,
    'lon' => 140.252367,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  23 => 
  array (
    'admin_code' => '06365',
    'name' => '山形県大蔵村',
    'lat' => 38.704121,
    'lon' => 140.230368,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  24 => 
  array (
    'admin_code' => '06366',
    'name' => '山形県鮭川村',
    'lat' => 38.796455,
    'lon' => 140.222007,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  25 => 
  array (
    'admin_code' => '06367',
    'name' => '山形県戸沢村',
    'lat' => 38.737601,
    'lon' => 140.143569,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  26 => 
  array (
    'admin_code' => '06381',
    'name' => '山形県高畠町',
    'lat' => 38.002745,
    'lon' => 140.189113,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  27 => 
  array (
    'admin_code' => '06382',
    'name' => '山形県川西町',
    'lat' => 38.004482,
    'lon' => 140.045787,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  28 => 
  array (
    'admin_code' => '06401',
    'name' => '山形県小国町',
    'lat' => 38.061391,
    'lon' => 139.743333,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  29 => 
  array (
    'admin_code' => '06402',
    'name' => '山形県白鷹町',
    'lat' => 38.183069,
    'lon' => 140.098571,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  30 => 
  array (
    'admin_code' => '06403',
    'name' => '山形県飯豊町',
    'lat' => 38.045714,
    'lon' => 139.987617,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  31 => 
  array (
    'admin_code' => '06426',
    'name' => '山形県三川町',
    'lat' => 38.794529,
    'lon' => 139.849612,
    'office_count' => 1,
    'main_office_count' => 1,
  ),
  32 => 
  array (
    'admin_code' => '06428',
    'name' => '山形県庄内町',
    'lat' => 38.849845,
    'lon' => 139.904723,
    'office_count' => 4,
    'main_office_count' => 1,
  ),
  33 => 
  array (
    'admin_code' => '06461',
    'name' => '山形県遊佐町',
    'lat' => 39.014585,
    'lon' => 139.907338,
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
