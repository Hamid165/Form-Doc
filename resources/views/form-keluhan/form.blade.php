@extends('layouts.app')

@section('content')
<style>
    .a4-wrapper {
        display: flex;
        justify-content: center;
        padding: 20px;
    }

    .a4-container {
        width: 297mm;
        background: white;
        padding: 15mm;
        box-sizing: border-box;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11px;
        color: #000;
    }

    .a4-container table {
        border-collapse: collapse;
    }

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

    .info-section {
        margin-top: 15px;
        margin-bottom: 15px;
    }
    
    .small-info-table {
        margin-bottom: 15px;
    }

    .table-kiri {
        width: max-content;
    }
    
    .kolom-label-kiri {
        width: 107px;
    }
    
    .input-garis-kiri {
        width: 160px;
    }
    
    .small-info-table td {
        border: 1px solid black;
        padding: 2px 5px;
        height: auto;
    }
    
    .small-info-table td:last-child {
        white-space: nowrap;
    }

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

    .form-input {
        width: 100%;
        box-sizing: border-box;
        border: none;
        padding: 1px;
        background-color: transparent;
        font-family: inherit;
        font-size: 11px;
        resize: vertical;
    }
    
    .form-input:focus {
        border-color: #00a4e4;
        outline: none;
    }      
    
    .main-table textarea.form-input {
        resize: none;
    }
    
    .main-table input.custom-date-picker.form-input {
        font-size: 10px;
        padding: 1px 0;
        letter-spacing: -0.2px;
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
    
    .signature-box-left {
        float: left;
        width: 200px;
        text-align: center;
        margin-left: 0;
    }
    
    .signature-box p, .signature-box-left p {
        margin: 5px 0;
    }
    
    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }
    
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

    .btn-tambah-baris {
        display: inline-flex; align-items: center; justify-content: center; height: 30px; padding: 4px 12px; background-color: #f59e0b; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 11px;
        transition: background-color 0.2s;
    }
    
    .btn-tambah-baris:hover {
        background-color: #d97706;
    }

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
    
    .btn-delete-row:hover {
        background-color: #fee2e2;
        color: #b91c1c;
        transform: translateY(-50%) scale(1.1);
    }

    input, select, textarea, .form-input, .form-input-inline {
        scroll-margin-top: 150px;
        scroll-margin-bottom: 150px;
    }

    @media screen and (max-width: 768px) {
        
        .a4-wrapper {
            padding: 10px !important;
        }
        
        .a4-container {
            width: 100% !important;
            padding: 15px !important;
            box-shadow: none !important;
        }
        
        .info-section {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 15px;
        }
        
        .a4-container table {
            min-width: 900px;
        }
        
        .header-table {
            min-width: 900px;
        }
        
        .footer-section {
            flex-direction: column;
        }
        
        .zoom-container {
            zoom: 1 !important;
        }
        
        .top-nav-container {
            width: 100% !important;
        }
    }
</style>

