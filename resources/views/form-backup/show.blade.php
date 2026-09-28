@php
    function formatTanggalIndo($tanggal)
    {
        if (!$tanggal) {
            return '-';
        }
        $bulan = [
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];
        $t = \Carbon\Carbon::parse($tanggal);
        return $t->format('d') . ' ' . $bulan[(int) $t->format('m')] . ' ' . $t->format('Y');
    }
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Backup - {{ $form->no_ref }}</title>
    <link rel="icon" href="{{ asset('images/favicon.svg') }}">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            background-color: #525659;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        .a4-container {
            width: 210mm;
            min-height: 297mm;
            background: white;
            padding: 12mm;
            box-sizing: border-box;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .a4-container table {
            border-collapse: collapse;
        }

        .header-table,
        .main-table {
            width: 100%;
        }

        .header-table {
            table-layout: fixed;
        }

        .header-table td {
            border: 1px solid black;
            vertical-align: middle;
            box-sizing: border-box;
        }

        .eof-text {
            margin-top: 8px;
            text-align: center;
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .header-logo {
            width: 18%;
            height: 75px;
            text-align: center;
            padding: 6px;
        }

        .header-logo img {
            display: block;
            width: 130px;
            max-width: 100%;
            height: auto;
            margin: 0 auto;
        }

        .header-company {
            width: 42%;
            height: 75px;
            text-align: center;
            padding: 8px;
            font-size: 14px;
            font-weight: bold;
            line-height: 1.5;
        }

        .header-status {
            width: 18%;
            height: 70px;
            text-align: center;
            vertical-align: middle;
            padding: 10px !important;
            overflow: hidden;
        }

        .terbatas-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 112px;
            min-width: 0;
            padding: 7px 5px;
            border: 2px solid #d4a017;
            color: #d4a017;
            font-size: 13px;
            font-weight: bold;
            line-height: 1;
            white-space: nowrap;
            box-sizing: border-box;
        }

        .header-title {
            width: 42%;
            height: 70px;
            text-align: center;
            padding: 8px;
            font-size: 15px;
            font-weight: bold;
        }

        .header-label {
            width: 15%;
            padding: 8px 10px;
            font-size: 12px;
            white-space: nowrap;
        }

        .header-value {
            width: 25%;
            padding: 8px 10px;
            font-size: 12px;
        }

        .info-table {
            width: 35%;
            margin-top: 25px;
            margin-bottom: 15px;
        }

        .info-table td {
            border: 1px solid black !important;
            padding: 6px 8px !important;
        }

        .flex-row {
            display: flex;
            align-items: center;
        }

        .label-col {
            width: 85px;
            display: inline-block;
        }

        .desc-text {
            text-align: justify;
            line-height: 1.5;
            margin: 0 40px 15px 40px;
        }

        .footer-note {
            font-size: 10px;
            margin: 15px 40px 0 40px;
            font-style: italic;
            text-align: justify;
            line-height: 1.4;
        }

        .main-table th,
        .main-table td {
            border: 1px solid black;
            padding: 6px;
        }

        .main-table th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .footer-section {
            margin-top: 40px;
            display: flex;
            justify-content: center;
        }

        .signature-box {
            width: 260px;
            text-align: center;
            font-size: 11px;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 8mm;
            }

            body {
                background-color: transparent;
                padding: 0;
                display: block;
            }

            .a4-container {
                box-shadow: none;
                margin: 0;
                padding: 0;
                border: none;
                width: 100%;
                min-height: auto;
            }

            .header-table {
                width: 100%;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <div class="a4-container">
        <button onclick="window.print()" class="no-print"
            style="margin-bottom:20px; padding: 8px 16px; background-color:#007bff; color:white; border:none; border-radius:4px; cursor:pointer; font-weight:bold;">
            Cetak Dokumen
        </button>

        <table class="header-table">
            <tr>
                <td class="header-logo" rowspan="2">
                    <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI">
                </td>

                <td class="header-company" rowspan="2">
                    PT KERETA API INDONESIA (PERSERO)<br>
                    SISTEM INFORMASI
                </td>

                <td class="header-label">No. Dokumen</td>
                <td class="header-value">{{ $form->doc_nomor }}</td>
            </tr>

            <tr>
                <td class="header-label">Tanggal</td>
                <td class="header-value">{{ $form->doc_tanggal }}</td>
            </tr>

            <tr>
                <td class="header-status" rowspan="2">
                    <div class="terbatas-box">TERBATAS</div>
                </td>

                <td class="header-title" rowspan="2">
                    LAPORAN BACKUP
                </td>

                <td class="header-label">Versi</td>
                <td class="header-value">{{ $form->doc_versi }}</td>
            </tr>

            <tr>
                <td class="header-label">Halaman</td>
                <td class="header-value"><span id="page-number">1 dari 1</span></td>
            </tr>
        </table>

        <table class="info-table">
            <tr>
                <td>
                    <div class="flex-row"><span class="label-col">No. Ref</span><span>: {{ $form->no_ref }}</span></div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="flex-row"><span class="label-col">Tanggal</span><span>: {{ $form->tanggal }}</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="flex-row"><span class="label-col">Business Area</span><span>:
                            {{ $form->business_area }}</span></div>
                </td>
            </tr>
        </table>

        <p class="desc-text">
            Informasi yang dianggap kritikal bagi berlangsungnya proses bisnis PT Kereta Api Indonesia (persero) harus
            memiliki backup. Proses backup dilakukan secara berkala sesuai dengan tingkat risiko yang dapat terjadi jika
            informasi rusak atau hilang. Informasi yang harus di-backup adalah seperti tercantum dalam tabel sebagai
            berikut.
        </p>

        <table class="main-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Nama Informasi</th>
                    <th style="width: 15%;">Metode Backup</th>
                    <th style="width: 20%;">Periode Backup</th>
                    <th style="width: 15%;">Retensi</th>
                    <th style="width: 20%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($form->items as $item)
                    <tr>
                        <td style="text-align: center;">{{ $item->no }}</td>
                        <td>{{ $item->nama_informasi }}</td>
                        <td style="text-align: left;">{{ $item->metode_backup }}</td>
                        <td style="text-align: left;">{{ $item->periode_backup }}</td>
                        <td style="text-align: left;">{{ $item->retensi }}</td>
                        <td style="text-align: left;">{{ $item->status }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #999; padding: 15px;">Data backup belum
                            diisi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="eof-text">
            ===== End Of File =====
        </div>

        <p class="footer-note">
            <strong>Ket: Backup untuk informasi lain di luar tabel tersebut dapat dilakukan sesuai dengan diskresi
                Pemilik Informasi dengan tetap memperhatikan langkah-langkah pengamanan informasi sesuai kebijakan dan
                prosedur.</strong>
        </p>

        <div class="footer-section clearfix">
            <div class="signature-box">
                <p>{{ $form->kota_tanggal }}</p>
                <p style="margin-top: 5px;">{{ $form->mengetahui_jabatan ?: 'Pimpinan Masing-Masing Unit' }}</p>
                <div style="height: 60px;"></div>

                <p style="text-decoration: underline; margin-bottom: 2px;">
                    <strong>{{ $form->mengetahui_nama ?: '(..................................................)' }}</strong>
                </p>
                <p style="margin-top: 0;">
                    NIPP. {{ $form->mengetahui_nipp ?: '....................' }}
                </p>
            </div>
        </div>

    </div>

    <script>
        function updatePageCount() {
            const container = document.querySelector('.a4-container');
            const pageNumber = document.getElementById('page-number');

            if (!container || !pageNumber) {
                return;
            }

            const mmToPx = 96 / 25.4;
            const onePageHeight = 297 * mmToPx;

            const printButton = container.querySelector('.no-print');
            let ignoredHeight = 0;

            if (printButton) {
                const buttonStyle = window.getComputedStyle(printButton);

                ignoredHeight =
                    printButton.offsetHeight +
                    parseFloat(buttonStyle.marginTop || 0) +
                    parseFloat(buttonStyle.marginBottom || 0);
            }

            const contentHeight =
                container.scrollHeight - ignoredHeight;

            const totalPages = Math.max(
                1,
                Math.ceil((contentHeight - 15) / onePageHeight)
            );

            pageNumber.textContent = `1 dari ${totalPages}`;
        }
        window.addEventListener('load', updatePageCount);
        window.addEventListener('resize', updatePageCount);

        window.addEventListener('beforeprint', () => {
            requestAnimationFrame(updatePageCount);
        });
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('action') && urlParams.get('action') === 'print') {
            setTimeout(() => {
                window.print();
            }, 500);
        }
    });
</script>

</body>

</html>
