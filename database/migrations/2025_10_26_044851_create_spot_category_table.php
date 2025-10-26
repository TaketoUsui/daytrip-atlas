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
        Schema::create('spot_category', function (Blueprint $table) {
            $table->foreignId("spot_id")
                ->constrained("spots")
                ->cascadeOnDelete();
            $table->foreignId("category_id")
                ->constrained("categories")
                ->cascadeOnDelete();
            $table->primary(["spot_id", "category_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spot_category');
    }
};
