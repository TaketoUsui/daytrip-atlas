<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Spot;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * スポットに最適な既存画像を選択するサービス
 */
class ImageSelectorService
{
    public function __construct(
        private readonly PromptLoaderService $promptLoader,
        private readonly GeminiClientService $geminiClient
    ) {}

    /**
     * スポットに最適な画像を選択して紐づける
     *
     * @param  Spot  $spot  対象スポット
     * @return Image|null 選択された画像（失敗時はnull）
     */
    public function selectImageForSpot(Spot $spot): ?Image
    {
        try {
            // 利用可能な画像リストを取得
            $availableImages = Image::all();

            if ($availableImages->isEmpty()) {
                Log::warning('No available images found');

                return null;
            }

            // 画像リストをフォーマット
            $imageListText = $this->formatImageList($availableImages);

            // プロンプトを読み込み
            $prompt = $this->promptLoader->load('image_selection.txt', [
                'spot_name' => $spot->name,
                'spot_role' => $spot->spot_role?->value ?? 'unknown',
                'prefecture' => $spot->prefecture ?? '',
                'municipality' => $spot->municipality ?? '',
                'available_images' => $imageListText,
            ]);

            // Gemini APIで画像を選択
            $response = $this->geminiClient->generateContent(
                $prompt,
                model: 'gemini-2.5-flash-lite'
            );

            // JSONレスポンスをパース
            $data = $this->geminiClient->parseJsonResponse($response);

            if (! isset($data['selected_image_id'])) {
                throw new Exception('Missing selected_image_id in response');
            }

            $selectedImageId = $data['selected_image_id'];

            // 画像を取得
            $selectedImage = Image::find($selectedImageId);

            if (! $selectedImage) {
                throw new Exception("Selected image not found: {$selectedImageId}");
            }

            // スポットと画像を紐づけ
            $spot->images()->syncWithoutDetaching([
                $selectedImage->id => ['display_order' => 1],
            ]);

            Log::info('Successfully selected image for spot', [
                'spot_id' => $spot->id,
                'spot_name' => $spot->name,
                'image_id' => $selectedImage->id,
            ]);

            return $selectedImage;

        } catch (Exception $e) {
            Log::error('Failed to select image for spot', [
                'spot_id' => $spot->id,
                'spot_name' => $spot->name,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * 画像リストをテキスト形式にフォーマット
     *
     * @param  \Illuminate\Database\Eloquent\Collection<int, Image>  $images  画像コレクション
     * @return string フォーマットされた画像リスト
     */
    private function formatImageList($images): string
    {
        $lines = [];

        foreach ($images as $image) {
            $lines[] = sprintf(
                'ID: %d - カテゴリ: %s',
                $image->id,
                $image->category ?? '未分類'
            );
        }

        return implode("\n", $lines);
    }
}
