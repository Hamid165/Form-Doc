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
        width: 297mm; /* Landscape A4 */
        background: white;
        padding: 20mm 10mm;
        box-sizing: border-box;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
        font-size: 10px;
        color: #000;
        position: relative;
        min-height: 210mm;
    }
    
    /* Tabel Kop Surat */
    .kop-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
        font-size: 11px;
    }
    .kop-table td {
        border: 1px solid #000;
        padding: 4px 6px;
        vertical-align: middle;
    }
    .logo-cell {
        width: 12%;
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
    
    .badge-cell {
        width: 12%;
        text-align: center;
        height: 38px;
    }
    .badge-terbatas {
        display: inline-block;
        border: 2px solid #d97706;
        color: #d97706;
        font-weight: bold;
        font-size: 11px;
        padding: 4px 14px;
        letter-spacing: 1px;
    }
    .title-cell {
        text-align: center;
        font-weight: bold;
        font-size: 12px;
        width: 50%;
    }
    .info-label { width: 12%; font-size: 11px; }
    .info-value { width: 20%; font-size: 11px; }

    /* Tabel Referensi */
    .ref-table {
        width: 35%;
        border-collapse: collapse;
        margin-bottom: 10px;
        font-size: 11px;
    }
    .ref-table td {
        border: 1px solid #000;
        padding: 4px;
    }
    .ref-table td:first-child { border-right: none; width: 40%; }
    .ref-table td:last-child { border-left: none; }

    /* Periode & Tanggal Pemeriksaan */
    .periode-section {
        font-size: 11px;
        margin-bottom: 10px;
        font-weight: bold;
    }
    .periode-section div {
        margin-bottom: 4px;
    }

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
        text-align: center;
    }
    .form-input:focus { border: 1px dashed #00a4e4; outline: none; }

    /* Select dropdown styling */
    .form-select-inline {
        border: none;
        border-bottom: 1px solid #000;
        background: transparent;
        font-family: inherit;
        font-size: inherit;
        padding: 2px 4px;
        width: 100%;
        box-sizing: border-box;
        cursor: pointer;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 4px center;
        padding-right: 20px;
    }
    .form-select-inline:focus { outline: none; border-bottom: 1px solid #00a4e4; }

    /* Tabel Data Checking */
    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 5px;
        font-size: 10px;
    }
    .data-table th, .data-table td {
        border: 1px solid #000;
        padding: 0;
        position: relative;
    }
    .data-table th {
        background-color: #d4d4d4;
        font-weight: normal;
        text-align: center;
        padding: 4px;
        font-size: 9px;
        white-space: pre-wrap;
    }
    .data-table td { height: 28px; }
    .data-table td.no-cell {
        text-align: center;
        width: 25px;
        padding: 4px;
        font-weight: normal;
    }

    /* Toggle Button for Checklist */
    .toggle-btn {
        width: 100%;
        height: 100%;
        min-height: 28px;
        border: none;
        background: transparent;
        cursor: pointer;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
        padding: 2px;
    }
    .toggle-btn:hover {
        background-color: #f0f0f0;
    }
    .toggle-btn.checked {
        color: #16a34a;
        font-weight: bold;
    }
    .toggle-btn.unchecked {
        color: #dc2626;
        font-weight: bold;
    }
    .toggle-btn.empty {
        color: #ccc;
    }

    /* Catatan */
    .catatan-box {
        width: 60%;
        border: 1px solid #000;
        padding: 8px;
        vertical-align: top;
        font-size: 11px;
        min-height: 120px;
        margin-top: 15px;
        display: inline-block;
    }

    /* Mengetahui - tanpa kotak */
    .mengetahui-section {
        width: 38%;
        padding: 8px;
        vertical-align: top;
        font-size: 11px;
        text-align: center;
        margin-top: 15px;
        display: inline-block;
    }

    /* End of file */
    .end-of-file {
        text-align: center;
        font-size: 11px;
        color: #666;
        margin-top: 30px;
        font-style: italic;
    }

    /* Buttons */
    .btn-submit {
        background-color: #16a34a; color: white; padding: 6px 16px; height: 36px; display: inline-flex; align-items: center; justify-content: center; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 13px; transition: background 0.2s; box-shadow: 0 2px 4px rgba(22,163,74,0.3);
    }
    .btn-submit:hover { background-color: #15803d; }
    
    .btn-cancel {
        background-color: #ef4444; color: white; padding: 6px 16px; height: 36px; display: inline-flex; align-items: center; justify-content: center; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 13px; transition: background 0.2s; box-shadow: 0 2px 4px rgba(239,68,68,0.3); margin-right: 10px; text-decoration: none;
    }
    .btn-cancel:hover { background-color: #dc2626; color: white; }
    
    .btn-tambah-baris {
        display: inline-flex; align-items: center; justify-content: center; height: 30px; padding: 4px 12px; background-color: #f59e0b; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 11px; transition: background-color 0.2s;
    }
    .btn-tambah-baris:hover { background-color: #d97706; }
    
    .btn-delete-row {
        position: absolute; right: -28px; top: 50%; transform: translateY(-50%); background-color: #fef2f2; border: none; color: #dc2626; cursor: pointer; padding: 4px; border-radius: 4px; display: flex; align-items: center; justify-content: center; transition: all 0.2s;
    }
    .btn-delete-row:hover { background-color: #fee2e2; color: #b91c1c; transform: translateY(-50%) scale(1.1); }
</style>

<div class="a4-wrapper" style="flex-direction: column; align-items: center;">
    <div style="width: 330mm; margin-bottom: 20px;">
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
        
        <a href="{{ route('form-pc-laptop-checking.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors mb-6">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Formulir PC/Laptop Checking
        </a>
    </div>

    <div style="zoom: 1.0;">
        <div class="a4-container">
            <form id="pc-checking-form" action="{{ $action }}" method="POST">
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
                        <td class="info-value">: {{ $formTemplate->no_dokumen ?? 'FR.SM/TI/017.002/10-2020' }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Tanggal Terbit</td>
                        <td class="info-value">: {{ $formTemplate->tanggal_dokumen ?? '12 Oktober 2020' }}</td>
                    </tr>
                    <tr>
                        <td rowspan="2" class="badge-cell">
                            <span class="badge-terbatas">TERBATAS</span>
                        </td>
                        <td rowspan="2" class="title-cell">
                            FORMULIR PC/LAPTOP CHECKING
                        </td>
                        <td class="info-label">Status Revisi</td>
                        <td class="info-value">: {{ $formTemplate->versi_dokumen ?? '002-2020' }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Halaman</td>
                        <td class="info-value">: 1 dari 1</td>
                    </tr>
                </table>

                <!-- Referensi -->
                <table class="ref-table">
                    <tr>
                        <td>No. Ref</td>
                        <td>: <input type="text" name="no_ref" value="{{ old('no_ref', $form->no_ref) }}" class="form-input-inline" style="width: 70%;" placeholder="__/__/____" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')"></td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>: <input type="text" id="tanggal_input" name="tanggal" value="{{ old('tanggal', $form->tanggal ? \Carbon\Carbon::parse($form->tanggal)->locale('id')->isoFormat('DD MMMM YYYY') : '') }}" class="form-input-inline custom-date-picker" data-format="id" style="width: 70%; cursor: pointer;" placeholder="__-__-____" autocomplete="off" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')" {{ isset($method) && $method === 'PUT' ? 'readonly' : '' }}></td>
                    </tr>
                    <tr>
                        <td>Business Area</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 4px;">
                                <span>:</span>
                                <select id="business_area_input" name="business_area" class="form-select-inline" style="width: 70%;">
                                    @php
                                        $baOptions = [
                                            'B060' => 'B060',
                                            'B010' => 'B010',
                                            'B020' => 'B020',
                                            'B030' => 'B030',
                                            'B040' => 'B040',
                                            'B050' => 'B050',
                                            'B070' => 'B070',
                                            'B080' => 'B080',
                                        ];
                                        $currentBA = old('business_area', $form->business_area ?: 'B060');
                                    @endphp
                                    @foreach($baOptions as $code => $label)
                                        <option value="{{ $code }}" {{ $currentBA == $code ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                    </tr>
                </table>

                <!-- Periode & Tanggal Pemeriksaan -->
                <div class="periode-section">
                    <div>Periode Pemeriksaan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" id="periode_pemeriksaan_input" name="periode_pemeriksaan" value="{{ old('periode_pemeriksaan', $form->periode_pemeriksaan) }}" class="form-input-inline" style="width: 300px; font-weight: normal;" placeholder="......................................................"></div>
                    <div>Tanggal Pemeriksaan &nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" id="tanggal_pemeriksaan_input" name="tanggal_pemeriksaan" value="{{ old('tanggal_pemeriksaan', $form->tanggal_pemeriksaan ? \Carbon\Carbon::parse($form->tanggal_pemeriksaan)->locale('id')->isoFormat('DD MMMM YYYY') : '') }}" class="form-input-inline custom-date-picker" data-format="id" style="width: 300px; font-weight: normal; cursor: pointer;" autocomplete="off" placeholder="......................................................"></div>
                </div>

                <!-- Tabel Data Checking -->
                <table class="data-table" id="items-table">
                    <thead>
                        <tr>
                            <th rowspan="3" style="width: 25px;">NO</th>
                            <th rowspan="3" style="width: 120px;">NAMA PENGGUNA</th>
                            <th rowspan="3" style="width: 80px;">UNIT</th>
                            <th colspan="12">CHECKLIST</th>
                            <th colspan="2">Verifikasi / Paraf</th>
                        </tr>
                        <tr>
                            <th rowspan="2">NDA</th>
                            <th rowspan="2">Login Strong<br>Password</th>
                            <th rowspan="2">Screensaver<br>Lock (maks<br>5 menit)</th>
                            <th rowspan="2">* Hak Akses<br>Khusus<br>(Admin /<br>User)</th>
                            <th rowspan="2">Cleardesk</th>
                            <th rowspan="2">.mp3, video,<br>etc</th>
                            <th colspan="3">Antivirus</th>
                            <th rowspan="2">O/S<br>(License)</th>
                            <th rowspan="2">Sinkronisasi<br>NTP Server</th>
                            <th rowspan="2">Label PC</th>
                            <th rowspan="2">Pemeriksa</th>
                            <th rowspan="2">Pegawai<br>Ybs</th>
                        </tr>
                        <tr>
                            <th>Status<br>Install</th>
                            <th>Status<br>Update</th>
                            <th>Full Scan Auto<br>Schedule</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $oldItems = old('items', $items ?? []);
                            $rowCount = max(1, count($oldItems));
                        @endphp
                        
                        @for ($i = 0; $i < $rowCount; $i++)
                            @php
                                $item = $oldItems[$i] ?? null;
                            @endphp
                            <tr class="item-row">
                                <td class="no-cell">{{ $i + 1 }}</td>
                                <td><input type="text" name="items[{{$i}}][nama_pengguna]" value="{{ $item['nama_pengguna'] ?? '' }}" class="form-input" oninput="syncPegawai(this)"></td>
                                <td><input type="text" name="items[{{$i}}][unit]" value="{{ $item['unit'] ?? '' }}" class="form-input"></td>
                                <!-- NDA: Sudah/Belum toggle -->
                                <td>
                                    <input type="hidden" name="items[{{$i}}][nda]" value="{{ $item['nda'] ?? '' }}">
                                    <button type="button" class="toggle-btn {{ ($item['nda'] ?? '') === 'Sudah' ? 'checked' : (($item['nda'] ?? '') === 'Belum' ? 'unchecked' : 'empty') }}" onclick="toggleCheck(this, 'Sudah', 'Belum')">
                                        {{ ($item['nda'] ?? '') === 'Sudah' ? '✓' : (($item['nda'] ?? '') === 'Belum' ? '✗' : '—') }}
                                    </button>
                                </td>
                                <!-- Login Strong Password: Sudah/Belum -->
                                <td>
                                    <input type="hidden" name="items[{{$i}}][login_strong_password]" value="{{ $item['login_strong_password'] ?? '' }}">
                                    <button type="button" class="toggle-btn {{ ($item['login_strong_password'] ?? '') === 'Sudah' ? 'checked' : (($item['login_strong_password'] ?? '') === 'Belum' ? 'unchecked' : 'empty') }}" onclick="toggleCheck(this, 'Sudah', 'Belum')">
                                        {{ ($item['login_strong_password'] ?? '') === 'Sudah' ? '✓' : (($item['login_strong_password'] ?? '') === 'Belum' ? '✗' : '—') }}
                                    </button>
                                </td>
                                <!-- Screensaver Lock: Sudah/Belum -->
                                <td>
                                    <input type="hidden" name="items[{{$i}}][screensaver_lock]" value="{{ $item['screensaver_lock'] ?? '' }}">
                                    <button type="button" class="toggle-btn {{ ($item['screensaver_lock'] ?? '') === 'Sudah' ? 'checked' : (($item['screensaver_lock'] ?? '') === 'Belum' ? 'unchecked' : 'empty') }}" onclick="toggleCheck(this, 'Sudah', 'Belum')">
                                        {{ ($item['screensaver_lock'] ?? '') === 'Sudah' ? '✓' : (($item['screensaver_lock'] ?? '') === 'Belum' ? '✗' : '—') }}
                                    </button>
                                </td>
                                <!-- Hak Akses Khusus: tetap input teks (Admin/User) -->
                                <td><input type="text" name="items[{{$i}}][hak_akses_khusus]" value="{{ $item['hak_akses_khusus'] ?? '' }}" class="form-input" placeholder=""></td>
                                <!-- Cleardesk: Sudah/Belum -->
                                <td>
                                    <input type="hidden" name="items[{{$i}}][cleardesk]" value="{{ $item['cleardesk'] ?? '' }}">
                                    <button type="button" class="toggle-btn {{ ($item['cleardesk'] ?? '') === 'Sudah' ? 'checked' : (($item['cleardesk'] ?? '') === 'Belum' ? 'unchecked' : 'empty') }}" onclick="toggleCheck(this, 'Sudah', 'Belum')">
                                        {{ ($item['cleardesk'] ?? '') === 'Sudah' ? '✓' : (($item['cleardesk'] ?? '') === 'Belum' ? '✗' : '—') }}
                                    </button>
                                </td>
                                <!-- mp3 video: Ada/Tidak -->
                                <td>
                                    <input type="hidden" name="items[{{$i}}][mp3_video_etc]" value="{{ $item['mp3_video_etc'] ?? '' }}">
                                    <button type="button" class="toggle-btn {{ ($item['mp3_video_etc'] ?? '') === 'Ada' ? 'checked' : (($item['mp3_video_etc'] ?? '') === 'Tidak' ? 'unchecked' : 'empty') }}" onclick="toggleCheck(this, 'Ada', 'Tidak')">
                                        {{ ($item['mp3_video_etc'] ?? '') === 'Ada' ? '✓' : (($item['mp3_video_etc'] ?? '') === 'Tidak' ? '✗' : '—') }}
                                    </button>
                                </td>
                                <!-- Antivirus Install: Sudah/Belum -->
                                <td>
                                    <input type="hidden" name="items[{{$i}}][antivirus_install]" value="{{ $item['antivirus_install'] ?? '' }}">
                                    <button type="button" class="toggle-btn {{ ($item['antivirus_install'] ?? '') === 'Sudah' ? 'checked' : (($item['antivirus_install'] ?? '') === 'Belum' ? 'unchecked' : 'empty') }}" onclick="toggleCheck(this, 'Sudah', 'Belum')">
                                        {{ ($item['antivirus_install'] ?? '') === 'Sudah' ? '✓' : (($item['antivirus_install'] ?? '') === 'Belum' ? '✗' : '—') }}
                                    </button>
                                </td>
                                <!-- Antivirus Update: Sudah/Belum -->
                                <td>
                                    <input type="hidden" name="items[{{$i}}][antivirus_update]" value="{{ $item['antivirus_update'] ?? '' }}">
                                    <button type="button" class="toggle-btn {{ ($item['antivirus_update'] ?? '') === 'Sudah' ? 'checked' : (($item['antivirus_update'] ?? '') === 'Belum' ? 'unchecked' : 'empty') }}" onclick="toggleCheck(this, 'Sudah', 'Belum')">
                                        {{ ($item['antivirus_update'] ?? '') === 'Sudah' ? '✓' : (($item['antivirus_update'] ?? '') === 'Belum' ? '✗' : '—') }}
                                    </button>
                                </td>
                                <!-- Full Scan: Sudah/Belum -->
                                <td>
                                    <input type="hidden" name="items[{{$i}}][full_scan_auto_schedule]" value="{{ $item['full_scan_auto_schedule'] ?? '' }}">
                                    <button type="button" class="toggle-btn {{ ($item['full_scan_auto_schedule'] ?? '') === 'Sudah' ? 'checked' : (($item['full_scan_auto_schedule'] ?? '') === 'Belum' ? 'unchecked' : 'empty') }}" onclick="toggleCheck(this, 'Sudah', 'Belum')">
                                        {{ ($item['full_scan_auto_schedule'] ?? '') === 'Sudah' ? '✓' : (($item['full_scan_auto_schedule'] ?? '') === 'Belum' ? '✗' : '—') }}
                                    </button>
                                </td>
                                <!-- OS License: License/Tidak -->
                                <td>
                                    <input type="hidden" name="items[{{$i}}][os_license]" value="{{ $item['os_license'] ?? '' }}">
                                    <button type="button" class="toggle-btn {{ ($item['os_license'] ?? '') === 'License' ? 'checked' : (($item['os_license'] ?? '') === 'Tidak' ? 'unchecked' : 'empty') }}" onclick="toggleCheck(this, 'License', 'Tidak')">
                                        {{ ($item['os_license'] ?? '') === 'License' ? '✓' : (($item['os_license'] ?? '') === 'Tidak' ? '✗' : '—') }}
                                    </button>
                                </td>
                                <!-- Sinkronisasi NTP: Ya/Tidak -->
                                <td>
                                    <input type="hidden" name="items[{{$i}}][sinkronisasi_ntp]" value="{{ $item['sinkronisasi_ntp'] ?? '' }}">
                                    <button type="button" class="toggle-btn {{ ($item['sinkronisasi_ntp'] ?? '') === 'Ya' ? 'checked' : (($item['sinkronisasi_ntp'] ?? '') === 'Tidak' ? 'unchecked' : 'empty') }}" onclick="toggleCheck(this, 'Ya', 'Tidak')">
                                        {{ ($item['sinkronisasi_ntp'] ?? '') === 'Ya' ? '✓' : (($item['sinkronisasi_ntp'] ?? '') === 'Tidak' ? '✗' : '—') }}
                                    </button>
                                </td>
                                <!-- Label PC: Ada/Tidak -->
                                <td>
                                    <input type="hidden" name="items[{{$i}}][label_pc]" value="{{ $item['label_pc'] ?? '' }}">
                                    <button type="button" class="toggle-btn {{ ($item['label_pc'] ?? '') === 'Ada' ? 'checked' : (($item['label_pc'] ?? '') === 'Tidak' ? 'unchecked' : 'empty') }}" onclick="toggleCheck(this, 'Ada', 'Tidak')">
                                        {{ ($item['label_pc'] ?? '') === 'Ada' ? '✓' : (($item['label_pc'] ?? '') === 'Tidak' ? '✗' : '—') }}
                                    </button>
                                </td>
                                <td><input type="text" name="items[{{$i}}][pemeriksa]" value="{{ $item['pemeriksa'] ?? '' }}" class="form-input"></td>
                                <td>
                                    <input type="text" name="items[{{$i}}][pegawai_ybs]" value="{{ $item['pegawai_ybs'] ?? '' }}" class="form-input pegawai-ybs-input">
                                    
                                    @if($i >= 1)
                                    <button type="button" class="btn-delete-row" onclick="removeRow(this)" title="Hapus Baris">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
                
                <div style="margin-right: 0; margin-bottom: 15px; text-align: right;" class="no-print">
                    <button type="button" class="btn-tambah-baris" onclick="addRow()">
                        Tambah Baris
                    </button>
                </div>

                <!-- End of File -->
                <div class="end-of-file" style="margin-bottom: 15px; margin-top: 15px; text-align: left; padding-left: 25px;">
                    --- End of File ---
                </div>

                <!-- Catatan (dalam kotak) & Mengetahui (tanpa kotak) -->
                <div style="margin-top: 15px; display: flex; gap: 0; width: 100%;">
                    <!-- Catatan: tetap dalam kotak -->
                    <div class="catatan-box">
                        <strong>Catatan :</strong><br>
                        <textarea name="catatan" class="form-input" style="width: 100%; height: 90px; resize: none; border: none; background: transparent; font-family: inherit; font-size: inherit; text-align: left;">{{ old('catatan', $form->catatan) }}</textarea>
                    </div>

                    <!-- Mengetahui: tanpa kotak -->
                    <div class="mengetahui-section">
                        <div>Mengetahui,</div>
                        <div id="mengetahui_lokasi_tanggal" style="font-size: 10px; margin-top: 4px; color: #333;"></div>
                        <div style="margin-top: 40px; border-top: 1px dotted #000; display: inline-block; width: 200px; padding-top: 4px;">
                            <select id="mengetahui_nama_select" name="mengetahui_nama" class="form-select-inline" style="text-align: center; border-bottom: none; width: 100%;" onchange="onSignerChange()">
                                <option value="">-- Pilih Nama --</option>
                                @foreach($signers ?? [] as $signer)
                                    <option value="{{ $signer->nama }}" data-nipp="{{ $signer->nipp }}" data-jabatan="{{ $signer->jabatan }}" {{ old('mengetahui_nama', $form->mengetahui_nama) == $signer->nama ? 'selected' : '' }}>{{ $signer->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="mengetahui_jabatan_display" style="margin-top: 4px; font-size: 10px;">
                            <input type="hidden" name="mengetahui_jabatan" id="mengetahui_jabatan_input" value="{{ old('mengetahui_jabatan', $form->mengetahui_jabatan ?? '') }}">
                            <span id="jabatan_text">{{ old('mengetahui_jabatan', $form->mengetahui_jabatan ?? '') }}</span>
                        </div>
                        <div style="margin-top: 4px;">
                            NIPP: <input type="text" name="mengetahui_nipp" id="mengetahui_nipp_input" value="{{ old('mengetahui_nipp', $form->mengetahui_nipp) }}" class="form-input-inline" style="width: 120px; pointer-events: none; background: transparent; border-bottom: none;" readonly placeholder="..................">
                        </div>
                    </div>
                </div>
                
                <div class="no-print" style="margin-top: 20px; text-align: right; border-top: 1px solid #eaeaea; padding-top: 20px;">
                    <a href="{{ route('form-pc-laptop-checking.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">
                        {{ $form->exists ? 'Perbarui' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // ========== SIGNER DATA ==========
    const signersData = @json($signers ?? []);
    
    // ========== BUSINESS AREA LOCATION MAP ==========
    const baLocationMap = {
        'B060': 'Yogyakarta',
        'B010': 'Jakarta',
        'B020': 'Bandung',
        'B030': 'Cirebon',
        'B040': 'Semarang',
        'B050': 'Surabaya',
        'B070': 'Madiun',
        'B080': 'Purwokerto',
    };

    // ========== INDONESIAN MONTH NAMES ==========
    const bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    // ========== TOGGLE CHECK FUNCTION ==========
    function toggleCheck(btn, positiveVal, negativeVal) {
        const hiddenInput = btn.parentElement.querySelector('input[type="hidden"]');
        const currentVal = hiddenInput.value;
        
        if (currentVal === '' || (currentVal !== positiveVal && currentVal !== negativeVal)) {
            // Empty → Checked (✓)
            hiddenInput.value = positiveVal;
            btn.textContent = '✓';
            btn.className = 'toggle-btn checked';
        } else if (currentVal === positiveVal) {
            // Checked → Unchecked (✗)
            hiddenInput.value = negativeVal;
            btn.textContent = '✗';
            btn.className = 'toggle-btn unchecked';
        } else {
            // Unchecked → Empty
            hiddenInput.value = '';
            btn.textContent = '—';
            btn.className = 'toggle-btn empty';
        }
    }

    // ========== AUTO-FILL TANGGAL PEMERIKSAAN FROM TANGGAL ==========
    function updateFromTanggal() {
        const tanggalInput = document.getElementById('tanggal_input');
        const tanggalPemInput = document.getElementById('tanggal_pemeriksaan_input');
        
        if (!tanggalInput || !tanggalInput.value) return;
        
        const val = tanggalInput.value.trim();
        let parsedDate = parseIndonesianDate(val);
        
        if (parsedDate) {
            // Auto-fill Tanggal Pemeriksaan (only if empty or was auto-filled)
            if (!tanggalPemInput.value || tanggalPemInput.dataset.autoFilled === 'true') {
                const day = String(parsedDate.day).padStart(2, '0');
                const monthName = bulanIndonesia[parsedDate.month];
                tanggalPemInput.value = day + ' ' + monthName + ' ' + parsedDate.year;
                tanggalPemInput.dataset.autoFilled = 'true';
            }
            
            // Auto-fill Periode Pemeriksaan
            const periodeInput = document.getElementById('periode_pemeriksaan_input');
            if (periodeInput && (!periodeInput.value || periodeInput.dataset.autoFilled === 'true')) {
                const monthName = bulanIndonesia[parsedDate.month];
                periodeInput.value = monthName + ' ' + parsedDate.year;
                periodeInput.dataset.autoFilled = 'true';
            }
            
            // Update mengetahui location + date
            updateMengetahuiHeader();
        }
    }

    function parseIndonesianDate(str) {
        if (!str) return null;
        
        const monthMap = {
            'januari': 0, 'februari': 1, 'maret': 2, 'april': 3,
            'mei': 4, 'juni': 5, 'juli': 6, 'agustus': 7,
            'september': 8, 'oktober': 9, 'november': 10, 'desember': 11
        };
        
        // Try "DD MMMM YYYY" format
        const parts = str.replace(/\s+/g, ' ').trim().split(' ');
        if (parts.length >= 3) {
            const day = parseInt(parts[0]);
            const monthStr = parts[1].toLowerCase();
            const year = parseInt(parts[parts.length - 1]);
            
            if (monthMap[monthStr] !== undefined && !isNaN(day) && !isNaN(year)) {
                return { day: day, month: monthMap[monthStr], year: year };
            }
        }
        
        // Try "DD-MM-YYYY" format
        const dashParts = str.split('-');
        if (dashParts.length === 3) {
            const day = parseInt(dashParts[0]);
            const month = parseInt(dashParts[1]) - 1;
            const year = parseInt(dashParts[2]);
            if (!isNaN(day) && !isNaN(month) && !isNaN(year) && month >= 0 && month <= 11) {
                return { day: day, month: month, year: year };
            }
        }
        
        return null;
    }

    // ========== UPDATE MENGETAHUI HEADER (LOKASI + TANGGAL) ==========
    function updateMengetahuiHeader() {
        const baSelect = document.getElementById('business_area_input');
        const tanggalInput = document.getElementById('tanggal_input');
        const display = document.getElementById('mengetahui_lokasi_tanggal');
        
        if (!display) return;
        
        const baCode = baSelect ? baSelect.value : 'B060';
        const location = baLocationMap[baCode] || baCode;
        
        let dateStr = '';
        const parsedDate = parseIndonesianDate(tanggalInput ? tanggalInput.value : '');
        if (parsedDate) {
            const day = String(parsedDate.day).padStart(2, '0');
            dateStr = location + ', ' + day + ' ' + bulanIndonesia[parsedDate.month] + ' ' + parsedDate.year;
        } else {
            dateStr = location;
        }
        
        display.textContent = dateStr;
    }

    // ========== SIGNER DROPDOWN CHANGE ==========
    function onSignerChange() {
        const select = document.getElementById('mengetahui_nama_select');
        const nippInput = document.getElementById('mengetahui_nipp_input');
        const jabatanInput = document.getElementById('mengetahui_jabatan_input');
        const jabatanText = document.getElementById('jabatan_text');
        
        const selectedOption = select.options[select.selectedIndex];
        
        if (selectedOption && selectedOption.value) {
            nippInput.value = selectedOption.getAttribute('data-nipp') || '';
            const jabatan = selectedOption.getAttribute('data-jabatan') || '';
            jabatanInput.value = jabatan;
            jabatanText.textContent = jabatan;
        } else {
            nippInput.value = '';
            jabatanInput.value = '';
            jabatanText.textContent = '';
        }
    }

    // ========== TABLE ROWS ==========
    let rowIndex = {{ $rowCount }};
    
    function addRow() {
        const tbody = document.querySelector('#items-table tbody');
        const newNo = tbody.querySelectorAll('tr.item-row').length + 1;
        const tr = document.createElement('tr');
        tr.className = 'item-row';
        tr.innerHTML = `
            <td class="no-cell">${newNo}</td>
            <td><input type="text" name="items[${rowIndex}][nama_pengguna]" class="form-input" oninput="syncPegawai(this)"></td>
            <td><input type="text" name="items[${rowIndex}][unit]" class="form-input"></td>
            <td>
                <input type="hidden" name="items[${rowIndex}][nda]" value="">
                <button type="button" class="toggle-btn empty" onclick="toggleCheck(this, 'Sudah', 'Belum')">—</button>
            </td>
            <td>
                <input type="hidden" name="items[${rowIndex}][login_strong_password]" value="">
                <button type="button" class="toggle-btn empty" onclick="toggleCheck(this, 'Sudah', 'Belum')">—</button>
            </td>
            <td>
                <input type="hidden" name="items[${rowIndex}][screensaver_lock]" value="">
                <button type="button" class="toggle-btn empty" onclick="toggleCheck(this, 'Sudah', 'Belum')">—</button>
            </td>
            <td><input type="text" name="items[${rowIndex}][hak_akses_khusus]" class="form-input" placeholder=""></td>
            <td>
                <input type="hidden" name="items[${rowIndex}][cleardesk]" value="">
                <button type="button" class="toggle-btn empty" onclick="toggleCheck(this, 'Sudah', 'Belum')">—</button>
            </td>
            <td>
                <input type="hidden" name="items[${rowIndex}][mp3_video_etc]" value="">
                <button type="button" class="toggle-btn empty" onclick="toggleCheck(this, 'Ada', 'Tidak')">—</button>
            </td>
            <td>
                <input type="hidden" name="items[${rowIndex}][antivirus_install]" value="">
                <button type="button" class="toggle-btn empty" onclick="toggleCheck(this, 'Sudah', 'Belum')">—</button>
            </td>
            <td>
                <input type="hidden" name="items[${rowIndex}][antivirus_update]" value="">
                <button type="button" class="toggle-btn empty" onclick="toggleCheck(this, 'Sudah', 'Belum')">—</button>
            </td>
            <td>
                <input type="hidden" name="items[${rowIndex}][full_scan_auto_schedule]" value="">
                <button type="button" class="toggle-btn empty" onclick="toggleCheck(this, 'Sudah', 'Belum')">—</button>
            </td>
            <td>
                <input type="hidden" name="items[${rowIndex}][os_license]" value="">
                <button type="button" class="toggle-btn empty" onclick="toggleCheck(this, 'License', 'Tidak')">—</button>
            </td>
            <td>
                <input type="hidden" name="items[${rowIndex}][sinkronisasi_ntp]" value="">
                <button type="button" class="toggle-btn empty" onclick="toggleCheck(this, 'Ya', 'Tidak')">—</button>
            </td>
            <td>
                <input type="hidden" name="items[${rowIndex}][label_pc]" value="">
                <button type="button" class="toggle-btn empty" onclick="toggleCheck(this, 'Ada', 'Tidak')">—</button>
            </td>
            <td><input type="text" name="items[${rowIndex}][pemeriksa]" class="form-input"></td>
            <td>
                <input type="text" name="items[${rowIndex}][pegawai_ybs]" class="form-input pegawai-ybs-input">
                <button type="button" class="btn-delete-row" onclick="removeRow(this)" title="Hapus Baris">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
        rowIndex++;
    }
    
    function removeRow(btn) {
        const tr = btn.closest('tr');
        tr.remove();
        // Re-number rows
        document.querySelectorAll('#items-table tbody tr.item-row').forEach((row, index) => {
            const noCell = row.querySelector('.no-cell');
            if (noCell) noCell.textContent = index + 1;
        });
    }
    
    // ========== SYNC PEGAWAI YBS ==========
    function syncPegawai(input) {
        const tr = input.closest('tr');
        const pegawaiInput = tr.querySelector('.pegawai-ybs-input');
        if (pegawaiInput) {
            pegawaiInput.value = input.value;
        }
    }

    // ========== INIT EVENT LISTENERS ==========
    document.addEventListener('DOMContentLoaded', function() {
        // Listen for tanggal changes
        const tanggalInput = document.getElementById('tanggal_input');
        if (tanggalInput) {
            tanggalInput.addEventListener('change', updateFromTanggal);
            tanggalInput.addEventListener('blur', updateFromTanggal);
            const observer = new MutationObserver(function() { updateFromTanggal(); });
            observer.observe(tanggalInput, { attributes: true, attributeFilter: ['value'] });
            let lastTanggalVal = tanggalInput.value;
            setInterval(function() {
                if (tanggalInput.value !== lastTanggalVal) {
                    lastTanggalVal = tanggalInput.value;
                    updateFromTanggal();
                }
            }, 500);
        }
        
        // Mark tanggal pemeriksaan and periode as manually edited if user changes it
        const tanggalPemInput = document.getElementById('tanggal_pemeriksaan_input');
        if (tanggalPemInput) {
            tanggalPemInput.addEventListener('change', function() {
                this.dataset.autoFilled = 'false';
            });
        }
        
        const periodeInput = document.getElementById('periode_pemeriksaan_input');
        if (periodeInput) {
            periodeInput.addEventListener('change', function() {
                this.dataset.autoFilled = 'false';
            });
        }
        
        // Listen for business area changes
        const baSelect = document.getElementById('business_area_input');
        if (baSelect) {
            baSelect.addEventListener('change', function() {
                updateMengetahuiHeader();
            });
        }
        
        // Initial fill
        updateFromTanggal();
        updateMengetahuiHeader();
    });
</script>
@endsection
