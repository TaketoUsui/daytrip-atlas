<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClusterResource;
use App\Http\Resources\ModelPlanResource;
use App\Models\Cluster;
use Inertia\Inertia;
use Inertia\Response;

class ClusterController extends Controller
{
    /**
     * クラスター詳細ページ表示
     *
     * クラスター基本情報とデフォルトモデルプランを表示
     */
    public function show(Cluster $cluster): Response
    {
        // デフォルトモデルプランとそのアイテム（スポット情報含む）をロード
        $cluster->load([
            'defaultModelPlan.items.spot',
        ]);

        return Inertia::render('Cluster/Detail', [
            'cluster' => (new ClusterResource($cluster))->resolve(),
            'modelPlan' => (new ModelPlanResource($cluster->defaultModelPlan))->resolve(),
        ]);
    }
}
