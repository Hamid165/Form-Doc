<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Berita Acara - {{ $bastik->nomor_surat ?? 'Draft #' . $bastik->id }}</title>
    <link rel="icon" href="{{ asset('images/favicon.svg') }}">
    <style>
        /* Base Styling A4 Standar KAI */
        * {
            box-sizing: border-box;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            background-color: #525659;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            color: #000000;
            line-height: 1.4;
        }
        .a4-container {
            width: 210mm;
            min-height: 297mm;
            background: white;
            padding: 15mm 20mm;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
            margin: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table.bordered th, table.bordered td {
            border: 0.8px solid #000000;
            padding: 6px 8px;
            font-size: 9.5pt;
            vertical-align: top;
        }
        table.bordered th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        .no-print {
            position: fixed;
            top: 15px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 1000;
        }
        .btn-kembali {
            padding: 8px 18px;
            background: #4b5563;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .btn-print {
            padding: 8px 18px;
            background: #ea580c;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 13px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .btn-kembali:hover { background: #374151; }
        .btn-print:hover { background: #c2410c; }

        @media print {
            body {
                background: white !important;
                margin: 0 !important;
                padding: 0 !important;
                display: block !important;
            }
            .no-print {
                display: none !important;
            }
            .a4-container {
                box-shadow: none !important;
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            @page {
                size: A4 portrait;
                margin: 12mm 15mm;
            }
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>
<body>

    <!-- Floating Action Buttons (Hidden on Print) -->
    <div class="no-print">
        <a href="{{ route('form-bastik.show', $bastik->id) }}" class="btn-kembali">&larr; Kembali</a>
        <button onclick="window.print()" class="btn-print">🖨 Print / Simpan PDF</button>
    </div>

    <!-- Auto Print Trigger -->
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                window.print();
            }, 300);
        });
    </script>

    <div class="a4-container">
        <!-- 1. Header / Kop Formulir ISO KAI 4 Kolom -->
        <table style="width: 100%; margin: 0 0 12px 0; border-collapse: collapse; table-layout: fixed; border: 0.8px solid #000;">
            <tr style="height: 32px;">
                <!-- Logo KAI -->
                <td rowspan="2" style="width: 20%; text-align: center; vertical-align: middle; padding: 4px; border: 0.8px solid #000;">
                    <img src="{{ asset('images/logo-kai.svg') }}" alt="KAI Logo" style="width: 90px; height: auto; max-height: 45px;">
                </td>

                <!-- Nama Instansi -->
                <td rowspan="2" style="width: 40%; text-align: center; vertical-align: middle; padding: 4px; border: 0.8px solid #000; font-weight: bold; font-size: 9.5pt; line-height: 1.2;">
                    PT. KERETA API INDONESIA (PERSERO)<br>
                    <span style="font-size: 9pt; font-weight: bold;">SISTEM INFORMASI</span>
                </td>

                <!-- Label Nomor -->
                <td style="width: 14%; padding: 3px 6px; border: 0.8px solid #000; font-size: 8.5pt; vertical-align: middle; font-weight: 600;">
                    Nomor
                </td>

                <!-- Nomor Formulir Tetap ISO -->
                <td style="width: 26%; padding: 3px 6px; border: 0.8px solid #000; font-size: 8.5pt; vertical-align: middle; white-space: nowrap;">
                    FR.SM/TI/031.005/02-2023
                </td>
            </tr>

            <tr style="height: 32px;">
                <td style="padding: 3px 6px; border: 0.8px solid #000; font-size: 8.5pt; vertical-align: middle; font-weight: 600;">
                    Tanggal Terbit
                </td>

                <td style="padding: 3px 6px; border: 0.8px solid #000; font-size: 8.5pt; vertical-align: middle; white-space: nowrap;">
                    13 Februari 2023
                </td>
            </tr>

            <tr style="height: 32px;">
                <!-- Status Dokumen -->
                <td rowspan="2" style="text-align: center; vertical-align: middle; padding: 4px; border: 0.8px solid #000;">
                    <div style="display: inline-block; border: 1.5px solid #d97706; padding: 2px 8px; color: #d97706; font-weight: bold; font-size: 10pt; letter-spacing: 0.8px;">
                        TERBATAS
                    </div>
                </td>

                <!-- Judul Formulir -->
                <td rowspan="2" style="text-align: center; vertical-align: middle; padding: 4px; border: 0.8px solid #000; font-weight: bold; font-size: 9.5pt; line-height: 1.2; text-transform: uppercase;">
                    FORMULIR BERITA ACARA<br>
                    PENUTUPAN TIKET INCIDENT/WORK ORDER
                </td>

                <td style="padding: 3px 6px; border: 0.8px solid #000; font-size: 8.5pt; vertical-align: middle; font-weight: 600;">
                    Versi
                </td>

                <td style="padding: 3px 6px; border: 0.8px solid #000; font-size: 8.5pt; vertical-align: middle;">
                    001-2023
                </td>
            </tr>

            <tr style="height: 32px;">
                <td style="padding: 3px 6px; border: 0.8px solid #000; font-size: 8.5pt; vertical-align: middle; font-weight: 600;">
                    Halaman
                </td>

                <td style="padding: 3px 6px; border: 0.8px solid #000; font-size: 8.5pt; vertical-align: middle;">
                    1 dari {{ $bastik->lampirans->count() > 0 ? '2' : '1' }}
                </td>
            </tr>
        </table>

        <!-- 2. Tabel Referensi Dokumen -->
        <table style="width: 100%; margin-bottom: 20px; border-collapse: collapse; table-layout: fixed;">
            <tr>
                <td style="border: 0.8px solid #000; padding: 5px 10px; width: 25%; font-size: 9.5pt; font-weight: 600;">
                    No. Ref
                </td>
                <td style="border: 0.8px solid #000; padding: 5px 10px; width: 75%; font-size: 9.5pt;">
                    : {{ $bastik->nomor_surat ?? '___/___/___' }}
                </td>
            </tr>
            <tr>
                <td style="border: 0.8px solid #000; padding: 5px 10px; width: 25%; font-size: 9.5pt; font-weight: 600;">
                    Tanggal
                </td>
                <td style="border: 0.8px solid #000; padding: 5px 10px; width: 75%; font-size: 9.5pt;">
                    : {{ $bastik->tanggal_surat ? \Carbon\Carbon::parse($bastik->tanggal_surat)->format('d - m - Y') : '__ - __ - ____' }}
                </td>
            </tr>
            <tr>
                <td style="border: 0.8px solid #000; padding: 5px 10px; width: 25%; font-size: 9.5pt; font-weight: 600;">
                    Business Area
                </td>
                <td style="border: 0.8px solid #000; padding: 5px 10px; width: 75%; font-size: 9.5pt;">
                    : {{ $bastik->business_area ?? ($bastik->petugas->unit_kerja ?? '-') }}
                </td>
            </tr>
        </table>

        @php
            $hari = '-';
            $tanggalBulanTahun = '-';
            if (!empty($bastik->tanggal_surat)) {
                $parsedDate = \Carbon\Carbon::parse($bastik->tanggal_surat)->locale('id');
                $hari = $parsedDate->isoFormat('dddd');
                $tanggalBulanTahun = $parsedDate->isoFormat('D MMMM YYYY');
            }
        @endphp

        <!-- 3. Teks Pembuka -->
        <p style="margin-bottom: 12px; font-size: 10.5pt; line-height: 1.5;">
            Pada hari ini, <span style="color: #dc2626; font-weight: bold;">{{ $hari }}, {{ $tanggalBulanTahun }}</span>, yang bertanda tangan di bawah ini:
        </p>

        <!-- 4. Data Petugas Service Desk -->
        <div style="font-weight: bold; margin-bottom: 4px; font-size: 10.5pt;">PETUGAS SERVICE DESK</div>
        <table style="width: 100%; border: none; margin-bottom: 14px; font-size: 10.5pt;">
            <tr>
                <td style="width: 120px; border: none; padding: 2px 0;">Nama</td>
                <td style="width: 15px; border: none; padding: 2px 0;">:</td>
                <td style="border: none; padding: 2px 0; font-weight: 500;">{{ $bastik->petugas->name ?? '-' }}</td>
            </tr>
            <tr>
                <td style="border: none; padding: 2px 0;">NIPKWT</td>
                <td style="border: none; padding: 2px 0;">:</td>
                <td style="border: none; padding: 2px 0; font-weight: 500;">{{ $bastik->petugas->nip_kwt ?? '-' }}</td>
            </tr>
        </table>

        <p style="margin-bottom: 12px; text-align: justify; line-height: 1.5; font-size: 10.5pt;">
            Telah dilakukan konfirmasi tiket sebanyak 3 (tiga) kali kepada user yang bersangkutan namun belum ada respon dari pihak terkait. Adapun tiket yang telah di konfirmasi diantaranya sebagai berikut:
        </p>

        <!-- 5. Tabel Rincian Tiket -->
        <table class="bordered">
            <thead>
                <tr>
                    <th style="width: 18%;">No Tiket</th>
                    <th style="width: 34%;">Detail Tiket</th>
                    <th style="width: 20%;">User Pemohon</th>
                    <th style="width: 14%;">NIPP</th>
                    <th style="width: 14%;">Unit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bastik->items as $item)
                    <tr>
                        <td style="font-weight: bold;">{{ $item->no_tiket }}</td>
                        <td>{{ $item->detail_tiket }}</td>
                        <td>{{ $item->user_pemohon }}</td>
                        <td style="text-align: center;">{{ $item->nipp }}</td>
                        <td>{{ $item->unit }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p style="margin-top: 4px; font-size: 9pt; color: #4b5563; font-style: italic;">
            *Lampirkan bukti konfirmasi
        </p>

        <p style="margin-top: 14px; margin-bottom: 20px; font-size: 10.5pt;">
            Demikian Berita Acara ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.
        </p>

        <!-- 6. Area Tanda Tangan Simetris -->
        <table style="width: 100%; border: none; text-align: center; margin-top: 15px; border-collapse: collapse; font-size: 10.5pt;">
            <!-- Baris 1: Kota & Tanggal (Kanan) -->
            <tr>
                <td style="width: 50%; border: none; padding: 0;"></td>
                <td style="width: 50%; border: none; padding: 0 0 10px 0;">
                    {{ $bastik->kota }}, <span style="color: #dc2626; font-weight: bold;">{{ $tanggalBulanTahun }}</span>
                </td>
            </tr>

            <!-- Baris 2: Judul Tanda Tangan -->
            <tr>
                <td style="width: 50%; border: none; padding: 0 0 6px 0; vertical-align: bottom; font-weight: 500;">
                    Petugas Service desk,
                </td>
                <td style="width: 50%; border: none; padding: 0 0 6px 0; vertical-align: bottom; font-weight: 500;">
                    Mengetahui,
                </td>
            </tr>

            <!-- Baris 3: Ruang Tanda Tangan & QR Code Validator -->
            <tr>
                <td style="width: 50%; border: none; padding: 0; height: 95px; vertical-align: middle;"></td>
                <td style="width: 50%; border: none; padding: 0; height: 95px; vertical-align: middle;">
                    @if($bastik->status === 'signed' || $bastik->status === 'final')
                        <div style="margin-top: 5px; margin-bottom: 3px;">
                            <img src="data:image/svg+xml;base64,{!! $qrCodeBase64 !!}" style="width: 80px; height: 80px; display: inline-block;" alt="QR Code" />
                        </div>
                        <div style="font-size: 7.5pt; color: #16a34a; font-weight: bold; letter-spacing: 0.5px;">[ VALIDATED ]</div>
                    @endif
                </td>
            </tr>

            <!-- Baris 4: Nama Penanda Tangan -->
            <tr>
                <td style="width: 50%; border: none; padding: 0; vertical-align: top;">
                    <strong><u>({{ $bastik->petugas->name ?? 'NAMA PETUGAS' }})</u></strong>
                </td>
                <td style="width: 50%; border: none; padding: 0; vertical-align: top;">
                    <strong><u>({{ strtoupper($bastik->pimpinan->nama ?? 'NAMA PIMPINAN') }})</u></strong>
                </td>
            </tr>

            <!-- Baris 5: NIPP / NIPKWT -->
            <tr>
                <td style="width: 50%; border: none; padding: 4px 0 0 0; vertical-align: top; font-size: 9.5pt; color: #374151;">
                    NIPP/NIPKWT {{ $bastik->petugas->nip_kwt ?? '-' }}
                </td>
                <td style="width: 50%; border: none; padding: 4px 0 0 0; vertical-align: top; font-size: 9.5pt; color: #374151;">
                    NIPP. {{ $bastik->pimpinan->nipp ?? '-' }}
                </td>
            </tr>
        </table>

        <!-- 7. Halaman Lampiran (Jika ada file lampiran) -->
        @if($bastik->lampirans->count() > 0)
            <div class="page-break" style="margin-top: 30px; padding-top: 15px;">
                <h3 style="font-size: 11pt; text-align: center; border-bottom: 1.5px solid #000; padding-bottom: 6px; margin-bottom: 20px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px;">
                    LAMPIRAN BUKTI KONFIRMASI
                </h3>

                <table style="width: 100%; border-collapse: separate; border-spacing: 12px; table-layout: fixed;">
                    @foreach($bastik->lampirans->chunk(2) as $chunk)
                        <tr>
                            @foreach($chunk as $lampiran)
                                <td style="width: 50%; vertical-align: top; border: 1px solid #d1d5db; background-color: #f9fafb; padding: 10px; text-align: center; border-radius: 6px;">
                                    <div style="font-weight: bold; font-size: 9pt; color: #111827; border-bottom: 0.8px solid #e5e7eb; padding-bottom: 4px; margin-bottom: 8px;">
                                        Tiket: {{ $lampiran->item->no_tiket ?? '-' }}
                                    </div>

                                    @php
                                        $extension = strtolower(pathinfo($lampiran->file_path, PATHINFO_EXTENSION));
                                        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
                                        $fileExists = \Illuminate\Support\Facades\Storage::disk('public')->exists($lampiran->file_path);
                                    @endphp

                                    <div style="height: 140px; display: flex; align-items: center; justify-content: center;">
                                        @if($fileExists && in_array($extension, $imageExtensions))
                                            <img src="{{ asset('storage/' . $lampiran->file_path) }}" style="max-width: 100%; max-height: 135px; width: auto; height: auto; object-fit: contain;" alt="Bukti Konfirmasi">
                                        @elseif($fileExists)
                                            <div style="padding: 15px; background: #f3f4f6; border: 1px dashed #9ca3af; border-radius: 4px;">
                                                <div style="font-size: 14pt; font-weight: bold; color: #4b5563;">{{ strtoupper($extension) }}</div>
                                                <div style="font-size: 8.5pt; color: #1f2937; margin-top: 4px;">{{ $lampiran->original_name ?: basename($lampiran->file_path) }}</div>
                                            </div>
                                        @else
                                            <div style="color: #9ca3af; font-size: 9pt;">File tidak ditemukan</div>
                                        @endif
                                    </div>

                                    <div style="font-size: 8.5pt; font-weight: bold; color: #4b5563; margin-top: 8px; border-top: 0.8px solid #e5e7eb; padding-top: 4px;">
                                        Konfirmasi Ke-{{ $lampiran->urutan_konfirmasi }}
                                    </div>
                                </td>
                            @endforeach

                            @if($chunk->count() < 2)
                                <td style="width: 50%; border: none; background: transparent;"></td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif
    </div>

</body>
</html>
