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
        Schema::create('model_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cluster_id')
                ->constrained('clusters')
                ->cascadeOnDelete();

            // メインスポットとキービジュアル（AI分析で設定）
            $table->foreignId('main_spot_id')->nullable()
                ->constrained('spots')
                ->nullOnDelete();
            $table->foreignId('image_id')->nullable()
                ->constrained('images')
                ->nullOnDelete();

            $table->string('name');
            $table->text('description')
                ->nullable();
            $table->unsignedInteger('total_duration_minutes')->default(0);
            // クラスターの代表プランかどうか（cluster_idごとに1つだけtrueという制約あり）
            $table->boolean('is_default')->default(false);

            // AI分析関連カラム - キャッチフレーズ生成
            $table->unsignedBigInteger('catchphrase_analyzed_by_model_id')->nullable();
            $table->unsignedBigInteger('catchphrase_analyzing_by_model_id')->nullable();
            $table->timestamp('catchphrase_analyzing_started_at')->nullable();

            // AI分析関連カラム - モデルプラン生成
            $table->unsignedBigInteger('model_plan_analyzed_by_model_id')->nullable();
            $table->unsignedBigInteger('model_plan_analyzing_by_model_id')->nullable();
            $table->timestamp('model_plan_analyzing_started_at')->nullable();

            $table->timestamps();

            // 外部キー制約（ai_modelsテーブルへの参照）
            $table->foreign('catchphrase_analyzed_by_model_id')->references('id')->on('ai_models')->nullOnDelete();
            $table->foreign('catchphrase_analyzing_by_model_id')->references('id')->on('ai_models')->nullOnDelete();
            $table->foreign('model_plan_analyzed_by_model_id')->references('id')->on('ai_models')->nullOnDelete();
            $table->foreign('model_plan_analyzing_by_model_id')->references('id')->on('ai_models')->nullOnDelete();
        });

        // cluster_idごとにis_default=trueは1つだけという制約（PostgreSQL部分インデックス）
        DB::statement('CREATE UNIQUE INDEX unique_default_model_plan_per_cluster ON model_plans (cluster_id) WHERE is_default = true');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP INDEX IF EXISTS unique_default_model_plan_per_cluster');
        Schema::dropIfExists('model_plans');
    }
};
