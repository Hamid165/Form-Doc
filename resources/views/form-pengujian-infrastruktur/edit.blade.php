@extends('layouts.app')

@section('title', 'Edit Formulir Pengujian Infrastruktur')

@section('content')

@include('form-pengujian-infrastruktur.form', [
    'action'        => route('form-pengujian-infrastruktur.update', $form->id),
    'method'        => 'PUT',
    'form'          => $form,
    'items'         => $form->items,
    'formTemplate'  => $formTemplate,
    'masterSigners' => $masterSigners,
])

@endsection
