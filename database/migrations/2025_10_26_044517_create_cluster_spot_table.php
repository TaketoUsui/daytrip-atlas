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
        Schema::create('cluster_spot', function (Blueprint $table) {
            $table->foreignId("cluster_id")
                ->constrained("clusters")
                ->cascadeOnDelete();
            $table->foreignId("spot_id")
                ->constrained("spots")
                ->cascadeOnDelete();
            $table->primary(["cluster_id", "spot_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cluster_spot');
    }
};
