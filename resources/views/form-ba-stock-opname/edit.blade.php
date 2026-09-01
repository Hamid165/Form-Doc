@extends('layouts.app')

@section('title', 'Edit BA Stock Opname')

@section('content')
@include('form-ba-stock-opname.form', [
    'action' => route('form-ba-stock-opname.update', $form->id),
    'method' => 'PUT'
])
@endsection
