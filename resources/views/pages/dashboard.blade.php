@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
<div class="container" style="padding: 40px 40px;">
    <h1 style="margin-bottom: 10px;">Личный кабинет</h1>
    <p style="opacity:.9;">Вы вошли как <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->email }}).</p>

    <div style="margin-top: 20px; display:flex; gap:12px; flex-wrap:wrap;">
        <a class="btn-primary" style="text-decoration:none;color:white;" href="/pages/catalog.html">Перейти в каталог</a>
        <a class="btn-outline" style="text-decoration:none;" href="/pages/news.html">Новости</a>
    </div>
</div>
@endsection
