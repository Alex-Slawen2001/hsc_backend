@extends('layouts.app')

@section('title', 'Document')

@push('styles')
    <link rel="stylesheet" href="/styles/css/document.css">
@endpush

@section('content')
@include('pages._document_content')
@endsection
