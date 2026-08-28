<style>
    /* Base Styling untuk meniru cetakan A4 */
    .a4-wrapper {
        display: flex;
        justify-content: center;
        padding: 20px;
    }
    .a4-container {
        width: 210mm;
        background: white;
        padding: 12mm 15mm;
        box-sizing: border-box;
        box-shadow: 0 4px 15px rgba(0,0,0,0.12);
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11px;
        color: #000;
    }

    /* Table Reset */
    .a4-container table {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 0;
    }

    .main-table th, .main-table td {
        border: 1px solid black;
        padding: 4px 8px;
        vertical-align: middle;
    }

    .main-table th {
        background-color: #f9f9f9;
        font-weight: bold;
    }

    /* Tabel Kop Surat */
    .kop-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0;
        font-size: 11px;
    }
    .kop-table td {
        border: 1px solid #000;
        padding: 4px 6px;
        vertical-align: middle;
    }

    /* Inputs */
    .form-input {
        width: 100%;
        box-sizing: border-box;
        border: none;
        padding: 3px 4px;
        background-color: transparent;
        font-family: inherit;
        font-size: 11px;
        outline: none;
    }
    .form-input:focus {
        background-color: #f0f7ff;
        outline: none;
    }

    textarea.form-input {
        resize: vertical;
        min-height: 40px;
    }

    select.form-input {
        appearance: auto;
        cursor: pointer;
    }

    .section-title {
        font-weight: bold;
        background-color: #dce6f1;
        padding: 5px 8px;
        border: 1px solid black;
        font-size: 11px;
    }

    /* Items table */
    .items-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0;
    }
    .items-table th, .items-table td {
        border: 1px solid black;
        padding: 4px 6px;
        vertical-align: middle;
        font-size: 11px;
    }
    .items-table th {
        background-color: #dce6f1;
        font-weight: bold;
        text-align: center;
    }
    .items-table td.no-col {
        width: 4%;
        text-align: center;
        font-weight: bold;
    }
    .items-table td.hasil-col {
        width: 10%;
        text-align: center;
    }
    .items-table td.action-col {
        width: 4%;
        text-align: center;
    }

    /* Checkbox-style result cells */
    .hasil-checkbox {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
        border: 2px solid #bbb;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        transition: all 0.15s;
        user-select: none;
        background: white;
    }
    .hasil-checkbox.checked-ok {
        border-color: #16a34a;
        background: #dcfce7;
        color: #16a34a;
    }
    .hasil-checkbox.checked-notok {
        border-color: #dc2626;
        background: #fee2e2;
        color: #dc2626;
    }
    .hasil-checkbox:hover {
        border-color: #555;
        background: #f5f5f5;
    }
    .hasil-checkbox.checked-ok:hover {
        border-color: #15803d;
    }
    .hasil-checkbox.checked-notok:hover {
        border-color: #b91c1c;
    }

    .btn-add-row {
        background-color: #2563eb;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 5px 12px;
        font-size: 11px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .btn-add-row:hover {
        background-color: #1d4ed8;
    }

    .btn-delete-row {
        background: none;
        border: none;
        color: #dc2626;
        cursor: pointer;
        padding: 2px;
    }
    .btn-delete-row:hover {
        color: #991b1b;
    }

    /* Footer Signature */
    .signature-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 8px;
    }
    .signature-table td {
        border: 1px solid black;
        padding: 8px;
        text-align: center;
        vertical-align: top;
        width: 50%;
    }
    .signature-space {
        height: 50px;
    }
    .signature-name {
        font-weight: bold;
        text-decoration: underline;
        min-height: 18px;
    }

    .btn-submit {
        background-color: #16a34a;
        color: white;
        padding: 4px 12px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        font-size: 11px;
        transition: background 0.2s;
    }
    .btn-submit:hover {
        background-color: #15803d;
    }

    .btn-kembali {
        display: inline-flex; align-items: center; justify-content: center; height: 30px; padding: 4px 12px; background-color: #ef4444; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; font-family: inherit; font-size: 11px; box-sizing: border-box;
        transition: background-color 0.2s;
    }
    .btn-kembali:hover {
        background-color: #dc2626;
    }

    /* Analisa box */
    .analisa-box {
        border: 1px solid black;
        padding: 8px;
        margin-top: 0;
    }
