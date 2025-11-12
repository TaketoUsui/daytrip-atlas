<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Data;

/**
 * Catchphrase.source_analysis のスキーマ定義
 *
 * キャッチフレーズ生成の根拠となる情報を保存します。
 * - cluster: クラスター名
 * - keywords: キーワードリスト
 * - source_tags: 元となるタグIDリスト（将来的な使用）
 */
class SourceAnalysisData extends Data
{
    public function __construct(
        /** @var string|null クラスター名 */
        public ?string $cluster = null,

        /** @var string[]|null キーワードの配列 */
        #[ArrayType]
        public ?array $keywords = null,

        /** @var int[]|null 元となるタグIDの配列（将来的な使用） */
        #[ArrayType]
        public ?array $source_tags = null,
    ) {}
}
