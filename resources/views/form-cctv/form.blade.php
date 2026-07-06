@extends('layouts.app')

@section('content')
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
        padding: 20mm;
        box-sizing: border-box;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11px;
        color: #000;
    }
    
    /* Table Reset */
    .a4-container table {
        border-collapse: collapse;
    }
    
    /* Header Table */
    .header-table, .main-table {
        width: 100%;
    }
    .header-table td {
        border: 1px solid black;
        padding: 5px 8px;
        vertical-align: middle;
    }
    .title-text {
        font-size: 11px;
        font-weight: bold;
        text-align: center;
    }
    .umum-box {
        border: 2px solid #5cb85c;
        color: #5cb85c;
        padding: 5px 15px;
        font-weight: bold;
        font-size: 14px;
        display: inline-block;
        margin: auto;
    }
    
    /* Info Section */
    .info-section {
        margin-top: 15px;
        margin-bottom: 15px;
    }
    .small-info-table {
        margin-bottom: 15px;
    }
    
    /* PENGATURAN UKURAN TABEL KIRI (NO REF) */
    .table-kiri {
        width: max-content; /* Lebar otomatis menyesuaikan isi agar garis batas kanan pas */
    }
    .kolom-label-kiri {
        width: 107px; /* Lebar khusus kolom tulisan "No Ref", "Tanggal", dll */
    }
    .input-garis-kiri {
        width: 100px; /* Panjang garis putus-putus untuk tempat mengisi */
    }

    /* PENGATURAN UKURAN TABEL KANAN (ID CCTV) */
    .table-kanan {
        width: max-content; /* Lebar otomatis menyesuaikan isi agar garis batas kanan pas */
    }
    .kolom-label-kanan {
        width: 107px; /* Lebar khusus kolom tulisan "ID CCTV" */
    }
    .input-garis-kanan {
        width: 100px; /* Panjang garis putus-putus untuk tempat mengisi */
    }
    .small-info-table td {
        border: 1px solid black;
        padding: 2px 5px;
        height: auto;
    }
    .small-info-table td:last-child {
        white-space: nowrap;
    }
    .info-text-row {
        display: flex;
        margin-bottom: 8px;
        align-items: center;
    }
    .info-text-label {
        width: 80px;
        font-weight: bold;
    }
    
    /* Main Checklist Table */
    .main-table th, .main-table td {
        border: 1px solid black;
        padding: 2px;
        vertical-align: middle;
    }
    .main-table th {
        font-weight: bold;
        text-align: center;
        vertical-align: middle;
        background-color: #f9f9f9;
    }
    
    /* Inputs */
    .form-input {
        width: 100%;
        box-sizing: border-box;
        border: none;
        padding: 1px;
        background-color: transparent;
        font-family: inherit;
        font-size: 11px;
    }
    .form-input:focus {
        border-color: #00a4e4;
        outline: none;
    }
    .form-input-inline {
        border: none;
        border-bottom: 1px dashed #000;
        background: transparent;
        font-family: inherit;
        font-size: inherit;
        width: 130px;
        padding: 2px 4px;
    }
    .form-input-inline:focus {
        outline: none;
        border-bottom: 1px solid #00a4e4;
    }
    
    /* Footer Signature */
    .footer-section {
        margin-top: 30px;
        width: 100%;
    }
    .signature-box {
        float: right;
        width: 200px;
        text-align: center;
        margin-right: 0;
    }
    .signature-box p {
        margin: 5px 0;
    }
    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }
    
    .btn-submit {
        background-color: #4CAF50;
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
        background-color: #388e3c;
    }
    
    .btn-kembali {
        display: inline-flex; align-items: center; justify-content: center; height: 30px; padding: 4px 12px; background-color: #f44336; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; font-family: inherit; font-size: 11px; box-sizing: border-box;
        transition: background-color 0.2s;
    }
    .btn-kembali:hover {
        background-color: #d32f2f;
    }

    .btn-tambah-baris {
        display: inline-flex; align-items: center; justify-content: center; height: 30px; padding: 4px 12px; background-color: #f39c12; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 11px;
        transition: background-color 0.2s;
    }
    .btn-tambah-baris:hover {
        background-color: #e67e22;
    }
    
    .btn-edit-ba {
        background-color: #fffbeb;
        color: #f59e0b;
        border: none;
        cursor: pointer;
        padding: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        transition: all 0.2s;
    }
    .btn-edit-ba:hover {
        background-color: #fef3c7;
        color: #b45309;
    }
    
    .btn-delete-row {
        position: absolute; 
        right: -24px; 
        top: 50%; 
        transform: translateY(-50%); 
        background-color: #e74c3c; 
        border: none; 
        color: white; 
        cursor: pointer; 
        padding: 3px 5px; 
        border-radius: 3px;
        display: flex; 
        align-items: center; 
        justify-content: center;
        transition: all 0.2s;
        box-shadow: 0 1px 2px rgba(231, 76, 60, 0.3);
    }
    .btn-delete-row:hover {
        background-color: #c0392b;
        color: white;
        transform: translateY(-50%) scale(1.1);
    }
    
    /* TomSelect Overrides */
    .ts-wrapper {
        width: 100%;
        font-family: 'Inter', ui-sans-serif, system-ui, sans-serif !important;
    }
    .ts-control {
        min-height: 24px !important;
        padding: 4px 16px 4px 0 !important;
        font-size: 11px !important;
        font-family: 'Inter', ui-sans-serif, system-ui, sans-serif !important;
        border: none !important;
        background: transparent !important;
        box-shadow: none !important;
        cursor: pointer !important;
        position: relative;
        text-align: center !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        flex-wrap: nowrap !important;
    }
    .ts-control > .item {
        text-align: center;
    }
    .ts-wrapper.has-items .ts-control > input {
        width: 0 !important;
        min-width: 0 !important;
        padding: 0 !important;
        margin: 0 !important;
        opacity: 0 !important;
    }
    .ts-wrapper.ts-align-left .ts-control {
        justify-content: flex-start !important;
    }
    .ts-wrapper.ts-align-left .ts-control > .item {
        text-align: left !important;
    }
    .ts-control::after {
        content: "\25BC";
        font-size: 9px;
        color: #00a4e4;
        position: absolute;
        right: 0px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
    }
    .ts-control.focus {
        border: none !important;
        box-shadow: none !important;
    }
    .ts-control > input {
        font-size: 11px !important;
        cursor: pointer !important;
    }
    .ts-dropdown {
        font-family: 'Inter', ui-sans-serif, system-ui, sans-serif !important;
        font-size: 11px !important;
        border-radius: 4px !important;
        border: 1px solid #00a4e4 !important;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1) !important;
        margin-top: 2px !important;
    }
    .ts-dropdown .option {
        padding: 6px 8px !important;
    }
    .ts-dropdown .option:hover, .ts-dropdown .option.active {
        background-color: #e6f7ff !important;
        color: #007bb5 !important;
    }
    
    /* Ensure native validation scroll doesn't stick to the top edge */
    input, select, textarea, .form-input, .form-input-inline {
        scroll-margin-top: 150px;
        scroll-margin-bottom: 150px;
    }
    
    /* Override TomSelect hiding the original select so HTML5 validation bubbles can show */
    select.tomselected {
        display: block !important;
        opacity: 0 !important;
        position: absolute !important;
        height: 1px !important;
        width: 1px !important;
        bottom: 0 !important;
        left: 50% !important;
        z-index: -1 !important;
        padding: 0 !important;
        margin: 0 !important;
    }
