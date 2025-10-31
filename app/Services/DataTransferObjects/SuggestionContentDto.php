<?php

namespace App\Services\DataTransferObjects;

/**
 * SuggestionContentServiceからGenerateSuggestionsJobへ、
 * 提案アイテムの作成に必要なID群を渡すためのDTO。
 *
 * @see MVP_旅先提案アルゴリズム設計 B. ドメインサービス
 * @see DB設計_改二 suggestion_set_items
 */
readonly class SuggestionContentDto
{
    public function __construct(
        public int $clusterId,
        public int $modelPlanId,
        public int $catchphraseId,
        public int $keyVisualImageId,
    ) {
    }
}
