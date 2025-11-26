<?php

namespace App\Services;

use Exception;
use Gemini;
use Illuminate\Support\Facades\Log;

/**
 * Gemini API呼び出しを共通化するサービス
 */
class GeminiClientService
{
    /**
     * Gemini APIでコンテンツを生成
     *
     * @param  string  $prompt  送信するプロンプト
     * @param  string  $model  使用するモデル名（デフォルト: gemini-2.5-flash）
     * @param  int  $maxRetries  最大リトライ回数（デフォルト: 3）
     * @return string 生成されたテキスト
     *
     * @throws Exception API呼び出しが失敗した場合
     */
    public function generateContent(
        string $prompt,
        string $model = 'gemini-2.5-flash',
        int $maxRetries = 3
    ): string {
        $apiKey = config('services.gemini.api_key');

        if (empty($apiKey)) {
            throw new Exception('Gemini API key is not configured');
        }

        $attempt = 0;
        $lastException = null;

        while ($attempt < $maxRetries) {
            try {
                // Geminiクライアントを初期化
                $client = Gemini::client($apiKey);

                // モデルを選択してコンテンツ生成
                $result = $client
                    ->generativeModel(model: $model)
                    ->generateContent($prompt);

                // 生成されたテキストを取得
                $generatedText = $result->text();

                if (empty($generatedText)) {
                    throw new Exception('Generated text is empty');
                }

                return $generatedText;

            } catch (Exception $e) {
                $attempt++;
                $lastException = $e;

                Log::warning("Gemini API call failed (attempt {$attempt}/{$maxRetries})", [
                    'model' => $model,
                    'error' => $e->getMessage(),
                ]);

                // 最終試行でない場合は待機してリトライ
                if ($attempt < $maxRetries) {
                    $sleepMs = config('services.gemini.retry.sleep_milliseconds', 1000);
                    usleep($sleepMs * 1000);
                }
            }
        }

        // 全てのリトライが失敗した場合
        throw new Exception(
            "Gemini API call failed after {$maxRetries} attempts: ".$lastException->getMessage(),
            0,
            $lastException
        );
    }

    /**
     * JSON形式のレスポンスをパース
     *
     * @param  string  $response  Gemini APIからのレスポンステキスト
     * @return array<string, mixed> パースされたJSON配列
     *
     * @throws Exception JSON解析に失敗した場合
     */
    public function parseJsonResponse(string $response): array
    {
        // コードブロック（```json ... ```）を除去
        $response = preg_replace('/```json\s*/', '', $response);
        $response = preg_replace('/```\s*$/', '', $response);
        $response = trim($response);

        $decoded = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Failed to parse JSON response: '.json_last_error_msg());
        }

        return $decoded;
    }
}
