<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 茨城県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class IbarakiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = [
            0 => [
                'admin_code' => '08201',
                'name' => '茨城県水戸市',
                'lat' => 36.365861,
                'lon' => 140.471222,
                'office_count' => 5,
                'main_office_count' => 1,
            ],
            1 => [
                'admin_code' => '08202',
                'name' => '茨城県日立市',
                'lat' => 36.599016,
                'lon' => 140.651546,
                'office_count' => 7,
                'main_office_count' => 1,
            ],
            2 => [
                'admin_code' => '08203',
                'name' => '茨城県土浦市',
                'lat' => 36.07187,
                'lon' => 140.196057,
                'office_count' => 7,
                'main_office_count' => 1,
            ],
            3 => [
                'admin_code' => '08204',
                'name' => '茨城県古河市',
                'lat' => 36.178228,
                'lon' => 139.755371,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            4 => [
                'admin_code' => '08205',
                'name' => '茨城県石岡市',
                'lat' => 36.19084,
                'lon' => 140.287242,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            5 => [
                'admin_code' => '08207',
                'name' => '茨城県結城市',
                'lat' => 36.305264,
                'lon' => 139.877154,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            6 => [
                'admin_code' => '08208',
                'name' => '茨城県龍ケ崎市',
                'lat' => 35.911594,
                'lon' => 140.182265,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            7 => [
                'admin_code' => '08211',
                'name' => '茨城県常総市',
                'lat' => 36.023563,
                'lon' => 139.993934,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            8 => [
                'admin_code' => '08212',
                'name' => '茨城県常陸太田市',
                'lat' => 36.538227,
                'lon' => 140.530929,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            9 => [
                'admin_code' => '08214',
                'name' => '茨城県高萩市',
                'lat' => 36.71871991,
                'lon' => 140.71683044,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            10 => [
                'admin_code' => '08215',
                'name' => '茨城県北茨城市',
                'lat' => 36.801892,
                'lon' => 140.751032,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            11 => [
                'admin_code' => '08216',
                'name' => '茨城県笠間市',
                'lat' => 36.345128,
                'lon' => 140.304232,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            12 => [
                'admin_code' => '08217',
                'name' => '茨城県取手市',
                'lat' => 35.911474,
                'lon' => 140.050305,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            13 => [
                'admin_code' => '08219',
                'name' => '茨城県牛久市',
                'lat' => 35.979397,
                'lon' => 140.149532,
                'office_count' => 5,
                'main_office_count' => 1,
            ],
            14 => [
                'admin_code' => '08221',
                'name' => '茨城県ひたちなか市',
                'lat' => 36.396615,
                'lon' => 140.534676,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            15 => [
                'admin_code' => '08222',
                'name' => '茨城県鹿嶋市',
                'lat' => 35.9657207,
                'lon' => 140.64485242,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            16 => [
                'admin_code' => '08223',
                'name' => '茨城県潮来市',
                'lat' => 35.947134,
                'lon' => 140.555364,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            17 => [
                'admin_code' => '08224',
                'name' => '茨城県守谷市',
                'lat' => 35.95132697,
                'lon' => 139.97546532,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            18 => [
                'admin_code' => '08225',
                'name' => '茨城県常陸大宮市',
                'lat' => 36.542592,
                'lon' => 140.411012,
                'office_count' => 5,
                'main_office_count' => 1,
            ],
            19 => [
                'admin_code' => '08226',
                'name' => '茨城県那珂市',
                'lat' => 36.457424,
                'lon' => 140.486726,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            20 => [
                'admin_code' => '08227',
                'name' => '茨城県筑西市',
                'lat' => 36.307115,
                'lon' => 139.983069,
                'office_count' => 6,
                'main_office_count' => 1,
            ],
            21 => [
                'admin_code' => '08228',
                'name' => '茨城県坂東市',
                'lat' => 36.048363,
                'lon' => 139.88868,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            22 => [
                'admin_code' => '08229',
                'name' => '茨城県稲敷市',
                'lat' => 35.956569,
                'lon' => 140.323988,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            23 => [
                'admin_code' => '08231',
                'name' => '茨城県桜川市',
                'lat' => 36.327273,
                'lon' => 140.090478,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            24 => [
                'admin_code' => '08232',
                'name' => '茨城県神栖市',
                'lat' => 35.889972,
                'lon' => 140.664527,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            25 => [
                'admin_code' => '08233',
                'name' => '茨城県行方市',
                'lat' => 35.99016591,
                'lon' => 140.48909986,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            26 => [
                'admin_code' => '08234',
                'name' => '茨城県鉾田市',
                'lat' => 36.158687,
                'lon' => 140.516437,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            27 => [
                'admin_code' => '08235',
                'name' => '茨城県つくばみらい市',
                'lat' => 35.962911,
                'lon' => 140.037069,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            28 => [
                'admin_code' => '08236',
                'name' => '茨城県小美玉市',
                'lat' => 36.239283,
                'lon' => 140.352589,
                'office_count' => 5,
                'main_office_count' => 1,
            ],
            29 => [
                'admin_code' => '08302',
                'name' => '茨城県茨城町',
                'lat' => 36.286921,
                'lon' => 140.424517,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            30 => [
                'admin_code' => '08309',
                'name' => '茨城県大洗町',
                'lat' => 36.313356,
                'lon' => 140.574888,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            31 => [
                'admin_code' => '08310',
                'name' => '茨城県城里町',
                'lat' => 36.479297,
                'lon' => 140.376241,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            32 => [
                'admin_code' => '08341',
                'name' => '茨城県東海村',
                'lat' => 36.472882,
                'lon' => 140.566301,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            33 => [
                'admin_code' => '08364',
                'name' => '茨城県大子町',
                'lat' => 36.768099,
                'lon' => 140.355275,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            34 => [
                'admin_code' => '08442',
                'name' => '茨城県美浦村',
                'lat' => 36.004554,
                'lon' => 140.301906,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            35 => [
                'admin_code' => '08443',
                'name' => '茨城県阿見町',
                'lat' => 36.03087,
                'lon' => 140.214769,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            36 => [
                'admin_code' => '08447',
                'name' => '茨城県河内町',
                'lat' => 35.884743,
                'lon' => 140.244516,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            37 => [
                'admin_code' => '08521',
                'name' => '茨城県八千代町',
                'lat' => 36.181632,
                'lon' => 139.891145,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            38 => [
                'admin_code' => '08542',
                'name' => '茨城県五霞町',
                'lat' => 36.114116,
                'lon' => 139.745832,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            39 => [
                'admin_code' => '08546',
                'name' => '茨城県境町',
                'lat' => 36.108529,
                'lon' => 139.795054,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            40 => [
                'admin_code' => '08564',
                'name' => '茨城県利根町',
                'lat' => 35.857825,
                'lon' => 140.139106,
                'office_count' => 1,
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
