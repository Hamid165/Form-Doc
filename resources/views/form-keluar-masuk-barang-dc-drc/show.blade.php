@extends('layouts.app')

@section('title', 'Detail Formulir Keluar/Masuk Barang')

@section('content')
<style>
    .a4-wrapper {
        display: flex;
        justify-content: center;
        padding: 20px;
    }
    .a4-container {
        width: 297mm;
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
    .main-table th {
        background-color: #f0f0f0;
        font-weight: bold;
        text-align: center;
        font-size: 9px;
        padding: 4px 3px;
    }
    .main-table td {
        padding: 3px 5px;
        font-size: 9px;
    }
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
    .cb {
        width: 12px;
        height: 12px;
        vertical-align: middle;
    }
    @media print {
        body {
            background-color: white;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        body * {
            visibility: hidden;
        }
        .a4-wrapper, .a4-wrapper * {
            visibility: visible;
        }
        .a4-wrapper {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 0;
            margin: 0;
            background: transparent;
        }
        .a4-container {
            box-shadow: none;
            width: 100%;
            padding: 0;
            margin: 0;
            min-height: auto;
        }
        .no-print, .no-print * {
            display: none !important;
        }
        @page {
            size: A4 landscape;
            margin: 10mm;
        }
    }
</style>

<!-- Breadcrumb -->
<div class="mb-4 no-print">
    <a href="{{ route('form-keluar-masuk-barang-dc-drc.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Formulir Keluar/Masuk Barang
    </a>
</div>

<div class="a4-wrapper" style="flex-direction: column; align-items: center;">
    <div class="a4-container">

        {{-- ============================================== --}}
        {{-- HEADER --}}
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
                    <td style="border: none; padding: 2px 5px; border-bottom: 1px dashed #000; min-width: 180px;">{{ $form->no_ref }}</td>
                </tr>
                <tr style="border: none;">
                    <td style="border: none; font-weight: bold; padding: 2px 5px;">Tanggal</td>
                    <td style="border: none; padding: 2px 5px;">:</td>
                    <td style="border: none; padding: 2px 5px; border-bottom: 1px dashed #000;">{{ $form->tanggal ?? '-' }}</td>
                </tr>
                <tr style="border: none;">
                    <td style="border: none; font-weight: bold; padding: 2px 5px;">Business Area</td>
                    <td style="border: none; padding: 2px 5px;">:</td>
                    <td style="border: none; padding: 2px 5px; border-bottom: 1px dashed #000;">{{ $form->business_area ?? '-' }}</td>
                </tr>
            </table>
        </div>

        {{-- ============================================== --}}
        {{-- JENIS TRANSAKSI + DATA PEMOHON (SIDE BY SIDE) --}}
        {{-- ============================================== --}}
        <div style="margin: 10px 0;">
            <table style="width: 100%; border: none;">
                <tr style="border: none;">
                    {{-- KIRI: Jenis Transaksi --}}
                    <td style="border: none; width: 50%; vertical-align: top; padding-right: 15px;">
                        <div style="margin-bottom: 8px;">
                            <div style="display: flex; gap: 15px; margin-bottom: 10px;">
                                <label style="display: flex; align-items: center; gap: 5px;">
                                    <input type="radio" class="cb" {{ $form->jenis === 'masuk' ? 'checked' : '' }} disabled>
                                    <span style="font-weight: bold;">Barang Masuk (*)</span>
                                </label>
                                <label style="display: flex; align-items: center; gap: 5px;">
                                    <input type="radio" class="cb" {{ $form->jenis === 'keluar' ? 'checked' : '' }} disabled>
                                    <span style="font-weight: bold;">Barang Keluar (*)</span>
                                </label>
                            </div>

                            @if($form->tanggal_masuk || $form->jam_masuk)
                            <table style="border: none; width: 100%;">
                                <tr style="border: none;">
                                    <td style="border: none; font-weight: bold; width: 80px; padding: 2px;">Tanggal</td>
                                    <td style="border: none; padding: 2px;">:</td>
                                    <td style="border: none; padding: 2px; border-bottom: 1px dashed #000;">{{ $form->tanggal_masuk ?? '-' }}</td>
                                </tr>
                                <tr style="border: none;">
                                    <td style="border: none; font-weight: bold; padding: 2px;">Jam</td>
                                    <td style="border: none; padding: 2px;">:</td>
                                    <td style="border: none; padding: 2px; border-bottom: 1px dashed #000;">{{ $form->jam_masuk ? substr($form->jam_masuk, 0, 5) : '-' }}</td>
                                </tr>
                            </table>
                            @endif
                        </div>
                    </td>

                    {{-- KANAN: Data Pemohon --}}
                    <td style="border: none; width: 50%; vertical-align: top;">
                        <table style="border: none; width: 100%;">
                            <tr style="border: none;">
                                <td style="border: none; font-weight: bold; width: 120px; padding: 2px;">Nama</td>
                                <td style="border: none; padding: 2px;">:</td>
                                <td style="border: none; padding: 2px; border-bottom: 1px dashed #000;">{{ $form->nama_pemohon }}</td>
                            </tr>
                            <tr style="border: none;">
                                <td style="border: none; font-weight: bold; padding: 2px;">Nomor Identitas</td>
                                <td style="border: none; padding: 2px;">:</td>
                                <td style="border: none; padding: 2px; border-bottom: 1px dashed #000;">{{ $form->nomor_identitas }}</td>
                            </tr>
                            <tr style="border: none;">
                                <td style="border: none; font-weight: bold; padding: 2px;">Alamat</td>
                                <td style="border: none; padding: 2px;">:</td>
                                <td style="border: none; padding: 2px; border-bottom: 1px dashed #000;">{{ $form->alamat ?? '-' }}</td>
                            </tr>
                            <tr style="border: none;">
                                <td style="border: none; font-weight: bold; padding: 2px;">Nomor Telepon</td>
                                <td style="border: none; padding: 2px;">:</td>
                                <td style="border: none; padding: 2px; border-bottom: 1px dashed #000;">{{ $form->nomor_telepon ?? '-' }}</td>
                            </tr>
                            <tr style="border: none;">
                                <td style="border: none; font-weight: bold; padding: 2px;">Perusahaan / Unit</td>
                                <td style="border: none; padding: 2px;">:</td>
                                <td style="border: none; padding: 2px; border-bottom: 1px dashed #000;">{{ $form->perusahaan_unit ?? '-' }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        {{-- ============================================== --}}
        {{-- TABEL ASET --}}
        {{-- ============================================== --}}
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
                </tr>
                <tr>
                    <th style="font-size: 8px;">OWNER</th>
                    <th style="font-size: 8px;">POWER (A)</th>
                    <th style="font-size: 8px;">BERAT (KG)</th>
                    <th style="font-size: 8px;">UKURAN (U)</th>
                    <th style="font-size: 8px;">JENIS HW/SW</th>
                    <th style="font-size: 8px;">BARU</th>
                    <th style="font-size: 8px;">BEKAS</th>
                    <th style="font-size: 8px;">BAIK</th>
                    <th style="font-size: 8px;">RUSAK</th>
                </tr>
            </thead>
            <tbody>
                @forelse($form->items as $item)
                <tr>
                    <td style="text-align: center;">{{ $item->no_urut }}</td>
                    <td>{{ $item->nama_jenis_aset }}</td>
                    <td>
                        @if(!empty($item->part_no) && $item->jumlah > 1)
                            @php
                                $sns = array_filter(array_map('trim', preg_split('/[\n,]+/', $item->part_no)));
                            @endphp
                            @if(count($sns) > 1)
                                <div style="text-align: left; padding-left: 2px; white-space: nowrap;">
                                    @foreach($sns as $i => $sn)
                                        <div style="margin-bottom: 2px;">{{ $i + 1 }}. {{ $sn }}</div>
                                    @endforeach
                                </div>
                            @else
                                {{ $item->part_no }}
                            @endif
                        @else
                            {{ $item->part_no ?? '-' }}
                        @endif
                    </td>
                    <td style="text-align: center;">{{ $item->jumlah }}</td>
                    <td>{{ $item->satuan }}</td>
                    <td>{{ $item->merk_type ?? '-' }}</td>
                    <td>{{ $item->kategori_aset ?? '-' }}</td>
                    <td>{{ $item->lokasi_penyimpanan ?? '-' }}</td>
                    <td>{{ $item->owner ?? '-' }}</td>
                    <td>{{ $item->power_a ?? '-' }}</td>
                    <td>{{ $item->berat_kg ?? '-' }}</td>
                    <td>{{ $item->ukuran_u ?? '-' }}</td>
                    <td>{{ $item->jenis_hw_sw ?? '-' }}</td>
                    <td style="text-align: center;">{{ $item->kondisi_baru_bekas === 'baru' ? '✓' : '' }}</td>
                    <td style="text-align: center;">{{ $item->kondisi_baru_bekas === 'bekas' ? '✓' : '' }}</td>
                    <td style="text-align: center;">{{ $item->kondisi_baik_rusak === 'baik' ? '✓' : '' }}</td>
                    <td style="text-align: center;">{{ $item->kondisi_baik_rusak === 'rusak' ? '✓' : '' }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>

                @empty
                <tr>
                    <td colspan="19" style="text-align: center; padding: 15px; color: #999;">Tidak ada data aset</td>
                </tr>
                @endforelse
            </tbody>
        </table>

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
                <td style="border: none; vertical-align: top; width: 50%; padding: 5px;">
                    {{-- Dateline --}}
                    <div style="text-align: right; margin-bottom: 10px; font-style: italic;">
                        {{ $form->kota_ttd ?? 'Yogyakarta' }}, {{ $form->tanggal ? date('d-m-Y', strtotime($form->tanggal)) : date('d-m-Y') }}
                    </div>

                    {{-- 3 Kolom Tanda Tangan --}}
                    <table style="width: 100%; border: none;">
                        <tr style="border: none;">
                            {{-- PEMOHON --}}
                            <td class="sig-block" style="border: none; vertical-align: top; width: 33.33%;">
                                <div style="font-weight: bold; margin-bottom: 50px;">Pemohon,</div>
                                <div class="sig-name" style="margin-top: 0;">
                                    <span class="sig-bracket" style="font-weight: bold; padding-bottom: 2px;">
                                        {!! $form->nama_pemohon ?: '&nbsp;' !!}
                                    </span>
                                </div>
                            </td>
                            {{-- PELAKSANA --}}
                            <td class="sig-block" style="border: none; vertical-align: top; width: 33.33%;">
                                <div style="font-weight: bold; margin-bottom: 50px;">Pelaksanaan Pekerjaan,</div>
                                <div class="sig-name" style="margin-top: 0;">
                                    <span class="sig-bracket" style="font-weight: bold; padding-bottom: 2px;">
                                        {!! $form->nama_pelaksana ?: '&nbsp;' !!}
                                    </span>
                                    <div style="font-size: 9px; margin-top: 2px; color: #555;">
                                        NIPP: {{ $form->nipp_pelaksana ?? '-' }}<br>
                                        {{ $form->jabatan_pelaksana ?? '' }}
                                    </div>
                                </div>
                            </td>
                            {{-- MENGETAHUI --}}
                            <td class="sig-block" style="border: none; vertical-align: top; width: 33.33%;">
                                <div style="font-weight: bold; margin-bottom: 50px;">Mengetahui,</div>
                                <div class="sig-name" style="margin-top: 0;">
                                    <span class="sig-bracket" style="font-weight: bold; padding-bottom: 2px;">
                                        {!! $form->nama_mengetahui ?: '&nbsp;' !!}
                                    </span>
                                    <div style="font-size: 9px; margin-top: 2px; color: #555;">
                                        NIPP: {{ $form->nipp_mengetahui ?? '-' }}<br>
                                        {{ $form->jabatan_mengetahui ?? '' }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </div>
</div>

@if(request()->has('print'))
<script>
    window.onload = function() {
        setTimeout(function() {
            window.print();
        }, 500);
        
        window.onafterprint = function() {
            window.close();
        }
    };
</script>
@endif
@endsection
