@extends('layouts.app')

@section('title', 'Programs')

@push('styles')
    <link rel="stylesheet" href="/styles/css/obuchenie.css">
@endpush

@section('content')
@include('pages._programs_content')
@endsection
