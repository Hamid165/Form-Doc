<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rencana Pelatihan Personil - Cetak</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #e2e8f0; margin: 0; padding: 30px 20px; display: flex; flex-direction: column; align-items: center; }
        .a4-container { background-color: white; width: 210mm; min-height: 297mm; padding: 15mm 20mm; box-shadow: 0 10px 25px rgba(0,0,0,0.1); box-sizing: border-box; color: #000; position: relative; margin-bottom: 20px; font-size: 11px; display: flex; flex-direction: column; }
        .a4-container-landscape { background-color: white; width: 297mm; min-height: 210mm; padding: 15mm 20mm; box-shadow: 0 10px 25px rgba(0,0,0,0.1); box-sizing: border-box; color: #000; position: relative; margin-bottom: 20px; font-size: 11px; display: flex; flex-direction: column; }

        /* Kop Surat */
        .kop-table { width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 25px; }
        .kop-table td { border: 1px solid #000; padding: 5px 8px; vertical-align: middle; }
        .terbatas-box { border: 2px solid #eab308; color: #eab308; font-weight: bold; font-size: 14px; padding: 4px 8px; display: inline-block; text-align: center; }

        /* Tabel Data Dinamis */
        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 10px; text-align: center; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 5px; position: relative; height: 25px; vertical-align: middle;}
        .data-table th { font-weight: bold; background-color: #f9fafb; }

        /* Tombol Aksi */
        .btn-print { width: 100px; height: 36px; line-height: 36px; background-color: #16a34a; color: white; border: none; cursor: pointer; border-radius: 6px; font-weight: bold; text-align: center; display: inline-block; }
        .btn-kembali { width: 100px; height: 36px; line-height: 36px; background-color: #ef4444; color: white; border: none; cursor: pointer; border-radius: 6px; font-weight: bold; text-align: center; display: inline-block; text-decoration: none; }

        /* Halaman Spesifik Styles */
        .cover-top { display: flex; align-items: center; margin-bottom: 120px; }
        .cover-title { text-align: center; font-size: 22px; font-weight: bold; line-height: 1.5; margin-bottom: auto; }
        .cover-meta { width: 100%; border-collapse: collapse; font-size: 12px; border-top: 4px solid #000; border-bottom: 4px solid #000; margin-top: auto; }
        .cover-meta td { border: 1px solid #000; padding: 8px 10px; }
        .cover-meta th { border: 1px solid #000; padding: 8px 10px; text-align: left; width: 35%; font-weight: normal; }

        .pengesahan-box { width: 100%; border: 1px solid #000; text-align: center; font-size: 11px; margin-top: 10px; }
        .pengesahan-header { padding: 8px; border-bottom: 1px solid #000; font-weight: bold; background-color: #f9fafb; }
        .pengesahan-body { height: 90px; display: flex; flex-direction: column; justify-content: flex-end; padding-bottom: 10px; font-weight: bold; }

        .daftar-isi-row { display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 12px; }
        .daftar-isi-dots { flex-grow: 1; border-bottom: 1px dotted #000; margin: 0 10px; position: relative; top: -4px; }

        .text-red-placeholder { color: red; font-style: italic; }

        /* --- PERBAIKAN PENGATURAN CETAK PRESISI --- */
        @page { size: A4 portrait; margin: 0; }
        @page landscape_page { size: A4 landscape; margin: 0; }

        .page-landscape { page: landscape_page; }

        @media print {
            body {
                margin: 0;
                padding: 0;
                background-color: white;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                display: block !important; /* Kunci perbaikan: Mematikan flex centering saat di-print */
            }
            .a4-container {
                box-shadow: none;
                margin: 0;
                width: 210mm;
                height: 296mm; /* Dibuat sedikit di bawah 297 untuk menghindari extra blank page */
                padding: 15mm 20mm;
                page-break-after: always;
                border: none;
            }
            .a4-container-landscape {
                box-shadow: none;
                margin: 0;
                width: 297mm;
                height: 209mm; /* Dibuat sedikit di bawah 210 untuk menghindari extra blank page */
                padding: 15mm 20mm;
                page-break-after: always;
                border: none;
            }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="width: 210mm; display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 20px;">
        <a href="{{ route('form-rencana-pelatihan.index') }}" class="btn-kembali">Kembali</a>
        <button onclick="window.print()" class="btn-print">Print PDF</button>
    </div>

    @php
        $kopSurat = function($hal) use ($form) {
            return '
            <table class="kop-table">
                <tr>
                    <td rowspan="2" style="width: 20%; text-align: center;"><img src="'.asset('images/logo-kai.svg').'" style="width: 80px;"></td>
                    <td rowspan="2" style="width: 45%; text-align: center; font-weight: bold; font-size: 12px;">PT. KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI</td>
                    <td style="width: 10%;">Nomor</td><td style="width: 25%;">'.$form->no_dokumen.'</td>
                </tr>
                <tr><td>Tanggal</td><td>'.$form->tanggal_terbit.'</td></tr>
                <tr>
                    <td rowspan="2" style="text-align: center; padding: 8px;"><div class="terbatas-box">TERBATAS</div></td>
                    <td rowspan="2" style="text-align: center; font-weight: bold; font-size: 11px;">RENCANA PELATIHAN DAN PENINGKATAN<br>KOMPETENSI PERSONIL</td>
                    <td>Versi</td><td>'.$form->versi.'</td>
                </tr>
                <tr><td>Halaman</td><td>'.$hal.'</td></tr>
            </table>';
        };

        $kopSuratLandscape = function($hal) use ($form) {
            return '
            <table class="kop-table">
                <tr>
                    <td rowspan="2" style="width: 15%; text-align: center;"><img src="'.asset('images/logo-kai.svg').'" style="width: 80px;"></td>
                    <td rowspan="2" style="width: 55%; text-align: center; font-weight: bold; font-size: 12px;">PT. KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI</td>
                    <td style="width: 10%;">Nomor</td><td style="width: 20%;">'.$form->no_dokumen.'</td>
                </tr>
                <tr><td>Tanggal</td><td>'.$form->tanggal_terbit.'</td></tr>
                <tr>
                    <td rowspan="2" style="text-align: center; padding: 8px;"><div class="terbatas-box">TERBATAS</div></td>
                    <td rowspan="2" style="text-align: center; font-weight: bold; font-size: 11px;">RENCANA PELATIHAN DAN PENINGKATAN<br>KOMPETENSI PERSONIL</td>
                    <td>Versi</td><td>'.$form->versi.'</td>
                </tr>
                <tr><td>Halaman</td><td>'.$hal.'</td></tr>
            </table>';
        };
    @endphp

    <!-- HALAMAN 1: COVER -->
    <div class="a4-container">
        <div class="cover-top">
            <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI" style="width: 100px; margin-right: 20px;">
            <div style="font-weight: bold; font-size: 14px;">PT. KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI</div>
        </div>

        <div class="cover-title">
            RENCANA PELATIHAN DAN PENINGKATAN<br>KOMPETENSI PERSONIL
        </div>

        <table class="cover-meta">
            <tr><th>Nomor Dokumen</th><td>{{ $form->no_dokumen }}</td></tr>
            <tr><th>Tanggal Terbit</th><td>{{ $form->tanggal_terbit }}</td></tr>
            <tr><th>Versi</th><td>{{ $form->versi }}</td></tr>
            <tr><th>Pemilik Dokumen</th><td>{{ $form->pemilik_dokumen }}</td></tr>
            <tr><th>Klasifikasi</th><td><div class="terbatas-box" style="padding: 2px 8px; font-size: 12px;">TERBATAS</div></td></tr>
        </table>
    </div>

    <!-- HALAMAN 2: LEMBAR PENGESAHAN -->
    <div class="a4-container page-break">
        {!! $kopSurat('i dari iii') !!}

        <h3 style="text-align: center; font-size: 13px; margin-bottom: 25px;">LEMBAR PENGESAHAN</h3>

        <div style="text-align: center; font-size: 11px; font-weight: bold; margin-bottom: 5px;">Penyusun</div>
        <table class="data-table">
            <thead>
                <tr><th style="width: 8%;">No.</th><th style="width: 35%;">Nama</th><th style="width: 27%;">NIPP</th><th style="width: 30%;">Jabatan</th></tr>
            </thead>
            <tbody>
                @php
                    $penyusuns = $form->penyusun ?? [];
                    $maxPenyusun = max(1, count($penyusuns));
                @endphp
                @for($i = 0; $i < $maxPenyusun; $i++)
                @php $p = $penyusuns[$i] ?? ['nama'=>'', 'nipp'=>'', 'jabatan'=>'']; @endphp
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $p['nama'] }}</td>
                    <td>{{ $p['nipp'] }}</td>
                    <td>{{ $p['jabatan'] }}</td>
                </tr>
                @endfor
            </tbody>
        </table>

        <div style="text-align: center; font-size: 11px; font-weight: bold; margin-top: 40px;">Pengesahan</div>
        <div class="pengesahan-box">
            <div class="pengesahan-header">Disetujui Oleh :<br>Subdivision Head of IT Planning & Governance</div>
            <div class="pengesahan-body">
                <div><span style="text-decoration: underline;">{{ $form->disetujui_nama ?: '..........................................................' }}</span></div>
                <div>NIPP. {{ $form->disetujui_nipp ?: '...........................' }}</div>
            </div>
            <div class="pengesahan-header" style="border-top: 1px solid #000;">Disahkan Oleh :<br>Division Head of Information System</div>
            <div class="pengesahan-body">
                <div><span style="text-decoration: underline;">{{ $form->disahkan_nama ?: '..........................................................' }}</span></div>
                <div>NIPP. {{ $form->disahkan_nipp ?: '...........................' }}</div>
            </div>
        </div>
    </div>

    <!-- HALAMAN 3: RIWAYAT PERUBAHAN -->
    <div class="a4-container page-break">
        {!! $kopSurat('ii dari iii') !!}

        <h3 style="text-align: center; font-size: 13px; margin-bottom: 25px;">RIWAYAT PERUBAHAN</h3>
        <table class="data-table">
            <thead>
                <tr><th style="width:10%">Versi</th><th style="width:25%">Penyusun /<br>Pelaksana Revisi</th><th style="width:20%">Tanggal Revisi</th><th style="width:10%">Hal</th><th style="width:35%">Keterangan Perubahan</th></tr>
            </thead>
            <tbody>
                @php
                    $riwayats = $form->riwayat_perubahan ?? [];
                    $maxRiwayat = max(1, count($riwayats));
                @endphp
                @for($i = 0; $i < $maxRiwayat; $i++)
                @php $r = $riwayats[$i] ?? ['versi'=>'', 'penyusun'=>'', 'tanggal'=>'', 'hal'=>'', 'keterangan'=>'']; @endphp
                <tr>
                    <td>{{ $r['versi'] }}</td>
                    <td>{{ $r['penyusun'] }}</td>
                    <td>{{ $r['tanggal'] }}</td>
                    <td>{{ $r['hal'] }}</td>
                    <td style="text-align: left;">{{ $r['keterangan'] }}</td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>

    <!-- HALAMAN 4: DAFTAR ISI -->
    <div class="a4-container page-break">
        {!! $kopSurat('iii dari iii') !!}

        <h3 style="text-align: center; font-size: 14px; margin-bottom: 50px; font-weight: bold;">DAFTAR ISI</h3>

        <div style="padding: 0 10px;">
            <div style="text-align: right; margin-bottom: 10px; font-size: 12px;">Hal.</div>

            <div class="daftar-isi-row"><span>LEMBAR PENGESAHAN</span><span class="daftar-isi-dots"></span><span>i</span></div>
            <div class="daftar-isi-row"><span>RIWAYAT PERUBAHAN</span><span class="daftar-isi-dots"></span><span>ii</span></div>
            <div class="daftar-isi-row"><span>DAFTAR ISI</span><span class="daftar-isi-dots"></span><span>iii</span></div>
            <div class="daftar-isi-row"><span>1. ANALISA KEBUTUHAN PELATIHAN DAN PENINGKATAN KOMPETENSI</span><span class="daftar-isi-dots"></span><span>1</span></div>
            <div class="daftar-isi-row"><span>2. PENGKAJIAN DOKUMEN</span><span class="daftar-isi-dots"></span><span>1</span></div>
        </div>
    </div>

    <!-- HALAMAN 5 (LANDSCAPE) -->
    <div class="a4-container-landscape page-landscape page-break">
        {!! $kopSuratLandscape('1 dari 1') !!}

        <div style="font-size: 11px; font-weight: bold; margin-bottom: 10px;">1. <span style="margin-left: 10px;">ANALISA KEBUTUHAN PELATIHAN DAN PENINGKATAN KOMPETENSI</span></div>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 4%;">No</th>
                    <th style="width: 14%;">Nama Personil</th>
                    <th style="width: 14%;">Jabatan / Peran</th>
                    <th style="width: 26%;">Kebutuhan Peningkatan<br>Kompetensi</th>
                    <th style="width: 16%;">Metode</th>
                    <th style="width: 14%;">Rencana Realisasi</th>
                    <th style="width: 12%;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $analisas = $form->analisa_kebutuhan ?? [];
                    $maxAnalisa = max(1, count($analisas));
                @endphp
                @for($i = 0; $i < $maxAnalisa; $i++)
                @php $a = $analisas[$i] ?? ['nama'=>'', 'jabatan'=>'', 'kebutuhan'=>'', 'metode'=>'', 'realisasi'=>'', 'keterangan'=>'']; @endphp
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td class="{{ empty($a['nama']) && $i == 0 ? 'text-red-placeholder' : '' }}">{!! empty($a['nama']) && $i == 0 ? '(Berisi nama personil)' : $a['nama'] !!}</td>
                    <td class="{{ empty($a['jabatan']) && $i == 0 ? 'text-red-placeholder' : '' }}">{!! empty($a['jabatan']) && $i == 0 ? '(Berisi jenis peran /<br>jabatan dari personil)' : $a['jabatan'] !!}</td>
                    <td class="{{ empty($a['kebutuhan']) && $i == 0 ? 'text-red-placeholder' : '' }}">{!! empty($a['kebutuhan']) && $i == 0 ? '(Berisi rencana peningkatan yang<br>dibutuhkan / akan dilakukan)' : $a['kebutuhan'] !!}</td>
                    <td class="{{ empty($a['metode']) && $i == 0 ? 'text-red-placeholder' : '' }}">{!! empty($a['metode']) && $i == 0 ? '(Berisi cara pelaksanaan<br>peningkatan, misal: pelatihan,<br>pendidikan formal, dll)' : $a['metode'] !!}</td>
                    <td class="{{ empty($a['realisasi']) && $i == 0 ? 'text-red-placeholder' : '' }}">{!! empty($a['realisasi']) && $i == 0 ? '(target waktu<br>pelaksanaan<br>peningkatan)' : $a['realisasi'] !!}</td>
                    <td class="{{ empty($a['keterangan']) && $i == 0 ? 'text-red-placeholder' : '' }}">{!! empty($a['keterangan']) && $i == 0 ? '(berisi keterangan<br>lebih lanjut jika<br>ada)' : $a['keterangan'] !!}</td>
                </tr>
                @endfor
            </tbody>
        </table>

        <div style="font-size: 11px; font-weight: bold; margin-bottom: 10px; margin-top: 25px;">2. <span style="margin-left: 10px;">PENGKAJIAN DOKUMEN</span></div>
        <div style="font-size: 11px; line-height: 1.8; text-align: justify; padding-left: 22px;">
            <p style="margin-top: 0; margin-bottom: 15px;">Dokumen ini dikelola oleh Pengelola Dokumen. Setiap masukan perubahan terhadap dokumen ini harus diajukan kepada Pengelola Dokumen dan perubahannya disetujui oleh pemegang kewenangan sesuai ketentuan yang berlaku di PT. Kereta Api Indonesia (Persero).</p>
            <p style="margin-top: 0;">Dokumen ini harus ditinjau ulang secara berkala oleh Pengelola Dokumen paling sedikit 1 (satu) kali dalam 1 (satu) tahun untuk memastikan kesesuaiannya dengan kondisi organisasi.</p>
        </div>
    </div>
</body>
</html>
