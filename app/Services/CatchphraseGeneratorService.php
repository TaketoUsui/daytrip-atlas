<?php

namespace App\Services;

use App\Models\Catchphrase;
use App\Models\Cluster;

/**
 * AIを使用してクラスター向けのキャッチコピーを生成するサービス
 *
 * Phase 2: ダミー実装（既存のキャッチコピーをランダムに返す）
 * Phase 4: Gemini APIを使用した本実装に置き換え予定
 */
class CatchphraseGeneratorService
{
    /**
     * クラスター向けのキャッチコピーを生成
     *
     * @param Cluster $cluster 対象クラスター
     * @param float $fromLatitude 出発地の緯度
     * @param float $fromLongitude 出発地の経度
     * @return Catchphrase 生成されたキャッチコピー
     */
    public function generateCatchphrase(Cluster $cluster, float $fromLatitude, float $fromLongitude): Catchphrase
    {
        // Phase 2: ダミー実装 - 固定文言のキャッチコピーを生成
        $dummyContents = [
            "{$cluster->name}で歴史とグルメを満喫する、大人の日帰り旅",
            "週末は{$cluster->name}へ。自然とアートに癒される1日",
            "{$cluster->name}の隠れた名所を巡る、特別な旅",
        ];

        $content = $dummyContents[array_rand($dummyContents)];

        return Catchphrase::create([
            'content' => $content,
            'context_data' => [
                'cluster_id' => $cluster->id,
                'input_location' => [$fromLatitude, $fromLongitude],
                'generated_at' => now()->toIso8601String(),
            ],
        ]);

        // Phase 4で以下のような実装に置き換え予定:
        // - Gemini APIにクラスター情報（名前、スポット情報等）を送信
        // - プロンプト: 「ユーザーが出発地から{cluster}を訪れる際の魅力的なキャッチコピーを生成してください」
        // - 生成されたキャッチコピーをcatchphrasesテーブルに保存して返す
    }
}
