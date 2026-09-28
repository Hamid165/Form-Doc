@extends('layouts.app')

@section('content')
<style>
    .a4-wrapper { display: flex; justify-content: center; padding: 20px; }
    .a4-container {
        width: 210mm; background: white; padding: 20mm; box-sizing: border-box;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1); font-family: Arial, Helvetica, sans-serif;
        font-size: 11px; color: #000;
    }
    .a4-container table { border-collapse: collapse; }
    .header-table, .main-table { width: 100%; }
    .header-table td { border: 1px solid black; padding: 5px 8px; vertical-align: middle; }
    .title-text { font-size: 11px; font-weight: bold; text-align: center; }
    .terbatas-box {
        border: 2px solid #f0d000; background-color: #fff9db; color: #7a6100;
        padding: 5px 10px; font-weight: bold; font-size: 13px; display: inline-block; margin: auto;
    }
    .info-section { margin-top: 15px; margin-bottom: 15px; }
    .small-info-table { margin-bottom: 15px; width: max-content; }
    .kolom-label-kiri { width: 107px; }
    .input-garis-kiri { width: 220px; }
    .small-info-table td { border: 1px solid black; padding: 4px 6px; height: auto; }
    .form-input-inline {
        border: none; border-bottom: 1px dashed #000; background: transparent;
        font-family: inherit; font-size: inherit; padding: 2px 4px; width: 100%; box-sizing: border-box;
    }
    .form-input-inline:focus { outline: none; border-bottom: 1px solid #00a4e4; }
    .pemohon-row { display: flex; align-items: baseline; margin-bottom: 12px; }
    .pemohon-label { width: 130px; flex-shrink: 0; }
    .pemohon-colon { width: 14px; flex-shrink: 0; }
    .pemohon-input { flex: 1; }
    .main-table th, .main-table td { border: 1px solid black; padding: 4px; vertical-align: middle; }
    .main-table th { font-weight: bold; text-align: center; background-color: #f9f9f9; }
    .table-input { width: 100%; border: none; background: transparent; font-family: inherit; font-size: 11px; padding: 2px; box-sizing: border-box; }
    .table-input:focus { outline: none; background-color: #fffbe6; }
    .table-textarea { width: 100%; border: none; background: transparent; font-family: inherit; font-size: 11px; padding: 2px; box-sizing: border-box; resize: vertical; }
    .table-textarea:focus { outline: none; background-color: #fffbe6; }
    .btn-delete-row { background: none; border: none; color: #dc2626; cursor: pointer; padding: 2px 6px; font-size: 13px; }
    .btn-delete-row:hover { color: #b91c1c; }

    .footer-section { margin-top: 35px; width: 100%; }
    .footer-place-row { text-align: right; margin-bottom: 20px; }
    .footer-place-row input { border: none; border-bottom: 1px dashed #000; background: transparent; font-family: inherit; font-size: 11px; text-align: center; }
    .signature-columns { display: flex; justify-content: space-between; margin-bottom: 20px; }
    .signature-box { width: 45%; text-align: center; }
    .signature-space { height: 60px; }
    .approval-section { text-align: center; margin-top: 30px; }
    .approval-space { height: 60px; }

    .btn-submit { background-color: #16a34a; color: white; padding: 6px 16px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 12px; }
    .btn-submit:hover { background-color: #15803d; }
    .btn-kembali { display: inline-flex; align-items: center; height: 32px; padding: 6px 16px; background-color: #ef4444; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 12px; }
    .btn-kembali:hover { background-color: #dc2626; }
    .btn-tambah-baris { display: inline-flex; align-items: center; height: 32px; padding: 6px 16px; background-color: #f59e0b; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 12px; }
    .btn-tambah-baris:hover { background-color: #d97706; }
    .actions-bar { display: flex; justify-content: space-between; align-items: center; margin: 15px 0; }

    @media screen and (max-width: 768px) {
        .a4-wrapper { padding: 10px !important; }
        .a4-container { width: 100% !important; padding: 15px !important; box-shadow: none !important; }
        .table-responsive { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .a4-container table { min-width: 600px; }
        .signature-columns { flex-direction: column; gap: 20px; }
        .signature-box { width: 100%; }
    }
</style>

@php
    $form = $form_pemusnahan ?? null;
    $isEdit = isset($form) && $form !== null;
    $actionUrl = $isEdit ? route('form-pemusnahan.update', $form) : route('form-pemusnahan.store');
    $items = $isEdit ? $form->items : collect();
@endphp

<div class="a4-wrapper" style="flex-direction: column; align-items: center;">
    <div style="width: 100%; max-width: 273mm; margin-bottom: 20px;">
        <a href="{{ route('form-pemusnahan.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Formulir Permohonan Pemusnahan Aset
        </a>
    </div>

    @if ($errors->any())
    <div style="width: 100%; max-width: 273mm; margin-bottom: 15px;" class="bg-red-50 border border-red-200 rounded-xl p-4">
        <h4 class="font-semibold text-red-700 mb-2">Terdapat kesalahan pada form</h4>
        <ul class="list-disc list-inside text-sm text-red-600">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="a4-container" style="max-width: 100%; overflow-x: auto;">
        <form id="pemusnahan-form" action="{{ $actionUrl }}" method="POST">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <!-- KOP DOKUMEN -->
            <div class="table-responsive">
            <table class="header-table">
                <tr>
                    <td rowspan="2" style="width: 15%; text-align: center;">
                        <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI" style="max-width: 100%; max-height: 50px;">
                    </td>
                    <td rowspan="2" class="title-text" style="width: 40%;">
                        PT KERETA API INDONESIA (PERSERO)<br>
                        SISTEM INFORMASI
                    </td>
                    <td style="width: 13%;">Nomor</td>
                    <td style="width: 22%;">: FR.SM/TI/011.004/10-2020</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: 12 Oktober 2020</td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align: center;">
                        <div class="terbatas-box">TERBATAS</div>
                    </td>
                    <td rowspan="2" class="title-text">
                        FORMULIR<br>PERMOHONAN PEMUSNAHAN ASET
                    </td>
                    <td>Versi</td>
                    <td>: 002-2020</td>
                </tr>
                <tr>
                    <td>Halaman</td>
                    <td>: 1 dari 1</td>
                </tr>
            </table>
            </div>

            <!-- NO REF / TANGGAL / BUSINESS AREA -->
            <div class="info-section">
                <table class="small-info-table">
                    <tr>
                        <td class="kolom-label-kiri">No. Ref</td>
                        <td>: <input type="text" name="no_ref" value="{{ old('no_ref', $form->no_ref ?? '') }}" class="form-input-inline input-garis-kiri" placeholder="___ /___ / _______"></td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>: <input type="date" id="tanggal_ref" name="tanggal_ref" value="{{ old('tanggal_ref', $form->tanggal_ref ?? '') }}" class="form-input-inline input-garis-kiri" onchange="syncTanggal(this.value)" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')"></td>
                    </tr>
                    <tr>
                        <td>Business Area</td>
                        <td>: <input type="text" name="business_area" value="{{ old('business_area', $form->business_area ?? '') }}" class="form-input-inline input-garis-kiri"></td>
                    </tr>
                </table>
            </div>

            <!-- DATA PEMOHON -->
            <div class="pemohon-row">
                <div class="pemohon-label">Tanggal</div>
                <div class="pemohon-colon">:</div>
                <div class="pemohon-input"><input type="date" id="tanggal_permohonan" name="tanggal_permohonan" value="{{ old('tanggal_permohonan', $form->tanggal_permohonan ?? '') }}" class="form-input-inline" readonly style="background-color:#f3f4f6; cursor:not-allowed;" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')"></div>
            </div>
            @php
                // Fallback untuk data lama yang kolom nama/nip-nya masih kosong
                // (dulu cuma disimpan gabungan di kolom nama_nip, format "Nama (NIP)")
                $fallbackNama = $form->nama ?? null;
                $fallbackNip = $form->nip ?? null;
                if (!$fallbackNama && !empty($form->nama_nip)) {
                    if (preg_match('/^(.+?)\s*\((.+?)\)\s*$/', trim($form->nama_nip), $m)) {
                        $fallbackNama = trim($m[1]);
                        $fallbackNip = trim($m[2]);
                    } else {
                        $fallbackNama = trim($form->nama_nip);
                    }
                }
            @endphp
            <div class="pemohon-row">
                <div class="pemohon-label">Nama</div>
                <div class="pemohon-colon">:</div>
                <div class="pemohon-input">
                    <input type="text" id="nama_pemohon" name="nama" list="dataPemohonNamaList" value="{{ old('nama', $fallbackNama) }}" class="form-input-inline" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')">
                    <datalist id="dataPemohonNamaList">
                        @foreach(($dataPemohons ?? []) as $p)
                            <option value="{{ $p->nama }}" data-nip="{{ $p->nip }}">
                        @endforeach
                    </datalist>
                </div>
            </div>
            <div class="pemohon-row">
                <div class="pemohon-label">NIP</div>
                <div class="pemohon-colon">:</div>
                <div class="pemohon-input">
                    <input type="text" id="nip_pemohon" name="nip" value="{{ old('nip', $fallbackNip) }}" class="form-input-inline">
                </div>
            </div>
            <div class="pemohon-row">
                <div class="pemohon-label">Unit Kerja</div>
                <div class="pemohon-colon">:</div>
                <div class="pemohon-input"><input type="text" name="unit_kerja" value="{{ old('unit_kerja', $form->unit_kerja ?? '') }}" class="form-input-inline" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')"></div>
            </div>

            <p style="margin: 15px 0 10px;">dengan ini mengajukan permohonan pemusnahan aset sebagai berikut:</p>

            <!-- TABEL ASET -->
            <div class="actions-bar" style="justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="addRow()" class="btn-tambah-baris">+ Tambah Baris</button>
            </div>
            <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 22%;">Nama Aset</th>
                        <th style="width: 20%;">Jenis Aset</th>
                        <th style="width: 18%;">ID Aset</th>
                        <th style="width: 30%;">Alasan Pemusnahan</th>
                        <th style="width: 5%;"></th>
                    </tr>
                </thead>
                <tbody id="items-body">
                    @php $rowCount = max(4, $items->count()); @endphp
                    @for ($i = 0; $i < $rowCount; $i++)
                        @php $item = $items[$i] ?? null; @endphp
                        <tr>
                            <td style="text-align:center;">{{ $i + 1 }}</td>
                            <td><input type="text" name="items[{{ $i }}][nama_aset]" value="{{ old("items.$i.nama_aset", $item->nama_aset ?? '') }}" class="table-input nama-aset-input" list="dataAsetList"></td>
                            <td><input type="text" name="items[{{ $i }}][jenis_aset]" value="{{ old("items.$i.jenis_aset", $item->jenis_aset ?? '') }}" class="table-input" placeholder="fisik / jaringan / HC / SC"></td>
                            <td><input type="text" name="items[{{ $i }}][id_aset]" value="{{ old("items.$i.id_aset", $item->id_aset ?? '') }}" class="table-input"></td>
                            <td><textarea name="items[{{ $i }}][alasan_pemusnahan]" rows="1" class="table-textarea">{{ old("items.$i.alasan_pemusnahan", $item->alasan_pemusnahan ?? '') }}</textarea></td>
                            <td style="text-align:center;"><button type="button" onclick="removeRow(this)" class="btn-delete-row">✕</button></td>
                        </tr>
                    @endfor
                </tbody>
            </table>
            <datalist id="dataAsetList">
                @foreach(($dataAsets ?? []) as $a)
                    <option value="{{ $a->nama_aset }}" data-id="{{ $a->id_aset }}" data-jenis="{{ $a->jenis_aset }}">
                @endforeach
            </datalist>
            </div>
            <p style="text-align:center; font-style:italic; color:#666; margin:4px 0 0;">*** EOF ***</p>

            <p style="margin: 20px 0 0;">Demikian permohonan ini disampaikan.</p>

            <!-- TEMPAT & TANGGAL PERSETUJUAN -->
            <div class="footer-place-row">
                <input type="text" name="tempat_persetujuan" value="{{ old('tempat_persetujuan', $form->tempat_persetujuan ?? '') }}" placeholder="Tempat" style="width: 140px;">
                ,
                <input type="date" id="tanggal_persetujuan" name="tanggal_persetujuan" value="{{ old('tanggal_persetujuan', $form->tanggal_persetujuan ?? '') }}" style="width: 140px; background-color:#f3f4f6; cursor:not-allowed;" readonly>
            </div>

            <!-- TANDA TANGAN: ATASAN PENGGUNA ASET & PENGELOLA ASET -->
            <div class="signature-columns">
                <div class="signature-box">
                    <p style="font-weight: bold; margin: 0 0 10px;">Atasan Pengguna Aset</p>
                    <div class="signature-space"></div>
                    <p style="margin: 0;">( <input type="text" name="nama_atasan" value="{{ old('nama_atasan', $form->nama_atasan ?? '') }}" placeholder="Nama &amp; Tanda Tangan" style="width: 200px; text-align: center; border: none; border-bottom: 1px dashed #000; background: transparent; font-family: inherit; font-size: 11px;"> )</p>
                </div>
                <div class="signature-box">
                    <p style="font-weight: bold; margin: 0 0 10px;">Pengelola Aset</p>
                    <div class="signature-space"></div>
                    <p style="margin: 0;">( <input type="text" name="nama_pengelola" value="{{ old('nama_pengelola', $form->nama_pengelola ?? '') }}" placeholder="Nama &amp; Tanda Tangan" style="width: 200px; text-align: center; border: none; border-bottom: 1px dashed #000; background: transparent; font-family: inherit; font-size: 11px;"> )</p>
                </div>
            </div>

            <!-- PERSETUJUAN VP IT OPERATION -->
            <div class="approval-section">
                <p style="margin: 0 0 6px;">
                    <label style="margin-right: 15px;"><input type="radio" name="keputusan" value="setuju" {{ old('keputusan', $form->keputusan ?? '') == 'setuju' ? 'checked' : '' }}> Menyetujui</label>
                    /
                    <label style="margin-left: 15px;"><input type="radio" name="keputusan" value="tidak_setuju" {{ old('keputusan', $form->keputusan ?? '') == 'tidak_setuju' ? 'checked' : '' }}> Tidak Menyetujui</label> *,
                </p>
                <p style="margin: 0;">VP IT Operation/ Pimpinan Unit Sistem Informasi Daerah</p>
                <div class="approval-space"></div>
                <p style="margin: 0;">( <input type="text" name="nama_vp" value="{{ old('nama_vp', $form->nama_vp ?? '') }}" placeholder="Nama &amp; Tanda Tangan" style="width: 260px; text-align: center; border: none; border-bottom: 1px dashed #000; background: transparent; font-family: inherit; font-size: 11px;"> )</p>
            </div>

            <div class="actions-bar" style="margin-top: 30px;">
                <a href="{{ route('form-pemusnahan.index') }}" class="btn-kembali">Batal</a>
                <button type="submit" class="btn-submit">{{ $isEdit ? 'Update Formulir' : 'Simpan Formulir' }}</button>
            </div>

        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
let rowIndex = {{ $rowCount }};

function addRow() {
    const tbody = document.getElementById('items-body');
    const rowNum = tbody.querySelectorAll('tr').length + 1;
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td style="text-align:center;">${rowNum}</td>
        <td><input type="text" name="items[${rowIndex}][nama_aset]" class="table-input nama-aset-input" list="dataAsetList"></td>
        <td><input type="text" name="items[${rowIndex}][jenis_aset]" class="table-input" placeholder="fisik / jaringan / HC / SC"></td>
        <td><input type="text" name="items[${rowIndex}][id_aset]" class="table-input"></td>
        <td><textarea name="items[${rowIndex}][alasan_pemusnahan]" rows="1" class="table-textarea"></textarea></td>
        <td style="text-align:center;"><button type="button" onclick="removeRow(this)" class="btn-delete-row">✕</button></td>
    `;
    tbody.appendChild(tr);
    rowIndex++;
}

function removeRow(button) {
    const rows = document.querySelectorAll('#items-body tr');
    if (rows.length > 1) {
        button.closest('tr').remove();
        renumberRows();
    }
}

function renumberRows() {
    document.querySelectorAll('#items-body tr').forEach((row, idx) => {
        row.querySelector('td').textContent = idx + 1;
    });
}

function syncTanggal(value) {
    const tp = document.getElementById('tanggal_permohonan');
    const tps = document.getElementById('tanggal_persetujuan');
    if (tp) tp.value = value;
    if (tps) tps.value = value;
}

// Sinkronkan tanggal_permohonan & tanggal_persetujuan dari tanggal_ref saat halaman dimuat
document.addEventListener('DOMContentLoaded', function () {
    const tr = document.getElementById('tanggal_ref');
    if (tr && tr.value) {
        syncTanggal(tr.value);
    }

    // Auto-isi NIP saat nama dipilih dari daftar saran (datalist)
    const namaInput = document.getElementById('nama_pemohon');
    const nipInput = document.getElementById('nip_pemohon');
    if (namaInput && nipInput) {
        namaInput.addEventListener('input', function () {
            const options = document.querySelectorAll('#dataPemohonNamaList option');
            for (const opt of options) {
                if (opt.value === namaInput.value) {
                    const nip = opt.getAttribute('data-nip');
                    if (nip) nipInput.value = nip;
                    break;
                }
            }
        });
    }

    // Auto-isi Jenis Aset & ID Aset saat Nama Aset dipilih dari daftar saran (Data Aset Perangkat)
    // Pakai event delegation di #items-body karena baris tabel bisa ditambah dinamis.
    document.getElementById('items-body').addEventListener('input', function (e) {
        if (!e.target.classList.contains('nama-aset-input')) return;

        const options = document.querySelectorAll('#dataAsetList option');
        for (const opt of options) {
            if (opt.value === e.target.value) {
                const row = e.target.closest('tr');
                const jenisInput = row.querySelector('input[name*="[jenis_aset]"]');
                const idInput = row.querySelector('input[name*="[id_aset]"]');
                const jenis = opt.getAttribute('data-jenis');
                const id = opt.getAttribute('data-id');
                if (jenisInput && jenis) jenisInput.value = jenis;
                if (idInput && id) idInput.value = id;
                break;
            }
        }
    });
});
</script>
@endsection
