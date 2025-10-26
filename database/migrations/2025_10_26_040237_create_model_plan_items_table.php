<?php

use App\Enums\TravelMode;
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
        Schema::create('model_plan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId("model_plan_id")
                ->constrained("model_plans")
                ->cascadeOnDelete();
            $table->unsignedInteger("display_order")->default(0);
            $table->foreignId("spot_id")
                ->constrained("spots")
                ->restrictOnDelete();
            $table->unsignedInteger("duration_minutes")->default(0);
            $table->unsignedInteger("travel_time_to_next_minutes")->default(0);
            $table->enum("travel_mode", TravelMode::options())->nullable();
            $table->text("description")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_plan_items');
    }
};
