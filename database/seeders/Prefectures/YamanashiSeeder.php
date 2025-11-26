<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 山梨県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class YamanashiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = [
            0 => [
                'admin_code' => '19201',
                'name' => '山梨県甲府市',
                'lat' => 35.66203333,
                'lon' => 138.56833862,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            1 => [
                'admin_code' => '19202',
                'name' => '山梨県富士吉田市',
                'lat' => 35.487499,
                'lon' => 138.807857,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            2 => [
                'admin_code' => '19204',
                'name' => '山梨県都留市',
                'lat' => 35.551565,
                'lon' => 138.90547,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            3 => [
                'admin_code' => '19205',
                'name' => '山梨県山梨市',
                'lat' => 35.69342902,
                'lon' => 138.68695504,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            4 => [
                'admin_code' => '19206',
                'name' => '山梨県大月市',
                'lat' => 35.610474,
                'lon' => 138.940041,
                'office_count' => 7,
                'main_office_count' => 1,
            ],
            5 => [
                'admin_code' => '19207',
                'name' => '山梨県韮崎市',
                'lat' => 35.708804,
                'lon' => 138.446192,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            6 => [
                'admin_code' => '19208',
                'name' => '山梨県南アルプス市',
                'lat' => 35.608361,
                'lon' => 138.465005,
                'office_count' => 6,
                'main_office_count' => 1,
            ],
            7 => [
                'admin_code' => '19209',
                'name' => '山梨県北杜市',
                'lat' => 35.776501,
                'lon' => 138.423537,
                'office_count' => 10,
                'main_office_count' => 1,
            ],
            8 => [
                'admin_code' => '19211',
                'name' => '山梨県笛吹市',
                'lat' => 35.647296,
                'lon' => 138.63973,
                'office_count' => 7,
                'main_office_count' => 1,
            ],
            9 => [
                'admin_code' => '19212',
                'name' => '山梨県上野原市',
                'lat' => 35.630301,
                'lon' => 139.108751,
                'office_count' => 9,
                'main_office_count' => 1,
            ],
            10 => [
                'admin_code' => '19213',
                'name' => '山梨県甲州市',
                'lat' => 35.70516,
                'lon' => 138.729265,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            11 => [
                'admin_code' => '19214',
                'name' => '山梨県中央市',
                'lat' => 35.599643,
                'lon' => 138.517269,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            12 => [
                'admin_code' => '19346',
                'name' => '山梨県市川三郷町',
                'lat' => 35.56512,
                'lon' => 138.502406,
                'office_count' => 4,
                'main_office_count' => 1,
            ],
            13 => [
                'admin_code' => '19364',
                'name' => '山梨県早川町',
                'lat' => 35.412658,
                'lon' => 138.363192,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            14 => [
                'admin_code' => '19365',
                'name' => '山梨県身延町',
                'lat' => 35.467569,
                'lon' => 138.442488,
                'office_count' => 5,
                'main_office_count' => 1,
            ],
            15 => [
                'admin_code' => '19366',
                'name' => '山梨県南部町',
                'lat' => 35.2423,
                'lon' => 138.486054,
                'office_count' => 3,
                'main_office_count' => 1,
            ],
            16 => [
                'admin_code' => '19368',
                'name' => '山梨県富士川町',
                'lat' => 35.561163,
                'lon' => 138.461305,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            17 => [
                'admin_code' => '19384',
                'name' => '山梨県昭和町',
                'lat' => 35.627928,
                'lon' => 138.535148,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            18 => [
                'admin_code' => '19422',
                'name' => '山梨県道志村',
                'lat' => 35.528025,
                'lon' => 139.033429,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            19 => [
                'admin_code' => '19423',
                'name' => '山梨県西桂町',
                'lat' => 35.524082,
                'lon' => 138.84688,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            20 => [
                'admin_code' => '19424',
                'name' => '山梨県忍野村',
                'lat' => 35.460062,
                'lon' => 138.847853,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            21 => [
                'admin_code' => '19425',
                'name' => '山梨県山中湖村',
                'lat' => 35.410644,
                'lon' => 138.861078,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            22 => [
                'admin_code' => '19429',
                'name' => '山梨県鳴沢村',
                'lat' => 35.481318,
                'lon' => 138.706609,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            23 => [
                'admin_code' => '19430',
                'name' => '山梨県富士河口湖町',
                'lat' => 35.497297,
                'lon' => 138.754926,
                'office_count' => 8,
                'main_office_count' => 1,
            ],
            24 => [
                'admin_code' => '19442',
                'name' => '山梨県小菅村',
                'lat' => 35.760274,
                'lon' => 138.940283,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            25 => [
                'admin_code' => '19443',
                'name' => '山梨県丹波山村',
                'lat' => 35.789716,
                'lon' => 138.92225,
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
