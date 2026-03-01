@extends('layouts.app')
@section('title','Админ — Товары')

@push('styles')
    <style>
        /* ===== Admin Products ===== */
        .adm-wrap{ padding:24px 0; }

        /* mobile side padding (контент, не шапка/футер) */
        @media (max-width: 768px){
            .adm-wrap.container{
                padding-left:16px !important;
                padding-right:16px !important;
            }
        }

        .adm-head{
            display:flex;
            align-items:flex-end;
            justify-content:space-between;
            gap:12px;
            flex-wrap:wrap;
            margin-bottom:14px;
        }

        .adm-titlebox{ display:flex; flex-direction:column; gap:6px; }
        .adm-head h1{ margin:0; font-size:26px; letter-spacing:-.2px; }
        .adm-subtitle{ opacity:.72; font-size:13px; }

        .adm-toolbar{
            display:flex;
            gap:10px;
            flex-wrap:wrap;
            align-items:center;
            justify-content:flex-end;
        }

        .adm-search{
            min-width:240px;
            width:min(420px,100%);
            padding:11px 12px;
            border-radius:14px;
            border:1px solid rgba(255,255,255,.14);
            background: rgba(0,0,0,.25);
            color:inherit;
            outline:none;
        }
        .adm-search:focus{
            border-color: rgba(78,127,255,.55);
            box-shadow: 0 0 0 3px rgba(78,127,255,.14);
        }

        .adm-top-actions{
            display:flex;
            gap:10px;
            flex-wrap:wrap;
            align-items:center;
        }

        /* Info / success */
        .adm-flash{
            padding:10px 12px;
            border:1px solid rgba(46,204,113,.7);
            border-radius:12px;
            background: rgba(46,204,113,.06);
            margin-bottom:12px;
        }

        /* cards grid */
        .adm-grid{
            display:grid;
            grid-template-columns: repeat(12, 1fr);
            gap:14px;
        }

        /* 4 cards per row large */
        .adm-card{ grid-column: span 3; }

        @media (max-width: 1200px){
            .adm-card{ grid-column: span 4; } /* 3 per row */
        }
        @media (max-width: 980px){
            .adm-card{ grid-column: span 6; } /* 2 per row */
        }
        @media (max-width: 640px){
            .adm-card{ grid-column: span 12; } /* 1 per row */
        }

        .adm-card{
            border:1px solid rgba(255,255,255,.12);
            border-radius:18px;
            overflow:hidden;
            background: rgba(255,255,255,.03);
            display:flex;
            flex-direction:column;
            min-height:100%;
        }

        .adm-thumb-wrap{
            position:relative;
            width:100%;
            background: rgba(255,255,255,.06);
            aspect-ratio: 16 / 10;
            overflow:hidden;
        }

        .adm-thumb{
            width:100%;
            height:100%;
            object-fit:cover;
            display:block;
        }

        .adm-thumb-empty{
            height:100%;
            display:flex;
            align-items:center;
            justify-content:center;
            opacity:.65;
            font-size:13px;
        }

        .adm-body{
            padding:12px 12px 14px;
            display:flex;
            flex-direction:column;
            gap:10px;
            flex:1;
            min-width:0;
        }

        .adm-row-top{
            display:flex;
            gap:10px;
            align-items:flex-start;
            justify-content:space-between;
        }

        .adm-title{
            font-weight:800;
            line-height:1.2;
            min-width:0;
            overflow:hidden;
            text-overflow:ellipsis;
            display:-webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .adm-badges{
            display:flex;
            flex-wrap:wrap;
            gap:6px;
            justify-content:flex-end;
        }

        .adm-badge{
            font-size:12px;
            padding:6px 8px;
            border-radius:999px;
            border:1px solid rgba(255,255,255,.12);
            background: rgba(0,0,0,.18);
            opacity:.9;
            white-space:nowrap;
        }

        .adm-meta{
            opacity:.75;
            font-size:13px;
            display:flex;
            gap:10px;
            flex-wrap:wrap;
        }

        .adm-price{
            margin-top:auto;
            font-weight:900;
            font-size:16px;
        }

        .adm-actions{
            display:grid;
            grid-template-columns: 1fr 1fr;
            gap:8px;
            margin-top:10px;
        }

        .adm-actions .btn-outline,
        .adm-actions .btn-primary{
            width:100%;
            text-align:center;
            padding:10px 12px;
            border-radius:14px;
            line-height:1.1;
        }

        .adm-actions form{ margin:0; }
        .adm-actions form button{ width:100%; }

        /* 3rd row for "delete" for readability */
        .adm-actions .adm-open{ grid-column: span 2; }

        @media (max-width: 640px){
            .adm-head{
                align-items:stretch;
            }
            .adm-toolbar{
                justify-content:stretch;
                width:100%;
            }
            .adm-search{
                width:100%;
                min-width:0;
            }
            .adm-top-actions{
                width:100%;
            }
            .adm-top-actions .btn-primary{
                width:100%;
            }
            .adm-actions{
                grid-template-columns: 1fr;
            }
            .adm-actions .adm-open{
                grid-column: auto;
            }
        }

        /* pagination wrapper */
        .adm-pagination{
            margin-top:18px;
        }
    </style>
@endpush

@section('content')
    <div class="container adm-wrap">
        <div class="adm-head">
            <div class="adm-titlebox">
                <h1>Каталог (админ)</h1>
                <div class="adm-subtitle">Управление товарами: поиск, редактирование, удаление</div>
            </div>

            <div class="adm-toolbar">
                <input class="adm-search" id="admSearch" type="search" placeholder="Поиск по названию / SKU…">
                <div class="adm-top-actions">
                    <a class="btn-primary" href="/admin/products/create">+ Добавить</a>
                </div>
            </div>
        </div>

        @if(session('ok'))
            <div class="adm-flash">
                {{ session('ok') }}
            </div>
        @endif

        <div class="adm-grid" id="admGrid">
            @foreach($products as $p)
                <div class="adm-card"
                     data-title="{{ mb_strtolower($p->title ?? '') }}"
                     data-sku="{{ mb_strtolower($p->sku ?? '') }}">

                    <div class="adm-thumb-wrap">
                        @if($p->image_path)
                            <img class="adm-thumb" src="{{ $p->image_path }}" alt="{{ $p->title }}">
                        @else
                            <div class="adm-thumb-empty">Нет изображения</div>
                        @endif
                    </div>

                    <div class="adm-body">
                        <div class="adm-row-top">
                            <div class="adm-title">{{ $p->title }}</div>
                            <div class="adm-badges">
                                @if($p->sku)<span class="adm-badge">SKU: {{ $p->sku }}</span>@endif
                                @if($p->category)<span class="adm-badge">{{ $p->category }}</span>@endif
                            </div>
                        </div>

                        <div class="adm-meta">
                            @if(!empty($p->model))<span>Модель: {{ $p->model }}</span>@endif
                            <span>ID: {{ $p->id }}</span>
                        </div>

                        <div class="adm-price">₽ {{ number_format((int)$p->price_rub, 0, '.', ' ') }}</div>

                        <div class="adm-actions">
                            <a class="btn-outline adm-open" href="/products/{{ $p->slug }}" target="_blank" rel="noopener">Открыть товар</a>
                            <a class="btn-outline" href="/admin/products/{{ $p->id }}/edit">Редактировать</a>

                            <form method="POST" action="/admin/products/{{ $p->id }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn-outline" type="submit" onclick="return confirm('Удалить товар?')">
                                    Удалить
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="adm-pagination">
            {{ $products->links() }}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function(){
            const input = document.getElementById('admSearch');
            const grid = document.getElementById('admGrid');
            if(!input || !grid) return;

            const cards = Array.from(grid.querySelectorAll('.adm-card'));
            const norm = (s) => (s || '').toString().toLowerCase().trim();

            function applyFilter(){
                const q = norm(input.value);
                cards.forEach(card => {
                    if(!q){ card.style.display=''; return; }
                    const t = norm(card.getAttribute('data-title'));
                    const s = norm(card.getAttribute('data-sku'));
                    card.style.display = (t.includes(q) || s.includes(q)) ? '' : 'none';
                });
            }

            input.addEventListener('input', applyFilter);
        })();
    </script>
@endpush
