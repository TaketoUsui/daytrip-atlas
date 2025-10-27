<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSuggestionRequest;
use App\Services\SuggestionService;
use Illuminate\Http\RedirectResponse;

class SuggestionController extends Controller
{
    public function __construct(
        protected SuggestionService $suggestionService,
    ){}

    /**
     * 提案内容の分析を開始するエンドポイント
     *
     * @param StoreSuggestionRequest $request
     * @return RedirectResponse
     */
    public function startAnalyze(StoreSuggestionRequest $request){
        $suggestionSet = $this->suggestionService->createAndDispatch(
            $request->validated(),
            $request->session()->getId(),
        );

        return redirect()->route("suggestions.wait", [
            "suggestion_set" => $suggestionSet->uuid,
        ]);
    }
}
