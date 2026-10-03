@extends('layouts.app')

@section('title', 'Edit Availability System Ticketing')

@section('content')

<div class="availability-container">

    {{-- KEMBALI --}}
    <a
        href="{{ route(
            'form-availability.show',
            $form_availability
        ) }}"
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

        Kembali ke Detail Form
    </a>


    {{-- HEADER --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Edit Availability System Ticketing
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Perbarui data laporan availability system ticketing.
            </p>
        </div>

        <a
            href="{{ route('form-availability.index') }}"
            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
        >
            Lihat Semua Form
        </a>

    </div>


    {{-- FORM --}}
    <form
        method="POST"
        action="{{ route(
            'form-availability.update',
            $form_availability
        ) }}"
    >
        @csrf
        @method('PUT')

        @include('form-availability._form', [
            'submitLabel' => 'Simpan Perubahan',
        ])
    </form>

</div>

@endsection
