<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Formulir Checklist 05 - Secure Implement Preparation</title>

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            padding: 28px;
            background: #eef0f3;
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
        }

        table {
            border-collapse: collapse;
        }

        /* =====================================================
           TOOLBAR
        ===================================================== */

        .toolbar {
            width: 210mm;
            max-width: 100%;
            margin: 0 auto 18px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn {
            padding: 10px 18px;

            border: 0;
            border-radius: 6px;

            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;

            cursor: pointer;
            text-decoration: none;
        }

        .btn-back {
            background: #6b7280;
            color: white;
        }

        .btn-print {
            background: #2563eb;
            color: white;
        }

        /* =====================================================
           A4
        ===================================================== */

        .paper {
            width: 210mm;
            min-height: 297mm;

            margin: 0 auto;
            padding: 14mm 15mm;

            background: white;

            box-shadow: 0 2px 12px rgba(0,0,0,.14);
        }

        .form-document {
            width: 100%;
            margin: 0 auto;

            font-size: 10pt;
        }

        /* =====================================================
           HEADER
        ===================================================== */

        .document-header {
            width: 100%;
            height: 43mm;

            table-layout: fixed;
        }

        .document-header > tbody > tr > td {
            padding: 0;

            border: 1px solid #000;

            vertical-align: middle;
        }

        /* LOGO */

        .logo-column {
            width: 21%;
        }

        .logo-box {
            height: 30mm;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 3mm;
        }

        .kai-logo {
            display: block;

            width: 30mm;
            max-width: 94%;
            height: auto;

            margin: auto;
        }

        /* TERBATAS */

        .restricted-box {
            height: 13mm;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 1.8mm;
        }

        .restricted-label {
            width: 100%;

            padding: 1.7mm;

            border: 2px solid #f1d800;

            color: #d4bd00;

            text-align: center;

            font-size: 9.5pt;
            font-weight: bold;
        }

        /* TENGAH */

        .middle-column {
            width: 47%;
        }

        .company-info {
            height: 21.5mm;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 2mm;

            text-align: center;

            font-size: 10.5pt;
            font-weight: bold;
            line-height: 1.3;
        }

        .form-title {
            height: 21.5mm;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 2mm;

            border-top: 1px solid #000;

            text-align: center;

            font-size: 10.5pt;
            font-weight: bold;
            line-height: 1.3;
        }

        /* INFO KANAN */

        .document-info-cell {
            width: 32%;
        }

        .document-info {
            width: 100%;
            height: 43mm;

            table-layout: fixed;
        }

        .document-info td {
            height: 10.75mm;

            padding: 1.4mm 1.7mm;

            border: 0;
            border-bottom: 1px solid #000;

            vertical-align: middle;

            font-size: 9pt;
            line-height: 1.2;
        }

        .document-info tr:last-child td {
            border-bottom: 0;
        }

        .document-info .label {
            width: 31%;

            border-right: 1px solid #000;

            font-weight: bold;
        }

        .document-info .value {
            width: 69%;

            overflow-wrap: anywhere;
        }

        /* =====================================================
           REFERENCE
        ===================================================== */

        .reference-table {
            width: 45%;

            margin-top: 4mm;
            margin-bottom: 7mm;

            table-layout: fixed;
        }

        .reference-table td {
            height: 6mm;

            padding: 1mm 1.5mm;

            border: 1px solid #000;

            font-size: 9.5pt;
        }

        .reference-label {
            width: 42%;
        }

        .reference-colon {
            width: 8%;

            text-align: center;
        }

        .reference-value {
            width: 50%;
        }

        /* =====================================================
           DESKRIPSI
        ===================================================== */

        .description-table {
            width: 92%;

            margin-left: 4%;
            margin-bottom: 5mm;

            table-layout: fixed;
        }

        .description-table td {
            border: 1px solid #000;
        }

        .description-title {
            height: 11mm;

            padding: 1.5mm;

            text-align: center;

            font-size: 10pt;
            font-weight: bold;
            line-height: 1.3;
        }

        .application-name {
            display: block;

            margin-top: 1mm;

            font-size: 10pt;
            font-style: italic;
            font-weight: bold;
        }

        .description-content {
            height: 60mm;

            padding: 3mm 4mm !important;

            vertical-align: top;

            font-size: 9.5pt;
        }

        .description-row {
            display: grid;

            grid-template-columns:
                34mm
                5mm
                1fr;

            margin-bottom: 2mm;

            line-height: 1.3;
        }

        .description-colon {
            text-align: center;
        }

        .description-space {
            height: 4mm;
        }

        .function-list {
            margin-top: 2mm;
        }

        .function-item {
            min-height: 4.5mm;

            font-size: 9.5pt;
            font-style: italic;
        }

        /* =====================================================
           CHECKLIST
        ===================================================== */

        .checklist-table {
            width: 92%;

            margin-left: 4%;
            margin-bottom: 5mm;

            table-layout: fixed;
        }

        .checklist-table th,
        .checklist-table td {
            padding: 2mm;

            border: 1px solid #000;

            vertical-align: middle;

            font-size: 9.5pt;
            line-height: 1.3;
        }

        .checklist-table th {
            background: #dce9f8;

            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .checklist-heading {
            height: 7mm;

            text-align: center;

            font-size: 10pt !important;
            font-weight: bold;
        }

        .number-column {
            width: 7%;

            text-align: center;
        }

        .activity-column {
            width: 72%;
        }

        .check-column {
            width: 21%;

            text-align: center;
        }

        .activity-row {
            height: 14mm;
        }

        .check-option {
            white-space: nowrap;
        }

        /* =====================================================
           TEMPAT / TANGGAL
        ===================================================== */

        .place-date {
            width: 92%;

            margin-left: 4%;
            margin-top: 4mm;
            margin-bottom: 3mm;

            padding-right: 1mm;

            text-align: right;

            font-size: 9.5pt;
        }

        /* =====================================================
           SIGNATURE
        ===================================================== */

        .signature-table {
            width: 66%;

            margin-left: 30%;

            table-layout: fixed;
        }

        .signature-table td {
            width: 50%;

            border: 1px solid #000;

            text-align: center;

            font-size: 9.5pt;
        }

        .signature-heading {
            height: 8mm;

            padding: 1mm;

            vertical-align: middle;
        }

        .signature-space {
            height: 22mm;
        }

        .signature-name {
            min-height: 10mm;

            padding: 1mm 2mm 2mm;
        }

        .signature-line {
            display: inline-block;

            min-width: 75%;

            padding-bottom: .7mm;

            border-bottom: 1px dotted #000;

            font-weight: bold;
        }

        .signature-nipp {
            display: block;

            margin-top: 1.5mm;
        }

        /* =====================================================
           PRINT
        ===================================================== */

        @page {
            size: A4 portrait;
            margin: 0;
        }

        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;

                margin: 0 !important;
                padding: 0 !important;

                background: #fff !important;
            }

            body {
                font-family: Arial, Helvetica, sans-serif !important;
                color: #000 !important;
            }

            .toolbar {
                display: none !important;
            }

            .paper {
                width: 210mm !important;
                height: 297mm !important;
                min-height: 297mm !important;

                margin: 0 !important;

                /*
                 * Tidak menggunakan scale/zoom.
                 * Font tetap terbaca.
                 */
                padding:
                    11mm
                    13mm
                    9mm !important;

                box-shadow: none !important;

                overflow: hidden !important;
            }

            .form-document {
                width: 100% !important;

                font-size: 10pt !important;

                transform: none !important;
                zoom: 1 !important;
            }

            .company-info,
            .form-title {
                font-size: 10.5pt !important;
            }

            .document-info td {
                font-size: 9pt !important;
            }

            .reference-table td {
                font-size: 9.5pt !important;
            }

            .description-title,
            .application-name {
                font-size: 10pt !important;
            }

            .description-content,
            .description-row,
            .function-item {
                font-size: 9.5pt !important;
            }

            .checklist-table th,
            .checklist-table td {
                font-size: 9.5pt !important;
            }

            .checklist-heading {
                font-size: 10pt !important;
            }

            .place-date,
            .signature-table td {
                font-size: 9.5pt !important;
            }

            .kai-logo {
                width: 30mm !important;
            }

            .restricted-label {
                font-size: 9.5pt !important;

                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .checklist-table th {
                background: #dce9f8 !important;

                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .document-header,
            .description-table,
            .checklist-table,
            .signature-table,
            tr {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }
        }
    </style>
</head>

<body>

<div class="toolbar">

    <a
        href="{{ route('secure-implement-preparation.index') }}"
        class="btn btn-back"
    >
        ← Kembali
    </a>

    <button
        type="button"
        class="btn btn-print"
        onclick="window.print()"
    >
        🖨 Print
    </button>

</div>


<div class="paper">

<div class="form-document">


    {{-- HEADER --}}

    <table class="document-header">

        <tr>

            <td class="logo-column">

                <div class="logo-box">

                    <img
                        src="{{ asset('images/logo-kai.png') }}"
                        alt="Logo KAI"
                        class="kai-logo"
                    >

                </div>

                <div class="restricted-box">

                    <div class="restricted-label">
                        TERBATAS
                    </div>

                </div>

            </td>


            <td class="middle-column">

                <div class="company-info">
                    PT KERETA API INDONESIA (PERSERO)
                    <br>
                    SISTEM INFORMASI
                </div>

                <div class="form-title">
                    FORMULIR CHECKLIST 05
                    <br>
                    SECURE IMPLEMENT PREPARATION
                </div>

            </td>


            <td class="document-info-cell">

                <table class="document-info">

                    <tr>
                        <td class="label">Nomor</td>
                        <td class="value">
                            FR.IK/TI/005.01/10-2020
                        </td>
                    </tr>

                    <tr>
                        <td class="label">Tanggal</td>
                        <td class="value">
                            12 Oktober 2020
                        </td>
                    </tr>

                    <tr>
                        <td class="label">Versi</td>
                        <td class="value">
                            002-2020
                        </td>
                    </tr>

                    <tr>
                        <td class="label">Halaman</td>
                        <td class="value">
                            1 dari 1
                        </td>
                    </tr>

                </table>

            </td>

        </tr>

    </table>


    {{-- REFERENCE --}}

    <table class="reference-table">

        <tr>
            <td class="reference-label">No. Ref</td>
            <td class="reference-colon">:</td>
            <td class="reference-value">
                {{ $form->no_ref ?? '-' }}
            </td>
        </tr>

        <tr>
            <td class="reference-label">Tanggal</td>
            <td class="reference-colon">:</td>
            <td class="reference-value">
                {{ $form->tanggal?->format('d-m-Y') ?? '-' }}
            </td>
        </tr>

        <tr>
            <td class="reference-label">Business Area</td>
            <td class="reference-colon">:</td>
            <td class="reference-value">
                {{ $form->business_area ?? '-' }}
            </td>
        </tr>

    </table>


    {{-- DESKRIPSI --}}

    <table class="description-table">

        <tr>

            <td class="description-title">

                DESKRIPSI

                <span class="application-name">
                    &lt;{{ $form->nama_aplikasi ?? 'NAMA APLIKASI' }}&gt;
                </span>

            </td>

        </tr>

        <tr>

            <td class="description-content">

                <div class="description-row">
                    <div>Tanggal Checklist</div>
                    <div class="description-colon">:</div>
                    <div>
                        {{ $form->tanggal_checklist?->format('d-m-Y') ?? '-' }}
                    </div>
                </div>

                <div class="description-row">
                    <div>Deskripsi</div>
                    <div class="description-colon">:</div>
                    <div>
                        {{ $form->deskripsi ?? '-' }}
                    </div>
                </div>

                <div class="description-space"></div>

                <div class="description-row">
                    <div>Versi Aplikasi</div>
                    <div class="description-colon">:</div>
                    <div>
                        {{ $form->versi_aplikasi ?? '-' }}
                    </div>
                </div>

                <div class="description-row">
                    <div>Modul</div>
                    <div class="description-colon">:</div>
                    <div>
                        {{ $form->modul ?? '-' }}
                    </div>
                </div>

                <div class="description-row">
                    <div>Fungsi</div>
                    <div class="description-colon">:</div>
                    <div style="white-space: pre-line;">{{ $form->fungsi ?? '-' }}</div>
                </div>

            </td>

        </tr>

    </table>


    {{-- CHECKLIST --}}

    <table class="checklist-table">

        <thead>

            <tr>
                <th colspan="3" class="checklist-heading">
                    CHECKLIST 05 SECURE IMPLEMENT PREPARATION
                </th>
            </tr>

            <tr>
                <th class="number-column">No</th>
                <th class="activity-column">Activity</th>
                <th class="check-column">Check</th>
            </tr>

        </thead>

        <tbody>

            <tr class="activity-row">

                <td class="number-column">
                    1
                </td>

                <td class="activity-column">
                    Membuat dokumen TSD
                    (<i>Technical Specification Document</i>)
                    oleh <i>Business Analyst</i> (BA)
                </td>

                <td class="check-column">

                    @if($form->check_tsd === 'YA')
                        <span class="check-option">☑ Ya</span>
                        &nbsp;
                        <span class="check-option">☐ Tidak</span>
                    @else
                        <span class="check-option">☐ Ya</span>
                        &nbsp;
                        <span class="check-option">☑ Tidak</span>
                    @endif

                </td>

            </tr>


            <tr class="activity-row">

                <td class="number-column">
                    2
                </td>

                <td class="activity-column">
                    Membuat dokumen
                    <i>User Manual</i>
                    oleh <i>Business Analyst</i> (BA)
                </td>

                <td class="check-column">

                    @if($form->check_user_manual === 'YA')
                        <span class="check-option">☑ Ya</span>
                        &nbsp;
                        <span class="check-option">☐ Tidak</span>
                    @else
                        <span class="check-option">☐ Ya</span>
                        &nbsp;
                        <span class="check-option">☑ Tidak</span>
                    @endif

                </td>

            </tr>

        </tbody>

    </table>


    {{-- TEMPAT / TANGGAL --}}

    <div class="place-date">

        {{ $form->tempat ?? '........................' }},

        {{ $form->tanggal_ttd?->format('d-m-Y') ?? '........................' }}

    </div>


    {{-- SIGNATURE --}}

    <table class="signature-table">

        <tr>

            <td class="signature-heading">
                Mengetahui,
            </td>

            <td class="signature-heading">
                Pelaksana Checklist,
            </td>

        </tr>

        <tr>

            <td>

                <div class="signature-space"></div>

                <div class="signature-name">

                    <span class="signature-line">
                        {{ $form->mengetahui_nama ?? '........................' }}
                    </span>

                    <span class="signature-nipp">
                        NIPP.
                        {{ $form->mengetahui_nipp ?? '................' }}
                    </span>

                </div>

            </td>

            <td>

                <div class="signature-space"></div>

                <div class="signature-name">

                    <span class="signature-line">
                        {{ $form->pelaksana_nama ?? '........................' }}
                    </span>

                    <span class="signature-nipp">
                        NIPP.
                        {{ $form->pelaksana_nipp ?? '................' }}
                    </span>

                </div>

            </td>

        </tr>

    </table>

</div>

</div>
    </table>

</div>
</div>


{{-- =====================================================
     AUTO PRINT
     Jika halaman dibuka dari tombol print pada index
     menggunakan ?print=1
===================================================== --}}

@if(request()->boolean('print'))
<script>
    window.addEventListener('load', function () {

        // Tunggu sebentar agar logo, font,
        // tabel dan seluruh layout selesai dirender
        setTimeout(function () {
            window.print();
        }, 300);

    });
</script>
@endif


</body>
</html>
