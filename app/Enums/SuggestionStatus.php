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
    case ListingSpots = 'listing_spots';
    case AnalyzingSpots = 'analyzing_spots';
    case GeneratingContent = 'generating_content';
    case EvaluatingClusters = 'evaluating_clusters';
    case Complete = 'complete';
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
            self::ListingSpots => '観光スポットをリストアップしています...',
            self::AnalyzingSpots => '各スポットの詳細を分析しています...',
            self::GeneratingContent => 'キャッチコピーとプランを生成しています...',
            self::EvaluatingClusters => '最終的な提案内容を調整しています...',
            self::Complete => '提案が完了しました！',
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
            self::ListingSpots,
            self::AnalyzingSpots,
            self::GeneratingContent,
            self::EvaluatingClusters,
        ]);
    }
}
