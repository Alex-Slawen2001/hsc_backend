@extends('layouts.app')
@section('title','Добавить товар')

@section('content')
    <div class="container" style="padding:24px 0;">
        <h1 style="margin-bottom:16px;">Добавить товар</h1>
        <form method="POST" action="/admin/products">
            @include('admin.products._form')
        </form>
    </div>
@endsection
