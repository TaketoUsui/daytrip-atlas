<?php

namespace App\Services;

use App\Data\SourceAnalysisData;
use App\Models\Catchphrase;
use App\Models\Cluster;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * AIを使用してクラスター向けのキャッチコピーを生成するサービス
 *
 * Phase 4: Gemini APIを使用した本実装（プロンプト分離版）
 */
class CatchphraseGeneratorService
{
    public function __construct(
        private readonly PromptLoaderService $promptLoader,
        private readonly GeminiClientService $geminiClient
    ) {}

    /**
     * クラスター向けのキャッチコピーを生成
     *
     * @param  Cluster  $cluster  対象クラスター
     * @param  float  $fromLatitude  出発地の緯度
     * @param  float  $fromLongitude  出発地の経度
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
                'source_analysis' => new SourceAnalysisData(
                    cluster: $cluster->name
                ),
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
     * @return string 生成されたキャッチコピー
     *
     * @throws Exception
     */
    private function generateWithGemini(Cluster $cluster): string
    {
        // プロンプトを読み込み
        $prompt = $this->promptLoader->load('catchphrase_generation.txt', [
            'cluster_name' => $cluster->name,
        ]);

        // Gemini APIでコンテンツ生成
        $generatedText = $this->geminiClient->generateContent(
            $prompt,
            model: 'gemini-2.5-flash'
        );

        // 改行や余分な空白を削除し、整形
        $generatedText = trim(preg_replace('/\s+/', ' ', $generatedText));

        // 「キャッチコピー:」などのプレフィックスを削除
        $generatedText = preg_replace('/^(キャッチコピー|catchphrase)[:\s]+/ui', '', $generatedText);

        if (empty($generatedText)) {
            throw new Exception('Generated text is empty after formatting');
        }

        return $generatedText;
    }

    /**
     * フォールバック用のダミーキャッチコピーを生成
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
            'source_analysis' => new SourceAnalysisData(
                cluster: $cluster->name
            ),
        ]);
    }
}
