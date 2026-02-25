@extends('layouts.app')

@section('title', 'Новости')

@push('styles')
    <link rel="stylesheet" href="/styles/css/news_detail.css">
@endpush

@section('content')
<div class="container">

    <div class="page-header">
        <div class="breadcrumbs">
            <a href="/">Главная</a><span class="crumb-sep">→</span>
            <span>Новости</span>
        </div>
        <h1>Новости</h1>
    </div>

    <div class="year-filter">
        <a class="active">Все новости</a>
        <a>2026</a>
        <a>2025</a>
        <a>2024</a>
        <a>2023</a>
        <a>2022</a>
        <a>2021</a>
        <a>2020</a>
    </div>

    <div class="news-grid">
        @foreach($items as $n)
            <article class="news-card" itemscope itemtype="http://schema.org/NewsArticle">
                <div class="news-image">
                    <img src="{{ $n->image_path }}" style="width:100%;height:100%;object-fit:cover" itemprop="image" alt="{{ $n->title }}">
                </div>
                <div class="news-body">
                    <div class="news-date" itemprop="datePublished">{{ $n->published_at->format('Y-m-d') }}</div>
                    <div class="news-title" itemprop="headline">{{ $n->title }}</div>
                    <div class="news-desc" itemprop="description">{{ $n->excerpt }}</div>
                    <a href="/news/{{ $n->slug }}" class="news-link">Читать далее →</a>
                </div>
            </article>
        @endforeach
    </div>

    <div style="margin-bottom:15px;" class="pagination">
        {!! $items->onEachSide(1)->links() !!}
    </div>

</div>
@endsection

@push('scripts')
    <script src="/styles/js/news.js"></script>
@endpush
