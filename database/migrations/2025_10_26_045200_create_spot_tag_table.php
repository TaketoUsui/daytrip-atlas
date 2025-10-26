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
        Schema::create('spot_tag', function (Blueprint $table) {
            $table->foreignId("spot_id")
                ->constrained("spots")
                ->cascadeOnDelete();
            $table->foreignId("tag_id")
                ->constrained("tags")
                ->cascadeOnDelete();
            $table->primary(["spot_id", "tag_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spot_tag');
    }
};
