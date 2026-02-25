@extends('layouts.app')

@section('title', 'Obuchenie')

@push('styles')
    <link rel="stylesheet" href="/styles/css/obuchenie.css">
@endpush

@section('content')
@include('pages._obuchenie_content')
@endsection
