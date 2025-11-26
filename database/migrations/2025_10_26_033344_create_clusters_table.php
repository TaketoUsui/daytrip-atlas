<?php

use App\Enums\ClusterStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clusters', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('name')->unique();
            $table->enum('status', ClusterStatus::options())
                ->default(ClusterStatus::Draft->value);
            $table->unsignedInteger('tourism_value')->default(10)->comment('観光地域としての価値（重みづけ用）');

            // AI分析関連カラム
            $table->unsignedInteger('analyzed_spots_count')->default(0)
                ->comment('詳細分析が完了したスポット数（キャッチフレーズ生成の開始条件）');

            // スポットリストアップ分析
            $table->unsignedBigInteger('spot_listing_analyzed_by_model_id')->nullable();
            $table->unsignedBigInteger('spot_listing_analyzing_by_model_id')->nullable();
            $table->timestamp('spot_listing_analyzing_started_at')->nullable();

            // スポット分析優先度確定
            $table->unsignedBigInteger('spot_priority_analyzed_by_model_id')->nullable();
            $table->unsignedBigInteger('spot_priority_analyzing_by_model_id')->nullable();
            $table->timestamp('spot_priority_analyzing_started_at')->nullable();

            // メインスポット選定
            $table->unsignedBigInteger('main_spot_analyzed_by_model_id')->nullable();
            $table->unsignedBigInteger('main_spot_analyzing_by_model_id')->nullable();
            $table->timestamp('main_spot_analyzing_started_at')->nullable();

            // 画像選定
            $table->unsignedBigInteger('image_analyzed_by_model_id')->nullable();
            $table->unsignedBigInteger('image_analyzing_by_model_id')->nullable();
            $table->timestamp('image_analyzing_started_at')->nullable();

            $table->timestamps();

            // 外部キー制約（ai_modelsテーブルへの参照）
            $table->foreign('spot_listing_analyzed_by_model_id')->references('id')->on('ai_models')->nullOnDelete();
            $table->foreign('spot_listing_analyzing_by_model_id')->references('id')->on('ai_models')->nullOnDelete();
            $table->foreign('spot_priority_analyzed_by_model_id')->references('id')->on('ai_models')->nullOnDelete();
            $table->foreign('spot_priority_analyzing_by_model_id')->references('id')->on('ai_models')->nullOnDelete();
            $table->foreign('main_spot_analyzed_by_model_id')->references('id')->on('ai_models')->nullOnDelete();
            $table->foreign('main_spot_analyzing_by_model_id')->references('id')->on('ai_models')->nullOnDelete();
            $table->foreign('image_analyzed_by_model_id')->references('id')->on('ai_models')->nullOnDelete();
            $table->foreign('image_analyzing_by_model_id')->references('id')->on('ai_models')->nullOnDelete();
        });

        try {
            DB::statement('ALTER TABLE clusters ADD COLUMN location geography(Point, 4326)');
            DB::statement('CREATE INDEX clusters_location_gist ON clusters USING GIST (location)');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('PostGIS Error: Failed to create geography column or GiST index for clusters table. '.$e->getMessage());
            Schema::dropIfExists('clusters');
            throw $e;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clusters');
    }
};
