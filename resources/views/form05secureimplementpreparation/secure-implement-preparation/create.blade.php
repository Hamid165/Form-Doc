@extends('layouts.app')

@section('title', 'Tambah Secure Implement Preparation')

@section('content')

<form
    action="{{ route('secure-implement-preparation.store') }}"
    method="POST"
>

    @csrf

    @include('secure-implement-preparation.form')


    <div class="secure-actions">

        <a
            href="{{ route('secure-implement-preparation.index') }}"
            class="secure-button secure-back"
        >
            ← Kembali
        </a>


        <button
            type="submit"
            class="secure-button secure-save"
        >
            Simpan Formulir
        </button>

    </div>

</form>

@endsection