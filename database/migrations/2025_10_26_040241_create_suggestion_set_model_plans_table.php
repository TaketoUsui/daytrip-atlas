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
        Schema::create('suggestion_set_model_plans', function (Blueprint $table) {
            $table->foreignId('suggestion_set_id')
                ->constrained('suggestion_sets')
                ->cascadeOnDelete();
            $table->foreignId('model_plan_id')
                ->constrained('model_plans')
                ->cascadeOnDelete();
            $table->unsignedInteger('display_order')->comment('提案結果一覧での表示順序');
            $table->string('generated_travel_time_text')->nullable()->comment('出発地からの移動時間テキスト（例: "車で約45分"）');
            $table->timestamp('created_at')->nullable();

            // 複合主キー
            $table->primary(['suggestion_set_id', 'model_plan_id']);

            // display_orderでのソート用インデックス
            $table->index(['suggestion_set_id', 'display_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggestion_set_model_plans');
    }
};
