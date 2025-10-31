<?php

namespace App\Services\Gemini;

use App\Models\Catchphrase;
use App\Models\ModelPlan;
use App\Models\Tag;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * AIによるキャッチコピーの生成とDB保存を担当するサービス。
 *
 * @see MVP_旅先提案アルゴリズム設計 C. インフラストラクチャサービス
 */
class CatchphraseGenerationService extends BaseGeminiClient
{
    /**
     * AIを使用してパーソナライズド・キャッチコピーを生成し、DBに保存する。
     *
     * @param ModelPlan $modelPlan 提案するモデルプラン
     * @param Collection<int, Tag> $tags ユーザーが入力したタグ（パーソナライズの根拠）
     * @return Catchphrase 生成されたCatchphraseモデル
     * @throws Throwable AIのレスポンスが不正、またはDB保存に失敗した場合
     */
    public function generateCatchphrase(ModelPlan $modelPlan, Collection $tags): Catchphrase
    {
        Log::info(
            "[CatchphraseGeneration] Generating catchphrase for ModelPlan ID: {$modelPlan->id}",
            [
                'plan_name' => $modelPlan->name,
                'tags' => $tags->pluck('name')->implode(', ')
            ]
        );

        // 1. AIへの指示（プロンプト）を構築
        $prompt = $this->buildPrompt($modelPlan, $tags);

        // 2. BaseGeminiClient経由でAI APIをコール
        // Spot/ModelPlanとは異なり、レスポンスは「キャッチコピー」という
        // 単一のテキストを期待する。BaseGeminiClient がJSONを要求するため、
        // プロンプト側でJSON形式での返却を指示する。
        $response = $this->generateContent($prompt);

        // 3. AIのレスポンスをDBに保存
        $catchphrase = $this->saveCatchphraseToDb($response, $tags);

        Log::info(
            "[CatchphraseGeneration] Successfully generated Catchphrase ID: {$catchphrase->id}",
            ['content' => $catchphrase->content]
        );

        return $catchphrase;
    }

    /**
     * AIへの指示（プロンプト）を構築する
     *
     * @param ModelPlan $modelPlan
     * @param Collection<int, Tag> $tags
     * @return string
     */
    private function buildPrompt(ModelPlan $modelPlan, Collection $tags): string
    {
        // アルゴリズム設計書 の例に基づく
        $planName = $modelPlan->name;

        // ユーザーが選択したタグをテーマとして使用する
        $theme = $tags->isEmpty()
            ? "旅行好き" // タグ未選択時のフォールバック
            : $tags->pluck('name')->implode('、');

        return <<<PROMPT
        あなたはプロのコピーライターです。
        以下の「ターゲット（テーマ）」に「プラン名」が刺さるような、短く（30文字以内）魅力的なキャッチコピーを1つだけ生成してください。

        # ターゲット（テーマ）
        「{$theme}」が好きな人

        # プラン名
        {$planName}

        # 出力形式
        以下のキーを持つJSONオブジェクトを1つだけ生成してください。
        - "catchphrase": (string) 生成したキャッチコピー

        例:
        {
          "catchphrase": "古都の風を感じる、癒やしの休日"
        }

        JSONのみを返し、前後に説明文や ```json タグは不要です。
        PROMPT;
    }

    /**
     * AIのレスポンスを検証し、DBに保存する
     *
     * @param array $response AIから返されたパース済みのJSON配列
     * @param Collection<int, Tag> $tags
     * @return Catchphrase
     * @throws \RuntimeException AIのレスポンスが不正な場合
     */
    private function saveCatchphraseToDb(array $response, Collection $tags): Catchphrase
    {
        $content = $response['catchphrase'] ?? null;

        if (empty($content) || !is_string($content)) {
            throw new \RuntimeException("[CatchphraseGeneration] AI response is missing 'catchphrase' key or content is empty.");
        }

        // アルゴリズム設計 と DB設計 に従い、
        // 生成根拠として入力タグIDを 'source_analysis' カラムにJSONBで保存する
        $sourceTagIds = $tags->pluck('id')->all();

        return Catchphrase::create([
            'content' => $content,
            'source_analysis' => ['source_tags' => $sourceTagIds],
            'performance_score' => 0, // 初期スコアは0
        ]);
    }
}
