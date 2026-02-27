@extends('layouts.app')
@section('title','Админ — Товары')

@push('styles')
    <style>
        .adm-wrap{ padding:24px 0; }
        .adm-head{ display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; margin-bottom:14px; }
        .adm-head h1{ margin:0; }
        .adm-toolbar{ display:flex; gap:10px; flex-wrap:wrap; align-items:center; }

        .adm-search{
            min-width:240px; width:min(420px,100%);
            padding:10px 12px; border-radius:14px;
            border:1px solid rgba(255,255,255,.14);
            background: rgba(0,0,0,.25);
            color:inherit;
        }

        .adm-grid{ display:grid; grid-template-columns:repeat(3,1fr); gap:14px; }
        @media (max-width: 980px){ .adm-grid{ grid-template-columns:repeat(2,1fr);} }
        @media (max-width: 640px){ .adm-grid{ grid-template-columns:1fr;} }

        .adm-card{
            border:1px solid rgba(255,255,255,.12);
            border-radius:18px; overflow:hidden;
            background: rgba(0,0,0,.18);
            display:flex; flex-direction:column;
            min-height:100%;
        }
        .adm-thumb{ width:100%; height:180px; object-fit:cover; background: rgba(255,255,255,.06); }
        .adm-body{ padding:12px 12px 14px; display:flex; flex-direction:column; gap:10px; flex:1; }
        .adm-title{ font-weight:800; line-height:1.2; }
        .adm-meta{ opacity:.75; font-size:13px; display:flex; gap:10px; flex-wrap:wrap; }
        .adm-price{ font-weight:900; }

        .adm-actions{ display:flex; gap:8px; flex-wrap:wrap; margin-top:auto; }
        .adm-actions a, .adm-actions button{ flex:1; min-width:140px; }
        @media (max-width: 640px){
            .adm-actions a, .adm-actions button{ min-width:0; width:100%; }
        }
    </style>
@endpush

@section('content')
    <div class="container adm-wrap">
        <div class="adm-head">
            <h1>Каталог (админ)</h1>

            <div class="adm-toolbar">
                <input class="adm-search" id="admSearch" type="search" placeholder="Поиск по названию / SKU…">
                <a class="btn-primary" href="/admin/products/create">+ Добавить</a>
            </div>
        </div>

        @if(session('ok'))
            <div style="padding:10px 12px;border:1px solid #2ecc71;border-radius:12px;margin-bottom:12px;">
                {{ session('ok') }}
            </div>
        @endif

        <div class="adm-grid" id="admGrid">
            @foreach($products as $p)
                <div class="adm-card" data-title="{{ mb_strtolower($p->title ?? '') }}" data-sku="{{ mb_strtolower($p->sku ?? '') }}">
                    @if($p->image_path)
                        <img class="adm-thumb" src="{{ $p->image_path }}" alt="{{ $p->title }}">
                    @else
                        <div class="adm-thumb" style="display:flex;align-items:center;justify-content:center;opacity:.6;">Нет изображения</div>
                    @endif

                    <div class="adm-body">
                        <div class="adm-title">{{ $p->title }}</div>

                        <div class="adm-meta">
                            @if($p->sku)<span>SKU: {{ $p->sku }}</span>@endif
                            @if($p->category)<span>Категория: {{ $p->category }}</span>@endif
                        </div>

                        <div class="adm-price">₽ {{ number_format((int)$p->price_rub, 0, '.', ' ') }}</div>

                        <div class="adm-actions">
                            <a class="btn-outline" href="/products/{{ $p->slug }}" target="_blank" rel="noopener">Открыть</a>
                            <a class="btn-outline" href="/admin/products/{{ $p->id }}/edit">Редактировать</a>

                            <form method="POST" action="/admin/products/{{ $p->id }}" style="margin:0;flex:1;">
                                @csrf
                                @method('DELETE')
                                <button class="btn-outline" type="submit" onclick="return confirm('Удалить товар?')">Удалить</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top:18px;">
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
