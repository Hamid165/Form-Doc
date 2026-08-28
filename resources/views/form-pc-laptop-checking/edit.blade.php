@extends('layouts.app')

@section('title', 'Edit Formulir PC/Laptop Checking')

@section('content')

@include('form-pc-laptop-checking.form', [
    'action' => route('form-pc-laptop-checking.update', $form->id),
    'method' => 'PUT'
])

@endsection
