<?php

namespace App\Services;

use Exception;
use Gemini;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

        // プロンプトログを記録（デバッグ用）
        if (config('services.gemini.log_prompts', false)) {
            $this->logPrompt($prompt, $model);
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

                // レスポンスログを記録（デバッグ用）
                if (config('services.gemini.log_prompts', false)) {
                    $this->logResponse($generatedText, $model);
                }

                return $generatedText;

            } catch (Exception $e) {
                $attempt++;
                $lastException = $e;

                // "The model is overloaded" エラーはサーバー側の一時的な過負荷
                // リトライせずに即座に例外をthrow（グローバルハンドラでログレベル調整）
                if (stripos($e->getMessage(), 'overloaded') !== false) {
                    throw new Exception('Gemini model is overloaded', 0, $e);
                }

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
        // 元のレスポンスを保存（エラー時のログ用）
        $originalResponse = $response;

        // コードブロック（```json ... ```）を除去
        $response = preg_replace('/```json\s*/', '', $response);
        $response = preg_replace('/```\s*$/', '', $response);
        $response = trim($response);

        $decoded = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            // パースエラー時の詳細情報をログに出力
            $errorMessage = json_last_error_msg();
            $responsePreview = mb_substr($originalResponse, 0, 500);
            $responseLength = mb_strlen($originalResponse);

            Log::error('Failed to parse JSON response from Gemini API', [
                'error' => $errorMessage,
                'response_length' => $responseLength,
                'response_preview' => $responsePreview,
                'cleaned_response_preview' => mb_substr($response, 0, 500),
            ]);

            // より詳細なエラーメッセージを含む例外をthrow
            throw new Exception(
                "Failed to parse JSON response: {$errorMessage}. ".
                "Response length: {$responseLength} characters. ".
                "Preview: ".mb_substr($originalResponse, 0, 200)."..."
            );
        }

        return $decoded;
    }

    /**
     * プロンプトをログファイルに記録（デバッグ用）
     *
     * @param  string  $prompt  送信するプロンプト
     * @param  string  $model  使用するモデル名
     */
    private function logPrompt(string $prompt, string $model): void
    {
        $timestamp = now()->format('Y-m-d H:i:s');
        $dateHour = now()->format('Y-m-d_H');
        $logFile = "logs/gemini-prompts-{$dateHour}.log";

        $logContent = str_repeat('=', 80)."\n";
        $logContent .= "[{$timestamp}] PROMPT SENT\n";
        $logContent .= "Model: {$model}\n";
        $logContent .= str_repeat('-', 80)."\n";
        $logContent .= $prompt."\n";
        $logContent .= str_repeat('=', 80)."\n\n";

        Storage::disk('local')->append($logFile, $logContent);
    }

    /**
     * レスポンスをログファイルに記録（デバッグ用）
     *
     * @param  string  $response  受信したレスポンス
     * @param  string  $model  使用したモデル名
     */
    private function logResponse(string $response, string $model): void
    {
        $timestamp = now()->format('Y-m-d H:i:s');
        $dateHour = now()->format('Y-m-d_H');
        $logFile = "logs/gemini-prompts-{$dateHour}.log";

        $logContent = "[{$timestamp}] RESPONSE RECEIVED\n";
        $logContent .= "Model: {$model}\n";
        $logContent .= str_repeat('-', 80)."\n";
        $logContent .= $response."\n";
        $logContent .= str_repeat('=', 80)."\n\n";

        Storage::disk('local')->append($logFile, $logContent);
    }
}
