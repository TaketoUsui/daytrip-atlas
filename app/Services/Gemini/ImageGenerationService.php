<?php

namespace App\Services\Gemini;

use App\Enums\ImageQualityLevel;
use App\Models\Image;
use App\Models\ModelPlan;
use App\Models\Tag;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

/**
 * AIによるキービジュアル（のメタデータ）生成とDB保存を担当するサービス。
 *
 * [変更] デモ最適化のため、AIによる「キーワード生成」から、
 * DB事前登録画像からの「選定」ロジックに変更。
 *
 * @see MVP_旅先提案アルゴリズム設計 C. インフラストラクチャサービス
 */
class ImageGenerationService extends BaseGeminiClient
{
    /**
     * AIを使用して、モデルプランに最適な「キービジュアル画像」を
     * DBに事前登録されたリストから選定し、そのImageモデルを返す。
     *
     * @param ModelPlan $modelPlan キービジュアルを選定する対象のモデルプラン
     * @param Collection<int, Tag> $tags ユーザーが入力したタグ（選定のヒント）
     * @return Image 選定されたImageモデル
     * @throws Throwable AIのレスポンスが不正、またはDB検索に失敗した場合
     */
    public function generateImageForModelPlan(ModelPlan $modelPlan, Collection $tags): Image
    {
        Log::info(
            "[ImageGeneration] Selecting image for ModelPlan ID: {$modelPlan->id}",
            ['plan_name' => $modelPlan->name]
        );


        $availableImages = Image::query()
        ->where('image_quality_level', ImageQualityLevel::ManuallyVerifiedPhoto)
        ->select(['id', 'alt_text', 'metadata'])
        ->get();

        if ($availableImages->isEmpty()) {
            Log::warning("[ImageGeneration] No 'ManuallyVerifiedPhoto' images found in DB. Falling back to AiGeneric.", ['plan_id' => $modelPlan->id]);
            // フォールバック: 既存のAiGeneric画像を返すか、ダミーのAiGeneric画像を作成する（ここではAiGenericの1件目を返す）
            return $this->findFallbackImage();
        }

        // 2. AIへの指示（プロンプト）を構築
        $prompt = $this->buildPrompt($modelPlan, $tags, $availableImages);

        // 3. BaseGeminiClient経由でAI APIをコール
        $response = $this->generateContent($prompt);


        $image = $this->findImageFromResponse($response, $availableImages);

        Log::info(
            "[ImageGeneration] Successfully selected Image ID: {$image->id}",
            ['alt_text' => $image->alt_text]
        );

        return $image;
    }

    /**
     * AIへの指示（プロンプト）を構築する
     *
     * @param ModelPlan $modelPlan
     * @param Collection<int, Tag> $tags ユーザー入力タグ
     * @param Collection<int, Image> $availableImages DB内の画像リスト
     * @return string
     */
    private function buildPrompt(ModelPlan $modelPlan, Collection $tags, Collection $availableImages): string
    {
        // プラン名と、プランに含まれるスポット名を取得
        $planName = $modelPlan->name;
        // リレーションがロードされていることを期待 (SuggestionContentServiceでロード済み)
        $spotNames = $modelPlan->items
        ->sortBy('display_order')
            ->map(fn($item) => $item->spot->name)
            ->implode('、');


        $userTheme = $tags->isEmpty() ? '指定なし' : $tags->pluck('name')->implode('、');

        $context = "プラン名: {$planName}\n主な訪問スポット: {$spotNames}\nユーザーの希望テーマ: {$userTheme}";


        $imageListPrompt = $availableImages->map(
            fn(Image $image) => "- ID {$image->id}: 説明=\"{$image->alt_text}\", 特徴メタデータ={$image->metadata_for_prompt}"
        )->implode("\n");


        // [変更] プロンプトを「キーワード生成」から「ID選定」に変更
        return <<<PROMPT
        あなたは優秀なアートディレクターです。
        以下の「モデルプラン」と「ユーザーの希望テーマ」に最もふさわしいキービジュアル画像を、
        提示された「画像リスト」の中から1つだけ選び、そのIDを返してください。

        # モデルプラン
        {$context}

        # 画像リスト (この中から選んでください)
        {$imageListPrompt}

        # 出力形式
        以下のキーを持つJSONオブジェクトを1つだけ生成してください。
        - "image_id": (int) 選定した画像のID (例: 1)

        JSONのみを返し、前後に説明文や ```json タグは不要です。
        PROMPT;
    }

    /**
     * AIのレスポンス（image_id）を検証し、Imageモデルを取得する
     *
     * @param array $response AIから返されたパース済みのJSON配列
     * @param Collection $availableImages AIに提示した画像リスト
     * @return Image
     * @throws \RuntimeException AIのレスポンスが不正な場合
     */
    private function findImageFromResponse(array $response, Collection $availableImages): Image
    {
        $imageId = $response['image_id'] ?? null;

        if (empty($imageId) || !is_numeric($imageId)) {
            throw new \RuntimeException("[ImageGeneration] AI response is missing 'image_id' key or content is invalid.");
        }


        $image = $availableImages->firstWhere('id', $imageId);

        if (!$image) {

            Log::warning("[ImageGeneration] AI returned an unknown image_id: {$imageId}. Falling back to first available image.", [
                'available_ids' => $availableImages->pluck('id')->all()
            ]);
            return $availableImages->first();
        }


        return Image::find($image->id);
    }

    /**
     * フォールバック用の画像を取得する
     * @return Image
     */
    private function findFallbackImage(): Image
    {
        // AiGenericの画像が1件も存在しない場合に備え、
        // 存在しない場合はAiGeneric画像を1件作成する（ロジックは簡略化）
        return Image::firstOrCreate(
            ['image_quality_level' => ImageQualityLevel::AiGeneric],
            [
                'file_name' => 'ai_fallback.jpg',
                'storage_path' => 'images/placeholders/ai_fallback.jpg', //
                'alt_text' => 'AI Generated Fallback Image',
                'copyright_holder' => 'AI Suggested Keyword (Placeholder)',
            ]
        );
    }

    /**
     * (旧メソッド: saveImageToDb は findImageFromResponse に置き換えられました)
     */
}
