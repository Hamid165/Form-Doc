@extends('layouts.app')

@section('title', 'Buat Formulir Checklist Pemeliharaan AC')

@section('content')

@include('form-pemeliharaan-ac.form', [
    'action' => route('form-pemeliharaan-ac.store'),
    'method' => 'POST',
    'form' => new \App\Models\FormPemeliharaanAc\FormPemeliharaanAc()
])

@endsection
