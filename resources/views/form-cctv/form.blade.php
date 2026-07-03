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
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        font-size: 13px;
        transition: background 0.2s;
    }
    .btn-submit:hover {
        background-color: #388e3c;
    }
    
    .btn-kembali {
        display: inline-block; padding: 8px 16px; background-color: #f44336; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; font-family: inherit; font-size: 13px; box-sizing: border-box;
        transition: background-color 0.2s;
    }
    .btn-kembali:hover {
        background-color: #d32f2f;
    }

    .btn-tambah-baris {
        padding: 6px 12px; background-color: #f39c12; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 11px;
        transition: background-color 0.2s;
    }
    .btn-tambah-baris:hover {
        background-color: #e67e22;
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
        content: "▼";
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


<div class="a4-wrapper">
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
                        <td>: <input type="text" name="no_ref" value="{{ old('no_ref', $form->no_ref) }}" class="form-input-inline input-garis-kiri" placeholder="Contoh: 01 / 10 / 2020" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')"></td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>: <input type="text" name="tanggal" value="{{ old('tanggal', $form->tanggal) }}" class="form-input-inline input-garis-kiri custom-date-picker" style="cursor: pointer;" placeholder="Tanggal" autocomplete="off" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')"></td>
                    </tr>
                    <tr>
                        <td>Business Area</td>
                        <td>: <input type="text" name="business_area" value="{{ old('business_area', $form->business_area) }}" class="form-input-inline input-garis-kiri" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')"></td>
                    </tr>
                </table>

                <!-- PENGATURAN LEBAR TABEL KANAN (ID CCTV) -->
                <table class="small-info-table table-kanan">
                <tr>
                    <td class="kolom-label-kanan" style="border: none;">ID CCTV</td>
                    <td style="border: none;">: 
                        <div style="display: inline-block; position: relative; width: 150px;">
                            <select id="id_cctv" name="id_cctv" class="form-input-inline input-garis-kanan ts-align-left" style="appearance: none; cursor: pointer;" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" onchange="this.setCustomValidity('')">
                                <option value="">-- Pilih ID CCTV --</option>
                                @for($i=1; $i<=10; $i++)
                                @php $val = "CCTV-" . str_pad($i, 2, '0', STR_PAD_LEFT); @endphp
                                <option value="{{ $val }}" {{ old('id_cctv', $form->id_cctv) == $val ? 'selected' : '' }}>{{ $val }}</option>
                                @endfor
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="kolom-label-kanan" style="border: none;">LOKASI</td>
                    <td style="border: none;">: <input type="text" name="lokasi" value="{{ old('lokasi', $form->lokasi) }}" class="form-input-inline input-garis-kanan" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')"></td>
                </tr>
            </table>
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
                    @endphp
                    <tr>
                        <td style="text-align: center;">{{ $i }}<input type="hidden" name="items[{{ $i }}][no]" value="{{ $i }}"></td>
                        <td><input type="text" name="items[{{ $i }}][tanggal]" value="{{ $item['tanggal'] ?? '' }}" class="form-input custom-date-picker" autocomplete="off" style="text-align: center; cursor: pointer;" placeholder="Tanggal" {{ $i == 1 ? 'required' : '' }} oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')"></td>
                        <td style="text-align: center;"><input type="checkbox" name="items[{{ $i }}][perawatan]" value="V" style="cursor: pointer; margin: 0 auto; display: block;" class="chk-kegiatan-{{ $i }}" {{ $isPerawatan ? 'checked' : '' }}></td>
                        <td style="text-align: center;"><input type="checkbox" name="items[{{ $i }}][perbaikan]" value="V" style="cursor: pointer; margin: 0 auto; display: block;" class="chk-kegiatan-{{ $i }}" {{ $isPerbaikan ? 'checked' : '' }}></td>
                        <td><input type="text" name="items[{{ $i }}][keterangan]" value="{{ $item['keterangan'] ?? '' }}" class="form-input" style="text-align: center;" {{ $i == 1 ? 'required' : '' }} oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')"></td>
                        @if ($i > 20)
                        <td style="position: relative;">
                            <input type="text" name="items[{{ $i }}][paraf]" value="{{ $item['paraf'] ?? '' }}" class="form-input" style="text-align: center;">
                            <button type="button" class="btn-delete-row no-print" title="Hapus Baris">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16" style="pointer-events: none;">
                                  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                </svg>
                            </button>
                        </td>
                        @else
                        <td><input type="text" name="items[{{ $i }}][paraf]" value="{{ $item['paraf'] ?? '' }}" class="form-input" style="text-align: center;"></td>
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
                    <p>Yogyakarta, <input type="text" name="kota_tanggal" class="form-input-inline custom-date-picker" data-format="id" style="width: 130px; text-align: center; cursor: pointer;" value="{{ old('kota_tanggal', $form->kota_tanggal) }}" placeholder="Tanggal" autocomplete="off" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')"></p>
                    <p style="margin-top: 15px;">Mengetahui,</p>
                    <div style="height: 60px;"></div>
                    <p style="position: relative;">
                        <select id="mengetahui_nama" name="mengetahui_nama" class="form-input-inline" style="width: 100%; text-align: center; appearance: none; cursor: pointer; text-align-last: center;" onchange="updateNipp(); this.setCustomValidity('');" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')">
                            <option value="">-- Pilih Nama --</option>
                            <option value="Pitra" {{ old('mengetahui_nama', $form->mengetahui_nama) == 'Pitra' ? 'selected' : '' }}>Pitra</option>
                            <option value="Hamid" {{ old('mengetahui_nama', $form->mengetahui_nama) == 'Hamid' ? 'selected' : '' }}>Hamid</option>
                        </select>
                    </p>
                    <p style="text-align: center;">NIPP. <input type="text" id="mengetahui_nipp" name="mengetahui_nipp" value="{{ old('mengetahui_nipp', $form->mengetahui_nipp) }}" class="form-input-inline" style="width: 150px; text-align: center;" placeholder="NIPP" readonly></p>
                </div>
            </div>

            <div style="text-align: right; display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; align-items: center;">
                <a href="{{ route('form-cctv.index') }}" class="btn-kembali">Kembali</a>
                <button type="submit" class="btn-submit" style="margin-top: 0;">{{ isset($method) && $method === 'PUT' ? 'Perbarui' : 'Simpan' }}</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('cctv-form');
        if (form) {
            form.addEventListener('invalid', function(e) {
                const firstInvalid = form.querySelector(':invalid');
                if (firstInvalid && firstInvalid === e.target) {
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }, true);
        }

        // Handle checkbox validation for row 1 natively
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
    });
