<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checklist Pemeliharaan — {{ $form_pemeliharaan->no_ref }}</title>
    <link rel="icon" href="{{ asset('images/favicon.svg') }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 11px; background-color: #525659; padding: 20px; display: flex; justify-content: center; color: black; }
        .a4-container { width: 297mm; min-height: 210mm; background: white; padding: 12mm 15mm; box-sizing: border-box; box-shadow: 0 4px 8px rgba(0,0,0,0.2); }
        table { border-collapse: collapse; width: 100%; }

        /* Kop Surat */
        .header-table td { border: 1px solid black; padding: 4px 6px; vertical-align: middle; }
        .title-text { font-size: 11px; font-weight: bold; text-align: center; }
        .terbatas-box { border: 2px solid #eab308; color: #eab308; padding: 4px 14px; font-weight: bold; font-size: 13px; display: inline-block; }

        /* Info Section */
        .info-table { width: 35%; border-collapse: collapse; margin-bottom: 5px; }
        .info-table td { border: 1px solid black; padding: 3px 5px; }
        .kolom-label { width: 95px; font-weight: bold; }

        .info-text-table { width: 100%; border: none; margin-top: 5px; }
        .info-text-table td { border: none; padding: 3px 0; vertical-align: top; }
        .label-cell { width: 130px; font-weight: bold; }
        .colon-cell { width: 15px; }

        /* Main Table */
        .main-table { margin-top: 10px; }
        .main-table th, .main-table td { border: 1px solid black; padding: 4px 5px; font-size: 10px; vertical-align: middle; }
        .main-table th { text-align: center; background-color: #b0c4de; font-weight: bold; }
        .sub-header { font-weight: normal; font-size: 8px; display: block; margin-top: 2px; }
        .text-center { text-align: center; }

        /* Catatan */
        .catatan-box { border: 1px solid black; padding: 6px; margin-top: 12px; min-height: 40px; font-size: 10px; }

        /* Keterangan Bawah */
        .keterangan-bawah { margin-top: 25px; font-size: 10px; }

        /* Print tools */
        .no-print { margin-bottom: 18px; display: flex; justify-content: flex-end; gap: 8px; align-items: center; width: 100%; }
        .btn-kembali { width: 100px; height: 34px; line-height: 34px; padding: 0; background-color: #f44336; color: white; border: none; cursor: pointer; border-radius: 4px; font-weight: bold; font-family: inherit; font-size: 13px; text-decoration: none; text-align: center; box-sizing: border-box; display: inline-block; transition: background-color 0.2s; }
        .btn-kembali:hover { background-color: #d32f2f; }
        .btn-print { width: 100px; height: 34px; line-height: 34px; padding: 0; background-color: #4CAF50; color: white; border: none; cursor: pointer; border-radius: 4px; font-weight: bold; font-family: inherit; font-size: 13px; text-align: center; box-sizing: border-box; display: inline-block; transition: background-color 0.2s; }
        .btn-print:hover { background-color: #388e3c; }
        @if($form_pemeliharaan->isDicetak())
        .btn-confirm { width: 160px; height: 34px; line-height: 34px; padding: 0; background-color: #7c3aed; color: white; border: none; cursor: pointer; border-radius: 4px; font-weight: bold; font-family: inherit; font-size: 13px; text-align: center; box-sizing: border-box; display: inline-block; transition: background-color 0.2s; }
        .btn-confirm:hover { background-color: #6d28d9; }
        @endif

        @media print {
            body { margin: 0; padding: 0; background-color: white; }
            .a4-container { box-shadow: none; width: 100%; min-height: auto; padding: 0; }
            .no-print { display: none !important; }
        }
        @page { size: A4 landscape; margin: 12mm 15mm; }
    </style>
</head>
<body>
<div style="display: flex; flex-direction: column;">
    {{-- Toolbar --}}
    <div class="no-print">
        <a href="{{ route('form-pemeliharaan.index') }}" class="btn-kembali">Kembali</a>
        <a href="{{ route('form-pemeliharaan.edit', $form_pemeliharaan) }}" class="btn-kembali" style="background-color:#f59e0b;">Edit</a>
        @if($form_pemeliharaan->isDicetak())
        <form method="POST" action="{{ route('form-pemeliharaan.confirm', $form_pemeliharaan) }}" style="display:inline;">
            @csrf @method('PATCH')
            <button type="submit" class="btn-confirm">✓ Konfirmasi Selesai</button>
        </form>
        @endif
        <button onclick="window.print()" class="btn-print">🖨 Print</button>
    </div>

    <div class="a4-container">
        {{-- KOP SURAT --}}
        <table class="header-table">
            <tr>
                <td rowspan="2" style="width:14%; text-align:center;">
                    <img src="{{ asset('images/logo-kai.svg') }}" alt="KAI" style="max-width:100%; max-height:50px;">
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
                <td>: 1 dari 1</td>
            </tr>
        </table>

        {{-- INFO SECTION --}}
        <div style="margin: 15px 0;">
            <table class="info-table">
                <tr><td class="kolom-label">No. Ref</td><td>: {{ $form_pemeliharaan->no_ref ?: '___________________________' }}</td></tr>
                <tr><td class="kolom-label">Tanggal</td><td>: {{ $form_pemeliharaan->tanggal ? \Carbon\Carbon::parse($form_pemeliharaan->tanggal)->locale('id')->isoFormat('D MMMM Y') : '___________________________' }}</td></tr>
                <tr><td class="kolom-label">Business Area</td><td>: {{ $form_pemeliharaan->business_area ?: '___________________________' }}</td></tr>
            </table>

            <table class="info-text-table">
                <tr>
                    <td class="label-cell">Petugas</td>
                    <td class="colon-cell">:</td>
                    <td style="width: 35%;">{{ $form_pemeliharaan->petugas_name ?: '(pelaksana pemeliharaan)' }}</td>

                    <td class="label-cell" style="width: 140px;">Jenis Pemeliharaan</td>
                    <td class="colon-cell">:</td>
                    <td>
                        @if(($form_pemeliharaan->jenis_pemeliharaan ?? '') === 'Terencana')
                            Terencana / <s>Tak Terencana</s>
                        @elseif(($form_pemeliharaan->jenis_pemeliharaan ?? '') === 'Tak Terencana')
                            <s>Terencana</s> / Tak Terencana
                        @else
                            Terencana / Tak Terencana (*)
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="label-cell">Lokasi</td>
                    <td class="colon-cell">:</td>
                    <td>{{ $form_pemeliharaan->lokasi ?: '(tempat keberadaan aset)' }}</td>

                    <td class="label-cell">Bulan</td>
                    <td class="colon-cell">:</td>
                    <td>{{ $form_pemeliharaan->bulan_pemeliharaan ?: '(bulan waktu pemeliharaan)' }}</td>
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
                    $items = $form_pemeliharaan->items;
                    $total = max(10, $items->count());
                @endphp
                @for ($i = 0; $i < $total; $i++)
                    @php $item = $items->get($i); @endphp
                    <tr style="height: 22px;">
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td class="text-center">{{ $item?->perangkat?->jenis_perangkat ?? '' }}</td>
                        <td class="text-center">{{ $item?->perangkat?->kode_aset ?? '' }}</td>
                        <td>{{ $item?->deskripsi ?? '' }}</td>
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
            <strong>Catatan :</strong> {{ $form_pemeliharaan->catatan ?: '(catatan mengenai pelaksanaan pemeliharaan perangkat jaringan, jika ada)' }}
        </div>

        {{-- TANDA TANGAN --}}
        <table style="width: 100%; margin-top: 30px; border: none;">
            <tr>
                <td style="width: 50%; text-align: center; border: none;">
                    <div style="width: 220px; margin: 0 auto; text-align: left;">
                        <p>Petugas,</p>
                        <div style="height: 50px;"></div>
                        <div style="text-align: center; font-weight: bold; margin-bottom: 2px;">{{ $form_pemeliharaan->petugas_name ?: '' }}</div>
                        <div style="border-bottom: 1px dotted black; width: 100%; margin-bottom: 2px;"></div>
                        <p>NIPP. <span style="display:inline-block; border-bottom: 1px dotted black; width: 185px; text-align: center;">{{ $form_pemeliharaan->petugas_nipp ?: '' }}</span></p>
                    </div>
                </td>
                <td style="width: 50%; text-align: center; border: none;">
                    <div style="width: 220px; margin: 0 auto; text-align: left;">
                        <p>Mengetahui,</p>
                        <div style="height: 50px;"></div>
                        <div style="text-align: center; font-weight: bold; margin-bottom: 2px;">{{ $form_pemeliharaan->mengetahui?->nama ?: '' }}</div>
                        <div style="border-bottom: 1px dotted black; width: 100%; margin-bottom: 2px;"></div>
                        <p>NIPP. <span style="display:inline-block; border-bottom: 1px dotted black; width: 185px; text-align: center;">{{ $form_pemeliharaan->mengetahui?->nipp ?: '' }}</span></p>
                    </div>
                </td>
            </tr>
        </table>

        <div class="keterangan-bawah">
            <strong>Keterangan :</strong><br>
            (*) Coret yang tidak perlu
        </div>
    </div>
</div>
</body>
</html>
