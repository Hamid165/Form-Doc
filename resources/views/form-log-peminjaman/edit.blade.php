@extends('layouts.app')

@section('title', 'Edit Log Peminjaman')

@section('content')
@include('form-log-peminjaman.form', [
    'action' => route('form-log-peminjaman.update', $form->id),
    'method' => 'PUT'
])
@endsection
