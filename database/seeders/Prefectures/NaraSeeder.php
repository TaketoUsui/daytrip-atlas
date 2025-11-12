<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 奈良県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class NaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = [
            0 => [
                'admin_code' => '29201',
                'name' => '奈良県奈良市',
                'lat' => 34.685117,
                'lon' => 135.804995,
                'office_count' => 16,
                'main_office_count' => 1,
            ],
            1 => [
                'admin_code' => '29202',
                'name' => '奈良県大和高田市',
                'lat' => 34.514975,
                'lon' => 135.736451,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            2 => [
                'admin_code' => '29203',
                'name' => '奈良県大和郡山市',
                'lat' => 34.649368,
                'lon' => 135.782747,
                'office_count' => 6,
                'main_office_count' => 1,
            ],
            3 => [
                'admin_code' => '29204',
                'name' => '奈良県天理市',
                'lat' => 34.596617,
                'lon' => 135.837367,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            4 => [
                'admin_code' => '29205',
                'name' => '奈良県橿原市',
                'lat' => 34.509453,
                'lon' => 135.792756,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            5 => [
                'admin_code' => '29206',
                'name' => '奈良県桜井市',
                'lat' => 34.5187,
                'lon' => 135.843232,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            6 => [
                'admin_code' => '29207',
                'name' => '奈良県五條市',
                'lat' => 34.352118,
                'lon' => 135.693497,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            7 => [
                'admin_code' => '29208',
                'name' => '奈良県御所市',
                'lat' => 34.46334,
                'lon' => 135.740177,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            8 => [
                'admin_code' => '29209',
                'name' => '奈良県生駒市',
                'lat' => 34.691979,
                'lon' => 135.700553,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            9 => [
                'admin_code' => '29211',
                'name' => '奈良県葛城市',
                'lat' => 34.489158,
                'lon' => 135.726563,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            10 => [
                'admin_code' => '29212',
                'name' => '奈良県宇陀市',
                'lat' => 34.528073,
                'lon' => 135.952303,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            11 => [
                'admin_code' => '29322',
                'name' => '奈良県山添村',
                'lat' => 34.681261,
                'lon' => 136.043797,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            12 => [
                'admin_code' => '29342',
                'name' => '奈良県平群町',
                'lat' => 34.629155,
                'lon' => 135.700711,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            13 => [
                'admin_code' => '29343',
                'name' => '奈良県三郷町',
                'lat' => 34.599977,
                'lon' => 135.695425,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            14 => [
                'admin_code' => '29344',
                'name' => '奈良県斑鳩町',
                'lat' => 34.608852,
                'lon' => 135.730593,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            15 => [
                'admin_code' => '29345',
                'name' => '奈良県安堵町',
                'lat' => 34.606488,
                'lon' => 135.756781,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            16 => [
                'admin_code' => '29361',
                'name' => '奈良県川西町',
                'lat' => 34.584383,
                'lon' => 135.773871,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            17 => [
                'admin_code' => '29362',
                'name' => '奈良県三宅町',
                'lat' => 34.573678,
                'lon' => 135.773177,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            18 => [
                'admin_code' => '29363',
                'name' => '奈良県田原本町',
                'lat' => 34.556667,
                'lon' => 135.79494,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            19 => [
                'admin_code' => '29385',
                'name' => '奈良県曽爾村',
                'lat' => 34.510664,
                'lon' => 136.124475,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            20 => [
                'admin_code' => '29386',
                'name' => '奈良県御杖村',
                'lat' => 34.488391,
                'lon' => 136.16591,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            21 => [
                'admin_code' => '29401',
                'name' => '奈良県高取町',
                'lat' => 34.449468,
                'lon' => 135.793168,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            22 => [
                'admin_code' => '29402',
                'name' => '奈良県明日香村',
                'lat' => 34.471281,
                'lon' => 135.820633,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            23 => [
                'admin_code' => '29424',
                'name' => '奈良県上牧町',
                'lat' => 34.562723,
                'lon' => 135.716674,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            24 => [
                'admin_code' => '29425',
                'name' => '奈良県王寺町',
                'lat' => 34.594696,
                'lon' => 135.706705,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            25 => [
                'admin_code' => '29426',
                'name' => '奈良県広陵町',
                'lat' => 34.54274,
                'lon' => 135.750842,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            26 => [
                'admin_code' => '29427',
                'name' => '奈良県河合町',
                'lat' => 34.578369,
                'lon' => 135.736699,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            27 => [
                'admin_code' => '29441',
                'name' => '奈良県吉野町',
                'lat' => 34.396046,
                'lon' => 135.857612,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            28 => [
                'admin_code' => '29442',
                'name' => '奈良県大淀町',
                'lat' => 34.390529,
                'lon' => 135.789798,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            29 => [
                'admin_code' => '29443',
                'name' => '奈良県下市町',
                'lat' => 34.360951,
                'lon' => 135.791872,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            30 => [
                'admin_code' => '29444',
                'name' => '奈良県黒滝村',
                'lat' => 34.309276,
                'lon' => 135.85225,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            31 => [
                'admin_code' => '29446',
                'name' => '奈良県天川村',
                'lat' => 34.241929,
                'lon' => 135.855135,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            32 => [
                'admin_code' => '29447',
                'name' => '奈良県野迫川村',
                'lat' => 34.166293,
                'lon' => 135.63303,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            33 => [
                'admin_code' => '29449',
                'name' => '奈良県十津川村',
                'lat' => 33.988504,
                'lon' => 135.792611,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            34 => [
                'admin_code' => '29451',
                'name' => '奈良県上北山村',
                'lat' => 34.134321,
                'lon' => 136.000149,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            35 => [
                'admin_code' => '29452',
                'name' => '奈良県川上村',
                'lat' => 34.338121,
                'lon' => 135.954303,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            36 => [
                'admin_code' => '29453',
                'name' => '奈良県東吉野村',
                'lat' => 34.403541,
                'lon' => 135.968307,
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
