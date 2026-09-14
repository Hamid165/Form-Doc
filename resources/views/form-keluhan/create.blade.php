@extends('layouts.app')

@section('title', 'Buat Formulir Pengelolaan dan Penanganan Keluhan')

@section('content')

@include('form-keluhan.form', [
    'action' => route('form-keluhan.store'),
    'method' => 'POST',
    'form' => new \App\Models\FormKeluhan\FormKeluhan()
])

@endsection
