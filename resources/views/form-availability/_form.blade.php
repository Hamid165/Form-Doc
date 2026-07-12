@php
    $form = $form_availability ?? null;
    $items = old('items');

    if ($items === null && $form) {
        $items = $form->items->map(function ($item) {
            return [
                'nomor' => $item->nomor,
                'station' => $item->station,
                'rts_pts_ng' => $item->rts_pts_ng,
                'jumlah_perangkat_ticketing' =>
                    $item->jumlah_perangkat_ticketing,
                'jumlah_gangguan' =>
                    $item->jumlah_gangguan,
                'lama_gangguan' =>
                    $item->lama_gangguan,
                'keterangan' =>
                    $item->keterangan,
            ];
        })->toArray();
    }

    if (empty($items)) {
        $items = [
            [
                'nomor' => 1,
                'station' => '',
                'rts_pts_ng' => '',
                'jumlah_perangkat_ticketing' => 0,
                'jumlah_gangguan' => 0,
                'lama_gangguan' => 0,
                'keterangan' => '',
            ],
        ];
    }
@endphp


<div class="availability-form">

    {{-- VALIDATION ERROR --}}
    @if ($errors->any())
        <div class="availability-alert availability-alert-error">
            <strong>Data belum dapat disimpan.</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- INFORMASI FORMULIR --}}
    <section class="availability-card">

        <div class="availability-card-header">
            <div>
                <h3>Informasi Formulir</h3>

                <p>
                    Masukkan informasi utama laporan availability.
                </p>
            </div>
        </div>

        <div class="availability-card-body">

            <div class="availability-form-grid">

                <div class="availability-field">
                    <label for="no_ref">
                        Nomor Referensi
                    </label>

                    <input
                        id="no_ref"
                        type="text"
                        name="no_ref"
                        value="{{ old('no_ref', $form?->no_ref) }}"
                        class="availability-control"
                        placeholder="Contoh: 001/IT/VII/2026"
                    >
                </div>


                <div class="availability-field">
                    <label for="tanggal">
                        Tanggal Laporan
                        <span class="required-mark">*</span>
                    </label>

                    <input
                        id="tanggal"
                        type="date"
                        name="tanggal"
                        value="{{ old(
                            'tanggal',
                            $form?->tanggal?->format('Y-m-d')
                        ) }}"
                        class="availability-control"
                        required
                    >
                </div>


                <div class="availability-field">
                    <label for="business_area">
                        Business Area
                        <span class="required-mark">*</span>
                    </label>

                    <input
                        id="business_area"
                        type="text"
                        name="business_area"
                        value="{{ old(
                            'business_area',
                            $form?->business_area
                        ) }}"
                        class="availability-control"
                        placeholder="Contoh: Sistem Informasi"
                        required
                    >
                </div>


                <div class="availability-field">
                    <label for="daop_divre">
                        DAOP/DIVRE
                        <span class="required-mark">*</span>
                    </label>

                    <input
                        id="daop_divre"
                        type="text"
                        name="daop_divre"
                        value="{{ old(
                            'daop_divre',
                            $form?->daop_divre
                        ) }}"
                        class="availability-control"
                        placeholder="Contoh: DAOP 8 Surabaya"
                        required
                    >
                </div>


                <div class="availability-field">
                    <label for="jumlah_total_station">
                        Jumlah Total Stasiun
                        <span class="required-mark">*</span>
                    </label>

                    <input
                        id="jumlah_total_station"
                        type="number"
                        name="jumlah_total_station"
                        value="{{ old(
                            'jumlah_total_station',
                            $form?->jumlah_total_station ?? 0
                        ) }}"
                        class="availability-control"
                        min="0"
                        required
                    >
                </div>


                <div class="availability-field">
                    <label for="jumlah_perangkat_ticketing">
                        Jumlah Total Perangkat
                        <span class="required-mark">*</span>
                    </label>

                    <input
                        id="jumlah_perangkat_ticketing"
                        type="number"
                        name="jumlah_perangkat_ticketing"
                        value="{{ old(
                            'jumlah_perangkat_ticketing',
                            $form?->jumlah_perangkat_ticketing ?? 0
                        ) }}"
                        class="availability-control"
                        min="0"
                        required
                    >
                </div>

            </div>

        </div>
    </section>


    {{-- DETAIL AVAILABILITY --}}
    <section class="availability-card">

        <div class="availability-card-header availability-detail-toolbar">

            <div>
                <h3>Detail Availability System Ticketing</h3>

                <p>
                    Setiap stasiun ditampilkan sebagai kolom yang dapat
                    dibuka dan ditutup.
                </p>
            </div>

            <button
                type="button"
                id="btnTambahGangguan"
                class="availability-add-button"
            >
                <svg
                    width="17"
                    height="17"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                >
                    <path
                        d="M12 5v14M5 12h14"
                        stroke-width="2"
                        stroke-linecap="round"
                    />
                </svg>

                Tambah Detail
            </button>

        </div>


        <div class="availability-card-body">

            <div
                id="detailGangguan"
                class="availability-detail-list"
            >

                @foreach ($items as $index => $item)

                    <article
                        class="availability-detail-card {{ $loop->first ? 'is-open' : '' }}"
                        data-detail-card
                    >

                        <button
                            type="button"
                            class="availability-detail-summary js-toggle-detail"
                        >

                            <div class="availability-summary-main">

                                <span
                                    class="availability-detail-number"
                                    data-detail-number
                                >
                                    Detail {{ $index + 1 }}
                                </span>

                                <div class="availability-summary-text">

                                    <strong data-summary-station>
                                        {{ filled($item['station'] ?? null)
                                            ? $item['station']
                                            : 'Stasiun belum diisi' }}
                                    </strong>

                                    <span data-summary-rts>
                                        {{ filled($item['rts_pts_ng'] ?? null)
                                            ? $item['rts_pts_ng']
                                            : 'RTS belum dipilih' }}
                                    </span>

                                </div>

                            </div>


                            <div class="availability-summary-meta">

                                <span class="availability-summary-count">
                                    Perangkat:
                                    <strong data-summary-device>
                                        {{ $item['jumlah_perangkat_ticketing'] ?? 0 }}
                                    </strong>
                                </span>

                                <span class="availability-summary-count">
                                    Gangguan:
                                    <strong data-summary-disturbance>
                                        {{ $item['jumlah_gangguan'] ?? 0 }}
                                    </strong>
                                </span>

                                <svg
                                    class="availability-detail-chevron"
                                    width="18"
                                    height="18"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                >
                                    <path
                                        d="m6 9 6 6 6-6"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>

                            </div>

                        </button>


                        <div
                            class="availability-detail-body"
                            data-detail-body
                        >

                            <input
                                type="hidden"
                                name="items[{{ $index }}][nomor]"
                                value="{{ $index + 1 }}"
                                class="js-detail-number-input"
                            >


                            <div class="availability-detail-grid">

                                <div class="availability-detail-field field-station">
                                    <label>
                                        Nama Stasiun
                                        <span class="required-mark">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="items[{{ $index }}][station]"
                                        value="{{ $item['station'] ?? '' }}"
                                        class="availability-control js-station-input"
                                        placeholder="Contoh: Malang"
                                        required
                                    >
                                </div>


                                <div class="availability-detail-field field-rts">
                                    <label>
                                        RTS/RTS NG
                                        <span class="required-mark">*</span>
                                    </label>

                                    <select
                                        name="items[{{ $index }}][rts_pts_ng]"
                                        class="availability-control js-rts-input"
                                        required
                                    >
                                        <option value="">
                                            Pilih jenis
                                        </option>

                                        <option
                                            value="RTS"
                                            @selected(
                                                ($item['rts_pts_ng'] ?? '') === 'RTS'
                                            )
                                        >
                                            RTS
                                        </option>

                                        <option
                                            value="RTS NG"
                                            @selected(
                                                ($item['rts_pts_ng'] ?? '') === 'RTS NG'
                                            )
                                        >
                                            RTS NG
                                        </option>
                                    </select>
                                </div>


                                <div class="availability-detail-field field-number">
                                    <label>
                                        Jumlah Perangkat
                                        <span class="required-mark">*</span>
                                    </label>

                                    <input
                                        type="number"
                                        name="items[{{ $index }}][jumlah_perangkat_ticketing]"
                                        value="{{ $item['jumlah_perangkat_ticketing'] ?? 0 }}"
                                        min="0"
                                        class="availability-control js-device-input"
                                        required
                                    >
                                </div>


                                <div class="availability-detail-field field-number">
                                    <label>
                                        Jumlah Gangguan
                                        <span class="required-mark">*</span>
                                    </label>

                                    <input
                                        type="number"
                                        name="items[{{ $index }}][jumlah_gangguan]"
                                        value="{{ $item['jumlah_gangguan'] ?? 0 }}"
                                        min="0"
                                        class="availability-control js-disturbance-input"
                                        required
                                    >
                                </div>


                                <div class="availability-detail-field field-number">
                                    <label>
                                        Lama Gangguan

                                        <small>
                                            Menit
                                        </small>
                                    </label>

                                    <input
                                        type="number"
                                        name="items[{{ $index }}][lama_gangguan]"
                                        value="{{ $item['lama_gangguan'] ?? 0 }}"
                                        min="0"
                                        class="availability-control"
                                        required
                                    >
                                </div>


                                <div class="availability-detail-field field-description">
                                    <label>
                                        Keterangan
                                    </label>

                                    <textarea
                                        name="items[{{ $index }}][keterangan]"
                                        rows="3"
                                        class="availability-control"
                                        placeholder="Isi Nihil apabila tidak ada gangguan"
                                    >{{ $item['keterangan'] ?? '' }}</textarea>
                                </div>

                            </div>


                            <div class="availability-detail-actions">

                                <button
                                    type="button"
                                    class="availability-delete-button js-delete-detail"
                                >
                                    <svg
                                        width="15"
                                        height="15"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                    >
                                        <path
                                            d="M4 7h16M10 11v6M14 11v6M6 7l1 14h10l1-14M9 7V4h6v3"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>

                                    Hapus Detail
                                </button>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

        </div>
    </section>


    {{-- CATATAN DAN PENANDATANGAN --}}
    <section class="availability-card">

        <div class="availability-card-header">
            <div>
                <h3>Catatan dan Penandatangan</h3>

                <p>
                    Masukkan catatan, petugas, dan pejabat yang mengetahui.
                </p>
            </div>
        </div>

        <div class="availability-card-body">

            <div class="availability-field availability-full-field">
                <label for="catatan">
                    Catatan/Keterangan Tambahan
                </label>

                <textarea
                    id="catatan"
                    name="catatan"
                    rows="4"
                    class="availability-control"
                    placeholder="Masukkan catatan tambahan laporan"
                >{{ old('catatan', $form?->catatan) }}</textarea>
            </div>


            <div class="availability-form-grid availability-sign-grid">

                <div class="availability-field">
                    <label for="petugas_name">
                        Nama Petugas
                    </label>

                    <input
                        id="petugas_name"
                        type="text"
                        name="petugas_name"
                        value="{{ old(
                            'petugas_name',
                            $form?->petugas_name
                        ) }}"
                        class="availability-control"
                        placeholder="Masukkan nama petugas"
                    >
                </div>


                <div class="availability-field">
                    <label for="petugas_nipp">
                        NIPP Petugas
                    </label>

                    <input
                        id="petugas_nipp"
                        type="text"
                        name="petugas_nipp"
                        value="{{ old(
                            'petugas_nipp',
                            $form?->petugas_nipp
                        ) }}"
                        class="availability-control"
                        placeholder="Masukkan NIPP petugas"
                    >
                </div>


                <div class="availability-field availability-full-field">
                    <label for="mengetahui_id">
                        Pejabat yang Mengetahui
                        <span class="required-mark">*</span>
                    </label>

                    @if ($masterSigners->isEmpty())

                        <div class="availability-alert availability-alert-warning">
                            Data pejabat belum tersedia pada tabel
                            <strong>master_signers</strong>.
                        </div>

                    @else

                        <select
                            id="mengetahui_id"
                            name="mengetahui_id"
                            class="availability-control"
                            required
                        >
                            <option
                                value=""
                                disabled
                                @selected(
                                    empty(old(
                                        'mengetahui_id',
                                        $form?->mengetahui_id
                                    ))
                                )
                            >
                                -- Pilih Pejabat yang Mengetahui --
                            </option>

                            @foreach ($masterSigners as $signer)
                                <option
                                    value="{{ $signer->id }}"
                                    @selected(
                                        (string) old(
                                            'mengetahui_id',
                                            $form?->mengetahui_id
                                        ) === (string) $signer->id
                                    )
                                >
                                    {{ $signer->nama }}

                                    @if ($signer->jabatan)
                                        — {{ $signer->jabatan }}
                                    @endif

                                    @if ($signer->nipp)
                                        — NIPP {{ $signer->nipp }}
                                    @endif
                                </option>
                            @endforeach
                        </select>

                        <small class="availability-help">
                            Nama, jabatan, dan NIPP akan ditampilkan
                            pada area tanda tangan.
                        </small>

                    @endif
                </div>

            </div>

        </div>
    </section>


    {{-- ACTION --}}
    <div class="availability-form-actions">

        <a
            href="{{ route('form-availability.index') }}"
            class="availability-cancel-button"
        >
            Batal
        </a>

        <button
            type="submit"
            class="availability-submit-button"
            @disabled($masterSigners->isEmpty())
        >
            {{ $submitLabel ?? 'Simpan Form' }}
        </button>

    </div>

