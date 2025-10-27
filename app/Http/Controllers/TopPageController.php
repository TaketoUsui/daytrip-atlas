<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

/**
 * 【FUNC-001】トップページ表示
 */
class TopPageController extends Controller
{
    public function show(Request $request): InertiaResponse{
        $tags = Tag::query()
            ->select(["id", "name"])
            ->get();

        return Inertia::render("TopPage", [
            "tags" => $tags,
        ]);
    }
}
