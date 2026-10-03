@php
    $form = $form_pemeliharaan ?? null;
    $actionUrl = $isEdit
        ? route('form-pemeliharaan.update', $form)
        : route('form-pemeliharaan.store');
    $method = $isEdit ? 'PUT' : 'POST';
@endphp

@extends('layouts.app')

@section('content')
<style>
    /* ==========================================
       BASE — tiruan cetakan dokumen A4 landscape
       ========================================== */
    .a4-wrapper {
        display: flex;
        justify-content: center;
        padding: 20px;
        flex-direction: column;
        align-items: center;
    }
    .a4-nav {
        width: 297mm;
        margin-bottom: 16px;
    }
    .a4-container {
        width: 297mm;
        background: white;
        padding: 15mm 18mm;
        box-sizing: border-box;
        box-shadow: 0 4px 15px rgba(0,0,0,0.12);
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11px;
        color: #000;
    }
    .a4-container table { border-collapse: collapse; }

    /* ==========================================
       KOP SURAT
       ========================================== */
    .header-table { width: 100%; }
    .header-table td {
        border: 1px solid black;
        padding: 4px 7px;
        vertical-align: middle;
    }
    .title-text { font-size: 11px; font-weight: bold; text-align: center; }
    .terbatas-box {
        border: 2px solid #eab308;
        color: #eab308;
        padding: 4px 14px;
        font-weight: bold;
        font-size: 13px;
        display: inline-block;
    }

    /* ==========================================
       INFO SECTION
       ========================================== */
    .info-section { margin: 12px 0; }
    .small-info-table { margin-bottom: 0; }
    .small-info-table td {
        border: 1px solid black;
        padding: 2px 5px;
        height: auto;
        white-space: nowrap;
    }
    .kolom-label { width: 110px; font-weight: normal; }

    /* ==========================================
       INPUT GAYA GARIS BAWAH PUTUS-PUTUS
       ========================================== */
    .form-input-inline {
        border: none;
        border-bottom: 1px dashed #000;
        background: transparent;
        font-family: inherit;
        font-size: 11px;
        width: 130px;
        padding: 2px 4px;
        color: #000;
    }
    .form-input-inline:focus {
        outline: none;
        border-bottom: 1px solid #00a4e4;
    }
    .form-input-inline[readonly] {
        background: #f9f9f9;
        pointer-events: none;
    }

    /* ==========================================
       TABEL UTAMA
       ========================================== */
    .main-table { width: 100%; margin-top: 10px; }
    .main-table th, .main-table td {
        border: 1px solid black;
        padding: 3px 4px;
        vertical-align: middle;
        font-size: 10px;
    }
    .main-table th {
        font-weight: bold;
        text-align: center;
        background-color: #dce6f1;
    }
    .sub-header { font-weight: normal; font-size: 8px; display: block; margin-top: 2px; }

    /* Input di dalam sel tabel */
    .form-input {
        width: 100%;
        box-sizing: border-box;
        border: none;
        padding: 1px 2px;
        background-color: transparent;
        font-family: inherit;
        font-size: 10px;
        color: #000;
    }
    .form-input:focus { outline: none; }

    /* ==========================================
       CATATAN
       ========================================== */
    .catatan-box {
        border: 1px solid black;
        padding: 5px;
        margin-top: 8px;
        min-height: 32px;
    }
    .catatan-input {
        width: 100%;
        border: none;
        background: transparent;
        font-family: inherit;
        font-size: 11px;
        resize: none;
        min-height: 28px;
    }
    .catatan-input:focus { outline: none; }

    /* ==========================================
       TOMBOL EDIT BUSINESS AREA
       ========================================== */
    .btn-edit-ba {
        background-color: #fffbeb;
        color: #d97706;
        border: none;
        cursor: pointer;
        padding: 4px 6px;
        display: inline-flex;
        align-items: center;
        border-radius: 4px;
        transition: all 0.2s;
    }
    .btn-edit-ba:hover { background-color: #fef3c7; color: #b45309; }

    /* ==========================================
       TOMBOL HAPUS ITEM
       ========================================== */
    .btn-delete-row {
        background-color: #fef2f2;
        border: none;
        color: #dc2626;
        cursor: pointer;
        padding: 4px 5px;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .btn-delete-row:hover { background-color: #fee2e2; color: #b91c1c; }

    /* ==========================================
       TOMBOL AKSI BAWAH
       ========================================== */
    .btn-submit {
        background-color: #16a34a;
        color: white;
        padding: 5px 16px;
        height: 32px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        font-size: 11px;
        transition: background 0.2s;
    }
    .btn-submit:hover { background-color: #15803d; }
    .btn-batal {
        display: inline-flex; align-items: center; justify-content: center;
        height: 32px; padding: 5px 16px; background-color: #ef4444;
        color: white; text-decoration: none; border-radius: 5px;
        font-weight: bold; font-size: 11px; box-sizing: border-box;
        transition: background-color 0.2s;
    }
    .btn-batal:hover { background-color: #dc2626; }
    .btn-tambah {
        background-color: #f59e0b; color: white;
        border: none; border-radius: 5px; cursor: pointer;
        font-weight: bold; font-size: 11px; height: 30px; padding: 5px 14px;
        transition: background-color 0.2s;
    }
    .btn-tambah:hover { background-color: #d97706; }

    /* ==========================================
       TANDA TANGAN
       ========================================== */
    .signature-table { width: 100%; border: none; margin-top: 20px; }
    .signature-table td { border: none; vertical-align: top; }

    /* ==========================================
       ERROR BOX
       ========================================== */
    .error-box {
        background: #fef2f2; border: 1px solid #fecaca;
        border-radius: 8px; padding: 12px 16px; margin-bottom: 16px;
    }
    .error-box h4 { color: #991b1b; font-size: 12px; margin: 0 0 6px; }
    .error-box ul { margin: 0; padding-left: 16px; color: #dc2626; font-size: 11px; }
</style>

<div class="a4-wrapper">
    {{-- Breadcrumb --}}
    <div class="a4-nav">
        <a href="{{ route('form-pemeliharaan.index') }}" style="display:inline-flex; align-items:center; gap:5px; font-size:13px; color:#64748b; text-decoration:none; font-family:Arial,sans-serif; transition: color .2s;" onmouseover="this.style.color='#2563eb'" onmouseout="this.style.color='#64748b'">
            <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Formulir Pemeliharaan
        </a>
    </div>

    <div class="a4-container">

        {{-- Error Box --}}
        @if ($errors->any())
        <div class="error-box">
            <h4>Terdapat kesalahan pada form:</h4>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form id="pemeliharaan-form" method="POST" action="{{ $actionUrl }}">
            @csrf
            @method($method)

            {{-- ===== KOP SURAT ===== --}}
            <table class="header-table">
                <tr>
                    <td rowspan="2" style="width:15%; text-align:center;">
                        <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI" style="max-width:100%; max-height:48px;">
                    </td>
                    <td rowspan="2" class="title-text" style="width:40%;">
                        PT KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI
                    </td>
                    <td style="width:13%;">Nomor</td>
                    <td style="width:22%;">: FR.SM/TI/015.005/10-2020</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: 12 Oktober 2020</td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center;">
                        <div class="terbatas-box">TERBATAS</div>
                    </td>
                    <td rowspan="2" class="title-text">FORMULIR CHECKLIST PEMELIHARAAN PERANGKAT JARINGAN</td>
                    <td>Versi</td>
                    <td>: 002-2020</td>
                </tr>
                <tr>
                    <td>Halaman</td>
                    <td>: 1 dari 1</td>
                </tr>
            </table>            {{-- ===== INFO SECTION ===== --}}
            <div class="info-section">
                {{-- Box Table: No Ref, Tanggal, Business Area --}}
                <table style="width: 280px; margin-bottom: 15px; border-collapse: collapse;">
                    <tr>
                        <td style="border: 1px solid black; width: 100px; padding: 2px 6px; font-size: 11px; font-weight: bold;">No. Ref</td>
                        <td style="border: 1px solid black; padding: 2px 6px;">:&nbsp;
                            <input type="text" name="no_ref"
                                   value="{{ old('no_ref', $form->no_ref ?? '') }}"
                                   class="form-input-inline"
                                   style="width: 140px; border-bottom: none;"
                                   placeholder="................................" required>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 2px 6px; font-size: 11px; font-weight: bold;">Tanggal</td>
                        <td style="border: 1px solid black; padding: 2px 6px;">:&nbsp;
                            <input type="text" name="tanggal"
                                   value="{{ old('tanggal', $form && $form->tanggal ? $form->tanggal->format('d/m/Y') : '') }}"
                                   class="form-input-inline custom-date-picker"
                                   data-format="id"
                                   autocomplete="off"
                                   style="width: 140px; border-bottom: none; cursor: pointer;"
                                   placeholder="Tanggal" required>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 2px 6px; font-size: 11px; font-weight: bold;">Business Area</td>
                        <td style="border: 1px solid black; padding: 2px 6px;">:&nbsp;
                            <span style="display:inline-flex; align-items:center; gap:4px;">
                                <input type="text" id="business_area_input" name="business_area"
                                       value="{{ old('business_area', $form->business_area ?? 'B060') }}"
                                       class="form-input-inline"
                                       style="width: 110px; pointer-events:none; background:#f9f9f9; border-bottom: none;"
                                       readonly required>
                                <button type="button" onclick="unlockBusinessArea()" title="Edit Business Area" class="btn-edit-ba" style="padding: 2px;">
                                    <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                            </span>
                        </td>
                    </tr>
                </table>

                {{-- Text info: Petugas, Lokasi, Jenis Pemeliharaan, Bulan --}}
                <table style="width: 100%; border: none; font-size: 11px; margin-bottom: 12px; font-weight: bold;">
                    <tr>
                        <td style="border:none; width:90px; padding:2px 0;">Petugas</td>
                        <td style="border:none; width:280px; padding:2px 0; font-weight: normal;">:&nbsp;
                            <select name="petugas_id" id="petugas_id_top" class="form-input-inline" style="width:200px; cursor:pointer; appearance:auto; color: #dc2626;" onchange="syncPetugas()" required>
                                <option value="">-- Pilih Petugas --</option>
                                @foreach ($masterPetugas as $pet)
                                    <option value="{{ $pet->id }}" data-nama="{{ $pet->nama }}" data-nipp="{{ $pet->nipp }}" {{ old('petugas_id', $form->petugas_id ?? '') == $pet->id ? 'selected' : '' }}>
                                        {{ $pet->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td style="border:none; width:130px; padding:2px 0;">Jenis Pemeliharaan</td>
                        <td style="border:none; padding:2px 0; font-weight: normal;">:&nbsp;
                            <select name="jenis_pemeliharaan" class="form-input-inline" style="width:180px; cursor:pointer; appearance:auto; color: #dc2626;" required>
                                <option value="">Terencana / Tak Terencana (*)</option>
                                <option value="Terencana" {{ old('jenis_pemeliharaan', $form->jenis_pemeliharaan ?? '') === 'Terencana' ? 'selected' : '' }}>Terencana</option>
                                <option value="Tak Terencana" {{ old('jenis_pemeliharaan', $form->jenis_pemeliharaan ?? '') === 'Tak Terencana' ? 'selected' : '' }}>Tak Terencana</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none; padding:2px 0;">Lokasi</td>
                        <td style="border:none; padding:2px 0; font-weight: normal;">:&nbsp;
                            <input type="text" name="lokasi" class="form-input-inline" style="width:200px; color: #dc2626;" placeholder="(tempat keberadaan aset)" value="{{ old('lokasi', $form->lokasi ?? '') }}" required>
                        </td>
                        <td style="border:none; padding:2px 0;">Bulan</td>
                        <td style="border:none; padding:2px 0; font-weight: normal;">:&nbsp;
                            <input type="text" name="bulan_pemeliharaan" class="form-input-inline" style="width:180px; color: #dc2626;" placeholder="(bulan waktu pemeliharaan)" value="{{ old('bulan_pemeliharaan', $form->bulan_pemeliharaan ?? '') }}" required>
                        </td>
                    </tr>
                </table>
            </div>

            {{-- ===== TABEL UTAMA ===== --}}
            <div style="overflow-x:auto;">
                <table class="main-table" style="min-width:700px;">
                    <thead>
                        <tr style="background-color: #93c5fd;">
                            <th style="width:3%; background-color: #93c5fd; color: black;">NO</th>
                            <th style="width:13%; background-color: #93c5fd; color: black;">KODE / ID<br>PERANGKAT<span class="sub-header" style="color: #dc2626; font-size: 9px; margin-top: 4px;">(nomor ID aset<br>perangkat jaringan)</span></th>
                            <th style="width:13%; background-color: #93c5fd; color: black;">JENIS<br>PERANGKAT<span class="sub-header" style="color: #dc2626; font-size: 9px; margin-top: 4px;">(jenis / nama<br>perangkat jaringan)</span></th>
                            <th style="width:15%; background-color: #93c5fd; color: black;">DESKRIPSI PERANGKAT<span class="sub-header" style="color: #dc2626; font-size: 9px; margin-top: 4px;">(deskripsi / spesifikasi dari<br>perangkat jaringan)</span></th>
                            <th style="width:15%; background-color: #93c5fd; color: black;">PEKERJAAN<span class="sub-header" style="color: #dc2626; font-size: 9px; margin-top: 4px;">(tindakan yang dilakukan<br>untuk pemeliharaan<br>perangkat jaringan)</span></th>
                            <th style="width:14%; background-color: #93c5fd; color: black;">PERMASALAHAN<span class="sub-header" style="color: #dc2626; font-size: 9px; margin-top: 4px;">(permasalahan yang dialami<br>oleh perangkat jaringan, jika<br>ada)</span></th>
                            <th style="width:14%; background-color: #93c5fd; color: black;">SOLUSI<span class="sub-header" style="color: #dc2626; font-size: 9px; margin-top: 4px;">(tindakan yang dilakukan<br>untuk memperbaiki<br>perangkat jaringan, jika ada)</span></th>
                            <th style="width:11%; background-color: #93c5fd; color: black;">KETERANGAN<span class="sub-header" style="color: #dc2626; font-size: 9px; margin-top: 4px;">(keterangan lebih<br>lanjut, jika ada)</span></th>
                            <th style="width:2%; background-color: #93c5fd;"></th>
                        </tr>
                    </thead>
                    <tbody id="items-tbody">
                        @if (old('items'))
                            @foreach (old('items') as $idx => $item)
                            <tr data-row="{{ $idx }}">
                                <td style="text-align:center;">{{ $loop->iteration }}</td>
                                <td>
                                    <input type="hidden" name="items[{{ $idx }}][id]" value="{{ $item['id'] ?? '' }}">
                                    <select name="items[{{ $idx }}][master_perangkat_id]" class="form-input perangkat-select" style="cursor:pointer; appearance:auto; width:100%;" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach ($masterPerangkats as $p)
                                            <option value="{{ $p->id }}" {{ (isset($item['master_perangkat_id']) && $item['master_perangkat_id'] == $p->id) ? 'selected' : '' }}>
                                                {{ $p->kode_aset }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-input jenis-perangkat-display" readonly
                                           value="{{ $item['_jenis_display'] ?? '' }}"
                                           style="background:transparent; pointer-events:none; text-align:center;">
                                    <input type="hidden" name="items[{{ $idx }}][_jenis_display]" value="{{ $item['_jenis_display'] ?? '' }}">
                                </td>
                                <td><input type="text" name="items[{{ $idx }}][deskripsi]" value="{{ $item['deskripsi'] ?? '' }}" class="form-input" placeholder="Deskripsi perangkat" required></td>
                                <td><input type="text" name="items[{{ $idx }}][pekerjaan]" value="{{ $item['pekerjaan'] ?? '' }}" class="form-input" placeholder="Uraian pekerjaan" required></td>
                                <td><input type="text" name="items[{{ $idx }}][permasalahan]" value="{{ $item['permasalahan'] ?? '' }}" class="form-input" placeholder="Permasalahan"></td>
                                <td><input type="text" name="items[{{ $idx }}][solusi]" value="{{ $item['solusi'] ?? '' }}" class="form-input" placeholder="Solusi"></td>
                                <td><input type="text" name="items[{{ $idx }}][keterangan]" value="{{ $item['keterangan'] ?? '' }}" class="form-input" placeholder="Keterangan"></td>
                                <td style="text-align:center;">
                                    <button type="button" onclick="removeRow(this)" class="btn-delete-row" title="Hapus Baris">
                                        <svg style="width:11px;height:11px;" fill="currentColor" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/><path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/></svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        @elseif ($isEdit && $form->items->count() > 0)
                            @foreach ($form->items as $idx => $item)
                            <tr data-row="{{ $idx }}">
                                <td style="text-align:center;">{{ $idx + 1 }}</td>
                                <td>
                                    <input type="hidden" name="items[{{ $idx }}][id]" value="{{ $item->id ?? '' }}">
                                    <select name="items[{{ $idx }}][master_perangkat_id]" class="form-input perangkat-select" style="cursor:pointer; appearance:auto; width:100%;" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach ($masterPerangkats as $p)
                                            <option value="{{ $p->id }}" {{ $item->master_perangkat_id == $p->id ? 'selected' : '' }}>
                                                {{ $p->kode_aset }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-input jenis-perangkat-display" readonly
                                           value="{{ $item->perangkat->jenis_perangkat ?? '' }}"
                                           style="background:transparent; pointer-events:none; text-align:center;">
                                    <input type="hidden" name="items[{{ $idx }}][_jenis_display]" value="{{ $item->perangkat->jenis_perangkat ?? '' }}">
                                </td>
                                <td><input type="text" name="items[{{ $idx }}][deskripsi]" value="{{ $item->deskripsi ?? '' }}" class="form-input" placeholder="Deskripsi perangkat" required></td>
                                <td><input type="text" name="items[{{ $idx }}][pekerjaan]" value="{{ $item->pekerjaan ?? '' }}" class="form-input" placeholder="Uraian pekerjaan" required></td>
                                <td><input type="text" name="items[{{ $idx }}][permasalahan]" value="{{ $item->permasalahan ?? '' }}" class="form-input" placeholder="Permasalahan"></td>
                                <td><input type="text" name="items[{{ $idx }}][solusi]" value="{{ $item->solusi ?? '' }}" class="form-input" placeholder="Solusi"></td>
                                <td><input type="text" name="items[{{ $idx }}][keterangan]" value="{{ $item->keterangan ?? '' }}" class="form-input" placeholder="Keterangan"></td>
                                <td style="text-align:center;">
                                    <button type="button" onclick="removeRow(this)" class="btn-delete-row" title="Hapus Baris">
                                        <svg style="width:11px;height:11px;" fill="currentColor" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/><path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/></svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr data-row="0">
                                <td style="text-align:center;">1</td>
                                <td>
                                    <input type="hidden" name="items[0][id]" value="">
                                    <select name="items[0][master_perangkat_id]" class="form-input perangkat-select" style="cursor:pointer; appearance:auto; width:100%;" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach ($masterPerangkats as $p)
                                            <option value="{{ $p->id }}">{{ $p->kode_aset }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-input jenis-perangkat-display" readonly style="background:transparent; pointer-events:none; text-align:center;" placeholder="">
                                    <input type="hidden" name="items[0][_jenis_display]" value="">
                                </td>
                                <td><input type="text" name="items[0][deskripsi]" class="form-input" placeholder="Deskripsi perangkat" required></td>
                                <td><input type="text" name="items[0][pekerjaan]" class="form-input" placeholder="Uraian pekerjaan" required></td>
                                <td><input type="text" name="items[0][permasalahan]" class="form-input" placeholder="Permasalahan"></td>
                                <td><input type="text" name="items[0][solusi]" class="form-input" placeholder="Solusi"></td>
                                <td><input type="text" name="items[0][keterangan]" class="form-input" placeholder="Keterangan"></td>
                                <td style="text-align:center;">
                                    <button type="button" onclick="removeRow(this)" class="btn-delete-row" title="Hapus Baris">
                                        <svg style="width:11px;height:11px;" fill="currentColor" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/><path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/></svg>
                                    </button>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- Tombol Tambah Baris --}}
            <div style="text-align:right; margin-top:8px;">
                <button type="button" onclick="addRow()" class="btn-tambah">+ Tambah Baris</button>
            </div>

            {{-- Catatan --}}
            <div class="catatan-box" style="margin-top:10px;">
                <strong>Catatan :</strong>
                <textarea name="catatan" class="catatan-input" rows="2"
                          placeholder="Catatan mengenai pelaksanaan pemeliharaan perangkat jaringan, jika ada">{{ old('catatan', $form->catatan ?? '') }}</textarea>
            </div>

            {{-- Tanda Tangan --}}
            <table class="signature-table">
                <tr>
                    <td style="width: 50%; text-align: center;">
                        <div style="width: 220px; margin: 0 auto; text-align: left;">
                            <p style="margin: 0 0 5px 0; font-weight: bold;">Petugas,</p>
                            <input type="text" id="petugas_name_bottom"
                                   value="{{ old('petugas_name', $form->petugas->nama ?? '') }}"
                                   class="form-input-inline" style="width: 100%; text-align: center; margin-bottom: 5px; margin-top: 40px; border-bottom: 1px dotted black; pointer-events: none; background: transparent;"
                                   readonly placeholder="........................................">
                            <p style="margin: 0; font-weight: bold;">NIPP. <input type="text" id="petugas_nipp_bottom"
                                                              value="{{ old('petugas_nipp', $form->petugas->nipp ?? '') }}"
                                                              class="form-input-inline" style="width: 178px; text-align: center; border-bottom: 1px dotted black; pointer-events: none; background: transparent;"
                                                              readonly placeholder="................................" required></p>
                        </div>
                    </td>
                    <td style="width: 50%; text-align: center;">
                        <div style="width: 220px; margin: 0 auto; text-align: left;">
                            <p id="tanggal_mengetahui_display" style="margin: 0 0 5px 0; text-align: center; padding-right: 30px;">Yogyakarta, {{ old('tanggal', $form && $form->tanggal ? $form->tanggal->format('d/m/Y') : '....................') }}</p>
                            <p style="margin: 0 0 5px 0; font-weight: bold; text-align: center; padding-right: 30px;">Mengetahui,</p>
                            <div style="height: 40px;"></div>
                            <select name="mengetahui_id" id="mengetahui_id" class="form-input-inline" style="width: 100%; text-align: center; cursor: pointer; appearance: auto; text-align-last: center; border-bottom: 1px dotted black;" onchange="syncSigner()" required>
                                <option value="">-- Pilih Pejabat --</option>
                                @foreach ($masterSigners as $signer)
                                    <option value="{{ $signer->id }}" data-nipp="{{ $signer->nipp }}" {{ old('mengetahui_id', $form->mengetahui_id ?? '') == $signer->id ? 'selected' : '' }}>
                                        {{ $signer->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <p style="margin: 0; font-weight: bold; margin-top: 5px;">NIPP. <input type="text" id="mengetahui_nipp_bottom" value="{{ old('mengetahui_nipp', $form->mengetahui->nipp ?? '') }}" class="form-input-inline" style="width: 178px; text-align: center; border-bottom: 1px dotted black; pointer-events: none; background: transparent;" readonly placeholder="................................" required></p>
                        </div>
                    </td>
                </tr>
            </table>

            {{-- ===== TOMBOL AKSI ===== --}}
            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px; align-items:center;">
                <a href="{{ route('form-pemeliharaan.index') }}" class="btn-batal">Batal</a>
                <button type="submit" name="action" value="save" class="btn-submit">
                    {{ $isEdit ? 'Perbarui Formulir' : 'Simpan Formulir' }}
                </button>
                @if($isEdit)
                <button type="submit" name="action" value="konfirmasi_selesai" class="btn-submit" style="background-color: #7c3aed;">
                    ✓ Simpan & Konfirmasi Selesai
                </button>
                @endif
            </div>

        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const perangkatData = @json($masterPerangkats->keyBy('id'));
    let rowIndex = {{ old('items') ? count(old('items')) : ($isEdit && $form->items->count() > 0 ? $form->items->count() : 1) }};

    function buildOptions() {
        return Object.values(perangkatData).map(p =>
            `<option value="${p.id}">${p.kode_aset}</option>`
        ).join('');
    }

    function addRow() {
        const tbody = document.getElementById('items-tbody');
        const rowNum = tbody.querySelectorAll('tr').length + 1;
        const idx = rowIndex++;
        const options = buildOptions();

        const tr = document.createElement('tr');
        tr.setAttribute('data-row', idx);
        tr.innerHTML = `
            <td style="text-align:center;">${rowNum}</td>
            <td>
                <input type="hidden" name="items[${idx}][id]" value="">
                <select name="items[${idx}][master_perangkat_id]" class="form-input perangkat-select" style="cursor:pointer; appearance:auto; width:100%;" required>
                    <option value="">-- Pilih --</option>${options}
                </select>
            </td>
            <td>
                <input type="text" class="form-input jenis-perangkat-display" readonly style="background:transparent; pointer-events:none; text-align:center;" placeholder="">
                <input type="hidden" name="items[${idx}][_jenis_display]" value="">
            </td>
            <td><input type="text" name="items[${idx}][deskripsi]" class="form-input" placeholder="Deskripsi perangkat" required></td>
            <td><input type="text" name="items[${idx}][pekerjaan]" class="form-input" placeholder="Uraian pekerjaan" required></td>
            <td><input type="text" name="items[${idx}][permasalahan]" class="form-input" placeholder="Permasalahan"></td>
            <td><input type="text" name="items[${idx}][solusi]" class="form-input" placeholder="Solusi"></td>
            <td><input type="text" name="items[${idx}][keterangan]" class="form-input" placeholder="Keterangan"></td>
            <td style="text-align:center;">
                <button type="button" onclick="removeRow(this)" class="btn-delete-row" title="Hapus Baris">
                    <svg style="width:11px;height:11px;" fill="currentColor" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/><path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/></svg>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
        bindSelect(tr.querySelector('.perangkat-select'));
        renumberRows();
    }

    function removeRow(btn) {
        const tbody = document.getElementById('items-tbody');
        if (tbody.querySelectorAll('tr').length <= 1) return;
        btn.closest('tr').remove();
        renumberRows();
    }

    function renumberRows() {
        document.querySelectorAll('#items-tbody tr').forEach((tr, i) => {
            tr.querySelector('td:first-child').textContent = i + 1;
        });
    }

    function bindSelect(select) {
        select.addEventListener('change', function () {
            const tr = this.closest('tr');
            const jenisDisplay = tr.querySelector('.jenis-perangkat-display');
            const jenisHidden = tr.querySelector('input[name$="[_jenis_display]"]');
            const perangkat = perangkatData[this.value];
            const jenisPerangkat = perangkat ? perangkat.jenis_perangkat : '';
            if (jenisDisplay) jenisDisplay.value = jenisPerangkat;
            if (jenisHidden) jenisHidden.value = jenisPerangkat;
        });
    }

    // Bind semua select yang sudah ada
    document.querySelectorAll('.perangkat-select').forEach(bindSelect);

    function unlockBusinessArea() {
        var input = document.getElementById('business_area_input');
        if (input.hasAttribute('readonly')) {
            input.removeAttribute('readonly');
            input.style.pointerEvents = 'auto';
            input.style.background = 'transparent';
            input.style.borderBottom = '1px solid #00a4e4';
            input.focus();
        } else {
            input.setAttribute('readonly', 'readonly');
            input.style.pointerEvents = 'none';
            input.style.background = '#f9f9f9';
            input.style.borderBottom = 'none';
        }
    }

    // Sinkronisasi Penanda Tangan (Mengetahui)
    function syncSigner() {
        const select = document.getElementById('mengetahui_id');
        if (!select) return;
        const selectedOption = select.options[select.selectedIndex];
        
        const nipp = selectedOption.getAttribute('data-nipp') || '';
        const bottomNipp = document.getElementById('mengetahui_nipp_bottom');
        if(bottomNipp) bottomNipp.value = nipp;
    }

    // Sinkronisasi Petugas (Top -> Bottom)
    function syncPetugas() {
        const select = document.getElementById('petugas_id_top');
        if (!select) return;
        const selectedOption = select.options[select.selectedIndex];
        
        const nama = selectedOption.getAttribute('data-nama') || '';
        const nipp = selectedOption.getAttribute('data-nipp') || '';

        const bottomName = document.getElementById('petugas_name_bottom');
        const bottomNipp = document.getElementById('petugas_nipp_bottom');
        if(bottomName) bottomName.value = nama;
        if(bottomNipp) bottomNipp.value = nipp;
    }

    // Auto-fill Bulan Pemeliharaan based on Tanggal
    document.addEventListener('DOMContentLoaded', () => {
        syncPetugas();
        syncSigner();

        const tanggalInput = document.querySelector('input[name="tanggal"]');
        const bulanInput = document.querySelector('input[name="bulan_pemeliharaan"]');

        if (tanggalInput && bulanInput) {
            function updateBulan() {
                let val = tanggalInput.value.trim();
                
                const tglDisplay = document.getElementById('tanggal_mengetahui_display');
                if (tglDisplay) {
                    tglDisplay.textContent = 'Yogyakarta, ' + (val ? val : '....................');
                }

                if (!val) return;
                
                if (val.includes('/')) {
                    // Format is dd/mm/yyyy
                    const parts = val.split('/');
                    if (parts.length === 3) {
                        const day = parseInt(parts[0], 10);
                        const month = parseInt(parts[1], 10) - 1;
                        const year = parseInt(parts[2], 10);
                        
                        const date = new Date(year, month, day);
                        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        if (!isNaN(date.getTime())) {
                            bulanInput.value = months[date.getMonth()] + ' ' + date.getFullYear();
                        }
                    }
                } else {
                    // Format is like "09 Jul 2026" or "09-Juli-2026"
                    val = val.replace(/-/g, ' ');
                    const parts = val.split(' ');
                    if (parts.length >= 3) {
                        const monthStr = parts[1].toLowerCase();
                        let monthFull = parts[1]; // fallback
                        
                        const monthMap = {
                            'jan': 'Januari', 'feb': 'Februari', 'mar': 'Maret', 'apr': 'April',
                            'mei': 'Mei', 'jun': 'Juni', 'jul': 'Juli', 'agu': 'Agustus',
                            'sep': 'September', 'okt': 'Oktober', 'nov': 'November', 'des': 'Desember'
                        };
                        
                        for (let key in monthMap) {
                            if (monthStr.startsWith(key)) {
                                monthFull = monthMap[key];
                                break;
                            }
                        }
                        
                        bulanInput.value = monthFull + ' ' + parts[2];
                    }
                }
            }
            tanggalInput.addEventListener('change', updateBulan);
            tanggalInput.addEventListener('input', updateBulan);
        }
    });
</script>
@endsection
