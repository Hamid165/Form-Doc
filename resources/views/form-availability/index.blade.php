@extends('layouts.app')

@section('title', 'Availability System Ticketing')

@section('content')

@php
    /*
     * Menentukan tab yang harus dibuka setelah pencarian/paginasi.
     * Jika tidak ada parameter khusus, tab terakhir disimpan di browser.
     */
    $forcedTab = null;

    if (request()->filled('search') || request()->has('page')) {
        $forcedTab = 'forms';
    }

    if (
        request()->filled('signer_search')
        || request()->has('signer_page')
        || request()->filled('ba_search')
        || request()->has('ba_page')
    ) {
        $forcedTab = 'settings';
    }
@endphp

<div class="mx-auto w-full max-w-7xl space-y-6">

    {{-- KEMBALI KE KATALOG --}}
    <a
        href="{{ url('/formulir') }}"
        class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-gray-900"
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

        Kembali ke Katalog Formulir
    </a>

    {{-- HEADER KAI --}}
    <header class="availability-index-hero">

        <div class="availability-index-hero-copy">

            <div class="availability-index-brandline">
                <span class="availability-index-brandmark">KAI</span>

                <span class="availability-index-brandtext">
                    Monitoring operasional
                </span>
            </div>
            <h1>
                Availability System Ticketing
            </h1>

            <p class="availability-index-description">
                Kelola laporan availability perangkat ticketing dan
                pengaturan sistem dalam satu halaman.
            </p>
        </div>

        <div class="availability-index-hero-action">

            <a
                href="{{ route('form-availability.create') }}"
                class="availability-index-create-button"
            >
                <svg
                    width="18"
                    height="18"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 4v16m8-8H4"
                    />
                </svg>

                Buat Form Baru
            </a>

            <div
                class="availability-index-rail"
                aria-hidden="true"
            >
                <span></span>
                <span></span>
                <span></span>
            </div>

        </div>

    </header>

    {{-- =========================================================
         NOTIFIKASI GLOBAL
         Berlaku untuk simpan, ubah, hapus, import, dan konfirmasi.
    ========================================================== --}}
    @if (session('success'))
        <div
            x-data="{ show: true, percent: 100 }"
            x-init="
                const duration = 5000;
                const interval = 50;
                const step = (interval / duration) * 100;

                const timer = setInterval(() => {
                    percent -= step;

                    if (percent <= 0) {
                        percent = 0;
                        clearInterval(timer);
                        show = false;
                    }
                }, interval);
            "
            x-show="show"
            x-transition:leave="transition ease-in duration-300 transform opacity-0 scale-95"
            class="relative flex items-center gap-3 rounded-xl border border-emerald-100 bg-emerald-50 p-4 text-emerald-800 shadow-sm"
        >
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-100">
                <svg
                    class="h-5 w-5 text-emerald-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
            </div>

            <div class="min-w-0 flex-1">
                <h4 class="text-sm font-bold text-emerald-800">
                    Berhasil
                </h4>

                <p class="mt-0.5 text-[13px] font-medium text-emerald-600">
                    {{ session('success') }}
                </p>
            </div>

            <div class="flex shrink-0 items-center gap-3">

                <div class="relative h-6 w-6">
                    <svg class="h-6 w-6 -rotate-90">
                        <circle
                            cx="12"
                            cy="12"
                            r="9"
                            stroke="#bbf7d0"
                            stroke-width="2"
                            fill="transparent"
                        />

                        <circle
                            cx="12"
                            cy="12"
                            r="9"
                            stroke="#059669"
                            stroke-width="2"
                            fill="transparent"
                            stroke-dasharray="56.54"
                            :stroke-dashoffset="56.54 - (56.54 * percent / 100)"
                            stroke-linecap="round"
                            class="transition-all duration-75 ease-linear"
                        />
                    </svg>
                </div>

                <button
                    type="button"
                    @click="show = false"
                    class="rounded-md p-1 text-emerald-500 transition hover:bg-emerald-100 hover:text-emerald-700"
                    aria-label="Tutup notifikasi"
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>

            </div>
        </div>
    @endif

    @if ($errors->any() || session('error'))
        <div
            x-data="{ show: true, percent: 100 }"
            x-init="
                const duration = 5000;
                const interval = 50;
                const step = (interval / duration) * 100;

                const timer = setInterval(() => {
                    percent -= step;

                    if (percent <= 0) {
                        percent = 0;
                        clearInterval(timer);
                        show = false;
                    }
                }, interval);
            "
            x-show="show"
            x-transition:leave="transition ease-in duration-300 transform opacity-0 scale-95"
            class="relative flex items-center gap-3 rounded-xl border border-red-100 bg-red-50 p-4 text-red-800 shadow-sm"
        >
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-100">
                <svg
                    class="h-5 w-5 text-red-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
            </div>

            <div class="min-w-0 flex-1">
                <h4 class="text-sm font-bold text-red-800">
                    Gagal
                </h4>

                <p class="mt-0.5 text-[13px] font-medium text-red-600">
                    {{ session('error') ?? $errors->first() }}
                </p>
            </div>

            <div class="flex shrink-0 items-center gap-3">

                <div class="relative h-6 w-6">
                    <svg class="h-6 w-6 -rotate-90">
                        <circle
                            cx="12"
                            cy="12"
                            r="9"
                            stroke="#fecaca"
                            stroke-width="2"
                            fill="transparent"
                        />

                        <circle
                            cx="12"
                            cy="12"
                            r="9"
                            stroke="#dc2626"
                            stroke-width="2"
                            fill="transparent"
                            stroke-dasharray="56.54"
                            :stroke-dashoffset="56.54 - (56.54 * percent / 100)"
                            stroke-linecap="round"
                            class="transition-all duration-75 ease-linear"
                        />
                    </svg>
                </div>

                <button
                    type="button"
                    @click="show = false"
                    class="rounded-md p-1 text-red-500 transition hover:bg-red-100 hover:text-red-700"
                    aria-label="Tutup notifikasi"
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>

            </div>
        </div>
    @endif

    {{-- =========================================================
         TAB UTAMA
    ========================================================== --}}
    <div
        x-data="{
            tab: 'forms',

            setTab(value) {
                this.tab = value;
                localStorage.setItem(
                    'availability.activeTab',
                    value
                );
            }
        }"
        x-init="
            const forcedTab = @js($forcedTab);
            const savedTab = localStorage.getItem(
                'availability.activeTab'
            );

            if (
                forcedTab === 'forms'
                || forcedTab === 'settings'
            ) {
                tab = forcedTab;
                localStorage.setItem(
                    'availability.activeTab',
                    forcedTab
                );
            } else if (
                savedTab === 'forms'
                || savedTab === 'settings'
            ) {
                tab = savedTab;
            }
        "
        class="space-y-6"
    >
        {{-- TAB SWITCHER --}}
        <div class="availability-index-tabs">

            <button
                type="button"
                @click="setTab('forms')"
                :class="tab === 'forms' ? 'is-active' : ''"
                class="availability-index-tab"
            >
                <span class="availability-index-tab-number">01</span>
                Daftar Formulir
            </button>

            <button
                type="button"
                @click="setTab('settings')"
                :class="tab === 'settings' ? 'is-active' : ''"
                class="availability-index-tab"
            >
                <span class="availability-index-tab-number">02</span>
                Pengaturan
            </button>

        </div>

        {{-- =====================================================
             TAB DAFTAR FORMULIR
        ====================================================== --}}
        <section
            x-show="tab === 'forms'"
            x-cloak
            class="space-y-6"
        >
            {{-- SEARCH + TOTAL --}}
            <div class="availability-index-toolbar">

                <div class="availability-index-section-heading">
                    <span class="availability-index-section-number">01</span>

                    <div>
                        <span class="availability-index-section-kicker">
                            Data laporan
                        </span>

                        <h2>Daftar Formulir</h2>

                        <p>
                            Cari, pantau status, dan buka laporan availability.
                        </p>
                    </div>
                </div>

                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                    <form
                        id="availabilitySearchForm"
                        action="{{ route('form-availability.index') }}"
                        method="GET"
                        class="flex w-full max-w-xl items-center gap-2"
                    >
                        <div class="relative flex-1">

                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg
                                    class="h-5 w-5 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m21 21-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z"
                                    />
                                </svg>
                            </div>

                            <input
                                type="text"
                                id="availabilitySearchInput"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari no. referensi, business area, atau DAOP..."
                                autocomplete="off"
                                class="availability-index-search-input"
                            >

                            <div
                                id="availabilitySearchLoading"
                                class="pointer-events-none absolute inset-y-0 right-0 hidden items-center pr-3"
                            >
                                <svg
                                    class="h-5 w-5 animate-spin text-gray-500"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                >
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                    />

                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                                    />
                                </svg>
                            </div>

                        </div>

                        <button
                            type="button"
                            id="availabilityResetSearch"
                            class="{{ request('search') ? '' : 'hidden' }} availability-index-reset-button"
                        >
                            Reset
                        </button>
                    </form>

                    <div class="availability-index-total">
                        Total

                        <span
                            id="availabilityTotalData"
                            class="font-semibold text-gray-900"
                        >
                            {{ $forms->total() }}
                        </span>

                        laporan
                    </div>

                </div>
            </div>

            {{-- TABEL FORMULIR --}}
            <div id="availabilityTableResult">

                <div class="availability-index-table-card">

                    <div class="availability-index-table-scroll">

                        <table class="availability-index-table">

                            <thead class="availability-index-table-head">
                                <tr>
                                    <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        No.
                                    </th>

                                    <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        No. Referensi
                                    </th>

                                    <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Tanggal
                                    </th>

                                    <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Business Area
                                    </th>

                                    <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        DAOP/DIVRE
                                    </th>

                                    <th class="px-5 py-3.5 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Stasiun
                                    </th>

                                    <th class="px-5 py-3.5 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Perangkat
                                    </th>

                                    <th class="px-5 py-3.5 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Status
                                    </th>

                                    <th class="w-28 px-4 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">

                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100 bg-white">

                                @forelse ($forms as $form)
                                    <tr
                                        data-availability-row-url="{{ route('form-availability.show', $form) }}"
                                        tabindex="0"
                                        role="link"
                                        aria-label="Lihat detail laporan {{ $form->no_ref ?: $form->id }}"
                                        class="availability-index-table-row cursor-pointer focus:outline-none"
                                    >
                                        <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-500">
                                            {{ $forms->firstItem() + $loop->index }}
                                        </td>

                                        <td class="whitespace-nowrap px-5 py-4">
                                            <div class="font-semibold text-gray-900">
                                                {{ $form->no_ref ?: '-' }}
                                            </div>

                                            <div class="mt-1 text-xs text-gray-400">
                                                Dibuat
                                                {{ $form->created_at?->format('d M Y, H:i') }}
                                            </div>
                                        </td>

                                        <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-700">
                                            {{ $form->tanggal?->format('d M Y') ?: '-' }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-gray-700">
                                            {{ $form->business_area ?: '-' }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-gray-700">
                                            {{ $form->daop_divre ?: '-' }}
                                        </td>

                                        <td class="whitespace-nowrap px-5 py-4 text-center">
                                            <span class="availability-index-metric availability-index-metric-blue">
                                                {{ $form->jumlah_total_station ?? 0 }}
                                            </span>
                                        </td>

                                        <td class="whitespace-nowrap px-5 py-4 text-center">
                                            <span class="availability-index-metric availability-index-metric-blue">
                                                {{ $form->jumlah_perangkat_ticketing ?? 0 }}
                                            </span>
                                        </td>

                                        <td class="whitespace-nowrap px-5 py-4 text-center">

                                            @if ($form->status === 'selesai')
                                                <span class="availability-index-status availability-index-status-complete">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                    Selesai
                                                </span>
                                            @elseif ($form->status === 'dicetak')
                                                <span class="availability-index-status availability-index-status-printed">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                                                    Dicetak
                                                </span>
                                            @else
                                                <span class="availability-index-status availability-index-status-draft">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span>
                                                    Draft
                                                </span>
                                            @endif

                                        </td>

                                        {{-- AKSI FORMULIR: DROPDOWN SEDERHANA --}}
                                        <td
                                            class="w-28 whitespace-nowrap px-4 py-3 text-right"
                                        >
                                            <div class="relative inline-flex">

                                                <button
                                                    type="button"
                                                    data-availability-action-toggle
                                                    aria-expanded="false"
                                                    class="availability-index-more-button"
                                                >
                                                    Lainnya

                                                    <svg
                                                        data-availability-action-chevron
                                                        class="h-4 w-4 transition-transform duration-150"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="m19 9-7 7-7-7"
                                                        />
                                                    </svg>
                                                </button>

                                                <template data-availability-action-template>
                                                    <div
                                                        data-availability-action-menu
                                                        class="availability-index-action-menu fixed z-[9999] hidden w-48"
                                                    >
                                                        <a
                                                            href="{{ route('form-availability.show', $form) }}"
                                                            class="availability-index-action-item"
                                                        >
                                                            Lihat Detail
                                                        </a>

                                                        @if ($form->status === 'draft')
                                                            <a
                                                                href="{{ route('form-availability.edit', $form) }}"
                                                                class="availability-index-action-item"
                                                            >
                                                                Edit Form
                                                            </a>
                                                        @endif

                                                        <button
                                                            type="button"
                                                            data-availability-print-url="{{ route('form-availability.show', $form) }}"
                                                            class="availability-index-action-item"
                                                        >
                                                            Cetak / Lihat PDF
                                                        </button>

                                                        <a
                                                            href="{{ route('form-availability.excel', $form) }}"
                                                            class="availability-index-action-item"
                                                        >
                                                            Unduh Excel
                                                        </a>

                                                        @if ($form->status === 'draft')
                                                            <form
                                                                method="POST"
                                                                action="{{ route('form-availability.confirm', $form) }}"
                                                                data-availability-confirm
                                                                data-confirm-type="complete"
                                                                data-confirm-title="Konfirmasi Selesai"
                                                                data-confirm-message="Laporan {{ $form->no_ref ?: '#' . $form->id }} akan ditandai sebagai selesai. Lanjutkan?"
                                                            >
                                                                @csrf
                                                                @method('PATCH')

                                                                <button
                                                                    type="submit"
                                                                    class="availability-index-action-item"
                                                                >
                                                                    Konfirmasi Selesai
                                                                </button>
                                                            </form>
                                                        @endif

                                                        <form
                                                            method="POST"
                                                            action="{{ route('form-availability.destroy', $form) }}"
                                                            data-availability-confirm
                                                            data-confirm-type="delete"
                                                            data-confirm-title="Hapus Laporan"
                                                            data-confirm-message="Laporan {{ $form->no_ref ?: '#' . $form->id }} akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan."
                                                        >
                                                            @csrf
                                                            @method('DELETE')

                                                            <button
                                                                type="submit"
                                                                class="availability-index-action-item availability-index-action-danger"
                                                            >
                                                                Hapus Laporan
                                                            </button>
                                                        </form>
                                                    </div>
                                                </template>

                                            </div>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td
                                            colspan="9"
                                            class="availability-empty-cell"
                                        >
                                            <div class="availability-empty-state">

                                                {{-- ILUSTRASI EMPTY STATE KERETA --}}
                                                <svg
                                                    class="availability-empty-illustration"
                                                    viewBox="0 0 320 220"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    aria-hidden="true"
                                                >
                                                    {{-- LATAR --}}
                                                    <path
                                                        class="availability-empty-bg"
                                                        d="M63 170C40 151 33 119 47 93C61 68 91 60 114 70C132 39 177 28 208 50C229 65 240 91 235 116C258 122 273 143 267 164C261 184 239 195 217 195H95C82 195 71 183 63 170Z"
                                                    />

                                                    {{-- PAPAN INFORMASI --}}
                                                    <rect
                                                        class="availability-empty-document"
                                                        x="206"
                                                        y="28"
                                                        width="78"
                                                        height="65"
                                                        rx="10"
                                                    />

                                                    <path
                                                        class="availability-empty-blue-line"
                                                        d="M224 48H265"
                                                        stroke-linecap="round"
                                                    />

                                                    <path
                                                        class="availability-empty-gray-line"
                                                        d="M224 62H257"
                                                        stroke-width="4"
                                                        stroke-linecap="round"
                                                    />

                                                    <path
                                                        class="availability-empty-orange-line"
                                                        d="M224 77H246"
                                                        stroke-width="4"
                                                        stroke-linecap="round"
                                                    />

                                                    {{-- IKON TAMBAH --}}
                                                    <circle
                                                        class="availability-empty-plus-circle"
                                                        cx="67"
                                                        cy="61"
                                                        r="23"
                                                    />

                                                    <path
                                                        class="availability-empty-plus-line"
                                                        d="M67 50V72"
                                                    />

                                                    <path
                                                        class="availability-empty-plus-line"
                                                        d="M56 61H78"
                                                    />

                                                    {{-- BADAN KERETA --}}
                                                    <rect
                                                        class="availability-empty-train"
                                                        x="83"
                                                        y="85"
                                                        width="152"
                                                        height="87"
                                                        rx="23"
                                                    />

                                                    {{-- KACA DEPAN --}}
                                                    <path
                                                        class="availability-empty-window"
                                                        d="M104 103C104 96.3726 109.373 91 116 91H201C207.627 91 213 96.3726 213 103V124H104V103Z"
                                                    />

                                                    <path
                                                        class="availability-empty-dark-line"
                                                        d="M158 92V123"
                                                    />

                                                    {{-- GARIS IDENTITAS --}}
                                                    <path
                                                        class="availability-empty-blue-line"
                                                        d="M85 133H233"
                                                    />

                                                    <path
                                                        class="availability-empty-orange-line"
                                                        d="M85 144H233"
                                                    />

                                                    {{-- LAMPU --}}
                                                    <circle
                                                        class="availability-empty-train"
                                                        cx="111"
                                                        cy="158"
                                                        r="8"
                                                    />

                                                    <circle
                                                        class="availability-empty-train"
                                                        cx="207"
                                                        cy="158"
                                                        r="8"
                                                    />

                                                    {{-- REL --}}
                                                    <path
                                                        class="availability-empty-orange-line"
                                                        d="M63 173H257"
                                                        stroke-linecap="round"
                                                    />

                                                    <path
                                                        class="availability-empty-gray-line"
                                                        d="M80 190H241"
                                                        stroke-linecap="round"
                                                    />

                                                    <path
                                                        class="availability-empty-gray-line"
                                                        d="M100 180L91 200"
                                                        stroke-linecap="round"
                                                    />

                                                    <path
                                                        class="availability-empty-gray-line"
                                                        d="M139 180L130 200"
                                                        stroke-linecap="round"
                                                    />

                                                    <path
                                                        class="availability-empty-gray-line"
                                                        d="M178 180L169 200"
                                                        stroke-linecap="round"
                                                    />

                                                    <path
                                                        class="availability-empty-gray-line"
                                                        d="M217 180L208 200"
                                                        stroke-linecap="round"
                                                    />
                                                </svg>

                                                @if (request('search'))

                                                    <h3 class="availability-empty-title">
                                                        Data tidak ditemukan
                                                    </h3>

                                                    <p class="availability-empty-description">
                                                        Tidak ada laporan Availability System Ticketing
                                                        yang cocok dengan pencarian

                                                        <span class="availability-empty-keyword">
                                                            “{{ request('search') }}”
                                                        </span>.

                                                        Coba gunakan kata kunci lain atau reset pencarian.
                                                    </p>

                                                    <button
                                                        type="button"
                                                        data-availability-empty-reset
                                                        class="availability-empty-button"
                                                    >
                                                        <svg
                                                            fill="none"
                                                            stroke="currentColor"
                                                            viewBox="0 0 24 24"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 4v6h6M20 20v-6h-6M5.5 15a7 7 0 0011.9 2M18.5 9A7 7 0 006.6 7"
                                                            />
                                                        </svg>

                                                        Reset Pencarian
                                                    </button>

                                                @else

                                                    <div class="availability-empty-accent">
                                                        <span class="availability-empty-accent-blue"></span>
                                                        <span class="availability-empty-accent-orange"></span>
                                                    </div>

                                                    <h3 class="availability-empty-title">
                                                        Belum ada laporan
                                                    </h3>

                                                    <p class="availability-empty-description">
                                                        Jika belum tersedia, Anda dapat

                                                        <a
                                                            href="{{ route('form-availability.create') }}"
                                                            class="availability-empty-link"
                                                        >
                                                            Buat Form
                                                        </a>

                                                        baru terlebih dahulu.
                                                    </p>

                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>

                    </div>

                    @if ($forms->hasPages())
                        <div class="availability-index-pagination">
                            {{ $forms->withQueryString()->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </section>

        {{-- =====================================================
             TAB PENGATURAN (MASTER SIGNER & BUSINESS AREA)
        ====================================================== --}}
        <section
            x-show="tab === 'settings'"
            x-cloak
            x-data="{
                showAddModal: false,
                showEditModal: false,
                showImportModal: false,
                editItem: null,
                showBaAddModal: false,
                showBaEditModal: false,
                baEditItem: null
            }"
            @master-signer-edit.window="
                editItem = $event.detail;
                showEditModal = true;
            "
            class="space-y-10"
        >
            {{-- SEARCH + ACTION + TOTAL --}}
            <div class="availability-index-toolbar">

                <div class="availability-index-section-heading">
                    <span class="availability-index-section-number">02</span>

                    <div>
                        <span class="availability-index-section-kicker">
                            Data penandatangan
                        </span>

                        <h2>Master Signer</h2>

                        <p>
                            Kelola identitas pejabat yang digunakan pada laporan.
                        </p>
                    </div>
                </div>

                <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">

                    <form
                        id="masterSignerSearchForm"
                        action="{{ route('form-availability.index') }}"
                        method="GET"
                        class="flex w-full max-w-xl items-center gap-2"
                    >
                        <input
                            type="hidden"
                            name="signer_page"
                            value="1"
                        >

                        <div class="relative flex-1">

                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg
                                    class="h-5 w-5 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m21 21-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z"
                                    />
                                </svg>
                            </div>

                            <input
                                type="text"
                                id="masterSignerSearchInput"
                                name="signer_search"
                                value="{{ request('signer_search') }}"
                                placeholder="Cari nama, NIPP, atau jabatan signer..."
                                autocomplete="off"
                                class="availability-index-search-input"
                            >

                            <div
                                id="masterSignerSearchLoading"
                                class="pointer-events-none absolute inset-y-0 right-0 hidden items-center pr-3"
                            >
                                <svg
                                    class="h-5 w-5 animate-spin text-gray-500"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                >
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                    />

                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                                    />
                                </svg>
                            </div>

                        </div>

                        <button
                            type="button"
                            id="masterSignerResetSearch"
                            class="{{ request('signer_search') ? '' : 'hidden' }} availability-index-reset-button"
                        >
                            Reset
                        </button>
                    </form>

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between xl:justify-end">

                        <div class="availability-index-total">
                            Total

                            <span
                                id="masterSignerTotalData"
                                class="font-semibold text-gray-900"
                            >
                                {{ $masterSigners->total() }}
                            </span>

                            signer
                        </div>

                        <div class="flex flex-wrap items-center gap-2">

                            <a
                                href="{{ route('master-signer.template') }}"
                                class="availability-index-tool-button"
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
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                    />
                                </svg>

                                Template
                            </a>

                            <button
                                type="button"
                                @click="showImportModal = true"
                                class="availability-index-tool-button availability-index-tool-button-blue"
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
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l4-4m0 0l4 4m-4-4v12"
                                    />
                                </svg>

                                Import
                            </button>

                            <button
                                type="button"
                                @click="showAddModal = true"
                                class="availability-index-add-button"
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
                                        d="M12 4v16m8-8H4"
                                    />
                                </svg>

                                Tambah Signer
                            </button>

                        </div>
                    </div>

                </div>
            </div>

            {{-- TABEL MASTER SIGNER --}}
            <div id="masterSignerTableResult">

            <div class="availability-index-table-card">

                <div class="availability-index-table-scroll">

                    <table class="availability-index-table">

                        <thead class="availability-index-table-head">
                            <tr>
                                <th class="w-16 px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    No.
                                </th>

                                <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    Nama
                                </th>

                                <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    NIPP
                                </th>

                                <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    Jabatan
                                </th>

                                <th class="w-28 px-4 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">

                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">

                            @forelse ($masterSigners as $idx => $signer)
                                <tr class="availability-index-table-row">

                                    <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-500">
                                        {{ $masterSigners->firstItem() + $idx }}
                                    </td>

                                    <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-gray-900">
                                        {{ $signer->nama }}
                                    </td>

                                    <td class="whitespace-nowrap px-5 py-4 font-mono text-sm text-gray-700">
                                        {{ $signer->nipp }}
                                    </td>

                                    <td class="px-5 py-4 text-sm text-gray-600">
                                        {{ $signer->jabatan ?: '-' }}
                                    </td>

                                    {{-- AKSI MASTER SIGNER: KEMBALI SEPERTI AWAL --}}
                                    <td class="w-28 whitespace-nowrap px-4 py-3 text-right">

                                        <div class="flex items-center justify-end gap-2">

                                            <button
                                                type="button"
                                                @click="
                                                    editItem = {
                                                        id: {{ $signer->id }},
                                                        nama: @js($signer->nama),
                                                        nipp: @js($signer->nipp),
                                                        jabatan: @js($signer->jabatan ?? '')
                                                    };
                                                    showEditModal = true;
                                                "
                                                class="availability-index-icon-button availability-index-icon-edit"
                                                title="Edit"
                                                aria-label="Edit signer {{ $signer->nama }}"
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
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                    />
                                                </svg>
                                            </button>

                                            <form
                                                method="POST"
                                                action="{{ route('master-signer.destroy', $signer) }}"
                                                data-availability-confirm
                                                data-confirm-type="delete"
                                                data-confirm-title="Hapus Master Signer"
                                                data-confirm-message="Signer {{ $signer->nama }} akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan."
                                                class="m-0 inline-block"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="availability-index-icon-button availability-index-icon-delete"
                                                    title="Hapus"
                                                    aria-label="Hapus signer {{ $signer->nama }}"
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
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                        />
                                                    </svg>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td
                                        colspan="5"
                                        class="availability-empty-cell"
                                    >
                                        <div class="availability-empty-state">

                                            {{-- ILUSTRASI EMPTY STATE KERETA --}}
                                            <svg
                                                class="availability-empty-illustration"
                                                viewBox="0 0 320 220"
                                                fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                                aria-hidden="true"
                                            >
                                                <path
                                                    class="availability-empty-bg"
                                                    d="M63 170C40 151 33 119 47 93C61 68 91 60 114 70C132 39 177 28 208 50C229 65 240 91 235 116C258 122 273 143 267 164C261 184 239 195 217 195H95C82 195 71 183 63 170Z"
                                                />

                                                <rect
                                                    class="availability-empty-document"
                                                    x="206"
                                                    y="28"
                                                    width="78"
                                                    height="65"
                                                    rx="10"
                                                />

                                                <path
                                                    class="availability-empty-blue-line"
                                                    d="M224 48H265"
                                                    stroke-linecap="round"
                                                />

                                                <path
                                                    class="availability-empty-gray-line"
                                                    d="M224 62H257"
                                                    stroke-width="4"
                                                    stroke-linecap="round"
                                                />

                                                <path
                                                    class="availability-empty-orange-line"
                                                    d="M224 77H246"
                                                    stroke-width="4"
                                                    stroke-linecap="round"
                                                />

                                                <circle
                                                    class="availability-empty-plus-circle"
                                                    cx="67"
                                                    cy="61"
                                                    r="23"
                                                />

                                                <path
                                                    class="availability-empty-plus-line"
                                                    d="M67 50V72"
                                                />

                                                <path
                                                    class="availability-empty-plus-line"
                                                    d="M56 61H78"
                                                />

                                                <rect
                                                    class="availability-empty-train"
                                                    x="83"
                                                    y="85"
                                                    width="152"
                                                    height="87"
                                                    rx="23"
                                                />

                                                <path
                                                    class="availability-empty-window"
                                                    d="M104 103C104 96.3726 109.373 91 116 91H201C207.627 91 213 96.3726 213 103V124H104V103Z"
                                                />

                                                <path
                                                    class="availability-empty-dark-line"
                                                    d="M158 92V123"
                                                />

                                                <path
                                                    class="availability-empty-blue-line"
                                                    d="M85 133H233"
                                                />

                                                <path
                                                    class="availability-empty-orange-line"
                                                    d="M85 144H233"
                                                />

                                                <circle
                                                    class="availability-empty-train"
                                                    cx="111"
                                                    cy="158"
                                                    r="8"
                                                />

                                                <circle
                                                    class="availability-empty-train"
                                                    cx="207"
                                                    cy="158"
                                                    r="8"
                                                />

                                                <path
                                                    class="availability-empty-orange-line"
                                                    d="M63 173H257"
                                                    stroke-linecap="round"
                                                />

                                                <path
                                                    class="availability-empty-gray-line"
                                                    d="M80 190H241"
                                                    stroke-linecap="round"
                                                />

                                                <path
                                                    class="availability-empty-gray-line"
                                                    d="M100 180L91 200"
                                                    stroke-linecap="round"
                                                />

                                                <path
                                                    class="availability-empty-gray-line"
                                                    d="M139 180L130 200"
                                                    stroke-linecap="round"
                                                />

                                                <path
                                                    class="availability-empty-gray-line"
                                                    d="M178 180L169 200"
                                                    stroke-linecap="round"
                                                />

                                                <path
                                                    class="availability-empty-gray-line"
                                                    d="M217 180L208 200"
                                                    stroke-linecap="round"
                                                />
                                            </svg>

                                            @if (request('signer_search'))

                                                <h3 class="availability-empty-title">
                                                    Signer tidak ditemukan
                                                </h3>

                                                <p class="availability-empty-description">
                                                    Tidak ada master signer yang cocok dengan pencarian

                                                    <span class="availability-empty-keyword">
                                                        “{{ request('signer_search') }}”
                                                    </span>.

                                                    Coba gunakan kata kunci lain atau reset pencarian.
                                                </p>

                                                <button
                                                    type="button"
                                                    data-master-signer-empty-reset
                                                    class="availability-empty-button"
                                                >
                                                    <svg
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 4v6h6M20 20v-6h-6M5.5 15a7 7 0 0011.9 2M18.5 9A7 7 0 006.6 7"
                                                        />
                                                    </svg>

                                                    Reset Pencarian
                                                </button>

                                            @else

                                                <div class="availability-empty-accent">
                                                    <span class="availability-empty-accent-blue"></span>
                                                    <span class="availability-empty-accent-orange"></span>
                                                </div>

                                                <h3 class="availability-empty-title">
                                                    Belum ada master signer
                                                </h3>

                                                <p class="availability-empty-description">
                                                    Tambahkan signer agar dapat digunakan pada form availability.
                                                </p>

                                                <button
                                                    type="button"
                                                    @click="showAddModal = true"
                                                    class="availability-empty-button"
                                                >
                                                    Tambah Signer
                                                </button>

                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>

                </div>

                @if ($masterSigners->hasPages())
                    <div class="availability-index-pagination">
                        {{ $masterSigners->withQueryString()->links() }}
                    </div>
                @endif

            </div>

                        </div>

            {{-- =================================================
                 MODAL TAMBAH SIGNER
            ================================================== --}}
            <div
                x-show="showAddModal"
                x-transition.opacity
                x-cloak
                class="fixed inset-0 z-[10000] flex items-center justify-center bg-black/50 p-4"
                @keydown.escape.window="showAddModal = false"
            >
                <div
                    @click.outside="showAddModal = false"
                    class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl"
                >
                    <div class="mb-5 flex items-start justify-between gap-4">

                        <div>
                            <h3 class="text-lg font-bold text-gray-900">
                                Tambah Signer
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Tambahkan identitas penandatangan baru.
                            </p>
                        </div>

                        <button
                            type="button"
                            @click="showAddModal = false"
                            class="rounded-lg p-1.5 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600"
                            aria-label="Tutup modal"
                        >
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>

                    </div>

                    <form
                        method="POST"
                        action="{{ route('master-signer.store') }}"
                        class="space-y-4"
                    >
                        @csrf

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">
                                Nama
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="text"
                                name="nama"
                                required
                                placeholder="Contoh: Budi Santoso"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                            >
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">
                                NIPP
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="text"
                                name="nipp"
                                required
                                placeholder="Contoh: 51324"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                            >
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">
                                Jabatan
                            </label>

                            <input
                                type="text"
                                name="jabatan"
                                placeholder="Contoh: Senior Manager Sistem Informasi"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                            >
                        </div>

                        <div class="flex justify-end gap-2 border-t border-gray-100 pt-4">

                            <button
                                type="button"
                                @click="showAddModal = false"
                                class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                            >
                                Batal
                            </button>

                            <button
                                type="submit"
                                class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
                            >
                                Simpan Signer
                            </button>

                        </div>
                    </form>
                </div>
            </div>

            {{-- =================================================
                 MODAL EDIT SIGNER
            ================================================== --}}
            <div
                x-show="showEditModal"
                x-transition.opacity
                x-cloak
                class="fixed inset-0 z-[10000] flex items-center justify-center bg-black/50 p-4"
                @keydown.escape.window="showEditModal = false"
            >
                <div
                    @click.outside="showEditModal = false"
                    class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl"
                >
                    <div class="mb-5 flex items-start justify-between gap-4">

                        <div>
                            <h3 class="text-lg font-bold text-gray-900">
                                Edit Signer
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Perbarui identitas penandatangan.
                            </p>
                        </div>

                        <button
                            type="button"
                            @click="showEditModal = false"
                            class="rounded-lg p-1.5 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600"
                            aria-label="Tutup modal"
                        >
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>

                    </div>

                    <template x-if="editItem">
                        <form
                            method="POST"
                            :action="`/master-signer/${editItem.id}`"
                            class="space-y-4"
                        >
                            @csrf
                            @method('PUT')

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Nama
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="nama"
                                    x-model="editItem.nama"
                                    required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                >
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    NIPP
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="nipp"
                                    x-model="editItem.nipp"
                                    required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                >
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Jabatan
                                </label>

                                <input
                                    type="text"
                                    name="jabatan"
                                    x-model="editItem.jabatan"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                >
                            </div>

                            <div class="flex justify-end gap-2 border-t border-gray-100 pt-4">

                                <button
                                    type="button"
                                    @click="showEditModal = false"
                                    class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                                >
                                    Batal
                                </button>

                                <button
                                    type="submit"
                                    class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
                                >
                                    Simpan Perubahan
                                </button>

                            </div>
                        </form>
                    </template>
                </div>
            </div>

            {{-- =================================================
                 MODAL IMPORT SIGNER
            ================================================== --}}
            <div
                x-show="showImportModal"
                x-transition.opacity
                x-cloak
                class="fixed inset-0 z-[10000] flex items-center justify-center bg-black/50 p-4"
                @keydown.escape.window="showImportModal = false"
            >
                <div
                    @click.outside="showImportModal = false"
                    class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl"
                >
                    <div class="mb-5 flex items-start justify-between gap-4">

                        <div>
                            <h3 class="text-lg font-bold text-gray-900">
                                Import Data Signer
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Unggah data signer menggunakan file Excel atau CSV.
                            </p>
                        </div>

                        <button
                            type="button"
                            @click="showImportModal = false"
                            class="rounded-lg p-1.5 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600"
                            aria-label="Tutup modal"
                        >
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>

                    </div>

                    <form
                        method="POST"
                        action="{{ route('master-signer.import') }}"
                        enctype="multipart/form-data"
                        class="space-y-4"
                    >
                        @csrf

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">
                                File Excel
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="file"
                                name="file"
                                accept=".xlsx,.xls,.csv"
                                required
                                class="w-full rounded-lg border border-gray-300 p-2 text-sm text-gray-500 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100"
                            >

                            <p class="mt-2 text-xs leading-5 text-gray-500">
                                Gunakan

                                <a
                                    href="{{ route('master-signer.template') }}"
                                    class="font-semibold text-blue-600 hover:underline"
                                >
                                    template Excel
                                </a>

                                agar struktur data sesuai.
                            </p>
                        </div>

                        <div class="flex justify-end gap-2 border-t border-gray-100 pt-4">

                            <button
                                type="button"
                                @click="showImportModal = false"
                                class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                            >
                                Batal
                            </button>

                            <button
                                type="submit"
                                class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
                            >
                                Import Signer
                            </button>

                        </div>
                    </form>
                </div>
            </div>

            {{-- =========================================================
                 SECTION BUSINESS AREA
            ========================================================== --}}
            <div class="border-t border-gray-200 pt-8 space-y-6">

                <div class="availability-index-toolbar">
                    <div class="availability-index-section-heading">
                        <span class="availability-index-section-number">03</span>

                        <div>
                            <span class="availability-index-section-kicker">
                                Data Wilayah & DAOP/DIVRE
                            </span>

                            <h2>Master Business Area</h2>

                            <p>
                                Kelola pemetaan kode Business Area dan DAOP/DIVRE untuk pengisian otomatis.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">

                        <form
                            id="masterBaSearchForm"
                            action="{{ route('form-availability.index') }}"
                            method="GET"
                            class="flex w-full max-w-xl items-center gap-2"
                        >
                            <input
                                type="hidden"
                                name="ba_page"
                                value="1"
                            >

                            <div class="relative flex-1">

                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg
                                        class="h-5 w-5 text-gray-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="m21 21-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z"
                                        />
                                    </svg>
                                </div>

                                <input
                                    type="text"
                                    id="masterBaSearchInput"
                                    name="ba_search"
                                    value="{{ request('ba_search') }}"
                                    placeholder="Cari kode Business Area atau DAOP/DIVRE..."
                                    autocomplete="off"
                                    class="availability-index-search-input"
                                >
                            </div>

                            <a
                                href="{{ route('form-availability.index') }}"
                                class="{{ request('ba_search') ? '' : 'hidden' }} availability-index-reset-button"
                            >
                                Reset
                            </a>
                        </form>

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between xl:justify-end">

                            <div class="availability-index-total">
                                Total

                                <span
                                    id="masterBaTotalData"
                                    class="font-semibold text-gray-900"
                                >
                                    {{ $masterBusinessAreas->total() }}
                                </span>

                                area
                            </div>

                            <button
                                type="button"
                                @click="showBaAddModal = true"
                                class="availability-index-add-button"
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
                                        d="M12 4v16m8-8H4"
                                    />
                                </svg>

                                Tambah Business Area
                            </button>

                        </div>

                    </div>
                </div>

                {{-- TABEL MASTER BUSINESS AREA --}}
                <div id="masterBaTableResult">

                    <div class="availability-index-table-card">

                        <div class="availability-index-table-scroll">

                            <table class="availability-index-table">

                                <thead class="availability-index-table-head">
                                    <tr>
                                        <th class="w-16 px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                            No.
                                        </th>

                                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                            Kode Business Area
                                        </th>

                                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                            DAOP / DIVRE
                                        </th>

                                        <th class="w-28 px-4 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">

                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-100 bg-white">

                                    @forelse ($masterBusinessAreas as $idx => $ba)
                                        <tr class="availability-index-table-row">

                                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-500">
                                                {{ $masterBusinessAreas->firstItem() + $idx }}
                                            </td>

                                            <td class="whitespace-nowrap px-5 py-4 font-mono text-sm font-semibold text-gray-900">
                                                {{ $ba->kode }}
                                            </td>

                                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-700">
                                                {{ $ba->daop_divre }}
                                            </td>

                                            <td class="w-28 whitespace-nowrap px-4 py-3 text-right">

                                                <div class="flex items-center justify-end gap-2">

                                                    <button
                                                        type="button"
                                                        @click="
                                                            baEditItem = {
                                                                id: {{ $ba->id }},
                                                                kode: @js($ba->kode),
                                                                daop_divre: @js($ba->daop_divre)
                                                            };
                                                            showBaEditModal = true;
                                                        "
                                                        class="availability-index-icon-button availability-index-icon-edit"
                                                        title="Edit"
                                                        aria-label="Edit Business Area {{ $ba->kode }}"
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
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                            />
                                                        </svg>
                                                    </button>

                                                    <form
                                                        method="POST"
                                                        action="{{ route('master-business-area.destroy', $ba) }}"
                                                        data-availability-confirm
                                                        data-confirm-type="delete"
                                                        data-confirm-title="Hapus Business Area"
                                                        data-confirm-message="Business Area {{ $ba->kode }} - {{ $ba->daop_divre }} akan dihapus secara permanen."
                                                        class="m-0 inline-block"
                                                    >
                                                        @csrf
                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            class="availability-index-icon-button availability-index-icon-delete"
                                                            title="Hapus"
                                                            aria-label="Hapus Business Area {{ $ba->kode }}"
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
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                                />
                                                            </svg>
                                                        </button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>

                                    @empty
                                        <tr>
                                            <td
                                                colspan="4"
                                                class="availability-empty-cell"
                                            >
                                                <div class="availability-empty-state">
                                                    <h3 class="availability-empty-title">
                                                        Belum ada data Business Area
                                                    </h3>

                                                    <p class="availability-empty-description">
                                                        Tambahkan kode Business Area dan DAOP/DIVRE agar otomatis terisi pada formulir.
                                                    </p>

                                                    <button
                                                        type="button"
                                                        @click="showBaAddModal = true"
                                                        class="availability-empty-button"
                                                    >
                                                        Tambah Business Area
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>

                        </div>

                        @if ($masterBusinessAreas->hasPages())
                            <div class="availability-index-pagination">
                                {{ $masterBusinessAreas->withQueryString()->links() }}
                            </div>
                        @endif

                    </div>

                </div>

                {{-- MODAL TAMBAH BUSINESS AREA --}}
                <div
                    x-show="showBaAddModal"
                    x-transition.opacity
                    x-cloak
                    class="fixed inset-0 z-[10000] flex items-center justify-center bg-black/50 p-4"
                    @keydown.escape.window="showBaAddModal = false"
                >
                    <div
                        @click.outside="showBaAddModal = false"
                        class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl"
                    >
                        <div class="mb-5 flex items-start justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">
                                    Tambah Business Area
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    Tambahkan kode Business Area dan DAOP/DIVRE.
                                </p>
                            </div>

                            <button
                                type="button"
                                @click="showBaAddModal = false"
                                class="rounded-lg p-1.5 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600"
                                aria-label="Tutup modal"
                            >
                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>

                        <form
                            method="POST"
                            action="{{ route('master-business-area.store') }}"
                            class="space-y-4"
                        >
                            @csrf

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Kode Business Area
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="kode"
                                    required
                                    placeholder="Contoh: B060"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                >
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    DAOP / DIVRE
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="daop_divre"
                                    required
                                    placeholder="Contoh: Daop 6 Yogyakarta"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                >
                            </div>

                            <div class="flex justify-end gap-2 border-t border-gray-100 pt-4">
                                <button
                                    type="button"
                                    @click="showBaAddModal = false"
                                    class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                                >
                                    Batal
                                </button>

                                <button
                                    type="submit"
                                    class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
                                >
                                    Simpan Business Area
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- MODAL EDIT BUSINESS AREA --}}
                <div
                    x-show="showBaEditModal"
                    x-transition.opacity
                    x-cloak
                    class="fixed inset-0 z-[10000] flex items-center justify-center bg-black/50 p-4"
                    @keydown.escape.window="showBaEditModal = false"
                >
                    <div
                        @click.outside="showBaEditModal = false"
                        class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl"
                    >
                        <div class="mb-5 flex items-start justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">
                                    Edit Business Area
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    Perbarui data Business Area dan DAOP/DIVRE.
                                </p>
                            </div>

                            <button
                                type="button"
                                @click="showBaEditModal = false"
                                class="rounded-lg p-1.5 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600"
                                aria-label="Tutup modal"
                            >
                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>

                        <template x-if="baEditItem">
                            <form
                                method="POST"
                                :action="`/master-business-area/${baEditItem.id}`"
                                class="space-y-4"
                            >
                                @csrf
                                @method('PUT')

                                <div>
                                    <label class="mb-1 block text-sm font-medium text-gray-700">
                                        Kode Business Area
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="kode"
                                        x-model="baEditItem.kode"
                                        required
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                    >
                                </div>

                                <div>
                                    <label class="mb-1 block text-sm font-medium text-gray-700">
                                        DAOP / DIVRE
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="daop_divre"
                                        x-model="baEditItem.daop_divre"
                                        required
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                    >
                                </div>

                                <div class="flex justify-end gap-2 border-t border-gray-100 pt-4">
                                    <button
                                        type="button"
                                        @click="showBaEditModal = false"
                                        class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                                    >
                                        Batal
                                    </button>

                                    <button
                                        type="submit"
                                        class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
                                    >
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </template>
                    </div>
                </div>

            </div>
        </section>
    </div>
</div>

@include('components.availability-confirm-modal')



@endsection
