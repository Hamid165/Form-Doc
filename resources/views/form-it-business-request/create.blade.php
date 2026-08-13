@extends('layouts.app')

@section('title', 'Buat Formulir IT Business Request')

@section('content')

@include('form-it-business-request.form', [
    'action' => route('form-it-business-request.store'),
    'method' => 'POST',
    'form' => new \App\Models\FormItBusinessRequest\FormItBusinessRequest(),
    'formTemplate' => $formTemplate
])

@endsection
