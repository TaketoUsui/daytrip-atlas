<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 岐阜県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class GifuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = [
            0 => [
                'admin_code' => '21201',
                'name' => '岐阜県岐阜市',
                'lat' => 35.423301,
                'lon' => 136.760657,
                'office_count' => 16,
                'main_office_count' => 1,
            ],
            1 => [
                'admin_code' => '21202',
                'name' => '岐阜県大垣市',
                'lat' => 35.359365,
                'lon' => 136.612753,
                'office_count' => 6,
                'main_office_count' => 1,
            ],
            2 => [
                'admin_code' => '21203',
                'name' => '岐阜県高山市',
                'lat' => 36.146093,
                'lon' => 137.252206,
                'office_count' => 10,
                'main_office_count' => 1,
            ],
            3 => [
                'admin_code' => '21204',
                'name' => '岐阜県多治見市',
                'lat' => 35.332773,
                'lon' => 137.132078,
                'office_count' => 12,
                'main_office_count' => 1,
            ],
            4 => [
                'admin_code' => '21205',
                'name' => '岐阜県関市',
                'lat' => 35.495777,
                'lon' => 136.917895,
                'office_count' => 7,
                'main_office_count' => 1,
            ],
            5 => [
                'admin_code' => '21206',
                'name' => '岐阜県中津川市',
                'lat' => 35.487493,
                'lon' => 137.500616,
                'office_count' => 8,
                'main_office_count' => 1,
            ],
            6 => [
                'admin_code' => '21207',
                'name' => '岐阜県美濃市',
                'lat' => 35.544713,
                'lon' => 136.90757,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            7 => [
                'admin_code' => '21208',
                'name' => '岐阜県瑞浪市',
                'lat' => 35.36174,
                'lon' => 137.254639,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            8 => [
                'admin_code' => '21209',
                'name' => '岐阜県羽島市',
                'lat' => 35.31991,
                'lon' => 136.703349,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            9 => [
                'admin_code' => '21211',
                'name' => '岐阜県美濃加茂市',
                'lat' => 35.440242,
                'lon' => 137.015664,
                'office_count' => 8,
                'main_office_count' => 1,
            ],
            10 => [
                'admin_code' => '21212',
                'name' => '岐阜県土岐市',
                'lat' => 35.352497,
                'lon' => 137.183205,
                'office_count' => 6,
                'main_office_count' => 1,
            ],
            11 => [
                'admin_code' => '21213',
                'name' => '岐阜県各務原市',
                'lat' => 35.398912,
                'lon' => 136.848393,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            12 => [
                'admin_code' => '21214',
                'name' => '岐阜県可児市',
                'lat' => 35.426132,
                'lon' => 137.061075,
                'office_count' => 13,
                'main_office_count' => 1,
            ],
            13 => [
                'admin_code' => '21215',
                'name' => '岐阜県山県市',
                'lat' => 35.506111,
                'lon' => 136.781401,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            14 => [
                'admin_code' => '21216',
                'name' => '岐阜県瑞穂市',
                'lat' => 35.391826,
                'lon' => 136.690784,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            15 => [
                'admin_code' => '21217',
                'name' => '岐阜県飛騨市',
                'lat' => 36.238144,
                'lon' => 137.186246,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            16 => [
                'admin_code' => '21218',
                'name' => '岐阜県本巣市',
                'lat' => 35.483052,
                'lon' => 136.678771,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            17 => [
                'admin_code' => '21219',
                'name' => '岐阜県郡上市',
                'lat' => 35.748569,
                'lon' => 136.964368,
                'office_count' => 8,
                'main_office_count' => 1,
            ],
            18 => [
                'admin_code' => '21221',
                'name' => '岐阜県海津市',
                'lat' => 35.22047,
                'lon' => 136.636612,
                'office_count' => 5,
                'main_office_count' => 1,
            ],
            19 => [
                'admin_code' => '21302',
                'name' => '岐阜県岐南町',
                'lat' => 35.389594,
                'lon' => 136.78262,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            20 => [
                'admin_code' => '21303',
                'name' => '岐阜県笠松町',
                'lat' => 35.367222,
                'lon' => 136.763192,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            21 => [
                'admin_code' => '21341',
                'name' => '岐阜県養老町',
                'lat' => 35.308411,
                'lon' => 136.561359,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            22 => [
                'admin_code' => '21361',
                'name' => '岐阜県垂井町',
                'lat' => 35.370244,
                'lon' => 136.527095,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            23 => [
                'admin_code' => '21362',
                'name' => '岐阜県関ケ原町',
                'lat' => 35.365523,
                'lon' => 136.466976,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            24 => [
                'admin_code' => '21381',
                'name' => '岐阜県神戸町',
                'lat' => 35.417349,
                'lon' => 136.608517,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            25 => [
                'admin_code' => '21382',
                'name' => '岐阜県輪之内町',
                'lat' => 35.285113,
                'lon' => 136.637444,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            26 => [
                'admin_code' => '21383',
                'name' => '岐阜県安八町',
                'lat' => 35.335418,
                'lon' => 136.665415,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            27 => [
                'admin_code' => '21401',
                'name' => '岐阜県揖斐川町',
                'lat' => 35.486948,
                'lon' => 136.5682,
                'office_count' => 6,
                'main_office_count' => 1,
            ],
            28 => [
                'admin_code' => '21403',
                'name' => '岐阜県大野町',
                'lat' => 35.470675,
                'lon' => 136.627636,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            29 => [
                'admin_code' => '21404',
                'name' => '岐阜県池田町',
                'lat' => 35.4423,
                'lon' => 136.572851,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            30 => [
                'admin_code' => '21421',
                'name' => '岐阜県北方町',
                'lat' => 35.436961,
                'lon' => 136.685972,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            31 => [
                'admin_code' => '21501',
                'name' => '岐阜県坂祝町',
                'lat' => 35.426734,
                'lon' => 136.98537,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            32 => [
                'admin_code' => '21502',
                'name' => '岐阜県富加町',
                'lat' => 35.484761,
                'lon' => 136.979707,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            33 => [
                'admin_code' => '21503',
                'name' => '岐阜県川辺町',
                'lat' => 35.486548,
                'lon' => 137.070605,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            34 => [
                'admin_code' => '21504',
                'name' => '岐阜県七宗町',
                'lat' => 35.54384,
                'lon' => 137.119946,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            35 => [
                'admin_code' => '21505',
                'name' => '岐阜県八百津町',
                'lat' => 35.475988,
                'lon' => 137.141499,
                'office_count' => 6,
                'main_office_count' => 1,
            ],
            36 => [
                'admin_code' => '21506',
                'name' => '岐阜県白川町',
                'lat' => 35.581862,
                'lon' => 137.187821,
                'office_count' => 5,
                'main_office_count' => 1,
            ],
            37 => [
                'admin_code' => '21507',
                'name' => '岐阜県東白川村',
                'lat' => 35.64256,
                'lon' => 137.323745,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            38 => [
                'admin_code' => '21521',
                'name' => '岐阜県御嵩町',
                'lat' => 35.434493,
                'lon' => 137.130885,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            39 => [
                'admin_code' => '21604',
                'name' => '岐阜県白川村',
                'lat' => 36.270904,
                'lon' => 136.898542,
                'office_count' => 2,
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
