<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Berita Acara IT - {{ $baItService->pemohon_nama }}</title>
    <style>
        @page {
            size: 215.9mm 330.2mm;
            margin: 1cm 1.5cm 3cm 2.2cm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #000;
            background: white;
            margin: 0;
            padding: 0;
        }
        .table-kop, .table-penanganan {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .table-kop th, .table-kop td, .table-penanganan th, .table-penanganan td {
            border: 1px solid black;
            padding: 4px 6px;
            vertical-align: middle;
        }
    </style>
</head>
<body onload="window.print()">
    <div>
        <!-- 1. KOP SURAT DENGAN GARIS PEMISAH -->
        <table class="table-kop" style="width: 100%; border-collapse: collapse; border: 1px solid black;">
            <tr>
                <!-- Kolom Kiri: Logo KAI & Box TERBATAS (Dipisah Garis di Tengah) -->
                <td style="width: 20%; text-align: center; border: 1px solid black; padding: 0; vertical-align: middle;">
                    <div style="padding: 6px 4px; border-bottom: 1px solid black;">
                        <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI" style="height: 26px; object-fit: contain; margin: 0 auto; display: block;">
                    </div>
                    <div style="padding: 4px; background-color: #ffffff;">
                        <div style="border: 2px solid #eab308; color: #ca8a04; font-weight: bold; font-size: 10px; text-align: center; padding: 2px 0; letter-spacing: 1px; background-color: #fefce8;">
                            TERBATAS
                        </div>
                    </div>
                </td>

                <!-- Kolom Tengah: Judul Instansi (Dipisah Garis di Tengah) -->
                <td style="width: 50%; font-weight: bold; font-size: 12px; text-align: center; border: 1px solid black; padding: 0; vertical-align: middle;">
                    <div style="padding: 8px 6px; border-bottom: 1px solid black; font-size: 11px;">
                        PT KERETA API INDONESIA (PERSERO)<br>
                        SISTEM INFORMASI
                    </div>
                    <div style="padding: 8px 6px; font-size: 10.5px;">
                        BERITA ACARA INSTALASI DAN<br>
                        TROUBLESHOOTING LAYANAN IT
                    </div>
                </td>

                <!-- Kolom Kanan: 4 Baris Detail Dokumen -->
                <td style="width: 30%; border: 1px solid black; padding: 0; vertical-align: middle;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 10px;">
                        <tr>
                            <td style="border-bottom: 1px solid black; border-right: 1px solid black; padding: 3px 5px; width: 35%;">Nomor</td>
                            <td style="border-bottom: 1px solid black; padding: 3px 5px;">
                                <input type="text" name="no_dokumen" class="input-borderless" value="FR.SM/IT/011.005/10-2020" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-bottom: 1px solid black; border-right: 1px solid black; padding: 3px 5px;">Tanggal</td>
                            <td style="border-bottom: 1px solid black; padding: 3px 5px;">12 Oktober 2020</td>
                        </tr>
                        <tr>
                            <td style="border-bottom: 1px solid black; border-right: 1px solid black; padding: 3px 5px;">Versi</td>
                            <td style="border-bottom: 1px solid black; padding: 3px 5px;">002-2020</td>
                        </tr>
                        <tr>
                            <td style="border-right: 1px solid black; padding: 3px 5px;">Halaman</td>
                            <td style="padding: 3px 5px;">1 dari 2</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- 2. DATA REFERENSI -->
        <table style="width: 40%; border-collapse: collapse; margin-bottom: 15px;" border="1">
            <tr><td style="padding: 2px 5px; width: 40%;">No. Ref</td><td>{{ $baItService->no_ref ?? '-' }}</td></tr>
            <tr><td style="padding: 2px 5px;">Tanggal</td><td>{{ $baItService->tgl_ref ?? '-' }}</td></tr>
            <tr><td style="padding: 2px 5px;">Business Area</td><td>{{ $baItService->business_area ?? '-' }}</td></tr>
        </table>

        <!-- 3. DATA PEMOHON -->
        <div style="margin-bottom: 15px; line-height: 1.8;">
            <strong>Permintaan Layanan dari :</strong><br>
            <table style="width: 100%; border: none;">
                <tr><td style="width: 15%; border:none;">Nama</td><td style="border:none;">: <b>{{ $baItService->pemohon_nama }}</b></td></tr>
                <tr><td style="border:none;">Unit</td><td style="border:none;">: <b>{{ $baItService->pemohon_unit }}</b></td></tr>
                <tr><td style="border:none;">Telepon / Email</td><td style="border:none;">: {{ $baItService->pemohon_kontak ?? '-' }}</td></tr>
                <tr><td style="border:none;">Waktu Pengerjaan</td>
                    <td style="border:none;">: 
                        Mulai: {{ $baItService->waktu_mulai ? $baItService->waktu_mulai->format('d-m-Y H:i') : '-' }} s.d 
                        Selesai: {{ $baItService->waktu_selesai ? $baItService->waktu_selesai->format('d-m-Y H:i') : '-' }}
                    </td>
                </tr>
            </table>
        </div>

        <!-- 4. TABEL PENANGANAN (INTI) -->
        @php
            $detail = $baItService->detail_penanganan ?? [];
            $rows = [
                ['no' => '1.1', 'key' => '1_1', 'label' => '1.1 Aplikasi'],
                ['no' => '1.2', 'key' => '1_2', 'label' => '1.2 Jaringan'],
                ['no' => '1.3', 'key' => '1_3', 'label' => '1.3 PC / Laptop'],
                ['no' => '1.4', 'key' => '1_4', 'label' => '1.4 Printer'],
                ['no' => '1.5', 'key' => '1_5', 'label' => '1.5 Lainnya'],
                ['no' => '2.1', 'key' => '2_1', 'label' => '2.1 Aplikasi'],
                ['no' => '2.2', 'key' => '2_2', 'label' => '2.2 Sistem Operasi'],
                ['no' => '2.3', 'key' => '2_3', 'label' => '2.3 Jaringan'],
            ];
        @endphp

        <strong>Hasil Penanganan Instalasi dan/atau <i>Troubleshooting</i> :</strong>
        <table class="table-penanganan">
            <tr>
                <td colspan="6" style="border-bottom: 2px solid black;">
                    <strong>Nomor Inventaris Aset :</strong> {{ $baItService->no_inventaris_aset ?? '-' }}
                </td>
            </tr>
            <tr style="text-align: center; font-weight: bold; background-color: #f9fafb;">
                <td rowspan="2" style="width: 3%;">No.</td>
                <td rowspan="2" style="width: 15%;">Kategori Layanan</td>
                <td rowspan="2" style="width: 20%;">Jenis Layanan</td>
                <td rowspan="2" style="width: 35%;">Detail Pekerjaan</td>
                <td colspan="2" style="width: 7%;">Status</td>
                <td rowspan="2" style="width: 20%;">Keterangan</td>
            </tr>
            <tr style="text-align: center; font-weight: bold; background-color: #f9fafb;">
                <td>V</td>
                <td>X</td>
            </tr>

            @foreach($rows as $idx => $r)
                @php
                    $st = $detail[$r['key']]['status'] ?? '';
                    $det = $detail[$r['key']]['detail'] ?? '';
                    $ket = $detail[$r['key']]['keterangan'] ?? '';
                @endphp
                <tr>
                    @if($idx == 0)
                        <td rowspan="5" style="text-align: center;">1</td>
                        <td rowspan="5" style="text-align: center; font-style: italic;">Troubleshooting</td>
                    @elseif($idx == 5)
                        <td rowspan="3" style="text-align: center;">2</td>
                        <td rowspan="3" style="text-align: center;">Instalasi</td>
                    @endif
                    <td>{{ $r['label'] }}</td>
                    <td>{{ $det }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ $st == 'V' ? 'V' : '' }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ $st == 'X' ? 'X' : '' }}</td>
                    <td>{{ $ket }}</td>
                </tr>
            @endforeach
        </table>
        <div style="font-size: 10px; margin-bottom: 15px;"><i>* V : Selesai, X : Gagal</i></div>

        <!-- 5. TANDA TANGAN -->
        <p style="margin-bottom: 25px;">
            Menyatakan bahwa penanganan instalasi dan atau <i>troubleshooting</i> telah diperiksa dan dilakukan oleh pihak Sistem Informasi dan pihak <b>{{ $baItService->pihak_terkait ?? '....................' }}</b> dengan hasil seperti dijelaskan diatas.<br>
            Selanjutnya, Diterima / Ditolak *)
        </p>

        <table style="width: 100%; text-align: center; border: none;">
            <tr>
                <td style="width: 33%; border: none;">Staf IT<br><br><br><br><br>____________________<br>NIPP: {{ $baItService->ttd_staf_nipp ?? '-' }}</td>
                <td style="width: 33%; border: none;">Mengetahui,<br><br><br><br><br>____________________<br>NIPP: {{ $baItService->ttd_mengetahui_nipp ?? '-' }}</td>
                <td style="width: 33%; border: none;">User,<br><br><br><br><br>____________________<br>NIPP: {{ $baItService->ttd_user_nipp ?? '-' }}</td>
            </tr>
        </table>
    </div>
</body>
</html>