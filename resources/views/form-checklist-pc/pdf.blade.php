<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checklist PC-Notebook-Printer — {{ $form_checklist_pc->no_ref }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: black; }
        table { border-collapse: collapse; width: 100%; }

        /* Kop Surat */
        .header-table td { border: 1px solid black; padding: 5px 7px; vertical-align: middle; }
        .title-text { font-size: 14px; font-weight: bold; text-align: center; }
        .terbatas-box { border: 2px solid #eab308; color: #eab308; padding: 5px 16px; font-weight: bold; font-size: 15px; display: inline-block; }

        /* Info Section (No.Ref / Tanggal / Business Area) */
        .info-table { width: 32%; border-collapse: collapse; margin: 8px 0; }
        .info-table td { border: 1px solid black; padding: 4px 7px; font-size: 12px; }
        .info-table .kolom-label { width: 110px; font-weight: bold; }

        /* Main Table */
        .main-table { table-layout: fixed; }
        .main-table th, .main-table td { border: 1px solid black; padding: 3px 4px; font-size: 11px; vertical-align: middle; text-align: center; word-wrap: break-word; }
        .main-table thead th { background-color: #b0c4de; font-weight: bold; }
        .chk-ok { color: #16a34a; font-weight: bold; }
        .chk-tidak { color: #dc2626; font-weight: bold; }
        .group-header { font-size: 12px; }
        /* Sel header kolom: kotak LURUS biasa (border normal di semua sisi),
           teksnya saja yang diputar tegak lurus (vertikal), bukan kotaknya.
           CATATAN DOMPDF: sengaja TIDAK memakai div pembungkus bersarang di dalam <th>
           (seperti versi web) karena dompdf sering salah menghitung tinggi baris ketika
           elemen absolute ada di dalam div di dalam <th>, sehingga baris kolaps/pendek
           dan teksnya ke-crop/ketiban baris nomor di bawahnya. position:relative +
           overflow:hidden dipasang LANGSUNG di <th> supaya dompdf menghitung tingginya
           dengan benar sebagai satu level saja. */
        .vert-cell {
            position: relative;
            height: 190px;
            padding: 0;
            overflow: hidden;
            vertical-align: bottom;
        }
        .vert-cell .vert-label { position: absolute; bottom: 4px; left: 50%; white-space: nowrap; font-size: 9px; font-weight: normal; transform: rotate(-90deg); transform-origin: left bottom; }
        .num-row th { font-size: 11px; height: 18px; }
        .col-no { width: 4.5%; }
        .col-aset { width: 13%; }
        .col-idaset { width: 8%; }
        .col-nipp { width: 9%; }
        .col-chk { width: 2.7%; }
        .col-paraf { width: 8.5%; }
        .data-cell-left { text-align: left; }

        /* Keterangan & Analisa: pakai TABLE (bukan flexbox) supaya kompatibel dengan dompdf */
        .bottom-table { width: 100%; margin-top: 10px; }
        .bottom-table td { vertical-align: top; padding: 0; border: none; }
        .bottom-table .col-left { width: 50%; padding-right: 10px; }
        .bottom-table .col-right { width: 50%; padding-left: 10px; }
        .keterangan-box { font-size: 11px; line-height: 1.5; }
        .keterangan-box ul { margin-left: 16px; }
        .analisa-wrap { font-size: 12px; }
        .analisa-wrap .analisa-title { display: block; font-weight: bold; text-transform: uppercase; margin-bottom: 4px; }
        .analisa-box { border: 1px solid black; padding: 7px; min-height: 150px; font-size: 12px; }

        /* Tanda tangan */
        .signature-table { width: 32%; margin-top: 20px; border-collapse: collapse; }
        .signature-table td.sig-cell { border: 1px solid black; padding: 7px; vertical-align: top; font-size: 12px; height: 110px; }
        .signature-table .sig-title { font-weight: bold; text-align: left; text-transform: uppercase; }
        .signature-table .sig-body { text-align: center; margin-top: 40px; }
        .signature-table .sig-body-signer { text-align: center; margin-top: 65px; }
        .signature-table .sig-name { border-bottom: 1px dotted black; display: inline-block; min-width: 160px; padding-bottom: 2px; font-weight: bold; }

        /* CATATAN DOMPDF: rule "@page { margin: ... }" terbukti TIDAK konsisten dieksekusi
           oleh dompdf (kadang diabaikan sepenuhnya tergantung versi/konfigurasi server).
           Solusi yang jauh lebih reliable: margin=0 di @page, lalu beri "jarak tepi"
           memakai padding biasa pada div pembungkus (.pdf-page) di bawah — ini murni
           box-model CSS biasa yang PASTI didukung dompdf, tidak bergantung pada
           implementasi @page. */
        .pdf-page { padding: 10mm 12mm; }
        @page { margin: 0; }
    </style>
</head>
<body>
    <div class="pdf-page">
    {{-- KOP SURAT --}}
    <table class="header-table">
        <tr>
            <td rowspan="2" style="width:10%; text-align:center;">
                <img src="{{ public_path('images/logo-kai.svg') }}" alt="KAI" style="max-width:100%; max-height:50px;">
            </td>
            <td rowspan="2" class="title-text" style="width:32%;">
                PT. KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI
            </td>
            <td style="width:10%;">No. Dokumen</td>
            <td style="width:18%;">: FR.SM/TI/015.002/10-2020</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>: 12 Oktober 2020</td>
        </tr>
        <tr>
            <td rowspan="2" style="text-align:center;">
                <div class="terbatas-box">TERBATAS</div>
            </td>
            <td rowspan="2" class="title-text">FORMULIR CHECKLIST PEMELIHARAAN PC-NOTEBOOK-PRINTER</td>
            <td>Versi</td>
            <td>: 003-2020</td>
        </tr>
        <tr>
            <td>Halaman</td>
            <td>: 1 dari 1</td>
        </tr>
    </table>

    {{-- INFO SECTION: No.Ref / Tanggal / Business Area --}}
    <table class="info-table">
        <tr><td class="kolom-label">No. Ref</td><td>: {{ $form_checklist_pc->no_ref ?: '___________________' }}</td></tr>
        <tr><td class="kolom-label">Tanggal</td><td>: {{ $form_checklist_pc->tanggal ? \Carbon\Carbon::parse($form_checklist_pc->tanggal)->locale('id')->isoFormat('D MMMM Y') : '___________________' }}</td></tr>
        <tr><td class="kolom-label">Business Area</td><td>: {{ $form_checklist_pc->business_area ?: '___________________' }}</td></tr>
    </table>

    {{-- TABEL UTAMA --}}
    <table class="main-table">
        <thead>
            <tr>
                <th rowspan="3" class="col-no">No</th>
                <th rowspan="3" class="col-aset">Nama Aset</th>
                <th rowspan="3" class="col-idaset">ID Aset</th>
                <th rowspan="3" class="col-nipp">NIPP</th>
                <th colspan="9" class="group-header">Checklist Fungsional Sistem</th>
                <th colspan="12" class="group-header">Checklist Fungsional Fisik</th>
                <th rowspan="3" class="col-paraf">Paraf</th>
            </tr>
            <tr style="height: 190px;">
                @foreach (\App\Models\FormChecklistPc\FormChecklistPc::CHECKLIST_ITEMS as $key => $label)
                    <th class="col-chk vert-cell"><span class="vert-label">{{ $label }}</span></th>
                @endforeach
            </tr>
            <tr class="num-row">
                @foreach (\App\Models\FormChecklistPc\FormChecklistPc::CHECKLIST_ITEMS as $key => $label)
                    <th>{{ $key }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php
                $items = $form_checklist_pc->items;
                $symbol = ['ok' => 'v', 'tidak' => 'x', 'na' => ''];
            @endphp
            @foreach ($items as $i => $item)
                @php $checklist = $item->checklist ?? []; @endphp
                <tr style="height: 22px;">
                    <td>{{ $i + 1 }}</td>
                    <td class="data-cell-left">{{ $item->nama_aset ?? '' }}</td>
                    <td class="data-cell-left">{{ $item->id_aset ?? '' }}</td>
                    <td class="data-cell-left">{{ $item->nipp ?? '' }}</td>
                    @foreach (\App\Models\FormChecklistPc\FormChecklistPc::CHECKLIST_ITEMS as $key => $label)
                        @php $chkVal = $checklist[$key] ?? 'na'; @endphp
                    <td class="chk-{{ $chkVal }}">{{ $symbol[$chkVal] ?? '' }}</td>
                    @endforeach
                    <td class="data-cell-left">{{ $item->paraf ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- KETERANGAN & ANALISA (table 2 kolom, bukan flexbox, supaya kompatibel dompdf) --}}
    <table class="bottom-table">
        <tr>
            <td class="col-left">
                <div class="keterangan-box">
                    <strong>Keterangan:</strong>
                    <ul>
                        <li>point checklist 2 mencakup: .tmp, .chk, file dengan tanda ~</li>
                        <li>point checklist 3 mencakup: file .zip &amp; draft yg tidak lagi digunakan, konfirmasikan terlebih dahulu kepada pengguna</li>
                        <li>point checklist 4: lakukan defragment HDD hanya jika diperlukan</li>
                        <li>point checklist 14 mencakup: display port, HDMI port, USB port</li>
                        <li>point checklist 15 mencakup: keyboard, trackpad, numerik pads, panel kontrol</li>
                    </ul>
                </div>
            </td>
            <td class="col-right">
                <div class="analisa-wrap">
                    <span class="analisa-title">Analisa dan Kesimpulan Hasil Pemeriksaan :</span>
                    <div class="analisa-box">
                        {{ $form_checklist_pc->analisa_kesimpulan ?: '(uraian mengenai hasil analisa dari pemeriksaan aset, beserta kesimpulan)' }}
                    </div>
                </div>
            </td>
        </tr>
    </table>

    {{-- TANDA TANGAN --}}
    <table class="signature-table">
        <tr>
            <td class="sig-cell" style="width:62%;">
                <div class="sig-title">PELAKSANA PEMERIKSAAN</div>
                <div class="sig-body-signer">
                    (<span class="sig-name">{{ $form_checklist_pc->pelaksana_name ?: '' }}</span>)
                </div>
            </td>
            <td class="sig-cell" style="width:38%;">
                <div class="sig-title">TANGGAL PEMERIKSAAN</div>
                <div class="sig-body">
                    <span class="sig-name">{{ $form_checklist_pc->tanggal_pemeriksaan ? \Carbon\Carbon::parse($form_checklist_pc->tanggal_pemeriksaan)->locale('id')->isoFormat('D MMMM Y') : '' }}</span>
                </div>
            </td>
        </tr>
    </table>
    </div>
</body>
</html>