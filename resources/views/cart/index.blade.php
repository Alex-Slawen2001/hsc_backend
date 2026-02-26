@extends('layouts.app')

@section('title','Корзина')

@push('styles')
    <style>
        .cart-wrap{ padding:24px 24px; }
        .cart-list{ display:grid; gap:12px; }

        .cart-item{
            display:grid;
            grid-template-columns: 90px 1fr 140px;
            gap:12px;
            align-items:center;
            border:1px solid rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.03);
            padding:12px;
            border-radius:14px;
        }

        .cart-img{
            width:90px;height:70px;object-fit:cover;border-radius:12px;
        }

        .cart-title{ font-weight:700; }
        .cart-meta{ opacity:.7; font-size:13px; margin-top:4px; }

        .cart-right{ display:flex; flex-direction:column; gap:10px; align-items:flex-end; }
        .cart-sum{ font-weight:900; }

        .cart-qty{
            display:flex;
            gap:10px;
            align-items:center;
            width:100%;
            justify-content:flex-end;
        }

        .cart-qty input{
            width: 88px;
            padding: 10px 12px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.12);
            background: rgba(0,0,0,0.2);
            color: inherit;
        }

        .cart-footer{
            margin-top:16px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:12px;
            flex-wrap:wrap;
        }

        .cart-total{ font-size:18px; font-weight:900; }

        /* Mobile */
        @media (max-width: 768px){
            .cart-item{
                grid-template-columns: 1fr;
                align-items: stretch;
            }

            .cart-img{ width:100%; height:180px; }

            .cart-right{ align-items: stretch; }
            .cart-qty{ justify-content: space-between; }
            .cart-qty input{ width: 120px; }
            .cart-actions-mobile{
                display:flex;
                gap:10px;
                flex-direction:column;
            }
            .cart-actions-mobile .btn-primary,
            .cart-actions-mobile .btn-outline{ width:100%; }
            .cart-footer {
                margin-top: 16px;
                display: flex;
                justify-content: center;
                gap: 12px;
                flex-wrap: wrap;
                flex-direction: column;
            }
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
            <form method="POST" action="/cart/update">
                @csrf

                <div class="cart-list">
                    @foreach($lines as $line)
                        @php($p = $line['product'])

                        <div class="cart-item">
                            <img class="cart-img" src="{{ $p->image_path }}" alt="{{ $p->title }}">

                            <div>
                                <div class="cart-title">
                                    <a href="/products/{{ $p->slug }}" style="color:inherit;text-decoration:none;">
                                        {{ $p->title }}
                                    </a>
                                </div>
                                @if($p->sku)
                                    <div class="cart-meta">SKU: {{ $p->sku }}</div>
                                @endif
                                <div class="cart-meta">Цена: ₽ {{ number_format($line['price'], 0, '.', ' ') }}</div>
                            </div>

                            <div class="cart-right">
                                <div class="cart-sum">₽ {{ number_format($line['sum'], 0, '.', ' ') }}</div>

                                <div class="cart-qty">
                                    <span style="opacity:.75;font-size:13px;">Кол-во</span>
                                    <input type="number" min="0" name="items[{{ $p->id }}]" value="{{ $line['qty'] }}">
                                </div>

                                <form method="POST" action="/cart/remove/{{ $p->id }}" style="width:100%;">
                                    @csrf
                                    <button class="btn-outline" type="submit" style="width:100%;">Удалить</button>
                                </form>

                                <div style="opacity:.6;font-size:12px;text-align:right;width:100%;display: none">0 = удалить</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="cart-footer">
                    <div class="cart-total">Итого: ₽ {{ number_format($total, 0, '.', ' ') }}</div>

                    <div class="cart-actions-mobile">
                        <button style="width: 100%;" type="submit" class="btn-primary">Обновить</button>

                        <form style=" margin-top: 5px;margin-bottom: 5px;" method="POST" action="/cart/clear">
                            @csrf
                            <button type="submit" class="btn-outline" style="width:100%;">Очистить</button>
                        </form>

                        <button type="button" class="btn-primary js-open-consult">Оформить (заявка)</button>
                    </div>
                </div>
            </form>
        @endif
    </div>
@endsection
