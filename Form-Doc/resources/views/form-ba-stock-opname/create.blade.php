@extends('layouts.app')

@section('title', 'Buat BA Stock Opname')

@section('content')
@include('form-ba-stock-opname.form', [
    'action' => route('form-ba-stock-opname.store'),
    'method' => 'POST'
])
@endsection