<div class="a4-wrapper" style="flex-direction: column; align-items: center;">
    <div class="top-nav-container" style="width: 100%; max-width: 297mm; margin-bottom: 20px;">
        <a href="{{ route('form-keluhan.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors mb-6">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>Kembali ke Daftar Formulir Pengelolaan dan Penanganan Keluhan
        </a>
    </div>
    <div class="zoom-container" style="zoom: 1.1; width: 100%; display: flex; justify-content: center;">
        <div class="a4-container" style="max-width: 100%; overflow-x: auto;">
            <form id="keluhan-form" action="{{ $action }}" method="POST">
                @csrf
                @if(isset($method) && $method === 'PUT')
                    @method('PUT')
                @endif

            @php
            
            $kategori = strtoupper($formTemplate->kategori ?? 'Terbatas');
             if ($kategori === 'PUBLIC' || $kategori === 'ALL') {
                $kategori = 'UMUM';
             }  
             $borderColor = '#5cb85c';
              if ($kategori === 'TERBATAS') { 
                 $borderColor = '#eadc04';
                 } elseif ($kategori === 'RAHASIA') {
                     $borderColor = '#d9534f';
                    }
            @endphp

            <div class="table-responsive">
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
                    <td style="width: 22%;">: {{ $formTemplate->no_dokumen ?? 'FR.SM/TI/033.001/10-2020' }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: {{ $formTemplate->tanggal_dokumen ?? '12 Oktober 2020' }}</td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align: center;">
                        <div class="umum-box" style="border-color: {{ $borderColor }}; color: {{ $borderColor }};">{{ $kategori }}</div>
                    </td>
                    <td rowspan="2" class="title-text">
                        DOKUMENTASI PENGELOLAAN DAN PENANGANAN KELUHAN PELANGGAN
                    </td>
                    <td>Versi</td>
                    <td>: {{ $formTemplate->versi_dokumen ?? '002-2020' }}</td>
                </tr>
                <tr>
                    <td>Halaman</td>
                    <td>: </td>
                </tr>
            </table>
            </div>

            <div class="info-section">
                <table class="small-info-table table-kiri">
                    <tr>
                        <td class="kolom-label-kiri">No Ref</td>
                        <td>: <input type="text" name="no_ref" value="{{ old('no_ref', $form->no_ref) }}" class="form-input-inline input-garis-kiri" placeholder="Contoh: 01 / 10 / 2020" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')" {{ isset($method) && $method === 'PUT' ? 'readonly style=pointer-events:none;background:#f9f9f9;' : '' }}></td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>: <input type="text" name="tanggal" value="{{ old('tanggal', $form->tanggal) }}" class="form-input-inline input-garis-kiri {{ isset($method) && $method === 'PUT' ? '' : 'custom-date-picker' }}" style="cursor: pointer; {{ isset($method) && $method === 'PUT' ? 'pointer-events:none;background:#f9f9f9;' : '' }}" placeholder="Tanggal" autocomplete="off" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')" {{ isset($method) && $method === 'PUT' ? 'readonly' : '' }}></td>
                    </tr>
                </table>
            </div>

            <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                       <th rowspan="2" style="width: 3%;">NO</th>
                       <th rowspan="2" style="width: 11%;">TANGGAL</th>
                       <th rowspan="2" style="width: 11%;">PELANGGAN</th>
                       <th rowspan="2" style="width: 10%;">SUMBER</th>
                       <th rowspan="2" style="width: 15%;">DESKRIPSI KELUHAN</th>
                       <th rowspan="2" style="width: 15%;">TINDAKAN PERBAIKAN DAN PENCEGAHAN YANG DIAMBIL</th>
                       <th colspan="3" style="width: 21%;">VERIFICATION</th>
                       <th rowspan="2" style="width: 14%;">KETERANGAN</th>
                    </tr>
                    <tr>
                        <th style="width: 10%;">TGL</th>
                        <th style="width: 6%;">PIC</th>
                        <th style="width: 5%;">HASIL</th>
                    </tr>
                </thead>
                <tbody id="keluhan-body">
                    @php
                        $items = $form->items->keyBy('no')->toArray();
                        $maxItems = max(10, count($items) > 0 ? max(array_keys($items)) : 0);
                    @endphp
                    @for ($i = 1; $i <= $maxItems; $i++)
                    @php
                        $item = $items[$i] ?? null;
                    @endphp
                    <tr>
                        <td style="text-align: center;">{{ $i }}<input type="hidden" name="items[{{ $i }}][no]" value="{{ $i }}"></td>
                        <td><input type="text" name="items[{{ $i }}][tanggal]" value="{{ $item['tanggal'] ?? '' }}" class="form-input custom-date-picker" autocomplete="off" style="text-align: center; cursor: pointer;" placeholder="Tanggal"></td>
                        <td><input type="text" name="items[{{ $i }}][pelanggan]" value="{{ $item['pelanggan'] ?? '' }}" class="form-input" style="text-align: center;"></td>
                        <td><input type="text" name="items[{{ $i }}][sumber]" value="{{ $item['sumber'] ?? '' }}" class="form-input" style="text-align: center;"></td>
                        <td><textarea name="items[{{ $i }}][deskripsi_keluhan]" class="form-input" rows="2">{{ $item['deskripsi_keluhan'] ?? '' }}</textarea></td>
                        <td><textarea name="items[{{ $i }}][tindakan]" class="form-input" rows="2">{{ $item['tindakan'] ?? '' }}</textarea></td>
                        <td><input type="text" name="items[{{ $i }}][verifikasi_tgl]" value="{{ $item['verifikasi_tgl'] ?? '' }}" class="form-input custom-date-picker" autocomplete="off" style="text-align: center; cursor: pointer;" placeholder="Tanggal"></td>
                        <td><input type="text" name="items[{{ $i }}][verifikasi_pic]" value="{{ $item['verifikasi_pic'] ?? '' }}" class="form-input" style="text-align: center;"></td>
                        <td><textarea name="items[{{ $i }}][verifikasi_hasil]" class="form-input" rows="2">{{ $item['verifikasi_hasil'] ?? '' }}</textarea></td>
                        <td style="position: relative;">
                            <textarea name="items[{{ $i }}][keterangan]" class="form-input" rows="2">{{ $item['keterangan'] ?? '' }}</textarea>
                            @if ($i > 10)
                            <button type="button" class="btn-delete-row no-print" title="Hapus Baris">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16" style="pointer-events: none;">
                                  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                </svg>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
            </div>

            <div class="no-print" style="text-align: right; margin-top: 10px;">
                <button type="button" id="btn-add-row" class="btn-tambah-baris">Tambah Baris</button>
            </div>

            <div class="footer-section clearfix">
                <div class="signature-box-left">
                    <div style="height: 67px;"></div>
                    <p>Dibuat Oleh,</p>
                    <p>Pelaksana</p>
                    <div style="height: 60px;"></div>
                    <p style="position: relative;">
                        <select id="pelaksana_nama" name="pelaksana_nama" class="form-input-inline sync-pelaksana" data-type="nama" style="width: 100%; text-align: center; appearance: none; cursor: pointer; text-align-last: center;">
                            <option value="">-- Pilih Nama --</option>
                            @foreach($masterSigners as $signer)
                            <option value="{{ $signer->nama }}" data-nama="{{ $signer->nama }}" data-nipp="{{ $signer->nipp }}" {{ old('pelaksana_nama', $form->pelaksana_nama) == $signer->nama ? 'selected' : '' }}>{{ $signer->nama }}</option>
                            @endforeach
                        </select>
                    
                    </p>
                    <p style="position: relative; margin-top: 5px;">
                        <select id="pelaksana_nipp" name="pelaksana_nipp" class="form-input-inline sync-pelaksana" data-type="nipp" style="width: 100%; text-align: center; appearance: none; cursor: pointer; text-align-last: center;">
                            <option value="">-- Pilih NIPP --</option>
                            @foreach($masterSigners as $signer)
                            <option value="{{ $signer->nipp }}" data-nama="{{ $signer->nama }}" data-nipp="{{ $signer->nipp }}" {{ old('pelaksana_nipp', $form->pelaksana_nipp) == $signer->nipp ? 'selected' : '' }}>NIPP. {{ $signer->nipp }}</option>
                            @endforeach
                        </select>
                    </p>
                </div>
                <div class="signature-box">
                    <p>Yogyakarta, <input type="text" name="kota_tanggal" class="form-input-inline {{ isset($method) && $method === 'PUT' ? '' : 'custom-date-picker' }}" data-format="id" style="width: 130px; text-align: center; cursor: pointer; {{ isset($method) && $method === 'PUT' ? 'pointer-events:none; background:#f9f9f9;' : '' }}" value="{{ isset($method) && $method === 'PUT' ? \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') : old('kota_tanggal', $form->kota_tanggal) }}" placeholder="Tanggal" autocomplete="off" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')" {{ isset($method) && $method === 'PUT' ? 'readonly' : '' }}></p>
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
                <a href="{{ route('form-keluhan.index') }}" class="btn-kembali">Batal</a>
                <button type="submit" class="btn-submit" style="margin-top: 0;">{{ isset($method) && $method === 'PUT' ? 'Perbarui' : 'Simpan' }}</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var inputTanggalAtas = document.querySelector('input[name="tanggal"]');
    var inputKotaTanggal = document.querySelector('input[name="kota_tanggal"]');
    var monthNamesId = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
    if (inputTanggalAtas && inputKotaTanggal) {
        inputTanggalAtas.addEventListener('change', function() {
            var parts = this.value.split('-');
            if (parts.length === 3) {
                var day = parts[0];
                var month = parseInt(parts[1], 10) - 1;
                var year = parts[2];
                if (monthNamesId[month]) {
                    inputKotaTanggal.value = day + ' ' + monthNamesId[month] + ' ' + year;
                    inputKotaTanggal.dispatchEvent(new Event('input', { bubbles: true }));
                }
            }
        });
    }

    var form = document.getElementById('keluhan-form');
    if (form) {
        form.addEventListener('invalid', function(e) {
            var firstInvalid = form.querySelector(':invalid');
            if (firstInvalid && firstInvalid === e.target) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }, true);
    }

      if (typeof TomSelect !== 'undefined') {
        var tomNama = new TomSelect("#mengetahui_nama", { create: false, placeholder: "-- Pilih Nama --", wrapperClass: 'ts-wrapper modern-select text-center' });
        var tomNipp = new TomSelect("#mengetahui_nipp", { create: false, placeholder: "-- Pilih NIPP --", wrapperClass: 'ts-wrapper modern-select text-center' });
        var tomJabatan = new TomSelect("#mengetahui_jabatan", { create: false, placeholder: "-- Pilih Jabatan --", wrapperClass: 'ts-wrapper modern-select text-center' });

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

        if (tomNama.getValue()) {
            syncSigners('nama', tomNama.getValue());
        } else if (tomNipp.getValue()) {
            syncSigners('nipp', tomNipp.getValue());
        } else if (tomJabatan.getValue()) {
            syncSigners('jabatan', tomJabatan.getValue());
        }

        var tomPelaksanaNama = new TomSelect("#pelaksana_nama", { create: false, placeholder: "-- Pilih Nama --", wrapperClass: 'ts-wrapper modern-select text-center' });
        var tomPelaksanaNipp = new TomSelect("#pelaksana_nipp", { create: false, placeholder: "-- Pilih NIPP --", wrapperClass: 'ts-wrapper modern-select text-center' });

        var isSyncingPelaksana = false;
        function syncPelaksana(source, val) {
            if (isSyncingPelaksana) return;
            isSyncingPelaksana = true;
            if (!val) {
                tomPelaksanaNama.clear(true);
                tomPelaksanaNipp.clear(true);
                setTimeout(function() { isSyncingPelaksana = false; }, 100);
                return;
            }
            var sourceSelect = document.getElementById('pelaksana_' + source);
            var option = Array.from(sourceSelect.options).find(function(o) { return o.value == val; });
            if (option) {
                if (source !== 'nama') tomPelaksanaNama.setValue(option.getAttribute('data-nama') || '', true);
                if (source !== 'nipp') tomPelaksanaNipp.setValue(option.getAttribute('data-nipp') || '', true);
            }
            setTimeout(function() { isSyncingPelaksana = false; }, 100);
        }
        tomPelaksanaNama.on('change', function(val) { syncPelaksana('nama', val); });
        tomPelaksanaNipp.on('change', function(val) { syncPelaksana('nipp', val); });

        if (tomPelaksanaNama.getValue()) {
            syncPelaksana('nama', tomPelaksanaNama.getValue());
        } else if (tomPelaksanaNipp.getValue()) {
            syncPelaksana('nipp', tomPelaksanaNipp.getValue());
        }
    }
});

