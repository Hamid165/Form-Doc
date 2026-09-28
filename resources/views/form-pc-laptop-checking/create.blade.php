@extends('layouts.app')

@section('title', 'Buat Formulir PC/Laptop Checking')

@section('content')

@include('form-pc-laptop-checking.form', [
    'action' => route('form-pc-laptop-checking.store'),
    'method' => 'POST'
])

@endsection
