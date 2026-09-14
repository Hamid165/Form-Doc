@extends('layouts.app')

@section('content')
<style>
    .a4-wrapper {
        display: flex;
        justify-content: center;
        padding: 20px;
    }
    .a4-container {
        width: 297mm; /* A4 landscape */
        min-height: 210mm;
        background: white;
        padding: 15mm;
        box-sizing: border-box;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10px;
        color: #000;
    }
    .a4-container table {
        border-collapse: collapse;
    }
    .a4-container td, .a4-container th {
        border: 1px solid black;
        padding: 3px 5px;
        vertical-align: middle;
    }

    /* Header */
    .header-table {
        width: 100%;
        margin-bottom: 10px;
    }
    .header-table td {
        border: 1px solid black;
        padding: 4px 8px;
    }
    .company-name {
        font-size: 12px;
        font-weight: bold;
    }
    .dept-name {
        font-size: 10px;
    }
    .form-title {
        font-size: 13px;
        font-weight: bold;
        text-align: center;
        letter-spacing: 0.5px;
    }
    .meta-label {
        font-weight: bold;
        width: 120px;
    }

    /* Info Section */
    .info-row {
        margin: 8px 0;
    }
    .info-label {
        display: inline-block;
        width: 100px;
        font-weight: bold;
    }
    .info-value {
        display: inline-block;
        border-bottom: 1px dashed #000;
        min-width: 150px;
        padding: 0 5px;
    }

    /* Main Table */
    .main-table th {
        background-color: #f0f0f0;
        font-weight: bold;
        text-align: center;
        font-size: 9px;
        padding: 4px 3px;
    }
    .main-table td {
        font-size: 9px;
        height: 1px;
    }
    .main-table td:not(:has(.form-input-sm)) {
        padding: 2px 3px;
    }
    .main-table td:has(.form-input-sm) {
        padding: 0;
    }

    /* Inputs */
    .form-input {
        width: 100%;
        box-sizing: border-box;
        border: none;
        padding: 1px 2px;
        background: transparent;
        font-family: inherit;
        font-size: 10px;
    }
    .form-input:focus {
        outline: none;
        background: #f0f7ff;
    }
    .form-input-sm {
        width: 100%;
        height: 100%;
        min-height: 22px;
        box-sizing: border-box;
        border: none;
        padding: 2px 3px;
        background: transparent;
        font-family: inherit;
        font-size: 9px;
    }
    .form-input-sm:focus {
        outline: none;
        background: #f0f7ff;
    }

    /* Checkbox */
    .cb {
        width: 12px;
        height: 12px;
        vertical-align: middle;
    }

    /* Signature */
    .sig-block {
        text-align: center;
        vertical-align: top;
        padding: 8px;
        width: 33%;
    }
    .sig-name {
        margin-top: 35px;
        font-weight: bold;
    }
    .sig-bracket {
        display: inline-block;
        min-width: 150px;
        border-bottom: 1px solid #000;
        text-align: center;
        padding: 2px 5px;
    }

    /* Tabs */
    .tab-btn {
        padding: 5px 15px;
        font-weight: 600;
        font-size: 10px;
        border: 1px solid #ccc;
        background: #f5f5f5;
        color: #666;
        cursor: pointer;
        transition: all 0.2s;
    }
    .tab-btn:first-child { border-radius: 5px 0 0 5px; }
    .tab-btn:last-child { border-radius: 0 5px 5px 0; }
    .tab-btn.active {
        background: #2563eb;
        border-color: #2563eb;
        color: white;
    }

    /* Expand detail */
    .expand-content {
        background: #f8fafc;
    }
</style>

<!-- Breadcrumb -->
<div class="mb-4">
    <a href="{{ route('form-keluar-masuk-barang-dc-drc.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Formulir Keluar/Masuk Barang
    </a>
</div>

