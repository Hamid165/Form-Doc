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
        padding: 20mm 15mm;
        box-sizing: border-box;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
        font-size: 11px;
        color: #000;
        position: relative;
        min-height: 210mm;
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
        width: 30%;
        border-collapse: collapse;
        margin-bottom: 15px;
        font-size: 11px;
    }
    .ref-table td {
        border: 1px solid #000;
        padding: 4px;
    }
    .ref-table td:first-child { border-right: none; }
    .ref-table td:last-child { border-left: none; }
    .ref-label { width: 40%; }

    /* Bulan Field */
    .bulan-section {
        font-size: 12px;
        margin-bottom: 15px;
        font-weight: bold;
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
    }
    .form-input:focus { border: 1px dashed #00a4e4; outline: none; }

    /* Tabel Data Grounding */
    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 5px;
        font-size: 11px;
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
        padding: 8px 4px;
        font-size: 11px;
    }
    .data-table td { height: 28px; }
    .data-table td.no-cell {
        text-align: center;
        width: 30px;
        padding: 4px;
        font-weight: normal;
    }
    .data-table .standard-cell {
        text-align: center;
        padding: 4px;
        font-size: 11px;
    }

    /* Footer Table */
    .footer-table {
        width: 40%;
        border-collapse: collapse;
        margin-top: 15px;
        font-size: 11px;
    }
    .footer-table td {
        border: 1px solid #000;
        padding: 4px 6px;
    }
    .footer-table td:first-child {
        width: 40%;
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
        text-align: left;
        font-size: 11px;
        color: #666;
        margin-top: 1px;
        font-style: italic;
    }

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
        
        <a href="{{ route('form-monitoring-grounding.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors mb-6">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Formulir Monitoring Grounding
        </a>
    </div>

    <div style="zoom: 1.1;">
        <div class="a4-container">
            <form id="grounding-form" action="{{ $action }}" method="POST">
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
                        <td class="info-value">: {{ $formTemplate->no_dokumen ?? 'FR.SM/TI/015.018/10-2020' }}</td>
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
                            FORMULIR MONITORING GROUNDING
                        </td>
                        <td class="info-label">Versi</td>
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
                        <td class="ref-label">No. Ref</td>
                        <td>: <input type="text" name="no_ref" value="{{ old('no_ref', $form->no_ref) }}" class="form-input-inline" style="width: 70%;" placeholder="__/__/____" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')"></td>
                    </tr>
                    <tr>
                        <td class="ref-label">Tanggal</td>
                        <td>: <input type="text" id="tanggal_input" name="tanggal" value="{{ old('tanggal', $form->tanggal ? \Carbon\Carbon::parse($form->tanggal)->locale('id')->isoFormat('DD MMMM YYYY') : '') }}" class="form-input-inline custom-date-picker" data-format="id" style="width: 70%; cursor: pointer;" placeholder="__-__-____" autocomplete="off" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')" {{ isset($method) && $method === 'PUT' ? 'readonly' : '' }}></td>
                    </tr>
                    <tr>
                        <td class="ref-label">Business Area</td>
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

                <!-- Bulan (auto-filled from tanggal) -->
                <div class="bulan-section">
                    Bulan : <input type="text" id="bulan_input" name="bulan" value="{{ old('bulan', $form->bulan) }}" class="form-input-inline" style="width: 300px; font-weight: normal; pointer-events: none; background: transparent;" placeholder="......................................................" readonly>
                </div>

                <!-- Tabel Data Grounding -->
                <table class="data-table" id="items-table">
                    <thead>
                        <tr>
                            <th style="width: 30px;">No.</th>
                            <th style="width: 18%;">Lokasi grounding</th>
                            <th style="width: 15%;">Nilai grounding standard (OHM)</th>
                            <th style="width: 15%;">Hasil pengukuran&nbsp;&nbsp;&nbsp;&nbsp;(OHM)</th>
                            <th style="width: 22%;">Kondisi bak grounding</th>
                            <th style="width: 22%;">Tindak lanjut</th>
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
                                <td>
                                    <input type="text" name="items[{{$i}}][lokasi_grounding]" value="{{ $item['lokasi_grounding'] ?? '' }}" class="form-input">
                                </td>
                                <td class="standard-cell">
                                    <span>≤ 1&nbsp;&nbsp;OHM</span>
                                    <input type="hidden" name="items[{{$i}}][nilai_grounding_standard]" value="{{ $item['nilai_grounding_standard'] ?? '≤ 1 OHM' }}">
                                </td>
                                <td>
                                    <input type="text" name="items[{{$i}}][hasil_pengukuran]" value="{{ $item['hasil_pengukuran'] ?? '' }}" class="form-input">
                                </td>
                                <td>
                                    <input type="text" name="items[{{$i}}][kondisi_bak_grounding]" value="{{ $item['kondisi_bak_grounding'] ?? '' }}" class="form-input">
                                </td>
                                <td>
                                    <input type="text" name="items[{{$i}}][tindak_lanjut]" value="{{ $item['tindak_lanjut'] ?? '' }}" class="form-input">
                                    
                                    @if($i >= 1)
                                    <button type="button" class="btn-delete-row" onclick="removeRow(this)" title="Hapus Baris">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
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
                <div class="end-of-file">
                    --- End of File ---
                </div>

                <!-- Footer: Tgl pelaksanaan, Nama Petugas, Paraf Petugas -->
                <table class="footer-table">
                    <tr>
                        <td>Tgl pelaksanaan</td>
                        <td>: <input type="text" id="tgl_pelaksanaan_input" name="tgl_pelaksanaan" value="{{ old('tgl_pelaksanaan', $form->tgl_pelaksanaan) }}" class="form-input-inline" style="width: 70%; pointer-events: none; background: transparent;" readonly></td>
                    </tr>
                    <tr>
                        <td>Nama Petugas</td>
                        <td>: <input type="text" name="nama_petugas" value="{{ old('nama_petugas', $form->nama_petugas) }}" class="form-input-inline" style="width: 70%;"></td>
                    </tr>
                    <tr>
                        <td>Paraf Petugas</td>
                        <td>: <input type="text" name="paraf_petugas" value="{{ old('paraf_petugas', $form->paraf_petugas) }}" class="form-input-inline" style="width: 70%;"></td>
                    </tr>
                </table>

                <!-- Catatan (dalam kotak) & Mengetahui (tanpa kotak luar) -->
                <div style="margin-top: 15px; display: flex; justify-content: space-between; width: 100%;">
                    <!-- Catatan: tetap dalam kotak -->
                    <div class="catatan-box" style="flex: 1; margin-right: 20px;">
                        <strong>Catatan :</strong><br>
                        <textarea name="catatan" class="form-input" style="width: 100%; height: 90px; resize: none; border: none; background: transparent; font-family: inherit; font-size: inherit;">{{ old('catatan', $form->catatan) }}</textarea>
                    </div>

                    <!-- Mengetahui: tanpa kotak, mengikuti style CCTV -->
                    <div class="mengetahui-section" style="text-align: center; width: 250px; font-family: inherit;">
                        <div id="mengetahui_lokasi_tanggal" style="margin-bottom: 15px;"></div>
                        <div style="margin-bottom: 5px;">Mengetahui,</div>
                        <div id="mengetahui_jabatan_display" style="margin-bottom: 5px;">
                            <input type="hidden" name="mengetahui_jabatan" id="mengetahui_jabatan_input" value="{{ old('mengetahui_jabatan', $form->mengetahui_jabatan ?? '') }}">
                            <span id="jabatan_text">{{ old('mengetahui_jabatan', $form->mengetahui_jabatan ?? '') ?: '..........................................' }}</span>
                        </div>
                        
                        <div style="height: 60px;"></div>
                        
                        <div>
                            <select id="mengetahui_nama_select" name="mengetahui_nama" class="form-select-inline" style="text-align: center; border-bottom: none; width: 100%; font-weight: bold; appearance: none; cursor: pointer; text-align-last: center;" onchange="onSignerChange()">
                                <option value="">-- Pilih Nama --</option>
                                @foreach($signers ?? [] as $signer)
                                    <option value="{{ $signer->nama }}" data-nipp="{{ $signer->nipp }}" data-jabatan="{{ $signer->jabatan }}" {{ old('mengetahui_nama', $form->mengetahui_nama) == $signer->nama ? 'selected' : '' }}>{{ $signer->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="margin-top: 5px;">
                            NIPP. <input type="text" name="mengetahui_nipp" id="mengetahui_nipp_input" value="{{ old('mengetahui_nipp', $form->mengetahui_nipp) }}" class="form-input-inline" style="width: 120px; pointer-events: none; background: transparent; border-bottom: none; text-align: center;" readonly placeholder="..........................................">
                        </div>
                    </div>
                </div>
                
                <div class="no-print" style="margin-top: 20px; text-align: right; border-top: 1px solid #eaeaea; padding-top: 20px;">
                    <a href="{{ route('form-monitoring-grounding.index') }}" class="btn-cancel">Batal</a>
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

    // ========== AUTO-FILL BULAN & TGL PELAKSANAAN FROM TANGGAL ==========
    function updateFromTanggal() {
        const tanggalInput = document.getElementById('tanggal_input');
        const bulanInput = document.getElementById('bulan_input');
        const tglPelaksanaanInput = document.getElementById('tgl_pelaksanaan_input');
        
        if (!tanggalInput || !tanggalInput.value) return;
        
        const val = tanggalInput.value.trim();
        
        // Parse Indonesian date format "DD MMMM YYYY" or "DD-MM-YYYY"
        let parsedDate = parseIndonesianDate(val);
        
        if (parsedDate) {
            // Set Bulan
            if (bulanInput && bulanIndonesia[parsedDate.month]) {
                bulanInput.value = bulanIndonesia[parsedDate.month] + ' ' + parsedDate.year;
            }
            
            // Set Tgl Pelaksanaan (same as tanggal)
            const day = String(parsedDate.day).padStart(2, '0');
            const monthName = bulanIndonesia[parsedDate.month];
            tglPelaksanaanInput.value = day + ' ' + monthName + ' ' + parsedDate.year;
            
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
            const day = parsedDate.day;
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
            <td>
                <input type="text" name="items[${rowIndex}][lokasi_grounding]" class="form-input">
            </td>
            <td class="standard-cell">
                <span>≤ 1&nbsp;&nbsp;OHM</span>
                <input type="hidden" name="items[${rowIndex}][nilai_grounding_standard]" value="≤ 1 OHM">
            </td>
            <td>
                <input type="text" name="items[${rowIndex}][hasil_pengukuran]" class="form-input">
            </td>
            <td>
                <input type="text" name="items[${rowIndex}][kondisi_bak_grounding]" class="form-input">
            </td>
            <td>
                <input type="text" name="items[${rowIndex}][tindak_lanjut]" class="form-input">
                
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
        // Re-number rows
        document.querySelectorAll('#items-table tbody tr.item-row').forEach((row, index) => {
            const noCell = row.querySelector('.no-cell');
            if (noCell) noCell.textContent = index + 1;
        });
    }

    // ========== INIT EVENT LISTENERS ==========
    document.addEventListener('DOMContentLoaded', function() {
        // Listen for tanggal changes (custom date picker fires 'change')
        const tanggalInput = document.getElementById('tanggal_input');
        if (tanggalInput) {
            tanggalInput.addEventListener('change', updateFromTanggal);
            tanggalInput.addEventListener('blur', updateFromTanggal);
            // Also observe value changes via MutationObserver for datepicker
            const observer = new MutationObserver(function() { updateFromTanggal(); });
            observer.observe(tanggalInput, { attributes: true, attributeFilter: ['value'] });
            // Poll for datepicker changes (some datepickers set value without events)
            let lastTanggalVal = tanggalInput.value;
            setInterval(function() {
                if (tanggalInput.value !== lastTanggalVal) {
                    lastTanggalVal = tanggalInput.value;
                    updateFromTanggal();
                }
            }, 500);
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
        
        // Trigger signer auto-fill if already selected (edit mode)
        const signerSelect = document.getElementById('mengetahui_nama_select');
        if (signerSelect && signerSelect.value) {
            // Don't overwrite existing jabatan/nipp on edit — they're already set from DB
        }
    });
</script>
@endsection


