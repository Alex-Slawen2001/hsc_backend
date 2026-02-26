@extends('layouts.app')
@section('title','Кабинет')

@push('styles')
    <style>
        .page-content{
            max-width: 520px;
            margin: 40px auto;
        }

        @media (max-width:640px){
            .page-content{
                margin: 32px auto;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="page-content">

            <h1 style="margin-bottom:10px;">Личный кабинет</h1>

            <p style="opacity:.8;margin-bottom:20px;">
                Вы вошли как <b>{{ auth()->user()->name }}</b>
                ({{ auth()->user()->email }})
            </p>

            <div style="display:flex;flex-direction:column;gap:14px;">
                <a href="/pages/catalog.html" class="btn-primary">
                    Перейти в каталог
                </a>

                <a href="/pages/news.html" class="btn-outline">
                    Новости
                </a>

                <form action="/logout" method="POST">
                    @csrf
                    <button class="btn-outline" style="width:100%;">
                        Выйти
                    </button>
                </form>
            </div>

        </div>
    </div>
@endsection
