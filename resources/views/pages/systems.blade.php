@extends('layouts.app')

@section('title', 'Systems')

@push('styles')
    <link rel="stylesheet" href="{{ asset('styles/css/obuchenie.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/css/systems.css') }}">
    <script rel="stylesheet" src="{{ asset('styles/js/systems.js') }}"></script>

@endpush

@section('content')
@include('pages._systems_content')
@endsection
