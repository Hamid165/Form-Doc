@extends('layouts.app')

@section('title', 'Buat Berita Acara Serah Terima Barang')

@section('content')
@include('form-berita-acara-serah-terima-barang.form', [
    'action' => route('form-berita-acara-serah-terima-barang.store'),
    'method' => 'POST'
])
@endsection
