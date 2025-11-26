<?php

namespace App\Services;

use App\Models\Cluster;
use Illuminate\Support\Facades\Log;

/**
 * クラスターの観光価値を再評価するサービス
 */
class ClusterEvaluatorService
{
    // 基礎スコア
    private const BASE_SCORE = 10;

    // スポット数による加点（1スポットあたり）
    private const SPOT_COUNT_WEIGHT = 2;

    // スポット役割による加点
    private const ROLE_WEIGHTS = [
        'main_destination' => 5,
        'sub_destination' => 3,
        'connector_spot' => 1,
    ];

    /**
     * クラスターの観光価値を再評価
     *
     * @param  Cluster  $cluster  対象クラスター
     * @return int 更新後の観光価値
     */
    public function evaluateCluster(Cluster $cluster): int
    {
        // 紐づくスポットを取得（spot_role が設定されているもののみ）
        $spots = $cluster->spots()
            ->whereNotNull('spot_role')
            ->get();

        // 基礎スコア
        $score = self::BASE_SCORE;

        // スポット数による加点
        $spotCount = $spots->count();
        $score += $spotCount * self::SPOT_COUNT_WEIGHT;

        // 各スポットの役割による加点
        foreach ($spots as $spot) {
            $roleValue = $spot->spot_role?->value ?? null;
            $roleWeight = self::ROLE_WEIGHTS[$roleValue] ?? 0;
            $score += $roleWeight;
        }

        // クラスターの観光価値を更新
        $cluster->update(['tourism_value' => $score]);

        Log::info('Cluster evaluated', [
            'cluster_id' => $cluster->id,
            'cluster_name' => $cluster->name,
            'spot_count' => $spotCount,
            'tourism_value' => $score,
        ]);

        return $score;
    }

    /**
     * 複数のクラスターを一括再評価
     *
     * @param  \Illuminate\Support\Collection<int, Cluster>  $clusters  クラスターのコレクション
     * @return array<int, int> クラスターIDと観光価値のマッピング
     */
    public function evaluateClusters($clusters): array
    {
        $results = [];

        foreach ($clusters as $cluster) {
            $results[$cluster->id] = $this->evaluateCluster($cluster);
        }

        return $results;
    }
}
