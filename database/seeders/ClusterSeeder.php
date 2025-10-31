<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * MVP要件定義書(非機能要件)に基づき、
 * サービスイン直後のCache Hit率を担保するための初期マスターデータを登録する。
 * 関西圏の主要な観光地域(クラスター)を10件登録する。
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
                'lat' => 35.0036,
                'lon' => 135.7800,
            ],
            [
                'name' => '京都・嵐山エリア',
                'lat' => 35.0139,
                'lon' => 135.6744,
            ],
            [
                'name' => '大阪・ミナミ（難波・心斎橋）エリア',
                'lat' => 34.6685,
                'lon' => 135.5010,
            ],
            [
                'name' => '大阪・キタ（梅田）エリア',
                'lat' => 34.7025,
                'lon' => 135.4959,
            ],
            [
                'name' => '神戸・三宮北野エリア',
                'lat' => 34.6953,
                'lon' => 135.1929,
            ],
            [
                'name' => '神戸・ハーバーランドエリア',
                'lat' => 34.6806,
                'lon' => 135.1884,
            ],
            [
                'name' => '奈良公園・ならまちエリア',
                'lat' => 34.6851,
                'lon' => 135.8447,
            ],
            [
                'name' => '和歌山・白浜エリア',
                'lat' => 33.6833,
                'lon' => 135.3500,
            ],
            [
                'name' => '兵庫・有馬温泉エリア',
                'lat' => 34.7950,
                'lon' => 135.2470,
            ],
            [
                'name' => '滋賀・琵琶湖（大津）エリア',
                'lat' => 35.0047,
                'lon' => 135.8617,
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
