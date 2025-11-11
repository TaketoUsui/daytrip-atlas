<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Data;

/**
 * SuggestionSet.processing_details のスキーマ定義
 *
 * サジェスチョン生成処理の詳細情報を保存します。
 * - found_clusters: 見つかったクラスター名の配列
 * - error: エラーメッセージ（エラー時のみ）
 * - trace: スタックトレース（エラー時のみ）
 */
class ProcessingDetailsData extends Data
{
    public function __construct(
        /** @var string[]|null クラスター生成時に見つかったクラスター名 */
        #[ArrayType]
        public ?array $found_clusters = null,

        /** @var string|null エラーメッセージ（失敗時のみ） */
        public ?string $error = null,

        /** @var string|null スタックトレース（失敗時のみ） */
        public ?string $trace = null,
    ) {
    }
}
