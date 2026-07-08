<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checklist Pemeliharaan — {{ $form->no_ref }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 10px; background: white; color: black; }
        page { display: block; width: 297mm; min-height: 210mm; padding: 12mm 15mm; page-break-after: always; }
        table { border-collapse: collapse; width: 100%; }

        /* Kop Surat */
        .header-table td { border: 1px solid black; padding: 4px 6px; vertical-align: middle; }
        .title-text { font-size: 11px; font-weight: bold; text-align: center; }
        .terbatas-box { border: 2px solid #eab308; color: #eab308; padding: 3px 12px; font-weight: bold; font-size: 12px; display: inline-block; }

        /* Info Section */
        .info-table { width: 35%; border-collapse: collapse; margin-bottom: 5px; }
        .info-table td { border: 1px solid black; padding: 2px 4px; }
        .kolom-label { width: 85px; font-weight: bold; }

        .info-text-table { width: 100%; border: none; margin-top: 5px; }
        .info-text-table td { border: none; padding: 2px 0; vertical-align: top; }
        .label-cell { width: 120px; font-weight: bold; }
        .colon-cell { width: 15px; }

        /* Main Table */
        .main-table { margin-top: 5px; }
        .main-table th, .main-table td { border: 1px solid black; padding: 4px 3px; font-size: 9px; vertical-align: middle; }
        .main-table th { text-align: center; background-color: #b0c4de; font-weight: bold; }
        .sub-header { font-weight: normal; font-size: 7.5px; display: block; margin-top: 2px; }
        .text-center { text-align: center; }

        /* Catatan */
        .catatan-box { border: 1px solid black; padding: 5px; margin-top: 10px; min-height: 35px; font-size: 9px; }

        /* Keterangan Bawah */
        .keterangan-bawah { margin-top: 20px; font-size: 9px; }

        @page { size: A4 landscape; margin: 0mm; }
    </style>
</head>
<body>
<page>
    {{-- KOP SURAT --}}
    <table class="header-table">
        <tr>
            <td rowspan="2" style="width:14%; text-align:center;">
                <img src="{{ public_path('images/logo-kai.svg') }}" alt="KAI" style="max-width:100%; max-height:45px;">
            </td>
            <td rowspan="2" class="title-text" style="width:40%;">
                PT KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI
            </td>
            <td style="width:13%;">Nomor</td>
            <td style="width:22%;">: FR.SM/TI/015.005/10-2020</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>: 12 Oktober 2020</td>
        </tr>
        <tr>
            <td rowspan="2" style="text-align:center;">
                <div class="terbatas-box">TERBATAS</div>
            </td>
            <td rowspan="2" class="title-text">FORMULIR CHECKLIST PEMELIHARAAN PERANGKAT JARINGAN</td>
            <td>Versi</td>
            <td>: 002-2020</td>
        </tr>
        <tr>
            <td>Halaman</td>
            <td>: 2 dari 2</td>
        </tr>
    </table>

    {{-- INFO SECTION --}}
    <div style="margin: 15px 0;">
        <table class="info-table">
            <tr><td class="kolom-label">No. Ref</td><td>: {{ $form->no_ref ?: '___________________________' }}</td></tr>
            <tr><td class="kolom-label">Tanggal</td><td>: {{ $form->tanggal ? $form->tanggal->translatedFormat('d F Y') : '___________________________' }}</td></tr>
            <tr><td class="kolom-label">Business Area</td><td>: {{ $form->business_area ?: '___________________________' }}</td></tr>
        </table>

        <table class="info-text-table">
            <tr>
                <td class="label-cell">Petugas</td>
                <td class="colon-cell">:</td>
                <td style="width: 35%;">{{ $form->petugas_name ?: '(pelaksana pemeliharaan)' }}</td>

                <td class="label-cell" style="width: 140px;">Jenis Pemeliharaan</td>
                <td class="colon-cell">:</td>
                <td>
                    @if(($form->jenis_pemeliharaan ?? '') === 'Terencana')
                        Terencana / <s>Tak Terencana</s>
                    @elseif(($form->jenis_pemeliharaan ?? '') === 'Tak Terencana')
                        <s>Terencana</s> / Tak Terencana
                    @else
                        Terencana / Tak Terencana (*)
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label-cell">Lokasi</td>
                <td class="colon-cell">:</td>
                <td>{{ $form->lokasi ?: '(tempat keberadaan aset)' }}</td>

                <td class="label-cell">Bulan</td>
                <td class="colon-cell">:</td>
                <td>{{ $form->bulan_pemeliharaan ?: '(bulan waktu pemeliharaan)' }}</td>
            </tr>
        </table>
    </div>

    {{-- TABEL UTAMA --}}
    <table class="main-table">
        <thead>
            <tr>
                <th style="width:3%;">NO</th>
                <th style="width:12%;">JENIS PERANGKAT<br><span class="sub-header">(jenis / nama<br>perangkat jaringan)</span></th>
                <th style="width:12%;">KODE / ID PERANGKAT<br><span class="sub-header">(nomor ID aset<br>perangkat jaringan)</span></th>
                <th style="width:15%;">DESKRIPSI PERANGKAT<br><span class="sub-header">(deskripsi / spesifikasi dari<br>perangkat jaringan)</span></th>
                <th style="width:16%;">PEKERJAAN<br><span class="sub-header">(tindakan yang dilakukan<br>untuk pemeliharaan<br>perangkat jaringan)</span></th>
                <th style="width:14%;">PERMASALAHAN<br><span class="sub-header">(permasalahan yang dialami<br>oleh perangkat jaringan, jika<br>ada)</span></th>
                <th style="width:14%;">SOLUSI<br><span class="sub-header">(tindakan yang dilakukan<br>untuk memperbaiki<br>perangkat jaringan, jika ada)</span></th>
                <th style="width:14%;">KETERANGAN<br><span class="sub-header">(keterangan lebih<br>lanjut, jika ada)</span></th>
            </tr>
        </thead>
        <tbody>
            @php
                $items = $form->items;
                $total = max(10, $items->count());
            @endphp
            @for ($i = 0; $i < $total; $i++)
                @php $item = $items->get($i); @endphp
                <tr style="height: 18px;">
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td class="text-center">{{ $item?->perangkat?->jenis_perangkat ?? '' }}</td>
                    <td class="text-center">{{ $item?->perangkat?->kode_aset ?? '' }}</td>
                    <td class="text-center">{{ $item?->perangkat?->deskripsi ?? '' }}</td>
                    <td>{{ $item?->pekerjaan ?? '' }}</td>
                    <td>{{ $item?->permasalahan ?? '' }}</td>
                    <td>{{ $item?->solusi ?? '' }}</td>
                    <td>{{ $item?->keterangan ?? '' }}</td>
                </tr>
            @endfor
        </tbody>
    </table>

    {{-- CATATAN --}}
    <div class="catatan-box">
        <strong>Catatan :</strong> {{ $form->catatan ?: '(catatan mengenai pelaksanaan pemeliharaan perangkat jaringan, jika ada)' }}
    </div>

    {{-- TANDA TANGAN --}}
    <table style="width: 100%; margin-top: 25px; border: none;">
        <tr>
            <td style="width: 50%; text-align: center; border: none;">
                <div style="width: 220px; margin: 0 auto; text-align: left;">
                    <p>Petugas,</p>
                    <div style="height: 50px;"></div>
                    <div style="text-align: center; font-weight: bold; margin-bottom: 2px;">{{ $form->petugas_name ?: '' }}</div>
                    <div style="border-bottom: 1px dotted black; width: 100%; margin-bottom: 2px;"></div>
                    <p>NIPP. <span style="display:inline-block; border-bottom: 1px dotted black; width: 185px; text-align: center;">{{ $form->petugas_nipp ?: '' }}</span></p>
                </div>
            </td>
            <td style="width: 50%; text-align: center; border: none;">
                <div style="width: 220px; margin: 0 auto; text-align: left;">
                    <p>Mengetahui,</p>
                    <div style="height: 50px;"></div>
                    <div style="text-align: center; font-weight: bold; margin-bottom: 2px;">{{ $form->mengetahui?->nama ?: '' }}</div>
                    <div style="border-bottom: 1px dotted black; width: 100%; margin-bottom: 2px;"></div>
                    <p>NIPP. <span style="display:inline-block; border-bottom: 1px dotted black; width: 185px; text-align: center;">{{ $form->mengetahui?->nipp ?: '' }}</span></p>
                </div>
            </td>
        </tr>
    </table>

    <div class="keterangan-bawah">
        <strong>Keterangan :</strong><br>
        (*) Coret yang tidak perlu
    </div>
</page>
</body>
</html>
