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
        Schema::create('spot_images', function (Blueprint $table) {
            $table->foreignId("spot_id")
                ->constrained("spots")
                ->cascadeOnDelete();
            $table->foreignId("image_id")
                ->constrained("images")
                ->cascadeOnDelete();
            $table->unsignedInteger("display_order");
            $table->primary(["spot_id", "image_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spot_images');
    }
};
