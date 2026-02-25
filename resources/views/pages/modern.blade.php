@extends('layouts.app')

@section('title', 'Modern')

@push('styles')
    <link rel="stylesheet" href="/styles/css/modern.css">
@endpush

@section('content')
@include('pages._modern_content')
@endsection
