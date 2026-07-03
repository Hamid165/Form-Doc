@extends('layouts.app')

@section('title', 'Edit Formulir CCTV')

@section('content')

@include('form-cctv.form', [
    'action' => route('form-cctv.update', $form->id),
    'method' => 'PUT',
    'form' => $form
])

@endsection
