@extends('layouts.app')

@section('title', 'News')

@push('styles')
    <link rel="stylesheet" href="/styles/css/news_detail.css">
    <link rel="stylesheet" href="/styles/css/form.css">
@endpush

@section('content')
@include('pages._news_content')
@endsection
