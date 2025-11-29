<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ai_model_execution_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_model_id')->constrained()->onDelete('cascade')->comment('使用されたAIモデル');
            $table->timestamp('executed_at')->index()->comment('実際にAPI呼び出しを実行した時刻');
            $table->string('task_type')->comment('タスク種別（spot_detail, catchphrase等）');
            $table->enum('status', ['success', 'failed'])->comment('API呼び出しの成否');
            $table->morphs('target'); // target_type, target_id（対象エンティティ: Spot, Cluster, ModelPlan）
            $table->json('metadata')->nullable()->comment('実行詳細（レスポンス時間、トークン数など）');
            $table->timestamps();

            // 効率的な集計のためのインデックス
            $table->index(['ai_model_id', 'executed_at']);
            $table->index(['executed_at', 'status']);
            $table->index(['task_type', 'executed_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_model_execution_logs');
    }
};
