@extends('layouts.app')

@section('title', 'Buat Availability System Ticketing')

@section('content')

<div class="availability-container">

    {{-- KEMBALI --}}
    <a
        href="{{ route('form-availability.index') }}"
        class="mb-5 inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-blue-600"
    >
        <svg
            class="h-4 w-4"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 19l-7-7 7-7"
            />
        </svg>

        Kembali ke Daftar Form
    </a>


    {{-- HEADER --}}
    <div class="mb-6">

        <h1 class="text-2xl font-bold text-gray-900">
            Buat Availability System Ticketing
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Silakan isi data laporan availability system ticketing.
        </p>

    </div>


    {{-- FORM --}}
    <form
        method="POST"
        action="{{ route('form-availability.store') }}"
    >
        @csrf

        @include('form-availability._form', [
            'submitLabel' => 'Simpan Form',
        ])
    </form>

</div>

@endsection
