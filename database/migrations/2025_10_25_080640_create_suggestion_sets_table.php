<?php

use App\Enums\SuggestionStatus;
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
        Schema::create('suggestion_sets', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('session_id')->index();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->enum('status', SuggestionStatus::options())
                ->default(SuggestionStatus::Pending->value);
            $table->double('input_latitude');
            $table->double('input_longitude');
            $table->jsonb('input_tags_json')
                ->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggestion_sets');
    }
};
