<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * 日本全国47都道府県の市区町村クラスターデータを登録する。
 * 各都道府県のSeederを順次実行することで、全国のクラスターデータを登録する。
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

        $this->command->info('全国のクラスターデータを登録します...');

        // 47都道府県のSeederクラスを順次実行
        $prefectures = [
            'Hokkaido', 'Aomori', 'Iwate', 'Miyagi', 'Akita', 'Yamagata', 'Fukushima',
            'Ibaraki', 'Tochigi', 'Gunma', 'Saitama', 'Chiba', 'Tokyo', 'Kanagawa',
            'Niigata', 'Toyama', 'Ishikawa', 'Fukui', 'Yamanashi', 'Nagano',
            'Gifu', 'Shizuoka', 'Aichi', 'Mie', 'Shiga', 'Kyoto', 'Osaka',
            'Hyogo', 'Nara', 'Wakayama', 'Tottori', 'Shimane', 'Okayama',
            'Hiroshima', 'Yamaguchi', 'Tokushima', 'Kagawa', 'Ehime', 'Kochi',
            'Fukuoka', 'Saga', 'Nagasaki', 'Kumamoto', 'Oita', 'Miyazaki',
            'Kagoshima', 'Okinawa',
        ];

        foreach ($prefectures as $i => $prefecture) {
            $index = $i + 1;
            $seederClass = "\\Database\\Seeders\\Prefectures\\{$prefecture}Seeder";

            $this->command->info("  [{$index}/47] {$seederClass} を実行中...");
            $this->call($seederClass);
        }

        $this->command->info('全国のクラスターデータの登録が完了しました。');
    }
}
