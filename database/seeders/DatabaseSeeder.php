<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 依存関係を考慮した順序でSeederを実行
        $this->call([
            // 1. 基本データ（クラスター、タグ、画像）
            ClusterSeeder::class,
            TagSeeder::class,
            DemoImageSeeder::class,

            // 2. スポットデータ（クラスターとタグに依存）
            SpotSeeder::class,

            // 3. モデルプラン（クラスターに依存）
            ModelPlanSeeder::class,

            // 4. モデルプランアイテム（モデルプランとスポットに依存）
            ModelPlanItemSeeder::class,

            // 5. キャッチコピー
            CatchphraseSeeder::class,
        ]);

//        User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);
    }
}
