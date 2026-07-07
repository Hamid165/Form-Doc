@extends('layouts.app')

@section('title', 'Buat Formulir Permohonan Pencabutan Hak Akses')

@section('content')

@include('form-pencabutan-hak-akses.form', [
    'action' => route('form-pencabutan-hak-akses.store'),
    'method' => 'POST'
])

@endsection
