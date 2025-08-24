<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Services\ArticleService;
use App\Services\NodeService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class ArticleController extends Controller
{
    public function index(NodeService $nodeService): View
    { // 帮助中心
        $user = auth()->user();

        return view('user.knowledge', [
            'subType' => $nodeService->getActiveNodeTypes(),
            'subUrl' => $user->sub_url,
            'subscribe' => $user->subscribe->only(['status', 'ban_desc']),
            'knowledge' => Article::type(1)->lang()->orderByDesc('sort')->latest()->get()->groupBy('category'),
        ]);
    }

    public function show(Article $article): JsonResponse
    { // 公告详情
        $content = cache()->remember("article.content.{$article->id}", 3600, function () use ($article) {
            return (new ArticleService($article))->getContent();
        });

        return response()->json(['title' => $article->title, 'content' => $content]);
    }
}
