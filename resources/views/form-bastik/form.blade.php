@php
    $currentUser = auth()->user()
        ?? \App\Models\User::where('role', 'petugas')->first();

    $businessAreaMap = config(
        'bastik.business_areas',
        []
    );

    $kotaOptions = config(
        'bastik.signing_cities',
        []
    );

    /*
     * Gunakan unit kerja user jika sama dengan daftar Business Area.
     * Jika tidak cocok, gunakan Kantor Pusat Bandung sebagai default.
     */
    $defaultBusinessArea = array_key_exists(
        $currentUser->unit_kerja ?? '',
        $businessAreaMap
    )
        ? $currentUser->unit_kerja
        : 'B060';

    $selectedBusinessArea = old(
        'business_area',
        isset($bastik)
            ? $bastik->business_area
            : $defaultBusinessArea
    );

    $selectedKota = old(
        'kota',
        isset($bastik)
            ? $bastik->kota
            : (
                $businessAreaMap[$selectedBusinessArea]
                ?? 'Yogyakarta'
            )
    );
@endphp


{{-- NOTIFIKASI ERROR --}}
@if ($errors->any())
    <div
        class="
            mb-6
            rounded-xl
            border border-red-300
            bg-red-50
            px-4 py-4
            shadow-sm
        "
    >
        <div class="flex items-start gap-3">
            <svg
                class="
                    mt-0.5
                    h-5 w-5
                    flex-shrink-0
                    text-red-600
                "
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"
                />
            </svg>

            <div>
                <p class="text-sm font-bold text-red-700">
                    Data gagal disimpan
                </p>

                <p class="mt-1 text-xs text-red-600">
                    Periksa kembali data dan lampiran berikut:
                </p>

                <ul
                    class="
                        mt-2
                        list-disc
                        space-y-1
                        pl-5
                        text-sm
                        text-red-700
                    "
                >
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif


{{-- SECTION 1: HEADER INFORMASI --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">

    <div class="flex items-center justify-between mb-5">
        <h2 class="text-base font-bold text-gray-800 flex items-center gap-2">

            <span
                class="
                    w-6 h-6
                    bg-blue-100
                    rounded-full
                    flex items-center
                    justify-center
                    text-blue-600
                    text-xs
                    font-bold
                "
            >
                1
            </span>

            Informasi Formulir
        </h2>

        <span
            class="
                bg-yellow-100
                text-yellow-800
                text-xs
                font-bold
                px-3 py-1
                rounded-full
                uppercase
                tracking-wider
            "
        >
            TERBATAS
        </span>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

        {{-- Nomor Surat --}}
        <div>
            <label
                class="
                    block
                    text-sm
                    font-medium
                    text-gray-700
                    mb-1.5
                "
            >
                Nomor Surat
            </label>

            <input
                type="text"
                name="nomor_surat"
                value="{{ old(
                    'nomor_surat',
                    isset($bastik)
                        ? $bastik->nomor_surat
                        : 'FR.SM/TI/031.005/02-2023'
                ) }}"
                class="
                    w-full
                    border border-gray-300
                    bg-gray-50
                    rounded-lg
                    px-3 py-2
                    text-sm
                    text-gray-500
                    focus:outline-none
                "
                readonly
            >
        </div>


        {{-- Tanggal --}}
        <div>
            <label
                class="
                    block
                    text-sm
                    font-medium
                    text-gray-700
                    mb-1.5
                "
            >
                Tanggal Terbit
            </label>

            <input
                type="date"
                name="tanggal_surat"
                id="tanggal_surat"
                value="{{ old(
                    'tanggal_surat',
                    isset($bastik)
                        ? $bastik->tanggal_surat
                        : date('Y-m-d')
                ) }}"
                class="
                    w-full
                    border border-gray-300
                    rounded-lg
                    px-3 py-2
                    text-sm
                    focus:outline-none
                    focus:ring-2
                    focus:ring-blue-500
                "
                required
            >
        </div>


        {{-- Business Area --}}
        <div>
            <label
                for="business_area"
                class="
                    block
                    text-sm
                    font-medium
                    text-gray-700
                    mb-1.5
                "
            >
                Business Area
            </label>

            <select
                id="business_area"
                name="business_area"
                class="
                    w-full
                    border border-gray-300
                    rounded-lg
                    px-3 py-2
                    text-sm
                    bg-white
                    focus:outline-none
                    focus:ring-2
                    focus:ring-blue-500
                "
                required
            >

                <option value="">
                    -- Pilih Business Area --
                </option>

                @foreach($businessAreaMap as $code => $defaultKota)

                    <option
                        value="{{ $code }}"
                        {{
                            $selectedBusinessArea === $code
                                ? 'selected'
                                : ''
                        }}
                    >
                        {{ $code }}
                    </option>

                @endforeach

            </select>

            <p class="mt-1 text-xs text-gray-400">
                Pilih wilayah kerja yang menerbitkan BASTIK.
            </p>
        </div>


        {{-- Kota --}}
        <div>
            <label
                for="kota"
                class="
                    block
                    text-sm
                    font-medium
                    text-gray-700
                    mb-1.5
                "
            >
                Kota Tanda Tangan
            </label>

            <select
                id="kota"
                name="kota"
                class="
                    w-full
                    border border-gray-300
                    rounded-lg
                    px-3 py-2
                    text-sm
                    bg-white
                    focus:outline-none
                    focus:ring-2
                    focus:ring-blue-500
                "
                required
            >

                <option value="">
                    -- Pilih Kota Tanda Tangan --
                </option>

                @foreach($kotaOptions as $kota)

                    <option
                        value="{{ $kota }}"
                        {{
                            $selectedKota === $kota
                                ? 'selected'
                                : ''
                        }}
                    >
                        {{ $kota }}
                    </option>

                @endforeach

            </select>

            <p class="mt-1 text-xs text-gray-400">
                Kota akan disarankan berdasarkan Business Area.
            </p>
        </div>

    </div>
