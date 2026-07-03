@extends('layouts.app')

@section('title', 'Tambah Formulir CCTV')

@section('content')
@include('components.custom-datepicker')

<style>
    /* ── Page Background ── */
    .v2-page { background-color: #f8fafc; min-height: 100vh; padding: 2rem 0; }

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

    /* readonly NIPP */
    .v2-input-readonly {
        box-sizing: border-box;
        width: 100%;
        height: 50px;
        padding: 0 16px 0 44px;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        background: #f1f5f9;
        color: #64748b;
        font-size: 14px;
        font-weight: 500;
        display: block;
        cursor: not-allowed;
    }

    /* ── Tomselect override — match height to .v2-input exactly ── */
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

    /* Table textarea */
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
        overflow: hidden;
        line-height: 1.375;
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
        text-align: center;
        transition: all 0.2s;
        outline: none;
        line-height: 38px;
    }
    .v2-td-input:focus {
        border-color: #3b82f6;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
    }
    .v2-td-input::placeholder { color: #94a3b8; }

    /* Custom Checkbox */
    .v2-checkbox {
        width: 22px; height: 22px;
        border: 2px solid #cbd5e1;
        border-radius: 6px;
        cursor: pointer;
        accent-color: #3b82f6;
        transition: transform 0.1s;
    }
    .v2-checkbox:hover { transform: scale(1.1); border-color: #3b82f6; }

    /* Delete row btn */
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

    /* Add row btn */
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

    /* Action Buttons */
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

    /* Row number badge */
    .v2-row-no {
        display: inline-flex; align-items: center; justify-content: center;
        width: 28px; height: 28px;
        border-radius: 50%;
        background: #eff6ff;
        color: #2563eb;
        font-size: 13px;
        font-weight: 800;
    }

    /* Scroll margin */
    input, select, textarea { scroll-margin-top: 150px; scroll-margin-bottom: 150px; }

    /* Page title */
    .v2-page-title { font-size: 26px; font-weight: 800; color: #0f172a; margin-bottom: 4px; }
    .v2-page-sub   { font-size: 14px; color: #64748b; margin-bottom: 28px; }

    /* Main Container */
    .v2-main-container { padding: 32px; background: #fff; border-radius: 20px; border: 1px solid #e2e8f0; }
    .v2-card { box-shadow: none; }
</style>

<div class="v2-page">
<div class="max-w-6xl mx-auto px-4">

    <div class="v2-main-container">
    <form id="cctvForm" action="{{ route('form-cctv.store') }}" method="POST">
        @csrf

        {{-- ─── SECTION 1 ─── --}}
        <div class="v2-card">
            <div class="v2-card-header">
                <div class="badge">1</div>
                <div>
                    <h2>Informasi Dasar</h2>
                    <p>No Referensi, Tanggal, Business Area</p>
                </div>
            </div>
            <div class="v2-card-body">
                <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">

                    <div class="v2-field">
                        <label class="v2-label">No Ref <span class="req">*</span></label>
                        <div class="v2-input-wrap">
                            <svg class="v2-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
                            <input type="text" name="no_ref" value="{{ old('no_ref') }}" class="v2-input" placeholder="01 / 10 / 2020" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')">
                        </div>
                    </div>

                    <div class="v2-field">
                        <label class="v2-label">Tanggal <span class="req">*</span></label>
                        <div class="v2-input-wrap">
                            <svg class="v2-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <input type="text" name="tanggal" value="{{ old('tanggal') }}" class="v2-input custom-date-picker" style="cursor:pointer;" placeholder="Pilih Tanggal" autocomplete="off" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')">
                        </div>
                    </div>

                    <div class="v2-field">
                        <label class="v2-label">Business Area <span class="req">*</span></label>
                        <div class="v2-input-wrap">
                            <svg class="v2-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <input type="text" name="business_area" value="{{ old('business_area') }}" class="v2-input" placeholder="Nama Business Area" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')">
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
                    <h2>Data Perangkat</h2>
                    <p>ID CCTV dan Lokasi Pemasangan</p>
                </div>
            </div>
            <div class="v2-card-body">
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 20px;">

                    <div class="v2-field" style="position:relative;">
                        <label class="v2-label">ID CCTV <span class="req">*</span></label>
                        <div class="v2-input-wrap" style="position:relative;">
                            <svg class="v2-icon" style="z-index:10;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <select id="id_cctv" name="id_cctv" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" onchange="this.setCustomValidity('')">
                                <option value="">-- Pilih ID CCTV --</option>
                                @for($i=1; $i<=10; $i++)
                                @php $val = "CCTV-" . str_pad($i, 2, '0', STR_PAD_LEFT); @endphp
                                <option value="{{ $val }}" {{ old('id_cctv') == $val ? 'selected' : '' }}>{{ $val }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="v2-field">
                        <label class="v2-label">Lokasi <span class="req">*</span></label>
                        <div class="v2-input-wrap">
                            <svg class="v2-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <input type="text" name="lokasi" value="{{ old('lokasi') }}" class="v2-input" placeholder="Contoh: Stasiun Tugu Yogyakarta" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')">
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
                        <h2>Item Pemeriksaan</h2>
                        <p>Tambah minimal 1 baris kegiatan</p>
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
                                <th>Tanggal</th>
                                <th style="width:110px;">Perawatan</th>
                                <th style="width:110px;">Perbaikan</th>
                                <th>Keterangan</th>
                                <th>Paraf</th>
                                <th style="width:52px;"></th>
                            </tr>
                        </thead>
                        <tbody id="checklist-body">
                            <tr>
                                <td><span class="v2-row-no">1</span><input type="hidden" name="items[1][no]" value="1"></td>
                                <td><input type="text" name="items[1][tanggal]" class="v2-td-input custom-date-picker" data-format="id" style="cursor:pointer; min-width:110px;" placeholder="Tanggal" autocomplete="off" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')"></td>
                                <td><input type="checkbox" name="items[1][perawatan]" value="V" class="v2-checkbox"></td>
                                <td><input type="checkbox" name="items[1][perbaikan]" value="V" class="v2-checkbox"></td>
                                <td><textarea name="items[1][keterangan]" class="v2-td-textarea" rows="1" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity(''); autoResize(this)" onkeyup="autoResize(this)" placeholder="Keterangan..."></textarea></td>
                                <td><input type="text" name="items[1][paraf]" class="v2-td-input" placeholder="Nama"></td>
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
                    <h2>Pengesahan</h2>
                    <p>Tanggal, Nama Pejabat & NIPP</p>
                </div>
            </div>
            <div class="v2-card-body">
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 20px;">

                    <div class="v2-field">
                        <label class="v2-label">Tanggal Pengesahan (Yogyakarta) <span class="req">*</span></label>
                        <div class="v2-input-wrap">
                            <svg class="v2-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <input type="text" name="kota_tanggal" class="v2-input custom-date-picker" data-format="id" style="cursor:pointer;" placeholder="Pilih Tanggal" autocomplete="off" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')" oninput="this.setCustomValidity('')">
                        </div>
                    </div>

                    <div class="v2-field" style="position:relative;">
                        <label class="v2-label">Nama Pejabat (Mengetahui) <span class="req">*</span></label>
                        <div class="v2-input-wrap" style="position:relative;">
                            <svg class="v2-icon" style="z-index:10;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <select id="mengetahui_nama" name="mengetahui_nama" onchange="updateNipp(); this.setCustomValidity('');" required oninvalid="this.setCustomValidity('Bagian ini harus diisi')">
                                <option value="">-- Pilih Nama --</option>
                                <option value="Pitra">Pitra</option>
                                <option value="Hamid">Hamid</option>
                            </select>
                        </div>
                    </div>

                    <div></div>
                    <div class="v2-field">
                        <label class="v2-label">NIPP <span style="color:#94a3b8; font-weight:400; text-transform:none; font-size:11px;">(otomatis)</span></label>
                        <div class="v2-input-wrap">
                            <svg class="v2-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                            <input type="text" id="mengetahui_nipp" name="mengetahui_nipp" class="v2-input-readonly" placeholder="Otomatis Terisi" readonly>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ─── Action Buttons ─── --}}
        <div style="display:flex; justify-content:flex-end; gap:14px; margin-top:8px; padding-bottom: 32px;">
            <a href="{{ route('form-cctv.index') }}" class="v2-btn-cancel">
                Batal
            </a>
            <button type="button" id="btn-submit-v2" class="v2-btn-save">
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
            <td><input type="text" name="items[${n}][tanggal]" class="v2-td-input custom-date-picker" data-format="id" style="cursor:pointer; min-width:110px;" placeholder="Tanggal" autocomplete="off"></td>
            <td><input type="checkbox" name="items[${n}][perawatan]" value="V" class="v2-checkbox"></td>
            <td><input type="checkbox" name="items[${n}][perbaikan]" value="V" class="v2-checkbox"></td>
            <td><textarea name="items[${n}][keterangan]" class="v2-td-textarea" rows="1" oninput="autoResize(this)" onkeyup="autoResize(this)" placeholder="Keterangan..."></textarea></td>
            <td><input type="text" name="items[${n}][paraf]" class="v2-td-input" placeholder="Nama"></td>
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
        document.dispatchEvent(new Event('refreshDatePickers'));
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
            row.querySelectorAll('input').forEach(inp => {
                if (inp.name) inp.name = inp.name.replace(/items\[\d+\]/, `items[${no}]`);
            });
        });
    }

    function updateNipp() {
        const v = document.getElementById('mengetahui_nama').value;
        document.getElementById('mengetahui_nipp').value = v === 'Pitra' ? '123123123' : v === 'Hamid' ? '321321' : '';
    }

    document.addEventListener('DOMContentLoaded', function() {
        // TomSelect
        if (typeof TomSelect !== 'undefined') {
            new TomSelect("#id_cctv", { create: false, placeholder: "-- Pilih ID CCTV --" });
            new TomSelect("#mengetahui_nama", { create: false, placeholder: "-- Pilih Nama --" });
        }

        // Scroll to invalid
        const form = document.getElementById('cctvForm');
        if (form) {
            form.addEventListener('invalid', function(e) {
            const first = form.querySelector(':invalid');
            if (first && first === e.target) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, true);
        }

        // Checkbox native validation
        const chkP  = document.querySelector('input[name="items[1][perawatan]"]');
        const chkPb = document.querySelector('input[name="items[1][perbaikan]"]');
        const clear = () => { if (chkP) chkP.setCustomValidity(''); };
        if (chkP)  chkP.addEventListener('change', clear);
        if (chkPb) chkPb.addEventListener('change', clear);

        document.getElementById('btn-submit-v2').addEventListener('click', function() {
            if (chkP && chkPb && !chkP.checked && !chkPb.checked) {
                chkP.setCustomValidity('Jenis Kegiatan (Perawatan/Perbaikan) baris 1 harus diisi');
            } else if (chkP) {
                chkP.setCustomValidity('');
            }
            if (form && form.reportValidity()) form.submit();
        });
    });
</script>
@endsection
