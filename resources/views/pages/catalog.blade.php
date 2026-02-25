@extends('layouts.app')

@section('title', 'Catalog')

@push('styles')
    <link rel="stylesheet" href="/styles/css/form.css">
    <link rel="stylesheet" href="/styles/css/catalog.css">
@endpush

@section('content')
@include('pages._catalog_content')
@endsection
