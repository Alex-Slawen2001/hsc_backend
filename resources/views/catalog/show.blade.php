@extends('layouts.app')

@section('title', 'Товар — ' . ($product->title ?? ''))

@push('styles')
    <link rel="stylesheet" href="/styles/css/product.css">
    <link rel="stylesheet" href="/styles/css/form.css">
@endpush

@section('content')
    @php
        $product = $product ?? null;
        $specs   = $specs   ?? [];
        $compat  = $compat  ?? [];
        $docs    = $docs    ?? [];

        $gallery = [];
        if ($product) {
            $gallery = $product->gallery_images ?: [$product->image_path];
        }

        $descHtml = $product?->description_html;
        $descSafe = (is_string($descHtml) && $descHtml !== '')
            ? $descHtml
            : nl2br(e((string)($product?->description ?? '')));
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
                    <form method="POST" action="/cart/add/{{ $product->id }}" class="js-add-to-cart">
                        @csrf
                        <button class="btn-primary" type="submit">В корзину</button>
                    </form>

                    <a style="text-align:center;" class="btn-primary" href="/cart">
                        Корзина (<span id="cartCount">{{ $cartCount ?? 0 }}</span>)
                    </a>

                    <button class="btn-primary js-open-consult" type="button">Запросить КП</button>
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
                <div class="tab-btn active" data-tab="0">Описание</div>
                <div class="tab-btn" data-tab="1">Характеристики</div>
                <div class="tab-btn" data-tab="2">Совместимость</div>
                <div class="tab-btn" data-tab="3">Документы</div>
            </div>

            <div class="tab-content active">
                {!! $descSafe !!}
            </div>

            <div class="tab-content">
                @forelse($specs as $row)
                    <div class="spec-row">
                        <span>{{ (string)($row[0] ?? '') }}</span>
                        <span>{{ (string)($row[1] ?? '') }}</span>
                    </div>
                @empty
                    <div class="compat-item" style="opacity:.75;">Характеристики не указаны</div>
                @endforelse
            </div>

            <div class="tab-content">
                @forelse($compat as $c)
                    <div class="compat-item">{{ $c }}</div>
                @empty
                    <div class="compat-item" style="opacity:.75;">Совместимость не указана</div>
                @endforelse
            </div>

            <div class="tab-content">
                @forelse($docs as $d)
                    @php
                        $title = is_array($d) ? ($d['title'] ?? '') : (string)$d;
                        $url   = is_array($d) ? ($d['url'] ?? '#') : '#';
                    @endphp
                    <a class="doc-link" href="{{ $url }}" target="_blank" rel="noopener">{{ $title }}</a>
                @empty
                    <div class="compat-item" style="opacity:.75;">Документы не указаны</div>
                @endforelse
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Tabs
            const tabBtns = Array.from(document.querySelectorAll('.tab-btn'));
            const tabContents = Array.from(document.querySelectorAll('.tab-content'));

            function openTab(index){
                tabBtns.forEach((b,i)=> b.classList.toggle('active', i === index));
                tabContents.forEach((c,i)=> c.classList.toggle('active', i === index));
            }

            tabBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const idx = parseInt(btn.getAttribute('data-tab'), 10);
                    if (!Number.isNaN(idx)) openTab(idx);
                });
            });

            if (!tabBtns.some(b => b.classList.contains('active'))) openTab(0);

            // Gallery
            const mainImage = document.getElementById('mainProductImage');
            const thumbs = Array.from(document.querySelectorAll('.gallery-thumbs .thumb'));

            thumbs.forEach(t => {
                t.addEventListener('click', () => {
                    const img = t.getAttribute('data-image');
                    if (img && mainImage) mainImage.src = img;
                    thumbs.forEach(x => x.classList.remove('active'));
                    t.classList.add('active');
                });
            });

            // AJAX add-to-cart
            const form = document.querySelector('form.js-add-to-cart');
            const countEl = document.getElementById('cartCount');
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            if(form && countEl && csrf){
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const url = form.getAttribute('action');
                    const fd = new FormData(form);

                    try{
                        const res = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': csrf,
                                'Accept': 'application/json'
                            },
                            body: fd
                        });

                        if(!res.ok){
                            form.submit();
                            return;
                        }

                        const data = await res.json();
                        if(data && typeof data.cartCount !== 'undefined'){
                            countEl.textContent = data.cartCount;
                        }

                        const toast = document.createElement('div');
                        toast.textContent = data?.message || 'Добавлено в корзину';
                        toast.style.cssText =
                            'position:fixed;right:16px;bottom:16px;z-index:9999;padding:10px 12px;border-radius:14px;' +
                            'background:rgba(0,0,0,.78);border:1px solid rgba(255,255,255,.18);color:#fff;' +
                            'max-width:min(360px,calc(100% - 32px));font:500 14px/1.3 Inter,system-ui,Arial';
                        document.body.appendChild(toast);
                        setTimeout(()=>toast.remove(), 1800);

                    }catch(err){
                        form.submit();
                    }
                });
            }
        });
    </script>
@endpush
