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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('file_name');
            $table->string('storage_path')->unique();
            $table->string('category')->nullable()->comment('画像のカテゴリ（神社、寺、城、自然景観など）');
            $table->string('alt_text')->nullable();
            $table->string('copyright_holder')->nullable();
            $table->text('description')->nullable();
            $table->enum('image_quality_level', \App\Enums\ImageQualityLevel::options());
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
