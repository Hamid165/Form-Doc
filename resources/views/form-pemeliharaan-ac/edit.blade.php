@extends('layouts.app')

@section('title', 'Edit Formulir Checklist Pemeliharaan AC')

@section('content')

@include('form-pemeliharaan-ac.form', [
    'action' => route('form-pemeliharaan-ac.update', $form->id),
    'method' => 'PUT',
    'form' => $form
])

@endsection
