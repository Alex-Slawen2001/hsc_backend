@extends('layouts.app')

@section('title', 'Регистрация')

@push('styles')
    <link rel="stylesheet" href="/styles/css/reg.css">
@endpush

@section('content')
@include('auth._register_content')
@endsection

@push('scripts')
    <script src="/styles/js/reg.js"></script>
@endpush
