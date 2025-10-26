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
        Schema::create('catchphrases', function (Blueprint $table) {
            $table->id();
            $table->text("content");
            $table->jsonb("source_analysis")->nullable(); // 生成根拠 (例: {'source_tags': [1, 5]})
            $table->integer("performance_score")->nullable()->default(0)->index();
            $table->timestamp("created_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catchphrases');
    }
};
