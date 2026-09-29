<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Berita Acara Penutupan Tiket - {{ $bastik->nomor_surat }}</title>
    <style>
        @page {
            margin: 1.5cm 2cm 2.5cm 2cm;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #000000;
        }

        /* Page Counter using CSS Counters (bulletproof in DomPDF) */
        .page-counter:before {
            content: counter(page);
        }
        .page-total:before {
            content: counter(pages);
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        table.bordered th, table.bordered td {
            border: 0.5px solid #000000;
            padding: 8px;
            font-size: 10pt;
            vertical-align: top;
        }

        table.bordered th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        /* Repeat headers in tables crossing pages */
        thead {
            display: table-header-group;
        }

        tr {
            page-break-inside: avoid;
        }

        .title {
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 20px;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 25px;
        }

        /* Signatures block */
        .sig-block {
            margin-top: 30px;
            width: 100%;
        }

        .sig-block td {
            width: 50%;
            vertical-align: top;
        }

        /* Image grid on attachment page */
        .attachment-page {
            page-break-before: always;
        }

        .grid-container {
            width: 100%;
            margin-top: 20px;
        }

        .grid-cell {
            width: 31%;
            display: inline-block;
            border: 1px solid #cccccc;
            padding: 5px;
            margin-right: 1.5%;
            margin-bottom: 15px;
            text-align: center;
            background-color: #fafafa;
        }

        .attachment-img {
            max-width: 100%;
            height: 120px;
            object-fit: contain;
        }
    </style>
</head>
<body>

    <!-- Header content -->
    <!-- Header / Kop Table matching PDF exactly -->
    <!-- Header / Kop Formulir -->
<table style="
    width: 100%;
    margin: 0 0 12px 0;
    border-collapse: collapse;
    table-layout: fixed;
    border: 0.7px solid #000;
">
    <tr style="height: 31px;">
        <!-- Logo -->
        <td rowspan="2" style="
            width: 20%;
            text-align: center;
            vertical-align: middle;
            padding: 2px 4px;
            border: 0.7px solid #000;
        ">
            <img
                src="{{ public_path('images/logo-kai.svg') }}"
                alt="KAI Logo"
                style="width: 90px; height: auto;"
            >
        </td>

        <!-- Nama Instansi -->
        <td rowspan="2" style="
            width: 40%;
            text-align: center;
            vertical-align: middle;
            padding: 3px 5px;
            border: 0.7px solid #000;
            font-weight: bold;
            font-size: 9.5pt;
            line-height: 1.18;
        ">
            PT. KERETA API INDONESIA (PERSERO)<br>
            SISTEM INFORMASI
        </td>

        <!-- Label Nomor -->
        <td style="
            width: 14%;
            padding: 2px 5px;
            border: 0.7px solid #000;
            font-size: 8.5pt;
            vertical-align: middle;
        ">
            Nomor
        </td>

        <!-- Nomor Formulir Tetap -->
        <td style="
            width: 26%;
            padding: 2px 5px;
            border: 0.7px solid #000;
            font-size: 8pt;
            vertical-align: middle;
            white-space: nowrap;
        ">
            FR.SM/TI/031.005/02-2023
        </td>
    </tr>

    <tr style="height: 31px;">
        <td style="
            padding: 2px 5px;
            border: 0.7px solid #000;
            font-size: 8.5pt;
            vertical-align: middle;
        ">
            Tanggal Terbit
        </td>

        <td style="
            padding: 2px 5px;
            border: 0.7px solid #000;
            font-size: 8.5pt;
            vertical-align: middle;
            white-space: nowrap;
        ">
            13 Februari 2023
        </td>
    </tr>

    <tr style="height: 32px;">
        <!-- Status Dokumen -->
        <td rowspan="2" style="
            text-align: center;
            vertical-align: middle;
            padding: 3px;
            border: 0.7px solid #000;
        ">
            <div style="
                display: inline-block;
                border: 1.5px solid #ffcc00;
                padding: 2px 6px;
                color: #ffcc00;
                font-weight: bold;
                font-size: 11pt;
                letter-spacing: 0.7px;
                line-height: 1.1;
                -webkit-print-color-adjust: exact;
            ">
                TERBATAS
            </div>
        </td>

        <!-- Judul Formulir -->
        <td rowspan="2" style="
            text-align: center;
            vertical-align: middle;
            padding: 3px 5px;
            border: 0.7px solid #000;
            font-weight: bold;
            font-size: 9.5pt;
            line-height: 1.15;
        ">
            FORMULIR BERITA ACARA<br>
            PENUTUPAN TIKET INCIDENT/WORK<br>
            ORDER
        </td>

        <td style="
            padding: 2px 5px;
            border: 0.7px solid #000;
            font-size: 8.5pt;
            vertical-align: middle;
        ">
            Versi
        </td>

        <td style="
            padding: 2px 5px;
            border: 0.7px solid #000;
            font-size: 8.5pt;
            vertical-align: middle;
        ">
            001-2023
        </td>
    </tr>

    <tr style="height: 32px;">
        <td style="
            padding: 2px 5px;
            border: 0.7px solid #000;
            font-size: 8.5pt;
            vertical-align: middle;
        ">
            Halaman
        </td>

        <td style="
            padding: 2px 5px;
            border: 0.7px solid #000;
            font-size: 8.5pt;
            vertical-align: middle;
        ">
            1 dari {{ $totalPages ?? 1 }}
        </td>
    </tr>
</table>

    <!-- Reference Table Info -->
    <table style="
        width: 100%;
        margin-bottom: 25px;
        border-collapse: collapse;
        table-layout: fixed;
    ">
        <tr>
            <td style="
                border: 1px solid #000;
                padding: 4px 10px;
                width: 25%;
                font-size: 10pt;
                white-space: nowrap;
            ">
                No. Ref
            </td>

            <td style="
                border: 1px solid #000;
                padding: 4px 10px;
                width: 75%;
                font-size: 10pt;
            ">
                : {{ $bastik->nomor_surat ?? '__/__/____' }}
            </td>
        </tr>

        <tr>
            <td style="
                border: 1px solid #000;
                padding: 4px 10px;
                width: 25%;
                font-size: 10pt;
                white-space: nowrap;
            ">
                Tanggal
            </td>

            <td style="
                border: 1px solid #000;
                padding: 4px 10px;
                width: 75%;
                font-size: 10pt;
            ">
                :
                {{ $bastik->tanggal_surat
                    ? \Carbon\Carbon::parse($bastik->tanggal_surat)
                        ->format('d - m - Y')
                    : '__ - __ - ____'
                }}
            </td>
        </tr>

        <tr>
            <td style="
                border: 1px solid #000;
                padding: 4px 10px;
                width: 25%;
                font-size: 10pt;
                white-space: nowrap;
            ">
                Business Area
            </td>

            <td style="
                border: 1px solid #000;
                padding: 4px 10px;
                width: 75%;
                font-size: 10pt;
            ">
                : {{ $bastik->business_area
                    ?? ($bastik->petugas->unit_kerja ?? '-')
                }}
            </td>
        </tr>
    </table>

    @php
        $hari = '-';
        $tanggalBulanTahun = '-';

        if (!empty($bastik->tanggal_surat)) {
            $parsedDate = \Carbon\Carbon::parse($bastik->tanggal_surat)
                ->locale('id');

            $hari = $parsedDate->isoFormat('dddd');
            $tanggalBulanTahun = $parsedDate->isoFormat('D MMMM YYYY');
        }
    @endphp

<p style="margin-bottom: 15px; font-size: 11pt;">
    Pada hari ini,
    <span style="color: red;">
        {{ $hari }}, {{ $tanggalBulanTahun }}
    </span>,
    yang bertanda tangan di bawah ini:
</p>
    
    <div style="font-weight: bold; margin-bottom: 5px; font-size: 11pt;">PETUGAS SERVICE DESK</div>
    <table style="width: 100%; border: none; margin-bottom: 20px; font-size: 11pt;">
        <tr>
            <td style="width: 150px; border: none; padding: 2px 0;">Nama</td>
            <td style="width: 15px; border: none; padding: 2px 0;">:</td>
            <td style="border: none; padding: 2px 0;">{{ $bastik->petugas->name ?? '-' }}</td>
        </tr>
        <tr>
            <td style="border: none; padding: 2px 0;">NIPKWT</td>
            <td style="border: none; padding: 2px 0;">:</td>
            <td style="border: none; padding: 2px 0;">{{ $bastik->petugas->nip_kwt ?? '-' }}</td>
        </tr>
    </table>

    <p style="margin-bottom: 15px; text-align: justify; line-height: 1.5; font-size: 11pt;">
        Telah dilakukan konfirmasi tiket sebanyak 3 (tiga) kali kepada user yang bersangkutan namun belum ada respon dari pihak terkait. Adapun tiket yang telah di konfirmasi diantaranya sebagai berikut:
    </p>

    <!-- Bordered Table -->
    <table class="bordered">
        <thead>
            <tr>
                <th style="width: 15%; border: 1px solid #000; padding: 4px; background-color: #f2f2f2;">No Tiket</th>
                <th style="width: 35%; border: 1px solid #000; padding: 4px; background-color: #f2f2f2;">Detail Tiket</th>
                <th style="width: 20%; border: 1px solid #000; padding: 4px; background-color: #f2f2f2;">User Pemohon</th>
                <th style="width: 15%; border: 1px solid #000; padding: 4px; background-color: #f2f2f2;">NIPP</th>
                <th style="width: 15%; border: 1px solid #000; padding: 4px; background-color: #f2f2f2;">Unit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bastik->items as $item)
                <tr>
                    <td style="border: 1px solid #000; padding: 4px; font-weight: bold;">{{ $item->no_tiket }}</td>
                    <td style="border: 1px solid #000; padding: 4px;">{{ $item->detail_tiket }}</td>
                    <td style="border: 1px solid #000; padding: 4px;">{{ $item->user_pemohon }}</td>
                    <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $item->nipp }}</td>
                    <td style="border: 1px solid #000; padding: 4px;">{{ $item->unit }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 5px; font-size: 10pt;">
        *Lampirkan bukti konfirmasi
    </p>

    <p style="margin-top: 15px; margin-bottom: 25px;">Demikian Berita Acara ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>

    <!-- Signatures section (Perfectly Symmetrical Row-based Table) -->
    <table style="width: 100%; border: none; text-align: center; margin-top: 20px; border-collapse: collapse; font-size: 11pt;">
        <!-- Baris 1: Ruang Kosong (Kiri) & Tanggal (Kanan) -->
        <tr>
            <td style="width: 50%; border: none; padding: 0;"></td>
            <td style="width: 50%; border: none; padding: 0; padding-bottom: 15px;">
                {{ $bastik->kota }}, <span style="color: red;">{{ $tanggalBulanTahun }}</span>
            </td>
        </tr>
        
        <!-- Baris 2: Judul Tanda Tangan -->
        <tr>
            <td style="width: 50%; border: none; padding: 0; padding-bottom: 6px; vertical-align: bottom;">Petugas Service desk,</td>
            <td style="width: 50%; border: none; padding: 0; padding-bottom: 6px; vertical-align: bottom;">Mengetahui,</td>
        </tr>
        
        <!-- Baris 3: Ruang Tanda Tangan -->
        <tr>
            <td style="width: 50%; border: none; padding: 0; height: 95px; vertical-align: middle;"></td>
            <td style="width: 50%; border: none; padding: 0; height: 95px; vertical-align: middle;">
                @if($bastik->status === 'signed' || $bastik->status === 'final')
                    <div style="margin-top: 8px; margin-bottom: 4px;"><img src="data:image/svg+xml;base64,{!! $qrCodeBase64 !!}" style="width: 80px; height: 80px; display: inline-block;" alt="QR Code" /></div>
                    <div style="font-size: 8pt; color: #008000; font-weight: bold; margin-bottom: 6px;">[ VALIDATED ]</div>
                @endif
            </td>
        </tr>
        
        <!-- Baris 4: Nama Penanda Tangan -->
        <tr>
            <td style="width: 50%; border: none; padding: 0; vertical-align: top;">
                <strong><u>({{ $bastik->petugas->name ?? 'NAMA' }})</u></strong>
            </td>
            <td style="width: 50%; border: none; padding: 0; vertical-align: top;">
                <strong><u>({{ strtoupper($bastik->pimpinan->nama ?? 'NAMA PIMPINAN') }})</u></strong>
            </td>
        </tr>
        
        <!-- Baris 5: NIPP / NIPKWT -->
        <tr>
            <td style="width: 50%; border: none; padding: 0; padding-top: 4px; vertical-align: top;">
                NIPP/NIPKWT {{ $bastik->petugas->nip_kwt ?? '-' }}
            </td>
            <td style="width: 50%; border: none; padding: 0; padding-top: 4px; vertical-align: top;">
                NIPP. {{ $bastik->pimpinan->nipp ?? '-' }}
            </td>
        </tr>
    </table>

    <!-- Attachment Page -->
    @if($bastik->lampirans->count() > 0)
        <div style="page-break-before: always; clear: both; padding-top: 5px;">
            <h3 style="font-size: 12pt; text-align: center; border-bottom: 1.5px solid #000000; padding-bottom: 6px; margin-bottom: 25px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px;">
                LAMPIRAN BUKTI KONFIRMASI
            </h3>
            
            <table style="width: 100%; border-collapse: separate; border-spacing: 12px 15px; margin-top: 10px; table-layout: fixed;">
                @foreach($bastik->lampirans->chunk(2) as $chunk)
                    <tr>
                        @foreach($chunk as $lampiran)
                            <td style="width: 50%; vertical-align: top; border: 1px solid #cccccc; background-color: #fafafa; padding: 8px 10px; text-align: center;">
                                <div style="font-weight: bold; font-size: 9pt; color: #111111; border-bottom: 0.5px solid #dddddd; padding-bottom: 4px; margin-bottom: 8px;">
                                    Tiket: {{ $lampiran->item->no_tiket ?? '-' }}
                                </div>

                                @php
                                    $extension = strtolower(pathinfo($lampiran->file_path, PATHINFO_EXTENSION));
                                    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
                                    $fileExists = Storage::disk('public')->exists($lampiran->file_path);
                                @endphp

                                <div style="height: 140px; text-align: center; vertical-align: middle;">
                                    @if($fileExists && in_array($extension, $imageExtensions))
                                        <img src="{{ Storage::disk('public')->path($lampiran->file_path) }}" style="max-width: 100%; max-height: 135px; width: auto; height: auto; display: inline-block;" alt="Bukti Konfirmasi">
                                    @elseif($fileExists)
                                        @php
                                            $namaDokumen = $lampiran->original_name ?: basename($lampiran->file_path);
                                        @endphp
                                        <div style="height: 125px; border: 1px solid #cccccc; background-color: #f5f5f5; text-align: center; padding: 12px 8px; box-sizing: border-box;">
                                            <div style="font-size: 15pt; font-weight: bold; color: #444444; margin-bottom: 8px;">
                                                {{ strtoupper($extension) }}
                                            </div>
                                            <div style="font-size: 9pt; font-weight: bold; color: #222222; line-height: 1.3; word-wrap: break-word;">
                                                {{ $namaDokumen }}
                                            </div>
                                            <div style="margin-top: 8px; font-size: 8pt; color: #666666;">
                                                Dokumen terlampir pada sistem
                                            </div>
                                        </div>
                                    @else
                                        <div style="height: 125px; padding-top: 40px; font-size: 8pt; color: #999999;">
                                            File tidak ditemukan
                                        </div>
                                    @endif
                                </div>

                                <div style="font-size: 8.5pt; font-weight: bold; color: #444444; margin-top: 6px; border-top: 0.5px solid #dddddd; padding-top: 4px;">
                                    Konfirmasi Ke-{{ $lampiran->urutan_konfirmasi }}
                                </div>
                            </td>
                        @endforeach

                        @if($chunk->count() < 2)
                            <td style="width: 50%; border: none; background-color: transparent;"></td>
                        @endif
                    </tr>
                @endforeach
            </table>
        </div>
    @endif

</body>
</html>