</script>
<script>
    let currentRowCount = {{ isset($maxItems) ? $maxItems : 20 }};
    document.getElementById('btn-add-row').addEventListener('click', function() {
        currentRowCount++;
        const tbody = document.getElementById('checklist-body');
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="text-center">${currentRowCount}<input type="hidden" name="items[${currentRowCount}][no]" value="${currentRowCount}"></td>
            <td><input type="text" name="items[${currentRowCount}][tanggal]" class="form-input custom-date-picker" autocomplete="off" style="text-align: center; cursor: pointer;" placeholder="Tanggal"></td>
            <td style="text-align: center;"><input type="checkbox" name="items[${currentRowCount}][perawatan]" value="V" style="cursor: pointer; margin: 0 auto; display: block;"></td>
            <td style="text-align: center;"><input type="checkbox" name="items[${currentRowCount}][perbaikan]" value="V" style="cursor: pointer; margin: 0 auto; display: block;"></td>
            <td><input type="text" name="items[${currentRowCount}][keterangan]" class="form-input" style="text-align: center;"></td>
            <td style="position: relative;">
                <input type="text" name="items[${currentRowCount}][paraf]" class="form-input" style="text-align: center;">
                <button type="button" class="btn-delete-row no-print" title="Hapus Baris">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16" style="pointer-events: none;">
                      <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                      <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                    </svg>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    document.getElementById('checklist-body').addEventListener('click', function(e) {
        if (e.target.closest('.btn-delete-row')) {
            const tr = e.target.closest('tr');
            if (tr) {
                tr.remove();
                reindexRows();
            }
        }
    });

    function reindexRows() {
        const rows = document.getElementById('checklist-body').querySelectorAll('tr');
        currentRowCount = rows.length;
        rows.forEach((row, index) => {
            const no = index + 1;
            const tdNo = row.querySelector('td:first-child');
            if (tdNo) {
                const hiddenInput = tdNo.querySelector('input[type="hidden"]');
                tdNo.innerHTML = no;
                if (hiddenInput) {
                    hiddenInput.value = no;
                    tdNo.appendChild(hiddenInput);
                }
            }
            row.querySelectorAll('input').forEach(input => {
                if (input.name) {
                    input.name = input.name.replace(/items\[\d+\]/, "items[" + no + "]");
                }
            });
        });
    }

    function updateNipp() {
        const select = document.getElementById('mengetahui_nama');
        const nippInput = document.getElementById('mengetahui_nipp');
        if (select.value === 'Pitra') {
            nippInput.value = '123123123';
        } else if (select.value === 'Hamid') {
            nippInput.value = '321321';
        } else {
            nippInput.value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof TomSelect !== 'undefined') {
            new TomSelect("#id_cctv",{
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                placeholder: "ID CCTV"
            });

            new TomSelect("#mengetahui_nama", {
                create: false,
                placeholder: "-- Pilih Nama --"
            });
        }
    });
</script>
@endsection