@if ($errors->any() || session('error'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
     class="mb-6 bg-[#fef2f2] border border-[#fecaca] rounded-xl flex items-center p-3 relative shadow-sm">
    <div class="w-10 h-10 bg-[#fee2e2] rounded-lg flex items-center justify-center shrink-0 mr-4">
        <svg class="w-5 h-5 text-[#dc2626]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </div>
    <div class="flex flex-col">
        <h4 class="text-sm font-bold text-[#991b1b] mb-0.5">Gagal!</h4>
        <p class="text-[13px] font-medium text-[#dc2626]">{{ session('error') ?? $errors->first() }}</p>
    </div>
    <button @click="show = false" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#f87171] hover:text-[#dc2626] transition-colors p-1 rounded-md hover:bg-[#fee2e2]">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>
@endif

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="FormKeluarMasukBarangDcDrc" x-data="{ namaPemohonUtama: '{{ old('nama_pemohon', $form->nama_pemohon ?? '') }}' }">
    @csrf
    @method($method)

    <div class="a4-wrapper">
        <div class="a4-container">

            {{-- ============================================== --}}
            {{-- HEADER: PT KAI + FORM TITLE + METADATA --}}
            {{-- ============================================== --}}
            <table class="header-table">
                <tr>
                    <td style="width: 35%; border: 1px solid black;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI" style="height: 45px;">
                            <div>
                                <div class="company-name">PT. KERETA API INDONESIA (PERSERO)</div>
                                <div class="dept-name">Sistem Informasi</div>
                            </div>
                        </div>
                    </td>
                    <td style="width: 35%; border: 1px solid black; text-align: center; vertical-align: middle;">
                        <div class="form-title">FORMULIR KELUAR / MASUK BARANG DC/DRC</div>
                    </td>
                    <td style="width: 30%; padding: 0;">
                        <table style="width: 100%; font-size: 9px;">
                            <tr>
                                <td class="meta-label" style="border: 1px solid black;">Nomor</td>
                                <td style="border: 1px solid black;">{{ $formTemplate->no_dokumen ?? 'FR.SM/TI/014.003/10-2020' }}</td>
                            </tr>
                            <tr>
                                <td class="meta-label" style="border: 1px solid black;">Tanggal Terbit</td>
                                <td style="border: 1px solid black;">{{ $formTemplate->tanggal_dokumen ?? '12 Oktober 2020' }}</td>
                            </tr>
                            <tr>
                                <td class="meta-label" style="border: 1px solid black;">Versi</td>
                                <td style="border: 1px solid black;">{{ $formTemplate->versi_dokumen ?? '002-2020' }}</td>
                            </tr>
                            <tr>
                                <td class="meta-label" style="border: 1px solid black;">Halaman</td>
                                <td style="border: 1px solid black;">1 dari 1</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            {{-- ============================================== --}}
            {{-- NO REF / TANGGAL / BUSINESS AREA --}}
            {{-- ============================================== --}}
            <div style="margin: 10px 0;">
                <table style="border: none; width: max-content;">
                    <tr style="border: none;">
                        <td style="border: none; font-weight: bold; width: 100px; padding: 2px 5px;">No Ref</td>
                        <td style="border: none; padding: 2px 5px;">:</td>
                        <td style="border: none; padding: 2px 5px;">
                            <input type="text" name="no_ref" class="form-input" style="width: 180px; border-bottom: 1px dashed #000;"
                                value="{{ $form->no_ref ?? $noRef }}" readonly style="background: #f0f0f0;">
                        </td>
                    </tr>
                    <tr style="border: none;">
                        <td style="border: none; font-weight: bold; padding: 2px 5px;">Tanggal</td>
                        <td style="border: none; padding: 2px 5px;">:</td>
                        <td style="border: none; padding: 2px 5px;">
                            <input type="date" name="tanggal" id="inputTanggalUtama" class="form-input" style="width: 180px; border-bottom: 1px dashed #000;"
                                value="{{ old('tanggal', $form->tanggal ? date('Y-m-d', strtotime($form->tanggal)) : date('Y-m-d')) }}">
                        </td>
                    </tr>
                    <tr style="border: none;">
                        <td style="border: none; font-weight: bold; padding: 2px 5px;">Business Area</td>
                        <td style="border: none; padding: 2px 5px;">:</td>
                        <td style="border: none; padding: 2px 5px;">
                            <input type="text" name="business_area" class="form-input" style="width: 180px; border-bottom: 1px dashed #000;"
                                value="{{ old('business_area', $form->business_area ?? 'B060') }}">
                        </td>
                    </tr>
                </table>
            </div>

            {{-- ============================================== --}}
            {{-- JENIS TRANSAKSI + DATA PEMOHON (SIDE BY SIDE) --}}
            {{-- ============================================== --}}
            <div x-data="{ jenis: '{{ old('jenis', $form->jenis ?? 'masuk') }}' }" style="margin: 10px 0;">
                <input type="hidden" name="jenis" :value="jenis">
                <table style="width: 100%; border: none;">
                    <tr style="border: none;">
                        {{-- KIRI: Jenis Transaksi --}}
                        <td style="border: none; width: 50%; vertical-align: top; padding-right: 15px;">
                            <div style="margin-bottom: 8px;">
                                <div class="flex gap-4 mb-3">
                                    <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                                        <input type="radio" name="jenis_radio" value="masuk" :checked="jenis === 'masuk'" @change="jenis = 'masuk'" class="cb">
                                        <span style="font-weight: bold;">Barang Masuk (*)</span>
                                    </label>
                                    <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                                        <input type="radio" name="jenis_radio" value="keluar" :checked="jenis === 'keluar'" @change="jenis = 'keluar'" class="cb">
                                        <span style="font-weight: bold;">Barang Keluar (*)</span>
                                    </label>
                                </div>

                                {{-- Tanggal & Jam (untuk Masuk & Keluar) --}}
                                <div x-show="jenis === 'masuk' || jenis === 'keluar'" x-transition>
                                    <table style="border: none; width: 100%;">
                                        <tr style="border: none;">
                                            <td style="border: none; font-weight: bold; width: 80px; padding: 2px;">Tanggal</td>
                                            <td style="border: none; padding: 2px;">:</td>
                                            <td style="border: none; padding: 2px;">
                                                <input type="date" name="tanggal_masuk" id="inputTanggalMasuk" class="form-input"
                                                    style="border-bottom: 1px dashed #000;"
                                                    value="{{ old('tanggal_masuk', $form->tanggal_masuk ? date('Y-m-d', strtotime($form->tanggal_masuk)) : '') }}">
                                            </td>
                                        </tr>
                                        <tr style="border: none;">
                                            <td style="border: none; font-weight: bold; padding: 2px;">Jam</td>
                                            <td style="border: none; padding: 2px;">:</td>
                                            <td style="border: none; padding: 2px;">
                                                <input type="time" name="jam_masuk" class="form-input"
                                                    style="border-bottom: 1px dashed #000; width: 120px;"
                                                    value="{{ old('jam_masuk', $form->jam_masuk ? substr($form->jam_masuk, 0, 5) : '') }}">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </td>

                        {{-- KANAN: Data Pemohon --}}
                        <td style="border: none; width: 50%; vertical-align: top;">
                            <table style="border: none; width: 100%;">
                                <tr style="border: none;">
                                    <td style="border: none; font-weight: bold; width: 120px; padding: 2px;">Nama</td>
                                    <td style="border: none; padding: 2px;">:</td>
                                    <td style="border: none; padding: 2px;">
                                        <input type="text" name="nama_pemohon" class="form-input"
                                            style="border-bottom: 1px dashed #000;"
                                            x-model="namaPemohonUtama"
                                            placeholder="nama pemohon">
                                    </td>
                                </tr>
                                <tr style="border: none;">
                                    <td style="border: none; font-weight: bold; padding: 2px;">Nomor Identitas</td>
                                    <td style="border: none; padding: 2px;">:</td>
                                    <td style="border: none; padding: 2px;">
                                        <input type="text" name="nomor_identitas" class="form-input"
                                            style="border-bottom: 1px dashed #000;"
                                            value="{{ old('nomor_identitas', $form->nomor_identitas ?? '') }}"
                                            placeholder="KTP / NIPP / Kartu Vendor">
                                    </td>
                                </tr>
                                <tr style="border: none;">
                                    <td style="border: none; font-weight: bold; padding: 2px;">Alamat</td>
                                    <td style="border: none; padding: 2px;">:</td>
                                    <td style="border: none; padding: 2px;">
                                        <input type="text" name="alamat" class="form-input"
                                            style="border-bottom: 1px dashed #000;"
                                            value="{{ old('alamat', $form->alamat ?? '') }}">
                                    </td>
                                </tr>
                                <tr style="border: none;">
                                    <td style="border: none; font-weight: bold; padding: 2px;">Nomor Telepon</td>
                                    <td style="border: none; padding: 2px;">:</td>
                                    <td style="border: none; padding: 2px;">
                                        <input type="text" name="nomor_telepon" class="form-input"
                                            style="border-bottom: 1px dashed #000;"
                                            value="{{ old('nomor_telepon', $form->nomor_telepon ?? '') }}">
                                    </td>
                                </tr>
                                <tr style="border: none;">
                                    <td style="border: none; font-weight: bold; padding: 2px;">Perusahaan / Unit</td>
                                    <td style="border: none; padding: 2px;">:</td>
                                    <td style="border: none; padding: 2px;">
                                        <input type="text" name="perusahaan_unit" class="form-input"
                                            style="border-bottom: 1px dashed #000;"
                                            value="{{ old('perusahaan_unit', $form->perusahaan_unit ?? '') }}">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>

            {{-- ============================================== --}}
            {{-- TABEL ASET --}}
            {{-- ============================================== --}}
            <div x-data="keluarMasukBarangApp">
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 5px;">
                    <div style="display: flex; gap: 5px;">
                        <button type="button" onclick="document.getElementById('importBarangItemsModal').classList.remove('hidden')"
                            style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; background-color: #10b981; color: white; border-radius: 4px; font-size: 12px; font-weight: 600; border: none; cursor: pointer;">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            Import Excel
                        </button>
                        <button type="button" @click="addItem()"
                            class="inline-flex items-center gap-1 px-3 py-1 bg-blue-600 text-white rounded text-xs font-semibold hover:bg-blue-700">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Baris
                        </button>
                    </div>
                </div>

                <table class="main-table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="width: 25px;" rowspan="2">NO</th>
                            <th style="width: 12%;" rowspan="2">NAMA / JENIS ASET</th>
                            <th style="width: 10%;" rowspan="2">PART NO. / ID NUMBER / SERIAL NUMBER</th>
                            <th style="width: 35px;" rowspan="2">Jumlah</th>
                            <th style="width: 50px;" rowspan="2">Satuan</th>
                            <th style="width: 10%;" rowspan="2">MERK / TYPE</th>
                            <th style="width: 10%;" rowspan="2">KATEGORI ASET</th>
                            <th style="width: 10%;" rowspan="2">LOKASI PENYIMPANAN</th>
                            <th colspan="5" style="text-align: center;">DESKRIPSI ASET</th>
                            <th colspan="2" style="text-align: center;">KONDISI ASET (*)</th>
                            <th colspan="2" style="text-align: center;">KONDISI ASET (*)</th>
                            <th style="width: 8%;" rowspan="2">KETERANGAN</th>
                            <th style="width: 5%; text-align: center;" rowspan="2">AKSI</th>
                        </tr>
                        <tr>
                            <th style="font-size: 8px;">OWNER</th>
                            <th style="font-size: 8px;">POWER (A)</th>
                            <th style="font-size: 8px;">BERAT (KG)</th>
                            <th style="font-size: 8px;">UKURAN (U)</th>
                            <th style="font-size: 8px; min-width: 55px;">JENIS HW/SW</th>
                            <th style="font-size: 8px;">BARU</th>
                            <th style="font-size: 8px;">BEKAS</th>
                            <th style="font-size: 8px;">BAIK</th>
                            <th style="font-size: 8px;">RUSAK</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-if="items.length === 0">
                            <tr>
                                <td colspan="19" style="text-align: center; padding: 15px; color: #999;">
                                    Belum ada aset. Klik "Tambah Baris" untuk menambah.
                                </td>
                            </tr>
                        </template>
                        <template x-for="(item, index) in items" :key="index">
                            <tr>
                                <td style="text-align: center; width: 30px;" x-text="index + 1"></td>
                                <td>
                                    <input type="text" :name="'items['+index+'][nama_jenis_aset]'" x-model="item.nama_jenis_aset" class="form-input-sm" placeholder="Nama aset">
                                </td>
                                <td>
                                    <textarea :name="'items['+index+'][part_no]'" x-model="item.part_no" class="form-input-sm" rows="2" style="resize: vertical; min-height: 22px;"
                                        :placeholder="'Masukkan ' + (item.jumlah || 1) + ' SN, pisahkan koma/baris baru'"></textarea>
                                    <div class="text-[8px] text-gray-500 mt-0.5" x-show="item.jumlah > 1">
                                        <span x-text="'Butuh ' + (item.jumlah || 1) + ' SN'"></span>
                                    </div>
                                </td>
                                <td>
                                    <input type="number" :name="'items['+index+'][jumlah]'" x-model="item.jumlah" class="form-input-sm" min="1">
                                </td>
                                <td>
                                    <input type="text" :name="'items['+index+'][satuan]'" x-model="item.satuan" class="form-input-sm">
                                </td>
                                <td>
                                    <input type="text" :name="'items['+index+'][merk_type]'" x-model="item.merk_type" class="form-input-sm">
                                </td>
                                <td>
                                     <select :name="'items['+index+'][kategori_aset]'" x-model="item.kategori_aset" class="form-input-sm">
                                         <option value="">Pilih</option>
                                         @foreach($kategoriOptions as $opt)
                                             <option value="{{ $opt }}">{{ $opt }}</option>
                                         @endforeach
                                     </select>
                                </td>
                                <td>
                                    <input type="text" :name="'items['+index+'][lokasi_penyimpanan]'" x-model="item.lokasi_penyimpanan" class="form-input-sm">
                                </td>
                                {{-- DESKRIPSI ASET --}}
                                <td>
                                    <input type="text" :name="'items['+index+'][owner]'" x-model="item.owner" class="form-input-sm">
                                </td>
                                <td>
                                    <input type="text" :name="'items['+index+'][power_a]'" x-model="item.power_a" class="form-input-sm">
                                </td>
                                <td>
                                    <input type="text" :name="'items['+index+'][berat_kg]'" x-model="item.berat_kg" class="form-input-sm" placeholder="Misal: 1.5">
                                </td>
                                <td>
                                    <input type="text" :name="'items['+index+'][ukuran_u]'" x-model="item.ukuran_u" class="form-input-sm">
                                </td>
                                <td>
                                    <select :name="'items['+index+'][jenis_hw_sw]'" x-model="item.jenis_hw_sw" class="form-input-sm" style="min-width: 60px; padding-right: 12px;">
                                        <option value="">Pilih</option>
                                        <option value="Hardware">Hardware</option>
                                        <option value="Software">Software</option>
                                    </select>
                                </td>
                                {{-- KONDISI: BARU/BEKAS --}}
                                <td style="text-align: center;">
                                    <input type="radio" :name="'items['+index+'][kondisi_baru_bekas]'" value="baru" x-model="item.kondisi_baru_bekas" class="cb">
                                </td>
                                <td style="text-align: center;">
                                    <input type="radio" :name="'items['+index+'][kondisi_baru_bekas]'" value="bekas" x-model="item.kondisi_baru_bekas" class="cb">
                                </td>
                                {{-- KONDISI: BAIK/RUSAK --}}
                                <td style="text-align: center;">
                                    <input type="radio" :name="'items['+index+'][kondisi_baik_rusak]'" value="baik" x-model="item.kondisi_baik_rusak" class="cb">
                                </td>
                                <td style="text-align: center;">
                                    <input type="radio" :name="'items['+index+'][kondisi_baik_rusak]'" value="rusak" x-model="item.kondisi_baik_rusak" class="cb">
                                </td>
                                <td>
                                    <input type="text" :name="'items['+index+'][keterangan]'" x-model="item.keterangan" class="form-input-sm" placeholder="Keterangan">
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; justify-content: center; gap: 5px;">
                                        <button type="button" @click="removeItem(index)" class="text-red-500 hover:text-red-700 bg-red-50 p-1 rounded-md" title="Hapus" style="flex-shrink: 0;">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>

            </div>

            {{-- ============================================== --}}
            {{-- FOOTER: CATATAN + TANDA TANGAN --}}
            {{-- ============================================== --}}
            <table style="width: 100%; margin-top: 10px; border: none;">
                <tr style="border: none;">
                    <td style="border: none; vertical-align: top; width: 50%; font-size: 9px; padding: 5px;">
                        <div style="margin-bottom: 5px;">
                            <strong>(*) :</strong> beri tanda &#8730; pada salah satu kolom
                        </div>
                        <div>- Dibuat rangkap 2 (dua), untuk Pemohon dan pihak KAI</div>
                        <div>- Mohon diisi dengan lengkap</div>
                        <div>- Kategori Aset diisi dengan:</div>
                        <div style="margin-left: 10px;">Air Conditioning / Data Center / Electrical Devices / Fire Suppression / Mass Storage / Network Device / Server Hardware / System Monitoring / UPS</div>
                    </td>
                    <td style="border: none; vertical-align: top; width: 50%; padding: 5px;" x-data="{
                        selectedPelaksana: { jabatan: '{{ old('jabatan_pelaksana', $form->jabatan_pelaksana ?? '') }}', nama: '{{ old('nama_pelaksana', $form->nama_pelaksana ?? '') }}', nipp: '{{ old('nipp_pelaksana', $form->nipp_pelaksana ?? '') }}' },
                        selectedMengetahui: { jabatan: '{{ old('jabatan_mengetahui', $form->jabatan_mengetahui ?? '') }}', nama: '{{ old('nama_mengetahui', $form->nama_mengetahui ?? '') }}', nipp: '{{ old('nipp_mengetahui', $form->nipp_mengetahui ?? '') }}' },
                        masterSigners: {{ $masterSigners->toJson() }},
                        onPelaksanaNama() {
                            const s = this.masterSigners.find(s => s.nama === this.selectedPelaksana.nama);
                            if(s) {
                                this.selectedPelaksana.nipp = s.nipp;
                                this.selectedPelaksana.jabatan = s.jabatan;
                            } else {
                                this.selectedPelaksana.nipp = '';
                                this.selectedPelaksana.jabatan = '';
                            }
                        },
                        onMengetahuiNama() {
                            const s = this.masterSigners.find(s => s.nama === this.selectedMengetahui.nama);
                            if(s) {
                                this.selectedMengetahui.nipp = s.nipp;
                                this.selectedMengetahui.jabatan = s.jabatan;
                            } else {
                                this.selectedMengetahui.nipp = '';
                                this.selectedMengetahui.jabatan = '';
                            }
                        }
                    }">
                        {{-- Dateline --}}
                        <div style="text-align: right; margin-bottom: 10px; font-style: italic;">
                            <input type="text" name="kota_ttd" class="form-input" style="width: 80px; display: inline; border-bottom: 1px dashed #000;"
                                value="{{ old('kota_ttd', $form->kota_ttd ?? 'Yogyakarta') }}">,
                            <span id="textTanggalSignature">{{ $form->tanggal ? date('d-m-Y', strtotime($form->tanggal)) : date('d-m-Y') }}</span>
                        </div>

                        {{-- 3 Kolom Tanda Tangan --}}
                        <table style="width: 100%; border: none;">
                        <tr style="border: none;">
                            {{-- PEMOHON --}}
                            <td class="sig-block" style="border: none; vertical-align: top; width: 33.33%;">
                                <div style="font-weight: bold; margin-bottom: 50px;">Pemohon,</div>
                                <div class="sig-name" style="margin-top: 0;">
                                    <input type="text" class="form-input" style="text-align: center; font-size: 10px; font-weight: bold; border-bottom: 1px solid #000; padding-bottom: 2px;"
                                        x-model="namaPemohonUtama" readonly placeholder="Nama Pemohon">
                                </div>
                            </td>
                            {{-- PELAKSANA --}}
                            <td class="sig-block" style="border: none; vertical-align: top; width: 33.33%;">
                                <div style="font-weight: bold; margin-bottom: 50px;">Pelaksanaan Pekerjaan,</div>
                                <div class="sig-name" style="margin-top: 0;">
                                    <select name="nama_pelaksana" x-model="selectedPelaksana.nama" @change="onPelaksanaNama()"
                                        class="form-input" style="text-align: center; font-size: 10px; font-weight: bold; border-bottom: 1px solid #000; padding-bottom: 2px;">
                                        <option value="">Pilih Nama</option>
                                        @foreach($masterSigners as $s)
                                            <option value="{{ $s->nama }}">{{ $s->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="font-size: 9px; margin-top: 2px; color: #555;">
                                    <span x-show="selectedPelaksana.nipp" x-transition>NIPP: <span x-text="selectedPelaksana.nipp"></span></span>
                                    <br>
                                    <span x-text="selectedPelaksana.jabatan"></span>
                                </div>
                                <input type="hidden" name="jabatan_pelaksana" x-model="selectedPelaksana.jabatan">
                                <input type="hidden" name="nipp_pelaksana" x-model="selectedPelaksana.nipp">
                            </td>
                            {{-- MENGETAHUI --}}
                            <td class="sig-block" style="border: none; vertical-align: top; width: 33.33%;">
                                <div style="font-weight: bold; margin-bottom: 50px;">Mengetahui,</div>
                                <div class="sig-name" style="margin-top: 0;">
                                    <select name="nama_mengetahui" x-model="selectedMengetahui.nama" @change="onMengetahuiNama()"
                                        class="form-input" style="text-align: center; font-size: 10px; font-weight: bold; border-bottom: 1px solid #000; padding-bottom: 2px;">
                                        <option value="">Pilih Nama</option>
                                        @foreach($masterSigners as $s)
                                            <option value="{{ $s->nama }}">{{ $s->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="font-size: 9px; margin-top: 2px; color: #555;">
                                    <span x-show="selectedMengetahui.nipp" x-transition>NIPP: <span x-text="selectedMengetahui.nipp"></span></span>
                                    <br>
                                    <span x-text="selectedMengetahui.jabatan"></span>
                                </div>
                                <input type="hidden" name="jabatan_mengetahui" x-model="selectedMengetahui.jabatan">
                                <input type="hidden" name="nipp_mengetahui" x-model="selectedMengetahui.nipp">
                            </td>
                        </tr>
                        </table>
                    </td>
                </tr>
            </table>

        </div>
    </div>

    {{-- ============================================== --}}
    {{-- TOMBOL AKSI --}}
    {{-- ============================================== --}}
    <div class="flex justify-between items-center mt-6 px-4">
        <a href="{{ route('form-keluar-masuk-barang-dc-drc.index') }}"
            class="inline-flex items-center gap-2 px-6 py-2.5 bg-red-600 text-white rounded-xl text-sm font-semibold hover:bg-red-700 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            Batal
        </a>
        <button type="submit"
            class="inline-flex items-center gap-2 px-6 py-2.5 bg-green-600 text-white rounded-xl text-sm font-semibold hover:bg-green-700 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            Simpan
        </button>
    </div>
</form>

@endsection

@section('scripts')
<script>
    // Alpine.js app for Keluar Masuk Barang form
    document.addEventListener('alpine:init', () => {
        Alpine.data('keluarMasukBarangApp', () => ({
            items: [],
            kategoriOptions: {!! json_encode($kategoriOptions) !!},
            uploadingExcel: false,
            parseExcelUrl: '{{ route("form-keluar-masuk-barang-dc-drc.parse-excel") }}',
            newItem() {
                return {
                    nama_jenis_aset: '', part_no: '', jumlah: 1, satuan: 'Unit',
                    merk_type: '', kategori_aset: '', lokasi_penyimpanan: '',
                    owner: '', power_a: '', berat_kg: '', ukuran_u: '',
                    jenis_hw_sw: '', kondisi_baru_bekas: '', kondisi_baik_rusak: '',
                    keterangan: '', expanded: false
                };
            },
            addItem() { this.items.push(this.newItem()); },
            removeItem(i) { this.items.splice(i, 1); },
            toggleExpand(i) { this.items[i].expanded = !this.items[i].expanded; },
            async handleExcelUpload(event) {
                const file = event.target.files[0];
                if (!file) return;
                
                this.uploadingExcel = true;
                const formData = new FormData();
                formData.append('file', file);
                
                try {
                    const response = await fetch(this.parseExcelUrl, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (result.success && result.data) {
                        this.items = result.data.map(item => ({
                            ...this.newItem(),
                            ...item
                        }));
                        alert('Berhasil mengimpor ' + this.items.length + ' baris data dari Excel.');
                    } else {
                        alert(result.message || 'Gagal membaca file Excel.');
                    }
                } catch (e) {
                    alert('Terjadi kesalahan saat mengupload file.');
                    console.error(e);
                } finally {
                    this.uploadingExcel = false;
                    event.target.value = '';
                }
            },
            init() {
                // Load existing items if editing
                @if(isset($existingItems) && $existingItems !== '[]')
                this.items = {!! $existingItems !!};
                @elseif(old('items'))
                this.items = {!! json_encode(old('items')) !!};
                @endif
            }
        }));
    });

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof flatpickr !== 'undefined') {
            flatpickr('.tanggal-input', {
                dateFormat: 'd-m-Y',
                locale: 'id',
                allowInput: true,
            });
        }
        
        // Sync tanggal bawah dan tanggal TTD saat tanggal atas berubah
        const inputTanggalUtama = document.getElementById('inputTanggalUtama');
        const inputTanggalMasuk = document.getElementById('inputTanggalMasuk');
        const textTanggalSignature = document.getElementById('textTanggalSignature');

        if (inputTanggalUtama) {
            inputTanggalUtama.addEventListener('change', function() {
                // Set tanggal bawah sama dengan tanggal atas
                if (inputTanggalMasuk) {
                    inputTanggalMasuk.value = this.value;
                }
                
                // Set tanggal TTD (Format d-m-Y)
                if (textTanggalSignature && this.value) {
                    const parts = this.value.split('-');
                    if (parts.length === 3) {
                        textTanggalSignature.textContent = parts[2] + '-' + parts[1] + '-' + parts[0];
                    }
                }
            });
        }
    });
</script>

<!-- Import Modal for Form Items -->
<div id="importBarangItemsModal" class="fixed inset-0 z-[100] hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 m-4" style="font-family: 'Inter', sans-serif;">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900 m-0">Import Isi Tabel Barang</h3>
            <button type="button" onclick="document.getElementById('importBarangItemsModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition-colors bg-transparent border-none cursor-pointer">
                <svg class="w-6 h-6" style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <div class="mb-5">
            <p class="text-sm text-gray-600 mb-3 mt-0">Silakan upload file Excel berformat .xlsx yang berisi data aset/barang.</p>
            <a href="{{ route('form-keluar-masuk-barang-dc-drc.download-template') }}" class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800 hover:underline mb-4" style="text-decoration: none;">
                <svg class="w-4 h-4" style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Download Template Excel (XLSX)
            </a>
            
            <label class="block text-[12px] font-bold uppercase tracking-wider text-slate-500 mb-2">File Excel <span class="text-red-500 ml-1">*</span></label>
            <div class="relative flex items-center border-2 border-slate-200 rounded-lg bg-slate-50 hover:bg-slate-100 transition-colors cursor-pointer w-full h-[42px] px-3 focus-within:border-blue-500 focus-within:ring-4 focus-within:ring-blue-500/10">
                <input type="file" id="file_import_barang_items_modal" accept=".xlsx, .xls" class="w-full text-sm text-slate-700 file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer outline-none">
            </div>
        </div>
        
        <div class="flex justify-end gap-3 mt-6">
            <button type="button" onclick="document.getElementById('importBarangItemsModal').classList.add('hidden')" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 h-[42px] rounded-lg text-sm font-semibold transition-all border-none cursor-pointer">Batal</button>
            <button type="button" onclick="processImportBarangItems(this)" class="bg-blue-600 hover:bg-blue-700 text-white px-5 h-[42px] rounded-lg text-sm font-semibold transition-all shadow-sm border-none cursor-pointer">Import Data</button>
        </div>
    </div>
</div>

<script>
function processImportBarangItems(btn) {
    var input = document.getElementById('file_import_barang_items_modal');
    if (!input.files || input.files.length === 0) {
        alert('Pilih file Excel terlebih dahulu');
        return;
    }

    var file = input.files[0];
    var formData = new FormData();
    formData.append('file', file);
    formData.append('_token', '{{ csrf_token() }}');

    // Tampilkan loading state
    var originalBtnHtml = btn.innerHTML;
    btn.innerHTML = 'Memproses...';
    btn.disabled = true;

    fetch('{{ route("form-keluar-masuk-barang-dc-drc.parse-excel") }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        btn.innerHTML = originalBtnHtml;
        btn.disabled = false;

        if (result.success && result.data && result.data.length > 0) {
            // Tutup modal
            document.getElementById('importBarangItemsModal').classList.add('hidden');
            
            // Trigger Alpine.js to add items
            var appData = document.querySelector('[x-data="keluarMasukBarangApp"]');
            if (appData && appData._x_dataStack && appData._x_dataStack.length > 0) {
                var data = appData._x_dataStack[0];
                // Clear existing items dan tambah dari import
                data.items = [];
                result.data.forEach(function(row) {
                    data.items.push({
                        no_urut: row.no_urut || 0,
                        nama_jenis_aset: row.nama_jenis_aset || '',
                        part_no: row.part_no || '',
                        jumlah: row.jumlah || 1,
                        satuan: row.satuan || 'unit',
                        merk_type: row.merk_type || '',
                        kategori_aset: row.kategori_aset || '',
                        lokasi_penyimpanan: row.lokasi_penyimpanan || '',
                        deskripsi_aset: row.deskripsi_aset || '',
                        owner: row.owner || '',
                        power_a: row.power_a || '',
                        berat_kg: row.berat_kg || '',
                        ukuran_u: row.ukuran_u || '',
                        jenis_hw_sw: row.jenis_hw_sw || '',
                        kondisi_baru_bekas: row.kondisi_baru_bekas || 'baru',
                        kondisi_baik_rusak: row.kondisi_baik_rusak || 'baik',
                        keterangan: row.keterangan || ''
                    });
                });
            }
            
            alert('Berhasil import ' + result.data.length + ' baris data');
        } else {
            alert('Tidak ada data yang dapat diimport. Pastikan format file benar.');
        }
    })
    .catch(error => {
        btn.innerHTML = originalBtnHtml;
        btn.disabled = false;
        alert('Terjadi kesalahan saat mengupload file: ' + error.message);
    });
}
</script>
@endsection
