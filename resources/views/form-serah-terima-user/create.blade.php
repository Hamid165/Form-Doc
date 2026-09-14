@extends('layouts.app')

@section('title', 'Buat Serah Terima User Aplikasi')

@section('content')
@include('form-serah-terima-user.form', [
    'action' => route('form-serah-terima-user.store'),
    'method' => 'POST'
])
@endsection
