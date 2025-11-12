<?php

namespace Database\Seeders\Prefectures;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 富山県のクラスターデータをシードする
 *
 * このファイルは scripts/generate_prefecture_seeders.php によって自動生成されました。
 * XMLファイルから抽出したデータがハードコードされています。
 */
class ToyamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = [
            0 => [
                'admin_code' => '16201',
                'name' => '富山県富山市',
                'lat' => 36.695982,
                'lon' => 137.213449,
                'office_count' => 7,
                'main_office_count' => 1,
            ],
            1 => [
                'admin_code' => '16202',
                'name' => '富山県高岡市',
                'lat' => 36.754099,
                'lon' => 137.025717,
                'office_count' => 5,
                'main_office_count' => 1,
            ],
            2 => [
                'admin_code' => '16204',
                'name' => '富山県魚津市',
                'lat' => 36.827367,
                'lon' => 137.40919,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            3 => [
                'admin_code' => '16205',
                'name' => '富山県氷見市',
                'lat' => 36.855978,
                'lon' => 136.972868,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            4 => [
                'admin_code' => '16206',
                'name' => '富山県滑川市',
                'lat' => 36.764394,
                'lon' => 137.34118,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            5 => [
                'admin_code' => '16207',
                'name' => '富山県黒部市',
                'lat' => 36.87359,
                'lon' => 137.449095,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            6 => [
                'admin_code' => '16208',
                'name' => '富山県砺波市',
                'lat' => 36.647467,
                'lon' => 136.962167,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            7 => [
                'admin_code' => '16209',
                'name' => '富山県小矢部市',
                'lat' => 36.675531,
                'lon' => 136.868653,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            8 => [
                'admin_code' => '16211',
                'name' => '富山県射水市',
                'lat' => 36.712222,
                'lon' => 137.099559,
                'office_count' => 6,
                'main_office_count' => 1,
            ],
            9 => [
                'admin_code' => '16321',
                'name' => '富山県舟橋村',
                'lat' => 36.703525,
                'lon' => 137.307372,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            10 => [
                'admin_code' => '16322',
                'name' => '富山県上市町',
                'lat' => 36.698429,
                'lon' => 137.362586,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            11 => [
                'admin_code' => '16323',
                'name' => '富山県立山町',
                'lat' => 36.663346,
                'lon' => 137.313658,
                'office_count' => 1,
                'main_office_count' => 1,
            ],
            12 => [
                'admin_code' => '16342',
                'name' => '富山県入善町',
                'lat' => 36.933578,
                'lon' => 137.502128,
                'office_count' => 2,
                'main_office_count' => 1,
            ],
            13 => [
                'admin_code' => '16343',
                'name' => '富山県朝日町',
                'lat' => 36.946179,
                'lon' => 137.559868,
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
