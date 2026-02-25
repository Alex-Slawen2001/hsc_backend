<?php

namespace App\Http\Controllers;

use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $items = News::query()->orderByDesc('published_at')->paginate(9);
        return view('news.index', compact('items'));
    }

    public function show(string $slug)
    {
        $item = News::query()->where('slug', $slug)->firstOrFail();
        return view('news.show', compact('item'));
    }
}
