@extends('layouts.app')

@section('title', 'Programs')

@push('styles')
    <link rel="stylesheet" href="{{ asset('styles/css/obuchenie.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/css/center.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/css/styles.css') }}">
@endpush

@section('content')
@include('pages._programs_content')
@endsection
