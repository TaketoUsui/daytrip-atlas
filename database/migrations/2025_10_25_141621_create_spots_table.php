<?php

use App\Enums\SpotRole;
use App\Enums\CoordinateReliability;
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
        Schema::create('spots', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string("slug")->unique();
            $table->string("prefecture")->nullable()->index();
            $table->string("municipality")->nullable()->index();
            $table->string("address_detail")->nullable();
            $table->unsignedInteger("min_duration_minutes")->default(0);
            $table->unsignedInteger("max_duration_minutes")->default(0);
            $table->enum("spot_role", SpotRole::options());
            $table->enum("coordinate_reliability", CoordinateReliability::options());
            $table->timestamps();
        });

        try {
            DB::statement("ALTER TABLE spots ADD COLUMN location geography(Point, 4326)");
            DB::statement("CREATE INDEX spots_location_gist ON spots USING GIST(location)");
        }catch (\Illuminate\Database\QueryException $e){
            Log::error("PostGIS Error: Failed to create geography column or GiST index for spots table. Is PostGIST enabled? " . $e->getMessage());
            Schema::dropIfExists("spots");
            throw $e;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spots');
    }
};
