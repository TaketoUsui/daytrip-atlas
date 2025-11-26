<?php

namespace App\Services;

/**
 * 地域情報（都道府県・市区町村）の解析サービス
 */
class LocationParserService
{
    /** 日本の都道府県一覧 */
    private const PREFECTURES = [
        '北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県',
        '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県',
        '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県',
        '静岡県', '愛知県', '三重県', '滋賀県', '京都府', '大阪府', '兵庫県',
        '奈良県', '和歌山県', '鳥取県', '島根県', '岡山県', '広島県', '山口県',
        '徳島県', '香川県', '愛媛県', '高知県', '福岡県', '佐賀県', '長崎県',
        '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県',
    ];

    /**
     * クラスター名から都道府県と市区町村を抽出
     *
     * @param  string  $clusterName  クラスター名（例: "兵庫県神戸市"）
     * @return array{prefecture: string|null, municipality: string|null}
     */
    public function parseClusterName(string $clusterName): array
    {
        foreach (self::PREFECTURES as $prefecture) {
            if (str_starts_with($clusterName, $prefecture)) {
                $municipality = str_replace($prefecture, '', $clusterName);

                return [
                    'prefecture' => $prefecture,
                    'municipality' => $municipality ?: null,
                ];
            }
        }

        // マッチしない場合はクラスター名全体を市区町村として扱う
        return [
            'prefecture' => null,
            'municipality' => $clusterName,
        ];
    }
}
