@extends('layouts.app')
@section('title','Админ — Товары')


@section('content')
    <div class="page-center">
        <div class="page-box">

            <div class="adm-head">
                <h1>Товары</h1>
                <a class="btn-primary adm-add" href="/admin/products/create">+ Добавить</a>
            </div>

            @if(session('ok'))
                <div style="padding:10px 12px;border:1px solid #2ecc71;border-radius:12px;margin-bottom:12px;">
                    {{ session('ok') }}
                </div>
            @endif

            <div class="adm-list">
                @foreach($products as $p)
                    <div class="adm-card">

                        @if($p->image_path)
                            <img src="{{ $p->image_path }}" alt="">
                        @endif

                        <div>
                            <div class="adm-title">{{ $p->title }}</div>
                            <div style="opacity:.9;margin-bottom:8px;">
                                ₽ {{ number_format((int)$p->price_rub, 0, '.', ' ') }}
                            </div>

                            <div class="adm-actions">
                                <a class="btn-outline" href="/products/{{ $p->slug }}">Открыть</a>
                                <a class="btn-outline" href="/admin/products/{{ $p->id }}/edit">Редактировать</a>

                                <form method="POST" action="/admin/products/{{ $p->id }}" style="margin:0;">
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

            <div style="margin-top:18px;">
                {{ $products->links() }}
            </div>

        </div>
    </div>
@endsection
