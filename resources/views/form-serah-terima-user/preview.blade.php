<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara Serah Terima User Aplikasi KAI - Preview</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #e2e8f0; margin: 0; padding: 30px 20px; display: flex; flex-direction: column; align-items: center; }
        .a4-container { background-color: white; width: 210mm; min-height: 297mm; padding: 15mm 20mm; box-shadow: 0 10px 25px rgba(0,0,0,0.1); box-sizing: border-box; color: #000; position: relative; margin-bottom: 20px; font-size: 11px; }
        .kop-table { width: 100%; border-collapse: collapse; font-size: 11px; }
        .kop-table td { border: 1px solid #000; padding: 5px 8px; vertical-align: middle; }
        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 10px; text-align: center; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 5px; }

        .btn-print { width: 100px; height: 36px; line-height: 36px; background-color: #16a34a; color: white; border: none; cursor: pointer; border-radius: 6px; font-weight: bold; text-align: center; display: inline-block; }
        .btn-kembali { width: 100px; height: 36px; line-height: 36px; background-color: #ef4444; color: white; border: none; cursor: pointer; border-radius: 6px; font-weight: bold; text-align: center; display: inline-block; text-decoration: none; }

        /* PENGATURAN CETAK SUPER PRESISI FULL A4 */
        @page { size: A4 portrait; margin: 8mm 12mm; }
        @media print {
            body { margin: 0; padding: 0; background-color: white; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .a4-container { box-shadow: none; padding: 5mm 5mm 0 5mm; margin: 0; width: 100%; height: auto; min-height: auto; margin-bottom: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    @php
        $tgl_ref = $form->tanggal_ref;
        try { if($tgl_ref) $tgl_ref = \Carbon\Carbon::parse($tgl_ref)->locale('id')->translatedFormat('d F Y'); } catch(\Exception $e) {}

        $tgl_hari_ini = $form->tanggal;
        try { if($tgl_hari_ini) $tgl_hari_ini = \Carbon\Carbon::parse($tgl_hari_ini)->locale('id')->translatedFormat('d F Y'); } catch(\Exception $e) {}

        $tgl_aktif_mulai = $form->masa_aktif_mulai;
        try { if($tgl_aktif_mulai) $tgl_aktif_mulai = \Carbon\Carbon::parse($tgl_aktif_mulai)->locale('id')->translatedFormat('d F Y'); } catch(\Exception $e) {}

        $tgl_aktif_selesai = $form->masa_aktif_selesai;
        try { if($tgl_aktif_selesai) $tgl_aktif_selesai = \Carbon\Carbon::parse($tgl_aktif_selesai)->locale('id')->translatedFormat('d F Y'); } catch(\Exception $e) {}

        $tgl_ttd = $form->tanggal_ttd;
        try { if($tgl_ttd) $tgl_ttd = \Carbon\Carbon::parse($tgl_ttd)->locale('id')->translatedFormat('d F Y'); } catch(\Exception $e) {}

        $items = collect($form->items)->toArray();
    @endphp

    <div class="no-print" style="width: 210mm; display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 20px;">
        <a href="{{ route('form-serah-terima-user.index') }}" class="btn-kembali">Kembali</a>
    </div>

    <!-- CONTAINER HALAMAN A4 -->
    <div class="a4-container">
        <!-- Header Table -->
        <table class="kop-table">
            <tr>
                <td rowspan="2" style="width: 20%; text-align: center; vertical-align: middle;">
                    <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI" style="width: 100%; max-width: 90px; height: auto; display: inline-block;">
                </td>
                <td rowspan="2" style="width: 45%; text-align: center; font-weight: bold; font-size: 12px;">
                    PT KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI
                </td>
                <td style="width: 12%;">Nomor</td>
                <td style="width: 23%;">{{ $formTemplate->no_dokumen ?? 'FR.SM/TI/011.002/10-2020' }}</td>
            </tr>
            <tr><td>Tanggal Terbit</td><td>{{ $formTemplate->tanggal_dokumen ?? '12 Oktober 2020' }}</td></tr>
            <tr>
                <td rowspan="2" style="text-align: center; padding: 10px;">
                    <div style="border: 2px solid #ef4444; color: #ef4444; font-weight: bold; font-size: 12px; padding: 4px 8px; display: inline-block; letter-spacing: 1px;">RAHASIA</div>
                </td>
                <td rowspan="2" style="text-align: center; font-weight: bold; font-size: 11px;">
                    FORMULIR BERITA ACARA<br>SERAH TERIMA USER APLIKASI
                </td>
                <td>Versi</td><td>{{ $formTemplate->versi_dokumen ?? '02-2020' }}</td>
            </tr>
            <tr><td>Halaman</td><td>1 dari 1</td></tr>
        </table>

        <!-- Ref & Date Box -->
        <table style="border-collapse: collapse; width: 350px; font-size: 11px; margin-top: 10px;">
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

        <!-- Execution Header text -->
        <div style="font-size: 11px; margin-top: 10px; line-height: 1.4;">
            Pada hari ini, <strong>{{ $form->hari }}</strong> tanggal <strong>{{ $tgl_hari_ini }}</strong>
        </div>

        <!-- Penyerah Info -->
        <div style="font-size: 11px; margin-top: 8px;">
            <table style="width: 100%; font-size: 11px; border-collapse: collapse; line-height: 1.4;">
                <tr>
                    <td style="width: 150px; vertical-align: top;">Nama</td>
                    <td style="width: 20px; vertical-align: top;">:</td>
                    <td style="border-bottom: 1px dotted #ccc;">{{ $form->nama_penyerah }}</td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">NIPP</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="border-bottom: 1px dotted #ccc;">{{ $form->nipp_penyerah ?: '-' }}</td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">Jabatan</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="border-bottom: 1px dotted #ccc;">{{ $form->jabatan_penyerah ?: '-' }}</td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">Tempat Kedudukan</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="border-bottom: 1px dotted #ccc;">{{ $form->tempat_kedudukan_penyerah ?: '-' }}</td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">Personal Area</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="border-bottom: 1px dotted #ccc;">{{ $form->personal_area_penyerah ?: '-' }}</td>
                </tr>
            </table>
        </div>

        <div style="font-size: 11px; margin-top: 10px;">
            Menyerahkan user aplikasi sebagai berikut:
        </div>

        <!-- Items Table -->
        <table class="data-table">
            <thead>
                <tr style="background-color: #f3f4f6;">
                    <th style="width: 5%;">No</th>
                    <th style="width: 35%;">Nama Aplikasi</th>
                    <th style="width: 30%;">Username</th>
                    <th style="width: 30%;">Password</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item['nama_aplikasi'] ?? '' }}</td>
                        <td>{{ $item['username'] ?? '' }}</td>
                        <td>{{ $item['password'] ?? '' }}</td>
                    </tr>
                @endforeach
                @for ($i = count($items); $i < 1; $i++)
                    <tr>
                        <td style="height: 25px;"></td><td></td><td></td><td></td>
                    </tr>
                @endfor
            </tbody>
        </table>

        <!-- Penerima Info -->
        <div style="font-size: 11px; margin-top: 8px; font-weight: bold;">
            Kepada
        </div>
        <div style="font-size: 11px;">
            <table style="width: 100%; font-size: 11px; border-collapse: collapse; line-height: 1.4;">
                <tr>
                    <td style="width: 150px; vertical-align: top;">Nama</td>
                    <td style="width: 20px; vertical-align: top;">:</td>
                    <td style="border-bottom: 1px dotted #ccc;">{{ $form->nama_penerima }}</td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">NIPP / No Identitas</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="border-bottom: 1px dotted #ccc;">{{ $form->nipp_penerima ?: '-' }}</td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">Jabatan / Instansi</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="border-bottom: 1px dotted #ccc;">{{ $form->jabatan_penerima ?: '-' }}</td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">Tempat Kedudukan</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="border-bottom: 1px dotted #ccc;">{{ $form->tempat_kedudukan_penerima ?: '-' }}</td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">Personal Area</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="border-bottom: 1px dotted #ccc;">{{ $form->personal_area_penerima ?: '-' }}</td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">Owner Responsible</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="border-bottom: 1px dotted #ccc;">{{ $form->owner_responsible_penerima ?: '-' }}</td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">Custodian</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="border-bottom: 1px dotted #ccc;">{{ $form->custodian_penerima ?: '-' }}</td>
                </tr>
            </table>
        </div>

        <!-- Keperluan -->
        <div style="font-size: 11px; margin-top: 8px;">
            <table style="width: 100%; font-size: 11px; border-collapse: collapse; line-height: 1.4;">
                <tr>
                    <td style="width: 150px; vertical-align: top;">Keperluan</td>
                    <td style="width: 20px; vertical-align: top;">:</td>
                    <td style="border-bottom: 1px dotted #ccc; white-space: pre-wrap;">{{ $form->keperluan }}</td>
                </tr>
            </table>
        </div>

        <!-- Masa Aktif -->
        <div style="font-size: 11px; margin-top: 8px; line-height: 1.4;">
            <strong>Masa Aktif User :</strong><br>
            Mulai Tanggal <strong>{{ $tgl_aktif_mulai }}</strong> s/d Tanggal <strong>{{ $tgl_aktif_selesai }}</strong>
        </div>

        <!-- Syarat dan Ketentuan -->
        <div style="font-size: 9.5px; margin-top: 8px; text-align: justify; line-height: 1.3;">
            <table style="width: 100%; border-collapse: collapse; font-size: inherit;">
                <tr style="vertical-align: top;">
                    <td style="width: 15px; padding-bottom: 2px;">1.</td>
                    <td style="padding-bottom: 2px;">Untuk dipergunakan sebagai alat kerja mengakses aplikasi sesuai dengan tugas dan tanggung jawabnya. Pemegang <em>user</em> aplikasi bertanggung jawab penuh terhadap semua transaksi yang dilakukannya dan tidak memberitahukan kepada orang lain <em>username</em> dan <em>password</em> aplikasi yang dimiliki.</td>
                </tr>
                <tr style="vertical-align: top;">
                    <td style="padding-bottom: 2px;">2.</td>
                    <td style="padding-bottom: 2px;"><em>Username</em> akan otomatis dinonaktifkan setelah masa aktif <em>user</em> berakhir. PT. Kereta Api Indonesia (Persero) berhak mencabut hak penggunaan aplikasi secara sepihak jika terjadi penyalahgunaan <em>user</em> aplikasi.</td>
                </tr>
                <tr style="vertical-align: top;">
                    <td style="padding-bottom: 2px;">3.</td>
                    <td style="padding-bottom: 2px;">Apabila dikemudian hari terbukti Pemegang <em>user</em> aplikasi melakukan pelanggaran, maka Pemegang <em>user</em> aplikasi bersedia menerima sanksi dari PT. Kereta Api Indonesia (Persero) dan/atau pihak lain yang berwenang sesuai ketentuan perundang-undangan yang berlaku.</td>
                </tr>
            </table>
        </div>

        <!-- Signers Section -->
        <table style="width: 100%; border-collapse: collapse; font-size: 11px; text-align: center; margin-top: 10px;">
            <tr>
                <td style="width: 50%; vertical-align: top; padding-bottom: 10px;">
                    Yang Menyerahkan
                </td>
                <td style="width: 50%; vertical-align: top; padding-bottom: 10px;">
                    Yang Menerima
                </td>
            </tr>
            <tr>
                <!-- Kolom Kiri: Yang Menyerahkan -->
                <td style="padding-top: 40px; vertical-align: bottom;">
                    <div style="margin-bottom: 6px;">
                        
                        <span style="display: inline-block; min-width: 180px; text-align: center;">
                            <span style="font-weight: bold; text-decoration: underline;">{{ $form->nama_yang_menyerahkan ?? $form->nama_penyerah ?? '....................' }}</span>
                        </span>
                        
                    </div>
                    <div>
                        NIPP.
                        <span style="display: inline-block; min-width: 130px; text-align: center;">{{ $form->nipp_yang_menyerahkan ?? $form->nipp_penyerah ?? '' }}</span>
                    </div>
                </td>

                <!-- Kolom Kanan: Yang Menerima -->
                <td style="padding-top: 5px; vertical-align: bottom; position: relative;">
                    <!-- Box Materai -->
                    <div style="border: 1px dashed #777; width: 85px; height: 50px; margin: 0 auto 10px auto; display: flex; align-items: center; justify-content: center; font-size: 8.5px; color: #555; background: #fafafa; font-weight: normal; line-height: 1.2;">
                        Materai<br>Rp. 6.000
                    </div>
                    
                    <div style="margin-bottom: 6px;">
                        
                        <span style="display: inline-block; min-width: 180px; text-align: center;">
                            <span style="font-weight: bold; text-decoration: underline;">{{ $form->nama_yang_menerima ?? $form->nama_penerima ?? '....................' }}</span>
                        </span>
                        
                    </div>
                    <div>
                        NIPP / No Identitas:
                        <span style="display: inline-block; min-width: 130px; text-align: center;">{{ $form->nipp_yang_menerima ?? $form->nipp_penerima ?? '' }}</span>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Footnotes -->
        <div style="font-size: 8px; color: #333; margin-top: 15px; border-top: 1px solid #ddd; padding-top: 5px; font-style: italic; line-height: 1.4;">
            *Nipp & Jabatan diisi khusus untuk pegawai PT. Kereta Api Indonesia (Persero)<br>
            *No Identitas = No KTP (untuk WNI) atau No Pasport (WNA)
        </div>
    </div>
</body>
</html>
