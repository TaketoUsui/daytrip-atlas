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
            $table->string("file_name");
            $table->string("storage_path")->unique();
            $table->string("alt_text")->nullable();
            $table->string("copyright_holder")->nullable();
            $table->enum("image_quality_level", \App\Enums\ImageQualityLevel::options());
            $table->timestamp("created_at")->nullable();
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
