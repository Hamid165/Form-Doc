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
        padding: 25mm 20mm;
        box-sizing: border-box;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
        font-size: 11px;
        color: #000;
        position: relative;
        min-height: 297mm;
    }
    
    /* Tabel Kop Surat */
    .kop-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
        font-size: 11px;
    }
    .kop-table td {
        border: 1px solid #000;
        padding: 4px 6px;
        vertical-align: middle;
    }
    .logo-cell {
        width: 15%;
        text-align: center;
        font-size: 24px;
        font-weight: 900;
        font-style: italic;
        letter-spacing: -1px;
        height: 38px;
    }
    .logo-k { color: #1f3b7c; }
    .logo-a { color: #e86424; }
    .logo-i { color: #1f3b7c; }
    
    .empty-box {
        width: 15%;
        height: 38px;
        background-color: white;
    }
    .title-cell {
        text-align: center;
        font-weight: bold;
        font-size: 12px;
        width: 45%;
    }
    .info-label { width: 15%; font-size: 11px; }
    .info-value { width: 25%; font-size: 11px; }

    /* Tabel Referensi */
    .ref-table {
        width: 35%;
        border-collapse: collapse;
        margin-bottom: 20px;
        font-size: 11px;
    }
    .ref-table td {
        border: 1px solid #000;
        padding: 4px;
    }
    .ref-table td:first-child { border-right: none; }
    .ref-table td:last-child { border-left: none; }
    .ref-label { width: 40%; }

    /* Area Info Pemohon */
    .applicant-info {
        display: table;
        width: calc(100% - 30px);
        font-size: 12px;
        margin-bottom: 15px;
        margin-left: 30px;
    }
    .form-row { display: table-row; }
    .form-row > div {
        display: table-cell;
        padding-bottom: 8px;
        vertical-align: bottom;
    }
    .form-label { width: 170px; font-weight: normal; }
    .form-colon { width: 20px; text-align: center; }

    /* Inputs */
    .form-input-inline {
        border: none;
        border-bottom: 1px solid #000;
        background: transparent;
        font-family: inherit;
        font-size: inherit;
        padding: 2px 4px;
        width: 100%;
        box-sizing: border-box;
    }
    .form-input-inline:focus { outline: none; border-bottom: 1px solid #00a4e4; }
    
    .form-input {
        width: 100%;
        box-sizing: border-box;
        border: none;
        padding: 4px;
        background-color: transparent;
        font-family: inherit;
        font-size: inherit;
    }
    .form-input:focus { border: 1px dashed #00a4e4; outline: none; }

    .line-short { width: 200px; display: inline-block; border-bottom: 1px solid #000; }
    .line-long { width: 370px; display: inline-block; border-bottom: 1px solid #000; }

    .desc-text {
        font-size: 12px;
        margin-bottom: 15px;
        margin-left: 30px;
    }

    /* Tabel Data Pengguna */
    .data-table {
        width: calc(100% - 30px);
        margin-left: 30px;
        border-collapse: collapse;
        margin-bottom: 5px;
        font-size: 12px;
    }
    .data-table th, .data-table td {
        border: 1px solid #000;
        padding: 0;
        position: relative;
    }
    .data-table th {
        background-color: #e6e6e6;
        font-weight: normal;
        text-align: center;
        padding: 8px;
    }
    .data-table td { height: 25px; }

    /* Bagian Tanda Tangan */
    .signature-section {
        text-align: center;
        font-size: 12px;
        margin-top: 30px;
    }
    .signature-box {
        display: inline-block;
        text-align: center;
        width: 100%;
        margin-bottom: 15px;
    }

    /* Buttons */
    .btn-submit {
        background-color: #16a34a; 
        color: white;
        padding: 6px 16px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        font-size: 13px;
        transition: background 0.2s;
        box-shadow: 0 2px 4px rgba(22,163,74,0.3);
    }
    .btn-submit:hover { background-color: #15803d; }
    
    .btn-cancel {
        background-color: #ef4444; 
        color: white;
        padding: 6px 16px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        font-size: 13px;
        transition: background 0.2s;
        box-shadow: 0 2px 4px rgba(239,68,68,0.3);
        margin-right: 10px;
        text-decoration: none;
    }
    .btn-cancel:hover { background-color: #dc2626; color: white; }
    
    .btn-tambah-baris {
        display: inline-flex; align-items: center; justify-content: center; height: 30px; padding: 4px 12px; background-color: #f59e0b; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 11px;
        transition: background-color 0.2s;
    }
    .btn-tambah-baris:hover { background-color: #d97706; }
    
    .btn-delete-row {
        position: absolute; 
        right: -32px; 
        top: 50%; 
        transform: translateY(-50%); 
        background-color: #fef2f2;
        border: none; 
        color: #dc2626;
        cursor: pointer; 
        padding: 6px; 
        border-radius: 6px;
        display: flex; 
        align-items: center; 
        justify-content: center;
        transition: all 0.2s;
    }
    .btn-delete-row:hover { background-color: #fee2e2; color: #b91c1c; transform: translateY(-50%) scale(1.1); }
    
    .btn-edit-ba {
        background-color: #fffbeb;
        color: #d97706;
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
    
    /* TomSelect Overrides */
    .ts-wrapper {
        width: 100%;
        font-family: inherit !important;
        font-size: inherit !important;
    }
    .ts-control {
        min-height: auto !important;
        padding: 0 16px 2px 0 !important;
        font-size: inherit !important;
        font-family: inherit !important;
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
    .ts-wrapper.has-items .ts-control > input,
    .ts-wrapper.no-search .ts-control > input {
        width: 0 !important;
        min-width: 0 !important;
        padding: 0 !important;
        margin: 0 !important;
        opacity: 0 !important;
        display: none !important;
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
        font-family: inherit !important;
        font-size: inherit !important;
        border-radius: 4px !important;
        border: 1px solid #00a4e4 !important;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1) !important;
        margin-top: 2px !important;
    }
    .ts-dropdown .option {
        padding: 6px 8px !important;
    }
    .ts-dropdown .option:hover, .ts-dropdown .option.active {
        background-color: #f3f4f6 !important;
        color: #00a4e4 !important;
    }
</style>

<div class="a4-wrapper" style="flex-direction: column; align-items: center;">
    <div style="width: 273mm; margin-bottom: 20px;">
        @if ($errors->has('no_ref'))
            <div class="relative flex items-center p-4 mb-6 border border-red-200 rounded-xl bg-red-50" role="alert">
                <div class="flex items-center justify-center w-10 h-10 bg-red-100 rounded-lg shrink-0">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-bold text-red-800">Gagal!</h3>
                    <p class="text-sm text-red-600 mt-0.5">{{ $errors->first('no_ref') }}</p>
                </div>
                <button type="button" class="absolute top-4 right-4 ml-auto text-red-400 hover:text-red-600 transition-colors" onclick="this.parentElement.style.display='none'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif
        
        <a href="{{ route('form-pencabutan-hak-akses.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors mb-6">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Formulir Pencabutan Hak Akses
        </a>
    </div>

    <div style="zoom: 1.3;">
        <div class="a4-container">
            <form id="pencabutan-form" action="{{ $action }}" method="POST">
                @csrf
                @if(isset($method) && $method === 'PUT')
                    @method('PUT')
                @endif
                
                <!-- Kop Surat -->
                <table class="kop-table">
                    <tr>
                        <td rowspan="2" class="logo-cell">
                            <span class="logo-k">K</span><span class="logo-a">A</span><span class="logo-i">I</span>
                        </td>
                        <td rowspan="2" class="title-cell">
                            PT KERETA API INDONESIA (PERSERO)<br>
                            SISTEM INFORMASI
                        </td>
                        <td class="info-label">Nomor</td>
                        <td class="info-value">{{ $formTemplate->no_dokumen ?? 'FR.SM/TI/013.004/10-2020' }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Tanggal</td>
                        <td class="info-value">{{ $formTemplate->tanggal_dokumen ?? '12 Oktober 2020' }}</td>
                    </tr>
                    <tr>
                        <td rowspan="2" class="empty-box"></td>
                        <td rowspan="2" class="title-cell">
                            FORMULIR<br>
                            PERMOHONAN PENCABUTAN HAK AKSES
                        </td>
                        <td class="info-label">Versi</td>
                        <td class="info-value">{{ $formTemplate->versi_dokumen ?? '002-2020' }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Halaman</td>
                        <td class="info-value">1 dari 2</td>
                    </tr>
                </table>

                <!-- Referensi -->
                <table class="ref-table">
                    <tr>
                        <td class="ref-label">No. Ref</td>
                        <td>: <input type="text" name="no_ref" value="{{ old('no_ref', $form->no_ref) }}" class="form-input-inline" style="width: 85%;" placeholder="Contoh: 01/02/2020" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')" {{ isset($method) && $method === 'PUT' ? 'readonly style=pointer-events:none;background:#f9f9f9;' : '' }}></td>
                    </tr>
                    <tr>
                        <td class="ref-label">Tanggal</td>
                        <td>: <input type="text" name="tanggal" value="{{ old('tanggal', $form->tanggal ? \Carbon\Carbon::parse($form->tanggal)->locale('id')->isoFormat('DD MMMM YYYY') : '') }}" class="form-input-inline custom-date-picker" data-format="id" style="width: 85%; cursor: pointer;" placeholder="Tanggal" autocomplete="off" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')" {{ isset($method) && $method === 'PUT' ? 'readonly' : '' }}></td>
                    </tr>
                    <tr>
                        <td class="ref-label">Business Area</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 4px;">
                                <span>:</span>
                                <div style="display: inline-flex; align-items: center; gap: 4px; width: 85%;">
                                    <input type="text" id="business_area_input" name="business_area" value="{{ old('business_area', $form->business_area ?: 'B060') }}" class="form-input-inline" style="pointer-events: none; background: #f9f9f9; flex: 1; border-bottom: none;" readonly required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')">
                                    <button type="button" onclick="unlockBusinessArea()" title="Edit Business Area" class="btn-edit-ba">
                                        <svg class="w-4 h-4" style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>

                <!-- Info Pemohon -->
                <div class="applicant-info">
                    <div class="form-row">
                        <div class="form-label">Tanggal Permohonan</div>
                        <div class="form-colon">:</div>
                        <div>
                            <div class="line-short">
                                <input type="text" name="tanggal_permohonan" value="{{ old('tanggal_permohonan', $form->tanggal_permohonan ? \Carbon\Carbon::parse($form->tanggal_permohonan)->locale('id')->isoFormat('DD MMMM YYYY') : '') }}" class="form-input-inline custom-date-picker" data-format="id" style="width:100%; border:none; padding:0; background:transparent; cursor: pointer;" placeholder="Tanggal Permohonan" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label">Nama Pemohon</div>
                        <div class="form-colon">:</div>
                        <div>
                            <div style="width: 370px; display:flex; align-items: flex-end;">
                                <div style="flex:1; position:relative;">
                                    <select id="nama_pemohon" name="nama_pemohon" class="form-input-inline custom-tomselect ts-align-left" data-placeholder="Nama Pemohon" required style="width:100%;">
                                        <option value=""></option>
                                        @foreach($masterPemohons ?? [] as $mp)
                                            <option value="{{ $mp->nama_pemohon }}" data-nip="{{ $mp->nip_pemohon }}" {{ old('nama_pemohon', $form->nama_pemohon) == $mp->nama_pemohon ? 'selected' : '' }}>{{ $mp->nama_pemohon }}</option>
                                        @endforeach
                                        @if(old('nama_pemohon', $form->nama_pemohon) && !collect($masterPemohons)->contains('nama_pemohon', old('nama_pemohon', $form->nama_pemohon)))
                                            <option value="{{ old('nama_pemohon', $form->nama_pemohon) }}" selected>{{ old('nama_pemohon', $form->nama_pemohon) }}</option>
                                        @endif
                                    </select>
                                </div>
                                <span style="margin: 0 6px 0 12px; white-space: nowrap;">NIP Pemohon :</span>
                                <div style="width: 120px; position:relative;">
                                    <select id="nip_pemohon" name="nip_pemohon" class="form-input-inline custom-tomselect ts-align-left" data-placeholder="NIP Pemohon" style="width: 100%;">
                                        <option value=""></option>
                                        @foreach($masterPemohons ?? [] as $mp)
                                            <option value="{{ $mp->nip_pemohon }}" data-nama="{{ $mp->nama_pemohon }}" {{ old('nip_pemohon', $form->nip_pemohon) == $mp->nip_pemohon ? 'selected' : '' }}>{{ $mp->nip_pemohon }}</option>
                                        @endforeach
                                        @if(old('nip_pemohon', $form->nip_pemohon) && !collect($masterPemohons)->contains('nip_pemohon', old('nip_pemohon', $form->nip_pemohon)))
                                            <option value="{{ old('nip_pemohon', $form->nip_pemohon) }}" selected>{{ old('nip_pemohon', $form->nip_pemohon) }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label">Bagian / Fungsi</div>
                        <div class="form-colon">:</div>
                        <div>
                            <div class="line-long" style="position:relative;">
                                <input type="text" name="bagian_fungsi" value="{{ old('bagian_fungsi', $form->bagian_fungsi) }}" class="form-input-inline" style="width:100%; border:none; padding:0; background:transparent;" placeholder="Bagian / Fungsi" required autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="desc-text">
                    dengan ini mengajukan permohonan pencabutan/penonaktifan Hak Akses untuk pengguna sebagai berikut.
                </div>

                <!-- Tabel Data Pengguna -->
                <table class="data-table" id="items-table">
                    <thead>
                        <tr>
                            <th style="width: 25%;">Nama Pengguna & NIP</th>
                            <th style="width: 25%;">Jenis Akun</th>
                            <th style="width: 25%;">Unit Kerja</th>
                            <th style="width: 25%;">Alasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $oldItems = old('items', $items ?? []);
                            $rowCount = max(4, count($oldItems));
                        @endphp
                        
                        @for ($i = 0; $i < $rowCount; $i++)
                            @php
                                $item = $oldItems[$i] ?? null;
                            @endphp
                            <tr class="item-row">
                                <td>
                                    <input type="text" name="items[{{$i}}][nama_pengguna]" value="{{ $item['nama_pengguna'] ?? '' }}" class="form-input">
                                </td>
                                <td>
                                    <input type="text" name="items[{{$i}}][jenis_akun]" value="{{ $item['jenis_akun'] ?? '' }}" class="form-input">
                                </td>
                                <td>
                                    <input type="text" name="items[{{$i}}][unit_kerja]" value="{{ $item['unit_kerja'] ?? '' }}" class="form-input">
                                </td>
                                <td>
                                    <input type="text" name="items[{{$i}}][alasan]" value="{{ $item['alasan'] ?? '' }}" class="form-input">
                                    
                                    @if($i >= 4)
                                    <button type="button" class="btn-delete-row" onclick="removeRow(this)" title="Hapus Baris">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
                
                <div style="margin-right: 0; margin-bottom: 20px; text-align: right;" class="no-print">
                    <button type="button" class="btn-tambah-baris" onclick="addRow()">
                        Tambah Baris
                    </button>
                </div>

                <!-- Bagian Tanda Tangan -->
                <div class="signature-section">
                    <div class="signature-box">
                        <div>
                            Bandung, 
                            <input type="text" name="kota_tanggal_pemohon" value="{{ old('kota_tanggal_pemohon', $form->kota_tanggal_pemohon) }}" class="form-input-inline custom-date-picker" data-format="id-dash" style="width: 130px; cursor: pointer;" autocomplete="off" required>
                        </div>
                        <div style="margin-top: 5px;">Pemohon</div>
                        <div style="margin-top: 80px;">
                            (<span id="teks_ttd_pemohon" style="display:inline-block; width: 220px; border-bottom: 1px dashed #000; padding-bottom: 2px; text-align: center;">
                                {{ old('nama_pemohon', $form->nama_pemohon ?? 'Ditandatangani oleh pemohon') }}
                            </span>)
                        </div>
                    </div>

                    <div class="signature-box" style="margin-top: 20px;">
                        <div>
                            Permohonan Pencabutan Hak Akses ini: 
                            <div style="display: inline-block; position: relative; width: 150px;">
                                <select name="status_persetujuan" class="form-input-inline ts-align-center custom-tomselect no-search" style="width: 100%; text-align: center;">
                                    <option value="DISETUJUI" {{ old('status_persetujuan', $form->status_persetujuan) == 'DISETUJUI' ? 'selected' : '' }}>DISETUJUI</option>
                                    <option value="TIDAK DISETUJUI" {{ old('status_persetujuan', $form->status_persetujuan) == 'TIDAK DISETUJUI' ? 'selected' : '' }}>TIDAK DISETUJUI</option>
                                </select>
                            </div>*
                        </div>
                        <div style="margin-top: 15px;">
                            Bandung, 
                            <input type="text" name="kota_tanggal_setuju" value="{{ old('kota_tanggal_setuju', $form->kota_tanggal_setuju) }}" class="form-input-inline custom-date-picker" data-format="id-dash" style="width: 130px; cursor: pointer;" autocomplete="off" required>
                        </div>
                        <div style="margin-top: 5px; position: relative; display: inline-block; width: 250px;">
                            <select name="jabatan_mengetahui" class="form-input-inline ts-align-center custom-tomselect no-search" data-placeholder="Jabatan" style="width: 100%; text-align: center;">
                                <option value=""></option>
                                <option value="Manajemen Puncak" {{ old('jabatan_mengetahui', $form->jabatan_mengetahui ?: 'Manajemen Puncak') == 'Manajemen Puncak' ? 'selected' : '' }}>Manajemen Puncak</option>
                                <option value="Pimpinan Unit Sistem Informasi" {{ old('jabatan_mengetahui', $form->jabatan_mengetahui) == 'Pimpinan Unit Sistem Informasi' ? 'selected' : '' }}>Pimpinan Unit Sistem Informasi</option>
                            </select>
                        </div>
                        <div style="margin-top: 80px;">
                            (<span style="display:inline-block; width: 220px; text-align: center; padding-bottom: 2px; position: relative;">
                                <input type="text" name="mengetahui_nama" class="form-input-inline" placeholder="Nama   " style="width: 100%; text-align: center; border-bottom: 1px dashed #000;" value="{{ old('mengetahui_nama', $form->mengetahui_nama) }}" autocomplete="off" required>
                            </span>)
                        </div>
                    </div>
                </div>
                
                <div class="no-print" style="margin-top: 30px; text-align: right; border-top: 1px solid #eaeaea; padding-top: 20px;">
                    <a href="{{ route('form-pencabutan-hak-akses.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">
                        {{ $form->exists ? 'Perbarui' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputTanggal = document.querySelector('input[name="tanggal"]');
        const inputTanggalPermohonan = document.querySelector('input[name="tanggal_permohonan"]');
        const inputKotaTanggalPemohon = document.querySelector('input[name="kota_tanggal_pemohon"]');
        const inputKotaTanggalSetuju = document.querySelector('input[name="kota_tanggal_setuju"]');

        if(inputTanggal || inputTanggalPermohonan) {
            function updateAllDates(selectedVal) {
                if(!selectedVal) return;
                
                if(inputTanggal && inputTanggal.value !== selectedVal) inputTanggal.value = selectedVal;
                if(inputTanggalPermohonan && inputTanggalPermohonan.value !== selectedVal) inputTanggalPermohonan.value = selectedVal;
                
                // Format the date with dashes for signature sections
                const dashedVal = selectedVal.split(' ').join(' - ');
                
                if(inputKotaTanggalPemohon && inputKotaTanggalPemohon.value !== dashedVal) inputKotaTanggalPemohon.value = dashedVal;
                if(inputKotaTanggalSetuju && inputKotaTanggalSetuju.value !== dashedVal) inputKotaTanggalSetuju.value = dashedVal;
            }

            if(inputTanggal) {
                inputTanggal.addEventListener('input', () => updateAllDates(inputTanggal.value));
                inputTanggal.addEventListener('change', () => updateAllDates(inputTanggal.value));
            }
            
            if(inputTanggalPermohonan) {
                inputTanggalPermohonan.addEventListener('input', () => updateAllDates(inputTanggalPermohonan.value));
                inputTanggalPermohonan.addEventListener('change', () => updateAllDates(inputTanggalPermohonan.value));
            }
        }
    });

    let rowIndex = {{ $rowCount }};
    
    function addRow() {
        const tbody = document.querySelector('#items-table tbody');
        const tr = document.createElement('tr');
        tr.className = 'item-row';
        tr.innerHTML = `
            <td>
                <input type="text" name="items[${rowIndex}][nama_pengguna]" class="form-input">
            </td>
            <td>
                <input type="text" name="items[${rowIndex}][jenis_akun]" class="form-input">
            </td>
            <td>
                <input type="text" name="items[${rowIndex}][unit_kerja]" class="form-input">
            </td>
            <td>
                <input type="text" name="items[${rowIndex}][alasan]" class="form-input">
                
                <button type="button" class="btn-delete-row" onclick="removeRow(this)" title="Hapus Baris">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
        rowIndex++;
    }
    
    function removeRow(btn) {
        const tr = btn.closest('tr');
        tr.remove();
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

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof TomSelect !== 'undefined') {
            document.querySelectorAll('.custom-tomselect').forEach(function(el) {
                let ts = new TomSelect(el, {
                    create: true,
                    sortField: { field: "text", direction: "asc" },
                    wrapperClass: 'ts-wrapper modern-select'
                });
                el.tomselect = ts; // Simpan instance untuk diakses nanti
            });

            // Sinkronisasi auto-fill Nama <-> NIP beserta Tabel dan Tanda Tangan
            const selectNama = document.getElementById('nama_pemohon');
            const selectNip = document.getElementById('nip_pemohon');
            
            if (selectNama && selectNip && selectNama.tomselect && selectNip.tomselect) {
                let isSyncing = false;

                selectNama.tomselect.on('change', function(value) {
                    if (isSyncing) return;
                    isSyncing = true;
                    if (value) {
                        let opt = Array.from(selectNama.options).find(o => o.value === value);
                        if (opt) {
                            let nip = opt.getAttribute('data-nip');
                            if (nip) selectNip.tomselect.setValue(nip, true);
                            
                            // Isi otomatis baris pertama di tabel Nama Pengguna & NIP
                            let firstItemInput = document.querySelector('input[name="items[0][nama_pengguna]"]');
                            if (firstItemInput) {
                                firstItemInput.value = value + (nip ? ' - ' + nip : '');
                                firstItemInput.dispatchEvent(new Event('input', { bubbles: true }));
                            }
                            
                            // Isi otomatis tanda tangan pemohon
                            let ttdPemohon = document.getElementById('teks_ttd_pemohon');
                            if (ttdPemohon) ttdPemohon.innerText = value || 'Ditandatangani oleh pemohon';
                        }
                    }
                    setTimeout(() => isSyncing = false, 50);
                });

                selectNip.tomselect.on('change', function(value) {
                    if (isSyncing) return;
                    isSyncing = true;
                    if (value) {
                        let opt = Array.from(selectNip.options).find(o => o.value === value);
                        if (opt) {
                            let nama = opt.getAttribute('data-nama');
                            if (nama) selectNama.tomselect.setValue(nama, true);
                            
                            // Isi otomatis baris pertama di tabel Nama Pengguna & NIP
                            let firstItemInput = document.querySelector('input[name="items[0][nama_pengguna]"]');
                            if (firstItemInput) {
                                firstItemInput.value = (nama ? nama + ' - ' : '') + value;
                                firstItemInput.dispatchEvent(new Event('input', { bubbles: true }));
                            }
                            
                            // Isi otomatis tanda tangan pemohon
                            let ttdPemohon = document.getElementById('teks_ttd_pemohon');
                            if (ttdPemohon) ttdPemohon.innerText = nama || 'Ditandatangani oleh pemohon';
                        }
                    }
                    setTimeout(() => isSyncing = false, 50);
                });
            }
            // Logika Wajib Isi pada Tabel Data Pengguna
            function checkRowValidation() {
                document.querySelectorAll('#items-table tbody tr').forEach(tr => {
                    const namaInput = tr.querySelector('input[name*="[nama_pengguna]"]');
                    if(namaInput) {
                        const isFilled = namaInput.value.trim() !== '';
                        const jenisAkun = tr.querySelector('input[name*="[jenis_akun]"]');
                        const unitKerja = tr.querySelector('input[name*="[unit_kerja]"]');
                        const alasan = tr.querySelector('input[name*="[alasan]"]');
                        
                        if(jenisAkun) jenisAkun.required = isFilled;
                        if(unitKerja) unitKerja.required = isFilled;
                        if(alasan) alasan.required = isFilled;
                    }
                });
            }
            
            const itemsTable = document.getElementById('items-table');
            if(itemsTable) {
                itemsTable.addEventListener('input', checkRowValidation);
                checkRowValidation(); // Jalankan saat pertama kali dimuat
            }
        }
    });
</script>
@endsection
