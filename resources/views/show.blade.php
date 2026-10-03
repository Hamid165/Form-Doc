<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak - Formulir Post Implementation Review</title>
    <style>
        /* Pengaturan Kertas A4 */
        @page {
            size: A4;
            margin: 15mm 20mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            color: black;
            background-color: #525659;
            margin: 0;
            padding: 0;
        }

        .sheet {
            background: white;
            width: 210mm;
            min-height: 297mm;
            padding: 15mm 20mm;
            margin: 10mm auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            box-sizing: border-box;
            position: relative;
        }

        /* Tabel Kop Dokumen */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
            margin-bottom: 20px;
        }

        .kop-table td {
            border: 1px solid black;
            padding: 5px;
            vertical-align: middle;
        }

        .logo-cell {
            width: 25%;
            text-align: center;
        }

        .title-cell {
            width: 45%;
            text-align: center;
            font-size: 11pt;
        }

        .meta-cell {
            width: 30%;
            padding: 0 !important;
        }

        .meta-inner-table {
            width: 100%;
            border-collapse: collapse;
        }

        .meta-inner-table td {
            border: none;
            border-bottom: 1px solid black;
            padding: 4px 6px;
            font-size: 9pt;
        }

        .meta-inner-table tr:last-child td {
            border-bottom: none;
        }

        .meta-label {
            width: 35%;
            border-right: 1px solid black !important;
        }

        /* Tabel Referensi */
        .ref-table {
            width: 35%;
            border-collapse: collapse;
            border: 1px solid black;
            margin-bottom: 20px;
            font-size: 9pt;
        }

        .ref-table td {
            border: 1px solid black;
            padding: 3px 5px;
        }

        /* Garis Pemisah Tebal */
        .divider {
            border-top: 2px solid black;
            border-bottom: 1px solid black;
            height: 2px;
            margin: 15px 0;
        }

        /* Tabel Informasi Umum */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .info-label {
            width: 25%;
        }

        .info-colon {
            width: 3%;
        }

        /* Sesi Dokumen (I, II) */
        .section-container {
            display: flex;
            margin-top: 20px;
            page-break-inside: avoid;
        }

        .section-number {
            width: 30px;
            font-weight: bold;
        }

        .section-content {
            flex: 1;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Kotak Abu-abu */
        .grey-box {
            background-color: #e6e6e6; /* Warna abu-abu sesuai contoh */
            padding: 8px;
            min-height: 25px;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }

        /* Kotak Analisa & Tindak Lanjut */
        .eval-box {
            border: 1px solid black;
            width: 100%;
            border-collapse: collapse;
        }
        
        .eval-row {
            border-bottom: 1px solid black;
            padding: 8px;
            min-height: 80px;
        }

        .eval-row:last-child {
            border-bottom: none;
        }

        .eval-heading {
            text-decoration: underline;
            font-style: italic;
            font-size: 10pt;
            margin-bottom: 5px;
            display: block;
        }

        /* Area Tanda Tangan */
        .signature-area {
            width: 100%;
            margin-top: 50px;
            text-align: center;
            page-break-inside: avoid;
        }

        .signature-area td {
            width: 50%;
            vertical-align: top;
        }

        .sign-space {
            height: 70px;
        }

        .sign-line {
            display: inline-block;
            width: 250px;
            border-bottom: 1px solid black;
            margin-bottom: 3px;
        }

        .sign-dots {
            display: inline-block;
            width: 150px;
            border-bottom: 1px dotted black;
        }

        /* Keterangan Bawah */
        .footer-note {
            margin-top: 40px;
            font-size: 9pt;
            color: #666;
        }

        /* Area Tombol Web */
        .no-print {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #2D2A70;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
            z-index: 999;
        }

        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
            font-family: Arial, sans-serif;
        }

        .btn-print { background: #F37021; color: white; }
        .btn-back { background: #ffffff; color: #2D2A70; }

        @media print {
            body { background: none; }
            .sheet { margin: 0; box-shadow: none; width: 100%; padding: 0; }
            .no-print { display: none; }
            /* Memaksa background abu-abu tetap tercetak */
            .grey-box { background-color: #e6e6e6 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <div style="color: white; margin-bottom: 10px; font-size: 12px;">Mode Pratinjau Dokumen</div>
        <a href="{{ route('reviews.index') }}" class="btn btn-back">⬅ Kembali</a>
        <button onclick="window.print()" class="btn btn-print">🖨️ Cetak</button>
    </div>

    <div class="sheet">
        <table class="kop-table">
            <tr>
                <td rowspan="2" class="logo-cell">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/56/Logo_PT_Kereta_Api_Indonesia_%28Persero%29_2020.svg" alt="Logo KAI" style="width: 130px;">
                </td>
                <td class="title-cell">
                    PT KERETA API INDONESIA (PERSERO)<br>
                    SISTEM INFORMASI
                </td>
                <td class="meta-cell">
                    <table class="meta-inner-table">
                        <tr>
                            <td class="meta-label">Nomor</td>
                            <td>: FR.SM/TI/020.005/10-2020</td>
                        </tr>
                        <tr>
                            <td class="meta-label">Tanggal</td>
                            <td>: 12 Oktober 2020</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="title-cell" style="font-weight: bold;">
                    FORMULIR POST IMPLEMENTATION REVIEW
                </td>
                <td class="meta-cell">
                    <table class="meta-inner-table">
                        <tr>
                            <td class="meta-label">Versi</td>
                            <td>: 002-2020</td>
                        </tr>
                        <tr>
                            <td class="meta-label">Halaman</td>
                            <td>: 1 dari 1</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="ref-table">
            <tr>
                <td style="width: 40%;">No. Ref</td>
                <td>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; / &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: </td>
            </tr>
            <tr>
                <td>Business Area</td>
                <td>: </td>
            </tr>
        </table>

        <div class="divider"></div>

        <table class="info-table">
            <tr>
                <td class="info-label">Tanggal Peninjauan</td>
                <td class="info-colon">:</td>
                <td>{{ \Carbon\Carbon::parse($review->tanggal_peninjauan)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td class="info-label">Periode Peninjauan</td>
                <td class="info-colon">:</td>
                <td>{{ $review->periode_peninjauan }}</td>
            </tr>
            <tr>
                <td class="info-label">Pelaksana Peninjauan</td>
                <td class="info-colon">:</td>
                <td>{{ $review->pelaksana_peninjauan }}</td>
            </tr>
        </table>

        <div class="divider"></div>

        <div class="section-container">
            <div class="section-number">I.</div>
            <div class="section-content">
                <div class="section-title">Obyek Peninjauan *</div>
                <div class="grey-box">
                    <strong>&lt;{{ $review->obyek_peninjauan }}&gt;</strong><br>
                    {{ $review->deskripsi_sistem }}
                </div>
            </div>
        </div>

        <div class="section-container">
            <div class="section-number">II.</div>
            <div class="section-content">
                <div class="section-title">Analisa & Tindak Lanjut</div>
                <div class="eval-box">
                    <div class="eval-row">
                        <span class="eval-heading">Analisa:</span>
                        {{ $review->analisa }}
                    </div>
                    <div class="eval-row">
                        <span class="eval-heading">Tindak Lanjut:</span>
                        {{ $review->tindak_lanjut }}
                    </div>
                </div>
            </div>
        </div>

        <table class="signature-area">
            <tr>
                <td>
                    Mengetahui,
                    <div class="sign-space"></div>
                    ( <span class="sign-line"></span> )<br>
                    <span class="sign-dots"></span>
                </td>
                <td>
                    {{ $review->lokasi_peninjauan }}, ...... - ...... - ............<br>
                    <br>
                    Pelaksana Peninjauan
                    <div class="sign-space" style="height: 50px;"></div>
                    ( <span class="sign-line text-center" style="border-bottom: 2px solid black;">{{ $review->pelaksana_peninjauan }}</span> )<br>
                    <span class="sign-dots" style="width: 120px;"></span><br>
                    Implementator
                </td>
            </tr>
        </table>

        <div class="footer-note">
            * beri tanda (√) pada kolom sesuai dengan obyek peninjauan
        </div>

    </div>

</body>
</html>