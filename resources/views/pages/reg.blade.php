@extends('layouts.app')

@section('title', 'Reg')

@push('styles')
    <link rel="stylesheet" href="/styles/css/reg.css">
@endpush

@section('content')
@include('pages._reg_content')
@endsection
