@extends('layouts.app')
@section('title', 'Buat Formulir Laporan Backup')
@section('content')
<div class="py-6">
    @include('form-backup.form', [
        'action' => route('form-backup.store'),
        'form' => new \App\Models\FormBackup\FormBackup()
    ])
</div>


@endsection