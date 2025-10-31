<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class TopPageController extends Controller
{
    /**
     * No.1 トップページ表示
     * ユーザーの現在地入力と興味のあるタグ選択を受け付ける
     *
     * @param Request $request
     * @return InertiaResponse
     */
    public function show(Request $request): InertiaResponse
    {
        $tags = Tag::query()
            ->select(['id', 'name'])
            ->orderBy('id', 'asc')
            ->limit(10)
            ->get();

        return Inertia::render('TopPage', [
            'tags' => $tags,
        ]);
    }
}
