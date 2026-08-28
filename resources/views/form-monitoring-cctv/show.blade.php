@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 overflow-x-auto">
        <style>
            .print-preview {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 11px;
                color: #000;
                line-height: 1.1;
                min-width: 1000px; /* Force minimum width to simulate A4 landscape */
                background-color: white;
            }
            .print-preview table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 10px;
                table-layout: fixed;
            }
            .print-preview th, .print-preview td {
                border: 1px solid #000;
                padding: 3px;
                word-wrap: break-word;
            }
            .print-preview .text-center { text-align: center; }
            .print-preview .text-left { text-align: left; }
            .print-preview .align-middle { vertical-align: middle; }
            .print-preview .font-bold { font-weight: bold; }
            .print-preview .bg-gray { background-color: #d1d5db; }
            .print-preview .no-border { border: none !important; }
        </style>

        <div class="print-preview">
            <!-- KOP FORMULIR -->
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
                <colgroup>
                    <col style="width: 10%;">
                    <col style="width: 65%;">
                    <col style="width: 9%;">
                    <col style="width: 16%;">
                </colgroup>
                <tr>
                    <td rowspan="2" class="text-center align-middle" style="width: 15%; padding: 5px;">
                        <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI" style="height: 35px; margin: 0 auto;">
                    </td>
                    <td rowspan="2" class="text-center align-middle" style="width: 65%;">
                        <h2 style="margin: 0; font-size: 14px; font-weight: bold;">PT. KERETA API INDONESIA (PERSERO)</h2>
                        <h3 style="margin: 0; font-size: 12px; font-weight: bold; padding-top: 2px;">Sistem Informasi</h3>
                    </td>
                    <td style="width: 9%; border-right: none; padding-left: 6px; font-size: 10px;">Nomor</td>
                    <td style="width: 16%; border-left: none; font-size: 10px;">: FR.SM/TI/015.017/10-2020</td>
                </tr>
                <tr>
                    <td style="border-right: none; padding-left: 6px; font-size: 10px;">Tanggal Terbit</td>
                    <td style="border-left: none; font-size: 10px;">: 12 Oktober 2020</td>
                </tr>
                <tr>
                    <td rowspan="2" class="text-center align-middle" style="padding: 5px;">
                        <span style="border: 1px solid #ca8a04; color: #ca8a04; padding: 2px 5px; font-weight: bold; font-size: 22px; white-space: nowrap; letter-spacing: 1px;">TERBATAS</span>
                    </td>
                    <td rowspan="2" class="text-center align-middle">
                        <h4 style="margin: 0; font-size: 14px; font-weight: bold;">FORMULIR MONITORING CCTV</h4>
                    </td>
                    <td style="border-right: none; padding-left: 6px; font-size: 10px;">Versi</td>
                    <td style="border-left: none; font-size: 10px;">: 002-2020</td>
                </tr>
                <tr>
                    <td style="border-right: none; padding-left: 6px; font-size: 10px;">Halaman</td>
                    <td style="border-left: none; font-size: 10px;">: 1 dari 1</td>
                </tr>
            </table>

            <!-- INFO NO REF -->
            <table style="width: 25%; table-layout: auto;">
                <tr>
                    <td style="width: 35%; border-right: none;">No Ref</td>
                    <td style="width: 5%; border-left: none; border-right: none;">:</td>
                    <td style="width: 60%; border-left: none;">{{ $monitoring->no_ref }}</td>
                </tr>
                <tr>
                    <td style="border-right: none;">Tanggal</td>
                    <td style="border-left: none; border-right: none;">:</td>
                    <td style="border-left: none;">{{ $monitoring->tanggal ? \Carbon\Carbon::parse($monitoring->tanggal)->locale('id')->isoFormat('D MMMM YYYY') : '' }}</td>
                </tr>
                <tr>
                    <td style="border-right: none;">Business Area</td>
                    <td style="border-left: none; border-right: none;">:</td>
                    <td style="border-left: none;">{{ $monitoring->business_area }}</td>
                </tr>
            </table>

            <!-- TABEL UTAMA CHECKLIST -->
            <table style="table-layout: fixed; width: 100%;">
                <thead>
                    <tr class="bg-gray">
                        <th rowspan="4" class="text-center align-middle" style="width: 4%;">No</th>
                        <th class="text-left" style="width: 23%;">Bulan</th>
                        <th colspan="8" class="text-center font-bold">{{ strtoupper($monitoring->bulan) }}</th>
                        <th rowspan="4" class="text-center align-middle" style="width: 20%;">Note</th>
                    </tr>
                    <tr class="bg-gray">
                        <th class="text-left">Minggu</th>
                        <th colspan="2" class="text-center" style="width: 13.25%;">M1</th>
                        <th colspan="2" class="text-center" style="width: 13.25%;">M2</th>
                        <th colspan="2" class="text-center" style="width: 13.25%;">M3</th>
                        <th colspan="2" class="text-center" style="width: 13.25%;">M4</th>
                    </tr>
                    <tr class="bg-gray">
                        <th class="text-left">Tanggal Pelaksanaan</th>
                        <th colspan="2" class="text-center">{{ $monitoring->tgl_pelaksanaan_m1 ? \Carbon\Carbon::parse($monitoring->tgl_pelaksanaan_m1)->format('d/m/Y') : '' }}</th>
                        <th colspan="2" class="text-center">{{ $monitoring->tgl_pelaksanaan_m2 ? \Carbon\Carbon::parse($monitoring->tgl_pelaksanaan_m2)->format('d/m/Y') : '' }}</th>
                        <th colspan="2" class="text-center">{{ $monitoring->tgl_pelaksanaan_m3 ? \Carbon\Carbon::parse($monitoring->tgl_pelaksanaan_m3)->format('d/m/Y') : '' }}</th>
                        <th colspan="2" class="text-center">{{ $monitoring->tgl_pelaksanaan_m4 ? \Carbon\Carbon::parse($monitoring->tgl_pelaksanaan_m4)->format('d/m/Y') : '' }}</th>
                    </tr>
                    <tr class="bg-gray" style="font-size: 10px; letter-spacing: -0.2px; padding: 1px;">
                        <th class="text-center">{{ $monitoring->header_nama_titik_cctv ?? 'Nama Titik CCTV' }}</th>
                        <th style="width: 6.625%;">BERFUNGSI</th>
                        <th style="width: 6.625%;">TERBACKUP</th>
                        <th style="width: 6.625%;">BERFUNGSI</th>
                        <th style="width: 6.625%;">TERBACKUP</th>
                        <th style="width: 6.625%;">BERFUNGSI</th>
                        <th style="width: 6.625%;">TERBACKUP</th>
                        <th style="width: 6.625%;">BERFUNGSI</th>
                        <th style="width: 6.625%;">TERBACKUP</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $rowCount = isset($monitoring) && $monitoring->items->count() > 0 ? $monitoring->items->count() : 10;
                    @endphp
                    @for ($i = 1; $i <= $rowCount; $i++)
                        @php
                            $item = isset($monitoring) && $monitoring->items->count() >= $i ? $monitoring->items[$i-1] : null;
                        @endphp
                        <tr>
                            <td class="text-center font-bold">{{ $item->nomor ?? ($i == $rowCount ? '<n>' : $i) }}</td>
                            <td>{{ $item->nama_titik_cctv ?? '' }}</td>
                            <td class="text-center">{{ $item->m1_berfungsi ?? '' }}</td>
                            <td class="text-center">{{ $item->m1_terbackup ?? '' }}</td>
                            <td class="text-center">{{ $item->m2_berfungsi ?? '' }}</td>
                            <td class="text-center">{{ $item->m2_terbackup ?? '' }}</td>
                            <td class="text-center">{{ $item->m3_berfungsi ?? '' }}</td>
                            <td class="text-center">{{ $item->m3_terbackup ?? '' }}</td>
                            <td class="text-center">{{ $item->m4_berfungsi ?? '' }}</td>
                            <td class="text-center">{{ $item->m4_terbackup ?? '' }}</td>
                            <td>{{ $item->note ?? '' }}</td>
                        </tr>
                    @endfor
                </tbody>
            </table>

            <!-- CATATAN -->
            <div style="margin-bottom: 10px;">
                <div style="margin-bottom: 3px; font-weight: bold;">Catatan :</div>
                <div style="border: 1px solid #000; padding: 6px; min-height: 40px;">
                    {!! nl2br(e($monitoring->catatan)) !!}
                </div>
            </div>

            <!-- TANDA TANGAN -->
            <table class="no-border">
                <tr>
                    <td class="no-border" style="width: 30%; vertical-align: top;">
                        <p style="margin: 0; line-height: 1.5;">Keterangan :<br>V : YA<br>X : TIDAK</p>
                    </td>
                    <td class="no-border text-center" style="width: 35%; vertical-align: top;">
                        <p style="margin: 0;">Mengetahui,</p>
                        <p style="margin: 0; margin-bottom: 45px;">Yogyakarta, {{ $monitoring->mengetahui_tanggal ? \Carbon\Carbon::parse($monitoring->mengetahui_tanggal)->locale('id')->isoFormat('D MMMM YYYY') : '' }}</p>
                        
                        <p style="margin: 0; font-weight: bold; text-decoration: underline;">{{ $monitoring->mengetahui->nama ?? ($monitoring->mengetahui_id ? 'ID: '.$monitoring->mengetahui_id : '') }}</p>
                        <p style="margin: 0;">NIPP. {{ $monitoring->mengetahui->nipp ?? '' }}</p>
                    </td>
                    <td class="no-border text-center" style="width: 35%; vertical-align: top;">
                        <p style="margin: 0;">Yogyakarta, {{ $monitoring->petugas_tanggal ? \Carbon\Carbon::parse($monitoring->petugas_tanggal)->locale('id')->isoFormat('D MMMM YYYY') : '' }}</p>
                        <p style="margin: 0; margin-bottom: 45px;">Petugas</p>
                        
                        <p style="margin: 0; font-weight: bold; text-decoration: underline;">{{ $monitoring->petugas_nama ?? '' }}</p>
                        <p style="margin: 0;">NIPP. {{ $monitoring->petugas_nipp ?? '' }}</p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
            <a href="{{ route('form-monitoring-cctv.index') }}" 
               class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
