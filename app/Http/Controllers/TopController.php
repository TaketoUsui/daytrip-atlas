<?php

namespace App\Http\Controllers;

use App\Data\InputTagsData;
use App\Enums\SuggestionStatus;
use App\Jobs\GenerateSuggestionsJob;
use App\Models\SuggestionSet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class TopController extends Controller
{
    /**
     * トップページ表示（出発地入力画面）
     */
    public function index(): Response
    {
        return Inertia::render('Top/Index');
    }

    /**
     * 提案リクエスト作成
     *
     * 出発地（緯度経度）を受け取り、SuggestionSetを作成してジョブをディスパッチ
     */
    public function store(Request $request): RedirectResponse
    {
        // バリデーション
        $validated = $request->validate([
            'input_latitude' => 'required|numeric|between:-90,90',
            'input_longitude' => 'required|numeric|between:-180,180',
            'input_tags' => 'nullable|array',
            'input_tags.*' => 'string',
        ]);

        // セッションIDの取得または生成
        $sessionId = $request->session()->getId();
        if (!$sessionId) {
            $sessionId = Str::uuid()->toString();
            $request->session()->setId($sessionId);
            $request->session()->start();
        }

        // SuggestionSet作成
        $suggestionSet = SuggestionSet::create([
            'session_id' => $sessionId,
            'user_id' => auth()->id(), // 認証済みの場合はuser_idを設定（MVPでは未認証想定）
            'status' => SuggestionStatus::Pending,
            'input_latitude' => $validated['input_latitude'],
            'input_longitude' => $validated['input_longitude'],
            'input_tags_json' => isset($validated['input_tags'])
                ? InputTagsData::fromArray($validated['input_tags'])
                : null,
        ]);

        // 非同期ジョブのディスパッチ
        GenerateSuggestionsJob::dispatch($suggestionSet);

        // 提案待機・結果一覧ページにリダイレクト
        return redirect()->route('suggestions.show', ['suggestionSet' => $suggestionSet->uuid]);
    }
}
