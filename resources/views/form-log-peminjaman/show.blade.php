<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Peminjaman Informasi / Dokumen KAI</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #e2e8f0; margin: 0; padding: 30px 20px; display: flex; flex-direction: column; align-items: center; }
        .a4-container { background-color: white; width: 297mm; min-height: 210mm; padding: 15mm 20mm; box-shadow: 0 10px 25px rgba(0,0,0,0.1); box-sizing: border-box; color: #000; position: relative; margin-bottom: 20px; font-size: 11px; }
        .kop-table { width: 100%; border-collapse: collapse; font-size: 11px; }
        .kop-table td { border: 1px solid #000; padding: 5px 8px; vertical-align: middle; }
        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 10px; text-align: center; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 5px; }

        .btn-print { width: 100px; height: 36px; line-height: 36px; background-color: #16a34a; color: white; border: none; cursor: pointer; border-radius: 6px; font-weight: bold; text-align: center; display: inline-block; }
        .btn-kembali { width: 100px; height: 36px; line-height: 36px; background-color: #ef4444; color: white; border: none; cursor: pointer; border-radius: 6px; font-weight: bold; text-align: center; display: inline-block; text-decoration: none; }

        @page { size: A4 landscape; margin: 10mm 15mm; }
        @media print {
            body { margin: 0; padding: 0; background-color: white; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .a4-container { box-shadow: none; padding: 0; margin: 0; width: 100%; height: auto; min-height: auto; margin-bottom: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    @php
        $tgl_ref = $form->tanggal_ref;
        try { if($tgl_ref) $tgl_ref = \Carbon\Carbon::parse($tgl_ref)->locale('id')->translatedFormat('d F Y'); } catch(\Exception $e) {}

        $items = collect($form->details)->toArray();
    @endphp

    <div class="no-print" style="width: 297mm; display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 20px;">
        <a href="{{ route('form-log-peminjaman.index') }}" class="btn-kembali">Kembali</a>
        <button onclick="window.print()" class="btn-print">Print PDF</button>
    </div>

    <div class="a4-container">
        <table class="kop-table">
            <tr>
                <td rowspan="2" style="width: 15%; text-align: center; vertical-align: middle;">
                    <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI" style="width: 100%; max-width: 90px; height: auto; display: inline-block;">
                </td>
                <td rowspan="2" style="width: 45%; text-align: center; font-weight: bold; font-size: 12px;">
                    PT KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI
                </td>
                <td style="width: 10%;">Nomor</td>
                <td style="width: 30%;">{{ $template->no_dokumen ?? 'FR.SM/TI/004.004/10-2020' }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>{{ $template->tanggal_dokumen ?? '12 Oktober 2020' }}</td>
            </tr>
            <tr>
                <td rowspan="2" style="text-align: center; padding: 10px;">
                    <div style="border: 2px solid #eadc04; color: #eadc04; font-weight: bold; font-size: 14px; padding: 6px 12px; display: inline-block;">TERBATAS</div>
                </td>
                <td rowspan="2" style="text-align: center; font-weight: bold; font-size: 12px;">
                    FORMULIR<br>LOG PEMINJAMAN INFORMASI / DOKUMEN
                </td>
                <td>Versi</td>
                <td>{{ $template->versi_dokumen ?? '002-2020' }}</td>
            </tr>
            <tr>
                <td>Halaman</td>
                <td>1 dari 1</td>
            </tr>
        </table>

        <table style="border-collapse: collapse; width: 350px; font-size: 11px; margin-top: 20px; margin-bottom: 20px;">
            <tr>
                <td style="border: 1px solid black; padding: 4px 6px; width: 100px;">No. Ref</td>
                <td style="border: 1px solid black; padding: 4px 6px; width: 10px; border-right: none;">:</td>
                <td style="border: 1px solid black; padding: 4px 6px; border-left: none;">{{ $form->no_ref }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 4px 6px;">Tanggal</td>
                <td style="border: 1px solid black; padding: 4px 6px; border-right: none;">:</td>
                <td style="border: 1px solid black; padding: 4px 6px; border-left: none;">{{ $tgl_ref }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 4px 6px;">Business Area</td>
                <td style="border: 1px solid black; padding: 4px 6px; border-right: none;">:</td>
                <td style="border: 1px solid black; padding: 4px 6px; border-left: none;">{{ $form->business_area }}</td>
            </tr>
        </table>

        <table class="data-table">
            <thead>
                <tr style="background-color: #f1f5f9;">
                    <th style="width: 3%;">No.</th>
                    <th style="width: 15%;">Nama Informasi / Dokumen</th>
                    <th style="width: 12%;">Nama Peminjam</th>
                    <th style="width: 12%;">Unit Kerja / Instansi</th>
                    <th style="width: 8%;">Tanggal Pinjam</th>
                    <th style="width: 10%;">Paraf Peminjam</th>
                    <th style="width: 8%;">Tanggal Kembali</th>
                    <th style="width: 10%;">Paraf Peminjam</th>
                    <th style="width: 10%;">Paraf P. Jawab</th>
                    <th style="width: 12%;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item['nama_informasi'] ?? '' }}</td>
                        <td>{{ $item['nama_peminjam'] ?? '' }}</td>
                        <td>{{ $item['unit_kerja'] ?? '' }}</td>
                        <td>{{ $item['tanggal_pinjam'] ?? '' }}</td>
                        <td>{{ $item['paraf_peminjam_pinjam'] ?? '' }}</td>
                        <td>{{ $item['tanggal_kembali'] ?? '' }}</td>
                        <td>{{ $item['paraf_peminjam_kembali'] ?? '' }}</td>
                        <td>{{ $item['paraf_p_jawab'] ?? '' }}</td>
                        <td>{{ $item['keterangan'] ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

<script>
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('print')) {
        setTimeout(function() {
            window.print();
        }, 500);
    }
</script>

</body>
</html>