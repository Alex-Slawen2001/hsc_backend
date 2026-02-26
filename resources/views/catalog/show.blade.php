@extends('layouts.app')

@section('title', 'Товар — ' . ($product->title ?? ''))

@push('styles')
    <link rel="stylesheet" href="/styles/css/product.css">
    <link rel="stylesheet" href="/styles/css/form.css">
@endpush

@section('content')
    @php
        // страховки, чтобы никогда не падало
        $product = $product ?? null;
        $specs   = $specs   ?? [];
        $compat  = $compat  ?? [];
        $docs    = $docs    ?? [];

        // галерея
        $gallery = [];
        if ($product) {
            $gallery = $product->gallery_images ?: [$product->image_path];
        }
    @endphp

    <div class="container">

        <div class="breadcrumbs">
            <a href="/">Главная</a> → <a href="/pages/catalog.html">Каталог</a> → <span>{{ $product?->title }}</span>
        </div>

        <div class="product-layout">
            <div class="gallery">
                <div class="gallery-main">
                    <img src="{{ $product?->image_path }}" alt="{{ $product?->title }}" id="mainProductImage">
                </div>

                <div class="gallery-thumbs">
                    @foreach($gallery as $i => $img)
                        <div class="thumb {{ $i===0 ? 'active' : '' }}" data-image="{{ $img }}">
                            <img src="{{ $img }}" alt="Вид {{ $i+1 }}">
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="product-info">
                <h1>{{ $product?->title }}</h1>

                @if(!empty($product?->sku))
                    <div class="sku">SKU: {{ $product->sku }}</div>
                @endif

                <div class="price">₽ {{ number_format((int)($product?->price_rub ?? 0), 0, '.', ' ') }}</div>

                @if(!empty($product?->availability))
                    <div class="stock">{{ $product->availability }}</div>
                @endif

                <div class="actions">

                    <form method="POST" action="/cart/add/{{ $product->id }}">
                        @csrf
                        <button class="btn-primary" type="submit">В корзину</button>
                    </form>

                    <a style="text-align: center;" class="btn-primary" href="/cart">
                        Корзина ({{ $cartCount ?? 0 }})
                    </a>

                    <button class="btn-primary js-open-consult">Запросить КП</button>

                </div>

                <div class="attributes">
                    @if(!empty($product?->category))
                        <div class="attr-row"><span>Категория</span><span>{{ $product->category }}</span></div>
                    @endif
                    @if(!empty($product?->model))
                        <div class="attr-row"><span>Модель</span><span>{{ $product->model }}</span></div>
                    @endif
                    <div class="attr-row"><span>Производитель</span><span>HSC</span></div>
                    <div class="attr-row"><span>Гарантия</span><span>12 месяцев</span></div>
                </div>
            </div>
        </div>

        <div class="tabs">
            <div class="tab-buttons">
                <div class="tab-btn active" onclick="openTab(0)">Описание</div>
                <div class="tab-btn" onclick="openTab(1)">Характеристики</div>
                <div class="tab-btn" onclick="openTab(2)">Совместимость</div>
                <div class="tab-btn" onclick="openTab(3)">Документы</div>
            </div>

            <div class="tab-content active">
                @foreach(preg_split("/\n\n+/", trim($product?->description ?? '')) as $p)
                    @if(trim($p) !== '')
                        <p>{{ $p }}</p>
                    @endif
                @endforeach
            </div>

            <div class="tab-content">
                <ul>
                    @foreach($specs as $row)
                        @php
                            $k = $row[0] ?? '';
                            $v = $row[1] ?? '';
                        @endphp
                        @if($k !== '')
                            <li><strong>{{ $k }}:</strong> {{ $v }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>

            <div class="tab-content">
                @if(count($compat))
                    <div class="compatibility-list">
                        @foreach($compat as $c)
                            <div class="compatibility-item">{{ $c }}</div>
                        @endforeach
                    </div>
                @else
                    <p>Совместимость уточняется.</p>
                @endif
            </div>

            <div class="tab-content">
                <ul>
                    @foreach($docs as $d)
                        <li>{{ $d }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="related-grid">
            <h2>Похожие товары</h2>
            <div style="margin-bottom: 15px;" class="related-items">
                @foreach(\App\Models\Product::query()->where('id','!=',$product?->id)->limit(3)->get() as $rel)
                    <a style="color: var(--text-main);text-decoration: none;" href="/products/{{ $rel->slug }}">
                        <div class="related-card">
                            <div class="related-image">
                                <img src="{{ $rel->image_path }}" alt="{{ $rel->title }}">
                            </div>
                            <div class="related-title">{{ $rel->title }}</div>
                            <div class="price">₽ {{ number_format((int)$rel->price_rub, 0, '.', ' ') }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        function openTab(index) {
            document.querySelectorAll('.tab-btn').forEach((btn,i)=>{
                btn.classList.toggle('active', i === index)
            })
            document.querySelectorAll('.tab-content').forEach((tab,i)=>{
                tab.classList.toggle('active', i === index)
            })
        }

        document.addEventListener('DOMContentLoaded', function() {
            const mainImage = document.getElementById('mainProductImage');
            document.querySelectorAll('.thumb').forEach(thumb => {
                thumb.addEventListener('click', () => {
                    document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
                    thumb.classList.add('active');
                    const img = thumb.getAttribute('data-image');
                    if (mainImage && img) mainImage.src = img;
                });
            });
        });
    </script>
@endpush
