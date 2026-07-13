<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pencabutan Hak Akses KAI - {{ $form->no_ref }}</title>
    <link rel="icon" href="{{ asset('images/favicon.svg') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .a4-container {
            background-color: white;
            width: 210mm; /* Lebar standar A4 */
            min-height: 297mm; /* Tinggi standar A4 */
            padding: 25mm 20mm;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            box-sizing: border-box;
            color: #000;
            position: relative;
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
        
        /* Bagian Logo KAI */
        .logo-cell {
            width: 15%;
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
        
        /* Kotak Kosong di Bawah Logo */
        .empty-box {
            width: 15%;
            height: 38px;
            background-color: white;
        }

        .title-cell {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            width: 45%;
        }
        .info-label {
            width: 15%;
            font-size: 11px;
        }
        .info-value {
            width: 25%;
            font-size: 11px;
        }

        /* Tabel Referensi */
        .ref-table {
            width: 35%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11px;
        }
        .ref-table td {
            border: 1px solid #000;
            padding: 4px;
        }
        .ref-label {
            width: 40%;
        }

        /* Area Info Pemohon */
        .applicant-info {
            display: table;
            width: calc(100% - 30px);
            font-size: 12px;
            margin-bottom: 15px;
            margin-left: 30px; /* Indentasi ke dalam */
        }
        .form-row {
            display: table-row;
        }
        .form-row > div {
            display: table-cell;
            padding-bottom: 8px;
            vertical-align: bottom;
        }
        .form-label {
            width: 170px;
            font-weight: normal; /* Font tidak lagi tebal/bold */
        }
        .form-colon {
            width: 20px;
            text-align: center;
        }
        
        /* Pengaturan Panjang Garis */
        .line-short {
            border-bottom: 1px solid #000;
            width: 200px; 
            padding-bottom: 2px;
        }
        .line-long {
            border-bottom: 1px solid #000;
            width: 370px; 
            padding-bottom: 2px;
        }

        /* Teks Keterangan - Disesuaikan agar sejajar */
        .desc-text {
            font-size: 12px;
            margin-bottom: 15px;
            margin-left: 30px; /* Dibuat sejajar dengan Info Pemohon */
        }

        /* Tabel Data Pengguna - Disesuaikan agar sejajar */
        .data-table {
            width: calc(100% - 30px); /* Sesuaikan lebar karena ada indentasi */
            margin-left: 30px; /* Dibuat sejajar dengan Info Pemohon */
            border-collapse: collapse;
            margin-bottom: 30px;
            font-size: 12px;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 8px;
        }
        .data-table th {
            background-color: #e6e6e6;
            font-weight: normal;
            text-align: center;
        }
        .data-table td {
            height: 25px;
        }

        /* Bagian Tanda Tangan */
        .signature-section {
            text-align: center;
            font-size: 12px;
            margin-top: 30px;
        }
        .signature-box {
            display: inline-block;
            text-align: center;
            width: 100%;
            margin-bottom: 15px;
        }
        .highlight-yellow {
            background-color: yellow;
        }

        /* Buttons & Preview styles */
        .btn-kembali {
            width: 100px; height: 36px; line-height: 36px; padding: 0; 
            background-color: #f44336; color: white; border: none; cursor: pointer; 
            border-radius: 4px; font-weight: bold; font-family: inherit; font-size: 13px; 
            text-decoration: none; text-align: center; box-sizing: border-box; display: inline-block;
            transition: background-color 0.2s;
        }
        .btn-kembali:hover {
            background-color: #d32f2f;
        }
        .btn-print {
            width: 100px; height: 36px; line-height: 36px; padding: 0; 
            background-color: #4CAF50; color: white; border: none; cursor: pointer; 
            border-radius: 4px; font-weight: bold; font-family: inherit; font-size: 13px; 
            text-align: center; box-sizing: border-box; display: inline-block;
            transition: background-color 0.2s;
        }
        .btn-print:hover {
            background-color: #388e3c;
        }

        .print-only {
            display: none !important;
        }
        .eof-cell {
            text-align: center;
            font-style: italic;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                background-color: white;
            }
            .a4-container {
                box-shadow: none;
                width: 100%;
                padding: 20mm;
            }
            .no-print {
                display: none !important;
            }
            .print-only {
                display: table-cell !important;
            }
            .screen-only {
                display: none !important;
            }
        }
        @page {
            size: auto;
            margin: 0mm;
        }
    </style>
