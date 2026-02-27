@extends('layouts.app')

@section('title','Корзина')

@push('styles')
    <style>
        .cart-wrap{ padding:24px 0; }
        .cart-list{ display:grid; gap:10px; }

        .cart-item{
            display:flex; gap:12px; align-items:center;
            border:1px solid rgba(255,255,255,0.10);
            background: rgba(255,255,255,0.03);
            padding:10px; border-radius:16px;
        }

        .cart-img{
            width:64px; height:64px; object-fit:cover;
            border-radius:14px; flex:0 0 64px;
            background: rgba(255,255,255,.06);
        }

        .cart-main{ display:flex; flex-direction:column; gap:4px; min-width:0; flex:1; }
        .cart-title{ font-weight:800; line-height:1.2; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .cart-meta{ opacity:.72; font-size:12.5px; display:flex; gap:10px; flex-wrap:wrap; }

        .cart-actions{ display:flex; gap:10px; align-items:center; flex-wrap:wrap; justify-content:flex-end; }
        .cart-sum{ font-weight:900; min-width:120px; text-align:right; }

        .qty{ display:flex; align-items:center; gap:6px; padding:6px; border-radius:14px;
            border:1px solid rgba(255,255,255,0.12); background: rgba(0,0,0,0.20); }
        .qty-btn{
            width:34px; height:34px; border-radius:12px;
            border:1px solid rgba(255,255,255,0.16);
            background: rgba(255,255,255,0.04);
            color:inherit; cursor:pointer;
        }
        .qty input{
            width:62px; text-align:center; padding:8px 8px;
            border-radius:12px; border:1px solid rgba(255,255,255,0.12);
            background: rgba(0,0,0,0.12); color:inherit;
        }

        .btn-mini{ padding:10px 12px; border-radius:14px; line-height:1; }

        .cart-footer{
            margin-top:14px;
            display:flex; justify-content:space-between; align-items:center;
            gap:12px; flex-wrap:wrap;
        }
        .cart-total{ font-size:18px; font-weight:900; }
        .cart-footer-actions{ display:flex; gap:10px; flex-wrap:wrap; align-items:center; }

        @media (max-width: 768px){
            .cart-item{ align-items:flex-start; flex-direction:column; }
            .cart-img{ width:100%; height:180px; flex:0 0 auto; }
            .cart-actions{ justify-content:space-between; width:100%; }
            .cart-sum{ min-width:0; text-align:left; }
            .cart-footer{ flex-direction:column; align-items:stretch; }
            .cart-footer-actions{ width:100%; }
            .cart-footer-actions .btn-primary,
            .cart-footer-actions .btn-outline{ width:100%; }
        }
    </style>
@endpush

@section('content')
    <div class="container cart-wrap">
        <h1 style="margin-bottom:16px;">Корзина</h1>

        @if(session('ok'))
            <div style="padding:10px 12px;border:1px solid #2ecc71;margin-bottom:12px;border-radius:12px;">
                {{ session('ok') }}
            </div>
        @endif

        @if(!count($lines))
            <p>Корзина пуста.</p>
            <a class="btn-primary" href="/pages/catalog.html" style="display:inline-block;margin-top:12px;">В каталог</a>
        @else
            {{-- форма обновления количества (единая) --}}
            <form id="cartUpdateForm" method="POST" action="/cart/update" style="display:none;">
                @csrf
            </form>

            <div class="cart-list">
                @foreach($lines as $line)
                    @php($p = $line['product'])

                    <div class="cart-item">
                        <img class="cart-img" src="{{ $p->image_path }}" alt="{{ $p->title }}">

                        <div class="cart-main">
                            <div class="cart-title">
                                <a href="/products/{{ $p->slug }}" style="color:inherit;text-decoration:none;">
                                    {{ $p->title }}
                                </a>
                            </div>
                            <div class="cart-meta">
                                @if($p->sku)<span>SKU: {{ $p->sku }}</span>@endif
                                <span>Цена: ₽ {{ number_format($line['price'], 0, '.', ' ') }}</span>
                            </div>
                        </div>

                        <div class="cart-actions">
                            <div class="cart-sum">₽ {{ number_format($line['sum'], 0, '.', ' ') }}</div>

                            <div class="qty" data-qty>
                                <button class="qty-btn" type="button" data-qty-minus>−</button>
                                <input form="cartUpdateForm" type="number" min="0" name="items[{{ $p->id }}]" value="{{ $line['qty'] }}" data-qty-input>
                                <button class="qty-btn" type="button" data-qty-plus>+</button>
                            </div>

                            {{-- обновить (общая форма) --}}
                            <button class="btn-outline btn-mini" form="cartUpdateForm" type="submit" title="Обновить">⟳</button>

                            <form method="POST" action="/cart/remove/{{ $p->id }}" style="margin:0;">
                                @csrf
                                <button class="btn-outline btn-mini" type="submit" title="Удалить" onclick="return confirm('Удалить товар?')">✕</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="cart-footer">
                <div class="cart-total">Итого: ₽ {{ number_format($total, 0, '.', ' ') }}</div>

                <div class="cart-footer-actions">
                    <button form="cartUpdateForm" type="submit" class="btn-primary">Обновить</button>

                    <form method="POST" action="/cart/clear" style="margin:0;">
                        @csrf
                        <button type="submit" class="btn-outline">Очистить</button>
                    </form>
                </div>
            </div>

            {{-- оформление заказа --}}
            <div style="margin-top:18px; padding:16px; border:1px solid rgba(255,255,255,.12); border-radius:16px; background: rgba(0,0,0,.2);">
                <h2 style="margin:0 0 10px; font-size:18px;">Оформление заказа</h2>
                <p style="margin:0 0 14px; opacity:.8;">Оставьте контакты — мы подтвердим наличие, сроки и свяжемся с вами.</p>

                <form method="POST" action="/cart/checkout" class="consult-grid" style="gap:12px;">
                    @csrf

                    <div class="consult-field">
                        <input type="text" name="name" placeholder="Ваше имя*" required value="{{ old('name') }}">
                        @error('name')<div style="color:#ff6b6b;font-size:12px;margin-top:6px;">{{ $message }}</div>@enderror
                    </div>

                    <div class="consult-field">
                        <input type="tel" name="phone" placeholder="Телефон" value="{{ old('phone') }}">
                        @error('phone')<div style="color:#ff6b6b;font-size:12px;margin-top:6px;">{{ $message }}</div>@enderror
                    </div>

                    <div class="consult-field">
                        <input type="email" name="email" placeholder="E-mail" value="{{ old('email') }}">
                        @error('email')<div style="color:#ff6b6b;font-size:12px;margin-top:6px;">{{ $message }}</div>@enderror
                    </div>

                    <div class="consult-field full">
                        <textarea name="comment" placeholder="Комментарий (если нужно)">{{ old('comment') }}</textarea>
                        @error('comment')<div style="color:#ff6b6b;font-size:12px;margin-top:6px;">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn-primary" style="width:100%;">Отправить заявку</button>
                </form>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        (function(){
            const blocks = document.querySelectorAll('[data-qty]');
            if(!blocks.length) return;

            blocks.forEach(block => {
                const input = block.querySelector('[data-qty-input]');
                const minus = block.querySelector('[data-qty-minus]');
                const plus  = block.querySelector('[data-qty-plus]');
                if(!input || !minus || !plus) return;

                const clamp = (v) => {
                    v = parseInt(v || '0', 10);
                    if (isNaN(v)) v = 0;
                    if (v < 0) v = 0;
                    return v;
                };

                minus.addEventListener('click', () => {
                    input.value = Math.max(0, clamp(input.value) - 1);
                });
                plus.addEventListener('click', () => {
                    input.value = clamp(input.value) + 1;
                });
            });
        })();
    </script>
@endpush
