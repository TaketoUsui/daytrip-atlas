<?php

namespace App\Http\Resources;

use App\Enums\SuggestionStatus;
use App\Models\SuggestionSet;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin SuggestionSet
 */
class SuggestionStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // 変更点③ (2.1)
        // 'processing_details' カラム（JSON）から動的メッセージを取得する
        $dynamicMessage = $this->processing_details['message'] ?? null;

        // $this->status は SuggestionStatus Enum
        $statusEnum = $this->status;

        // 動的メッセージが存在しない場合（または完了/失敗時）は、
        // Enum のデフォルトメッセージ をフォールバックとして使用する
        $message = $dynamicMessage ?? $statusEnum->getMessage();

        return [
            'status' => $statusEnum->value, // "pending", "processing_clusters" など
            'message' => $message,          // 動的メッセージ (またはフォールバック)

            // found_clusters: ステータスが "analyzing_items" 以降の場合に
            // ロード済みの items.cluster からクラスター情報を返却する
            'found_clusters' => $this->when(
                $statusEnum !== SuggestionStatus::Pending && $this->relationLoaded('items'),
                fn () => $this->items->map(fn ($item) => [
                    'id' => $item->cluster->id,
                    'name' => $item->cluster->name,
                ])
            ),

            // デバッグやフロントエンドでの高度な分岐用に、生の processing_details も渡す
            'processing_details' => $this->processing_details ?? null,
        ];
    }
}
