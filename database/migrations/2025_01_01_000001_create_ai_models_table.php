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
        Schema::create('ai_models', function (Blueprint $table) {
            $table->id();
            $table->string('model_name')->comment('例: gemini-1.5-flash, gemini-1.5-pro');
            $table->string('provider')->comment('例: google');
            $table->unsignedInteger('performance_priority')->comment('数値が大きいほど高性能（例: 200=最高性能, 100=標準）');
            $table->unsignedInteger('daily_limit')->comment('1日あたりのAPI呼び出し上限回数');
            $table->boolean('enabled')->default(true)->comment('モデルの有効/無効');
            $table->timestamps();

            // パフォーマンス優先度でのソートが頻繁に行われるためインデックスを追加
            $table->index(['enabled', 'performance_priority']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_models');
    }
};
