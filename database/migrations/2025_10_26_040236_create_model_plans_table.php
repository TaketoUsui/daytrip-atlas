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
        Schema::create('model_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId("cluster_id")
                ->constrained("clusters")
                ->cascadeOnDelete();
            $table->string("name");
            $table->text("description")
                ->nullable();
            $table->unsignedInteger("total_duration_minutes")->default(0);
            // クラスターの代表プランかどうか。
            // cluster_id ごとに1つだけ trueという制約を付けるのが好ましいが実装が複雑。
            $table->boolean("is_default")->default(false);
            $table->timestamp("created_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_plans');
    }
};
