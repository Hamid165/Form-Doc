<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Rencana Pelatihan Personil</title>
    <!-- Tambahkan Tailwind CDN agar styling Modal Import Excel berjalan sempurna -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .a4-wrapper { display: flex; flex-direction: column; align-items: center; padding: 20px; background-color: #f3f4f6; }
        .a4-container { width: 210mm; min-height: 297mm; background: white; padding: 15mm 20mm; box-sizing: border-box; box-shadow: 0 4px 15px rgba(0,0,0,0.1); font-family: Arial, sans-serif; font-size: 11px; color: #000; position: relative; margin-bottom: 20px; display: flex; flex-direction: column; }
        .a4-container-landscape { width: 297mm; min-height: 210mm; background: white; padding: 15mm 20mm; box-sizing: border-box; box-shadow: 0 4px 15px rgba(0,0,0,0.1); font-family: Arial, sans-serif; font-size: 11px; color: #000; position: relative; margin-bottom: 20px; display: flex; flex-direction: column; }

        .kop-table { width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 25px; }
        .kop-table td { border: 1px solid #000; padding: 5px 8px; vertical-align: middle; }
        .terbatas-box { border: 2px solid #eab308; color: #eab308; font-weight: bold; font-size: 14px; padding: 4px 8px; display: inline-block; text-align: center; }

        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 10px; text-align: center; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 5px; position: relative; height: 25px; vertical-align: middle;}
        .data-table th { font-weight: bold; background-color: #f9fafb; }

        .form-input-line { width: 100%; border: none; outline: none; background: transparent; font-family: inherit; font-size: inherit; text-align: center; padding: 2px; }
        .form-input-line:focus { background-color: #e0f2fe; }
        .input-left { text-align: left !important; }
        .red-placeholder::placeholder { color: red; font-style: italic; }

        .btn-submit { background-color: #16a34a; color: white; padding: 6px 16px; height: 36px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 13px; transition: background 0.2s; }
        .btn-cancel { background-color: #ef4444; color: white; padding: 6px 16px; height: 36px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 13px; margin-right: 10px; text-decoration: none; }
        .btn-tambah-baris { display: inline-flex; height: 28px; padding: 4px 12px; background-color: #f59e0b; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 11px; margin-top: 10px; }
        .btn-import-data { display: inline-flex; height: 28px; padding: 4px 12px; background-color: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 11px; margin-top: 10px; margin-right: 8px; }
        .btn-delete-row { position: absolute; right: -28px; top: 50%; transform: translateY(-50%); background-color: #fef2f2; border: none; color: #dc2626; cursor: pointer; padding: 4px; border-radius: 4px; font-weight: bold; }

        .cover-top { display: flex; align-items: center; margin-bottom: 120px; }
        .cover-title { text-align: center; font-size: 22px; font-weight: bold; line-height: 1.5; margin-bottom: auto; }
        .cover-meta { width: 100%; border-collapse: collapse; font-size: 12px; border-top: 4px solid #000; border-bottom: 4px solid #000; margin-top: auto; }
        .cover-meta td { border: 1px solid #000; padding: 8px 10px; }
        .cover-meta th { border: 1px solid #000; padding: 8px 10px; text-align: left; width: 35%; font-weight: normal; }

        .pengesahan-box { width: 100%; border: 1px solid #000; text-align: center; font-size: 11px; margin-top: 10px; }
        .pengesahan-header { padding: 8px; border-bottom: 1px solid #000; font-weight: bold; background-color: #f9fafb; }
        .pengesahan-body { height: 90px; display: flex; flex-direction: column; justify-content: flex-end; padding-bottom: 10px; font-weight: bold; }

        .daftar-isi-row { display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 12px; }
        .daftar-isi-dots { flex-grow: 1; border-bottom: 1px dotted #000; margin: 0 10px; position: relative; top: -4px; }
    </style>
</head>
<body>
<div class="a4-wrapper">
    <form action="{{ $action }}" method="POST" id="mainForm" style="display: flex; flex-direction: column; align-items: center; width: 100%;">
        @csrf
        @if(isset($method) && $method === 'PUT') @method('PUT') @endif

        @isset($masterSigners)
        <datalist id="signer-list">
            @foreach($masterSigners as $ms)
                <option value="{{ $ms->nama }}" data-nipp="{{ $ms->nipp }}" data-jabatan="{{ $ms->jabatan }}"></option>
            @endforeach
        </datalist>
        @endisset

        <!-- HALAMAN COVER -->
        <div class="a4-container">
            <div class="cover-top">
                <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI" style="width: 100px; margin-right: 20px;">
                <div style="font-weight: bold; font-size: 14px;">PT. KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI</div>
            </div>
            <div class="cover-title">RENCANA PELATIHAN DAN PENINGKATAN<br>KOMPETENSI PERSONIL</div>
            <table class="cover-meta">
                <tr><th>Nomor Dokumen</th><td><input type="text" name="no_dokumen" id="input_no_dokumen" value="{{ old('no_dokumen', $form->no_dokumen) }}" class="form-input-line input-left" required></td></tr>
                <tr><th>Tanggal Terbit</th><td><input type="text" name="tanggal_terbit" id="input_tanggal_terbit" value="{{ old('tanggal_terbit', $form->tanggal_terbit) }}" class="form-input-line input-left" required></td></tr>
                <tr><th>Versi</th><td><input type="text" name="versi" id="input_versi" value="{{ old('versi', $form->versi) }}" class="form-input-line input-left" required></td></tr>
                <tr><th>Pemilik Dokumen</th><td><input type="text" name="pemilik_dokumen" value="{{ old('pemilik_dokumen', $form->pemilik_dokumen ?? 'Unit Sistem Informasi (CI)') }}" class="form-input-line input-left"></td></tr>
                <tr><th>Klasifikasi</th><td><div class="terbatas-box" style="padding: 2px 8px; font-size: 12px;">TERBATAS</div></td></tr>
            </table>
        </div>

        <!-- HALAMAN 2: LEMBAR PENGESAHAN -->
        <div class="a4-container">
            <table class="kop-table">
                <tr>
                    <td rowspan="2" style="width: 20%; text-align: center;"><img src="{{ asset('images/logo-kai.svg') }}" style="width: 80px;"></td>
                    <td rowspan="2" style="width: 45%; text-align: center; font-weight: bold; font-size: 12px;">PT. KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI</td>
                    <td style="width: 10%;">Nomor</td><td style="width: 25%;"><span class="sync-no_dokumen"></span></td>
                </tr>
                <tr><td>Tanggal</td><td><span class="sync-tanggal_terbit"></span></td></tr>
                <tr>
                    <td rowspan="2" style="text-align: center; padding: 8px;"><div class="terbatas-box">TERBATAS</div></td>
                    <td rowspan="2" style="text-align: center; font-weight: bold; font-size: 11px;">RENCANA PELATIHAN DAN PENINGKATAN<br>KOMPETENSI PERSONIL</td>
                    <td>Versi</td><td><span class="sync-versi"></span></td>
                </tr>
                <tr><td>Halaman</td><td>i dari iii</td></tr>
            </table>

            <h3 style="text-align: center; font-size: 13px; margin-bottom: 25px;">LEMBAR PENGESAHAN</h3>
            <div style="text-align: center; font-size: 11px; font-weight: bold; margin-bottom: 5px;">Penyusun</div>
            <table class="data-table" id="table-penyusun">
                <thead><tr><th style="width: 8%;">No.</th><th style="width: 35%;">Nama</th><th style="width: 27%;">NIPP</th><th style="width: 30%;">Jabatan</th></tr></thead>
                <tbody>
                    @php $penyusuns = old('penyusun', $form->penyusun ?? []); $maxPenyusun = max(1, count($penyusuns)); @endphp
                    @for($i = 0; $i < $maxPenyusun; $i++)
                    @php $p = $penyusuns[$i] ?? ['nama'=>'', 'nipp'=>'', 'jabatan'=>'']; @endphp
                    <tr>
                        <td class="row-number">{{ $i+1 }}</td>
                        <td><input type="text" name="penyusun[{{$i}}][nama]" value="{{ $p['nama'] }}" class="form-input-line" list="signer-list" oninput="autofillSigner(this)"></td>
                        <td><input type="text" name="penyusun[{{$i}}][nipp]" value="{{ $p['nipp'] }}" class="form-input-line"></td>
                        <td>
                            <input type="text" name="penyusun[{{$i}}][jabatan]" value="{{ $p['jabatan'] }}" class="form-input-line">
                            @if($i >= 1)<button type="button" class="btn-delete-row" onclick="removeRow(this, 'table-penyusun', 'penyusun')">X</button>@endif
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
            <div style="text-align: right; margin-bottom: 20px;" class="no-print">
                <button type="button" class="btn-import-data" onclick="openImportModal('penyusun')">Import Data</button>
                <button type="button" class="btn-tambah-baris" onclick="addRowPenyusun()">+ Tambah Penyusun</button>
            </div>

            <div style="text-align: center; font-size: 11px; font-weight: bold; margin-top: 40px;">Pengesahan</div>
            <div class="pengesahan-box">
                <div class="pengesahan-header">
                    Disetujui Oleh :<br>
                    <input type="text" name="disetujui_jabatan" value="{{ old('disetujui_jabatan', $form->disetujui_jabatan ?? '') }}" class="form-input-line" style="font-weight: bold; width: 100%; text-align: center;" placeholder="Jabatan">
                </div>
                <div class="pengesahan-body">
                    <div><input type="text" name="disetujui_nama" value="{{ old('disetujui_nama', $form->disetujui_nama) }}" class="form-input-line" style="width: 250px; text-decoration: underline;" placeholder="Nama Lengkap" list="signer-list" oninput="autofillDisetujui(this)"></div>
                    <div>NIPP. <input type="text" name="disetujui_nipp" value="{{ old('disetujui_nipp', $form->disetujui_nipp) }}" class="form-input-line" style="width: 150px;" placeholder="NIPP"></div>
                </div>
                <div class="pengesahan-header" style="border-top: 1px solid #000;">
                    Disahkan Oleh :<br>
                    <input type="text" name="disahkan_jabatan" value="{{ old('disahkan_jabatan', $form->disahkan_jabatan ?? '') }}" class="form-input-line" style="font-weight: bold; width: 100%; text-align: center;" placeholder="Jabatan">
                </div>
                <div class="pengesahan-body">
                    <div><input type="text" name="disahkan_nama" value="{{ old('disahkan_nama', $form->disahkan_nama) }}" class="form-input-line" style="width: 250px; text-decoration: underline;" placeholder="Nama Lengkap" list="signer-list" oninput="autofillDisahkan(this)"></div>
                    <div>NIPP. <input type="text" name="disahkan_nipp" value="{{ old('disahkan_nipp', $form->disahkan_nipp) }}" class="form-input-line" style="width: 150px;" placeholder="NIPP"></div>
                </div>
            </div>
        </div>

        <!-- HALAMAN 3: RIWAYAT PERUBAHAN -->
        <div class="a4-container">
            <table class="kop-table">
                <tr>
                    <td rowspan="2" style="width: 20%; text-align: center;"><img src="{{ asset('images/logo-kai.svg') }}" style="width: 80px;"></td>
                    <td rowspan="2" style="width: 45%; text-align: center; font-weight: bold; font-size: 12px;">PT. KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI</td>
                    <td style="width: 10%;">Nomor</td><td style="width: 25%;"><span class="sync-no_dokumen"></span></td>
                </tr>
                <tr><td>Tanggal</td><td><span class="sync-tanggal_terbit"></span></td></tr>
                <tr>
                    <td rowspan="2" style="text-align: center; padding: 8px;"><div class="terbatas-box">TERBATAS</div></td>
                    <td rowspan="2" style="text-align: center; font-weight: bold; font-size: 11px;">RENCANA PELATIHAN DAN PENINGKATAN<br>KOMPETENSI PERSONIL</td>
                    <td>Versi</td><td><span class="sync-versi"></span></td>
                </tr>
                <tr><td>Halaman</td><td>ii dari iii</td></tr>
            </table>

            <h3 style="text-align: center; font-size: 13px; margin-bottom: 25px;">RIWAYAT PERUBAHAN</h3>
            <table class="data-table" id="table-riwayat">
                <thead><tr><th style="width:10%">Versi</th><th style="width:25%">Penyusun /<br>Pelaksana Revisi</th><th style="width:20%">Tanggal Revisi</th><th style="width:10%">Hal</th><th style="width:35%">Keterangan Perubahan</th></tr></thead>
                <tbody>
                    @php $riwayats = old('riwayat_perubahan', $form->riwayat_perubahan ?? []); $maxRiwayat = max(1, count($riwayats)); @endphp
                    @for($i = 0; $i < $maxRiwayat; $i++)
                    @php $r = $riwayats[$i] ?? ['versi'=>'', 'penyusun'=>'', 'tanggal'=>'', 'hal'=>'', 'keterangan'=>'']; @endphp
                    <tr>
                        <td><input type="text" name="riwayat_perubahan[{{$i}}][versi]" value="{{ $r['versi'] }}" class="form-input-line"></td>
                        <td><input type="text" name="riwayat_perubahan[{{$i}}][penyusun]" value="{{ $r['penyusun'] }}" class="form-input-line"></td>
                        <td><input type="text" name="riwayat_perubahan[{{$i}}][tanggal]" value="{{ $r['tanggal'] }}" class="form-input-line"></td>
                        <td><input type="text" name="riwayat_perubahan[{{$i}}][hal]" value="{{ $r['hal'] }}" class="form-input-line"></td>
                        <td>
                            <input type="text" name="riwayat_perubahan[{{$i}}][keterangan]" value="{{ $r['keterangan'] }}" class="form-input-line input-left">
                            @if($i >= 1)<button type="button" class="btn-delete-row" onclick="removeRow(this, 'table-riwayat', 'riwayat_perubahan')">X</button>@endif
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
            <div style="text-align: right; margin-bottom: 20px;" class="no-print">
                <button type="button" class="btn-import-data" onclick="openImportModal('riwayat')">Import Data</button>
                <button type="button" class="btn-tambah-baris" onclick="addRowRiwayat()">+ Tambah Riwayat</button>
            </div>
        </div>

        <!-- HALAMAN 4: DAFTAR ISI -->
        <div class="a4-container">
            <table class="kop-table">
                <tr>
                    <td rowspan="2" style="width: 20%; text-align: center;"><img src="{{ asset('images/logo-kai.svg') }}" style="width: 80px;"></td>
                    <td rowspan="2" style="width: 45%; text-align: center; font-weight: bold; font-size: 12px;">PT. KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI</td>
                    <td style="width: 10%;">Nomor</td><td style="width: 25%;"><span class="sync-no_dokumen"></span></td>
                </tr>
                <tr><td>Tanggal</td><td><span class="sync-tanggal_terbit"></span></td></tr>
                <tr>
                    <td rowspan="2" style="text-align: center; padding: 8px;"><div class="terbatas-box">TERBATAS</div></td>
                    <td rowspan="2" style="text-align: center; font-weight: bold; font-size: 11px;">RENCANA PELATIHAN DAN PENINGKATAN<br>KOMPETENSI PERSONIL</td>
                    <td>Versi</td><td><span class="sync-versi"></span></td>
                </tr>
                <tr><td>Halaman</td><td>iii dari iii</td></tr>
            </table>

            <h3 style="text-align: center; font-size: 14px; margin-bottom: 50px; font-weight: bold;">DAFTAR ISI</h3>
            <div style="padding: 0 10px;">
                <div style="text-align: right; margin-bottom: 10px; font-size: 12px;">Hal.</div>
                <div class="daftar-isi-row"><span>LEMBAR PENGESAHAN</span><span class="daftar-isi-dots"></span><span>i</span></div>
                <div class="daftar-isi-row"><span>RIWAYAT PERUBAHAN</span><span class="daftar-isi-dots"></span><span>ii</span></div>
                <div class="daftar-isi-row"><span>DAFTAR ISI</span><span class="daftar-isi-dots"></span><span>iii</span></div>
                <div class="daftar-isi-row"><span>1. ANALISA KEBUTUHAN PELATIHAN DAN PENINGKATAN KOMPETENSI</span><span class="daftar-isi-dots"></span><span>1</span></div>
                <div class="daftar-isi-row"><span>2. PENGKAJIAN DOKUMEN</span><span class="daftar-isi-dots"></span><span>1</span></div>
            </div>
        </div>

        <!-- HALAMAN 5: LANDSCAPE -->
        <div class="a4-container-landscape">
            <table class="kop-table">
                <tr>
                    <td rowspan="2" style="width: 15%; text-align: center;"><img src="{{ asset('images/logo-kai.svg') }}" style="width: 80px;"></td>
                    <td rowspan="2" style="width: 55%; text-align: center; font-weight: bold; font-size: 12px;">PT. KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI</td>
                    <td style="width: 10%;">Nomor</td><td style="width: 20%;"><span class="sync-no_dokumen"></span></td>
                </tr>
                <tr><td>Tanggal</td><td><span class="sync-tanggal_terbit"></span></td></tr>
                <tr>
                    <td rowspan="2" style="text-align: center; padding: 8px;"><div class="terbatas-box">TERBATAS</div></td>
                    <td rowspan="2" style="text-align: center; font-weight: bold; font-size: 11px;">RENCANA PELATIHAN DAN PENINGKATAN<br>KOMPETENSI PERSONIL</td>
                    <td>Versi</td><td><span class="sync-versi"></span></td>
                </tr>
                <tr><td>Halaman</td><td>1 dari 1</td></tr>
            </table>

            <div style="font-size: 11px; font-weight: bold; margin-bottom: 10px;">1. <span style="margin-left: 10px;">ANALISA KEBUTUHAN PELATIHAN DAN PENINGKATAN KOMPETENSI</span></div>
            <table class="data-table" id="table-analisa">
                <thead>
                    <tr>
                        <th style="width: 4%;">No</th>
                        <th style="width: 14%;">Nama Personil</th>
                        <th style="width: 14%;">Jabatan / Peran</th>
                        <th style="width: 26%;">Kebutuhan Peningkatan<br>Kompetensi</th>
                        <th style="width: 16%;">Metode</th>
                        <th style="width: 14%;">Rencana Realisasi</th>
                        <th style="width: 12%;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @php $analisas = old('analisa_kebutuhan', $form->analisa_kebutuhan ?? []); $maxAnalisa = max(1, count($analisas)); @endphp
                    @for($i = 0; $i < $maxAnalisa; $i++)
                    @php $a = $analisas[$i] ?? ['nama'=>'', 'jabatan'=>'', 'kebutuhan'=>'', 'metode'=>'', 'realisasi'=>'', 'keterangan'=>'']; @endphp
                    <tr>
                        <td class="row-number">{{ $i+1 }}</td>
                        <td><input type="text" name="analisa_kebutuhan[{{$i}}][nama]" value="{{ $a['nama'] }}" class="form-input-line red-placeholder" {!! $i == 0 ? 'placeholder="(Berisi nama personil)"' : '' !!}></td>
                        <td><input type="text" name="analisa_kebutuhan[{{$i}}][jabatan]" value="{{ $a['jabatan'] }}" class="form-input-line red-placeholder" {!! $i == 0 ? 'placeholder="(Berisi jenis peran / jabatan dari personil)"' : '' !!}></td>
                        <td><input type="text" name="analisa_kebutuhan[{{$i}}][kebutuhan]" value="{{ $a['kebutuhan'] }}" class="form-input-line red-placeholder" {!! $i == 0 ? 'placeholder="(Berisi rencana peningkatan yang dibutuhkan / akan dilakukan)"' : '' !!}></td>
                        <td><input type="text" name="analisa_kebutuhan[{{$i}}][metode]" value="{{ $a['metode'] }}" class="form-input-line red-placeholder" {!! $i == 0 ? 'placeholder="(Berisi cara pelaksanaan peningkatan, misal: pelatihan, pendidikan formal, dll)"' : '' !!}></td>
                        <td><input type="text" name="analisa_kebutuhan[{{$i}}][realisasi]" value="{{ $a['realisasi'] }}" class="form-input-line red-placeholder" {!! $i == 0 ? 'placeholder="(target waktu pelaksanaan peningkatan)"' : '' !!}></td>
                        <td>
                            <input type="text" name="analisa_kebutuhan[{{$i}}][keterangan]" value="{{ $a['keterangan'] }}" class="form-input-line red-placeholder" {!! $i == 0 ? 'placeholder="(berisi keterangan lebih lanjut jika ada)"' : '' !!}>
                            @if($i >= 1)<button type="button" class="btn-delete-row" onclick="removeRow(this, 'table-analisa', 'analisa_kebutuhan')">X</button>@endif
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
            <div style="text-align: right; margin-bottom: 25px;" class="no-print">
                <button type="button" class="btn-import-data" onclick="openImportModal('analisa')">Import Data</button>
                <button type="button" class="btn-tambah-baris" onclick="addRowAnalisa()">+ Tambah Analisa</button>
            </div>

            <div style="font-size: 11px; font-weight: bold; margin-bottom: 10px;">2. <span style="margin-left: 10px;">PENGKAJIAN DOKUMEN</span></div>
            <div style="font-size: 11px; line-height: 1.8; text-align: justify; padding-left: 22px;">
                <p style="margin-top: 0; margin-bottom: 15px;">Dokumen ini dikelola oleh Pengelola Dokumen. Setiap masukan perubahan terhadap dokumen ini harus diajukan kepada Pengelola Dokumen dan perubahannya disetujui oleh pemegang kewenangan sesuai ketentuan yang berlaku di PT. Kereta Api Indonesia (Persero).</p>
                <p style="margin-top: 0;">Dokumen ini harus ditinjau ulang secara berkala oleh Pengelola Dokumen paling sedikit 1 (satu) kali dalam 1 (satu) tahun untuk memastikan kesesuaiannya dengan kondisi organisasi.</p>
            </div>

            <div style="margin-top: auto; text-align: right; border-top: 1px solid #eaeaea; padding-top: 20px;">
                <a href="{{ route('form-rencana-pelatihan.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">{{ isset($form) && $form->exists ? 'Perbarui Dokumen' : 'Simpan Dokumen' }}</button>
            </div>
        </div>
    </form>
</div>

<!-- MODAL IMPORT EXCEL -->
<div id="importModal" class="fixed inset-0 bg-slate-900/50 hidden z-[100] items-center justify-center backdrop-blur-sm transition-all duration-300 opacity-0">
    <div class="bg-white rounded-xl w-[400px] p-6 shadow-xl relative transform transition-all scale-95" id="importModalContent">
        <button type="button" onclick="closeImportModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <h3 id="importModalTitle" class="text-[17px] font-bold text-slate-800 mb-2">Import Data via Excel</h3>
        <p class="text-[13px] text-slate-500 mb-4 leading-relaxed">Silakan upload file Excel berformat .xlsx yang datanya berurutan dari kiri ke kanan sesuai kolom pada tabel yang dituju.</p>

        <button type="button" onclick="downloadTemplate()" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 text-[13px] font-semibold mb-6 transition-colors bg-transparent border-none cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Download Template Excel (XLSX)
        </button>

        <div class="mb-6">
            <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-wider">FILE EXCEL <span class="text-red-500">*</span></label>
            <div class="border border-slate-200 rounded-lg p-2 flex items-center gap-3 bg-slate-50/50">
                <label class="cursor-pointer bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-1.5 rounded-md text-[12px] font-semibold transition-colors">
                    Pilih File
                    <input type="file" id="excelFileInput" class="hidden" accept=".xlsx, .xls, .csv">
                </label>
                <span id="fileNameDisplay" class="text-slate-400 text-[13px] truncate w-[200px]">Tidak ada file yang dipilih</span>
            </div>
        </div>

        <div class="flex justify-end gap-2 pt-2 border-t border-slate-100">
            <button type="button" onclick="closeImportModal()" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-lg text-[13px] font-semibold hover:bg-slate-200 transition-colors">Batal</button>
            <button type="button" onclick="processExcelImport()" class="px-5 py-2.5 bg-[#2563eb] text-white rounded-lg text-[13px] font-semibold hover:bg-blue-700 transition-colors">Import Data</button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const syncFields = ['no_dokumen', 'tanggal_terbit', 'versi'];
        syncFields.forEach(field => {
            const input = document.getElementById('input_' + field);
            const targets = document.querySelectorAll('.sync-' + field);
            if (input && targets.length > 0) {
                const updateValue = () => {
                    targets.forEach(target => {
                        target.innerText = input.value || '';
                    });
                };
                input.addEventListener('input', updateValue);
                setTimeout(updateValue, 100);
            }
        });

        const fileInput = document.getElementById('excelFileInput');
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                let fileName = e.target.files[0] ? e.target.files[0].name : 'Tidak ada file yang dipilih';
                document.getElementById('fileNameDisplay').innerText = fileName;
            });
        }
    });

    let currentImportTarget = '';

    function openImportModal(target) {
        currentImportTarget = target;
        const modal = document.getElementById('importModal');
        const content = document.getElementById('importModalContent');
        const title = document.getElementById('importModalTitle');

        if(target === 'penyusun') title.innerText = 'Import Tabel Penyusun';
        else if(target === 'riwayat') title.innerText = 'Import Tabel Riwayat Perubahan';
        else if(target === 'analisa') title.innerText = 'Import Tabel Analisa Kebutuhan';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 10);
    }

    function closeImportModal() {
        const modal = document.getElementById('importModal');
        const content = document.getElementById('importModalContent');
        modal.classList.add('opacity-0');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            let fileInput = document.getElementById('excelFileInput');
            if(fileInput) fileInput.value = '';
            let fileNameDisplay = document.getElementById('fileNameDisplay');
            if(fileNameDisplay) fileNameDisplay.innerText = 'Tidak ada file yang dipilih';
        }, 300);
    }

    function downloadTemplate() {
        if (typeof XLSX === 'undefined') {
            alert('Library Excel belum siap dimuat. Pastikan koneksi internet kamu aktif.');
            return;
        }

        let headers = [];
        let filename = '';

        if (currentImportTarget === 'penyusun') {
            headers = ['Nama', 'NIPP', 'Jabatan'];
            filename = 'Template_Data_Penyusun.xlsx';
        } else if (currentImportTarget === 'riwayat') {
            headers = ['Versi', 'Penyusun / Pelaksana Revisi', 'Tanggal Revisi', 'Hal', 'Keterangan Perubahan'];
            filename = 'Template_Riwayat_Perubahan.xlsx';
        } else if (currentImportTarget === 'analisa') {
            headers = ['Nama Personil', 'Jabatan / Peran', 'Kebutuhan Peningkatan Kompetensi', 'Metode', 'Rencana Realisasi', 'Keterangan'];
            filename = 'Template_Analisa_Kebutuhan.xlsx';
        }

        const ws = XLSX.utils.aoa_to_sheet([headers]);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Template");

        XLSX.writeFile(wb, filename);
    }

    /* FUNGSI REINDEXING UTAMA: Menjaga urutan array name="prefix[index][field]" tetap rapi */
    function reindexTable(tableId, arrayPrefix) {
        const rows = document.querySelectorAll(`#${tableId} tbody tr`);
        rows.forEach((row, index) => {
            const numCell = row.querySelector('.row-number');
            if(numCell) numCell.innerText = index + 1;

            const inputs = row.querySelectorAll('input');
            inputs.forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    const newName = name.replace(new RegExp(`${arrayPrefix}\\[\\d+\\]`), `${arrayPrefix}[${index}]`);
                    input.setAttribute('name', newName);
                }
            });
        });
    }

    function removeRow(btn, tableId, arrayPrefix) {
        btn.closest('tr').remove();
        reindexTable(tableId, arrayPrefix);
    }

    function addRowPenyusun() {
        const tbody = document.querySelector('#table-penyusun tbody');
        const index = tbody.children.length;
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="row-number">${index + 1}</td>
            <td><input type="text" name="penyusun[${index}][nama]" class="form-input-line" list="signer-list" oninput="autofillSigner(this)"></td>
            <td><input type="text" name="penyusun[${index}][nipp]" class="form-input-line"></td>
            <td>
                <input type="text" name="penyusun[${index}][jabatan]" class="form-input-line">
                <button type="button" class="btn-delete-row" onclick="removeRow(this, 'table-penyusun', 'penyusun')">X</button>
            </td>`;
        tbody.appendChild(tr);
        reindexTable('table-penyusun', 'penyusun');
    }

    function addRowRiwayat() {
        const tbody = document.querySelector('#table-riwayat tbody');
        const index = tbody.children.length;
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><input type="text" name="riwayat_perubahan[${index}][versi]" class="form-input-line"></td>
            <td><input type="text" name="riwayat_perubahan[${index}][penyusun]" class="form-input-line"></td>
            <td><input type="text" name="riwayat_perubahan[${index}][tanggal]" class="form-input-line"></td>
            <td><input type="text" name="riwayat_perubahan[${index}][hal]" class="form-input-line"></td>
            <td>
                <input type="text" name="riwayat_perubahan[${index}][keterangan]" class="form-input-line input-left">
                <button type="button" class="btn-delete-row" onclick="removeRow(this, 'table-riwayat', 'riwayat_perubahan')">X</button>
            </td>`;
        tbody.appendChild(tr);
        reindexTable('table-riwayat', 'riwayat_perubahan');
    }

    function addRowAnalisa() {
        const tbody = document.querySelector('#table-analisa tbody');
        const index = tbody.children.length;
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="row-number">${index + 1}</td>
            <td><input type="text" name="analisa_kebutuhan[${index}][nama]" class="form-input-line"></td>
            <td><input type="text" name="analisa_kebutuhan[${index}][jabatan]" class="form-input-line"></td>
            <td><input type="text" name="analisa_kebutuhan[${index}][kebutuhan]" class="form-input-line"></td>
            <td><input type="text" name="analisa_kebutuhan[${index}][metode]" class="form-input-line"></td>
            <td><input type="text" name="analisa_kebutuhan[${index}][realisasi]" class="form-input-line"></td>
            <td>
                <input type="text" name="analisa_kebutuhan[${index}][keterangan]" class="form-input-line">
                <button type="button" class="btn-delete-row" onclick="removeRow(this, 'table-analisa', 'analisa_kebutuhan')">X</button>
            </td>`;
        tbody.appendChild(tr);
        reindexTable('table-analisa', 'analisa_kebutuhan');
    }

    function processExcelImport() {
        try {
            if (typeof XLSX === 'undefined') {
                alert('Sistem pembaca Excel belum siap! Pastikan koneksi internet kamu aktif.');
                return;
            }

            const fileInput = document.getElementById('excelFileInput');
            if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                alert('Silakan pilih file Excel terlebih dahulu!');
                return;
            }

            const file = fileInput.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, {type: 'array'});
                const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                const rows = XLSX.utils.sheet_to_json(firstSheet, {header: 1, defval: ""});

                if (rows.length <= 1) {
                    alert('File Excel kosong atau hanya berisi judul kolom!');
                    return;
                }

                let tbodyId = '';
                let addRowFunc = null;
                let arrayPrefix = '';

                if (currentImportTarget === 'penyusun') {
                    tbodyId = '#table-penyusun tbody';
                    addRowFunc = addRowPenyusun;
                    arrayPrefix = 'penyusun';
                } else if (currentImportTarget === 'riwayat') {
                    tbodyId = '#table-riwayat tbody';
                    addRowFunc = addRowRiwayat;
                    arrayPrefix = 'riwayat_perubahan';
                } else if (currentImportTarget === 'analisa') {
                    tbodyId = '#table-analisa tbody';
                    addRowFunc = addRowAnalisa;
                    arrayPrefix = 'analisa_kebutuhan';
                }

                const tbody = document.querySelector(tbodyId);
                tbody.innerHTML = '';
                let dataDitambahkan = 0;

                for (let i = 1; i < rows.length; i++) {
                    let rowData = rows[i];
                    if (!rowData || rowData.length === 0 || rowData.every(val => val === "")) continue;

                    addRowFunc();
                    let lastRow = tbody.lastElementChild;
                    let inputs = lastRow.querySelectorAll('input[type="text"]');

                    for (let j = 0; j < inputs.length; j++) {
                        if (rowData[j] !== undefined && rowData[j] !== null) {
                            inputs[j].value = rowData[j];
                        }
                    }
                    dataDitambahkan++;
                }

                if(dataDitambahkan === 0) { addRowFunc(); }

                reindexTable(tbodyId.replace(' tbody', '').replace('#', ''), arrayPrefix);

                closeImportModal();
                alert('Berhasil! ' + dataDitambahkan + ' baris data telah ditambahkan ke tabel.');
            };

            reader.readAsArrayBuffer(file);
        } catch (error) {
            console.error(error);
            alert('Terjadi kesalahan saat memproses file Excel.');
        }
    }

    function autofillSigner(inputElement) {
        const tr = inputElement.closest('tr');
        const list = document.getElementById('signer-list');
        if (!list) return;
        for (let i = 0; i < list.options.length; i++) {
            if (list.options[i].value === inputElement.value) {
                const nippInput = tr.querySelector('input[name*="[nipp]"]');
                const jabatanInput = tr.querySelector('input[name*="[jabatan]"]');
                if (nippInput) nippInput.value = list.options[i].getAttribute('data-nipp') || '';
                if (jabatanInput) jabatanInput.value = list.options[i].getAttribute('data-jabatan') || '';
                break;
            }
        }
    }

    function autofillDisetujui(input) {
        const list = document.getElementById('signer-list');
        if(!list) return;
        for (let i = 0; i < list.options.length; i++) {
            if (list.options[i].value === input.value) {
                document.querySelector('input[name="disetujui_nipp"]').value = list.options[i].getAttribute('data-nipp') || '';
                document.querySelector('input[name="disetujui_jabatan"]').value = list.options[i].getAttribute('data-jabatan') || '';
                break;
            }
        }
    }

    function autofillDisahkan(input) {
        const list = document.getElementById('signer-list');
        if(!list) return;
        for (let i = 0; i < list.options.length; i++) {
            if (list.options[i].value === input.value) {
                document.querySelector('input[name="disahkan_nipp"]').value = list.options[i].getAttribute('data-nipp') || '';
                document.querySelector('input[name="disahkan_jabatan"]').value = list.options[i].getAttribute('data-jabatan') || '';
                break;
            }
        }
    }
</script>
</body>
</html>
