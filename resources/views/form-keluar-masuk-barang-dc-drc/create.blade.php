@extends('layouts.app')

@section('title', 'Buat Formulir Keluar/Masuk Barang')

@section('content')

@include('form-keluar-masuk-barang-dc-drc.form', [
    'action' => route('form-keluar-masuk-barang-dc-drc.store'),
    'method' => 'POST',
    'form' => new \App\Models\FormKeluarMasukBarangDcDrc\FormKeluarMasukBarangDcDrc()
])

@endsection
