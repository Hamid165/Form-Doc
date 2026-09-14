@extends('layouts.app')

@section('title', 'Edit Serah Terima User Aplikasi')

@section('content')
@include('form-serah-terima-user.form', [
    'action' => route('form-serah-terima-user.update', $form->id),
    'method' => 'PUT'
])
@endsection
