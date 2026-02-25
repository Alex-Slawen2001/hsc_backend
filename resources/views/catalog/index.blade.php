@extends('layouts.app')

@section('title', 'Каталог')

@push('styles')
    <link rel="stylesheet" href="/styles/css/form.css">
    <link rel="stylesheet" href="/styles/css/catalog.css">
@endpush

@section('content')
<div class="container">

    <div class="page-header">
        <div class="breadcrumbs">
            <a href="/">Главная</a><span class="crumb-sep">→</span>
            <a href="/pages/catalog.html">Каталог</a><span class="crumb-sep">→</span>
            <span>Запчасти</span>
        </div>
        <h1>Каталог запчастей для вертолётов</h1>
    </div>

    <div class="catalog-layout">

        <aside class="filters">
            <h3>Фильтры</h3>

            <div class="filter-group">
                <label>Модель вертолёта</label>
                <select>
                    <option>Все модели</option>
                    <option>Mi-8</option>
                    <option>Mi-17</option>
                    <option>Mi-26</option>
                    <option>Ka-32</option>
                    <option>Ansat</option>
                    <option>Универсальный</option>
                </select>
            </div>

            <div class="filter-group">
                <label>Категория</label>
                <select>
                    <option>Все категории</option>
                    <option>Трансмиссия</option>
                    <option>Лопасти</option>
                    <option>Авионика</option>
                    <option>Гидравлика</option>
                </select>
            </div>

            <div class="filter-group">
                <label>Номер детали (SKU)</label>
                <input type="text" placeholder="Введите артикул">
            </div>

            <div class="filter-group">
                <label>Цена до</label>
                <input type="number" placeholder="₽">
            </div>
        </aside>

        <section>
            <div class="catalog-toolbar">
                <div>Найдено: <strong>{{ $products->total() }}</strong></div>
                <div class="sort">
                    <select>
                        <option>По умолчанию</option>
                        <option>Цена ↑</option>
                        <option>Цена ↓</option>
                        <option>По популярности</option>
                    </select>
                </div>
            </div>

            <div class="catalog-grid">
                @foreach($products as $product)
                    <article class="product-card">
                        <div class="product-image">
                            <img class="img_product" src="{{ $product->image_path }}" alt="{{ $product->title }}">
                        </div>
                        <div class="product-body">
                            <div class="product-title">{{ $product->title }}</div>
                            @if($product->sku)
                                <div class="product-sku">SKU: {{ $product->sku }}</div>
                            @endif
                            <div class="product-attrs">
                                @if($product->model)
                                    Модель: {{ $product->model }}<br>
                                @endif
                                @if($product->category)
                                    Категория: {{ $product->category }}<br>
                                @endif
                                @if($product->availability)
                                    Наличие: {{ $product->availability }}
                                @endif
                            </div>
                            <div class="product-price">₽ {{ number_format($product->price_rub, 0, '.', ' ') }}</div>
                            <a class="btn-primary" style="text-decoration:none;color:white;text-align:center" href="/products/{{ $product->slug }}">Посмотреть</a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="pagination">
                {{-- Оставляем визуально как в исходнике; реальные ссылки Laravel-пагинации ниже --}}
                {!! $products->onEachSide(1)->links() !!}
            </div>
        </section>

    </div>
</div>
@endsection

@push('scripts')
    <script src="/styles/js/filter.js"></script>
@endpush
