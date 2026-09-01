@extends('layouts.app')
@section('title', 'Edit Formulir Laporan Backup')
@section('content')
<div class="py-6">
    @include('form-backup.form', [
        'action' => route('form-backup.update', $form->id),
        'method' => 'PUT',
        'form' => $form
    ])
</div>


@endsection