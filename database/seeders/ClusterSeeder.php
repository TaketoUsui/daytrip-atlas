<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 関西圏の主要な市区町村(クラスター)を20件登録する。
 */
class ClusterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 開発環境での再実行を考慮し、既存データをクリア
        DB::table('clusters')->truncate();

        $now = Carbon::now();

        /**
         * 登録するクラスターデータの配列
         * location は PostGIS の GEOGRAPHY 型 (SRID: 4326) で登録する。
         * POINT(経度 longitude, 緯度 latitude) の順序で指定する。
         */
        $clustersData = [
            [
                'name' => '兵庫県神戸市',
                'lat' => 34.6901,
                'lon' => 135.1955,
            ],
            [
                'name' => '大阪府大阪市',
                'lat' => 34.6937,
                'lon' => 135.5023,
            ],
            [
                'name' => '京都府京都市',
                'lat' => 35.0116,
                'lon' => 135.7681,
            ],
            [
                'name' => '大阪府堺市',
                'lat' => 34.5733,
                'lon' => 135.4833,
            ],
            [
                'name' => '兵庫県西宮市',
                'lat' => 34.7380,
                'lon' => 135.3420,
            ],
            [
                'name' => '兵庫県尼崎市',
                'lat' => 34.7333,
                'lon' => 135.4000,
            ],
            [
                'name' => '兵庫県姫路市',
                'lat' => 34.8404,
                'lon' => 134.6937,
            ],
            [
                'name' => '大阪府東大阪市',
                'lat' => 34.6794,
                'lon' => 135.6008,
            ],
            [
                'name' => '大阪府吹田市',
                'lat' => 34.7591,
                'lon' => 135.5172,
            ],
            [
                'name' => '大阪府枚方市',
                'lat' => 34.8164,
                'lon' => 135.6508,
            ],
            [
                'name' => '大阪府豊中市',
                'lat' => 34.7823,
                'lon' => 135.4706,
            ],
            [
                'name' => '京都府宇治市',
                'lat' => 34.8822,
                'lon' => 135.7996,
            ],
            [
                'name' => '奈良県奈良市',
                'lat' => 34.6851,
                'lon' => 135.8048,
            ],
            [
                'name' => '兵庫県明石市',
                'lat' => 34.6486,
                'lon' => 134.9990,
            ],
            [
                'name' => '滋賀県大津市',
                'lat' => 35.0042,
                'lon' => 135.8681,
            ],
            [
                'name' => '兵庫県宝塚市',
                'lat' => 34.7980,
                'lon' => 135.3604,
            ],
            [
                'name' => '大阪府高槻市',
                'lat' => 34.8430,
                'lon' => 135.6172,
            ],
            [
                'name' => '和歌山県和歌山市',
                'lat' => 34.2305,
                'lon' => 135.1708,
            ],
            [
                'name' => '奈良県橿原市',
                'lat' => 34.5097,
                'lon' => 135.7925,
            ],
            [
                'name' => '大阪府茨木市',
                'lat' => 34.8164,
                'lon' => 135.5686,
            ],
        ];

        // DB::raw() を使用してPostGISの地理空間データを登録
        foreach ($clustersData as $cluster) {
            DB::table('clusters')->insert([
                'uuid' => Str::uuid()->toString(),
                'name' => $cluster['name'],
                // ST_GeogFromText を使用し、WKT形式 (POINT(経度 緯度)) で location を設定
                'location' => DB::raw("ST_GeogFromText('POINT({$cluster['lon']} {$cluster['lat']})')"),
                // MVPで即時利用可能にするため 'published' に設定
                'status' => 'published',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
