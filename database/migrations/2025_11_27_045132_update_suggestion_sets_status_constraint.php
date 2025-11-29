<?php

use App\Enums\SuggestionStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 既存のCHECK制約を削除
        DB::statement('ALTER TABLE suggestion_sets DROP CONSTRAINT IF EXISTS suggestion_sets_status_check');

        // 新しいCHECK制約を作成
        $statusValues = collect(SuggestionStatus::cases())
            ->map(fn ($case) => "'{$case->value}'")
            ->join(', ');

        DB::statement("ALTER TABLE suggestion_sets ADD CONSTRAINT suggestion_sets_status_check CHECK (status IN ($statusValues))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // ロールバック時は元のCHECK制約に戻す
        DB::statement('ALTER TABLE suggestion_sets DROP CONSTRAINT IF EXISTS suggestion_sets_status_check');

        $oldStatusValues = "'pending', 'processing_clusters', 'listing_spots', 'analyzing_spots', 'generating_content', 'evaluating_clusters', 'complete', 'failed'";
        DB::statement("ALTER TABLE suggestion_sets ADD CONSTRAINT suggestion_sets_status_check CHECK (status::text = ANY (ARRAY[$oldStatusValues]::text[]))");
    }
};
