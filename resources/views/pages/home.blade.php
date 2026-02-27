@extends('layouts.app')

@section('title', 'HSC Copter — Главная')

@push('styles')
    <link rel="stylesheet" href="/styles/css/form.css">
@endpush

@section('content')
    @include('pages._home_content')
@endsection

@push('scripts')
    <script src="/styles/js/calc.js"></script>
@endpush
