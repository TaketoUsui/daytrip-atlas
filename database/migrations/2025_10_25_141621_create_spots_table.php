<?php

use App\Enums\CoordinateReliability;
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
        Schema::create('spots', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('prefecture')->nullable()->index();
            $table->string('municipality')->nullable()->index();
            $table->string('address_detail')->nullable();
            $table->unsignedInteger('min_duration_minutes')->nullable();
            $table->unsignedInteger('max_duration_minutes')->nullable();

            // spot_roleはVARCHAR型で柔軟性を確保（ENUM型ではない）
            $table->string('spot_role')->nullable()
                ->comment('main_attraction, sub_attraction, dining, rest_area, shopping, scenic_spot など');

            // 分析優先度（1-3、3が最優先）
            $table->unsignedTinyInteger('analysis_priority')->nullable()
                ->comment('3: 隠れ観光スポット（最優先）、2: 定番観光スポット、1: 散歩スポット');

            $table->enum('coordinate_reliability', CoordinateReliability::options())->nullable()
                ->comment('manually_verified, open_data_sourced, ai_analysis');

            // AI分析関連カラム
            $table->unsignedBigInteger('detail_analyzed_by_model_id')->nullable();
            $table->unsignedBigInteger('detail_analyzing_by_model_id')->nullable();
            $table->timestamp('detail_analyzing_started_at')->nullable();

            $table->timestamps();

            // 外部キー制約（ai_modelsテーブルへの参照）
            $table->foreign('detail_analyzed_by_model_id')->references('id')->on('ai_models')->nullOnDelete();
            $table->foreign('detail_analyzing_by_model_id')->references('id')->on('ai_models')->nullOnDelete();

            // 分析優先度でのソートが頻繁に行われるためインデックスを追加
            $table->index('analysis_priority');
        });

        try {
            DB::statement('ALTER TABLE spots ADD COLUMN location geography(Point, 4326)');
            DB::statement('CREATE INDEX spots_location_gist ON spots USING GIST(location)');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('PostGIS Error: Failed to create geography column or GiST index for spots table. Is PostGIST enabled? '.$e->getMessage());
            Schema::dropIfExists('spots');
            throw $e;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spots');
    }
};
