@extends('layouts.app')

@section('title', 'Availability System Ticketing')

@section('content')

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


    {{-- HEADER --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Availability System Ticketing
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Kelola laporan availability perangkat ticketing setiap stasiun.
            </p>
        </div>


        <a
            href="{{ route('form-availability.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:border-gray-400 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200"
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
                    d="M12 4v16m8-8H4"
                />
            </svg>

            Buat Form Baru
        </a>

    </div>


    {{-- FLASH MESSAGE --}}
    @if (session('success'))
        <div x-data="{ show: true, percent: 100 }"
             x-init="
                let duration = 5000;
                let interval = 50;
                let step = (interval / duration) * 100;
                let timer = setInterval(() => {
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
             class="relative flex items-center gap-3 rounded-xl border border-emerald-100 bg-[#f0fdf4] p-4 text-emerald-800 shadow-sm transition-all mb-6"
        >
            <!-- SUCCESS ICON -->
            <div class="w-10 h-10 bg-[#dcfce7] rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-[#059669]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <!-- MESSAGE CONTENT -->
            <div class="flex-1 flex flex-col">
                <h4 class="text-sm font-bold text-[#065f46] mb-0.5">Berhasil!</h4>
                <span class="text-[13px] font-medium text-[#059669]">
                    {{ session('success') }}
                </span>
            </div>

            <!-- TIMER PROGRESS & CLOSE BUTTON -->
            <div class="flex items-center gap-3 shrink-0">
                <!-- CIRCULAR TIMER SVG -->
                <div class="relative w-6 h-6">
                    <!-- BACKGROUND RING -->
                    <svg class="w-6 h-6 transform -rotate-90">
                        <circle cx="12" cy="12" r="9" stroke="#bbf7d0" stroke-width="2" fill="transparent" />
                        <circle cx="12" cy="12" r="9" stroke="#059669" stroke-width="2" fill="transparent"
                                stroke-dasharray="56.54"
                                :stroke-dashoffset="56.54 - (56.54 * percent / 100)"
                                stroke-linecap="round"
                                class="transition-all duration-75 ease-linear"
                        />
                    </svg>
                </div>

                <!-- CLOSE BUTTON -->
                <button @click="show = false" class="text-[#10b981] hover:text-[#047857] transition-colors p-1 rounded-md hover:bg-[#dcfce7]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if ($errors->any() || session('error'))
        <div x-data="{ show: true, percent: 100 }"
             x-init="
                let duration = 5000;
                let interval = 50;
                let step = (interval / duration) * 100;
                let timer = setInterval(() => {
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
             class="relative flex items-center gap-3 rounded-xl border border-red-100 bg-[#fef2f2] p-4 text-red-800 shadow-sm transition-all mb-6"
        >
            <!-- ERROR ICON -->
            <div class="w-10 h-10 bg-[#fee2e2] rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-[#dc2626]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <!-- MESSAGE CONTENT -->
            <div class="flex-1 flex flex-col">
                <h4 class="text-sm font-bold text-[#991b1b] mb-0.5">Gagal!</h4>
                <span class="text-[13px] font-medium text-[#dc2626]">
                    {{ session('error') ?? $errors->first() }}
                </span>
            </div>

            <!-- TIMER PROGRESS & CLOSE BUTTON -->
            <div class="flex items-center gap-3 shrink-0">
                <!-- CIRCULAR TIMER SVG -->
                <div class="relative w-6 h-6">
                    <!-- BACKGROUND RING -->
                    <svg class="w-6 h-6 transform -rotate-90">
                        <circle cx="12" cy="12" r="9" stroke="#fecaca" stroke-width="2" fill="transparent" />
                        <circle cx="12" cy="12" r="9" stroke="#dc2626" stroke-width="2" fill="transparent"
                                stroke-dasharray="56.54"
                                :stroke-dashoffset="56.54 - (56.54 * percent / 100)"
                                stroke-linecap="round"
                                class="transition-all duration-75 ease-linear"
                        />
                    </svg>
                </div>

                <!-- CLOSE BUTTON -->
                <button @click="show = false" class="text-[#f87171] hover:text-[#dc2626] transition-colors p-1 rounded-md hover:bg-[#fee2e2]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif


    {{-- Tab Switcher --}}
    <div x-data="{ tab: '{{ request()->has('signer_page') ? 'signer' : 'forms' }}' }" class="space-y-6">
        <div class="flex gap-1 bg-gray-100 rounded-xl p-1 w-fit border border-gray-200">
            <button @click="tab = 'forms'" :class="tab === 'forms' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">Daftar Formulir</button>
            <button @click="tab = 'signer'" :class="tab === 'signer' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">Master Signer</button>
        </div>

        {{-- TAB: Daftar Formulir --}}
        <div x-show="tab === 'forms'" class="space-y-6">

            {{-- SEARCH DAN JUMLAH DATA --}}
            <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">

                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <form
                id="availabilitySearchForm"
                action="{{ route('form-availability.index') }}"
                method="GET"
                class="flex w-full max-w-xl items-center gap-2"
            >

                <div class="relative flex-1">

                    {{-- ICON SEARCH --}}
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


                    {{-- INPUT SEARCH --}}
                    <input
                        type="text"
                        id="availabilitySearchInput"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari no. referensi, business area, atau DAOP..."
                        autocomplete="off"
                        class="w-full rounded-lg border border-gray-300 py-2.5 pl-10 pr-11 text-sm text-gray-900 outline-none transition focus:border-gray-400 focus:ring-2 focus:ring-gray-100"
                    >


                    {{-- LOADING SEARCH --}}
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


                {{-- RESET --}}
                <button
                    type="button"
                    id="availabilityResetSearch"
                    class="{{ request('search') ? '' : 'hidden' }} rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                >
                    Reset
                </button>

            </form>


            {{-- TOTAL DATA --}}
            <div class="whitespace-nowrap text-sm text-gray-500">

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


    {{-- HASIL TABEL UNTUK LIVE SEARCH --}}
    <div id="availabilityTableResult">

        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="overflow-x-auto rounded-xl">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">

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

                            <th class="w-32 px-4 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-gray-600"></th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100 bg-white">

                        @forelse ($forms as $form)

                                <tr
                                    data-availability-row-url="{{ route(
                                        'form-availability.show',
                                        $form
                                    ) }}"
                                    tabindex="0"
                                    role="link"
                                    aria-label="Lihat detail laporan {{ $form->no_ref ?: $form->id }}"
                                    class="cursor-pointer transition hover:bg-gray-50 focus:bg-gray-50 focus:outline-none"
                                >

                                {{-- NOMOR --}}
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-500">
                                    {{ $forms->firstItem() + $loop->index }}
                                </td>


                                {{-- NO REFERENSI --}}
                                <td class="whitespace-nowrap px-5 py-4">

                                    <div class="font-semibold text-gray-900">
                                        {{ $form->no_ref ?: '-' }}
                                    </div>

                                    <div class="mt-1 text-xs text-gray-400">
                                        Dibuat
                                        {{ $form->created_at?->format('d M Y, H:i') }}
                                    </div>

                                </td>


                                {{-- TANGGAL --}}
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-700">
                                    {{ $form->tanggal?->format('d M Y') ?: '-' }}
                                </td>


                                {{-- BUSINESS AREA --}}
                                <td class="px-5 py-4 text-sm text-gray-700">
                                    {{ $form->business_area ?: '-' }}
                                </td>


                                {{-- DAOP/DIVRE --}}
                                <td class="px-5 py-4 text-sm text-gray-700">
                                    {{ $form->daop_divre ?: '-' }}
                                </td>


                                {{-- STASIUN --}}
                                <td class="whitespace-nowrap px-5 py-4 text-center">

                                    <span class="inline-flex min-w-9 justify-center rounded-md bg-gray-100 px-2.5 py-1 text-sm font-semibold text-gray-700">
                                        {{ $form->jumlah_total_station ?? 0 }}
                                    </span>

                                </td>


                                {{-- PERANGKAT --}}
                                <td class="whitespace-nowrap px-5 py-4 text-center">

                                    <span class="inline-flex min-w-9 justify-center rounded-md bg-gray-100 px-2.5 py-1 text-sm font-semibold text-gray-700">
                                        {{ $form->jumlah_perangkat_ticketing ?? 0 }}
                                    </span>

                                </td>


                                {{-- STATUS --}}
                                <td class="whitespace-nowrap px-5 py-4 text-center">

                                    @if ($form->status === 'selesai')

                                        <span class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-3 py-1 text-xs font-medium text-gray-600">

                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                            Selesai

                                        </span>

                                    @elseif ($form->status === 'dicetak')

                                        <span class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-3 py-1 text-xs font-medium text-gray-600">

                                            <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>

                                            Dicetak

                                        </span>

                                    @else

                                        <span class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-3 py-1 text-xs font-medium text-gray-600">

                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span>

                                            Draft

                                        </span>

                                    @endif

                                </td>


                                 {{-- AKSI --}}
                                 <td class="w-56 whitespace-nowrap px-4 py-3 text-right">

                                     <div class="flex items-center justify-end gap-1.5">

                                         {{-- EDIT --}}
                                         @if ($form->status === 'draft')
                                             <a
                                                 href="{{ route('form-availability.edit', $form) }}"
                                                 class="text-amber-500 hover:text-amber-700 bg-amber-50 hover:bg-amber-100 h-9 w-9 flex items-center justify-center rounded-lg transition-colors"
                                                 title="Edit"
                                             >
                                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                 </svg>
                                             </a>
                                         @endif

                                         {{-- CETAK PDF --}}
                                         <button
                                             type="button"
                                             data-availability-print-url="{{ route('form-availability.show', $form) }}"
                                             class="text-emerald-600 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 h-9 w-9 flex items-center justify-center rounded-lg transition-colors"
                                             title="Cetak / Lihat PDF"
                                         >
                                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                             </svg>
                                         </button>

                                         {{-- HAPUS --}}
                                         <form
                                             method="POST"
                                             action="{{ route('form-availability.destroy', $form) }}"
                                             data-availability-confirm
                                             data-confirm-type="delete"
                                             data-confirm-title="Hapus Laporan"
                                             data-confirm-message="Laporan {{ $form->no_ref ?: '#' . $form->id }} akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan."
                                             class="inline-block m-0"
                                         >
                                             @csrf
                                             @method('DELETE')
                                             <button
                                                 type="submit"
                                                 class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 h-9 w-9 flex items-center justify-center rounded-lg transition-colors"
                                                 title="Hapus"
                                             >
                                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                 </svg>
                                             </button>
                                         </form>

                                         {{-- LAINNYA DROPDOWN --}}
                                         <div class="inline-flex relative">
                                             <button
                                                 type="button"
                                                 data-availability-action-toggle
                                                 aria-expanded="false"
                                                 class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1.5 text-sm font-medium text-gray-600 transition hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-200"
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

                                             {{-- TEMPLATE DROPDOWN --}}
                                             <template data-availability-action-template>
                                                 <div
                                                     data-availability-action-menu
                                                     class="fixed z-[9999] hidden w-48 overflow-hidden rounded-xl border border-gray-200 bg-white py-1 shadow-xl"
                                                 >
                                                     {{-- UNDUH EXCEL --}}
                                                     <a
                                                         href="{{ route('form-availability.excel', $form) }}"
                                                         class="block px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-50"
                                                     >
                                                         Unduh Excel
                                                     </a>

                                                     {{-- KONFIRMASI SELESAI --}}
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
                                                                 class="block w-full px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-50"
                                                             >
                                                                 Konfirmasi Selesai
                                                             </button>
                                                         </form>
                                                     @endif
                                                 </div>
                                             </template>
                                         </div>

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

                                        {{-- ILUSTRASI EMPTY STATE KHAS KAI --}}
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

                                            {{-- GARIS IDENTITAS KAI --}}
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


                                        {{-- HASIL PENCARIAN KOSONG --}}
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

                                            {{-- DATA BENAR-BENAR BELUM ADA --}}
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


            {{-- PAGINATION --}}
            @if ($forms->hasPages())

                <div class="border-t border-gray-200 bg-gray-50 px-5 py-4">
                    {{ $forms->withQueryString()->links() }}
                </div>

            @endif

        </div>

    </div>

        </div>

        {{-- TAB: Master Signer --}}
        <div x-show="tab === 'signer'" x-data="{
            showAddModal: false,
            editItem: null,
            showEditModal: false,
            showImportModal: false,
        }" class="space-y-6" style="display: none;">
            <div class="flex justify-end gap-2">
                <a href="{{ route('master-signer.template') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-600 border border-gray-300 bg-white hover:bg-gray-50 px-3 py-2 rounded-lg transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Template Excel
                </a>
                <button @click="showImportModal = true" class="inline-flex items-center gap-1.5 text-sm text-gray-600 border border-gray-300 bg-white hover:bg-gray-50 px-3 py-2 rounded-lg transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l4-4m0 0l4 4m-4-4v12"></path></svg>
                    Import Excel
                </button>
                <button @click="showAddModal = true" class="inline-flex items-center gap-1.5 text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg transition-colors font-semibold shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Signer
                </button>
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 w-10">#</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Nama</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">NIPP</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Jabatan</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($masterSigners as $idx => $signer)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-500">{{ $masterSigners->firstItem() + $idx }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-gray-900">{{ $signer->nama }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-700 font-mono">{{ $signer->nipp }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-500">{{ $signer->jabatan ?: '-' }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm">
                                <div class="flex gap-2">
                                    <button @click="editItem = {{ $signer->toJson() }}; showEditModal = true" class="text-yellow-600 hover:text-yellow-800 transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <form method="POST" action="{{ route('master-signer.destroy', $signer) }}" onsubmit="return confirm('Hapus signer ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-5 py-10 text-center text-gray-400">Belum ada data signer</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($masterSigners->hasPages())
                <div class="border border-gray-200 rounded-xl bg-gray-50 px-5 py-4 shadow-sm">
                    {{ $masterSigners->links() }}
                </div>
            @endif

            {{-- Add Modal --}}
            <div x-show="showAddModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;">
                <div @click.outside="showAddModal = false" class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Tambah Signer</h3>
                    <form method="POST" action="{{ route('master-signer.store') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" required placeholder="Contoh: Budi Santoso" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIPP <span class="text-red-500">*</span></label>
                            <input type="text" name="nipp" required placeholder="Contoh: 51324" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                            <input type="text" name="jabatan" placeholder="Contoh: Senior Manager Sistem Informasi" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" @click="showAddModal = false" class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                            <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Edit Modal --}}
            <div x-show="showEditModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;">
                <div @click.outside="showEditModal = false" class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Edit Signer</h3>
                    <template x-if="editItem">
                        <form method="POST" :action="`/master-signer/${editItem.id}`" class="space-y-4">
                            @csrf @method('PUT')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama <span class="text-red-500">*</span></label>
                                <input type="text" name="nama" :value="editItem.nama" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">NIPP <span class="text-red-500">*</span></label>
                                <input type="text" name="nipp" :value="editItem.nipp" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                                <input type="text" name="jabatan" :value="editItem.jabatan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" @click="showEditModal = false" class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                                <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">Perbarui</button>
                            </div>
                        </form>
                    </template>
                </div>
            </div>

            {{-- Import Modal --}}
            <div x-show="showImportModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;">
                <div @click.outside="showImportModal = false" class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Import Data Signer</h3>
                    <form method="POST" action="{{ route('master-signer.import') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">File Excel (.xlsx, .xls, .csv)</label>
                            <input type="file" name="file" accept=".xlsx,.xls,.csv" required class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-gray-400 mt-1">Download <a href="{{ route('master-signer.template') }}" class="text-blue-600 underline">template Excel</a> untuk format yang benar</p>
                        </div>
                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" @click="showImportModal = false" class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                            <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>

@include('components.availability-confirm-modal')
@endsection