</style>

<div class="a4-wrapper" style="flex-direction: column; align-items: center;">
    <div class="top-nav-container" style="width: 100%; max-width: 273mm; margin-bottom: 20px;">
        <a href="{{ route('form-pengujian-infrastruktur.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors mb-6">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Pengujian Infrastruktur
        </a>
    </div>

    <div class="zoom-container" style="zoom: 1.3; width: 100%; display: flex; justify-content: center;">
        <div class="a4-container" style="max-width: 100%; overflow-x: auto;">
            <form action="{{ $action }}" method="POST">
                @csrf
                @if(isset($method) && $method === 'PUT')
                    @method('PUT')
                @endif

                <!-- Kop Surat KAI -->
                @php
                    $kategori = strtoupper($formTemplate->kategori ?? 'Terbatas');
                    if ($kategori === 'PUBLIC' || $kategori === 'ALL') {
                        $kategori = 'UMUM';
                    }
                    $borderColor = '#5cb85c'; // green for UMUM
                    if ($kategori === 'TERBATAS') {
                        $borderColor = '#eadc04'; // yellow
                    } elseif ($kategori === 'RAHASIA') {
                        $borderColor = '#d9534f'; // red
                    }

                    // Business area options
                    $businessAreas = [
                        'B010' => 'DAOP 1 Jakarta',
                        'B020' => 'DAOP 2 Bandung',
                        'B030' => 'DAOP 3 Cirebon',
                        'B040' => 'DAOP 4 Semarang',
                        'B050' => 'DAOP 5 Purwokerto',
                        'B060' => 'DAOP 6 Yogyakarta',
                        'B070' => 'DAOP 7 Madiun',
                        'B080' => 'DAOP 8 Surabaya',
                        'B090' => 'DAOP 9 Jember',
                        'B100' => 'DIVRE 1 Medan',
                        'B200' => 'DIVRE 2 Padang',
                        'B300' => 'DIVRE 3 Palembang',
                        'B400' => 'DIVRE 4 Tanjungkarang',
                    ];

                    $savedBusinessArea = old('business_area', $form->business_area ?? '');
                    // Match saved value to key (could be code or full name)
                    $selectedKey = '';
                    foreach ($businessAreas as $code => $label) {
                        if ($savedBusinessArea === $code || $savedBusinessArea === $label || $savedBusinessArea === "$code - $label") {
                            $selectedKey = $code;
                            break;
                        }
                    }
                    if (!$selectedKey && $savedBusinessArea) {
                        $selectedKey = $savedBusinessArea; // fallback
                    }
                @endphp

                <table class="kop-table">
                    <tr>
                        <td rowspan="2" style="width: 15%; text-align: center; vertical-align: middle;">
                            <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI" style="width: 100%; max-width: 90px; height: auto; display: inline-block;">
                        </td>
                        <td rowspan="2" style="width: 45%; text-align: center; font-weight: bold; font-size: 12px; vertical-align: middle;">
                            PT KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI
                        </td>
                        <td style="width: 10%; font-weight: bold;">Nomor</td>
                        <td style="width: 30%;">: {{ $formTemplate->no_dokumen ?? 'FR.SM/TI/025.002/10-2020' }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Tanggal</td>
                        <td>: {{ $formTemplate->tanggal_dokumen ?? '12 Oktober 2020' }}</td>
                    </tr>
                    <tr>
                        <td rowspan="2" style="text-align: center; padding: 10px; vertical-align: middle;">
                            <div style="border: 2px solid {{ $borderColor }}; color: {{ $borderColor }}; font-weight: bold; font-size: 14px; padding: 6px 12px; display: inline-block;">{{ $kategori }}</div>
                        </td>
                        <td rowspan="2" style="text-align: center; font-weight: bold; font-size: 12px; vertical-align: middle;">
                            FORMULIR PENGUJIAN INFRASTRUKTUR
                        </td>
                        <td style="font-weight: bold;">Versi</td>
                        <td>: {{ $formTemplate->versi_dokumen ?? '002-2020' }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Halaman</td>
                        <td>: 1 dari 1</td>
                    </tr>
                </table>

                {{-- Tabel atas: No Ref, Tanggal, Business Area (narrow, kiri, seperti Word) --}}
                <table class="main-table" style="margin-top: 10px; width: 55%; border-right: 1px solid black;">
                    <tr>
                        <td style="width: 35%; font-weight: bold;">No Ref</td>
                        <td style="width: 3%; text-align: center; border-right: none;">:</td>
                        <td style="border-left: none;"><input type="text" name="no_ref" value="{{ old('no_ref', $form->no_ref) }}" class="form-input" placeholder="__ /__ /______"></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Tanggal</td>
                        <td style="text-align: center; border-right: none;">:</td>
                        <td style="border-left: none;">
                            @php
                                $formatted_tanggal = '';
                                if (old('tanggal')) {
                                    $formatted_tanggal = old('tanggal');
                                } elseif ($form->tanggal) {
                                    try {
                                        $formatted_tanggal = \Carbon\Carbon::createFromFormat('d-m-Y', $form->tanggal)->format('Y-m-d');
                                    } catch (\Exception $e) {
                                        try {
                                            $formatted_tanggal = \Carbon\Carbon::parse($form->tanggal)->format('Y-m-d');
                                        } catch (\Exception $ex) {
                                            $formatted_tanggal = $form->tanggal;
                                        }
                                    }
                                }
                            @endphp
                            <input type="date" id="tanggal" name="tanggal" value="{{ $formatted_tanggal }}" class="form-input">
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Business Area</td>
                        <td style="text-align: center; border-right: none;">:</td>
                        <td style="border-left: none;">
                            <select name="business_area" id="business_area" class="form-input">
                                <option value="">-- Pilih Business Area --</option>
                                @foreach ($businessAreas as $code => $label)
                                    <option value="{{ $code }}"
                                        {{ ($selectedKey === $code) ? 'selected' : '' }}>
                                        {{ $code }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                </table>

                {{-- Spasi pemisah seperti di Word --}}
                <div style="margin-top: 8px; margin-bottom: 8px;"></div>

                {{-- Tabel bawah: Tanggal Pengujian, Objek, Pelaksana (full width) --}}
                <table class="main-table" style="margin-top: 0;">
                    <tr>
                        <td style="width: 25%; font-weight: bold;">Tanggal Pengujian</td>
                        <td style="width: 2%; text-align: center; border-right: none;">:</td>
                        <td style="border-left: none;">
                            @php
                                $formatted_tanggal_pengujian = '';
                                if (old('tanggal_pengujian')) {
                                    $formatted_tanggal_pengujian = old('tanggal_pengujian');
                                } elseif ($form->tanggal_pengujian) {
                                    try {
                                        $formatted_tanggal_pengujian = \Carbon\Carbon::createFromFormat('d-m-Y', $form->tanggal_pengujian)->format('Y-m-d');
                                    } catch (\Exception $e) {
                                        try {
                                            $formatted_tanggal_pengujian = \Carbon\Carbon::parse($form->tanggal_pengujian)->format('Y-m-d');
                                        } catch (\Exception $ex) {
                                            $formatted_tanggal_pengujian = $form->tanggal_pengujian;
                                        }
                                    }
                                }
                            @endphp
                            <input type="date" id="tanggal_pengujian" name="tanggal_pengujian" value="{{ $formatted_tanggal_pengujian }}" class="form-input">
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Objek Pengujian</td>
                        <td style="text-align: center; border-right: none;">:</td>
                        <td style="border-left: none;"><input type="text" name="objek_pengujian" value="{{ old('objek_pengujian', $form->objek_pengujian) }}" class="form-input" placeholder="Isi Objek Pengujian"></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Pelaksana Pengujian</td>
                        <td style="text-align: center; border-right: none;">:</td>
                        <td style="border-left: none;"><input type="text" id="pelaksana_display" value="{{ old('pelaksana_pengujian', $form->pelaksana_pengujian) }}" class="form-input" readonly placeholder="Pilih dari dropdown di bawah">
                            <input type="hidden" name="pelaksana_pengujian" id="pelaksana_pengujian_val" value="{{ old('pelaksana_pengujian', $form->pelaksana_pengujian) }}">
                            <input type="hidden" name="pelaksana_nipp" id="pelaksana_nipp_val" value="{{ old('pelaksana_nipp', $form->pelaksana_nipp) }}">
                        </td>
                    </tr>
                </table>

                <div class="section-title" style="margin-top: 8px;">I. DESKRIPSI PENGUJIAN</div>
                <div style="border: 1px solid black; border-top: none; padding: 6px; min-height: 45px;">
                    <p style="color: #c00; font-style: italic; margin: 0 0 4px 0; font-size: 10px;">&lt;berisikan deskripsi objek yang akan dilakukan pengujian&gt;</p>
                    <textarea name="deskripsi_pengujian" class="form-input" placeholder="Isi deskripsi pengujian di sini...">{{ old('deskripsi_pengujian', $form->deskripsi_pengujian) }}</textarea>
                </div>

                <div class="section-title" style="margin-top: 8px;">II. ANALISA &amp; TINDAK LANJUT</div>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th rowspan="2" style="width: 4%;">No.</th>
                            <th rowspan="2">Rencana Pengujian</th>
                            <th colspan="2">Hasil Pengujian</th>
                            <th rowspan="2">Keterangan</th>
                            <th rowspan="2" class="action-col" style="width: 4%;"></th>
                        </tr>
                        <tr>
                            <th style="width: 10%;">OK</th>
                            <th style="width: 10%;">Not OK</th>
                        </tr>
                    </thead>
                    <tbody id="items-body">
                        @php
                            $existingItems = old('items', $items ?? []);
                        @endphp
                        @forelse ($existingItems as $index => $item)
                            @php
                                $rencana = is_array($item) ? ($item['rencana_pengujian'] ?? '') : $item->rencana_pengujian;
                                $hasil   = is_array($item) ? ($item['hasil'] ?? '') : $item->hasil;
                                $ket     = is_array($item) ? ($item['keterangan'] ?? '') : $item->keterangan;
                            @endphp
                            <tr>
                                <td class="no-col">{{ $index + 1 }}</td>
                                <td><textarea name="items[{{ $index }}][rencana_pengujian]" class="form-input">{{ $rencana }}</textarea></td>
                                <td class="hasil-col">
                                    <span class="hasil-checkbox {{ $hasil === 'OK' ? 'checked-ok' : '' }}"
                                          data-index="{{ $index }}" data-value="OK"
                                          onclick="toggleHasil(this)">
                                        {{ $hasil === 'OK' ? '✓' : '' }}
                                    </span>
                                    <input type="hidden" name="items[{{ $index }}][hasil]" class="hasil-value" value="{{ $hasil }}">
                                </td>
                                <td class="hasil-col">
                                    <span class="hasil-checkbox {{ $hasil === 'Not OK' ? 'checked-notok' : '' }}"
                                          data-index="{{ $index }}" data-value="Not OK"
                                          onclick="toggleHasil(this)">
                                        {{ $hasil === 'Not OK' ? '✗' : '' }}
                                    </span>
                                </td>
                                <td><textarea name="items[{{ $index }}][keterangan]" class="form-input">{{ $ket }}</textarea></td>
                                <td class="action-col">
                                    <button type="button" class="btn-delete-row" title="Hapus Baris">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/><path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/></svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
                <div style="text-align: left; margin-top: 2px;">
                    <button type="button" id="btn-add-row" class="btn-add-row">
                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="currentColor" viewBox="0 0 16 16"><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/></svg>
                        Tambah Baris
                    </button>
                </div>

                <div class="section-title" style="margin-top: 8px;">ANALISA HASIL DAN KESIMPULAN</div>
                <div class="analisa-box">
                    <p style="font-style: italic; text-decoration: underline; margin: 0 0 4px 0;">Analisa Hasil dan Kesimpulan:</p>
                    <p style="color: #c00; font-style: italic; margin: 0 0 4px 0; font-size: 10px;">&lt;Catatan / kesimpulan mengenai hasil pengujian (diisi oleh tester)&gt;</p>
                    <textarea name="analisa_kesimpulan" class="form-input" placeholder="Catatan / kesimpulan mengenai hasil pengujian (diisi oleh tester)">{{ old('analisa_kesimpulan', $form->analisa_kesimpulan) }}</textarea>
                </div>

                {{-- Penandatanganan --}}
                @php
                    $savedMengetahuiId = old('mengetahui_id', $form->mengetahui_id ?? null);
                    $selectedSigner    = null;
                    if ($savedMengetahuiId && isset($masterSigners)) {
                        $selectedSigner = $masterSigners->firstWhere('id', $savedMengetahuiId);
                    }
                    // Fallback: if no master signer selected but old name/jabatan exist
                    $displayNama    = $selectedSigner ? $selectedSigner->nama    : old('mengetahui_nama', $form->mengetahui_nama ?? '');
                    $displayJabatan = $selectedSigner ? $selectedSigner->jabatan : old('mengetahui_jabatan', $form->mengetahui_jabatan ?? '');
                    $displayNipp    = $selectedSigner ? ($selectedSigner->nipp ?? '') : '';
                @endphp

                {{-- Hidden inputs for signer data --}}
                <input type="hidden" name="mengetahui_id"      id="mengetahui_id_val"      value="{{ $savedMengetahuiId }}">
                <input type="hidden" name="mengetahui_nama"    id="mengetahui_nama_val"    value="{{ $displayNama }}">
                <input type="hidden" name="mengetahui_jabatan" id="mengetahui_jabatan_val" value="{{ $displayJabatan }}">

                <table class="signature-table">
                    <tr>
                        <td>
                            Mengetahui,<br>
                            <div id="display_jabatan" style="min-height:16px; font-size:11px;">{{ $displayJabatan }}</div>
                        </td>
                        <td>
                            <div>
                                <input type="text" name="kota_tanggal" value="{{ old('kota_tanggal', $form->kota_tanggal) }}" class="form-input" placeholder="Bandung, .. - .. - ...." style="text-align: center;">
                            </div>
                            Pelaksana Pengujian
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="signature-space"></div>
                            <div class="signature-name" id="display_nama">{{ $displayNama ? '(' . $displayNama . ')' : '(____________________)' }}</div>
                            @if($displayNipp)
                                <div style="font-size:10px;" id="display_nipp">NIPP: {{ $displayNipp }}</div>
                            @else
                                <div style="font-size:10px;" id="display_nipp"></div>
                            @endif
                            {{-- Dropdown pilih pejabat --}}
                            <div style="margin-top: 6px;">
                                <select id="signer_select" class="form-input" style="border: 1px dotted #aaa; font-size:10px;" onchange="onSignerChange(this)">
                                    <option value="">-- Pilih Penandatangan --</option>
                                    @if(isset($masterSigners))
                                        @foreach ($masterSigners as $signer)
                                            <option value="{{ $signer->id }}"
                                                    data-nama="{{ $signer->nama }}"
                                                    data-jabatan="{{ $signer->jabatan ?? '' }}"
                                                    data-nipp="{{ $signer->nipp ?? '' }}"
                                                    {{ $savedMengetahuiId == $signer->id ? 'selected' : '' }}>
                                                {{ $signer->nama }} — {{ $signer->jabatan ?? '' }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="signature-space"></div>
                            <div class="signature-name" id="display_pelaksana_nama">{{ old('pelaksana_pengujian', $form->pelaksana_pengujian) ? '(' . old('pelaksana_pengujian', $form->pelaksana_pengujian) . ')' : '(____________________)' }}</div>
                            <div style="font-size:10px;" id="display_pelaksana_nipp">{{ old('pelaksana_nipp', $form->pelaksana_nipp) ? 'NIPP: ' . old('pelaksana_nipp', $form->pelaksana_nipp) : '' }}</div>
                            {{-- Dropdown pilih pelaksana --}}
                            <div style="margin-top: 6px;">
                                <select id="pelaksana_select" class="form-input" style="border: 1px dotted #aaa; font-size:10px;" onchange="onPelaksanaChange(this)">
                                    <option value="">-- Pilih Pelaksana --</option>
                                    @if(isset($masterSigners))
                                        @foreach ($masterSigners as $signer)
                                            <option value="{{ $signer->id }}"
                                                    data-nama="{{ $signer->nama }}"
                                                    data-jabatan="{{ $signer->jabatan ?? '' }}"
                                                    data-nipp="{{ $signer->nipp ?? '' }}"
                                                    {{ old('pelaksana_pengujian', $form->pelaksana_pengujian) == $signer->nama ? 'selected' : '' }}>
                                                {{ $signer->nama }} — {{ $signer->jabatan ?? '' }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </td>
                    </tr>
                </table>

                <p style="margin-top: 8px; font-style: italic; font-size: 10px;">* beri tanda (&radic;) pada kolom Hasil Pengujian</p>

                @if(!isset($method) || $method !== 'GET')
                <div style="text-align: right; display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                    <a href="{{ route('form-pengujian-infrastruktur.index') }}" class="btn-kembali">Batal</a>
                    <button type="submit" class="btn-submit">{{ isset($method) && $method === 'PUT' ? 'Perbarui' : 'Simpan' }}</button>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>

<script>
// ── Business area data ─────────────────────────────────────────────────────────
var businessAreas = {
    'B010': 'DAOP 1 Jakarta',
    'B020': 'DAOP 2 Bandung',
    'B030': 'DAOP 3 Cirebon',
    'B040': 'DAOP 4 Semarang',
    'B050': 'DAOP 5 Purwokerto',
    'B060': 'DAOP 6 Yogyakarta',
    'B070': 'DAOP 7 Madiun',
    'B080': 'DAOP 8 Surabaya',
    'B090': 'DAOP 9 Jember',
    'B100': 'DIVRE 1 Medan',
    'B200': 'DIVRE 2 Padang',
    'B300': 'DIVRE 3 Palembang',
    'B400': 'DIVRE 4 Tanjungkarang',
};

function updateKotaTanggal(force = false) {
    var input = document.querySelector('input[name="kota_tanggal"]');
    if (!input || input.readOnly) return;
    
    // Jangan timpa jika sudah ada nilainya dari database (kecuali dipicu oleh event change)
    if (!force && input.value && input.value !== 'Bandung, .. - .. - ....') return;

    var ba = document.getElementById('business_area').value;
    var tgl = document.getElementById('tanggal').value;
    var kota = 'Bandung';
    
    if (ba && businessAreas[ba]) {
        var label = businessAreas[ba];
        var parts = label.split(' ');
        if (parts.length > 2) {
            kota = parts.slice(2).join(' '); // "DAOP 6 Yogyakarta" -> "Yogyakarta"
        } else if (parts.length === 2) {
            kota = parts[1];
        } else {
            kota = label;
        }
    }
    
    var formattedDate = '.. - .. - ....';
    if (tgl) {
        var d = new Date(tgl);
        var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        var day = String(d.getDate()).padStart(2, '0');
        var month = months[d.getMonth()];
        var year = d.getFullYear();
        formattedDate = day + ' ' + month + ' ' + year;
    }
    
    input.value = kota + ', ' + formattedDate;
}

document.getElementById('business_area').addEventListener('change', function() {
    updateKotaTanggal(true);
});

// ── Tanggal → Tanggal Pengujian & Kota auto-fill ─────────────────────────────────────
document.getElementById('tanggal').addEventListener('change', function () {
    var tpInput = document.getElementById('tanggal_pengujian');
    if (!tpInput.value) {
        tpInput.value = this.value;
    }
    updateKotaTanggal(true);
});

// Run once on load for create mode
document.addEventListener('DOMContentLoaded', function() {
    updateKotaTanggal(false);
});

// ── Row counter ────────────────────────────────────────────────────────────────
var currentRowCount = {{ count($existingItems ?? []) }};

// ── Checkbox toggle (exclusive per row) ────────────────────────────────────────
function toggleHasil(el) {
    var idx    = el.getAttribute('data-index');
    var val    = el.getAttribute('data-value');
    var row    = el.closest('tr');
    var all    = row.querySelectorAll('.hasil-checkbox');
    var hidden = row.querySelector('.hasil-value');

    var isAlreadyChecked = el.classList.contains('checked-ok') || el.classList.contains('checked-notok');

    // Clear all checkboxes in this row
    all.forEach(function (cb) {
        cb.classList.remove('checked-ok', 'checked-notok');
        cb.textContent = '';
    });
    if (hidden) hidden.value = '';

    if (!isAlreadyChecked) {
        // Set the clicked one
        if (val === 'OK') {
            el.classList.add('checked-ok');
            el.textContent = '✓';
        } else {
            el.classList.add('checked-notok');
            el.textContent = '✗';
        }
        if (hidden) hidden.value = val;
    }
}

// ── Add row ────────────────────────────────────────────────────────────────────
function addRow() {
    var tbody = document.getElementById('items-body');
    var tr    = document.createElement('tr');
    var idx   = currentRowCount;
    tr.innerHTML =
        '<td class="no-col">' + (idx + 1) + '</td>' +
        '<td><textarea name="items[' + idx + '][rencana_pengujian]" class="form-input"></textarea></td>' +
        '<td class="hasil-col">' +
            '<span class="hasil-checkbox" data-index="' + idx + '" data-value="OK" onclick="toggleHasil(this)"></span>' +
            '<input type="hidden" name="items[' + idx + '][hasil]" class="hasil-value" value="">' +
        '</td>' +
        '<td class="hasil-col">' +
            '<span class="hasil-checkbox" data-index="' + idx + '" data-value="Not OK" onclick="toggleHasil(this)"></span>' +
        '</td>' +
        '<td><textarea name="items[' + idx + '][keterangan]" class="form-input"></textarea></td>' +
        '<td class="action-col"><button type="button" class="btn-delete-row" title="Hapus Baris"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/><path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/></svg></button></td>';
    tbody.appendChild(tr);
    currentRowCount++;
}

document.getElementById('btn-add-row').addEventListener('click', addRow);

document.getElementById('items-body').addEventListener('click', function (e) {
    var btn = e.target.closest('.btn-delete-row');
    if (btn) {
        btn.closest('tr').remove();
        reindexRows();
    }
});

function reindexRows() {
    var rows = document.getElementById('items-body').querySelectorAll('tr');
    currentRowCount = rows.length;
    rows.forEach(function (row, index) {
        var tdNo = row.querySelector('td.no-col');
        if (tdNo) tdNo.textContent = index + 1;
        row.querySelectorAll('[name]').forEach(function (el) {
            el.name = el.name.replace(/items\[\d+\]/, 'items[' + index + ']');
        });
        row.querySelectorAll('.hasil-checkbox').forEach(function (cb) {
            cb.setAttribute('data-index', index);
        });
    });
}

// Ensure at least one empty row is present on a fresh create form
if (currentRowCount === 0) {
    addRow();
}

// ── Signer dropdown ────────────────────────────────────────────────────────────
function onSignerChange(select) {
    var opt = select.options[select.selectedIndex];
    var nama    = opt ? (opt.getAttribute('data-nama')    || '') : '';
    var jabatan = opt ? (opt.getAttribute('data-jabatan') || '') : '';
    var nipp    = opt ? (opt.getAttribute('data-nipp')    || '') : '';
    var id      = opt ? opt.value : '';

    document.getElementById('mengetahui_id_val').value      = id;
    document.getElementById('mengetahui_nama_val').value    = nama;
    document.getElementById('mengetahui_jabatan_val').value = jabatan;

    document.getElementById('display_jabatan').textContent = jabatan;
    document.getElementById('display_nama').textContent    = nama ? '(' + nama + ')' : '(____________________)';
    document.getElementById('display_nipp').textContent   = nipp ? 'NIPP: ' + nipp : '';
}

// ── Pelaksana dropdown ─────────────────────────────────────────────────────────
function onPelaksanaChange(select) {
    var opt = select.options[select.selectedIndex];
    var nama = opt ? (opt.getAttribute('data-nama') || '') : '';
    var nipp = opt ? (opt.getAttribute('data-nipp') || '') : '';

    document.getElementById('pelaksana_pengujian_val').value = nama;
    document.getElementById('pelaksana_nipp_val').value = nipp;
    document.getElementById('pelaksana_display').value = nama;

    document.getElementById('display_pelaksana_nama').textContent = nama ? '(' + nama + ')' : '(____________________)';
    document.getElementById('display_pelaksana_nipp').textContent = nipp ? 'NIPP: ' + nipp : '';
}
</script>
