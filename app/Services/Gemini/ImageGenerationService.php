<?php

namespace App\Services\Gemini;

use App\Enums\ImageQualityLevel;
use App\Models\Image;
use App\Models\ModelPlan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

/**
 * AIによるキービジュアル（のメタデータ）生成とDB保存を担当するサービス。
 *
 * @see MVP_旅先提案アルゴリズム設計 C. インフラストラクチャサービス
 */
class ImageGenerationService extends BaseGeminiClient
{
    /**
     * AIを使用して、モデルプランに最適な「検索キーワード」を生成し、
     * それをメタデータとして持つImageレコードを作成する。
     *
     * @param ModelPlan $modelPlan キービジュアルを生成する対象のモデルプラン
     * @return Image 生成されたImageモデル
     * @throws Throwable AIのレスポンスが不正、またはDB保存に失敗した場合
     */
    public function generateImageForModelPlan(ModelPlan $modelPlan): Image
    {
        Log::info(
            "[ImageGeneration] Generating image metadata for ModelPlan ID: {$modelPlan->id}",
            ['plan_name' => $modelPlan->name]
        );

        // 1. AIへの指示（プロンプト）を構築
        $prompt = $this->buildPrompt($modelPlan);

        // 2. BaseGeminiClient経由でAI APIをコール
        $response = $this->generateContent($prompt);

        // 3. AIのレスポンス（キーワード）をDBに保存
        $image = $this->saveImageToDb($response);

        Log::info(
            "[ImageGeneration] Successfully generated Image ID: {$image->id}",
            ['keyword_alt_text' => $image->alt_text]
        );

        return $image;
    }

    /**
     * AIへの指示（プロンプト）を構築する
     *
     * @param ModelPlan $modelPlan
     * @return string
     */
    private function buildPrompt(ModelPlan $modelPlan): string
    {
        // プラン名と、プランに含まれるスポット名を取得
        $planName = $modelPlan->name;
        // リレーションがロードされていることを期待 (SuggestionContentServiceでロードすべき)
        // もしロードされていない場合でも、N+1を避けるためプラン名だけで実行する
        $spotNames = $modelPlan->items
            ->sortBy('display_order')
            ->map(fn($item) => $item->spot->name)
            ->implode('、');

        $context = "プラン名: {$planName}\n主な訪問スポット: {$spotNames}";
        if ($spotNames === '') {
            $context = "プラン名: {$planName}";
        }

        // アルゴリズム設計書 に従い、検索キーワードを要求する
        return <<<PROMPT
        あなたは優秀なアートディレクターです。
        以下の「モデルプラン」のキービジュアルとして、ストックフォトサービス（Unsplashなど）で検索すべき、
        最も象徴的で魅力的な「英語の検索キーワード」を1つだけ生成してください。

        # モデルプラン
        {$context}

        # 出力形式
        以下のキーを持つJSONオブジェクトを1つだけ生成してください。
        - "keyword": (string) 生成した英語の検索キーワード (例: "Kamakura Great Buddha sunset")

        JSONのみを返し、前後に説明文や ```json タグは不要です。
        PROMPT;
    }

    /**
     * AIのレスポンス（キーワード）を検証し、ImageレコードとしてDBに保存する
     *
     * @param array $response AIから返されたパース済みのJSON配列
     * @return Image
     * @throws \RuntimeException AIのレスポンスが不正な場合
     */
    private function saveImageToDb(array $response): Image
    {
        $keyword = $response['keyword'] ?? null;

        if (empty($keyword) || !is_string($keyword)) {
            throw new \RuntimeException("[ImageGeneration] AI response is missing 'keyword' key or content is empty.");
        }

        $fileName = 'ai_generic_' . Str::uuid() . '.jpg';

        // アルゴリズム設計 と DB設計 に従う
        return Image::create([
            // uuidはImageモデルのbooted()メソッドで自動生成される想定
            'file_name' => $fileName,
            // MVPでは、フロントエンドで表示する共通のプレースホルダー画像パスを指定する
            'storage_path' => 'images/placeholders/' . $fileName,
            // alt_text にAIが生成したキーワードを格納する
            'alt_text' => $keyword,
            'copyright_holder' => 'AI Suggested Keyword (Placeholder)',
            //
            'image_quality_level' => ImageQualityLevel::AiGeneric,
        ]);
    }
}
