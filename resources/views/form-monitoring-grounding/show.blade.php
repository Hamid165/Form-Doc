<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Monitoring Grounding KAI - {{ $form->no_ref }}</title>
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
            padding: 20mm 15mm;
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
        .info-label {
            width: 12%;
            font-size: 11px;
        }
        .info-value {
            width: 20%;
            font-size: 11px;
        }

        /* Tabel Referensi */
        .ref-table {
            width: 30%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 11px;
        }
        .ref-table td {
            border: 1px solid #000;
            padding: 4px;
        }
        .ref-label {
            width: 40%;
        }

        /* Bulan */
        .bulan-section {
            font-size: 12px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        /* Tabel Data Grounding */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 11px;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 6px 4px;
        }
        .data-table th {
            background-color: #d4d4d4;
            font-weight: normal;
            text-align: center;
            font-size: 11px;
        }
        .data-table td {
            height: 25px;
        }
        .data-table td.no-cell {
            text-align: center;
            width: 30px;
        }
        .data-table .standard-cell {
            text-align: center;
        }

        /* Footer Table */
        .footer-table {
            width: 40%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 11px;
        }
        .footer-table td {
            border: 1px solid #000;
            padding: 4px 6px;
        }
        .footer-table td:first-child {
            width: 40%;
        }

    /* Catatan */
    .catatan-box {
        width: 60%;
        border: 1px solid #000;
        padding: 8px;
        vertical-align: top;
        font-size: 11px;
        min-height: 120px;
        margin-top: 15px;
        display: inline-block;
    }
    .mengetahui-section {
        width: 38%;
        padding: 8px;
        vertical-align: top;
        font-size: 11px;
        text-align: center;
        margin-top: 15px;
        display: inline-block;
    }
    .end-of-file {
        text-align: left;
        font-size: 11px;
        color: #666;
        margin-top: 1px;
        font-style: italic;
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
                padding: 15mm;
            }
            .no-print {
                display: none !important;
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
            <a href="{{ route('form-monitoring-grounding.index') }}" class="btn-kembali">Kembali</a>
            @if(request('mode') !== 'view')
            <button onclick="window.print()" class="btn-print">Print</button>
            @endif
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
                <td class="info-value">: {{ $formTemplate->no_dokumen ?? 'FR.SM/TI/015.018/10-2020' }}</td>
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
                    FORMULIR MONITORING GROUNDING
                </td>
                <td class="info-label">Versi</td>
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

        <!-- Bulan -->
        <div class="bulan-section">
            <strong>Bulan</strong> : {{ $form->bulan ?: '......................................................' }}
        </div>

        <!-- Tabel Data Grounding -->
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 30px;">No.</th>
                    <th style="width: 18%;">Lokasi grounding</th>
                    <th style="width: 15%;">Nilai grounding standard (OHM)</th>
                    <th style="width: 15%;">Hasil pengukuran&nbsp;&nbsp;&nbsp;&nbsp;(OHM)</th>
                    <th style="width: 22%;">Kondisi bak grounding</th>
                    <th style="width: 22%;">Tindak lanjut</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $rawItems = $form->items ? array_values($form->items->toArray()) : [];
                    $items = array_filter($rawItems, function($item) {
                        return !empty($item['lokasi_grounding']) || !empty($item['hasil_pengukuran']) || !empty($item['kondisi_bak_grounding']) || !empty($item['tindak_lanjut']);
                    });
                    $items = array_values($items);
                    $countItems = count($items);
                    $maxItems = max(1, $countItems);
                @endphp
                
                @for ($i = 0; $i < $maxItems; $i++)
                    @php
                        $item = $items[$i] ?? null;
                    @endphp
                    <tr>
                        <td class="no-cell">{{ $i + 1 }}</td>
                        @if ($item)
                            <td>{{ $item['lokasi_grounding'] ?? '' }}</td>
                            <td class="standard-cell">{{ $item['nilai_grounding_standard'] ?? '≤ 1 OHM' }}</td>
                            <td>{{ $item['hasil_pengukuran'] ?? '' }}</td>
                            <td>{{ $item['kondisi_bak_grounding'] ?? '' }}</td>
                            <td>{{ $item['tindak_lanjut'] ?? '' }}</td>
                        @else
                            <td></td>
                            <td class="standard-cell">≤ 1 OHM</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        @endif
                    </tr>
                @endfor
            </tbody>
        </table>
        
        <!-- End of File -->
        <div class="end-of-file">
            --- End of File ---
        </div>

        
        <table class="footer-table">
            <tr>
                <td>Tgl pelaksanaan</td>
                <td>: {{ $form->tgl_pelaksanaan ?: '' }}</td>
            </tr>
            <tr>
                <td>Nama Petugas</td>
                <td>: {{ $form->nama_petugas ?: '' }}</td>
            </tr>
            <tr>
                <td>Paraf Petugas</td>
                <td>: {{ $form->paraf_petugas ?: '' }}</td>
            </tr>
        </table>

        <!-- Catatan & Mengetahui -->
        <div style="margin-top: 15px; display: flex; justify-content: space-between; width: 100%;">
            <div class="catatan-box" style="flex: 1; margin-right: 20px;">
                <strong>Catatan :</strong><br>
                {{ $form->catatan ?: '' }}
            </div>
            <div class="mengetahui-section" style="text-align: center; width: 250px; font-family: inherit;">
                @php
                    $baLocationMap = ['B060' => 'Yogyakarta', 'B010' => 'Jakarta', 'B020' => 'Bandung', 'B030' => 'Cirebon', 'B040' => 'Semarang', 'B050' => 'Surabaya', 'B070' => 'Madiun', 'B080' => 'Purwokerto'];
                    $lokasi = $baLocationMap[$form->business_area] ?? $form->business_area ?? '';
                    $tglFormatted = '';
                    if ($form->tanggal) {
                        try {
                            $tglFormatted = \Carbon\Carbon::parse($form->tanggal)->locale('id')->translatedFormat('d F Y');
                        } catch (\Exception $e) {
                            $tglFormatted = $form->tanggal;
                        }
                    }
                @endphp
                <div style="margin-bottom: 15px; color: #000;">{{ $lokasi }}{{ $tglFormatted ? ', ' . $tglFormatted : '' }}</div>
                <div style="margin-bottom: 5px;">Mengetahui,</div>
                <div style="margin-bottom: 5px;">{{ $form->mengetahui_jabatan ?: '..........................................' }}</div>
                
                <div style="height: 60px;"></div>
                
                <div style="font-weight: bold;">
                    {{ $form->mengetahui_nama ?: '(..................................................)' }}
                </div>
                <div style="margin-top: 5px;">
                    NIPP. {{ $form->mengetahui_nipp ?: '..........................................' }}
                </div>
            </div>
        </div>

    </div>

</body>
</html>


