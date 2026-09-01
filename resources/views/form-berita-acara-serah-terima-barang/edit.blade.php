@extends('layouts.app')

@section('title', 'Edit Berita Acara Serah Terima Barang')

@section('content')
@include('form-berita-acara-serah-terima-barang.form', [
    'action' => route('form-berita-acara-serah-terima-barang.update', $form->id),
    'method' => 'PUT'
])
@endsection
