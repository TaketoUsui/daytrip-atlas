<?php

namespace App\Services\Gemini;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Gemini API クライアント（基底クラス）
 *
 * LaravelのHTTPクライアントをラップし、認証、リトライ、基本的なリクエスト構築を共通化する。
 * サブクラス（SpotGenerationServiceなど）は、具体的なプロンプトの構築と
 * レスポンスのパース（データモデルへの変換）に集中する。
 *
 * @see MVP_旅先提案アルゴリズム設計 C. インフラストラクチャサービス
 */
abstract class BaseGeminiClient
{
    /**
     * @var PendingRequest Laravel HTTPクライアントのインスタンス
     */
    protected readonly PendingRequest $client;

    /**
     * @var string 使用するAIモデル
     */
    protected readonly string $model;

    /**
     * @var array<string, mixed> Gemini APIに渡す共通設定
     */
    protected array $generationConfig = [
        'responseMimeType' => 'application/json', // 常にJSON形式でのレスポンスを要求
    ];

    /**
     * BaseGeminiClientのコンストラクタ
     *
     * APIキーとベースURI、リトライ設定を読み込み、HTTPクライアントを初期化する。
     */
    public function __construct()
    {
        $config = config('services.gemini');
        $apiKey = $config['api_key'] ?? null;
        $baseUri = $config['base_uri'] ?? '';
        $retryConfig = $config['retry'] ?? ['times' => 1, 'sleep_milliseconds' => 0];

        if (empty($apiKey)) {
            Log::critical('[GeminiClient] GEMINI_API_KEYが設定されていません。');
            throw new \InvalidArgumentException('Gemini API Key not configured.');
        }

        $this->client = Http::baseUrl($baseUri)
            ->timeout(120) // タイムアウトを120秒に設定
            ->retry(
                $retryConfig['times'],
                $retryConfig['sleep_milliseconds'],
                null, // $when (常にリトライ)
                true  // $throw (リトライ失敗時に例外をスロー)
            );

        $this->model = $config['model'] ?? 'gemini-2.5-flash';
    }

    /**
     * Gemini APIにプロンプトを送信し、JSONレスポンスを解析して返す
     *
     * @param string $prompt AIへの指示（プロンプト）
     * @param string|null $model (オプション) デフォルト以外のモデルを使用する場合に指定
     * @return array<string, mixed> AIが生成したJSONをパースした連想配列
     * @throws RequestException API通信が失敗した場合
     * @throws \JsonException AIのレスポンスがJSONとしてパースできない場合
     * @throws Throwable
     */
    protected function generateContent(string $prompt, ?string $model = null): array
    {
        $modelToUse = $model ?? $this->model;
        $endpoint = "v1beta/models/{$modelToUse}:generateContent";
        $apiKey = config('services.gemini.api_key');

        Log::debug("[GeminiClient] Requesting to model: {$modelToUse}", ['prompt' => $prompt]);

        try {
            $response = $this->client->post("{$endpoint}?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => $this->generationConfig,
            ]);

            // 4xx, 5xxエラーの場合は例外をスロー
            $response->throw();

            // レスポンスからJSON文字列を抽出
            $jsonString = $this->extractJsonFromResponse($response);

            // JSON文字列を連想配列にデコード
            $decoded = json_decode($jsonString, true, 512, JSON_THROW_ON_ERROR);

            Log::debug("[GeminiClient] Response received and parsed.", ['model' => $modelToUse]);

            return $decoded;

        } catch (RequestException $e) {
            // API通信自体のエラー
            Log::error("[GeminiClient] API Request Failed.", [
                'model' => $modelToUse,
                'status' => $e->response?->status(),
                'response_body' => $e->response?->body(),
                'message' => $e->getMessage(),
            ]);
            throw $e; // ジョブ側で捕捉するために再スロー
        } catch (\JsonException $e) {
            // AIのレスポンスが期待したJSON形式でない場合
            Log::error("[GeminiClient] Failed to parse JSON response from AI.", [
                'model' => $modelToUse,
                'message' => $e->getMessage(),
                'raw_response' => $response?->body(),
            ]);
            throw $e; // ジョブ側で捕捉するために再スロー
        } catch (Throwable $e) {
            // その他の予期せぬエラー
            Log::critical("[GeminiClient] An unexpected error occurred.", [
                'model' => $modelToUse,
                'exception' => $e,
            ]);
            throw $e; // ジョブ側で捕捉するために再スロー
        }
    }

    /**
     * Gemini APIのレスポンスボディから、AIが生成したテキスト（JSON文字列）を抽出する
     *
     * @param Response $response
     * @return string AIが生成したJSON文字列
     * @throws \Exception レスポンス構造が予期しない形式だった場合
     */
    private function extractJsonFromResponse(Response $response): string
    {
        // $response->json() は Illuminate\Http\Client\Response のメソッド
        $data = $response->json();

        // レスポンス構造: $data['candidates'][0]['content']['parts'][0]['text']
        $text = Arr::get($data, 'candidates.0.content.parts.0.text');

        if ($text === null) {
            // 予期しないレスポンス構造、またはAIがコンテンツを生成できなかった
            Log::warning("[GeminiClient] Unexpected response structure or empty content.", [
                'response_body' => $data
            ]);
            throw new \RuntimeException("Failed to extract content from Gemini response.");
        }

        // AIのレスポンスには "```json\n{...}\n```" のようなマークダウンが含まれることがあるため、除去する
        return trim($text, " \n\r\t\v\0`json");
    }
}
