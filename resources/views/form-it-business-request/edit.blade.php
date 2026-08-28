@extends('layouts.app')

@section('title', 'Edit Formulir IT Business Request')

@section('content')

@include('form-it-business-request.form', [
    'action' => route('form-it-business-request.update', $form->id),
    'method' => 'PUT',
    'form' => $form,
    'formTemplate' => $formTemplate
])

@endsection
