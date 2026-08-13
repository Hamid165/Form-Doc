@extends('layouts.app')

@section('title', 'Edit Rencana Pelatihan Personil')

@section('content')
@include('form-rencana-pelatihan.form', [
    'action' => route('form-rencana-pelatihan.update', $form->id),
    'method' => 'PUT'
])
@endsection
