<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checklist Pemantauan APAR — {{ $form_apar->no_ref ?: 'Formulir' }}</title>
    <link rel="icon" href="{{ asset('images/favicon.svg') }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 10px; background-color: #525659; padding: 20px; display: flex; flex-direction: column; align-items: center; color: black; }
        
        /* A4 Page container (Landscape) */
        .a4-page { 
            width: 297mm; 
            height: 210mm; 
            background: white; 
            padding: 12mm 15mm; 
            box-sizing: border-box; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.2); 
            margin-bottom: 20px;
            position: relative; 
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        
        table { border-collapse: collapse; width: 100%; }

        /* Kop Surat */
        .header-table td { border: 1px solid black; padding: 4px 6px; vertical-align: middle; }
        .title-text { font-size: 11px; font-weight: bold; text-align: center; }
        .terbatas-box { border: 2px solid #eab308; color: #eab308; padding: 4px 14px; font-weight: bold; font-size: 13px; display: inline-block; }

        /* Info Section (Added gap below kop surat) */
        .info-table { width: 28%; border-collapse: collapse; margin-top: 12px; margin-bottom: 4px; }
        .info-table td { border: 1px solid black; padding: 3px 5px; font-size: 10px; }
        .kolom-label { width: 95px; font-weight: bold; }

        /* Bulan separated below info table */
        .bulan-container { margin-top: 8px; font-size: 10px; font-weight: bold; display: flex; align-items: center; }

        /* Main Table */
        .main-table { margin-top: 10px; table-layout: fixed; }
        .main-table th, .main-table td { border: 1px solid black; padding: 3px 4px; font-size: 9px; vertical-align: middle; word-wrap: break-word; }
        .main-table th { text-align: center; background-color: #f1f5f9; font-weight: bold; font-size: 8.5px; }
        .sub-header { font-weight: normal; font-size: 7.5px; display: block; margin-top: 2px; color: #374151; }
        .text-center { text-align: center; }

        /* Catatan */
        .catatan-box { border: 1px solid black; padding: 6px; font-size: 9.5px; }

        /* Print tools */
        .no-print { margin-bottom: 18px; display: flex; justify-content: flex-end; gap: 8px; align-items: center; width: 297mm; }
        .btn-kembali { width: 100px; height: 34px; line-height: 34px; padding: 0; background-color: #f44336; color: white; border: none; cursor: pointer; border-radius: 4px; font-weight: bold; font-family: inherit; font-size: 13px; text-decoration: none; text-align: center; box-sizing: border-box; display: inline-block; transition: background-color 0.2s; }
        .btn-kembali:hover { background-color: #d32f2f; }
        .btn-print { width: 100px; height: 34px; line-height: 34px; padding: 0; background-color: #4CAF50; color: white; border: none; cursor: pointer; border-radius: 4px; font-weight: bold; font-family: inherit; font-size: 13px; text-align: center; box-sizing: border-box; display: inline-block; transition: background-color 0.2s; }
        .btn-print:hover { background-color: #388e3c; }
        @if($form_apar->isDicetak())
        .btn-confirm { width: 160px; height: 34px; line-height: 34px; padding: 0; background-color: #7c3aed; color: white; border: none; cursor: pointer; border-radius: 4px; font-weight: bold; font-family: inherit; font-size: 13px; text-align: center; box-sizing: border-box; display: inline-block; transition: background-color 0.2s; }
        .btn-confirm:hover { background-color: #6d28d9; }
        @endif

        .print-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        @page {
            size: A4 landscape;
            margin: 0mm; /* Hides default browser header/footer text */
        }

        /* Print Media Styles (Landscape) */
        @media print {
            @page {
                size: A4 landscape;
                margin: 0mm;
            }
            html, body {
                width: 297mm;
                height: auto;
                margin: 0 !important;
                padding: 0 !important;
                background-color: white;
                display: block !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .print-container {
                display: block !important;
                width: 297mm;
                margin: 0 !important;
                padding: 0 !important;
            }
            .a4-page {
                width: 297mm;
                height: 210mm;
                padding: 12mm 15mm !important;
                margin: 0 auto !important;
                box-shadow: none;
                page-break-inside: avoid;
                page-break-after: always;
                box-sizing: border-box;
            }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
<div class="print-container">
    {{-- Toolbar --}}
    <div class="no-print">
        <a href="{{ route('form-apar.index') }}" class="btn-kembali">Kembali</a>
        @if($form_apar->isDicetak())
        <form method="POST" action="{{ route('form-apar.confirm', $form_apar) }}" style="display:inline;">
            @csrf @method('PATCH')
            <button type="submit" class="btn-confirm">✓ Konfirmasi Selesai</button>
        </form>
        @endif
    </div>

    {{-- HALAMAN 1 (DEPAN) --}}
    <div class="a4-page">
        {{-- KOP SURAT --}}
        <table class="header-table">
            <tr>
                <td rowspan="2" style="width:14%; text-align:center;">
                    <img src="{{ asset('images/logo-kai.svg') }}" alt="KAI" style="max-width:100%; max-height:42px;">
                </td>
                <td rowspan="2" class="title-text" style="width:42%;">
                    PT KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI
                </td>
                <td style="width:13%;">Nomor</td>
                <td style="width:21%; font-family: monospace; font-weight: bold;">: FR.SM/TI/015.007/10-2020</td>
            </tr>
            <tr>
                <td>Tanggal Terbit</td>
                <td>: 12 Oktober 2020</td>
            </tr>
            <tr>
                <td rowspan="2" style="text-align:center; padding: 2px;">
                    <div class="terbatas-box">TERBATAS</div>
                </td>
                <td rowspan="2" class="title-text">FORMULIR CHECKLIST PEMANTAUAN APAR</td>
                <td>Status Revisi</td>
                <td>: 002-2020</td>
            </tr>
            <tr>
                <td>Halaman</td>
                <td>: 1 dari 1</td>
            </tr>
        </table>

        {{-- INFO SECTION (With spacing gap) --}}
        <div>
            <table class="info-table">
                <tr><td class="kolom-label">No Ref</td><td style="font-family: monospace; font-weight: bold;">: {{ $form_apar->no_ref ?: '___________________________' }}</td></tr>
                <tr><td class="kolom-label">Tanggal</td><td>: {{ $form_apar->tanggal ? \Carbon\Carbon::parse($form_apar->tanggal)->locale('id')->isoFormat('D MMMM Y') : '___________________________' }}</td></tr>
                <tr><td class="kolom-label">Business Area</td><td>: {{ $form_apar->business_area ?: 'B060' }}</td></tr>
            </table>
            
            {{-- Bulan separated from the info-table --}}
            <div class="bulan-container">
                <span style="width: 95px; display: inline-block;">Bulan</span>
                <span>: </span>
                <span style="font-weight: normal; border-bottom: 1px dotted black; display: inline-block; width: 180px; padding-left: 5px; margin-left: 2px;">{{ $form_apar->bulan ?: '..................................................' }}</span>
            </div>
        </div>

        {{-- TABEL UTAMA --}}
        <table class="main-table">
            <thead>
                <tr>
                    <th rowspan="2" style="width:3%;">No.</th>
                    <th rowspan="2" style="width:8%;">Kode/ID Aset<br><span class="sub-header">(nomor ID aset APAR)</span></th>
                    <th rowspan="2" style="width:7%;">Merk<br><span class="sub-header">(merk dari APAR)</span></th>
                    <th rowspan="2" style="width:7%;">Tipe<br><span class="sub-header">(tipe dari APAR)</span></th>
                    <th rowspan="2" style="width:9%;">Media Pemadam<br><span class="sub-header">(Air/Busa/Serbuk/CO2/Halon Free)</span></th>
                    <th rowspan="2" style="width:6%;">Kapasitas<br><span class="sub-header">(Kg)</span></th>
                    <th rowspan="2" style="width:10%;">Lokasi<br><span class="sub-header">(tempat keberadaan APAR)</span></th>
                    <th colspan="2" style="width:12%;">Waktu Pengecekkan</th>
                    <th rowspan="2" style="width:7%;">Tgl. Isi Ulang<br><span class="sub-header">(tanggal isi ulang terakhir)</span></th>
                    <th rowspan="2" style="width:7%;">Tgl. Kadaluarsa<br><span class="sub-header">(tanggal kadaluarsa)</span></th>
                    <th rowspan="2" style="width:7%;">Indikator Tekanan Gas<br><span class="sub-header">(Hijau/Merah)</span></th>
                    <th rowspan="2" style="width:9%;">Perlakuan Fisik<br><span class="sub-header">(terawat / tidak, digantung / di bawah, dll)</span></th>
                    <th rowspan="2" style="width:9%;">Tindak Lanjut<br><span class="sub-header">(tindak lanjut yang dilakukan jika tidak sesuai)</span></th>
                    <th rowspan="2" style="width:5%;">Paraf Petugas</th>
                </tr>
                <tr>
                    <th style="width:6%;">Tgl.<br><span class="sub-header">(tanggal pengecekan)</span></th>
                    <th style="width:6%;">Jam<br><span class="sub-header">(jam pengecekan)</span></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $items = $form_apar->items;
                    $total = max(10, $items->count());
                @endphp
                @for ($i = 0; $i < $total; $i++)
                    @php $item = $items->get($i); @endphp
                    <tr style="height: 20px;">
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td class="text-center font-mono font-semibold">{{ $item?->apar?->kode_aset ?? '' }}</td>
                        <td class="text-center">{{ $item?->apar?->merk ?? '' }}</td>
                        <td class="text-center">{{ $item?->apar?->tipe ?? '' }}</td>
                        <td class="text-center">{{ $item?->apar?->media ?? '' }}</td>
                        <td class="text-center">{{ $item?->apar?->kapasitas ?? '' }}</td>
                        <td>{{ $item?->apar?->lokasi ?? '' }}</td>
                        <td class="text-center">
                            @if($item?->waktu_pengecekan_tgl)
                                {{ \Carbon\Carbon::parse($item->waktu_pengecekan_tgl)->format('d/m/y') }}
                            @endif
                        </td>
                        <td class="text-center">
                            {{ $item?->waktu_pengecekan_jam ?: '' }}
                        </td>
                        <td class="text-center">{{ $item?->apar?->tanggal_isi_ulang ? $item->apar->tanggal_isi_ulang->format('d/m/y') : '' }}</td>
                        <td class="text-center font-semibold text-red-600">{{ $item?->apar?->tanggal_kadaluarsa ? $item->apar->tanggal_kadaluarsa->format('d/m/y') : '' }}</td>
                        <td class="text-center">
                            @if($item?->indikator_tekanan === 'Hijau')
                                <span style="color: green; font-weight: bold;">Hijau (V)</span>
                            @elseif($item?->indikator_tekanan === 'Merah')
                                <span style="color: red; font-weight: bold;">Merah (X)</span>
                            @endif
                        </td>
                        <td>{{ $item?->perlakuan_fisik ?? '' }}</td>
                        <td>{{ $item?->tindak_lanjut ?? '' }}</td>
                        <td class="text-center">{{ $item?->paraf ?? '' }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>

        {{-- CATATAN & TANDA TANGAN HALAMAN DEPAN (BERSEBELAHAN) --}}
        <table style="width: 100%; margin-top: 15px; border: none;">
            <tr>
                {{-- Kiri: Catatan --}}
                <td style="width: 60%; border: none; vertical-align: top; padding-right: 20px;">
                    <div class="catatan-box" style="min-height: 80px; width: 100%;">
                        <strong>Catatan :</strong> {{ $form_apar->catatan ?: '(catatan mengenai pelaksanaan pengecekan APAR, jika ada)' }}
                    </div>
                </td>
                
                {{-- Kanan: Mengetahui Pejabat 1 --}}
                <td style="width: 40%; border: none; text-align: center; vertical-align: top;">
                    <div style="width: 250px; margin: 0 auto; text-align: left; font-size: 10px; line-height: 1.5;">
                        <p style="text-align: center; margin-bottom: 0;">Mengetahui,</p>
                        <p style="text-align: center; margin-bottom: 0; min-height: 15px; font-weight: normal;">{{ $form_apar->mengetahui?->jabatan ?: '..................................................' }}</p>
                        <div style="height: 50px;"></div>
                        <div style="text-align: center; font-weight: bold; border-bottom: 1px solid black; padding-bottom: 2px; width: 220px; margin: 0 auto;">
                            {{ $form_apar->mengetahui?->nama ?: '' }}
                        </div>
                        <p style="text-align: center; margin-top: 5px; margin-bottom: 0;">NIPP. {{ $form_apar->mengetahui?->nipp ?: '..................................................' }}</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- HALAMAN 2 (BELAKANG) --}}
    <div class="a4-page">
        {{-- TANDA TANGAN HALAMAN BELAKANG (DENGAN KETERANGAN SEJAJAR DI KIRI) --}}
        <table style="width: 100%; border: none; margin-top: 10px;">
            <tr>
                {{-- Kiri: Keterangan --}}
                <td style="width: 25%; border: none; vertical-align: top;">
                    <div style="font-size: 11px; font-weight: bold; margin-bottom: 12px;">Keterangan :</div>
                    <div style="font-size: 10px; line-height: 1.8;">
                        V : Kondisi Baik<br>
                        X : Kondisi Kurang Baik
                    </div>
                </td>
                
                {{-- Tengah: Mengetahui Pejabat 2 --}}
                <td style="width: 37.5%; border: none; text-align: center; vertical-align: top;">
                    <div style="width: 240px; margin: 0 auto; text-align: left; font-size: 10px; line-height: 1.5;">
                        <p style="text-align: center; margin-bottom: 0;">Mengetahui,</p>
                        <p style="text-align: center; margin-bottom: 0; min-height: 15px;">{{ $form_apar->mengetahui2?->jabatan ?: '..................................................' }}</p>
                        <div style="height: 60px;"></div>
                        <div style="text-align: center; font-weight: bold; border-bottom: 1px solid black; padding-bottom: 2px; width: 200px; margin: 0 auto;">
                            {{ $form_apar->mengetahui2?->nama ?: '' }}
                        </div>
                        <p style="text-align: center; margin-top: 5px; margin-bottom: 0;">NIPP. {{ $form_apar->mengetahui2?->nipp ?: '..................................................' }}</p>
                    </div>
                </td>
                
                {{-- Kanan: Petugas --}}
                <td style="width: 37.5%; border: none; text-align: center; vertical-align: top;">
                    <div style="width: 240px; margin: 0 auto; text-align: left; font-size: 10px; line-height: 1.5;">
                        <p style="text-align: center; margin-bottom: 0;">
                            Yogyakarta, {{ $form_apar->tanggal ? \Carbon\Carbon::parse($form_apar->tanggal)->locale('id')->isoFormat('D MMMM Y') : '..................................................' }}
                        </p>
                        <p style="text-align: center; margin-bottom: 0; min-height: 15px;">Petugas,</p>
                        <div style="height: 60px;"></div>
                        <div style="text-align: center; font-weight: bold; border-bottom: 1px solid black; padding-bottom: 2px; width: 200px; margin: 0 auto;">
                            {{ $form_apar->petugas_name ?: '' }}
                        </div>
                        <p style="text-align: center; margin-top: 5px; margin-bottom: 0;">NIPP. {{ $form_apar->petugas_nipp ?: '..................................................' }}</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
