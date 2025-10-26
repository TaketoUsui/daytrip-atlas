<?php

use App\Enums\UserSpotInterestStatus;
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
        Schema::create('user_spot_interests', function (Blueprint $table) {
            $table->foreignId("user_id")
                ->constrained("users")
                ->cascadeOnDelete();
            $table->foreignId("spot_id")
                ->constrained("spots")
                ->cascadeOnDelete();
            $table->enum("status", UserSpotInterestStatus::options());
            $table->timestamp("created_at");
            $table->primary(["user_id", "spot_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_spot_interests');
    }
};