</div>


{{-- TEMPLATE DETAIL BARU --}}
<template id="detailGangguanTemplate">

    <article
        class="availability-detail-card is-open"
        data-detail-card
    >

        <button
            type="button"
            class="availability-detail-summary js-toggle-detail"
        >

            <div class="availability-summary-main">

                <span
                    class="availability-detail-number"
                    data-detail-number
                >
                    Detail __NUMBER__
                </span>

                <div class="availability-summary-text">
                    <strong data-summary-station>
                        Stasiun belum diisi
                    </strong>

                    <span data-summary-rts>
                        RTS belum dipilih
                    </span>
                </div>

            </div>


            <div class="availability-summary-meta">

                <span class="availability-summary-count">
                    Perangkat:
                    <strong data-summary-device>0</strong>
                </span>

                <span class="availability-summary-count">
                    Gangguan:
                    <strong data-summary-disturbance>0</strong>
                </span>

                <svg
                    class="availability-detail-chevron"
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                >
                    <path
                        d="m6 9 6 6 6-6"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>

            </div>

        </button>


        <div
            class="availability-detail-body"
            data-detail-body
        >

            <input
                type="hidden"
                name="items[__INDEX__][nomor]"
                value="__NUMBER__"
                class="js-detail-number-input"
            >


            <div class="availability-detail-grid">

                <div class="availability-detail-field field-station">
                    <label>
                        Nama Stasiun
                        <span class="required-mark">*</span>
                    </label>

                    <input
                        type="text"
                        name="items[__INDEX__][station]"
                        class="availability-control js-station-input"
                        placeholder="Contoh: Malang"
                        required
                    >
                </div>


                <div class="availability-detail-field field-rts">
                    <label>
                        RTS/RTS NG
                        <span class="required-mark">*</span>
                    </label>

                    <select
                        name="items[__INDEX__][rts_pts_ng]"
                        class="availability-control js-rts-input"
                        required
                    >
                        <option value="">
                            Pilih jenis
                        </option>

                        <option value="RTS">
                            RTS
                        </option>

                        <option value="RTS NG">
                            RTS NG
                        </option>
                    </select>
                </div>


                <div class="availability-detail-field field-number">
                    <label>
                        Jumlah Perangkat
                        <span class="required-mark">*</span>
                    </label>

                    <input
                        type="number"
                        name="items[__INDEX__][jumlah_perangkat_ticketing]"
                        value="0"
                        min="0"
                        class="availability-control js-device-input"
                        required
                    >
                </div>


                <div class="availability-detail-field field-number">
                    <label>
                        Jumlah Gangguan
                        <span class="required-mark">*</span>
                    </label>

                    <input
                        type="number"
                        name="items[__INDEX__][jumlah_gangguan]"
                        value="0"
                        min="0"
                        class="availability-control js-disturbance-input"
                        required
                    >
                </div>


                <div class="availability-detail-field field-number">
                    <label>
                        Lama Gangguan
                        <small>Menit</small>
                    </label>

                    <input
                        type="number"
                        name="items[__INDEX__][lama_gangguan]"
                        value="0"
                        min="0"
                        class="availability-control"
                        required
                    >
                </div>


                <div class="availability-detail-field field-description">
                    <label>
                        Keterangan
                    </label>

                    <textarea
                        name="items[__INDEX__][keterangan]"
                        rows="3"
                        class="availability-control"
                        placeholder="Isi Nihil apabila tidak ada gangguan"
                    ></textarea>
                </div>

            </div>


            <div class="availability-detail-actions">

                <button
                    type="button"
                    class="availability-delete-button js-delete-detail"
                >
                    <svg
                        width="15"
                        height="15"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                    >
                        <path
                            d="M4 7h16M10 11v6M14 11v6M6 7l1 14h10l1-14M9 7V4h6v3"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>

                    Hapus Detail
                </button>

            </div>

        </div>

    </article>

</template>
