<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        // 開発環境での再実行を考慮し、既存データをクリア
        DB::table('tags')->truncate();

        $tags = [
            ['name' => '絶景'],
            ['name' => 'デート向き'],
            ['name' => 'グルメ'],
            ['name' => '自然・癒やし'],
            ['name' => '歴史・文化'],
            ['name' => 'おしゃれカフェ'],
            ['name' => '家族で楽しむ'],
            ['name' => 'ひとりでのんびり'],
            ['name' => '温泉'],
            ['name' => 'アート・美術館'],
        ];

        DB::table('tags')->insert($tags);
    }
}
