<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: UUID カラムを nullable で追加
        Schema::table('suggestion_set_model_plans', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('model_plan_id');
        });

        // Step 2: 既存レコードに UUID を生成して設定
        DB::table('suggestion_set_model_plans')->get()->each(function ($record) {
            DB::table('suggestion_set_model_plans')
                ->where('suggestion_set_id', $record->suggestion_set_id)
                ->where('model_plan_id', $record->model_plan_id)
                ->update(['uuid' => (string) Str::uuid()]);
        });

        // Step 3: UUID カラムに NOT NULL 制約と UNIQUE 制約を追加
        Schema::table('suggestion_set_model_plans', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suggestion_set_model_plans', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
