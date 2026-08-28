@extends('layouts.app')

@section('title', 'Buat Rencana Pelatihan Personil')

@section('content')
@include('form-rencana-pelatihan.form', [
    'action' => route('form-rencana-pelatihan.store'),
    'method' => 'POST'
])
@endsection

