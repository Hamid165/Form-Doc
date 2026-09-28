@extends('layouts.app')

@section('title', 'Buat Log Peminjaman')

@section('content')
@include('form-log-peminjaman.form', [
    'action' => route('form-log-peminjaman.store'),
    'method' => 'POST'
])
@endsection
