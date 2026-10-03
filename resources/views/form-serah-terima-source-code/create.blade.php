@extends('layouts.app')

@section('title', 'Buat Formulir Serah Terima Source Code')

@section('content')

@include('form-serah-terima-source-code.form', [
    'action' => route('form-serah-terima-source-code.store'),
    'method' => 'POST',
    'form' => new \App\Models\FormSerahTerimaSourceCode\FormSerahTerimaSourceCode()
])

@endsection