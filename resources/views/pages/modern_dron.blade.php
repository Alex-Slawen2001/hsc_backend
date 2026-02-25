@extends('layouts.app')

@section('title', 'Modern_dron')

@push('styles')
    <link rel="stylesheet" href="/styles/css/modern.css">
@endpush

@section('content')
@include('pages._modern_dron_content')
@endsection
