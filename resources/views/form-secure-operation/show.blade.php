<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Secure Operation - {{ $form->no_ref ?? 'Cetak' }}</title>
    <!-- Kamu bisa menyesuaikan path favicon jika ada -->
    <link rel="icon" href="{{ asset('images/favicon.svg') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .a4-container {
            background-color: white;
            width: 210mm; /* Lebar standar A4 */
            min-height: 297mm; /* Tinggi standar A4 */
            padding: 25mm 20mm;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            box-sizing: border-box;
            color: #000;
            position: relative;
        }
        /* Tabel Kop Surat */
        .kop-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 11px; }
        .kop-table td { border: 1px solid #000; padding: 4px 6px; vertical-align: middle; }
        .logo-cell { width: 15%; text-align: center; font-size: 24px; font-weight: 900; font-style: italic; letter-spacing: -1px; height: 38px; }
        .logo-k { color: #1f3b7c; } .logo-a { color: #e86424; } .logo-i { color: #1f3b7c; }
        .title-cell { text-align: center; font-weight: bold; font-size: 12px; width: 45%; }
        .info-label { width: 15%; font-size: 11px; }
        .info-value { width: 25%; font-size: 11px; }

        /* Tabel Referensi */
        .ref-table { width: 35%; border-collapse: collapse; margin-bottom: 20px; font-size: 11px; }
        .ref-table td { border: 1px solid #000; padding: 4px; }
        .ref-label { width: 40%; }

        /* Tabel Box Deskripsi & Checklist */
        .box-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 11px; }
        .box-table th, .box-table td { border: 1px solid #000; padding: 6px; vertical-align: top; word-break: break-word; }
        .box-header { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        
        /* Area Baris Data Deskripsi */
        .desc-row { display: flex; margin-bottom: 6px; line-height: 1.5; }
        .desc-label { width: 130px; }
        .desc-colon { width: 10px; }
        .desc-val { flex: 1; font-weight: normal; border-bottom: 1px dotted #ccc; word-break: break-word; }

        /* Buttons & Preview styles */
        .btn-kembali {
            width: 100px; height: 36px; line-height: 36px; padding: 0; 
            background-color: #f44336; color: white; border: none; cursor: pointer; 
            border-radius: 4px; font-weight: bold; font-family: inherit; font-size: 13px; 
            text-decoration: none; text-align: center; box-sizing: border-box; display: inline-block;
            transition: background-color 0.2s;
        }
        .btn-kembali:hover { background-color: #d32f2f; }
        .btn-print {
            width: 100px; height: 36px; line-height: 36px; padding: 0; 
            background-color: #4CAF50; color: white; border: none; cursor: pointer; 
            border-radius: 4px; font-weight: bold; font-family: inherit; font-size: 13px; 
            text-align: center; box-sizing: border-box; display: inline-block;
            transition: background-color 0.2s;
        }
        .btn-print:hover { background-color: #388e3c; }

        /* =========================================
           PENGATURAN KHUSUS SAAT DI-PRINT 
           ========================================= */
        @media print {
            /* Bersihkan background */
            body { margin: 0; padding: 0; background-color: white; }
            
            /* Pertahankan margin kiri-kanan (20mm), pangkas atas-bawah agar lebih lega (12mm) */
            .a4-container { 
                box-shadow: none; 
                width: 100%; 
                padding: 12mm 20mm !important; 
            }
            
            /* Sembunyikan tombol */
            .no-print { display: none !important; }

            /* Rapatkan spasi antar tabel agar menghemat ruang vertikal */
            .kop-table, .ref-table, .box-table { 
                margin-bottom: 10px !important; 
            }

            /* Rapatkan bantalan (padding) dalam tabel deskripsi & checklist */
            .box-table th, .box-table td { 
                padding: 4px 6px !important; 
            }

            /* Tarik area tanda tangan ke atas */
            .ttd-table { 
                margin-top: 10px !important; 
            }
        }
        @page { size: A4 portrait; margin: 0mm; }
    </style>
</head>
<body>
    <div class="a4-container">
        <!-- Tombol Aksi (Hilang saat diprint) -->
        <div class="no-print" style="position: absolute; top: 15px; right: 20px; display: flex; gap: 10px; z-index: 100;">
            <a href="{{ route('form-secure-operation.index') }}" class="btn-kembali">Kembali</a>
            <button onclick="window.print()" class="btn-print">Print</button>
        </div>

        <!-- Kop Surat -->
        <table class="kop-table" style="width: 100%; border-collapse: collapse; border: 1px solid #000; margin-bottom: 20px;">
            <tr>
                <td rowspan="2" style="width: 20%; text-align: center; vertical-align: middle; border: 1px solid #000; padding: 10px;">
                    <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI" style="width: 100%; max-width: 90px; height: auto; display: inline-block;">
                </td>
                <td rowspan="2" style="width: 45%; text-align: center; font-weight: bold; font-size: 12px; border: 1px solid #000; padding: 10px;">
                    PT KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI
                </td>
                <td style="width: 12%; border: 1px solid #000; padding: 5px;">Nomor</td>
                <!-- Variabel Dinamis No Dokumen -->
                <td style="width: 23%; border: 1px solid #000; padding: 5px;">: {{ $kategoriForm->no_dokumen ?? 'FR.SM/TI/013.004/10-2020' }}</td> 
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 5px;">Tanggal</td>
                <!-- Variabel Dinamis Tanggal -->
                <td style="border: 1px solid #000; padding: 5px;">: {{ $kategoriForm->tanggal_dokumen ?? '12 Oktober 2020' }}</td>
            </tr>
            <tr>
                <td rowspan="2" style="text-align: center; padding: 10px; border: 1px solid #000; vertical-align: middle;">
                    <div style="border: 2px solid #eadc04; color: #eadc04; font-weight: bold; font-size: 14px; padding: 6px 12px; display: inline-block;">TERBATAS</div>
                </td>
                <td rowspan="2" style="text-align: center; font-weight: bold; font-size: 12px; border: 1px solid #000; padding: 10px; vertical-align: middle;">
                    FORMULIR<br>CHECKLIST 06 SECURE OPERATION INCIDENT
                </td>
                <td style="border: 1px solid #000; padding: 5px;">Versi</td>
                <!-- Variabel Dinamis Versi -->
                <td style="border: 1px solid #000; padding: 5px;">: {{ $kategoriForm->versi_dokumen ?? '002-2020' }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 5px;">Halaman</td>
                <td style="border: 1px solid #000; padding: 5px;">: 1 dari 2</td>
            </tr>
        </table>
                
        <!-- Tabel Referensi -->
        <table class="ref-table">
            <tr>
                <td class="ref-label">No. Ref</td>
                <td>: {{ $form->no_ref ?: '- - -' }}</td>
            </tr>
            <tr>
                <td class="ref-label">Tanggal</td>
                <td>: {{ $form->tanggal_ref ? \Carbon\Carbon::parse($form->tanggal_ref)->locale('id')->translatedFormat('d F Y') : '- - -' }}</td>
            </tr>
            <tr>
                <td class="ref-label">Business Area</td>
                <td>: {{ $form->business_area ?: '- - -' }}</td>
            </tr>
        </table>
        
        <!-- Deskripsi Aplikasi -->
        <table class="box-table">
            <tr>
                <th class="box-header">
                    DESKRIPSI<br>
                    <span style="text-transform: uppercase;">{{ $form->nama_aplikasi }}</span>
                </th>
            </tr>
            <tr>
                <td style="padding: 15px;">
                    <div class="desc-row">
                        <div class="desc-label">Tanggal Checklist</div><div class="desc-colon">:</div>
                        <div class="desc-val">{{ \Carbon\Carbon::parse($form->tanggal_checklist)->locale('id')->translatedFormat('d F Y') }}</div>
                    </div>
                    <div class="desc-row">
                        <div class="desc-label">Deskripsi</div><div class="desc-colon">:</div>
                        <div class="desc-val">{{ $form->deskripsi }}</div>
                    </div>
                    <br>
                    <div class="desc-row">
                        <div class="desc-label">Versi Aplikasi</div><div class="desc-colon">:</div>
                        <div class="desc-val">{{ $form->versi_aplikasi }}</div>
                    </div>
                    <div class="desc-row">
                        <div class="desc-label">Modul</div><div class="desc-colon">:</div>
                        <div class="desc-val">{{ $form->modul }}</div>
                    </div>
                    <div class="desc-row">
                        <div class="desc-label">Fungsi</div><div class="desc-colon">:</div>
                        <!-- Perbaikan nl2br untuk memunculkan enter dari textarea -->
                        <div class="desc-val">{!! nl2br(e($form->fungsi)) !!}</div>
                    </div>
                </td>
            </tr>
        </table>
        
        <!-- Tabel Checklist -->
        <table class="box-table">
            <tr>
                <th colspan="3" class="box-header" style="background-color: #d9e1f2;">CHECKLIST 05 SECURE IMPLEMENT</th>
            </tr>
            <tr style="background-color: #d9e1f2; text-align: center; font-weight: bold;">
                <td style="width: 5%;">No</td>
                <td>Activity</td>
                <td style="width: 25%;">Check</td>
            </tr>
            <tr>
                <td style="text-align: center;">1</td>
                <td>Incident dengan kategori High dilaporkan ke CDD IT</td>
                <td style="font-size: 13px;">{!! $form->incident_high_dilaporkan == 'Ya' ? '&#9745; Ya &nbsp; &#9744; Tidak' : '&#9744; Ya &nbsp; &#9745; Tidak' !!}</td>
            </tr>
            <tr>
                <td style="text-align: center;">2</td>
                <td>Incident sudah dimasukkan ke dalam sistem Trouble Ticket dan ditindak lanjuti</td>
                <td style="font-size: 13px;">{!! $form->incident_masuk_tiket == 'Ya' ? '&#9745; Ya &nbsp; &#9744; Tidak' : '&#9744; Ya &nbsp; &#9745; Tidak' !!}</td>
            </tr>
            <tr>
                <td style="text-align: center;">3</td>
                <td>Incident tiket yang ada sudah ditindak lanjuti dan sudah di-close</td>
                <td style="font-size: 13px;">{!! $form->incident_tiket_closed == 'Ya' ? '&#9745; Ya &nbsp; &#9744; Tidak' : '&#9744; Ya &nbsp; &#9745; Tidak' !!}</td>
            </tr>
            <tr>
                <td style="text-align: center;">4</td>
                <td>Vulnerability Assessment (VA) dilakukan untuk incident yang sudah di-close<br><span style="font-size: 10px; color: #555;">Bila Ya, ada dokumen VA result</span></td>
                <td style="font-size: 13px;">{!! $form->va_dilakukan == 'Ya' ? '&#9745; Ya &nbsp; &#9744; Tidak' : '&#9744; Ya &nbsp; &#9745; Tidak' !!}</td>
            </tr>
            <tr>
                <td style="text-align: center;">5</td>
                <td>Untuk sistem yang mengalami incident dilakukan penjadwalan untuk masuk dalam regular Penetration Test berikutnya</td>
                <td style="font-size: 13px;">{!! $form->jadwal_pentest == 'Ya' ? '&#9745; Ya &nbsp; &#9744; Tidak' : '&#9744; Ya &nbsp; &#9745; Tidak' !!}</td>
            </tr>
        </table>
        
        <!-- Tanda Tangan -->
        <table class="ttd-table" style="width: 100%; border: none; margin-top: 30px; font-size: 11px;">
            <!-- Baris Khusus untuk Tempat & Tanggal (Baris ke-1) -->
            <tr>
                <td style="width: 50%;"></td> <!-- Sisi kiri sengaja dikosongkan -->
                <td style="width: 50%; text-align: right; padding-bottom: 25px;">
                    {{ $form->tempat_ttd ?? '....................' }}, {{ $form->tanggal_ttd ? \Carbon\Carbon::parse($form->tanggal_ttd)->locale('id')->translatedFormat('d F Y') : '.............................. 20....' }}
                </td>
            </tr>

            <!-- Baris Khusus untuk Posisi Tanda Tangan (Baris ke-2) -->
            <tr>
                <td style="width: 50%; text-align: center; vertical-align: top;">
                    <div>Mengetahui,</div>
                    <div style="margin-bottom: 70px;">{{ $form->mengetahui->jabatan ?? '' }}</div>
                    
                    <div style="font-weight: bold; text-decoration: underline; text-transform: uppercase;">
                        {{ $form->mengetahui->nama ?? '..................................................' }}
                    </div>
                    <div>NIPP. {{ $form->mengetahui->nipp ?? '..........................' }}</div>
                </td>
                <td style="width: 50%; text-align: center; vertical-align: top;">
                    <div>Pelaksana Checklist,</div>
                    <div style="margin-bottom: 70px;">{{ $form->pelaksana->jabatan ?? '' }}</div>
                    
                    <div style="font-weight: bold; text-decoration: underline; text-transform: uppercase;">
                        {{ $form->pelaksana->nama ?? '..................................................' }}
                    </div>
                    <div>NIPP. {{ $form->pelaksana->nipp ?? '..........................' }}</div>
                </td>
            </tr>
        </table>

    </div>

    <!-- AUTO-PRINT -->
    @if(request()->query('print') == 'yes')
        <script>
            window.onload = function() {
                // Jeda 500ms agar logo dan tabel termuat sempurna sebelum print
                setTimeout(function() {
                    window.print();
                }, 500);
            };
        </script>
    @endif

</body>
</html>