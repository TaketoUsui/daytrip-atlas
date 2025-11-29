<?php

namespace Tests\Unit;

use App\Services\GeminiClientService;
use Exception;
use Tests\TestCase;

class GeminiClientServiceTest extends TestCase
{
    private GeminiClientService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new GeminiClientService();
    }

    /**
     * 正常なJSONレスポンスのパース
     */
    public function test_parse_valid_json(): void
    {
        $response = '{"key": "value", "number": 123}';
        $result = $this->service->parseJsonResponse($response);

        $this->assertEquals(['key' => 'value', 'number' => 123], $result);
    }

    /**
     * コードブロック付きJSONのパース
     */
    public function test_parse_json_with_code_block(): void
    {
        $response = '```json
{"key": "value"}
```';
        $result = $this->service->parseJsonResponse($response);

        $this->assertEquals(['key' => 'value'], $result);
    }

    /**
     * 前後にテキストが含まれるJSONのパース
     */
    public function test_parse_json_with_surrounding_text(): void
    {
        $response = '説明文がここにあります。

{"key": "value", "nested": {"a": 1}}

後ろにも何かテキストがあります。';

        $result = $this->service->parseJsonResponse($response);

        $this->assertEquals(['key' => 'value', 'nested' => ['a' => 1]], $result);
    }

    /**
     * コードブロックとテキストが混在するJSONのパース
     */
    public function test_parse_json_with_code_block_and_text(): void
    {
        $response = '「峡谷美と歴史ロマン！東吾妻の発見日帰り旅」をテーマに、雄大な自然と歴史の舞台を巡る欲張りプランです。

```json
{
  "description": "名水百選に選ばれた清らかな湧水から始まり、絶景の吾妻渓谷を散策。",
  "plan_items": [
    {
      "spot_id": 1350,
      "duration_minutes": 30
    }
  ]
}
```';

        $result = $this->service->parseJsonResponse($response);

        $this->assertArrayHasKey('description', $result);
        $this->assertArrayHasKey('plan_items', $result);
        $this->assertCount(1, $result['plan_items']);
    }

    /**
     * 配列形式のJSONのパース
     */
    public function test_parse_json_array(): void
    {
        $response = 'テキスト [{"id": 1}, {"id": 2}] テキスト';
        $result = $this->service->parseJsonResponse($response);

        $this->assertCount(2, $result);
        $this->assertEquals(['id' => 1], $result[0]);
    }

    /**
     * 不正なJSONの場合は例外をスロー
     */
    public function test_parse_invalid_json_throws_exception(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Failed to parse JSON response');

        $response = 'これは有効なJSONではありません';
        $this->service->parseJsonResponse($response);
    }

    /**
     * 不完全なJSONの場合は例外をスロー
     */
    public function test_parse_incomplete_json_throws_exception(): void
    {
        $this->expectException(Exception::class);

        $response = '{"key": "value", "incomplete":';
        $this->service->parseJsonResponse($response);
    }
}
