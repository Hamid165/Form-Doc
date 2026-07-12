@extends('layouts.app')

@section('title', 'Detail Availability System Ticketing')

@section('content')

<div class="mx-auto w-full max-w-[210mm]">

    {{-- KEMBALI --}}
    <a
        href="{{ route('form-availability.index') }}"
        class="no-print mb-4 inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-gray-900"
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


    {{-- HEADER HALAMAN --}}
    <div
        class="no-print mb-5 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between"
    >

        {{-- JUDUL --}}
        <div class="min-w-0">

            <h1 class="text-2xl font-bold leading-tight text-gray-900">
                Detail Availability System Ticketing
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Lihat, cetak, atau perbarui laporan availability
                system ticketing.
            </p>

        </div>


        {{-- MENU LAINNYA --}}
        <details class="group relative shrink-0">

            <summary
                class="flex cursor-pointer list-none items-center gap-1.5 rounded-md px-2 py-1.5 text-sm font-medium text-gray-600 transition hover:bg-gray-100 hover:text-gray-900"
            >
                Lainnya

                <svg
                    class="h-4 w-4 transition-transform group-open:rotate-180"
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
            </summary>


            {{-- ISI DROPDOWN --}}
            <div
                class="absolute right-0 z-50 mt-2 w-52 overflow-hidden rounded-lg border border-gray-200 bg-white py-1 shadow-lg"
            >

                {{-- BUAT FORM BARU --}}
                <a
                    href="{{ route('form-availability.create') }}"
                    class="block px-4 py-2.5 text-sm text-gray-700 transition hover:bg-gray-50 hover:text-gray-900"
                >
                    Buat Form Baru
                </a>


                {{-- EDIT FORM --}}
                @if ($form_availability->isDraft())

                    <a
                        href="{{ route(
                            'form-availability.edit',
                            $form_availability
                        ) }}"
                        class="block px-4 py-2.5 text-sm text-gray-700 transition hover:bg-gray-50 hover:text-gray-900"
                    >
                        Edit Form
                    </a>

                @endif


                <div class="my-1 border-t border-gray-100"></div>


                {{-- CETAK PDF --}}
                <button
                    type="button"
                    onclick="window.printAvailabilityReport()"
                    class="block w-full px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-50 hover:text-gray-900"
                >
                    Cetak PDF
                </button>


                {{-- UNDUH EXCEL --}}
                <a
                    href="{{ route(
                        'form-availability.excel',
                        $form_availability
                    ) }}"
                    class="block px-4 py-2.5 text-sm text-gray-700 transition hover:bg-gray-50 hover:text-gray-900"
                >
                    Unduh Excel
                </a>


                {{-- KONFIRMASI SELESAI --}}
                @if (!$form_availability->isSelesai())

                    <div class="my-1 border-t border-gray-100"></div>

                    <form
                        method="POST"
                        action="{{ route(
                            'form-availability.confirm',
                            $form_availability
                        ) }}"
                        data-availability-confirm
                        data-confirm-type="complete"
                        data-confirm-title="Konfirmasi Selesai"
                        data-confirm-message="Laporan {{ $form_availability->no_ref ?: '#' . $form_availability->id }} akan ditandai sebagai selesai. Lanjutkan?"
                    >
                        @csrf
                        @method('PATCH')

                        <button
                            type="submit"
                            class="block w-full px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-50 hover:text-gray-900"
                        >
                            Konfirmasi Selesai
                        </button>
                    </form>

                @endif

                <div class="my-1 border-t border-gray-100"></div>


                {{-- HAPUS FORM --}}
                <form
                    method="POST"
                    action="{{ route(
                        'form-availability.destroy',
                        $form_availability
                    ) }}"
                    data-availability-confirm
                    data-confirm-type="delete"
                    data-confirm-title="Hapus Laporan"
                    data-confirm-message="Laporan {{ $form_availability->no_ref ?: '#' . $form_availability->id }} akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan."
                >
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="block w-full px-4 py-2.5 text-left text-sm text-red-600 transition hover:bg-red-50"
                    >
                        Hapus Form
                    </button>
                </form>

            </div>

        </details>

    </div>


    {{-- NOTIFIKASI BERHASIL --}}
    @if (session('success'))

        <div
            class="no-print mb-5 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-800"
        >
            {{ session('success') }}
        </div>

    @endif


    {{-- NOTIFIKASI ERROR --}}
    @if ($errors->any())

        <div
            class="no-print mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800"
        >
            {{ $errors->first() }}
        </div>

    @endif


    {{-- DOKUMEN --}}
    <article class="availability-report">

        {{-- HEADER DOKUMEN --}}
        <table class="document-header-table">

            <tbody>

                <tr>

                    <td
                        rowspan="4"
                        class="document-logo-cell"
                    >
                        <img
                            src="{{ asset('images/logo-kai.svg') }}"
                            alt="Logo KAI"
                        >
                    </td>


                    <td
                        rowspan="2"
                        class="document-company-cell"
                    >
                        PT KERETA API INDONESIA (PERSERO)

                        <br>

                        SISTEM INFORMASI
                    </td>


                    <td class="document-meta-label">
                        No. Dokumen
                    </td>

                    <td class="document-meta-value">
                        : FR.SM/TI/031.004/01-2019
                    </td>

                </tr>


                <tr>

                    <td class="document-meta-label">
                        Tanggal
                    </td>

                    <td class="document-meta-value">
                        : 09 Januari 2019
                    </td>

                </tr>


                <tr>

                    <td
                        rowspan="2"
                        class="document-title-cell"
                    >
                        FORMULIR AVAILABILITY SYSTEM TICKETING
                    </td>

                    <td class="document-meta-label">
                        Versi
                    </td>

                    <td class="document-meta-value">
                        : 001-2019
                    </td>

                </tr>


                <tr>

                    <td class="document-meta-label">
                        Halaman
                    </td>

                    <td class="document-meta-value">
                        : 1 dari 1
                    </td>

                </tr>

            </tbody>

        </table>


        {{-- INFORMASI REFERENSI --}}
        <table class="reference-table">

            <tbody>

                <tr>

                    <td>
                        No Ref
                    </td>

                    <td>
                        :
                    </td>

                    <td>
                        {{ $form_availability->no_ref ?: '-' }}
                    </td>

                </tr>


                <tr>

                    <td>
                        Tanggal
                    </td>

                    <td>
                        :
                    </td>

                    <td>
                        {{ $form_availability->tanggal?->format('d/m/Y') ?: '-' }}
                    </td>

                </tr>


                <tr>

                    <td>
                        Business Area
                    </td>

                    <td>
                        :
                    </td>

                    <td>
                        {{ $form_availability->business_area ?: '-' }}
                    </td>

                </tr>

            </tbody>

        </table>


        {{-- JUDUL LAPORAN --}}
        <h2 class="availability-report-title">
            LAPORAN AVAILABILITY SYSTEM TICKETING
        </h2>


        {{-- RINGKASAN --}}
        <table class="summary-table">

            <tbody>

                <tr>

                    <td>
                        TANGGAL
                    </td>

                    <td>
                        :
                    </td>

                    <td>
                        {{ $form_availability->tanggal?->format('d/m/Y') ?: '-' }}
                    </td>

                </tr>


                <tr>

                    <td>
                        DAOP/DIVRE
                    </td>

                    <td>
                        :
                    </td>

                    <td>
                        {{ strtoupper(
                            $form_availability->daop_divre ?: '-'
                        ) }}
                    </td>

                </tr>


                <tr>

                    <td>
                        JUMLAH TOTAL STASIUN DI DAERAH
                    </td>

                    <td>
                        :
                    </td>

                    <td>
                        {{ $form_availability->jumlah_total_station ?? 0 }}
                    </td>

                </tr>


                <tr>

                    <td>
                        JUMLAH TOTAL PERANGKAT TICKETING DI DAERAH
                    </td>

                    <td>
                        :
                    </td>

                    <td>
                        {{ $form_availability->jumlah_perangkat_ticketing ?? 0 }}
                    </td>

                </tr>

            </tbody>

        </table>


        {{-- DETAIL AVAILABILITY --}}
        <table class="availability-document-table">

            <thead>

                <tr>

                    <th
                        rowspan="2"
                        class="doc-col-number"
                    >
                        NO
                    </th>

                    <th
                        rowspan="2"
                        class="doc-col-station"
                    >
                        STASIUN
                    </th>

                    <th
                        rowspan="2"
                        class="doc-col-rts"
                    >
                        RTS/RTS NG
                    </th>

                    <th
                        rowspan="2"
                        class="doc-col-device"
                    >
                        JUMLAH PERANGKAT TICKETING
                    </th>

                    <th colspan="2">
                        GANGGUAN
                    </th>

                    <th
                        rowspan="2"
                        class="doc-col-note"
                    >
                        KETERANGAN
                    </th>

                </tr>


                <tr>

                    <th class="doc-col-disturbance">
                        JUMLAH
                    </th>

                    <th class="doc-col-duration">
                        LAMA GANGGUAN (MENIT)
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse ($form_availability->items as $item)

                    <tr>

                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>


                        <td>
                            {{ $item->station ?: '-' }}
                        </td>


                        <td class="text-center">
                            {{ $item->rts_pts_ng ?: '-' }}
                        </td>


                        <td class="text-center">
                            {{ $item->jumlah_perangkat_ticketing ?? 0 }}
                        </td>


                        <td class="text-center">
                            {{ ($item->jumlah_gangguan ?? 0) > 0
                                ? $item->jumlah_gangguan
                                : '-' }}
                        </td>


                        <td class="text-center">
                            {{ ($item->lama_gangguan ?? 0) > 0
                                ? $item->lama_gangguan
                                : '-' }}
                        </td>


                        <td class="whitespace-pre-line">
                            {{ $item->keterangan ?: 'Nihil' }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="7"
                            class="text-center"
                        >
                            Tidak ada data.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>


        {{-- CATATAN --}}
        <div class="document-notes">

            <strong>
                KETERANGAN:
            </strong>

            <div class="whitespace-pre-line">
                {{ $form_availability->catatan ?: '-' }}
            </div>

        </div>


        {{-- FOOTER DOKUMEN --}}
        <div class="document-footer">

            {{-- PETUNJUK --}}
            <div class="document-instructions">

                <p>
                    LAPORAN DIKIRIM SETIAP HARI JAM 10.00
                </p>

                <p>
                    YANG DILAPORKAN KEJADIAN MULAI
                    JAM 00.00 S/D 23.59
                </p>

                <p>
                    KIRIM VIA EMAIL KE HELP DESK
                    (it.helpdesk@kai.id)
                </p>

                <p>
                    PERANGKAT TICKETING MENCAKUP
                    PC, SCANNER, PRINTER, DLL
                </p>

                <p>
                    TERMASUK PADA LOKET, CIC,
                    BOARDING, OA, CS, OPERATOR
                </p>

            </div>


            {{-- TANDA TANGAN --}}
            <div class="document-signature">

                <p class="signature-place-date">

                    {{ $form_availability->daop_divre
                        ?: '................' }},

                    {{ $form_availability->tanggal?->format('d/m/Y')
                        ?: '................' }}

                </p>


                <p class="signature-title">

                    MENGETAHUI

                    <br>

                    {{ strtoupper(
                        $form_availability->mengetahui?->jabatan
                        ?: 'SENIOR MANAGER/MANAGER/JM/ASMEN'
                    ) }}

                </p>


                {{-- RUANG TANDA TANGAN --}}
                <div class="signature-space"></div>


                {{-- IDENTITAS PEJABAT --}}
                <div class="signature-identity">

                    <div class="signature-person-name">

                        {{ $form_availability->mengetahui?->nama
                            ?: '-' }}

                    </div>


                    <div class="signature-nipp">

                        NIPP.

                        {{ $form_availability->mengetahui?->nipp
                            ?: '-' }}

                    </div>

                </div>

            </div>

        </div>


        {{-- DATA PETUGAS --}}
        @if (
            $form_availability->petugas_name ||
            $form_availability->petugas_nipp
        )

            <div class="document-officer">

                Petugas:

                {{ $form_availability->petugas_name ?: '-' }}

                @if ($form_availability->petugas_nipp)

                    — NIPP

                    {{ $form_availability->petugas_nipp }}

                @endif

            </div>

        @endif

    </article>

</div>

@include('components.availability-confirm-modal')

@endsection
