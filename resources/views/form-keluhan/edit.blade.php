@extends('layouts.app')

@section('title', 'Edit Formulir Pengelolaan dan Penanganan Keluhan')

@section('content')

@include('form-keluhan.form', [
    'action' => route('form-keluhan.update', $form->id),
    'method' => 'PUT',
    'form' => $form
])

@endsection
