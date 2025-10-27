<?php

namespace App\Jobs;

use App\Enums\SuggestionStatus;
use App\Models\SuggestionSet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateSuggestionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public SuggestionSet $suggestionSet,
    ){}

    public function handle(): void{
        try {
            //
            $this->suggestionSet->update(["status" => SuggestionStatus::ProcessingClusters]);

            // --- ここから FUNC-007 提案ロジック（簡易版） ---
            //
            // 例:
            // 1. $this->suggestionSet->input_latitude / longitude を使って空間クエリ実行
            // 2. $this->suggestionSet->input_tags_json を使ってクラスターを選定
            //

            sleep(10); // TODO: 開発用. 実際のロジックに置き換える

            $this->suggestionSet->update(["status" => SuggestionStatus::AnalyzingItems]);
            // 3. 提案アイテム(suggestion_set_items)を作成・保存する

            sleep(10); // TODO: 開発用. 実際のロジックに置き換える

            // 4. 完了ステータスに更新
            $this->suggestionSet->update(["status" => SuggestionStatus::Complete]);
        }catch (\Throwable $exception){
            Log::error("Suggestion generation failed", [
                "suggestion_set_id" => $this->suggestionSet->id,
                "error" => $exception->getMessage(),
            ]);
            $this->suggestionSet->update(["status" => SuggestionStatus::Failed]);
        }
    }
}
