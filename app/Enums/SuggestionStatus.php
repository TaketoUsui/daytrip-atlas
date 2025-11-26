<?php

namespace App\Enums;

/**
 * 提案生成のステータス
 *
 * AI自動生成の各段階を表す
 */
enum SuggestionStatus: string
{
    case Pending = 'pending';
    case ProcessingClusters = 'processing_clusters';
    case GeneratingContent = 'generating_content';
    case Complete = 'complete';
    case NoResults = 'no_results';
    case Failed = 'failed';

    public static function options(): array
    {
        return collect(self::cases())
            ->map(fn (self $case) => [$case->value])
            ->all();
    }

    /**
     * ユーザー向けの進捗メッセージを取得
     */
    public function getMessage(): string
    {
        return match ($this) {
            self::Pending => '提案のリクエストを受け付けました...',
            self::ProcessingClusters => 'あなたに合いそうな観光地を探しています...',
            self::GeneratingContent => 'キャッチコピーとプランを生成しています...',
            self::Complete => '提案が完了しました！',
            self::NoResults => '現在、条件に合う旅行先が見つかりませんでした。',
            self::Failed => '提案の作成に失敗しました。',
        };
    }

    /**
     * 処理中のステータスかどうかを判定
     */
    public function isProcessing(): bool
    {
        return in_array($this, [
            self::Pending,
            self::ProcessingClusters,
            self::GeneratingContent,
        ]);
    }
}
