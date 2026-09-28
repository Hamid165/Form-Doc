@extends('layouts.app')

@section('title', 'Edit Formulir Serah Terima Source Code')

@section('content')

@include('form-serah-terima-source-code.form', [
    'action' => route('form-serah-terima-source-code.update', $form->id),
    'method' => 'PUT',
    'form' => $form,
])

@endsection