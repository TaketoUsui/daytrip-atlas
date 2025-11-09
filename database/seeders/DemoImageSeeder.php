<?php

namespace Database\Seeders;

use App\Enums\ImageQualityLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class DemoImageSeeder extends Seeder
{
    public function run(): void
    {
        // 開発環境での再実行を考慮し、既存データをクリア
        DB::table('images')->truncate();

        $now = Carbon::now();

        /**
         * デモ用画像データ
         * MVPでは実際の画像ファイルは後で配置
         * storage_pathは 'demo_images/{filename}' の形式
         */
        $images = [
            // 神戸市エリア用画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'kobe_harborland.jpg',
                'storage_path' => 'demo_images/kobe_harborland.jpg',
                'alt_text' => '神戸ハーバーランドの夜景',
                'description' => '神戸港の美しい夜景',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 大阪市エリア用画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'osaka_castle.jpg',
                'storage_path' => 'demo_images/osaka_castle.jpg',
                'alt_text' => '大阪城',
                'description' => '大阪のシンボル、大阪城',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 京都市エリア用画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'kyoto_temple.jpg',
                'storage_path' => 'demo_images/kyoto_temple.jpg',
                'alt_text' => '京都の寺院',
                'description' => '京都の伝統的な寺院',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 奈良市エリア用画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'nara_deer.jpg',
                'storage_path' => 'demo_images/nara_deer.jpg',
                'alt_text' => '奈良公園の鹿',
                'description' => '奈良公園で鹿と触れ合う風景',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 姫路市エリア用画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'himeji_castle.jpg',
                'storage_path' => 'demo_images/himeji_castle.jpg',
                'alt_text' => '姫路城',
                'description' => '世界遺産の白鷺城',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 宇治市エリア用画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'uji_matcha.jpg',
                'storage_path' => 'demo_images/uji_matcha.jpg',
                'alt_text' => '宇治抹茶',
                'description' => '宇治の抹茶スイーツ',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 和歌山市エリア用画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'wakayama_castle.jpg',
                'storage_path' => 'demo_images/wakayama_castle.jpg',
                'alt_text' => '和歌山城',
                'description' => '和歌山のシンボル、和歌山城',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 大津市エリア用画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'otsu_biwako.jpg',
                'storage_path' => 'demo_images/otsu_biwako.jpg',
                'alt_text' => '琵琶湖',
                'description' => '日本最大の湖、琵琶湖',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
        ];

        foreach ($images as $image) {
            DB::table('images')->insert($image);
        }
    }
}
