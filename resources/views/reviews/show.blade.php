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

        /* Tabel Kop Dokumen Baru (Dijamin Lurus 100%) */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
            margin-bottom: 15px;
        }

        .kop-table td {
            border: 1px solid black;
            padding: 5px 8px;
            vertical-align: middle;
        }

        /* Tabel Referensi */
        .ref-table {
            width: 35%;
            border-collapse: collapse;
            border: 1px solid black;
            margin-bottom: 15px;
            font-size: 9pt;
        }

        .ref-table td {
            border: 1px solid black;
            padding: 4px 6px;
        }

        /* Garis Pemisah Tebal (Ganda) */
        .divider {
            border-top: 3px double black;
            margin: 15px 0;
        }

        /* Tabel Informasi Umum */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        .info-table td {
            padding: 5px 0;
            vertical-align: top;
        }

        .info-label {
            width: 22%;
            font-weight: bold;
        }

        .info-colon {
            width: 3%;
        }

        /* Sesi Dokumen (I, II) */
        .section-container {
            display: flex;
            margin-top: 15px;
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
            margin-bottom: 8px;
        }

        /* Kotak Abu-abu */
        .grey-box {
            background-color: #e6e6e6;
            padding: 10px;
            min-height: 25px;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Kotak Analisa & Tindak Lanjut */
        .eval-box {
            border: 1px solid black;
            width: 100%;
            border-collapse: collapse;
        }
        
        .eval-row {
            border-bottom: 1px solid black;
            padding: 10px;
            min-height: 70px;
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
            font-weight: bold;
        }

        /* Area Tanda Tangan */
        .signature-area {
            width: 100%;
            margin-top: 40px;
            text-align: center;
            page-break-inside: avoid;
        }

        .signature-area td {
            width: 50%;
            vertical-align: top;
        }

        .sign-space {
            height: 60px;
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
            margin-top: 30px;
            font-size: 9pt;
            color: #444;
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
        <!-- KOP SURAT UTAMA (DIJAMIN LURUS 100%) -->
        <table class="kop-table">
            <tr>
                <td rowspan="4" style="width: 25%; text-align: center;">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/56/Logo_PT_Kereta_Api_Indonesia_%28Persero%29_2020.svg" alt="Logo KAI" style="width: 120px;">
                </td>
                <td rowspan="2" style="width: 45%; text-align: center; font-weight: bold; font-size: 11pt; line-height: 1.3;">
                    PT KERETA API INDONESIA (PERSERO)<br>
                    SISTEM INFORMASI
                </td>
                <td style="width: 12%; padding: 4px 6px;">Nomor</td>
                <td style="width: 18%; padding: 4px 6px;">: FR.SM/TI/020.005/10-2020</td>
            </tr>
            <tr>
                <td style="padding: 4px 6px;">Tanggal</td>
                <td style="padding: 4px 6px;">: 12 Oktober 2020</td>
            </tr>
            <tr>
                <td rowspan="2" style="text-align: center; font-weight: bold; font-size: 11pt;">
                    FORMULIR POST IMPLEMENTATION REVIEW
                </td>
                <td style="padding: 4px 6px;">Versi</td>
                <td style="padding: 4px 6px;">: 002-2020</td>
            </tr>
            <tr>
                <td style="padding: 4px 6px;">Halaman</td>
                <td style="padding: 4px 6px;">: 1 dari 1</td>
            </tr>
        </table>

        <!-- TABEL REFERENSI -->
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

        <!-- INFORMASI UTAMA -->
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
            <tr>
                <td class="info-label">Lokasi Peninjauan</td>
                <td class="info-colon">:</td>
                <td>{{ $review->lokasi_peninjauan }}</td>
            </tr>
        </table>

        <div class="divider"></div>

        <!-- BAGIAN I: OBYEK PENINJAUAN -->
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

        <!-- BAGIAN II: ANALISA & TINDAK LANJUT -->
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

        <!-- TANDA TANGAN -->
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
                    <div class="sign-space" style="height: 40px;"></div>
                    ( <span class="sign-line text-center" style="border-bottom: 2px solid black; width: 220px; font-weight: bold;">{{ $review->pelaksana_peninjauan }}</span> )<br>
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