var currentRowCount = {{ isset($maxItems) ? $maxItems : 10 }};
document.getElementById('btn-add-row').addEventListener('click', function() {
    currentRowCount++;
    var tbody = document.getElementById('keluhan-body');
    var tr = document.createElement('tr');
    tr.innerHTML = 
        '<td class="text-center">' + currentRowCount + '<input type="hidden" name="items[' + currentRowCount + '][no]" value="' + currentRowCount + '"></td>' +
        '<td><input type="text" name="items[' + currentRowCount + '][tanggal]" class="form-input custom-date-picker" autocomplete="off" style="text-align: center; cursor: pointer;" placeholder="Tanggal"></td>' +
        '<td><input type="text" name="items[' + currentRowCount + '][pelanggan]" class="form-input" style="text-align: center;"></td>' +
        '<td><input type="text" name="items[' + currentRowCount + '][sumber]" class="form-input" style="text-align: center;"></td>' +
        '<td><textarea name="items[' + currentRowCount + '][deskripsi_keluhan]" class="form-input" rows="2"></textarea></td>' +
        '<td><textarea name="items[' + currentRowCount + '][tindakan]" class="form-input" rows="2"></textarea></td>' +
        '<td><input type="text" name="items[' + currentRowCount + '][verifikasi_tgl]" class="form-input custom-date-picker" autocomplete="off" style="text-align: center; cursor: pointer;" placeholder="Tanggal"></td>' +
        '<td><input type="text" name="items[' + currentRowCount + '][verifikasi_pic]" class="form-input" style="text-align: center;"></td>' +
        '<td><textarea name="items[' + currentRowCount + '][verifikasi_hasil]" class="form-input" rows="2"></textarea></td>' +
        '<td style="position: relative;"><textarea name="items[' + currentRowCount + '][keterangan]" class="form-input" rows="2"></textarea>' +
        '<button type="button" class="btn-delete-row no-print" title="Hapus Baris"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16" style="pointer-events: none;"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/><path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/></svg></button></td>';
    tbody.appendChild(tr);
});

document.getElementById('keluhan-body').addEventListener('click', function(e) {
    var btn = e.target.closest('.btn-delete-row');
    if (btn) {
        btn.closest('tr').remove();
        reindexRows();
    }
});

function reindexRows() {
    var rows = document.getElementById('keluhan-body').querySelectorAll('tr');
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
        row.querySelectorAll('input, textarea').forEach(function(input) {
            if (input.name) {
                input.name = input.name.replace(/items\[\d+\]/, "items[" + no + "]");
            }
        });
    });
}
</script>
@endsection
