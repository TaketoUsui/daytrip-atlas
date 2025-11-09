<?php

namespace Database\Seeders;

use App\Enums\SpotRole;
use App\Enums\CoordinateReliability;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 関西圏の観光スポットを登録する
 */
class SpotSeeder extends Seeder
{
    public function run(): void
    {
        // 開発環境での再実行を考慮し、既存データをクリア
        DB::table('cluster_spot')->truncate();
        DB::table('spot_tag')->truncate();
        DB::table('spot_images')->truncate();
        DB::table('spots')->truncate();

        $now = Carbon::now();

        /**
         * スポットデータ
         * location は PostGIS の GEOGRAPHY 型 (SRID: 4326) で登録
         * POINT(経度 longitude, 緯度 latitude) の順序で指定
         */
        $spotsData = [
            // 神戸市エリア
            [
                'name' => '神戸ハーバーランド',
                'slug' => 'kobe-harborland',
                'lat' => 34.6836,
                'lon' => 135.1866,
                'prefecture' => '兵庫県',
                'municipality' => '神戸市',
                'address_detail' => '中央区東川崎町',
                'min_duration_minutes' => 60,
                'max_duration_minutes' => 120,
                'spot_role' => SpotRole::MainDestination->value,
                'coordinate_reliability' => CoordinateReliability::ManuallyVerified->value,
                'cluster_name' => '兵庫県神戸市',
                'tags' => ['デート向き', 'グルメ', 'おしゃれカフェ'],
            ],
            [
                'name' => '南京町',
                'slug' => 'nankinmachi',
                'lat' => 34.6900,
                'lon' => 135.1893,
                'prefecture' => '兵庫県',
                'municipality' => '神戸市',
                'address_detail' => '中央区元町通',
                'min_duration_minutes' => 45,
                'max_duration_minutes' => 90,
                'spot_role' => SpotRole::SubDestination->value,
                'coordinate_reliability' => CoordinateReliability::ManuallyVerified->value,
                'cluster_name' => '兵庫県神戸市',
                'tags' => ['グルメ', '歴史・文化'],
            ],
            [
                'name' => '有馬温泉',
                'slug' => 'arima-onsen',
                'lat' => 34.7975,
                'lon' => 135.2485,
                'prefecture' => '兵庫県',
                'municipality' => '神戸市',
                'address_detail' => '北区有馬町',
                'min_duration_minutes' => 120,
                'max_duration_minutes' => 240,
                'spot_role' => SpotRole::MainDestination->value,
                'coordinate_reliability' => CoordinateReliability::ManuallyVerified->value,
                'cluster_name' => '兵庫県神戸市',
                'tags' => ['自然・癒やし', '歴史・文化', 'デート向き'],
            ],

            // 大阪市エリア
            [
                'name' => '大阪城',
                'slug' => 'osaka-castle',
                'lat' => 34.6873,
                'lon' => 135.5262,
                'prefecture' => '大阪府',
                'municipality' => '大阪市',
                'address_detail' => '中央区大阪城',
                'min_duration_minutes' => 90,
                'max_duration_minutes' => 150,
                'spot_role' => SpotRole::MainDestination->value,
                'coordinate_reliability' => CoordinateReliability::ManuallyVerified->value,
                'cluster_name' => '大阪府大阪市',
                'tags' => ['歴史・文化', '絶景'],
            ],
            [
                'name' => '道頓堀',
                'slug' => 'dotonbori',
                'lat' => 34.6686,
                'lon' => 135.5007,
                'prefecture' => '大阪府',
                'municipality' => '大阪市',
                'address_detail' => '中央区道頓堀',
                'min_duration_minutes' => 60,
                'max_duration_minutes' => 120,
                'spot_role' => SpotRole::SubDestination->value,
                'coordinate_reliability' => CoordinateReliability::ManuallyVerified->value,
                'cluster_name' => '大阪府大阪市',
                'tags' => ['グルメ', 'デート向き'],
            ],

            // 京都市エリア
            [
                'name' => '清水寺',
                'slug' => 'kiyomizu-dera',
                'lat' => 34.9949,
                'lon' => 135.7851,
                'prefecture' => '京都府',
                'municipality' => '京都市',
                'address_detail' => '東山区清水',
                'min_duration_minutes' => 90,
                'max_duration_minutes' => 150,
                'spot_role' => SpotRole::MainDestination->value,
                'coordinate_reliability' => CoordinateReliability::ManuallyVerified->value,
                'cluster_name' => '京都府京都市',
                'tags' => ['歴史・文化', '絶景'],
            ],
            [
                'name' => '嵐山',
                'slug' => 'arashiyama',
                'lat' => 35.0094,
                'lon' => 135.6733,
                'prefecture' => '京都府',
                'municipality' => '京都市',
                'address_detail' => '右京区嵯峨',
                'min_duration_minutes' => 120,
                'max_duration_minutes' => 180,
                'spot_role' => SpotRole::MainDestination->value,
                'coordinate_reliability' => CoordinateReliability::ManuallyVerified->value,
                'cluster_name' => '京都府京都市',
                'tags' => ['自然・癒やし', '絶景'],
            ],
            [
                'name' => '渡月橋',
                'slug' => 'togetsukyo',
                'lat' => 35.0125,
                'lon' => 135.6775,
                'prefecture' => '京都府',
                'municipality' => '京都市',
                'address_detail' => '右京区嵯峨',
                'min_duration_minutes' => 30,
                'max_duration_minutes' => 60,
                'spot_role' => SpotRole::SubDestination->value,
                'coordinate_reliability' => CoordinateReliability::ManuallyVerified->value,
                'cluster_name' => '京都府京都市',
                'tags' => ['絶景', 'デート向き'],
            ],

            // 奈良市エリア
            [
                'name' => '奈良公園',
                'slug' => 'nara-park',
                'lat' => 34.6851,
                'lon' => 135.8431,
                'prefecture' => '奈良県',
                'municipality' => '奈良市',
                'address_detail' => '奈良公園',
                'min_duration_minutes' => 90,
                'max_duration_minutes' => 150,
                'spot_role' => SpotRole::MainDestination->value,
                'coordinate_reliability' => CoordinateReliability::ManuallyVerified->value,
                'cluster_name' => '奈良県奈良市',
                'tags' => ['自然・癒やし', '家族で楽しむ'],
            ],
            [
                'name' => '東大寺',
                'slug' => 'todai-ji',
                'lat' => 34.6889,
                'lon' => 135.8398,
                'prefecture' => '奈良県',
                'municipality' => '奈良市',
                'address_detail' => '雑司町',
                'min_duration_minutes' => 60,
                'max_duration_minutes' => 120,
                'spot_role' => SpotRole::SubDestination->value,
                'coordinate_reliability' => CoordinateReliability::ManuallyVerified->value,
                'cluster_name' => '奈良県奈良市',
                'tags' => ['歴史・文化'],
            ],

            // 姫路市エリア
            [
                'name' => '姫路城',
                'slug' => 'himeji-castle',
                'lat' => 34.8394,
                'lon' => 134.6939,
                'prefecture' => '兵庫県',
                'municipality' => '姫路市',
                'address_detail' => '本町',
                'min_duration_minutes' => 90,
                'max_duration_minutes' => 150,
                'spot_role' => SpotRole::MainDestination->value,
                'coordinate_reliability' => CoordinateReliability::ManuallyVerified->value,
                'cluster_name' => '兵庫県姫路市',
                'tags' => ['歴史・文化', '絶景'],
            ],

            // 宇治市エリア
            [
                'name' => '平等院',
                'slug' => 'byodoin',
                'lat' => 34.8894,
                'lon' => 135.8076,
                'prefecture' => '京都府',
                'municipality' => '宇治市',
                'address_detail' => '宇治蓮華',
                'min_duration_minutes' => 60,
                'max_duration_minutes' => 120,
                'spot_role' => SpotRole::MainDestination->value,
                'coordinate_reliability' => CoordinateReliability::ManuallyVerified->value,
                'cluster_name' => '京都府宇治市',
                'tags' => ['歴史・文化'],
            ],
            [
                'name' => '宇治川',
                'slug' => 'uji-river',
                'lat' => 34.8910,
                'lon' => 135.8064,
                'prefecture' => '京都府',
                'municipality' => '宇治市',
                'address_detail' => '宇治',
                'min_duration_minutes' => 45,
                'max_duration_minutes' => 90,
                'spot_role' => SpotRole::SubDestination->value,
                'coordinate_reliability' => CoordinateReliability::ManuallyVerified->value,
                'cluster_name' => '京都府宇治市',
                'tags' => ['自然・癒やし', 'おしゃれカフェ'],
            ],

            // 和歌山市エリア
            [
                'name' => '和歌山城',
                'slug' => 'wakayama-castle',
                'lat' => 34.2267,
                'lon' => 135.1707,
                'prefecture' => '和歌山県',
                'municipality' => '和歌山市',
                'address_detail' => '一番丁',
                'min_duration_minutes' => 90,
                'max_duration_minutes' => 150,
                'spot_role' => SpotRole::MainDestination->value,
                'coordinate_reliability' => CoordinateReliability::ManuallyVerified->value,
                'cluster_name' => '和歌山県和歌山市',
                'tags' => ['歴史・文化', '絶景'],
            ],

            // 大津市エリア
            [
                'name' => '琵琶湖',
                'slug' => 'biwako',
                'lat' => 35.0219,
                'lon' => 135.8694,
                'prefecture' => '滋賀県',
                'municipality' => '大津市',
                'address_detail' => '浜大津',
                'min_duration_minutes' => 120,
                'max_duration_minutes' => 180,
                'spot_role' => SpotRole::MainDestination->value,
                'coordinate_reliability' => CoordinateReliability::ManuallyVerified->value,
                'cluster_name' => '滋賀県大津市',
                'tags' => ['自然・癒やし', '絶景'],
            ],
        ];

        // スポットデータを登録し、IDとスラッグのマッピングを保存
        $spotIdMap = [];
        foreach ($spotsData as $spot) {
            $id = DB::table('spots')->insertGetId([
                'name' => $spot['name'],
                'slug' => $spot['slug'],
                'location' => DB::raw("ST_GeogFromText('POINT({$spot['lon']} {$spot['lat']})')"),
                'prefecture' => $spot['prefecture'],
                'municipality' => $spot['municipality'],
                'address_detail' => $spot['address_detail'],
                'min_duration_minutes' => $spot['min_duration_minutes'],
                'max_duration_minutes' => $spot['max_duration_minutes'],
                'spot_role' => $spot['spot_role'],
                'coordinate_reliability' => $spot['coordinate_reliability'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $spotIdMap[$spot['slug']] = [
                'id' => $id,
                'cluster_name' => $spot['cluster_name'],
                'tags' => $spot['tags'],
            ];
        }

        // クラスターとの紐付け（中間テーブル cluster_spot）
        $clusters = DB::table('clusters')->select('id', 'name')->get()->keyBy('name');
        foreach ($spotIdMap as $slug => $data) {
            $cluster = $clusters->get($data['cluster_name']);
            if ($cluster) {
                DB::table('cluster_spot')->insert([
                    'cluster_id' => $cluster->id,
                    'spot_id' => $data['id'],
                ]);
            }
        }

        // タグとの紐付け（中間テーブル spot_tag）
        $tags = DB::table('tags')->select('id', 'name')->get()->keyBy('name');
        foreach ($spotIdMap as $slug => $data) {
            foreach ($data['tags'] as $tagName) {
                $tag = $tags->get($tagName);
                if ($tag) {
                    DB::table('spot_tag')->insert([
                        'spot_id' => $data['id'],
                        'tag_id' => $tag->id,
                    ]);
                }
            }
        }

        // 画像との紐付け（中間テーブル spot_images）
        // 簡易的に、各クラスターの代表的な画像を最初のスポットに紐付ける
        $images = DB::table('images')->select('id', 'file_name')->get()->keyBy('file_name');
        $spotImageMappings = [
            'kobe-harborland' => 'kobe-harbor.png',
            'arima-onsen' => 'arima-onsen.png',
            'osaka-castle' => 'osaka_castle.png',
            'kiyomizu-dera' => 'kyoto_temple.png',
            'arashiyama' => 'arashiyama.png',
            'togetsukyo' => 'togetsukyo.png',
            'nara-park' => 'nara-park-deer.png',
            'himeji-castle' => 'himeji_castle.png',
            'byodoin' => 'uji_matcha.png',
            'wakayama-castle' => 'wakayama_castle.png',
            'biwako' => 'otsu_biwako.png',
        ];

        foreach ($spotImageMappings as $slug => $fileName) {
            $image = $images->get($fileName);
            if ($image && isset($spotIdMap[$slug])) {
                DB::table('spot_images')->insert([
                    'spot_id' => $spotIdMap[$slug]['id'],
                    'image_id' => $image->id,
                    'display_order' => 1,
                ]);
            }
        }
    }
}
