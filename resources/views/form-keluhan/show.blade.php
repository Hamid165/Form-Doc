<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumentasi Pengelolaan dan Penanganan Keluhan - {{ $form->no_ref }}</title>
    <link rel="icon" href="{{ asset('images/favicon.svg') }}">
    <style>
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
            width: 297mm;
            min-height: 210mm;
            background: white;
            padding: 10mm;
            box-sizing: border-box;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .a4-container table {
            border-collapse: collapse;
        }

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

        .info-section {
            margin-top: 15px;
            margin-bottom: 15px;
        }
        
        .small-info-table {
            margin-bottom: 15px;
        }
        
        .table-kiri {
            width: max-content;
        }

        .kolom-label-kiri {
            width: 97px;
        }

        .small-info-table td {
            border: 1px solid black;
            padding: 2px 5px;
            height: auto;
        }

        .filled-data {
            font-weight: normal;
        }

        .main-table {
            width: 100%;
            table-layout: fixed;
        }

        .main-table th,
        .main-table td {
            border: 1px solid black;
            padding: 2px 4px;
            vertical-align: top;
            word-break: break-word;
            overflow-wrap: anywhere;
            white-space: normal;
        }
        
        .main-table th {
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
        }
        
        .text-center {
            text-align: center;
        }

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

        .signature-box-left {
            float: left;
            width: 200px;
            text-align: center;
            margin-left: 0;
        }
        
        .signature-box p, .signature-box-left p {
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
            min-height: auto;
        }
        .no-print {
            display: none !important;
        }
    }
    @page {
        margin: 8mm;
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

    @media screen and (max-width: 768px) {
        body {
            padding: 10px;
        }
        
        .a4-container {
            width: 100% !important;
            padding: 15px !important;
            box-shadow: none !important;
            min-height: auto;
        }
        
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 15px;
        }
        
        .a4-container table {
            min-width: 900px;
        }
        
        .header-table {
            min-width: 900px;
        }
        
        .footer-section {
            flex-direction: column;
        }
    }
    </style>
</head>
<body>

    <div class="a4-container relative">
        <div class="no-print" style="margin-bottom: 20px; text-align: right; display: flex; justify-content: flex-end; gap: 10px;">
            <a href="{{ route('form-keluhan.index') }}" class="btn-kembali">Batal</a>
            <button onclick="window.print()" class="btn-print">Print</button>
        </div>

        @php
    $kategori = strtoupper($formTemplate->kategori ?? 'Terbatas');
    if ($kategori === 'PUBLIC' || $kategori === 'ALL') {
        $kategori = 'UMUM';
    }
    $borderColor = '#5cb85c'; // hijau untuk UMUM
    if ($kategori === 'TERBATAS') {
        $borderColor = '#eadc04'; // kuning
    } elseif ($kategori === 'RAHASIA') {
        $borderColor = '#d9534f'; // merah
    }
@endphp

        <div class="table-responsive">
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
                <td style="width: 22%;">: {{ $formTemplate->no_dokumen ?? 'FR.SM/TI/033.001/10-2020' }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: {{ $formTemplate->tanggal_dokumen ?? '12 Oktober 2020' }}</td>
            </tr>
            <tr>
                <td rowspan="2" style="text-align: center;">
                    <div class="umum-box" style="border-color: {{ $borderColor }}; color: {{ $borderColor }};">{{ $kategori }}</div>
                </td>
                <td rowspan="2" class="title-text">
                    DOKUMENTASI PENGELOLAAN DAN PENANGANAN KELUHAN PELANGGAN
                </td>
                <td>Versi</td>
                <td>: {{ $formTemplate->versi_dokumen ?? '002-2020' }}</td>
            </tr>
            <tr>
                <td>Halaman</td>
                <td>: </td>
            </tr>
        </table>
        </div>

        <div class="info-section">
            <table class="small-info-table table-kiri">
                <tr>
                    <td class="kolom-label-kiri">No Ref</td>
                    <td class="filled-data">: {{ $form->no_ref ?: '__ / __ / _______' }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td class="filled-data">: {{ $form->tanggal ? \Carbon\Carbon::createFromFormat('d-m-Y', $form->tanggal)->format('d / m / Y') : '__ / __ / _______' }}</td>
                </tr>
            </table>
        </div>

        <div class="table-responsive">
        <table class="main-table">
            <thead>
                <tr>
                    <th rowspan="2" style="width:3%">NO</th>
                    <th rowspan="2" style="width:9%">TANGGAL</th>
                    <th rowspan="2" style="width:11%">PELANGGAN</th>
                    <th rowspan="2" style="width:10%">SUMBER</th>
                    <th rowspan="2" style="width:17%">DESKRIPSI KELUHAN</th>
                    <th rowspan="2" style="width:18%">TINDAKAN PERBAIKAN DAN PENCEGAHAN YANG DIAMBIL</th>
                    <th colspan="3" style="width:17%">VERIFICATION</th>
                    <th rowspan="2" style="width:15%">KETERANGAN</th>
                <tr>
                    <th style="width: 6%;">TGL</th>
                    <th style="width: 6%;">PIC</th>
                    <th style="width: 5%;">HASIL</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $items = $form->items->keyBy('no')->toArray();
                    $maxItems = max(10, count($items) > 0 ? max(array_keys($items)) : 0);
                    $lastFilledNo = count($items) > 0 ? max(array_keys($items)) : 0;
                @endphp

                @for ($i = 1; $i <= $maxItems; $i++)
                    @php
                        $item = $items[$i] ?? null;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $i }}</td>
                        <td class="text-center">{{ $item['tanggal'] ?? '' }}</td>
                        <td class="text-center">{{ $item['pelanggan'] ?? '' }}</td>
                        <td class="text-center">{{ $item['sumber'] ?? '' }}</td>
                        <td>{{ $item['deskripsi_keluhan'] ?? '' }}</td>
                        <td>{{ $item['tindakan'] ?? '' }}</td>
                        <td class="text-center">{{ $item['verifikasi_tgl'] ?? '' }}</td>
                        <td class="text-center">{{ $item['verifikasi_pic'] ?? '' }}</td>
                        <td>{{ $item['verifikasi_hasil'] ?? '' }}</td>
                        <td>{{ $item['keterangan'] ?? '' }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>
        </div>

            <div class="footer-section clearfix">
                <div class="signature-box-left">
                    <div style="height: 34px;"></div>
                    <p>Dibuat Oleh,</p>
                    <p>Pelaksana</p>
                    <div style="height: 60px;"></div>
                    <p><span>{{ $form->pelaksana_nama ?: '(..................................................)' }}</span></p>
                    <p style="margin-top: 5px; text-align: center;">NIPP. {{ $form->pelaksana_nipp ?: '..........................................' }}</p>
                </div>
                <div class="signature-box">
                    <p> Yogyakarta,
                        <span>{{ $form->kota_tanggal ?: '................................' }}</span>
                    </p>
                    <p style="margin-top: 15px;">Mengetahui,</p>
                    <p style="margin-top: 5px; text-align: center;">{{ $form->mengetahui_jabatan ?: '..........................................' }}</p>
                    <div style="height: 60px;"></div>
                    <p><span>{{ $form->mengetahui_nama ?: '(..................................................)' }}</span></p>
                    <p style="margin-top: 5px; text-align: center;">NIPP. {{ $form->mengetahui_nipp ?: '..........................................' }}</p>
                </div>
            </div>
        </div>
</body>
</html>
