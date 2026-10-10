@extends('layouts.app')

@section('title', 'Edit Secure Implement Preparation')

@section('content')

<form
    action="{{ route(
        'secure-implement-preparation.update',
        $form->id
    ) }}"
    method="POST"
>

    @csrf
    @method('PUT')


    @include('secure-implement-preparation.form')


    <div class="secure-actions">

        <a
            href="{{ route(
                'secure-implement-preparation.show',
                $form->id
            ) }}"
            class="secure-button secure-back"
        >
            ← Kembali
        </a>


        <button
            type="submit"
            class="secure-button secure-save"
        >
            Simpan Perubahan
        </button>

    </div>

</form>

@endsection