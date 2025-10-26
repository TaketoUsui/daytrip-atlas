<?php

use App\Enums\ClusterStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clusters', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('name')->unique();
            $table->enum("status", ClusterStatus::options())
                ->default(ClusterStatus::Draft->value);
            $table->timestamps();
        });

        try {
            DB::statement("ALTER TABLE clusters ADD COLUMN location geography(Point, 4326)");
            DB::statement("CREATE INDEX clusters_location_gist ON clusters USING GIST (location)");
        }catch(\Illuminate\Database\QueryException $e){
            Log::error("PostGIS Error: Failed to create geography column or GiST index for clusters table. " . $e->getMessage());
            Schema::dropIfExists("clusters");
            throw $e;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clusters');
    }
};
