@extends('layouts.app')

@section('title', 'Center')

@push('styles')
    <link rel="stylesheet" href="/styles/css/center.css">
@endpush

@section('content')
@include('pages._center_content')
@endsection
