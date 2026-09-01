<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Permohonan Pemusnahan Aset - {{ $form_pemusnahan->no_ref }}</title>
    <link rel="icon" href="{{ asset('images/favicon.svg') }}">
    <style>
        body {
            font-family: 'Calibri', 'Segoe UI', Candara, Arial, sans-serif; font-size: 11px; background-color: #525659;
            margin: 0; padding: 20px; display: flex; justify-content: center;
        }
        .a4-container { width: 210mm; min-height: 297mm; background: white; padding: 20mm; box-sizing: border-box; box-shadow: 0 4px 8px rgba(0,0,0,0.2); }
        .a4-container table { border-collapse: collapse; }
        .header-table, .main-table { width: 100%; }
        .header-table td { border: 1px solid black; padding: 2px 8px; height: 28px; vertical-align: middle; box-sizing: border-box; }
        .title-text { font-size: 11px; font-weight: bold; text-align: center; }
        .terbatas-box { border: 2px solid #f0d000; background-color: #fff9db; color: #7a6100; padding: 5px 10px; font-weight: bold; font-size: 13px; display: inline-block; margin: auto; }
        .info-section { margin-top: 15px; margin-bottom: 15px; }
        .small-info-table { margin-bottom: 15px; width: max-content; }
        .kolom-label-kiri { width: 107px; }
        .small-info-table td { border: 1px solid black; padding: 4px 6px; height: auto; }
        .filled-data { font-weight: normal; }
        .pemohon-row { display: flex; margin-bottom: 8px; }
        .pemohon-label { width: 130px; }
        .main-table th, .main-table td { border: 1px solid black; padding: 4px; vertical-align: middle; }
        .main-table th { font-weight: bold; text-align: center; }
        .text-center { text-align: center; }
        .footer-place-row { text-align: right; margin: 25px 0 20px; }
        .signature-columns { display: flex; justify-content: space-between; margin-bottom: 24px; }
        .signature-box { width: 45%; text-align: center; }
        .signature-space { height: 115px; }
        .approval-section { text-align: center; margin-top: 0; }
        .approval-space { height: 115px; }
        @media print {
            body { margin: 0; padding: 0; background-color: white; }
            .a4-container { box-shadow: none; width: 100%; }
            .no-print { display: none !important; }
        }
        @page { size: A4; margin: 0mm; }
        @if(request('print'))
        /* Sembunyikan dari layar (biar tidak "kelip" kelihatan sebelum dialog print muncul),
           tapi tetap ditampilkan saat proses cetak berlangsung. */
        body { visibility: hidden; }
        @media print {
            body { visibility: visible !important; }
        }
        @endif
        .btn-kembali { width: 100px; height: 36px; line-height: 36px; padding: 0; background-color: #f44336; color: white; border: none; cursor: pointer; border-radius: 4px; font-weight: bold; font-family: inherit; font-size: 13px; text-decoration: none; text-align: center; box-sizing: border-box; display: inline-block; }
        .btn-kembali:hover { background-color: #d32f2f; }
        .btn-print { width: 100px; height: 36px; line-height: 36px; padding: 0; background-color: #4CAF50; color: white; border: none; cursor: pointer; border-radius: 4px; font-weight: bold; font-family: inherit; font-size: 13px; text-align: center; box-sizing: border-box; display: inline-block; }
        .btn-print:hover { background-color: #388e3c; }
        @media screen and (max-width: 768px) {
            body { padding: 10px; }
            .a4-container { width: 100% !important; padding: 15px !important; box-shadow: none !important; min-height: auto; }
            .table-responsive { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; margin-bottom: 15px; }
            .a4-container table { min-width: 600px; }
            .header-table { min-width: 600px; }
            .signature-columns { flex-direction: column; gap: 20px; }
            .signature-box { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="a4-container relative">
        <div class="no-print" style="margin-bottom: 20px; text-align: right; display: flex; justify-content: flex-end; gap: 10px;">
            <a href="{{ route('form-pemusnahan.index') }}" class="btn-kembali">Kembali</a>
        </div>

        <div class="table-responsive">
        <table class="header-table">
            <tr>
                <td rowspan="2" style="width: 18.92%; text-align: center;">
                    <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI" style="max-width: 100%; max-height: 50px;">
                </td>
                <td rowspan="2" class="title-text" style="width: 47.3%;">
                    PT KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI
                </td>
                <td style="width: 9.46%;">Nomor</td>
                <td style="width: 24.32%;">: FR.SM/TI/011.004/10-2020</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: 12 Oktober 2020</td>
            </tr>
            <tr>
                <td rowspan="2" style="text-align: center;">
                    <div class="terbatas-box">TERBATAS</div>
                </td>
                <td rowspan="2" class="title-text">
                    FORMULIR<br>PERMOHONAN PEMUSNAHAN ASET
                </td>
                <td>Versi</td>
                <td>: 002-2020</td>
            </tr>
            <tr>
                <td>Halaman</td>
                <td>: 1 dari 1</td>
            </tr>
        </table>
        </div>

        <div class="info-section">
            <table class="small-info-table">
                <tr>
                    <td class="kolom-label-kiri">No. Ref</td>
                    <td class="filled-data">: {{ $form_pemusnahan->no_ref ?: '___ /___ / _______' }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td class="filled-data">: {{ $form_pemusnahan->tanggal_ref ? \Carbon\Carbon::parse($form_pemusnahan->tanggal_ref)->format('d / m / Y') : '' }}</td>
                </tr>
                <tr>
                    <td>Business Area</td>
                    <td class="filled-data">: {{ $form_pemusnahan->business_area }}</td>
                </tr>
            </table>
        </div>

        <div class="pemohon-row">
            <div class="pemohon-label">Tanggal</div>
            <div>: {{ $form_pemusnahan->tanggal_permohonan ? \Carbon\Carbon::parse($form_pemusnahan->tanggal_permohonan)->format('d/m/Y') : '' }}</div>
        </div>
        <div class="pemohon-row">
            <div class="pemohon-label">Nama &amp; NIP</div>
            <div>: {{ $form_pemusnahan->nama_nip }}</div>
        </div>
        <div class="pemohon-row">
            <div class="pemohon-label">Unit Kerja</div>
            <div>: {{ $form_pemusnahan->unit_kerja }}</div>
        </div>

        <p style="margin: 15px 0 10px;">dengan ini mengajukan permohonan pemusnahan aset sebagai berikut:</p>

        <div class="table-responsive">
        <table class="main-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 22%;">Nama Aset</th>
                    <th style="width: 20%;">Jenis Aset</th>
                    <th style="width: 18%;">ID Aset</th>
                    <th style="width: 35%;">Alasan Pemusnahan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($form_pemusnahan->items as $i => $item)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $item->nama_aset }}</td>
                    <td>{{ $item->jenis_aset }}</td>
                    <td>{{ $item->id_aset }}</td>
                    <td>{{ $item->alasan_pemusnahan }}</td>
                </tr>
                @empty
                <tr><td class="text-center" colspan="5">&nbsp;</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>

        <p style="margin: 20px 0 0;">Demikian permohonan ini disampaikan.</p>

        <div class="footer-place-row" style="display: flex; justify-content: space-between;">
            <div style="width: 45%;"></div>
            <div style="width: 45%; text-align: center;">
                {{ $form_pemusnahan->tempat_persetujuan ?: '.......................' }},
                {{ $form_pemusnahan->tanggal_persetujuan ? \Carbon\Carbon::parse($form_pemusnahan->tanggal_persetujuan)->locale('id')->translatedFormat('j  F  Y') : '.......... - .......... - ..............' }}
            </div>
        </div>

        <div class="signature-columns">
            <div class="signature-box">
                <p style="font-weight: bold; margin: 0 0 10px;">Atasan Pengguna Aset</p>
                <div class="signature-space"></div>
                <p style="margin: 0;">( {{ $form_pemusnahan->nama_atasan ?: '..................................................' }} )</p>
            </div>
            <div class="signature-box">
                <p style="font-weight: bold; margin: 0 0 10px;">Pengelola Aset</p>
                <div class="signature-space"></div>
                <p style="margin: 0;">( {{ $form_pemusnahan->nama_pengelola ?: '..................................................' }} )</p>
            </div>
        </div>

        <div class="approval-section">
            <p style="margin: 0 0 6px;">
                {{ $form_pemusnahan->keputusan === 'setuju' ? 'Menyetujui' : ($form_pemusnahan->keputusan === 'tidak_setuju' ? 'Tidak Menyetujui' : 'Menyetujui / Tidak Menyetujui') }} *,
            </p>
            <p style="margin: 0;">VP IT Operation/ Pimpinan Unit Sistem Informasi Daerah</p>
            <div class="approval-space"></div>
            <p style="margin: 0;">( {{ $form_pemusnahan->nama_vp ?: '..................................................' }} )</p>
        </div>
    </div>

    @if(request('print'))
    <script>
        window.onload = function () {
            window.print();
        };
        // Setelah dialog print ditutup (baik jadi print maupun di-cancel),
        // otomatis kembali ke halaman daftar formulir.
        window.addEventListener('afterprint', function () {
            window.location.href = "{{ route('form-pemusnahan.index') }}";
        });
    </script>
    @endif
</body>
</html>
