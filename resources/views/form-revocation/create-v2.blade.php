@extends('layouts.app')

@section('title', 'Tambah Permohonan Pencabutan Hak Akses')

@section('content')
@include('components.custom-datepicker')

<style>
    /* ── Page Background ── */
    .v2-page { background-color: #f8fafc; min-height: 100vh; padding: 1.25rem 0 120px 0; }

    /* ── Main Container ── */
    .v2-main-container {
        background: #ffffff;
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        border: 1px solid #e2e8f0;
    }

    /* ── Section Cards ── */
    .v2-card {
        background: #fff;
        border-radius: 16px;
        margin-bottom: 24px;
        overflow: visible;
        border: 1px solid #e2e8f0;
    }
    .v2-card:last-child { margin-bottom: 0; }
    /* ── Section Headers ── */
    .v2-card-header { border-radius: 20px 20px 0 0; overflow: hidden; }
    .v2-card-header {
        padding: 18px 28px;
        display: flex;
        align-items: center;
        gap: 14px;
        border-bottom: 1px solid #e2e8f0;
        background-color: #ffffff;
    }
    .v2-card-header .badge {
        width: 32px; height: 32px;
        background-color: #e2e8f0;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 14px; color: #475569;
        flex-shrink: 0;
    }
    .v2-card-header h2 { font-size: 16px; font-weight: 700; color: #0f172a; margin: 0; }
    .v2-card-header p  { font-size: 13px; color: #64748b; margin: 0; margin-top: 2px; }

    /* ── Card Body ── */
    .v2-card-body { padding: 28px; }

    /* ── Field Group ── */
    .v2-field { margin-bottom: 0; }
    .v2-label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 8px;
    }
    .v2-label-aligned { min-height: 34px; }
    .v2-label .req { color: #ef4444; margin-left: 3px; }

    /* ── Input Fields ── */
    .v2-input-wrap { position: relative; }
    .v2-input-wrap .v2-icon {
        position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
        color: #94a3b8; pointer-events: none; width: 18px; height: 18px;
        z-index: 5;
    }
    .v2-input {
        box-sizing: border-box;
        width: 100%;
        height: 50px;
        padding: 0 16px 0 44px;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        background: #f8fafc;
        color: #0f172a;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
        outline: none;
        -webkit-appearance: none;
        appearance: none;
        display: block;
    }
    .v2-input::placeholder { color: #94a3b8; font-weight: 400; }
    .v2-input:focus {
        border-color: #3b82f6;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(59,130,246,0.12);
    }
    .v2-input-wrap:focus-within .v2-icon { color: #3b82f6; }

    /* ── Tomselect override ── */
    .ts-wrapper {
        height: 50px !important;
    }
    .ts-wrapper .ts-control {
        box-sizing: border-box !important;
        height: 50px !important;
        padding: 0 16px 0 44px !important;
        border: 2px solid #e2e8f0 !important;
        border-radius: 14px !important;
        background: #f8fafc !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        color: #0f172a !important;
        box-shadow: none !important;
        transition: all 0.2s ease !important;
        min-height: unset !important;
        display: flex !important;
        align-items: center !important;
        flex-wrap: nowrap !important;
        overflow: hidden !important;
    }
    .ts-wrapper .ts-control input {
        color: #0f172a !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .ts-wrapper.focus .ts-control {
        border-color: #3b82f6 !important;
        background: #fff !important;
        box-shadow: 0 0 0 4px rgba(59,130,246,0.12) !important;
    }
    select.tomselected {
        display: block !important; opacity: 0 !important; position: absolute !important;
        height: 1px !important; width: 1px !important; bottom: 0 !important;
        left: 0 !important; z-index: -1 !important; padding: 0 !important; margin: 0 !important;
    }

    /* ── Table ── */
    .v2-table { width: 100%; border-collapse: separate; border-spacing: 0; }
    .v2-table thead tr { background-color: #f1f5f9; }
    .v2-table thead th {
        padding: 14px 12px;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        text-align: center;
        border-bottom: 1px solid #e2e8f0;
    }
    .v2-table thead th:first-child { border-radius: 14px 0 0 0; }
    .v2-table thead th:last-child  { border-radius: 0 14px 0 0; }
    .v2-table tbody tr {
        background: #fff;
        transition: background 0.15s;
    }
    .v2-table tbody tr:hover { background: #eff6ff; }
    .v2-table tbody tr:last-child td:first-child { border-radius: 0 0 0 14px; }
    .v2-table tbody tr:last-child td:last-child  { border-radius: 0 0 14px 0; }
    .v2-table tbody td {
        padding: 8px 8px;
        text-align: center;
        border-bottom: 1px solid #f1f5f9;
        border-right: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .v2-table tbody td:last-child { border-right: none; }
    .v2-table-wrap { border-radius: 16px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.07); border: 1.5px solid #e2e8f0; }

    /* Table fields */
    .v2-td-textarea {
        box-sizing: border-box;
        display: block;
        width: 100%;
        height: 38px;
        min-height: 38px;
        padding: 8px 10px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        background: #f8fafc;
        font-size: 13px;
        color: #0f172a;
        text-align: left;
        transition: all 0.2s;
        outline: none;
        resize: none;
        overflow-y: hidden;
        line-height: 1.4;
        font-family: inherit;
    }
    .v2-td-textarea:focus {
        border-color: #3b82f6;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
    }
    .v2-td-textarea::placeholder { color: #94a3b8; }
    .v2-td-input {
        box-sizing: border-box;
        display: block;
        width: 100%;
        height: 38px;
        min-height: 38px;
        padding: 0 10px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        background: #f8fafc;
        font-size: 13px;
        color: #0f172a;
        transition: all 0.2s;
        outline: none;
        line-height: 38px;
        text-align: left;
    }
    .v2-td-input:focus {
        border-color: #3b82f6;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
    }
    .v2-td-input::placeholder { color: #94a3b8; }

    /* Buttons */
    .v2-btn-delete {
        display: inline-flex; align-items: center; justify-content: center;
        width: 32px; height: 32px;
        border-radius: 8px;
        background: #fef2f2;
        color: #ef4444;
        border: 1.5px solid #fecaca;
        cursor: pointer;
        transition: all 0.15s;
    }
    .v2-btn-delete:hover { background: #ef4444; color: #fff; border-color: #ef4444; transform: scale(1.05); }

    .v2-btn-add-row {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px;
        border-radius: 8px;
        background: #f1f5f9;
        color: #0f172a;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        transition: all 0.2s;
    }
    .v2-btn-add-row:hover { background: #e2e8f0; }

    .v2-btn-cancel {
        display: inline-flex; align-items: center; justify-content: center;
        padding: 10px 24px;
        border-radius: 8px;
        border: none;
        background-color: #ef4444;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
    }
    .v2-btn-cancel:hover { background-color: #b91c1c; color: #fff; }
    .v2-btn-save {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 24px;
        border-radius: 8px;
        border: none;
        background-color: #059669;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .v2-btn-save:hover { background-color: #047857; }

    .v2-row-no {
        display: inline-flex; align-items: center; justify-content: center;
        width: 28px; height: 28px;
        border-radius: 50%;
        background: #eff6ff;
        color: #2563eb;
        font-size: 13px;
        font-weight: 800;
    }

    input, select, textarea { scroll-margin-top: 150px; scroll-margin-bottom: 150px; }
</style>

<div class="v2-page">
<div class="max-w-6xl mx-auto px-4">
    <div class="v2-main-container">
    <form id="revocationForm" action="{{ route('form-revocation.store') }}" method="POST">
        @csrf

        {{-- ─── SECTION 1 ─── --}}
        <div class="v2-card">
            <div class="v2-card-header">
                <div class="badge">1</div>
                <div>
                    <h2>Informasi Dasar</h2>
                    <p>No Referensi, Tanggal Cetak, dan Business Area</p>
                </div>
            </div>
            <div class="v2-card-body">
                <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                    <div class="v2-field">
                        <label class="v2-label">No Ref <span class="req">*</span></label>
                        <div class="v2-input-wrap">
                            <svg class="v2-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
                            <input type="text" name="no_ref" value="{{ old('no_ref') }}" class="v2-input" placeholder="01 / 10 / 2020" required>
                        </div>
                    </div>

                    <div class="v2-field">
                        <label class="v2-label">Tanggal Cetak <span class="req">*</span></label>
                        <div class="v2-input-wrap">
                            <svg class="v2-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <input type="text" name="tanggal" value="{{ old('tanggal') }}" class="v2-input custom-date-picker" style="cursor:pointer;" placeholder="Pilih Tanggal" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="v2-field">
                        <label class="v2-label">Business Area <span class="req">*</span></label>
                        <div class="v2-input-wrap">
                            <svg class="v2-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <input type="text" name="business_area" value="{{ old('business_area') }}" class="v2-input" placeholder="Nama Business Area" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ─── SECTION 2 ─── --}}
        <div class="v2-card">
            <div class="v2-card-header">
                <div class="badge">2</div>
                <div>
                    <h2>Data Pemohon</h2>
                    <p>Tanggal Permohonan (paling kiri), Informasi Pembuat, dan Bagian / Fungsi</p>
                </div>
            </div>
            <div class="v2-card-body">
                <div style="display:grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                    <div class="v2-field">
                        <label class="v2-label">Tanggal Permohonan <span class="req">*</span></label>
                        <div class="v2-input-wrap">
                            <svg class="v2-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <input type="text" name="tanggal_permohonan" value="{{ old('tanggal_permohonan') }}" class="v2-input custom-date-picker" style="cursor:pointer;" placeholder="Pilih Tanggal" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="v2-field">
                        <label class="v2-label">Nama Pemohon <span class="req">*</span></label>
                        <div class="v2-input-wrap">
                            <svg class="v2-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <input type="text" name="nama_pemohon" value="{{ old('nama_pemohon') }}" class="v2-input" placeholder="Nama Lengkap" required>
                        </div>
                    </div>

                    <div class="v2-field">
                        <label class="v2-label">NIP Pemohon <span class="req">*</span></label>
                        <div class="v2-input-wrap">
                            <svg class="v2-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <input type="text" name="nip_pemohon" value="{{ old('nip_pemohon') }}" class="v2-input" placeholder="NIP / NIPP Pemohon" required>
                        </div>
                    </div>

                    <div class="v2-field">
                        <label class="v2-label">Bagian / Fungsi <span class="req">*</span></label>
                        <div class="v2-input-wrap">
                            <svg class="v2-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <input type="text" name="bagian_fungsi" value="{{ old('bagian_fungsi') }}" class="v2-input" placeholder="Contoh: Unit IT / Keuangan" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ─── SECTION 3 ─── --}}
        <div class="v2-card">
            <div class="v2-card-header" style="justify-content: space-between;">
                <div style="display:flex; align-items:center; gap:14px;">
                    <div class="badge">3</div>
                    <div>
                        <h2>Hak Akses Pengguna</h2>
                        <p>Daftar Pengguna, Akun, dan Alasan Pencabutan</p>
                    </div>
                </div>
                <button type="button" id="btn-add-row" class="v2-btn-add-row">
                    Tambah Baris
                </button>
            </div>
            <div class="v2-card-body" style="padding: 20px;">
                <div class="v2-table-wrap">
                    <table class="v2-table">
                        <thead>
                            <tr>
                                <th style="width:52px;">No</th>
                                <th>Nama Pengguna & NIP</th>
                                <th>Jenis Akun</th>
                                <th>Unit Kerja</th>
                                <th>Alasan</th>
                                <th style="width:52px;"></th>
                            </tr>
                        </thead>
                        <tbody id="checklist-body">
                            <tr>
                                <td><span class="v2-row-no">1</span><input type="hidden" name="items[1][no]" value="1"></td>
                                <td><input type="text" name="items[1][nama_pengguna]" class="v2-td-input" placeholder="Nama & NIP Personil" required></td>
                                <td><input type="text" name="items[1][jenis_akun]" class="v2-td-input" placeholder="Jenis Akun / Akses" required></td>
                                <td><input type="text" name="items[1][unit_kerja]" class="v2-td-input" placeholder="Unit Kerja Personil" required></td>
                                <td><textarea name="items[1][alasan]" class="v2-td-textarea" rows="1" oninput="autoResize(this)" onkeyup="autoResize(this)" placeholder="Alasan Pencabutan" required></textarea></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ─── SECTION 4 ─── --}}
        <div class="v2-card">
            <div class="v2-card-header">
                <div class="badge">4</div>
                <div>
                    <h2>Persetujuan & Pengesahan</h2>
                    <p>Tanda Tangan Pemohon & Pilihan Opsi Mengetahui</p>
                </div>
            </div>
            <div class="v2-card-body">
                <div style="display:grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 24px;">
                    <div class="v2-field">
                        <label class="v2-label v2-label-aligned">Tanda Tangan Pemohon (Tanggal & Tahun) <span class="req">*</span> <span style="color:#94a3b8; font-weight:400; text-transform:none; font-size:11px;">(Bandung, otomatis)</span></label>
                        <div class="v2-input-wrap">
                            <svg class="v2-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <input type="text" name="kota_tanggal_pemohon" value="{{ old('kota_tanggal_pemohon') }}" class="v2-input custom-date-picker" style="cursor:pointer;" placeholder="Pilih Tanggal" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="v2-field" style="position:relative;">
                        <label class="v2-label v2-label-aligned">Status Persetujuan <span class="req">*</span></label>
                        <div class="v2-input-wrap" style="position:relative;">
                            <svg class="v2-icon" style="z-index:10;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <select id="status_persetujuan" name="status_persetujuan" required>
                                <option value="DISETUJUI" selected>DISETUJUI</option>
                                <option value="TIDAK DISETUJUI">TIDAK DISETUJUI</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                    <div class="v2-field">
                        <label class="v2-label v2-label-aligned">Tanda Tangan Manajemen (Tanggal) <span class="req">*</span> <span style="color:#94a3b8; font-weight:400; text-transform:none; font-size:11px;">(Bandung, otomatis)</span></label>
                        <div class="v2-input-wrap">
                            <svg class="v2-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <input type="text" name="kota_tanggal_setuju" value="{{ old('kota_tanggal_setuju') }}" class="v2-input custom-date-picker" style="cursor:pointer;" placeholder="Pilih Tanggal" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="v2-field" style="position:relative;">
                        <label class="v2-label v2-label-aligned">Jabatan (Mengetahui) <span class="req">*</span></label>
                        <div class="v2-input-wrap" style="position:relative;">
                            <svg class="v2-icon" style="z-index:10;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <select id="jabatan_mengetahui" name="jabatan_mengetahui" required>
                                <option value="">-- Pilih Jabatan --</option>
                                <option value="Manajemen Puncak">Manajemen Puncak</option>
                                <option value="Pimpinan Unit Sistem Informasi">Pimpinan Unit Sistem Informasi</option>
                            </select>
                        </div>
                    </div>

                    <div class="v2-field">
                        <label class="v2-label v2-label-aligned">Nama Pejabat (Mengetahui) <span class="req">*</span></label>
                        <div class="v2-input-wrap">
                            <svg class="v2-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <input type="text" name="mengetahui_nama" value="{{ old('mengetahui_nama') }}" class="v2-input" placeholder="Nama Pejabat Penandatangan" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ─── Action Buttons ─── --}}
        <div style="display:flex; justify-content:flex-end; gap:14px; margin-top:24px; padding-bottom: 32px;">
            <a href="{{ route('form-revocation.index') }}" class="v2-btn-cancel">
                Batal
            </a>
            <button type="submit" class="v2-btn-save">
                Simpan
            </button>
        </div>
    </form>
    </div>

</div>
</div>

@endsection

@section('scripts')
<script>
    let currentRowCount = 1;

    function makeRowHTML(n) {
        return `
            <td><span class="v2-row-no">${n}</span><input type="hidden" name="items[${n}][no]" value="${n}"></td>
            <td><input type="text" name="items[${n}][nama_pengguna]" class="v2-td-input" placeholder="Nama & NIP Personil" required></td>
            <td><input type="text" name="items[${n}][jenis_akun]" class="v2-td-input" placeholder="Jenis Akun / Akses" required></td>
            <td><input type="text" name="items[${n}][unit_kerja]" class="v2-td-input" placeholder="Unit Kerja Personil" required></td>
            <td><textarea name="items[${n}][alasan]" class="v2-td-textarea" oninput="autoResize(this)" onkeyup="autoResize(this)" placeholder="Alasan..." required></textarea></td>
            <td><button type="button" class="v2-btn-delete btn-delete-row" title="Hapus">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button></td>
        `;
    }

    function autoResize(el) {
        el.style.height = 'auto';
        el.style.height = el.scrollHeight + 'px';
    }

    document.getElementById('btn-add-row').addEventListener('click', function() {
        currentRowCount++;
        const tr = document.createElement('tr');
        tr.innerHTML = makeRowHTML(currentRowCount);
        document.getElementById('checklist-body').appendChild(tr);
    });

    document.getElementById('checklist-body').addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-delete-row');
        if (btn) {
            btn.closest('tr').remove();
            updateRowNumbers();
        }
    });

    function updateRowNumbers() {
        document.querySelectorAll('#checklist-body tr').forEach((row, i) => {
            const no = i + 1;
            currentRowCount = Math.max(currentRowCount, no);
            const badge = row.querySelector('.v2-row-no');
            if (badge) badge.textContent = no;
            const hidden = row.querySelector('input[type="hidden"]');
            if (hidden) hidden.value = no;
            row.querySelectorAll('input, textarea').forEach(inp => {
                if (inp.name) inp.name = inp.name.replace(/items\[\d+\]/, `items[${no}]`);
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof TomSelect !== 'undefined') {
            new TomSelect("#jabatan_mengetahui", { create: false, placeholder: "-- Pilih Jabatan --" });
            new TomSelect("#status_persetujuan", { create: false });
        }

        const form = document.getElementById('revocationForm');
        if (form) {
            form.addEventListener('invalid', function(e) {
                const first = form.querySelector(':invalid');
                if (first && first === e.target) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, true);
        }

        const jabatanSelect = document.getElementById('jabatan_mengetahui');
        const namaInput = document.querySelector('input[name="mengetahui_nama"]');
        if (jabatanSelect && namaInput) {
            jabatanSelect.addEventListener('change', function() {
                const val = this.value;
                if (val === 'Manajemen Puncak') {
                    namaInput.value = 'Pitra';
                } else if (val === 'Pimpinan Unit Sistem Informasi') {
                    namaInput.value = 'Qonita';
                } else {
                    namaInput.value = '';
                }
            });
        }
    });
</script>
@endsection
