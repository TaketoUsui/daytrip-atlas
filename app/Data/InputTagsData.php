<?php

namespace App\Data;

use Spatie\LaravelData\Data;

/**
 * SuggestionSet.input_tags_json のスキーマ定義
 *
 * ユーザーが入力したタグ情報の配列を保存します。
 * 現在はstring[]として保存されますが、将来的にint[]（タグID）に変更する可能性があります。
 */
class InputTagsData extends Data
{
    public function __construct(
        /** @var string[] タグ文字列の配列 */
        public array $tags = [],
    ) {}

    /**
     * 配列から直接インスタンス化する際の便利メソッド
     */
    public static function fromArray(array $tags): self
    {
        return new self(tags: $tags);
    }
}
