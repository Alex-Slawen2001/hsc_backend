@extends('layouts.app')

@section('title', 'Login')

@push('styles')
    <link rel="stylesheet" href="/styles/css/login.css">
@endpush

@section('content')
@include('pages._login_content')
@endsection
