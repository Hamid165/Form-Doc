@extends('layouts.app')

@section('title', 'Edit Formulir Keluar/Masuk Barang')

@section('content')

@include('form-keluar-masuk-barang-dc-drc.form', [
    'action' => route('form-keluar-masuk-barang-dc-drc.update', $form->id),
    'method' => 'PUT',
    'form' => $form
])

@endsection
