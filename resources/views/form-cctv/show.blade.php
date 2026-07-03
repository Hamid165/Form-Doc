<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Checklist Pemeliharaan CCTV - {{ $form->no_ref }}</title>
    <link rel="icon" href="{{ asset('images/favicon.svg') }}">
    <style>
        /* Base Styling untuk meniru cetakan A4 */
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            background-color: #525659;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
        }
        .a4-container {
            width: 210mm;
            min-height: 297mm;
            background: white;
            padding: 20mm;
            box-sizing: border-box;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
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
        
        /* Info Section (No Ref, Tanggal, dll) */
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
            width: 97px; /* Lebar khusus kolom tulisan "No Ref", "Tanggal", dll */
        }
    
        /* PENGATURAN UKURAN TABEL KANAN (ID CCTV) */
        .table-kanan {
            width: max-content; /* Lebar otomatis menyesuaikan isi agar garis batas kanan pas */
        }
        .kolom-label-kanan {
            width: 99px; /* Lebar khusus kolom tulisan "ID CCTV" */
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
            margin-bottom: 4px;
        }
        .info-text-label {
            width: 80px;
        }
        .placeholder-red {
            color: #d9534f;
            font-size: 10px;
        }
        .filled-data {
            font-weight: normal;
        }
        
        /* Main Checklist Table */
        .main-table th, .main-table td {
            border: 1px solid black;
            padding: 2px;
        }
        .main-table th {
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
        }
        .text-center {
            text-align: center;
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
        .signature-space {
            height: 60px;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
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
            /* retain padding from base class to act as margin */
        }
        .no-print {
            display: none !important;
        }
    }
    @page {
        size: auto;
        margin: 0mm;
    }
    
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
    </style>
</head>
<body>
    
    <div class="a4-container relative">
        <!-- Tombol diletakkan di pojok kanan atas (text-align: right) -->
        <div class="no-print" style="margin-bottom: 20px; text-align: right; display: flex; justify-content: flex-end; gap: 10px;">
            <a href="{{ route('form-cctv.index') }}" class="btn-kembali">Kembali</a>
            <button onclick="window.print()" class="btn-print">Print</button>
        </div>

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
                    <td class="filled-data">: {{ $form->no_ref ?: '__ / __ / _______' }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td class="filled-data">: {{ $form->tanggal ? \Carbon\Carbon::parse($form->tanggal)->format('d / m / Y') : '__ / __ / _______' }}</td>
                </tr>
                <tr>
                    <td>Business Area</td>
                    <td class="filled-data">: {{ $form->business_area }}</td>
                </tr>
            </table>

            <!-- PENGATURAN LEBAR TABEL KANAN (ID CCTV) -->
            <table class="small-info-table table-kanan">
                <tr>
                    <td class="kolom-label-kanan" style="border: none;">ID CCTV</td>
                    <td class="filled-data" style="border: none;">: {{ $form->id_cctv ?: '(nomor ID aset CCTV)' }}</td>
                </tr>
                <tr>
                    <td class="kolom-label-kanan" style="border: none;">LOKASI</td>
                    <td class="filled-data" style="border: none;">: {{ $form->lokasi ?: '(tempat keberadaan aset CCTV)' }}</td>
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
            <tbody>
                @php
                    // Retrieve items and pad array to at least 20 rows
                    $items = $form->items->keyBy('no')->toArray();
                    $maxItems = max(20, count($items) > 0 ? max(array_keys($items)) : 0);
                @endphp
                
                @for ($i = 1; $i <= $maxItems; $i++)
                    @php
                        $item = $items[$i] ?? null;
                        $jenis = $item && $item['jenis_kegiatan'] ? json_decode($item['jenis_kegiatan'], true) : null;
                        $isPerawatan = $jenis && isset($jenis['perawatan']) && $jenis['perawatan'] == 'V' ? 'V' : '-';
                        $isPerbaikan = $jenis && isset($jenis['perbaikan']) && $jenis['perbaikan'] == 'V' ? 'V' : '-';
                    @endphp
                    <tr>
                        <td class="text-center">{{ $i }}</td>
                        <td class="text-center">{{ $item['tanggal'] ?? '' }}</td>
                        <td class="text-center">{{ $isPerawatan }}</td>
                        <td class="text-center">{{ $isPerbaikan }}</td>
                        <td class="text-center">{{ $item['keterangan'] ?? '' }}</td>
                        <td class="text-center">{{ $item['paraf'] ?? '' }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>

            <div class="footer-section clearfix">
                <div class="signature-box">
                    <p>Yogyakarta, <span>{{ $form->kota_tanggal ? \Carbon\Carbon::parse($form->kota_tanggal)->locale('id')->translatedFormat('j F Y') : '................................' }}</span></p>
                    <p class="mt-4">Mengetahui,</p>
                    <div style="height: 60px;"></div>
                    <p><span>{{ $form->mengetahui_nama ?: '(..................................................)' }}</span></p>
                    <p style="text-align: center;">NIPP. {{ $form->mengetahui_nipp ?: '..........................................' }}</p>
                </div>
            </div>

    </div>

</body>
</html>
