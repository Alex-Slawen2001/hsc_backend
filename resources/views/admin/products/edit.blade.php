@extends('layouts.app')
@section('title','Редактировать товар')

@section('content')
    <div class="container" style="padding:24px 0;">
        <h1 style="margin-bottom:16px;">Редактировать товар</h1>
        <form method="POST" action="/admin/products/{{ $product->id }}">
            @csrf
            @method('PUT')
            @include('admin.products._form', ['product' => $product])
        </form>
    </div>
@endsection