</style>


<div class="a4-wrapper" style="flex-direction: column; align-items: center;">
    <div style="width: 273mm; margin-bottom: 20px;">
        <a href="{{ route('form-cctv.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors mb-6">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Formulir Pemeliharaan CCTV
        </a>
    </div>
    <div style="zoom: 1.3;">
        <div class="a4-container">
            <form id="cctv-form" action="{{ $action }}" method="POST">
                @csrf
                @if(isset($method) && $method === 'PUT')
                    @method('PUT')
                @endif
            
            <table class="header-table">
                <tr>
                    <td rowspan="2" style="width: 15%; text-align: center;">
                        <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI" style="max-width: 100%; max-height: 50px;">
                    </td>
                    <td rowspan="2" class="title-text" style="width: 40%;">
                        PT KERETA API INDONESIA(PERSERO)<br>
                        SISTEM INFORMASI
                    </td>
                    <td style="width: 13%;">No. Dokumen</td>
                    <td style="width: 22%;">: FR.SM/TI/015.013/10-2020</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: 12 Oktober 2020</td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align: center;">
                        <div class="umum-box">UMUM</div>
                    </td>
                    <td rowspan="2" class="title-text">
                        FORMULIR CHECKLIST PEMELIHARAAN CCTV
                    </td>
                    <td>Versi</td>
                    <td>: 002-2020</td>
                </tr>
                <tr>
                    <td>Halaman</td>
                    <td>: </td>
                </tr>
            </table>

            <div class="info-section">
                <!-- PENGATURAN LEBAR TABEL KIRI (NO REF) -->
                <table class="small-info-table table-kiri">
                    <tr>
                        <td class="kolom-label-kiri">No Ref</td>
                        <td>: <input type="text" name="no_ref" value="{{ old('no_ref', $form->no_ref) }}" class="form-input-inline input-garis-kiri" placeholder="Contoh: 01 / 10 / 2020" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')" {{ isset($method) && $method === 'PUT' ? 'readonly style=pointer-events:none;background:#f9f9f9;' : '' }}></td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>: <input type="text" name="tanggal" value="{{ old('tanggal', $form->tanggal) }}" class="form-input-inline input-garis-kiri {{ isset($method) && $method === 'PUT' ? '' : 'custom-date-picker' }}" style="cursor: pointer; {{ isset($method) && $method === 'PUT' ? 'pointer-events:none;background:#f9f9f9;' : '' }}" placeholder="Tanggal" autocomplete="off" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')" {{ isset($method) && $method === 'PUT' ? 'readonly' : '' }}></td>
                    </tr>
                    <tr>
                        <td>Business Area</td>
                        <td>: 
                            <div style="display: inline-flex; align-items: center; gap: 4px;">
                                <input type="text" id="business_area_input" name="business_area" value="{{ old('business_area', $form->business_area ?: 'B060') }}" class="form-input-inline input-garis-kiri" style="pointer-events: none; background: #f9f9f9; width: 120px;" readonly required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')">
                                <button type="button" onclick="unlockBusinessArea()" title="Edit Business Area" class="btn-edit-ba">
                                    <svg class="w-4 h-4" style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </table>

                <!-- PENGATURAN LEBAR TABEL KANAN (ID CCTV) -->
                <table class="small-info-table table-kanan">
                <tr>
                    <td class="kolom-label-kanan" style="border: none;">ID CCTV</td>
                    <td style="border: none;">: 
                        <div style="display: inline-block; position: relative; width: 150px; {{ isset($method) && $method === 'PUT' ? 'pointer-events:none; opacity: 0.8;' : '' }}">
                            <select id="id_cctv" name="id_cctv" class="form-input-inline input-garis-kanan ts-align-left" style="appearance: none; cursor: pointer;" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" onchange="this.setCustomValidity('');" {{ isset($method) && $method === 'PUT' ? 'readonly' : '' }}>
                                <option value="">-- Pilih ID CCTV --</option>
                                @foreach($masterCctvs as $cctv)
                                <option value="{{ $cctv->id_cctv }}" data-lokasi="{{ $cctv->lokasi }}" {{ old('id_cctv', $form->id_cctv) == $cctv->id_cctv ? 'selected' : '' }}>{{ $cctv->id_cctv }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="kolom-label-kanan" style="border: none;">LOKASI</td>
                    <td style="border: none;">: 
                        <div style="display: inline-block; position: relative; width: 150px; {{ isset($method) && $method === 'PUT' ? 'pointer-events:none; opacity: 0.8;' : '' }}">
                            <select id="lokasi" name="lokasi" class="form-input-inline input-garis-kanan ts-align-left" style="appearance: none; cursor: pointer;" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" onchange="this.setCustomValidity('');" {{ isset($method) && $method === 'PUT' ? 'readonly' : '' }}>
                                <option value="">-- Pilih Lokasi --</option>
                                @foreach($masterCctvs as $cctv)
                                <option value="{{ $cctv->lokasi }}" data-id_cctv="{{ $cctv->id_cctv }}" {{ old('lokasi', $form->lokasi) == $cctv->lokasi ? 'selected' : '' }}>{{ $cctv->lokasi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                </tr>
            </table>
            </div>

            <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 10px; gap: 10px;">
                <div id="import-alert-container"></div>
                <button type="button" onclick="document.getElementById('importCctvItemsModal').classList.remove('hidden')" class="bg-green-600 hover:bg-green-700 text-white px-3 h-[30px] rounded-lg text-[11px] font-bold transition-all shadow-sm focus:ring-4 focus:ring-green-500/20 shrink-0 flex items-center gap-2" style="border: none; cursor: pointer;">
                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Import Tabel
                </button>
            </div>

            <table class="main-table">
                <thead>
                    <tr>
                        <th rowspan="2" style="width: 4%;">NO</th>
                        <th rowspan="2" style="width: 18%;">TANGGAL</th>
                        <th colspan="2" style="width: 28%;">JENIS KEGIATAN</th>
                        <th rowspan="2" style="width: 30%;">KETERANGAN</th>
                        <th rowspan="2" style="width: 20%;">PARAF</th>
                    </tr>
                    <tr>
                        <th>PERAWATAN</th>
                        <th>PERBAIKAN</th>
                    </tr>
                </thead>
                <tbody id="checklist-body">
                    @php
                        $items = $form->items->keyBy('no')->toArray();
                        $maxItems = max(20, count($items) > 0 ? max(array_keys($items)) : 0);
                    @endphp
                    @for ($i = 1; $i <= $maxItems; $i++)
                    @php
                        $item = $items[$i] ?? null;
                        $jenis = $item && isset($item['jenis_kegiatan']) ? json_decode($item['jenis_kegiatan'], true) : null;
                        $isPerawatan = $jenis && isset($jenis['perawatan']) && $jenis['perawatan'] == 'V';
                        $isPerbaikan = $jenis && isset($jenis['perbaikan']) && $jenis['perbaikan'] == 'V';
                        $isLocked = $item !== null && !empty($item['tanggal']) && isset($method) && $method === 'PUT';
                    @endphp
                    <tr>
                        <td style="text-align: center;">{{ $i }}<input type="hidden" name="items[{{ $i }}][no]" value="{{ $i }}"></td>
                        <td><input type="text" name="items[{{ $i }}][tanggal]" value="{{ $item['tanggal'] ?? '' }}" class="form-input {{ $isLocked ? '' : 'custom-date-picker' }}" data-format="id" autocomplete="off" style="text-align: center; cursor: pointer; {{ $isLocked ? 'pointer-events:none; background:#f9f9f9;' : '' }}" placeholder="Tanggal" {{ $i == 1 ? 'required' : '' }} oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')" {{ $isLocked ? 'readonly' : '' }}></td>
                        <td style="text-align: center;"><input type="checkbox" name="items[{{ $i }}][perawatan]" value="V" style="cursor: {{ $isLocked ? 'not-allowed' : 'pointer' }}; margin: 0 auto; display: block; {{ $isLocked ? 'pointer-events: none; opacity: 0.6;' : '' }}" class="chk-kegiatan-{{ $i }}" {{ $isPerawatan ? 'checked' : '' }} {{ $isLocked ? 'readonly tabindex="-1"' : '' }}></td>
                        <td style="text-align: center;"><input type="checkbox" name="items[{{ $i }}][perbaikan]" value="V" style="cursor: {{ $isLocked ? 'not-allowed' : 'pointer' }}; margin: 0 auto; display: block; {{ $isLocked ? 'pointer-events: none; opacity: 0.6;' : '' }}" class="chk-kegiatan-{{ $i }}" {{ $isPerbaikan ? 'checked' : '' }} {{ $isLocked ? 'readonly tabindex="-1"' : '' }}></td>
                        <td><input type="text" name="items[{{ $i }}][keterangan]" value="{{ $item['keterangan'] ?? '' }}" class="form-input" style="text-align: center; {{ $isLocked ? 'pointer-events:none; background:#f9f9f9;' : '' }}" {{ $isLocked ? 'readonly' : '' }}></td>
                        @if ($i > 20)
                        <td style="position: relative;">
                            <input type="text" name="items[{{ $i }}][paraf]" value="{{ $item['paraf'] ?? '' }}" class="form-input" style="text-align: center; {{ $isLocked ? 'pointer-events:none; background:#f9f9f9;' : '' }}" {{ $isLocked ? 'readonly' : '' }}>
                            @if (!$isLocked)
                            <button type="button" class="btn-delete-row no-print" title="Hapus Baris">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16" style="pointer-events: none;">
                                  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                </svg>
                            </button>
                            @endif
                        </td>
                        @else
                        <td><input type="text" name="items[{{ $i }}][paraf]" value="{{ $item['paraf'] ?? '' }}" class="form-input" style="text-align: center; {{ $isLocked ? 'pointer-events:none; background:#f9f9f9;' : '' }}" {{ $isLocked ? 'readonly' : '' }}></td>
                        @endif
                    </tr>
                    @endfor
                </tbody>
            </table>
            
            <div class="no-print" style="text-align: right; margin-top: 10px;">
                <button type="button" id="btn-add-row" class="btn-tambah-baris">Tambah Baris</button>
            </div>

            <div class="footer-section clearfix">
                <div class="signature-box">
                    <p>Yogyakarta, <input type="text" name="kota_tanggal" class="form-input-inline {{ isset($method) && $method === 'PUT' ? '' : 'custom-date-picker' }}" data-format="id" style="width: 130px; text-align: center; cursor: pointer; {{ isset($method) && $method === 'PUT' ? 'pointer-events:none; background:#f9f9f9;' : '' }}" value="{{ old('kota_tanggal', $form->kota_tanggal) }}" placeholder="Tanggal" autocomplete="off" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')" {{ isset($method) && $method === 'PUT' ? 'readonly' : '' }}></p>
                    <p style="margin-top: 15px;">Mengetahui,</p>
                    <p style="position: relative; margin-top: 5px;">
                        <select id="mengetahui_jabatan" name="mengetahui_jabatan" class="form-input-inline sync-signer" data-type="jabatan" style="width: 100%; text-align: center; appearance: none; cursor: pointer; text-align-last: center;">
                            <option value="">-- Pilih Jabatan --</option>
                            @foreach($masterSigners as $signer)
                            <option value="{{ $signer->jabatan }}" data-nama="{{ $signer->nama }}" data-nipp="{{ $signer->nipp }}" data-jabatan="{{ $signer->jabatan }}" {{ old('mengetahui_jabatan', $form->mengetahui_jabatan) == $signer->jabatan ? 'selected' : '' }}>{{ $signer->jabatan }}</option>
                            @endforeach
                        </select>
                    </p>
                    <div style="height: 60px;"></div>
                    <p style="position: relative;">
                        <select id="mengetahui_nama" name="mengetahui_nama" class="form-input-inline sync-signer" data-type="nama" style="width: 100%; text-align: center; appearance: none; cursor: pointer; text-align-last: center;" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')">
                            <option value="">-- Pilih Nama --</option>
                            @foreach($masterSigners as $signer)
                            <option value="{{ $signer->nama }}" data-nama="{{ $signer->nama }}" data-nipp="{{ $signer->nipp }}" data-jabatan="{{ $signer->jabatan }}" {{ old('mengetahui_nama', $form->mengetahui_nama) == $signer->nama ? 'selected' : '' }}>{{ $signer->nama }}</option>
                            @endforeach
                        </select>
                    </p>
                    <p style="position: relative; margin-top: 5px;">
                        <select id="mengetahui_nipp" name="mengetahui_nipp" class="form-input-inline sync-signer" data-type="nipp" style="width: 100%; text-align: center; appearance: none; cursor: pointer; text-align-last: center;" required>
                            <option value="">-- Pilih NIPP --</option>
                            @foreach($masterSigners as $signer)
                            <option value="{{ $signer->nipp }}" data-nama="{{ $signer->nama }}" data-nipp="{{ $signer->nipp }}" data-jabatan="{{ $signer->jabatan }}" {{ old('mengetahui_nipp', $form->mengetahui_nipp) == $signer->nipp ? 'selected' : '' }}>NIPP. {{ $signer->nipp }}</option>
                            @endforeach
                        </select>
                    </p>
                </div>
            </div>

            <div style="text-align: right; display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; align-items: center;">
                <a href="{{ route('form-cctv.index') }}" class="btn-kembali">Batal</a>
                <button type="submit" class="btn-submit" style="margin-top: 0;">{{ isset($method) && $method === 'PUT' ? 'Perbarui' : 'Simpan' }}</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // === Form validation ===
    var form = document.getElementById('cctv-form');
    if (form) {
        form.addEventListener('invalid', function(e) {
            var firstInvalid = form.querySelector(':invalid');
            if (firstInvalid && firstInvalid === e.target) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }, true);
    }

    // === Checkbox validation for row 1 ===
    var chkPerawatan = document.querySelector('input[name="items[1][perawatan]"]');
    var chkPerbaikan = document.querySelector('input[name="items[1][perbaikan]"]');
    var btnSubmit = document.querySelector('.btn-submit');

    function clearCheckboxValidity() {
        if (chkPerawatan) chkPerawatan.setCustomValidity('');
    }
    if (chkPerawatan) chkPerawatan.addEventListener('change', clearCheckboxValidity);
    if (chkPerbaikan) chkPerbaikan.addEventListener('change', clearCheckboxValidity);

    if (btnSubmit) {
        btnSubmit.addEventListener('click', function() {
            if (chkPerawatan && chkPerbaikan) {
                if (!chkPerawatan.checked && !chkPerbaikan.checked) {
                    chkPerawatan.setCustomValidity('Bagian Jenis Kegiatan (Perawatan/Perbaikan) pada baris pertama harus diisi');
                } else {
                    chkPerawatan.setCustomValidity('');
                }
            }
        });
    }

    // === TomSelect Initialization ===
    if (typeof TomSelect !== 'undefined') {
        // --- ID CCTV <-> LOKASI sync ---
        var tsIdCctv = new TomSelect("#id_cctv", {
            create: false,
            sortField: { field: "text", direction: "asc" },
            placeholder: "ID CCTV"
        });

        var tsLokasi = new TomSelect("#lokasi", {
            create: false,
            sortField: { field: "text", direction: "asc" },
            placeholder: "LOKASI"
        });

        var isSyncingCctv = false;

        tsIdCctv.on('change', function(value) {
            if (isSyncingCctv) return;
            isSyncingCctv = true;
            if (value) {
                var opt = Array.from(document.getElementById('id_cctv').options).find(function(o) { return o.value === value; });
                if (opt) tsLokasi.setValue(opt.getAttribute('data-lokasi'), true);
            } else {
                tsLokasi.setValue('', true);
            }
            setTimeout(function() { isSyncingCctv = false; }, 50);
        });

        tsLokasi.on('change', function(value) {
            if (isSyncingCctv) return;
            isSyncingCctv = true;
            if (value) {
                var opt = Array.from(document.getElementById('lokasi').options).find(function(o) { return o.value === value; });
                if (opt) tsIdCctv.setValue(opt.getAttribute('data-id_cctv'), true);
            } else {
                tsIdCctv.setValue('', true);
            }
            setTimeout(function() { isSyncingCctv = false; }, 50);
        });

        // --- NAMA <-> NIPP <-> JABATAN sync ---
        var tomNama = new TomSelect("#mengetahui_nama", { create: false, placeholder: "-- Pilih Nama --" });
        var tomNipp = new TomSelect("#mengetahui_nipp", { create: false, placeholder: "-- Pilih NIPP --" });
        var tomJabatan = new TomSelect("#mengetahui_jabatan", { create: false, placeholder: "-- Pilih Jabatan --" });

        var isSyncingSigner = false;

        function syncSigners(source, val) {
            if (isSyncingSigner) return;
            isSyncingSigner = true;

            if (!val) {
                tomNama.clear(true);
                tomNipp.clear(true);
                tomJabatan.clear(true);
                setTimeout(function() { isSyncingSigner = false; }, 100);
                return;
            }

            var sourceSelect = document.getElementById('mengetahui_' + source);
            var option = Array.from(sourceSelect.options).find(function(o) { return o.value == val; });
            if (!option) {
                setTimeout(function() { isSyncingSigner = false; }, 100);
                return;
            }

            var nama = option.getAttribute('data-nama') || '';
            var nipp = option.getAttribute('data-nipp') || '';
            var jabatan = option.getAttribute('data-jabatan') || '';

            if (source !== 'nama') {
                tomNama.setValue(nama, true);
            }

            if (source !== 'nipp') {
                tomNipp.setValue(nipp, true);
            }

            if (source !== 'jabatan') {
                tomJabatan.setValue(jabatan, true);
            }

            setTimeout(function() { isSyncingSigner = false; }, 100);
        }

        tomNama.on('change', function(val) { syncSigners('nama', val); });
        tomNipp.on('change', function(val) { syncSigners('nipp', val); });
        tomJabatan.on('change', function(val) { syncSigners('jabatan', val); });

        // Initial sync on page load (for edit mode)
        if (tomNama.getValue()) {
            syncSigners('nama', tomNama.getValue());
        } else if (tomNipp.getValue()) {
            syncSigners('nipp', tomNipp.getValue());
        } else if (tomJabatan.getValue()) {
            syncSigners('jabatan', tomJabatan.getValue());
        }
    }
});

// === Add Row ===
var currentRowCount = {{ isset($maxItems) ? $maxItems : 20 }};
document.getElementById('btn-add-row').addEventListener('click', function() {
    currentRowCount++;
    var tbody = document.getElementById('checklist-body');
    var tr = document.createElement('tr');
    tr.innerHTML = '<td class="text-center">' + currentRowCount + '<input type="hidden" name="items[' + currentRowCount + '][no]" value="' + currentRowCount + '"></td>' +
        '<td><input type="text" name="items[' + currentRowCount + '][tanggal]" class="form-input custom-date-picker" data-format="id" autocomplete="off" style="text-align: center; cursor: pointer;" placeholder="Tanggal"></td>' +
        '<td style="text-align: center;"><input type="checkbox" name="items[' + currentRowCount + '][perawatan]" value="V" style="cursor: pointer; margin: 0 auto; display: block;"></td>' +
        '<td style="text-align: center;"><input type="checkbox" name="items[' + currentRowCount + '][perbaikan]" value="V" style="cursor: pointer; margin: 0 auto; display: block;"></td>' +
        '<td><input type="text" name="items[' + currentRowCount + '][keterangan]" class="form-input" style="text-align: center;"></td>' +
        '<td style="position: relative;"><input type="text" name="items[' + currentRowCount + '][paraf]" class="form-input" style="text-align: center;">' +
        '<button type="button" class="btn-delete-row no-print" title="Hapus Baris"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16" style="pointer-events: none;"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/><path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/></svg></button></td>';
    tbody.appendChild(tr);
});

// === Delete Row ===
document.getElementById('checklist-body').addEventListener('click', function(e) {
    var btn = e.target.closest('.btn-delete-row');
    if (btn) {
        btn.closest('tr').remove();
        reindexRows();
    }
});

// === Mutually exclusive checkboxes ===
document.getElementById('checklist-body').addEventListener('change', function(e) {
    if (e.target.matches('input[type="checkbox"]')) {
        var row = e.target.closest('tr');
        if (e.target.name.includes('[perawatan]') && e.target.checked) {
            var perbaikan = row.querySelector('input[name*="[perbaikan]"]');
            if (perbaikan) perbaikan.checked = false;
        } else if (e.target.name.includes('[perbaikan]') && e.target.checked) {
            var perawatan = row.querySelector('input[name*="[perawatan]"]');
            if (perawatan) perawatan.checked = false;
        }
    }
});

function reindexRows() {
    var rows = document.getElementById('checklist-body').querySelectorAll('tr');
    currentRowCount = rows.length;
    rows.forEach(function(row, index) {
        var no = index + 1;
        var tdNo = row.querySelector('td:first-child');
        if (tdNo) {
            var hiddenInput = tdNo.querySelector('input[type="hidden"]');
            tdNo.innerHTML = no;
            if (hiddenInput) {
                hiddenInput.value = no;
                tdNo.appendChild(hiddenInput);
            }
        }
        row.querySelectorAll('input').forEach(function(input) {
            if (input.name) {
                input.name = input.name.replace(/items\[\d+\]/, "items[" + no + "]");
            }
        });
    });
}

function unlockBusinessArea() {
    var input = document.getElementById('business_area_input');
    if (input.hasAttribute('readonly')) {
        input.removeAttribute('readonly');
        input.style.pointerEvents = 'auto';
        input.style.background = 'transparent';
        input.focus();
    } else {
        input.setAttribute('readonly', 'readonly');
        input.style.pointerEvents = 'none';
        input.style.background = '#f9f9f9';
    }
}
</script>

<!-- Import Modal for Form Items -->
<div id="importCctvItemsModal" class="fixed inset-0 z-[100] hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 m-4" style="font-family: 'Inter', sans-serif;">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900 m-0">Import Isi Tabel CCTV</h3>
            <button type="button" onclick="document.getElementById('importCctvItemsModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition-colors bg-transparent border-none cursor-pointer">
                <svg class="w-6 h-6" style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <div class="mb-5">
            <p class="text-sm text-gray-600 mb-3 mt-0">Silakan upload file Excel berformat .xlsx yang berisi data tabel kegiatan.</p>
            <a href="{{ route('form-cctv.template-items') }}" class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800 hover:underline mb-4" style="text-decoration: none;">
                <svg class="w-4 h-4" style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Download Template Excel (XLSX)
            </a>
            
            <label class="block text-[12px] font-bold uppercase tracking-wider text-slate-500 mb-2">File Excel <span class="text-red-500 ml-1">*</span></label>
            <div class="relative flex items-center border-2 border-slate-200 rounded-lg bg-slate-50 hover:bg-slate-100 transition-colors cursor-pointer w-full h-[42px] px-3 focus-within:border-blue-500 focus-within:ring-4 focus-within:ring-blue-500/10">
                <input type="file" id="file_import_items_modal" accept=".xlsx, .xls" class="w-full text-sm text-slate-700 file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer outline-none">
            </div>
        </div>
        
        <div class="flex justify-end gap-3 mt-6">
            <button type="button" onclick="document.getElementById('importCctvItemsModal').classList.add('hidden')" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 h-[42px] rounded-lg text-sm font-semibold transition-all border-none cursor-pointer">Batal</button>
            <button type="button" onclick="processImportItems(this)" class="bg-blue-600 hover:bg-blue-700 text-white px-5 h-[42px] rounded-lg text-sm font-semibold transition-all shadow-sm border-none cursor-pointer">Import Data</button>
        </div>
    </div>
</div>

<script>
function processImportItems(btn) {
    var input = document.getElementById('file_import_items_modal');
    if (!input.files || input.files.length === 0) return;

    var file = input.files[0];
    var formData = new FormData();
    formData.append('file', file);
    formData.append('_token', '{{ csrf_token() }}');

    // Tampilkan loading state
    var originalBtnHtml = btn.innerHTML;
    btn.innerHTML = 'Memproses...';
    btn.disabled = true;

    fetch('{{ route('form-cctv.parse-excel') }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.success && result.data && result.data.length > 0) {
            var tbody = document.getElementById('checklist-body');
            var existingRows = Array.from(tbody.querySelectorAll('tr'));
            
            // Helper function to parse Indonesian dates
            function parseIndoDate(dateStr) {
                if (!dateStr) return null;
                dateStr = dateStr.toString().trim();
                if (/^\d{4}-\d{2}-\d{2}$/.test(dateStr)) return new Date(dateStr);
                
                const months = {
                    'januari': 0, 'februari': 1, 'maret': 2, 'april': 3, 'mei': 4, 'juni': 5,
                    'juli': 6, 'agustus': 7, 'september': 8, 'oktober': 9, 'november': 10, 'desember': 11
                };
                let parts = dateStr.toLowerCase().split(' ');
                if (parts.length === 3) {
                    let d = parseInt(parts[0]);
                    let m = months[parts[1]];
                    let y = parseInt(parts[2]);
                    if (!isNaN(d) && m !== undefined && !isNaN(y)) return new Date(y, m, d);
                }
                let d = new Date(dateStr);
                return isNaN(d.getTime()) ? null : d;
            }
            
            // Find the first empty row index
            var firstEmptyIndex = existingRows.findIndex(row => {
                var inputTanggal = row.querySelector('input[name*="[tanggal]"]');
                var inputKet = row.querySelector('input[name*="[keterangan]"]');
                return (!inputTanggal || inputTanggal.value.trim() === '') && 
                       (!inputKet || inputKet.value.trim() === '');
            });

            if (firstEmptyIndex === -1) firstEmptyIndex = existingRows.length;
            
            // Find last filled date
            var lastFilledDateObj = null;
            for (let i = firstEmptyIndex - 1; i >= 0; i--) {
                let inputTanggal = existingRows[i].querySelector('input[name*="[tanggal]"]');
                if (inputTanggal && inputTanggal.value.trim() !== '') {
                    lastFilledDateObj = parseIndoDate(inputTanggal.value);
                    if (lastFilledDateObj) break;
                }
            }

            // Filter data based on date
            let currentLastDate = lastFilledDateObj;
            let validItems = [];
            
            result.data.forEach(item => {
                let itemDate = parseIndoDate(item.tanggal);
                if (!itemDate) return;
                
                if (!currentLastDate || itemDate.getTime() > currentLastDate.getTime()) {
                    validItems.push(item);
                    currentLastDate = itemDate;
                }
            });
            
            if (validItems.length === 0) {
                showImportAlert('Tidak ada data yang diimpor. Pastikan tanggal data yang diunggah lebih baru dari tanggal baris terakhir dan tidak ada duplikat.', 'error');
                return;
            }

            validItems.forEach((item, i) => {
                var rowIndex = firstEmptyIndex + i;
                
                // If we need more rows, create them
                if (rowIndex >= existingRows.length) {
                    addRow();
                    existingRows = Array.from(tbody.querySelectorAll('tr'));
                }
                
                var row = existingRows[rowIndex];
                if (row) {
                    var inTanggal = row.querySelector('input[name*="[tanggal]"]');
                    var inKet = row.querySelector('input[name*="[keterangan]"]');
                    var inParaf = row.querySelector('input[name*="[paraf]"]');
                    var chkPerawatan = row.querySelector('input[name*="[perawatan]"]');
                    var chkPerbaikan = row.querySelector('input[name*="[perbaikan]"]');

                    if (inTanggal && item.tanggal) {
                        inTanggal.value = item.tanggal;
                        inTanggal.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                    if (inKet && item.keterangan) inKet.value = item.keterangan;
                    if (inParaf && item.paraf) inParaf.value = item.paraf;
                    if (chkPerawatan) chkPerawatan.checked = (item.perawatan === 'V');
                    if (chkPerbaikan) chkPerbaikan.checked = (item.perbaikan === 'V');
                }
            });
            
            showImportAlert(validItems.length + ' data berhasil diimpor!', 'success');
            document.getElementById('importCctvItemsModal').classList.add('hidden');
        } else {
            showImportAlert(result.message || 'Gagal membaca file atau file kosong.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showImportAlert('Terjadi kesalahan saat menghubungi server.', 'error');
    })
    .finally(() => {
        // Reset file input & button
        input.value = '';
        btn.innerHTML = originalBtnHtml;
        btn.disabled = false;
    });
}

function showImportAlert(message, type) {
    var container = document.getElementById('import-alert-container');
    if (!container) return;
    
    var isSuccess = type === 'success';
    var bgColor = isSuccess ? 'bg-[#f0fdf4] border-[#bbf7d0]' : 'bg-[#fef2f2] border-[#fecaca]';
    var iconBg = isSuccess ? 'bg-[#dcfce7]' : 'bg-[#fee2e2]';
    var iconText = isSuccess ? 'text-[#059669]' : 'text-[#ef4444]';
    var titleText = isSuccess ? 'text-[#065f46]' : 'text-[#991b1b]';
    var msgText = isSuccess ? 'text-[#059669]' : 'text-[#b91c1c]';
    var title = isSuccess ? 'Berhasil!' : 'Gagal!';
    
    var iconSvg = isSuccess 
        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>' 
        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
        
    container.innerHTML = `
        <div class="m-0 ${bgColor} border rounded-lg flex items-center px-3 shadow-sm transition-opacity duration-300 h-[30px]" id="dynamic-alert">
            <svg class="w-4 h-4 ${iconText} mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${iconSvg}
            </svg>
            <span class="text-[11px] font-bold ${msgText}">${message}</span>
        </div>
    `;
    
    setTimeout(() => {
        var el = document.getElementById('dynamic-alert');
        if (el) {
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 300);
        }
    }, 5000);
}
</script>
@endsection
