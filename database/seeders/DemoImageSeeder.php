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
    /**
     * Run the database seeds.
     *
     * 目的: 「事前登録画像の選定」ロジックのため、
     * 高品質なデモ用画像と、AIが参照する特徴メタデータを登録する。
     */
    public function run(): void
    {
        // 開発環境での再実行を考慮し、既存データをクリア
        DB::table('images')->truncate();

        $now = Carbon::now();
        $disk = Storage::disk('public');
        $basePath = 'demo_images/';

        /**
         * 登録するデモ用画像データ
         * storage_path: publicディスク内のパス (例: /storage/demo_images/arashiyama.png)
         * metadata: AIがプランの特徴と照合するために使用する特徴タグ
         */
        $imagesData = [
            [
                'file_name' => 'arashiyama.png',
                'storage_path' => $basePath . 'arashiyama.png',
                'alt_text' => '京都・嵐山の竹林と渡月橋の風景',
                'copyright_holder' => 'Demo User (Public Domain)',
                // metadata: TagSeederの「絶景」「自然・癒やし」「デート向き」「歴史・文化」に関連
                'metadata' => json_encode(['京都', '嵐山', '竹林', '絶景', '自然', '癒やし', 'デート', '歴史']),
                'image_quality_level' => ImageQualityLevel::ManuallyVerifiedPhoto,
            ],
            [
                'file_name' => 'kobe-harbor.png',
                'storage_path' => $basePath . 'kobe-harbor.png',
                'alt_text' => '夜の神戸ハーバーランドの観覧車とポートタワー',
                'copyright_holder' => 'Demo User (Public Domain)',
                // metadata: TagSeederの「絶景」「デート向き」「おしゃれカフェ」に関連
                'metadata' => json_encode(['神戸', 'ハーバーランド', '夜景', '絶景', 'デート', 'おしゃれ']),
                'image_quality_level' => ImageQualityLevel::ManuallyVerifiedPhoto,
            ],
            [
                'file_name' => 'arima-onsen.png',
                'storage_path' => $basePath . 'arima-onsen.png',
                'alt_text' => '有馬温泉の金泉の湯けむり',
                'copyright_holder' => 'Demo User (Public Domain)',
                // metadata: TagSeederの「温泉」「自然・癒やし」「ひとりでのんびり」に関連
                'metadata' => json_encode(['兵庫', '有馬温泉', '温泉', '金泉', '癒やし', 'のんびり', '歴史']),
                'image_quality_level' => ImageQualityLevel::ManuallyVerifiedPhoto,
            ],
            [
                'file_name' => 'nara-park-deer.png',
                'storage_path' => $basePath . 'nara-park-deer.png',
                'alt_text' => '奈良公園で鹿せんべいを待つ鹿たち',
                'copyright_holder' => 'Demo User (Public Domain)',
                // metadata: TagSeederの「歴史・文化」「自然・癒やし」「家族で楽しむ」に関連
                'metadata' => json_encode(['奈良', '奈良公園', '鹿', '歴史', '文化', '家族', '癒やし']),
                'image_quality_level' => ImageQualityLevel::ManuallyVerifiedPhoto,
            ],
            // TODO: ClusterSeeder に合わせて他のデモ画像も追加
        ];

        // DBに挿入
        foreach ($imagesData as $data) {
            // storage_pathが実際に public/storage/ 経由でアクセス可能か簡易チェック
            if (!$disk->exists($data['storage_path'])) {
                // 開発者への警告
                $this->command->warn("Image file not found: [{$data['storage_path']}]. Skipping seeding this image.");
                continue;
            }

            DB::table('images')->insert([
                'uuid' => Str::uuid()->toString(),
                'file_name' => $data['file_name'],
                'storage_path' => $data['storage_path'],
                'alt_text' => $data['alt_text'],
                'copyright_holder' => $data['copyright_holder'],
                'metadata' => $data['metadata'], // JSON文字列として挿入
                'image_quality_level' => $data['image_quality_level'],
                'created_at' => $now,
            ]);
        }
    }
}
