@extends('layouts.app')

@section('title', 'Вход')

@push('styles')
    <link rel="stylesheet" href="/styles/css/login.css">
@endpush

@section('content')
@include('auth._login_content')
@endsection

@push('scripts')
    <script src="/styles/js/login.js"></script>
@endpush
