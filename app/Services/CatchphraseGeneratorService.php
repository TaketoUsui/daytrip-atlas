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
        // Phase 2: ダミー実装
        // 既存のキャッチコピーからランダムに1件取得
        $existingCatchphrase = Catchphrase::inRandomOrder()->first();

        if ($existingCatchphrase) {
            return $existingCatchphrase;
        }

        // もし既存のキャッチコピーがない場合は新規作成
        return Catchphrase::create([
            'content' => 'この地域で素敵な一日を過ごしませんか',
            'source_analysis' => json_encode([
                'cluster' => $cluster->name,
                'generated_by' => 'dummy',
            ]),
        ]);

        // Phase 4で以下のような実装に置き換え予定:
        // - Gemini APIにクラスター情報（名前、スポット情報等）を送信
        // - プロンプト: 「ユーザーが出発地から{cluster}を訪れる際の魅力的なキャッチコピーを生成してください」
        // - 生成されたキャッチコピーをcatchphrasesテーブルに保存して返す
    }
}
