@extends('layouts.app')

@section('title', $item->title)

@push('styles')
    <link rel="stylesheet" href="/styles/css/news_detail.css">
@endpush

@section('content')
<div class="container">

    <div class="breadcrumbs" style="margin-top:20px;">
        <a href="/">Главная</a> →
        <a href="/pages/news.html">Новости</a> → Детальная новость
    </div>

    <div class="page-grid">

        <article style='margin-bottom: 15px;' class="article-card" itemscope itemtype="https://schema.org/NewsArticle">

            <h1 class="article-title" itemprop="headline">{{ $item->title }}</h1>

            <div class="article-meta" itemprop="datePublished">
                {{ $item->published_at->format('d F Y') }}
            </div>

            @if($item->image_path)
                <div class="article-image article-image--compact">
                    <img src="{{ $item->image_path }}" itemprop="image" alt="">
                </div>
            @endif

            <div class="article-content" itemprop="articleBody">
                {!! $item->content !!}
            </div>

            <a href="/pages/news.html" class="back-link">← Вернуться ко всем новостям</a>

        </article>

        <aside style="margin-bottom:10px;" class="sidebar">

            <div class="sidebar-block">
                <div class="sidebar-title">Другие новости</div>

                @foreach(\App\Models\News::query()->where('id','!=',$item->id)->orderByDesc('published_at')->limit(3)->get() as $n)
                    <div class="sidebar-news-item">
                        <div class="sidebar-date">{{ $n->published_at->format('d.m.Y') }}</div>
                        <a href="/news/{{ $n->slug }}" class="sidebar-link">{{ $n->title }}</a>
                    </div>
                @endforeach

                <a href="/pages/news.html" class="back-link">Все новости →</a>
            </div>

        </aside>

    </div>
</div>
@endsection
