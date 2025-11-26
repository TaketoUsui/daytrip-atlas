<?php

namespace App\Enums;

/**
 * スポットの役割
 *
 * 旅行プランにおけるスポットの位置づけを定義
 */
enum SpotRole: string
{
    /** メインの目的地（観光の中心） */
    case MainDestination = 'main_destination';

    /** サブの目的地（補助的な観光地） */
    case SubDestination = 'sub_destination';

    /** 接続スポット（食事・休憩・移動の中継点） */
    case ConnectorSpot = 'connector_spot';

    /** 生成中（詳細分析未完了） */
    case Generating = 'generating';

    public static function options(): array
    {
        return collect(self::cases())
            ->map(fn (self $case) => [$case->value])
            ->all();
    }

    /**
     * 役割の説明を取得
     */
    public function getDescription(): string
    {
        return match ($this) {
            self::MainDestination => 'メインの目的地',
            self::SubDestination => 'サブの目的地',
            self::ConnectorSpot => '接続スポット',
            self::Generating => '生成中',
        };
    }
}