</head>
<body>

    <div class="a4-container">
        <div class="no-print" style="position: absolute; top: 15px; right: 20px; display: flex; gap: 10px; z-index: 100;">
            <a href="{{ route('form-pencabutan-hak-akses.index') }}" class="btn-kembali">Kembali</a>
            <button onclick="window.print()" class="btn-print">Print</button>
        </div>
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
                <td class="info-value">{{ $formTemplate->no_dokumen ?? 'FR.SM/TI/013.004/10-2020' }}</td>
            </tr>
            <tr>
                <td class="info-label">Tanggal</td>
                <td class="info-value">{{ $formTemplate->tanggal_dokumen ?? '12 Oktober 2020' }}</td>
            </tr>
            <tr>
                <td rowspan="2" class="empty-box"></td>
                <td rowspan="2" class="title-cell">
                    FORMULIR<br>
                    PERMOHONAN PENCABUTAN HAK AKSES
                </td>
                <td class="info-label">Versi</td>
                <td class="info-value">{{ $formTemplate->versi_dokumen ?? '002-2020' }}</td>
            </tr>
            <tr>
                <td class="info-label">Halaman</td>
                <td class="info-value">1 dari 2</td>
            </tr>
        </table>

        <table class="ref-table">
            <tr>
                <td class="ref-label">No. Ref</td>
                <td>: {{ $form->no_ref ?: '' }}</td>
            </tr>
            <tr>
                <td class="ref-label">Tanggal</td>
                <td>: {{ $form->tanggal ? \Carbon\Carbon::parse($form->tanggal)->locale('id')->translatedFormat('d F Y') : '' }}</td>
            </tr>
            <tr>
                <td class="ref-label">Business Area</td>
                <td>: {{ $form->business_area ?: '' }}</td>
            </tr>
        </table>

        <div class="applicant-info">
            <div class="form-row">
                <div class="form-label">Tanggal Permohonan</div>
                <div class="form-colon">:</div>
                <div>
                    <div class="line-short">
                        {{ $form->tanggal_permohonan ? \Carbon\Carbon::parse($form->tanggal_permohonan)->locale('id')->translatedFormat('d F Y') : '' }}
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-label">Nama dan NIP Pemohon</div>
                <div class="form-colon">:</div>
                <div>
                    <div class="line-long">
                        {{ $form->nama_pemohon }}{{ $form->nip_pemohon ? ' (NIP. ' . $form->nip_pemohon . ')' : '' }}
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-label">Bagian / Fungsi</div>
                <div class="form-colon">:</div>
                <div>
                    <div class="line-long">
                        {{ $form->bagian_fungsi ?: '' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="desc-text">
            dengan ini mengajukan permohonan pencabutan/penonaktifan Hak Akses untuk pengguna sebagai berikut.
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 25%;">Nama Pengguna & NIP</th>
                    <th style="width: 25%;">Jenis Akun</th>
                    <th style="width: 25%;">Unit Kerja</th>
                    <th style="width: 25%;">Alasan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $rawItems = $form->items ? array_values($form->items->toArray()) : [];
                    $items = array_filter($rawItems, function($item) {
                        return !empty($item['nama_pengguna']) || !empty($item['jenis_akun']) || !empty($item['unit_kerja']) || !empty($item['alasan']);
                    });
                    $items = array_values($items); // re-index
                    $countItems = count($items);
                    $maxItems = max(4, $countItems + 1);
                @endphp
                
                @for ($i = 0; $i < $maxItems; $i++)
                    @php
                        $item = $items[$i] ?? null;
                    @endphp
                    <tr>
                        @if ($item)
                            <td>{{ $item['nama_pengguna'] ?? '' }}</td>
                            <td>{{ $item['jenis_akun'] ?? '' }}</td>
                            <td>{{ $item['unit_kerja'] ?? '' }}</td>
                            <td>{{ $item['alasan'] ?? '' }}</td>
                        @else
                            @if ($i === $countItems)
                                <td style="text-align: center;">
                                    <span style="font-style: italic;">-eof-</span>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            @else
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            @endif
                        @endif
                    </tr>
                @endfor
            </tbody>
        </table>

        <div class="signature-section">
            <div class="signature-box">
                <div>
                    Bandung, 
                    <span>
                        @if($form->kota_tanggal_pemohon)
                            {{ \Carbon\Carbon::hasFormat($form->kota_tanggal_pemohon, 'Y-m-d') ? \Carbon\Carbon::parse($form->kota_tanggal_pemohon)->locale('id')->translatedFormat('j F Y') : $form->kota_tanggal_pemohon }}
                        @else
                            ...... - ...... - ............
                        @endif
                    </span>
                </div>
                <div style="margin-top: 5px;">Pemohon</div>
                <div style="margin-top: 80px;">
                    (<span style="display:inline-block; width: 220px; border-bottom: 1px solid #000; padding-bottom: 2px; text-align: center;">{{ $form->nama_pemohon }}</span>)
                </div>
            </div>

            <div class="signature-box" style="margin-top: 0px;">
                <div>
                    Permohonan Pencabutan Hak Akses ini: 
                    @if($form->status_persetujuan == 'DISETUJUI')
                        DISETUJUI <span style="text-decoration: line-through; color: #777;">/ TIDAK DISETUJUI</span>*
                    @else
                        <span style="text-decoration: line-through; color: #777;">DISETUJUI /</span> TIDAK DISETUJUI*
                    @endif
                </div>
                <div style="margin-top: 15px;">
                    Bandung, 
                    <span>
                        @if($form->kota_tanggal_setuju)
                            {{ \Carbon\Carbon::hasFormat($form->kota_tanggal_setuju, 'Y-m-d') ? \Carbon\Carbon::parse($form->kota_tanggal_setuju)->locale('id')->translatedFormat('j F Y') : $form->kota_tanggal_setuju }}
                        @else
                            ...... - ...... - ............
                        @endif
                    </span>
                </div>
                <div style="margin-top: 5px;">
                    {{ $form->jabatan_mengetahui ?: 'Manajemen Puncak' }}
                </div>
                <div style="margin-top: 80px;">
                    (<span style="display:inline-block; width: 220px; border-bottom: 1px solid #000; text-align: center; padding-bottom: 2px;">{{ $form->mengetahui_nama }}</span>)
                </div>
            </div>
        </div>

    </div>

</body>
</html>
