@extends('layouts.app')

    <script src="/styles/js/calc.js"></script>


@section('title', 'HSC Copter — Главная')

@push('styles')
    <link rel="stylesheet" href="/styles/css/form.css">
@endpush

@section('content')
@include('pages._home_content')
@endsection
