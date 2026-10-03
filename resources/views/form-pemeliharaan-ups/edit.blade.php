@extends('layouts.app')

@section('title', 'Edit Checklist Pemeliharaan UPS')

@section('content')
    @include('form-pemeliharaan-ups.form', [
        'action' => route('form-pemeliharaan-ups.update', $form->id),
        'method' => 'PUT',
        'form' => $form
    ])
@endsection
