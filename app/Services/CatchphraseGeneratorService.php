<?php

namespace App\Services;

use App\Models\Catchphrase;
use App\Models\Cluster;
use Gemini;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * AIを使用してクラスター向けのキャッチコピーを生成するサービス
 *
 * Phase 4: Gemini APIを使用した本実装
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
        try {
            // Gemini APIでキャッチコピーを生成
            $content = $this->generateWithGemini($cluster);

            // 生成成功：データベースに保存
            return Catchphrase::create([
                'content' => $content,
                'context_data' => [
                    'cluster_id' => $cluster->id,
                    'cluster_name' => $cluster->name,
                    'input_location' => [$fromLatitude, $fromLongitude],
                    'generated_at' => now()->toIso8601String(),
                    'generation_method' => 'gemini_api',
                ],
            ]);
        } catch (Exception $e) {
            // エラー発生時はログに記録してフォールバック
            Log::warning('Gemini API failed, using fallback', [
                'error' => $e->getMessage(),
                'cluster_id' => $cluster->id,
                'cluster_name' => $cluster->name,
            ]);

            return $this->generateFallbackCatchphrase($cluster, $fromLatitude, $fromLongitude);
        }
    }

    /**
     * Gemini APIを使用してキャッチコピーを生成
     *
     * @param Cluster $cluster
     * @return string 生成されたキャッチコピー
     * @throws Exception
     */
    private function generateWithGemini(Cluster $cluster): string
    {
        // APIキーを取得
        $apiKey = config('services.gemini.api_key');

        if (empty($apiKey)) {
            throw new Exception('Gemini API key is not configured');
        }

        // プロンプトを構築
        $prompt = $this->buildPrompt($cluster);

        // Geminiクライアントを初期化
        $client = Gemini::client($apiKey);

        // モデルを選択してコンテンツ生成
        $result = $client
            ->generativeModel(model: config('services.gemini.model', 'gemini-2.0-flash'))
            ->generateContent($prompt);

        // 生成されたテキストを取得
        $generatedText = $result->text();

        if (empty($generatedText)) {
            throw new Exception('Generated text is empty');
        }

        // 改行や余分な空白を削除し、整形
        $generatedText = trim(preg_replace('/\s+/', ' ', $generatedText));

        // 「キャッチコピー:」などのプレフィックスを削除
        $generatedText = preg_replace('/^(キャッチコピー|catchphrase)[:\s]+/ui', '', $generatedText);

        return $generatedText;
    }

    /**
     * プロンプトを構築
     *
     * @param Cluster $cluster
     * @return string
     */
    private function buildPrompt(Cluster $cluster): string
    {
        return <<<PROMPT
あなたは日本の旅行ガイドのプロフェッショナルです。以下の観光エリアについて、魅力的なキャッチコピーを1つだけ生成してください。

# 観光エリア情報
- エリア名: {$cluster->name}
- 説明: {$cluster->description}

# キャッチコピーの条件
1. 40文字以内の日本語で記述する
2. 旅行者の感情に訴える魅力的な表現を使う
3. 「日帰り旅行」であることを意識する
4. エリアの特徴や魅力を端的に伝える
5. 親しみやすく、ワクワクする表現にする
6. 句読点は自然な位置にのみ使用する

# 出力形式
キャッチコピーのみを出力してください。説明や補足、プレフィックス（「キャッチコピー:」など）は不要です。
PROMPT;
    }

    /**
     * フォールバック用のダミーキャッチコピーを生成
     *
     * @param Cluster $cluster
     * @param float $fromLatitude
     * @param float $fromLongitude
     * @return Catchphrase
     */
    private function generateFallbackCatchphrase(Cluster $cluster, float $fromLatitude, float $fromLongitude): Catchphrase
    {
        $fallbackContents = [
            "{$cluster->name}で歴史とグルメを満喫する、大人の日帰り旅",
            "週末は{$cluster->name}へ。自然とアートに癒される1日",
            "{$cluster->name}の隠れた名所を巡る、特別な旅",
        ];

        $content = $fallbackContents[array_rand($fallbackContents)];

        return Catchphrase::create([
            'content' => $content,
            'context_data' => [
                'cluster_id' => $cluster->id,
                'cluster_name' => $cluster->name,
                'input_location' => [$fromLatitude, $fromLongitude],
                'generated_at' => now()->toIso8601String(),
                'generation_method' => 'fallback',
            ],
        ]);
    }
}
