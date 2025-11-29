<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * 非同期AI分析アーキテクチャにより、基盤データのみをシード。
     * スポット、モデルプラン、キャッチフレーズなどは全てAI分析で生成される。
     */
    public function run(): void
    {
        $this->call([
            // AIモデル: 非同期AI分析で使用するモデルの定義
            AiModelSeeder::class,

            // クラスター: 日本全国の市区町村データ（分析対象地域）
            ClusterSeeder::class,

            // 画像: 一般的な観光地のイラスト画像
            DefaultImageSeeder::class,
        ]);
    }
}
