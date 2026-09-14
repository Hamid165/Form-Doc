<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir PC/Laptop Checking KAI - {{ $form->no_ref }}</title>
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
            width: 297mm; /* Landscape A4 */
            min-height: 210mm;
            padding: 20mm 10mm;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            box-sizing: border-box;
            color: #000;
            position: relative;
        }

        /* Tabel Kop Surat */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 11px;
        }
        .kop-table td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: middle;
        }
        
        .logo-cell {
            width: 12%;
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
        
        .badge-cell {
            width: 12%;
            text-align: center;
            height: 38px;
        }
        .badge-terbatas {
            display: inline-block;
            border: 2px solid #d97706;
            color: #d97706;
            font-weight: bold;
            font-size: 11px;
            padding: 4px 14px;
            letter-spacing: 1px;
        }

        .title-cell {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            width: 50%;
        }
        .info-label { width: 12%; font-size: 11px; }
        .info-value { width: 20%; font-size: 11px; }

        /* Tabel Referensi */
        .ref-table {
            width: 35%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 11px;
        }
        .ref-table td {
            border: 1px solid #000;
            padding: 4px;
        }

        /* Periode Pemeriksaan */
        .periode-section {
            font-size: 11px;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .periode-section div { margin-bottom: 4px; }

        /* Tabel Data Checking */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 9px;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 4px;
        }
        .data-table th {
            background-color: #d4d4d4;
            font-weight: normal;
            text-align: center;
            white-space: pre-wrap;
        }
        .data-table td {
            height: 25px;
            text-align: center;
        }
        .data-table td.no-cell {
            text-align: center;
            width: 25px;
        }

        /* Catatan / Mengetahui */
        .bottom-section {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 11px;
        }
        .bottom-section td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: top;
        }

        /* Buttons */
        .btn-kembali {
            width: 100px; height: 36px; line-height: 36px; padding: 0; 
            background-color: #f44336; color: white; border: none; cursor: pointer; 
            border-radius: 4px; font-weight: bold; font-family: inherit; font-size: 13px; 
            text-decoration: none; text-align: center; box-sizing: border-box; display: inline-block;
            transition: background-color 0.2s;
        }
        .btn-kembali:hover { background-color: #d32f2f; }
        .btn-print {
            width: 100px; height: 36px; line-height: 36px; padding: 0; 
            background-color: #4CAF50; color: white; border: none; cursor: pointer; 
            border-radius: 4px; font-weight: bold; font-family: inherit; font-size: 13px; 
            text-align: center; box-sizing: border-box; display: inline-block;
            transition: background-color 0.2s;
        }
        .btn-print:hover { background-color: #388e3c; }

        @media print {
            body {
                margin: 0;
                padding: 0;
                background-color: white;
            }
            .a4-container {
                box-shadow: none;
                width: 100%;
                padding: 10mm;
            }
            .no-print {
                display: none !important;
            }
            
            /* Print scaling optimization */
            html {
                zoom: 0.95; 
            }
        }
        @page {
            size: landscape;
            margin: 0mm;
        }
    </style>
</head>
<body>

    <div class="a4-container">
        <div class="no-print" style="position: absolute; top: 15px; right: 20px; display: flex; gap: 10px; z-index: 100;">
            <a href="{{ route('form-pc-laptop-checking.index') }}" class="btn-kembali">Kembali</a>
            <button onclick="window.print()" class="btn-print">Print</button>
        </div>

        <!-- Kop Surat -->
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
                <td class="info-value">: {{ $formTemplate->no_dokumen ?? 'FR.SM/TI/017.002/10-2020' }}</td>
            </tr>
            <tr>
                <td class="info-label">Tanggal Terbit</td>
                <td class="info-value">: {{ $formTemplate->tanggal_dokumen ?? '12 Oktober 2020' }}</td>
            </tr>
            <tr>
                <td rowspan="2" class="badge-cell">
                    <span class="badge-terbatas">TERBATAS</span>
                </td>
                <td rowspan="2" class="title-cell">
                    FORMULIR PC/LAPTOP CHECKING
                </td>
                <td class="info-label">Status Revisi</td>
                <td class="info-value">: {{ $formTemplate->versi_dokumen ?? '002-2020' }}</td>
            </tr>
            <tr>
                <td class="info-label">Halaman</td>
                <td class="info-value">: 1 dari 1</td>
            </tr>
        </table>

        <!-- Referensi -->
        <table class="ref-table">
            <tr>
                <td style="width: 40%">No. Ref</td>
                <td>: {{ $form->no_ref ?: '' }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: {{ $form->tanggal ? \Carbon\Carbon::parse($form->tanggal)->locale('id')->translatedFormat('d - m - Y') : '' }}</td>
            </tr>
            <tr>
                <td>Business Area</td>
                <td>: {{ $form->business_area ?: '' }}</td>
            </tr>
        </table>

        <!-- Periode & Tanggal -->
        <div class="periode-section">
            <div>Periode Pemeriksaan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $form->periode_pemeriksaan ?: '......................................................' }}</div>
            <div>Tanggal Pemeriksaan &nbsp;&nbsp;&nbsp;&nbsp;: {{ $form->tanggal_pemeriksaan ? \Carbon\Carbon::parse($form->tanggal_pemeriksaan)->locale('id')->translatedFormat('d F Y') : '......................................................' }}</div>
        </div>

        <!-- Tabel Data Checking -->
        <table class="data-table">
            <thead>
                <tr>
                    <th rowspan="3" style="width: 25px;">NO</th>
                    <th rowspan="3" style="width: 120px;">NAMA PENGGUNA</th>
                    <th rowspan="3" style="width: 80px;">UNIT</th>
                    <th colspan="12">CHECKLIST</th>
                    <th colspan="2">Verifikasi / Paraf</th>
                </tr>
                <tr>
                    <th rowspan="2">NDA</th>
                    <th rowspan="2">Login Strong<br>Password</th>
                    <th rowspan="2">Screensaver<br>Lock (maks<br>5 menit)</th>
                    <th rowspan="2">* Hak Akses<br>Khusus</th>
                    <th rowspan="2">Cleardesk</th>
                    <th rowspan="2">.mp3, video,<br>etc</th>
                    <th colspan="3">Antivirus</th>
                    <th rowspan="2">O/S</th>
                    <th rowspan="2">Sinkronisasi<br>NTP Server</th>
                    <th rowspan="2">Label PC</th>
                    <th rowspan="2">Pemeriksa</th>
                    <th rowspan="2">Pegawai<br>Ybs</th>
                </tr>
                <tr>
                    <th>Status<br>Install</th>
                    <th>Status<br>Update</th>
                    <th>Full Scan Auto<br>Schedule</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $rawItems = $form->items ? array_values($form->items->toArray()) : [];
                    $items = array_filter($rawItems, function($item) {
                        return !empty($item['nama_pengguna']) || !empty($item['unit']) || !empty($item['nda']);
                    });
                    $items = array_values($items);
                    $countItems = count($items);
                @endphp
                
                @for ($i = 0; $i < $countItems; $i++)
                    @php
                        $item = $items[$i];
                    @endphp
                    <tr>
                        <td class="no-cell">{{ $i + 1 }}</td>
                        <td>{{ $item['nama_pengguna'] ?? '' }}</td>
                        <td>{{ $item['unit'] ?? '' }}</td>
                        <td>{{ $item['nda'] ?? '' }}</td>
                        <td>{{ $item['login_strong_password'] ?? '' }}</td>
                        <td>{{ $item['screensaver_lock'] ?? '' }}</td>
                        <td>{{ $item['hak_akses_khusus'] ?? '' }}</td>
                        <td>{{ $item['cleardesk'] ?? '' }}</td>
                        <td>{{ ($item['mp3_video_etc'] ?? '') === 'Tidak' ? 'Tidak Ada' : ($item['mp3_video_etc'] ?? '') }}</td>
                        <td>{{ $item['antivirus_install'] ?? '' }}</td>
                        <td>{{ $item['antivirus_update'] ?? '' }}</td>
                        <td>{{ $item['full_scan_auto_schedule'] ?? '' }}</td>
                        <td>{{ ($item['os_license'] ?? '') === 'Tidak' ? 'Non License' : ($item['os_license'] ?? '') }}</td>
                        <td>{{ $item['sinkronisasi_ntp'] ?? '' }}</td>
                        <td>{{ $item['label_pc'] ?? '' }}</td>
                        <td>{{ $item['pemeriksa'] ?? '' }}</td>
                        <td>{{ $item['pegawai_ybs'] ?? '' }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>

        <div style="text-align: left; padding-left: 25px; font-size: 11px; margin-top: 15px; margin-bottom: 15px; font-style: italic;">
            --- End of File ---
        </div>

        <!-- Catatan & Mengetahui -->
        @php
            $baLocationMap = ['B060' => 'Yogyakarta', 'B010' => 'Jakarta', 'B020' => 'Bandung', 'B030' => 'Cirebon', 'B040' => 'Semarang', 'B050' => 'Surabaya', 'B070' => 'Madiun', 'B080' => 'Purwokerto'];
            $lokasi = $baLocationMap[$form->business_area] ?? $form->business_area ?: '............................................';
            $tanggalText = $form->tanggal ? \Carbon\Carbon::parse($form->tanggal)->locale('id')->translatedFormat('d F Y') : '..................................';
        @endphp
        <div style="width: 100%; margin-top: 15px; font-size: 11px;">
            <div style="display: inline-block; width: 60%; vertical-align: top; border: 1px solid #000; padding: 8px; min-height: 120px; box-sizing: border-box;">
                <strong>Catatan :</strong><br>
                {!! nl2br(e($form->catatan ?: '')) !!}
            </div>
            <div style="display: inline-block; width: 38%; vertical-align: top; padding: 8px; text-align: center; box-sizing: border-box;">
                <div>{{ $lokasi }}, {{ $tanggalText }}</div>
                <div style="margin-top: 5px;">Mengetahui,</div>
                <div style="margin-top: 80px; border-bottom: 1px dotted #000; display: inline-block; min-width: 200px; padding-bottom: 4px; font-weight: bold;">
                    {{ $form->mengetahui_nama ?: '....................................................................' }}
                </div>
                @if(!empty($form->mengetahui_jabatan))
                <div style="margin-top: 4px;">
                    {{ $form->mengetahui_jabatan }}
                </div>
                @endif
                <div style="margin-top: 4px;">
                    NIPP. {{ $form->mengetahui_nipp ?: '......................' }}
                </div>
            </div>
        </div>

    </div>

    @if(request('print'))
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
    @endif
</body>
</html>
