@extends('layouts.app')

@section('title', 'About')

@push('styles')
    <link rel="stylesheet" href="/styles/css/about.css">
@endpush

@section('content')
@include('pages._about_content')
@endsection
