@extends('layouts.app')

@section('title', 'Contacts')

@push('styles')
    <link rel="stylesheet" href="/styles/css/form.css">
    <link rel="stylesheet" href="/styles/css/contacts.css">
@endpush

@section('content')
@include('pages._contacts_content')
@endsection