</div>



{{-- SECTION 2: PETUGAS & PENANDATANGAN --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">

    <h2 class="text-base font-bold text-gray-800 mb-5 flex items-center gap-2">

        <span
            class="
                w-6 h-6
                bg-blue-100
                rounded-full
                flex items-center
                justify-center
                text-blue-600
                text-xs
                font-bold
            "
        >
            2
        </span>

        Petugas & Penandatangan
    </h2>


    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

        <div>
            <label
                class="
                    block
                    text-sm
                    font-medium
                    text-gray-700
                    mb-1.5
                "
            >
                Petugas Service Desk
            </label>

            <input
                type="text"
                value="{{ $currentUser->name ?? '-' }}"
                class="
                    w-full
                    border border-gray-200
                    bg-gray-50
                    rounded-lg
                    px-3 py-2
                    text-sm
                    text-gray-500
                    focus:outline-none
                "
                readonly
            >
        </div>


        <div>
            <label
                class="
                    block
                    text-sm
                    font-medium
                    text-gray-700
                    mb-1.5
                "
            >
                NIPP/NIPKWT Petugas
            </label>

            <input
                type="text"
                value="{{ $currentUser->nip_kwt ?? '-' }}"
                class="
                    w-full
                    border border-gray-200
                    bg-gray-50
                    rounded-lg
                    px-3 py-2
                    text-sm
                    text-gray-500
                    focus:outline-none
                "
                readonly
            >
        </div>


        <div class="md:col-span-2">

            <label
                class="
                    block
                    text-sm
                    font-medium
                    text-gray-700
                    mb-1.5
                "
            >
                Mengetahui (Pejabat)
            </label>

            <select
                name="pimpinan_id"
                class="
                    w-full
                    border border-gray-300
                    rounded-lg
                    px-3 py-2
                    text-sm
                    focus:outline-none
                    focus:ring-2
                    focus:ring-blue-500
                    bg-white
                "
                required
            >

                <option value="">
                    -- Pilih Pimpinan / Pejabat --
                </option>

                @foreach($signers as $signer)

                    <option
                        value="{{ $signer->id }}"
                        {{
                            old(
                                'pimpinan_id',
                                isset($bastik)
                                    ? $bastik->pimpinan_id
                                    : ''
                            ) == $signer->id
                                ? 'selected'
                                : ''
                        }}
                    >
                        {{ $signer->nama }}
                        —
                        {{ $signer->jabatan }}
                    </option>

                @endforeach

            </select>

        </div>

    </div>
</div>



{{-- DATALIST UNIT --}}
<datalist id="unit_list">
    <option value="Daop 1 Jakarta">
    <option value="Daop 2 Bandung">
    <option value="Daop 3 Cirebon">
    <option value="Daop 4 Semarang">
    <option value="Daop 5 Purwokerto">
    <option value="Daop 6 Yogyakarta">
    <option value="Daop 7 Madiun">
    <option value="Daop 8 Surabaya">
    <option value="Daop 9 Jember">

    <option value="Divre I Sumatera Utara">
    <option value="Divre II Sumatera Barat">
    <option value="Divre III Palembang">
    <option value="Divre IV Tanjungkarang">

    <option value="Kantor Pusat Bandung">
</datalist>



{{-- SECTION 3: DETAIL TIKET --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">

    <div class="flex items-center justify-between mb-5">

        <h2 class="text-base font-bold text-gray-800 flex items-center gap-2">

            <span
                class="
                    w-6 h-6
                    bg-blue-100
                    rounded-full
                    flex items-center
                    justify-center
                    text-blue-600
                    text-xs
                    font-bold
                "
            >
                3
            </span>

            Daftar Tiket Ditutup
        </h2>


        <div class="flex gap-2">

            <a
                href="{{ route('form-bastik.template-items') }}"
                class="
                    text-xs
                    text-blue-600
                    hover:text-blue-800
                    flex
                    items-center
                    gap-1
                    border
                    border-blue-200
                    px-3
                    py-1.5
                    rounded-lg
                    hover:bg-blue-50
                    transition
                "
            >

                <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                    ></path>
                </svg>

                Template Excel
            </a>


            <button
                type="button"
                onclick="openExcelModal()"
                class="
                    text-xs
                    bg-emerald-50
                    text-emerald-600
                    hover:bg-emerald-100
                    border
                    border-emerald-200
                    px-3
                    py-1.5
                    rounded-lg
                    flex
                    items-center
                    gap-1
                    transition
                    font-medium
                "
            >

                <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                    ></path>
                </svg>

                Import Excel

            </button>

        </div>

    </div>


    <p class="text-sm text-gray-500 mb-6">
        Masukkan tiket-tiket incident/work order yang telah
        dikonfirmasi namun tidak mendapat respon dari user pemohon.
    </p>



    {{-- PERSIAPAN DATA TIKET --}}
    @php

        /*
         * Prioritas data:
         *
         * 1. old('items')
         *    Digunakan ketika submit gagal validasi.
         *
         * 2. $bastik->items
         *    Digunakan ketika edit draft.
         *
         * 3. Baris kosong
         *    Digunakan ketika create baru.
         */

        if (old('items') !== null) {

            $formItems = old('items');

        } elseif (
            isset($bastik)
            && $bastik->items
            && $bastik->items->count() > 0
        ) {

            $formItems = $bastik->items
                ->map(function ($item) {

                    return [
                        'no_tiket' =>
                            $item->no_tiket,

                        'user_pemohon' =>
                            $item->user_pemohon,

                        'nipp' =>
                            $item->nipp,

                        'unit' =>
                            $item->unit,

                        'detail_tiket' =>
                            $item->detail_tiket,
                    ];

                })
                ->values()
                ->toArray();

        } else {

            $formItems = [
                [
                    'no_tiket' => 'INC' . sprintf('%06d', rand(100000, 999999)),
                    'user_pemohon' => '',
                    'nipp' => '',
                    'unit' => '',
                    'detail_tiket' => '',
                ]
            ];
        }

    @endphp



    {{-- CONTAINER TIKET --}}
    <div
        id="tickets-container"
        class="space-y-4"
    >

        @foreach($formItems as $index => $item)

            <div
                class="
                    ticket-row
                    border
                    border-gray-200
                    rounded-xl
                    p-4
                    relative
                    bg-gray-50
                "
                data-index="{{ $index }}"
            >


                {{-- HAPUS BARIS --}}
                <button
                    type="button"
                    onclick="removeRow(this)"
                    style="
                        right: 12px;
                        top: 12px;
                    "
                    class="
                        absolute
                        text-red-400
                        hover:text-red-600
                        transition-colors
                        btn-hapus-baris
                    "
                    title="Hapus Item"
                >

                    <svg
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        ></path>
                    </svg>

                </button>



                <div
                    class="
                        grid
                        grid-cols-1
                        md:grid-cols-2
                        gap-4
                        pr-6
                    "
                >


                    {{-- NO TIKET --}}
                    <div>

                        <label
                            class="
                                block
                                text-xs
                                font-medium
                                text-gray-600
                                mb-1
                            "
                        >
                            No Tiket
                        </label>

                        <input
                            type="text"
                            name="items[{{ $index }}][no_tiket]"
                            value="{{ $item['no_tiket'] ?? '' }}"
                            class="
                                w-full
                                border
                                border-gray-300
                                rounded-lg
                                px-3
                                py-2
                                text-sm
                                focus:outline-none
                                focus:ring-2
                                focus:ring-blue-500
                                font-mono
                            "
                            placeholder="INC00xxx"
                            required
                        >

                    </div>



                    {{-- USER PEMOHON --}}
                    <div>

                        <label
                            class="
                                block
                                text-xs
                                font-medium
                                text-gray-600
                                mb-1
                            "
                        >
                            User Pemohon
                        </label>

                        <input
                            type="text"
                            name="items[{{ $index }}][user_pemohon]"
                            value="{{ $item['user_pemohon'] ?? '' }}"
                            class="
                                w-full
                                border
                                border-gray-300
                                rounded-lg
                                px-3
                                py-2
                                text-sm
                                focus:outline-none
                                focus:ring-2
                                focus:ring-blue-500
                            "
                            placeholder="Nama User"
                            required
                        >

                    </div>



                    {{-- NIPP --}}
                    <div>

                        <label
                            class="
                                block
                                text-xs
                                font-medium
                                text-gray-600
                                mb-1
                            "
                        >
                            NIPP
                        </label>

                        <input
                            type="text"
                            name="items[{{ $index }}][nipp]"
                            value="{{ $item['nipp'] ?? '' }}"
                            class="
                                w-full
                                border
                                border-gray-300
                                rounded-lg
                                px-3
                                py-2
                                text-sm
                                focus:outline-none
                                focus:ring-2
                                focus:ring-blue-500
                            "
                            placeholder="NIPP"
                            required
                        >

                    </div>



                    {{-- UNIT --}}
                    <div>

                        <label
                            class="
                                block
                                text-xs
                                font-medium
                                text-gray-600
                                mb-1
                            "
                        >
                            Unit
                        </label>

                        <input
                            type="text"
                            name="items[{{ $index }}][unit]"
                            value="{{ $item['unit'] ?? '' }}"
                            class="
                                w-full
                                border
                                border-gray-300
                                rounded-lg
                                px-3
                                py-2
                                text-sm
                                focus:outline-none
                                focus:ring-2
                                focus:ring-blue-500
                            "
                            placeholder="Pilih Unit..."
                            list="unit_list"
                            required
                        >

                    </div>



                    {{-- DETAIL TIKET --}}
                    <div class="md:col-span-2">

                        <label
                            class="
                                block
                                text-xs
                                font-medium
                                text-gray-600
                                mb-1
                            "
                        >
                            Detail Tiket
                        </label>

                        <textarea
                            name="items[{{ $index }}][detail_tiket]"
                            rows="2"
                            class="
                                w-full
                                border
                                border-gray-300
                                rounded-lg
                                px-3
                                py-2
                                text-sm
                                focus:outline-none
                                focus:ring-2
                                focus:ring-blue-500
                            "
                            placeholder="Detail masalah tiket..."
                            required
                        >{{ $item['detail_tiket'] ?? '' }}</textarea>

                    </div>



                    {{-- LAMPIRAN --}}
                    <div class="md:col-span-2">

                        <label
                            class="
                                block
                                text-xs
                                font-medium
                                text-gray-600
                                mb-1
                            "
                        >
                            Lampiran Konfirmasi
                        </label>


                        <p
                            class="
                                text-[11px]
                                text-gray-500
                                mb-2
                            "
                        >
                            Maksimal 3 file •
                            Maksimal 10 MB per file •
                            Format:
                            JPG, JPEG, PNG, PDF, DOC, DOCX
                        </p>


                        <div class="flex flex-wrap gap-2">


                            {{-- LAMPIRAN 1 --}}
                            <label
                                class="
                                    cursor-pointer
                                    text-xs
                                    bg-blue-50
                                    text-blue-600
                                    hover:bg-blue-100
                                    px-3
                                    py-1.5
                                    rounded-lg
                                    border
                                    border-blue-200
                                    transition-colors
                                    inline-flex
                                    items-center
                                    gap-1.5
                                "
                            >

                                <input
                                    type="file"
                                    name="items[{{ $index }}][lampiran_1]"
                                    accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                                    onchange="updateFileName(this)"
                                    style="display: none;"
                                >

                                <span class="file-label">
                                    Upload Lampiran 1
                                </span>

                                <span
                                    class="
                                        file-clear
                                        hidden
                                        text-red-500
                                        hover:text-red-700
                                        font-bold
                                        text-sm
                                        ml-1
                                    "
                                    onclick="cancelUpload(event, this)"
                                    title="Batalkan lampiran"
                                >
                                    ×
                                </span>

                            </label>



                            {{-- LAMPIRAN 2 --}}
                            <label
                                class="
                                    cursor-pointer
                                    text-xs
                                    bg-blue-50
                                    text-blue-600
                                    hover:bg-blue-100
                                    px-3
                                    py-1.5
                                    rounded-lg
                                    border
                                    border-blue-200
                                    transition-colors
                                    inline-flex
                                    items-center
                                    gap-1.5
                                "
                            >

                                <input
                                    type="file"
                                    name="items[{{ $index }}][lampiran_2]"
                                    accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                                    onchange="updateFileName(this)"
                                    style="display: none;"
                                >

                                <span class="file-label">
                                    Upload Lampiran 2
                                </span>

                                <span
                                    class="
                                        file-clear
                                        hidden
                                        text-red-500
                                        hover:text-red-700
                                        font-bold
                                        text-sm
                                        ml-1
                                    "
                                    onclick="cancelUpload(event, this)"
                                    title="Batalkan lampiran"
                                >
                                    ×
                                </span>

                            </label>



                            {{-- LAMPIRAN 3 --}}
                            <label
                                class="
                                    cursor-pointer
                                    text-xs
                                    bg-blue-50
                                    text-blue-600
                                    hover:bg-blue-100
                                    px-3
                                    py-1.5
                                    rounded-lg
                                    border
                                    border-blue-200
                                    transition-colors
                                    inline-flex
                                    items-center
                                    gap-1.5
                                "
                            >

                                <input
                                    type="file"
                                    name="items[{{ $index }}][lampiran_3]"
                                    accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                                    onchange="updateFileName(this)"
                                    style="display: none;"
                                >

                                <span class="file-label">
                                    Upload Lampiran 3
                                </span>

                                <span
                                    class="
                                        file-clear
                                        hidden
                                        text-red-500
                                        hover:text-red-700
                                        font-bold
                                        text-sm
                                        ml-1
                                    "
                                    onclick="cancelUpload(event, this)"
                                    title="Batalkan lampiran"
                                >
                                    ×
                                </span>

                            </label>

                        </div>

                    </div>

                </div>

            </div>

        @endforeach

    </div>



    {{-- TAMBAH BARIS --}}
    <button
        type="button"
        onclick="addNewRow()"
        class="
            mt-4
            inline-flex
            items-center
            gap-2
            text-sm
            text-blue-600
            hover:text-blue-800
            border
            border-blue-300
            hover:border-blue-500
            px-4
            py-2
            rounded-lg
            transition-colors
        "
    >

        <svg
            class="w-4 h-4"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 4v16m8-8H4"
            ></path>
        </svg>

        Tambah Baris Tiket

    </button>

</div>



{{-- SUBMIT --}}
<div class="flex justify-end gap-3 mb-10">

    <a
        href="{{ route('form-bastik.index') }}"
        class="
            px-5
            py-2.5
            text-sm
            border
            border-gray-300
            rounded-lg
            hover:bg-gray-50
            transition-colors
            font-medium
            text-gray-700
        "
    >
        Batal
    </a>


    <button
        type="submit"
        name="action"
        value="draft"
        class="
            px-5
            py-2.5
            text-sm
            bg-yellow-500
            hover:bg-yellow-600
            text-white
            rounded-lg
            transition-colors
            font-semibold
            shadow-sm
        "
    >
        Simpan Draft
    </button>


    <button
        type="submit"
        name="action"
        value="generate"
        onclick="
            return confirm(
                'Kirim Berita Acara ini untuk persetujuan Pimpinan?'
            )
        "
        class="
            px-5
            py-2.5
            text-sm
            bg-blue-600
            hover:bg-blue-700
            text-white
            rounded-lg
            transition-colors
            font-semibold
            shadow-sm
        "
    >
        Submit Persetujuan
    </button>

</div>



{{-- MODAL IMPORT EXCEL --}}
<div
    id="excel-modal"
    class="
        fixed
        inset-0
        z-50
        overflow-y-auto
        hidden
    "
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
>

    <div
        class="
            flex
            items-end
            justify-center
            min-h-screen
            pt-4
            px-4
            pb-20
            text-center
            sm:block
            sm:p-0
        "
    >

        <div
            class="
                fixed
                inset-0
                bg-gray-500
                bg-opacity-75
                transition-opacity
            "
            aria-hidden="true"
            onclick="closeExcelModal()"
        ></div>


        <span
            class="
                hidden
                sm:inline-block
                sm:align-middle
                sm:h-screen
            "
            aria-hidden="true"
        >
            &#8203;
        </span>


        <div
            class="
                inline-block
                align-middle
                bg-white
                rounded-xl
                text-left
                overflow-hidden
                shadow-xl
                transform
                transition-all
                sm:my-8
                sm:max-w-lg
                w-full
                border
                border-gray-200
            "
        >

            {{-- HEADER MODAL --}}
            <div
                class="
                    bg-gray-900
                    px-6
                    py-4
                    flex
                    items-center
                    justify-between
                    text-white
                    border-b
                    border-gray-700
                "
            >

                <h3
                    class="
                        text-base
                        font-bold
                        tracking-wider
                    "
                >
                    Import Tiket Dari Excel
                </h3>


                <button
                    type="button"
                    onclick="closeExcelModal()"
                    class="
                        text-gray-400
                        hover:text-white
                        transition
                    "
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



            {{-- BODY MODAL --}}
            <div class="p-6 space-y-4">

                <p class="text-sm text-gray-500">
                    Silakan unggah file Excel
                    (.xlsx / .xls) Anda.
                    Baris tiket yang ada di file Excel
                    akan ditambahkan otomatis ke form.
                </p>


                <div
                    class="
                        bg-amber-50
                        border-l-4
                        border-amber-500
                        p-3
                        rounded-r
                        text-xs
                        text-amber-800
                    "
                >
                    <strong>Penting:</strong>
                    Pastikan format kolom file Excel
                    sama persis dengan template
                    (No Tiket, Detail Tiket,
                    User Pemohon, NIPP, Unit).
                </div>


                <div
                    class="
                        border-2
                        border-dashed
                        border-gray-300
                        rounded-lg
                        p-6
                        text-center
                        hover:border-gray-400
                        transition
                        relative
                    "
                >

                    <input
                        type="file"
                        id="excel-file-input"
                        accept=".xlsx,.xls,.csv"
                        class="
                            absolute
                            inset-0
                            opacity-0
                            cursor-pointer
                            w-full
                            h-full
                        "
                    >


                    <svg
                        class="
                            mx-auto
                            h-8
                            w-8
                            text-gray-400
                            mb-2
                        "
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                        />
                    </svg>


                    <span
                        class="
                            block
                            text-sm
                            font-semibold
                            text-gray-700
                        "
                        id="file-label"
                    >
                        Pilih file Excel...
                    </span>


                    <span
                        class="
                            block
                            text-xs
                            text-gray-400
                            mt-1
                        "
                    >
                        Maksimum ukuran 5 MB
                    </span>

                </div>

            </div>



            {{-- FOOTER MODAL --}}
            <div
                class="
                    px-6
                    py-4
                    bg-gray-50
                    border-t
                    border-gray-200
                    flex
                    justify-end
                    space-x-2
                "
            >

                <button
                    type="button"
                    onclick="closeExcelModal()"
                    class="
                        px-4
                        py-2
                        border
                        border-gray-300
                        text-sm
                        font-semibold
                        rounded-lg
                        text-gray-700
                        bg-white
                        hover:bg-gray-50
                        transition
                    "
                >
                    Batal
                </button>


                <button
                    type="button"
                    onclick="processExcelImport()"
                    class="
                        px-4
                        py-2
                        border
                        border-transparent
                        text-sm
                        font-semibold
                        rounded-lg
                        text-white
                        bg-blue-600
                        hover:bg-blue-700
                        transition
                        shadow
                    "
                >
                    Import Sekarang
                </button>

            </div>

        </div>

    </div>

</div>



{{-- NOTIFIKASI UPLOAD --}}
<div
    id="upload-notification"
    class="
        hidden
        fixed
        top-5
        right-5
        z-[9999]
        max-w-md
        rounded-xl
        border
        px-4
        py-3
        shadow-lg
    "
>

    <div class="flex items-start gap-3">

        <svg
            class="
                mt-0.5
                h-5
                w-5
                flex-shrink-0
            "
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"
            />

        </svg>


        <div>

            <p
                id="upload-notification-title"
                class="text-sm font-bold"
            ></p>


            <p
                id="upload-notification-message"
                class="mt-1 text-xs"
            ></p>

        </div>

    </div>

</div>



<script>

    /*
    |--------------------------------------------------------------------------
    | INDEX TIKET
    |--------------------------------------------------------------------------
    */

    let rowIndex = {{ count($formItems) }};



    /*
    |--------------------------------------------------------------------------
    | KONFIGURASI UPLOAD
    |--------------------------------------------------------------------------
    */

    const MAX_UPLOAD_SIZE =
        10 * 1024 * 1024;

    const ALLOWED_UPLOAD_EXTENSIONS = [
        'jpg',
        'jpeg',
        'png',
        'pdf',
        'doc',
        'docx'
    ];

    let uploadNotificationTimer = null;



    /*
    |--------------------------------------------------------------------------
    | NOTIFIKASI UPLOAD
    |--------------------------------------------------------------------------
    */

    function showUploadNotification(
        title,
        message,
        type = 'error'
    ) {

        const notification =
            document.getElementById(
                'upload-notification'
            );

        const titleElement =
            document.getElementById(
                'upload-notification-title'
            );

        const messageElement =
            document.getElementById(
                'upload-notification-message'
            );


        if (
            !notification ||
            !titleElement ||
            !messageElement
        ) {

            alert(
                title +
                '\n' +
                message
            );

            return;
        }


        notification.classList.remove(
            'hidden',

            'bg-red-50',
            'border-red-300',
            'text-red-700',

            'bg-emerald-50',
            'border-emerald-300',
            'text-emerald-700'
        );


        if (type === 'success') {

            notification.classList.add(
                'bg-emerald-50',
                'border-emerald-300',
                'text-emerald-700'
            );

        } else {

            notification.classList.add(
                'bg-red-50',
                'border-red-300',
                'text-red-700'
            );
        }


        titleElement.textContent =
            title;

        messageElement.textContent =
            message;


        clearTimeout(
            uploadNotificationTimer
        );


        uploadNotificationTimer =
            setTimeout(
                function () {

                    notification
                        .classList
                        .add('hidden');

                },
                5000
            );
    }



    /*
    |--------------------------------------------------------------------------
    | RESET FILE INPUT
    |--------------------------------------------------------------------------
    */

    function resetFileInput(input) {

        const label =
            input.nextElementSibling;


        const match =
            input.name.match(
                /lampiran_(\d+)/
            );


        const number =
            match
                ? match[1]
                : '';


        /*
         * Kosongkan file.
         */
        input.value = '';


        /*
         * Kembalikan label.
         */
        if (label) {

            label.innerText =
                'Upload Lampiran ' +
                number;
        }


        /*
         * Sembunyikan tanda silang.
         */
        const clearButton =
            input.parentElement
                .querySelector(
                    '.file-clear'
                );


        if (clearButton) {

            clearButton.classList.add(
                'hidden'
            );
        }


        /*
         * Hilangkan status hijau.
         */
        input.parentElement
            .classList
            .remove(
                'bg-emerald-50',
                'text-emerald-700',
                'border-emerald-200'
            );


        /*
         * Kembali ke biru.
         */
        input.parentElement
            .classList
            .add(
                'bg-blue-50',
                'text-blue-600',
                'border-blue-200'
            );
    }



    /*
    |--------------------------------------------------------------------------
    | FILE DIPILIH
    |--------------------------------------------------------------------------
    */

    function updateFileName(input) {

        const label =
            input.nextElementSibling;

        const file =
            input.files &&
            input.files[0];


        /*
         * Tidak ada file.
         */
        if (!file) {

            resetFileInput(input);

            return;
        }


        /*
         * Ambil extension.
         */
        const extension =
            file.name
                .split('.')
                .pop()
                .toLowerCase();


        /*
         * Validasi extension.
         */
        if (
            !ALLOWED_UPLOAD_EXTENSIONS
                .includes(extension)
        ) {

            showUploadNotification(
                'Format file tidak sesuai',

                'File "' +
                file.name +
                '" ditolak. ' +
                'Gunakan JPG, JPEG, PNG, PDF, DOC, atau DOCX.'
            );


            resetFileInput(input);

            return;
        }


        /*
         * Validasi ukuran.
         */
        if (
            file.size >
            MAX_UPLOAD_SIZE
        ) {

            const fileSizeMb =
                (
                    file.size /
                    1024 /
                    1024
                ).toFixed(2);


            showUploadNotification(
                'Ukuran file terlalu besar',

                'File "' +
                file.name +
                '" berukuran ' +
                fileSizeMb +
                ' MB. Maksimal 10 MB.'
            );


            resetFileInput(input);

            return;
        }


        /*
         * Ubah label menjadi nama file.
         */
        if (label) {

            label.innerText =
                '📎 ' +
                file.name;
        }


        /*
         * Tampilkan tombol X.
         */
        const clearButton =
            input.parentElement
                .querySelector(
                    '.file-clear'
                );


        if (clearButton) {

            clearButton.classList.remove(
                'hidden'
            );
        }


        /*
         * Ubah tombol menjadi hijau.
         */
        input.parentElement
            .classList
            .remove(
                'bg-blue-50',
                'text-blue-600',
                'border-blue-200'
            );


        input.parentElement
            .classList
            .add(
                'bg-emerald-50',
                'text-emerald-700',
                'border-emerald-200'
            );


        /*
         * Tampilkan notifikasi berhasil.
         */
        const fileSizeMb =
            (
                file.size /
                1024 /
                1024
            ).toFixed(2);


        showUploadNotification(
            'File siap diunggah',

            file.name +
            ' (' +
            fileSizeMb +
            ' MB)',

            'success'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | CANCEL FILE
    |--------------------------------------------------------------------------
    */

    function cancelUpload(
        event,
        clearButton
    ) {

        /*
         * Supaya klik X tidak membuka
         * file picker.
         */
        event.preventDefault();

        event.stopPropagation();


        const label =
            clearButton.closest(
                'label'
            );


        if (!label) {

            return;
        }


        const input =
            label.querySelector(
                'input[type="file"]'
            );


        const fileLabel =
            label.querySelector(
                '.file-label'
            );


        if (!input) {

            return;
        }


        /*
         * Kosongkan file.
         */
        input.value = '';


        /*
         * Ambil nomor lampiran.
         */
        const match =
            input.name.match(
                /lampiran_(\d+)/
            );


        const number =
            match
                ? match[1]
                : '';


        /*
         * Kembalikan label.
         */
        if (fileLabel) {

            fileLabel.textContent =
                'Upload Lampiran ' +
                number;
        }


        /*
         * Sembunyikan X.
         */
        clearButton.classList.add(
            'hidden'
        );


        /*
         * Hilangkan warna hijau.
         */
        label.classList.remove(
            'bg-emerald-50',
            'text-emerald-700',
            'border-emerald-200'
        );


        /*
         * Kembalikan warna biru.
         */
        label.classList.add(
            'bg-blue-50',
            'text-blue-600',
            'border-blue-200'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | TAMBAH BARIS TIKET
    |--------------------------------------------------------------------------
    */

    function addNewRow(
        initialData = {}
    ) {
        if (!initialData.no_tiket) {
            initialData.no_tiket = 'INC' + Math.floor(100000 + Math.random() * 900000);
        }

        const container =
            document.getElementById(
                'tickets-container'
            );


        const index =
            rowIndex++;


        const newRow =
            document.createElement(
                'div'
            );


        newRow.className =
            'ticket-row border border-gray-200 rounded-xl p-4 relative bg-gray-50';


        newRow.setAttribute(
            'data-index',
            index
        );


        newRow.innerHTML = `

            <button
                type="button"
                onclick="removeRow(this)"
                style="right: 12px; top: 12px;"
                class="
                    absolute
                    text-red-400
                    hover:text-red-600
                    transition-colors
                    btn-hapus-baris
                "
                title="Hapus Item"
            >
                <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                    ></path>
                </svg>
            </button>


            <div
                class="
                    grid
                    grid-cols-1
                    md:grid-cols-2
                    gap-4
                    pr-6
                "
            >


                <div>

                    <label
                        class="
                            block
                            text-xs
                            font-medium
                            text-gray-600
                            mb-1
                        "
                    >
                        No Tiket
                    </label>

                    <input
                        type="text"
                        name="items[${index}][no_tiket]"
                        value="${initialData.no_tiket || ''}"
                        class="
                            w-full
                            border
                            border-gray-300
                            rounded-lg
                            px-3
                            py-2
                            text-sm
                            focus:outline-none
                            focus:ring-2
                            focus:ring-blue-500
                            font-mono
                        "
                        placeholder="INC00xxx"
                        required
                    >

                </div>



                <div>

                    <label
                        class="
                            block
                            text-xs
                            font-medium
                            text-gray-600
                            mb-1
                        "
                    >
                        User Pemohon
                    </label>

                    <input
                        type="text"
                        name="items[${index}][user_pemohon]"
                        value="${initialData.user_pemohon || ''}"
                        class="
                            w-full
                            border
                            border-gray-300
                            rounded-lg
                            px-3
                            py-2
                            text-sm
                            focus:outline-none
                            focus:ring-2
                            focus:ring-blue-500
                        "
                        placeholder="Nama User"
                        required
                    >

                </div>



                <div>

                    <label
                        class="
                            block
                            text-xs
                            font-medium
                            text-gray-600
                            mb-1
                        "
                    >
                        NIPP
                    </label>

                    <input
                        type="text"
                        name="items[${index}][nipp]"
                        value="${initialData.nipp || ''}"
                        class="
                            w-full
                            border
                            border-gray-300
                            rounded-lg
                            px-3
                            py-2
                            text-sm
                            focus:outline-none
                            focus:ring-2
                            focus:ring-blue-500
                        "
                        placeholder="NIPP"
                        required
                    >

                </div>



                <div>

                    <label
                        class="
                            block
                            text-xs
                            font-medium
                            text-gray-600
                            mb-1
                        "
                    >
                        Unit
                    </label>

                    <input
                        type="text"
                        name="items[${index}][unit]"
                        value="${initialData.unit || ''}"
                        class="
                            w-full
                            border
                            border-gray-300
                            rounded-lg
                            px-3
                            py-2
                            text-sm
                            focus:outline-none
                            focus:ring-2
                            focus:ring-blue-500
                        "
                        placeholder="Pilih Unit..."
                        list="unit_list"
                        required
                    >

                </div>



                <div class="md:col-span-2">

                    <label
                        class="
                            block
                            text-xs
                            font-medium
                            text-gray-600
                            mb-1
                        "
                    >
                        Detail Tiket
                    </label>

                    <textarea
                        name="items[${index}][detail_tiket]"
                        rows="2"
                        class="
                            w-full
                            border
                            border-gray-300
                            rounded-lg
                            px-3
                            py-2
                            text-sm
                            focus:outline-none
                            focus:ring-2
                            focus:ring-blue-500
                        "
                        placeholder="Detail masalah tiket..."
                        required
                    >${initialData.detail_tiket || ''}</textarea>

                </div>



                <div class="md:col-span-2">

                    <label
                        class="
                            block
                            text-xs
                            font-medium
                            text-gray-600
                            mb-1
                        "
                    >
                        Lampiran Konfirmasi
                    </label>

                    <p
                        class="
                            text-[11px]
                            text-gray-500
                            mb-2
                        "
                    >
                        Maksimal 3 file •
                        Maksimal 10 MB per file •
                        Format:
                        JPG, JPEG, PNG, PDF, DOC, DOCX
                    </p>


                    <div class="flex flex-wrap gap-2">


                        <label
                            class="
                                cursor-pointer
                                text-xs
                                bg-blue-50
                                text-blue-600
                                hover:bg-blue-100
                                px-3
                                py-1.5
                                rounded-lg
                                border
                                border-blue-200
                                transition-colors
                                inline-flex
                                items-center
                                gap-1.5
                            "
                        >

                            <input
                                type="file"
                                name="items[${index}][lampiran_1]"
                                accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                                onchange="updateFileName(this)"
                                style="display: none;"
                            >

                            <span class="file-label">
                                Upload Lampiran 1
                            </span>

                            <span
                                class="
                                    file-clear
                                    hidden
                                    text-red-500
                                    hover:text-red-700
                                    font-bold
                                    text-sm
                                    ml-1
                                "
                                onclick="cancelUpload(event, this)"
                                title="Batalkan lampiran"
                            >
                                ×
                            </span>

                        </label>



                        <label
                            class="
                                cursor-pointer
                                text-xs
                                bg-blue-50
                                text-blue-600
                                hover:bg-blue-100
                                px-3
                                py-1.5
                                rounded-lg
                                border
                                border-blue-200
                                transition-colors
                                inline-flex
                                items-center
                                gap-1.5
                            "
                        >

                            <input
                                type="file"
                                name="items[${index}][lampiran_2]"
                                accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                                onchange="updateFileName(this)"
                                style="display: none;"
                            >

                            <span class="file-label">
                                Upload Lampiran 2
                            </span>

                            <span
                                class="
                                    file-clear
                                    hidden
                                    text-red-500
                                    hover:text-red-700
                                    font-bold
                                    text-sm
                                    ml-1
                                "
                                onclick="cancelUpload(event, this)"
                                title="Batalkan lampiran"
                            >
                                ×
                            </span>

                        </label>



                        <label
                            class="
                                cursor-pointer
                                text-xs
                                bg-blue-50
                                text-blue-600
                                hover:bg-blue-100
                                px-3
                                py-1.5
                                rounded-lg
                                border
                                border-blue-200
                                transition-colors
                                inline-flex
                                items-center
                                gap-1.5
                            "
                        >

                            <input
                                type="file"
                                name="items[${index}][lampiran_3]"
                                accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                                onchange="updateFileName(this)"
                                style="display: none;"
                            >

                            <span class="file-label">
                                Upload Lampiran 3
                            </span>

                            <span
                                class="
                                    file-clear
                                    hidden
                                    text-red-500
                                    hover:text-red-700
                                    font-bold
                                    text-sm
                                    ml-1
                                "
                                onclick="cancelUpload(event, this)"
                                title="Batalkan lampiran"
                            >
                                ×
                            </span>

                        </label>

                    </div>

                </div>

            </div>
        `;


        container.appendChild(
            newRow
        );


        updateDeleteButtons();
    }



    /*
    |--------------------------------------------------------------------------
    | HAPUS BARIS
    |--------------------------------------------------------------------------
    */

    function removeRow(button) {

        button
            .closest('.ticket-row')
            .remove();


        updateDeleteButtons();
    }



    /*
    |--------------------------------------------------------------------------
    | TOMBOL HAPUS BARIS
    |--------------------------------------------------------------------------
    */

    function updateDeleteButtons() {

        const rows =
            document.querySelectorAll(
                '#tickets-container .ticket-row'
            );


        rows.forEach(
            (row) => {

                const deleteBtn =
                    row.querySelector(
                        '.btn-hapus-baris'
                    );


                if (deleteBtn) {

                    if (
                        rows.length === 1
                    ) {

                        deleteBtn.style.display =
                            'none';

                    } else {

                        deleteBtn.style.display =
                            'block';
                    }
                }
            }
        );
    }



    /*
    |--------------------------------------------------------------------------
    | MODAL EXCEL
    |--------------------------------------------------------------------------
    */

    function openExcelModal() {

        document
            .getElementById(
                'excel-modal'
            )
            .classList
            .remove('hidden');
    }


    function closeExcelModal() {

        document
            .getElementById(
                'excel-modal'
            )
            .classList
            .add('hidden');


        document
            .getElementById(
                'excel-file-input'
            )
            .value = '';


        document
            .getElementById(
                'file-label'
            )
            .textContent =
                'Pilih file Excel...';
    }



    /*
    |--------------------------------------------------------------------------
    | FILE EXCEL DIPILIH
    |--------------------------------------------------------------------------
    */

    document
        .getElementById(
            'excel-file-input'
        )
        .addEventListener(
            'change',
            function (e) {

                if (
                    e.target.files.length >
                    0
                ) {

                    document
                        .getElementById(
                            'file-label'
                        )
                        .textContent =
                            e.target
                                .files[0]
                                .name;
                }
            }
        );



    /*
    |--------------------------------------------------------------------------
    | IMPORT EXCEL
    |--------------------------------------------------------------------------
    */

    function processExcelImport() {

        const fileInput =
            document.getElementById(
                'excel-file-input'
            );


        if (
            fileInput.files.length ===
            0
        ) {

            alert(
                'Silakan pilih file Excel terlebih dahulu.'
            );

            return;
        }


        const formData =
            new FormData();


        formData.append(
            'file',
            fileInput.files[0]
        );


        formData.append(
            '_token',
            '{{ csrf_token() }}'
        );


        const importBtn =
            document.querySelector(
                '#excel-modal button[onclick="processExcelImport()"]'
            );


        const originalText =
            importBtn.textContent;


        importBtn.disabled =
            true;


        importBtn.textContent =
            'Memproses...';


        fetch(
            '{{ route('form-bastik.parse-excel') }}',
            {
                method: 'POST',

                body: formData,

                headers: {
                    'X-Requested-With':
                        'XMLHttpRequest'
                }
            }
        )

        .then(
            response =>
                response.json()
        )

        .then(
            res => {

                if (
                    res.success &&
                    res.data.length > 0
                ) {

                    const rows =
                        document.querySelectorAll(
                            '#tickets-container .ticket-row'
                        );


                    /*
                     * Jika hanya ada satu
                     * baris kosong,
                     * hapus terlebih dahulu.
                     */
                    if (
                        rows.length === 1
                    ) {

                        const firstRowInputs =
                            rows[0]
                                .querySelectorAll(
                                    'input[type="text"], textarea'
                                );


                        let isClean =
                            true;


                        firstRowInputs
                            .forEach(
                                input => {

                                    if (
                                        input
                                            .value
                                            .trim() !==
                                        ''
                                    ) {

                                        isClean =
                                            false;
                                    }
                                }
                            );


                        if (isClean) {

                            rows[0].remove();
                        }
                    }


                    res.data.forEach(
                        item =>
                            addNewRow(item)
                    );


                    closeExcelModal();


                    alert(
                        `Berhasil mengimport ${res.data.length} baris tiket.`
                    );

                } else {

                    alert(
                        res.message ||
                        'File Excel kosong atau format tidak sesuai.'
                    );
                }
            }
        )

        .catch(
            err => {

                console.error(err);

                alert(
                    'Terjadi kesalahan saat memproses file Excel.'
                );
            }
        )

        .finally(
            () => {

                importBtn.disabled =
                    false;

                importBtn.textContent =
                    originalText;
            }
        );
    }



    /*
    |--------------------------------------------------------------------------
    | BUSINESS AREA → KOTA
    |--------------------------------------------------------------------------
    */

    const businessAreaCityMap =
        @json($businessAreaMap);


    document.addEventListener(
        'DOMContentLoaded',
        function () {

            updateDeleteButtons();


            const businessAreaSelect =
                document.getElementById(
                    'business_area'
                );


            const kotaSelect =
                document.getElementById(
                    'kota'
                );


            if (
                businessAreaSelect &&
                kotaSelect
            ) {

                businessAreaSelect
                    .addEventListener(
                        'change',
                        function () {

                            const rekomendasiKota =
                                businessAreaCityMap[
                                    this.value
                                ];


                            if (
                                rekomendasiKota
                            ) {

                                kotaSelect.value =
                                    rekomendasiKota;
                            }
                        }
                    );
            }
        }
    );

</script>