@extends('layouts.app')

@section('title', 'Edit Formulir Permohonan Pencabutan Hak Akses')

@section('content')

@include('form-pencabutan-hak-akses.form', [
    'action' => route('form-pencabutan-hak-akses.update', $form->id),
    'method' => 'PUT'
])

@endsection
