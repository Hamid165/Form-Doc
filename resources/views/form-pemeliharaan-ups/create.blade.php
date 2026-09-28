@extends('layouts.app')

@section('title', 'Buat Checklist Pemeliharaan UPS')

@section('content')
    @include('form-pemeliharaan-ups.form', [
        'action' => route('form-pemeliharaan-ups.store'),
        'method' => 'POST',
        'form' => new \App\Models\FormPemeliharaanUps\FormPemeliharaanUps()
    ])
@endsection
