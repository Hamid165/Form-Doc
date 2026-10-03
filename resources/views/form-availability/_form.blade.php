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

    $nippMode = old(
        'mengetahui_nipp_mode',
        $form?->mengetahui_nipp_mode ?? 'master'
    );

    $nippOverride = old(
        'mengetahui_nipp_override',
        $form?->mengetahui_nipp_override
    );

    $namaOverride = old(
        'mengetahui_nama_override',
        $form?->mengetahui_nama_override
    );
@endphp


<div class="availability-form">

    {{-- HEADER FORM KAI RINGKAS --}}
    <header
        class="mb-1"
        aria-labelledby="availabilityFormTitle"
    >
        <div
            class="mb-3 flex items-center gap-2"
            aria-hidden="true"
        >
            <span class="h-1 w-10 rounded-full bg-[#1558a6]"></span>
            <span class="h-1 w-6 rounded-full bg-[#f58220]"></span>
        </div>

        <p class="mb-1 text-xs font-bold uppercase tracking-[0.18em] text-[#1558a6]">
            KAI · Availability System Ticketing
        </p>

        <p class="mt-1 text-sm text-gray-500">
            Lengkapi data laporan availability perangkat ticketing setiap stasiun.
        </p>
    </header>

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

        <div class="availability-card-header availability-card-header-kai">
            <div class="availability-section-heading">
                <span class="availability-section-number">01</span>

                <div>
                    <span class="availability-section-kicker">Informasi utama</span>
                    <h3>Informasi Formulir</h3>

                    <p>
                        Masukkan identitas utama laporan availability.
                    </p>
                </div>
            </div>

            <span class="availability-section-status">Wajib diisi</span>
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

                <div
                    class="availability-date-picker"
                    data-availability-date-picker
                >
                    <input
                        id="tanggal"
                        type="date"
                        name="tanggal"
                        value="{{ old(
                            'tanggal',
                            $form?->tanggal?->format('Y-m-d')
                        ) }}"
                        class="availability-control availability-date-input"
                        data-availability-date-input
                        required
                    >

                    <button
                        type="button"
                        class="availability-date-trigger"
                        data-availability-date-trigger
                        aria-label="Buka kalender tanggal laporan"
                        aria-controls="tanggal"
                    >
                        <svg
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                d="M7 3v3M17 3v3M4 9h16M5 5h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1Z"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                            <path
                                d="M8 13h2M14 13h2M8 17h2M14 17h2"
                                stroke-width="1.8"
                                stroke-linecap="round"
                            />
                        </svg>
                    </button>

                </div>

                <small class="availability-date-help">
                    Klik kolom atau ikon kalender untuk memilih tanggal.
                </small>

                </div>


                <div class="availability-field">
                    <label for="business_area">
                        Business Area
                        <span class="required-mark">*</span>
                    </label>

                    @php
                        $currentBa = old('business_area', $form?->business_area);
                    @endphp

                    <div class="availability-select-shell">
                        <select
                            id="business_area"
                            name="business_area"
                            class="availability-control availability-select-control"
                            required
                        >
                            <option value="" disabled @selected(empty($currentBa))>
                                Pilih Business Area
                            </option>
                            @foreach ($masterBusinessAreas ?? [] as $ba)
                                @php
                                    $baValue = "{$ba->kode} — {$ba->daop_divre}";
                                @endphp
                                <option
                                    value="{{ $baValue }}"
                                    data-daop="{{ $ba->daop_divre }}"
                                    data-kode="{{ $ba->kode }}"
                                    @selected($currentBa === $baValue || $currentBa === $ba->kode)
                                >
                                    {{ $baValue }}
                                </option>
                            @endforeach
                        </select>

                        <svg
                            class="availability-select-chevron"
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                d="m6 9 6 6 6-6"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </div>
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
                        class="availability-control bg-gray-50 cursor-not-allowed"
                        placeholder="Otomatis mengikuti Business Area"
                        readonly
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

        <div class="availability-card-header availability-card-header-kai availability-detail-toolbar">

            <div class="availability-section-heading">
                <span class="availability-section-number">02</span>

                <div>
                    <span class="availability-section-kicker">Data operasional</span>
                    <h3>Detail Availability System Ticketing</h3>

                    <p>
                        Tambahkan detail stasiun, jenis RTS, perangkat, dan gangguan.
                    </p>
                </div>
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

                                    <div
                                        class="availability-choice-grid availability-choice-grid-rts"
                                        role="radiogroup"
                                        aria-label="Pilih jenis RTS untuk detail {{ $index + 1 }}"
                                    >
                                        <label class="availability-choice-card">
                                            <input
                                                type="radio"
                                                name="items[{{ $index }}][rts_pts_ng]"
                                                value="RTS"
                                                class="availability-choice-input js-rts-input"
                                                @checked(
                                                    ($item['rts_pts_ng'] ?? '') === 'RTS'
                                                )
                                                required
                                            >

                                            <span class="availability-choice-dot"></span>

                                            <span class="availability-choice-copy">
                                                <strong>RTS</strong>
                                                <small>Perangkat existing</small>
                                            </span>
                                        </label>

                                        <label class="availability-choice-card">
                                            <input
                                                type="radio"
                                                name="items[{{ $index }}][rts_pts_ng]"
                                                value="RTS NG"
                                                class="availability-choice-input js-rts-input"
                                                @checked(
                                                    ($item['rts_pts_ng'] ?? '') === 'RTS NG'
                                                )
                                            >

                                            <span class="availability-choice-dot"></span>

                                            <span class="availability-choice-copy">
                                                <strong>RTS NG</strong>
                                                <small>Generasi terbaru</small>
                                            </span>
                                        </label>
                                    </div>
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

        <div class="availability-card-header availability-card-header-kai">
            <div class="availability-section-heading">
                <span class="availability-section-number">03</span>

                <div>
                    <span class="availability-section-kicker">Pengesahan laporan</span>
                    <h3>Catatan dan Penandatangan</h3>

                    <p>
                        Lengkapi catatan, petugas, dan pejabat yang mengetahui.
                    </p>
                </div>
            </div>

            <span class="availability-section-status availability-section-status-soft">Tahap akhir</span>
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
                        Tanda Tangan yang Mengetahui (Master Sign)
                        <span class="required-mark">*</span>
                    </label>

                    <input type="hidden" name="mengetahui_nipp_mode" value="master">

                    @if ($masterSigners->isEmpty())
                        <div class="availability-alert availability-alert-warning mb-3">
                            Data pejabat belum tersedia pada tabel <strong>master_signers</strong>. Silakan tambahkan pada menu Pengaturan.
                        </div>
                    @endif

                    <div class="availability-select-shell">
                        <select
                            id="mengetahui_id"
                            name="mengetahui_id"
                            class="availability-control availability-select-control"
                            data-signer-select
                            required
                        >
                            <option
                                value=""
                                disabled
                                data-name=""
                                data-position=""
                                data-nipp=""
                                @selected(empty(old('mengetahui_id', $form?->mengetahui_id)))
                            >
                                Pilih pejabat penandatangan
                            </option>

                            @foreach ($masterSigners as $signer)
                                <option
                                    value="{{ $signer->id }}"
                                    data-name="{{ $signer->nama }}"
                                    data-position="{{ $signer->jabatan }}"
                                    data-nipp="{{ $signer->nipp }}"
                                    @selected((string) old('mengetahui_id', $form?->mengetahui_id) === (string) $signer->id)
                                >
                                    {{ $signer->nama }}
                                    @if ($signer->jabatan)
                                        — {{ $signer->jabatan }}
                                    @endif
                                </option>
                            @endforeach
                        </select>

                        <svg
                            class="availability-select-chevron"
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                d="m6 9 6 6 6-6"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </div>

                    <div
                        class="availability-signer-preview mt-3"
                        data-signer-preview
                        hidden
                    >
                        <span class="availability-signer-avatar" aria-hidden="true">
                            <svg
                                width="22"
                                height="22"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                            >
                                <path
                                    d="M12 12a4 4 0 100-8 4 4 0 000 8ZM4.5 20a7.5 7.5 0 0115 0"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </span>

                        <span class="availability-signer-copy">
                            <strong data-signer-name>-</strong>
                            <span data-signer-position>-</span>
                            <small data-signer-nipp>-</small>
                        </span>

                        <span class="availability-signer-badge">Penandatangan</span>
                    </div>
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
        >
            <svg
                width="17"
                height="17"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                aria-hidden="true"
            >
                <path
                    d="M5 4h11l3 3v13H5V4Zm3 0v6h8V4M8 20v-6h8v6"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>

            <span>{{ $submitLabel ?? 'Simpan Form' }}</span>
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

                    <div
                        class="availability-choice-grid availability-choice-grid-rts"
                        role="radiogroup"
                        aria-label="Pilih jenis RTS untuk detail __NUMBER__"
                    >
                        <label class="availability-choice-card">
                            <input
                                type="radio"
                                name="items[__INDEX__][rts_pts_ng]"
                                value="RTS"
                                class="availability-choice-input js-rts-input"
                                required
                            >

                            <span class="availability-choice-dot"></span>

                            <span class="availability-choice-copy">
                                <strong>RTS</strong>
                                <small>Perangkat existing</small>
                            </span>
                        </label>

                        <label class="availability-choice-card">
                            <input
                                type="radio"
                                name="items[__INDEX__][rts_pts_ng]"
                                value="RTS NG"
                                class="availability-choice-input js-rts-input"
                            >

                            <span class="availability-choice-dot"></span>

                            <span class="availability-choice-copy">
                                <strong>RTS NG</strong>
                                <small>Generasi terbaru</small>
                            </span>
                        </label>
                    </div>
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
