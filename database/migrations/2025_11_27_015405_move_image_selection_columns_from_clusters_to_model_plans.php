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
        // model_plansテーブルに画像選定関連のカラムを追加
        Schema::table('model_plans', function (Blueprint $table) {
            $table->unsignedBigInteger('image_selection_analyzed_by_model_id')->nullable()->after('model_plan_analyzing_started_at');
            $table->unsignedBigInteger('image_selection_analyzing_by_model_id')->nullable()->after('image_selection_analyzed_by_model_id');
            $table->timestamp('image_selection_analyzing_started_at')->nullable()->after('image_selection_analyzing_by_model_id');

            // 外部キー制約
            $table->foreign('image_selection_analyzed_by_model_id')->references('id')->on('ai_models')->nullOnDelete();
            $table->foreign('image_selection_analyzing_by_model_id')->references('id')->on('ai_models')->nullOnDelete();
        });

        // clustersテーブルから画像選定関連のカラムを削除
        Schema::table('clusters', function (Blueprint $table) {
            $table->dropForeign(['image_analyzed_by_model_id']);
            $table->dropForeign(['image_analyzing_by_model_id']);
            $table->dropColumn([
                'image_analyzed_by_model_id',
                'image_analyzing_by_model_id',
                'image_analyzing_started_at',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // clustersテーブルに画像選定関連のカラムを復元
        Schema::table('clusters', function (Blueprint $table) {
            $table->unsignedBigInteger('image_analyzed_by_model_id')->nullable()->after('main_spot_analyzing_started_at');
            $table->unsignedBigInteger('image_analyzing_by_model_id')->nullable()->after('image_analyzed_by_model_id');
            $table->timestamp('image_analyzing_started_at')->nullable()->after('image_analyzing_by_model_id');

            $table->foreign('image_analyzed_by_model_id')->references('id')->on('ai_models')->nullOnDelete();
            $table->foreign('image_analyzing_by_model_id')->references('id')->on('ai_models')->nullOnDelete();
        });

        // model_plansテーブルから画像選定関連のカラムを削除
        Schema::table('model_plans', function (Blueprint $table) {
            $table->dropForeign(['image_selection_analyzed_by_model_id']);
            $table->dropForeign(['image_selection_analyzing_by_model_id']);
            $table->dropColumn([
                'image_selection_analyzed_by_model_id',
                'image_selection_analyzing_by_model_id',
                'image_selection_analyzing_started_at',
            ]);
        });
    }
};
