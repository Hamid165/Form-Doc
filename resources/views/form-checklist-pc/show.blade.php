<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checklist PC-Notebook-Printer — {{ $form_checklist_pc->no_ref }}</title>
    <link rel="icon" href="{{ asset('images/favicon.svg') }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 10px; background-color: #525659; color: black; }

        /* Wrapper: yang di-scroll horizontal, BUKAN body-nya.
           Ini mencegah elemen "mencelat"/geser saat lebar layar < 420mm. */
        .page-wrapper { width: 100%; overflow-x: auto; padding: 20px; }
        .a4-container { width: 420mm; min-height: 210mm; background: white; padding: 10mm 12mm; box-sizing: border-box; box-shadow: 0 4px 8px rgba(0,0,0,0.2); margin: 0 auto; }
        table { border-collapse: collapse; width: 100%; }

        /* Kop Surat */
        .header-table td { border: 1px solid black; padding: 4px 6px; vertical-align: middle; }
        .title-text { font-size: 12px; font-weight: bold; text-align: center; }
        .terbatas-box { border: 2px solid #eab308; color: #eab308; padding: 4px 14px; font-weight: bold; font-size: 13px; display: inline-block; }

        /* Info Section (No.Ref / Tanggal / Business Area) */
        .info-table { width: 30%; border-collapse: collapse; margin: 8px 0; }
        .info-table td { border: 1px solid black; padding: 3px 6px; font-size: 10px; }
        .info-table .kolom-label { width: 100px; font-weight: bold; }

        /* Main Table */
        .main-table { table-layout: fixed; }
        .main-table th, .main-table td { border: 1px solid black; padding: 2px 3px; font-size: 9px; vertical-align: middle; text-align: center; word-wrap: break-word; }
        .main-table thead th { background-color: #b0c4de; font-weight: bold; }
        .chk-ok { color: #16a34a; font-weight: bold; }
        .chk-tidak { color: #dc2626; font-weight: bold; }
        .group-header { font-size: 10px; }
        /* Sel header kolom: kotak LURUS biasa (border normal di semua sisi),
           teksnya saja yang diputar tegak lurus (vertikal), bukan kotaknya. */
        .vert-cell {
            height: 170px;
            padding: 0;
            vertical-align: bottom;
        }
        /* Div pembungkus terpisah dari <th> — <th> dengan overflow:hidden tidak selalu
           mengkliping konten anak di semua browser, sehingga label bisa "bocor"
           ke kolom sebelah. Div block biasa jauh lebih konsisten untuk ini. */
        .vert-clip { position: relative; width: 100%; height: 170px; overflow: hidden; }
        .vert-cell .vert-label { position: absolute; bottom: 4px; left: 50%; white-space: nowrap; font-size: 7px; font-weight: normal; transform: rotate(-90deg); transform-origin: left bottom; }
        .num-row th { font-size: 9px; height: 16px; }
        .col-no { width: 4.5%; }
        .col-aset { width: 13%; }
        .col-idaset { width: 8%; }
        .col-nipp { width: 9%; }
        .col-chk { width: 2.7%; }
        .col-paraf { width: 8.5%; }
        .data-cell-left { text-align: left; }

        /* Keterangan */
        .bottom-section { display: flex; gap: 20px; margin-top: 10px; align-items: flex-start; }
        .keterangan-box { flex: 1; font-size: 9px; line-height: 1.5; }
        .keterangan-box ul { margin-left: 16px; }
        .analisa-wrap { flex: 1; font-size: 10px; }
        .analisa-wrap .analisa-title { display: block; font-weight: bold; text-transform: uppercase; margin-bottom: 4px; }
        .analisa-box { border: 1px solid black; padding: 6px; min-height: 80px; font-size: 10px; }

        /* Tanda tangan */
        .signature-table { width: 45%; margin-top: 20px; border-collapse: collapse; }
        .signature-table td.sig-cell { border: 1px solid black; padding: 6px; vertical-align: top; font-size: 10px; height: 90px; }
        .signature-table .sig-title { font-weight: bold; text-align: left; text-transform: uppercase; }
        .signature-table .sig-body { text-align: center; margin-top: 40px; }
        .signature-table .sig-name { border-bottom: 1px dotted black; display:inline-block; min-width: 160px; padding-bottom: 2px; font-weight: bold; }

        /* Print tools */
        .no-print { margin-bottom: 18px; display: flex; justify-content: flex-end; gap: 8px; align-items: center; width: 100%; }
        .btn-kembali { width: 100px; height: 34px; line-height: 34px; padding: 0; background-color: #f44336; color: white; border: none; cursor: pointer; border-radius: 4px; font-weight: bold; font-family: inherit; font-size: 13px; text-decoration: none; text-align: center; box-sizing: border-box; display: inline-block; transition: background-color 0.2s; }
        .btn-kembali:hover { background-color: #d32f2f; }
        .btn-print { width: 100px; height: 34px; line-height: 34px; padding: 0; background-color: #4CAF50; color: white; border: none; cursor: pointer; border-radius: 4px; font-weight: bold; font-family: inherit; font-size: 13px; text-align: center; box-sizing: border-box; display: inline-block; transition: background-color 0.2s; }
        .btn-print:hover { background-color: #388e3c; }
        @if($form_checklist_pc->isDicetak())
        .btn-confirm { width: 160px; height: 34px; line-height: 34px; padding: 0; background-color: #7c3aed; color: white; border: none; cursor: pointer; border-radius: 4px; font-weight: bold; font-family: inherit; font-size: 13px; text-align: center; box-sizing: border-box; display: inline-block; transition: background-color 0.2s; }
        .btn-confirm:hover { background-color: #6d28d9; }
        @endif

        @media print {
            body { margin: 0; padding: 0; background-color: white; }
            .a4-container { box-shadow: none; width: 100%; min-height: auto; padding: 0; }
            .no-print { display: none !important; }
        }
        @page { size: A3 landscape; margin: 10mm 12mm; }
    </style>
</head>
<body>
<div class="page-wrapper">
    {{-- Toolbar --}}
    <div class="no-print" style="width: 420mm; margin: 0 auto 18px;">
        <a href="{{ route('form-checklist-pc.index') }}" class="btn-kembali">Kembali</a>
        <a href="{{ route('form-checklist-pc.edit', $form_checklist_pc) }}" class="btn-kembali" style="background-color:#f59e0b;">Edit</a>
        @if($form_checklist_pc->isDicetak())
        <form method="POST" action="{{ route('form-checklist-pc.confirm', $form_checklist_pc) }}" style="display:inline;">
            @csrf @method('PATCH')
            <button type="submit" class="btn-confirm">✓ Konfirmasi Selesai</button>
        </form>
        @endif
        <a href="{{ route('form-checklist-pc.pdf', $form_checklist_pc) }}" target="_blank" class="btn-print" style="text-decoration:none;">📄 Download PDF</a>
    </div>

    <div class="a4-container">
        {{-- KOP SURAT --}}
        <table class="header-table">
            <tr>
                <td rowspan="2" style="width:10%; text-align:center;">
                    <img src="{{ asset('images/logo-kai.svg') }}" alt="KAI" style="max-width:100%; max-height:50px;">
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
                <tr>
                    @foreach (\App\Models\FormChecklistPc\FormChecklistPc::CHECKLIST_ITEMS as $key => $label)
                        <th class="col-chk vert-cell"><div class="vert-clip"><span class="vert-label">{{ $label }}</span></div></th>
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
                    <tr style="height: 20px;">
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

        {{-- KETERANGAN & ANALISA --}}
        <div class="bottom-section">
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
            <div class="analisa-wrap">
                <span class="analisa-title">Analisa dan Kesimpulan Hasil Pemeriksaan :</span>
                <div class="analisa-box">
                    {{ $form_checklist_pc->analisa_kesimpulan ?: '(uraian mengenai hasil analisa dari pemeriksaan aset, beserta kesimpulan)' }}
                </div>
            </div>
        </div>

        {{-- TANDA TANGAN --}}
        <table class="signature-table">
            <tr>
                <td class="sig-cell" style="width:50%;">
                    <div class="sig-title">PELAKSANA PEMERIKSAAN</div>
                    <div class="sig-body">
                        (<span class="sig-name">{{ $form_checklist_pc->pelaksana_name ?: '' }}</span>)
                    </div>
                </td>
                <td class="sig-cell" style="width:50%;">
                    <div class="sig-title">TANGGAL PEMERIKSAAN</div>
                    <div class="sig-body">
                        <span class="sig-name">{{ $form_checklist_pc->tanggal_pemeriksaan ? \Carbon\Carbon::parse($form_checklist_pc->tanggal_pemeriksaan)->locale('id')->isoFormat('D MMMM Y') : '' }}</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>