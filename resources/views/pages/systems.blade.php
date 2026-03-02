@extends('layouts.app')

@section('title', 'Systems')

@push('styles')
    <link rel="stylesheet" href="{{ asset('styles/css/obuchenie.css') }}">

@endpush

@section('content')
@include('pages._systems_content')
@endsection
