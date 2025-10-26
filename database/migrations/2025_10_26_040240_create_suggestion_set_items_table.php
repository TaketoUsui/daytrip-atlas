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
        Schema::create('suggestion_set_items', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId("suggestion_set_id")
                ->constrained("suggestion_sets")
                ->cascadeOnDelete();
            $table->foreignId("cluster_id")
                ->constrained("clusters")
                ->restrictOnDelete();
            $table->foreignId("key_visual_image_id")
                ->constrained("images")
                ->restrictOnDelete();
            $table->foreignId("catchphrase_id")
                ->constrained("catchphrases")
                ->restrictOnDelete();
            $table->foreignId("model_plan_id")
                ->constrained("model_plans")
                ->restrictOnDelete();
            $table->unsignedInteger("display_order")->default(0);
            $table->string("generated_travel_time_text")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggestion_set_items');
    }
};
