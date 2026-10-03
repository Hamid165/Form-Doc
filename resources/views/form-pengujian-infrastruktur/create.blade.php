@extends('layouts.app')

@section('title', 'Buat Formulir Pengujian Infrastruktur')

@section('content')

@include('form-pengujian-infrastruktur.form', [
    'action'        => route('form-pengujian-infrastruktur.store'),
    'method'        => 'POST',
    'form'          => new \App\Models\FormPengujianInfrastruktur\FormPengujianInfrastruktur(),
    'items'         => [],
    'formTemplate'  => $formTemplate,
    'masterSigners' => $masterSigners,
])

@endsection
