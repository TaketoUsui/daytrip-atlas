<?php

namespace App\Enums;

enum SuggestionStatus: string{
    case Pending = 'pending';
    case ProcessingClusters = 'processing_clusters';
    case AnalyzingItems = 'analyzing_items';
    case Complete = 'complete';
    case Failed = 'failed';

    public static function options(): array{
        return collect(self::cases())
            ->map(fn(self $case) => [$case->value])
            ->all();
    }

    /**
     * ユーザーフレンドリーな進捗メッセージを取得
     */
    public function getMessage(): string
    {
        return match ($this) {
            self::Pending => '提案のリクエストを受け付けました...',
            self::ProcessingClusters => 'あなたに合いそうな観光地を探しています...',
            self::AnalyzingItems => 'おすすめのプランを組み立てています...',
            self::Complete => '提案が完了しました！',
            self::Failed => '提案の作成に失敗しました。',
        };
    }
}
