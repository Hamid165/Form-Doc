@extends('layouts.app')

@section('title', 'Buat Formulir Pemeliharaan CCTV')

@section('content')

@include('form-cctv.form', [
    'action' => route('form-cctv.store'),
    'method' => 'POST',
    'form' => new \App\Models\FormCctv\FormCctv()
])

@endsection
