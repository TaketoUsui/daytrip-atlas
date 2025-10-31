<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * MVP要件定義書(FUNC-001)の「5〜10個程度の代表的なタグ」に基づき、
 * TopPageController(MVP_実装状況.txt Source 15)で取得される
 * タグのマスターデータを登録する。
 */
class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 開発環境での再実行を考慮し、既存データをクリア
        DB::table('tags')->truncate();

        /**
         * 登録するタグの配列
         * TopPageController は orderBy('id', 'asc') で取得するため、
         * この配列の順序がそのままフロントエンドの表示順になる。
         */
        $tags = [
            // MVP要件定義書(FUNC-001) 記載例
            ['name' => '絶景'],
            // MVP要件定義書(FUNC-001) 記載例
            ['name' => 'デート向き'],
            // 以下、主要な旅行テーマ
            ['name' => 'グルメ'],
            ['name' => '自然・癒やし'],
            ['name' => '歴史・文化'],
            ['name' => 'おしゃれカフェ'],
            ['name' => '家族で楽しむ'],
            ['name' => 'ひとりでのんびり'],
            ['name' => '温泉'],
            ['name' => 'アート・美術館'],
        ];

        // DB設計(DB設計_改二.md)上、tagsテーブルは id と name のみで
        // タイムスタンプを持たない想定のため、
        // Eloquentの insert メソッドで単純に挿入する。
        DB::table('tags')->insert($tags);
    }
}
