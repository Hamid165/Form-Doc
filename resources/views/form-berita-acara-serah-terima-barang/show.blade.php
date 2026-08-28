<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara Serah Terima Barang</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #e2e8f0; margin: 0; padding: 30px 20px; display: flex; flex-direction: column; align-items: center; }
        .a4-container { background-color: white; width: 210mm; min-height: 297mm; padding: 15mm 20mm; box-shadow: 0 10px 25px rgba(0,0,0,0.1); box-sizing: border-box; color: #000; position: relative; margin-bottom: 20px; font-size: 11px; }
        .kop-table { width: 100%; border-collapse: collapse; font-size: 11px; }
        .kop-table td { border: 1px solid #000; padding: 5px 8px; vertical-align: middle; }
        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 10px; text-align: center; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 5px; }
        .info-field-table { width: 100%; border-collapse: separate; border-spacing: 0 4px; font-size: 11px; }
        .info-field-table td:first-child { width: 150px; font-weight: bold; }
        .info-field-table td:nth-child(2) { width: 15px; }
        .info-field-table td:nth-child(3) { border-bottom: 1px dotted #999; }

        /* Input untuk field tanda tangan yang bisa diedit langsung dari halaman ini */
        .form-input-line { width: 100%; border: none; border-bottom: 1px solid black; outline: none; background: transparent; font-family: inherit; font-size: inherit; padding: 2px 4px; box-sizing: border-box; text-align: center; }
        .form-input-line:focus { background-color: #f0f8ff; border-bottom: 1px solid #00a4e4; }
        .form-input-line::placeholder { color: #9ca3af; font-style: italic; }

        .btn-print { width: 100px; height: 36px; line-height: 36px; background-color: #16a34a; color: white; border: none; cursor: pointer; border-radius: 6px; font-weight: bold; text-align: center; display: inline-block; }
        .btn-kembali { width: 100px; height: 36px; line-height: 36px; background-color: #ef4444; color: white; border: none; cursor: pointer; border-radius: 6px; font-weight: bold; text-align: center; display: inline-block; text-decoration: none; }
        .btn-simpan-ttd { height: 36px; line-height: 36px; padding: 0 16px; background-color: #2563eb; color: white; border: none; cursor: pointer; border-radius: 6px; font-weight: bold; text-align: center; display: inline-block; }

        /* PENGATURAN CETAK A4 */
        @page { size: A4 portrait; margin: 10mm 15mm; }
        @media print {
            body { margin: 0; padding: 0; background-color: white; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .a4-container { box-shadow: none; padding: 0; margin: 0; width: 100%; height: auto; min-height: auto; margin-bottom: 0; }
            .no-print { display: none !important; }
            .form-input-line { border-bottom: none !important; }
        }
    </style>
</head>
<body>

    @php
        $tgl_ref = $form->tanggal_ref;
        try { if($tgl_ref) $tgl_ref = \Carbon\Carbon::parse($tgl_ref)->locale('id')->translatedFormat('d - m - Y'); } catch(\Exception $e) {}

        $tgl_serah = $form->tanggal_serah_terima;
        try { if($tgl_serah) $tgl_serah = \Carbon\Carbon::parse($tgl_serah)->locale('id')->translatedFormat('d F Y'); } catch(\Exception $e) {}

        $items = collect($form->items)->toArray();
    @endphp

    <div class="no-print" style="width: 210mm; display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 20px;">
        <a href="{{ route('form-berita-acara-serah-terima-barang.index') }}" class="btn-kembali">Kembali</a>
    </div>

    <form action="{{ route('form-berita-acara-serah-terima-barang.update', $form->id) }}" method="POST" id="signerForm">
        @csrf
        @method('PUT')

        {{-- Hidden inputs untuk menjaga semua data saat hanya update tanda tangan --}}
        <input type="hidden" name="no_ref" value="{{ $form->no_ref }}">
        <input type="hidden" name="tanggal_ref" value="{{ $form->tanggal_ref }}">
        <input type="hidden" name="business_area" value="{{ $form->business_area }}">
        <input type="hidden" name="hari" value="{{ $form->hari }}">
        <input type="hidden" name="tanggal_serah_terima" value="{{ $form->tanggal_serah_terima }}">
        <input type="hidden" name="penyerah_nama" value="{{ $form->penyerah_nama }}">
        <input type="hidden" name="penyerah_nipp" value="{{ $form->penyerah_nipp }}">
        <input type="hidden" name="penyerah_jabatan" value="{{ $form->penyerah_jabatan }}">
        <input type="hidden" name="penyerah_tempat_kedudukan" value="{{ $form->penyerah_tempat_kedudukan }}">
        <input type="hidden" name="penyerah_personal_area" value="{{ $form->penyerah_personal_area }}">
        <input type="hidden" name="penerima_nama" value="{{ $form->penerima_nama }}">
        <input type="hidden" name="penerima_nipp" value="{{ $form->penerima_nipp }}">
        <input type="hidden" name="penerima_jabatan" value="{{ $form->penerima_jabatan }}">
        <input type="hidden" name="penerima_tempat_kedudukan" value="{{ $form->penerima_tempat_kedudukan }}">
        <input type="hidden" name="penerima_personal_area" value="{{ $form->penerima_personal_area }}">
        <input type="hidden" name="penerima_owner_responsible" value="{{ $form->penerima_owner_responsible }}">
        <input type="hidden" name="penerima_custodian" value="{{ $form->penerima_custodian }}">
        <input type="hidden" name="nama_unit" value="{{ $form->nama_unit }}">
        <input type="hidden" name="wilayah" value="{{ $form->wilayah }}">
        @foreach ($items as $index => $item)
            <input type="hidden" name="items[{{ $index }}][nama_barang]" value="{{ $item['nama_barang'] ?? '' }}">
            <input type="hidden" name="items[{{ $index }}][brand_series]" value="{{ $item['brand_series'] ?? '' }}">
            <input type="hidden" name="items[{{ $index }}][no_inventaris]" value="{{ $item['no_inventaris'] ?? '' }}">
            <input type="hidden" name="items[{{ $index }}][serial_number]" value="{{ $item['serial_number'] ?? '' }}">
            <input type="hidden" name="items[{{ $index }}][keterangan]" value="{{ $item['keterangan'] ?? '' }}">
        @endforeach

        @isset($masterSigners)
            <datalist id="signer-list">
                @foreach($masterSigners as $ms)
                    <option value="{{ $ms->nama }}" data-nipp="{{ $ms->nipp }}">{{ $ms->jabatan }}</option>
                @endforeach
            </datalist>
        @endisset

        <!-- HALAMAN 1 -->
        <div class="a4-container">
            {{-- =================== KOP SURAT =================== --}}
            <table class="kop-table">
                <tr>
                    <td rowspan="2" style="width: 20%; text-align: center; vertical-align: middle;">
                        <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI" style="width: 100%; max-width: 90px; height: auto; display: inline-block;">
                    </td>
                    <td rowspan="2" style="width: 45%; text-align: center; font-weight: bold; font-size: 12px;">
                        PT KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI
                    </td>
                    <td style="width: 12%;">Nomor</td>
                    <td style="width: 23%;">: FR.SM/TI/011.002/10-2020</td>
                </tr>
                <tr><td>Tanggal Terbit</td><td>: 12 Oktober 2020</td></tr>
                <tr>
                    <td rowspan="2" style="text-align: center; padding: 10px;">
                        <div style="border: 2px solid #eadc04; color: #eadc04; font-weight: bold; font-size: 14px; padding: 6px 12px; display: inline-block;">TERBATAS</div>
                    </td>
                    <td rowspan="2" style="text-align: center; font-weight: bold; font-size: 12px;">
                        FORMULIR BERITA ACARA SERAH<br>TERIMA BARANG
                    </td>
                    <td>Versi</td><td>: 02-2020</td>
                </tr>
                <tr><td>Halaman</td><td>: 1 dari 2</td></tr>
            </table>

            {{-- =================== INFO REFERENSI =================== --}}
            <table style="border-collapse: collapse; width: 350px; font-size: 11px; margin-top: 15px;">
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

            {{-- =================== PEMBUKA & DATA PENYERAH =================== --}}
            <div style="font-size: 11px; margin-top: 25px; margin-left: 20px;">
                <div style="margin-bottom: 15px;">
                    Pada hari ini, {{ $form->hari ?: '.............' }} tanggal {{ $tgl_serah ?: '...................' }}
                </div>

                <table class="info-field-table">
                    <tr><td><strong>Nama Lengkap</strong></td><td>:</td><td>{{ $form->penyerah_nama }}</td></tr>
                    <tr><td><strong>Nipp</strong></td><td>:</td><td>{{ $form->penyerah_nipp }}</td></tr>
                    <tr><td><strong>Jabatan</strong></td><td>:</td><td>{{ $form->penyerah_jabatan }}</td></tr>
                    <tr><td><strong>Tempat Kedudukan</strong></td><td>:</td><td>{{ $form->penyerah_tempat_kedudukan }}</td></tr>
                    <tr><td><strong>Personal Area</strong></td><td>:</td><td>{{ $form->penyerah_personal_area }}</td></tr>
                </table>
            </div>

            {{-- =================== TABEL BARANG =================== --}}
            <div style="font-size: 11px; margin-top: 20px; margin-left: 20px;">
                <div style="margin-bottom: 10px;">Menyerahkan barang-barang sebagai berikut:</div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 22%;">Nama Barang</th>
                            <th style="width: 15%;">Brand / Series</th>
                            <th style="width: 18%;">No. Inventaris</th>
                            <th style="width: 18%;">Serial Number</th>
                            <th style="width: 22%;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item['nama_barang'] ?? '' }}</td>
                                <td>{{ $item['brand_series'] ?? '' }}</td>
                                <td>{{ $item['no_inventaris'] ?? '' }}</td>
                                <td>{{ $item['serial_number'] ?? '' }}</td>
                                <td>{{ $item['keterangan'] ?? '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- =================== DATA PENERIMA =================== --}}
            <div style="font-size: 11px; margin-top: 25px; margin-left: 20px;">
                <div style="margin-bottom: 10px;"><strong>Kepada :</strong></div>

                <table class="info-field-table">
                    <tr><td><strong>Nama Lengkap</strong></td><td>:</td><td>{{ $form->penerima_nama }}</td></tr>
                    <tr><td><strong>Nipp</strong></td><td>:</td><td>{{ $form->penerima_nipp }}</td></tr>
                    <tr><td><strong>Jabatan</strong></td><td>:</td><td>{{ $form->penerima_jabatan }}</td></tr>
                    <tr><td><strong>Tempat Kedudukan</strong></td><td>:</td><td>{{ $form->penerima_tempat_kedudukan }}</td></tr>
                    <tr><td><strong>Personal Area</strong></td><td>:</td><td>{{ $form->penerima_personal_area }}</td></tr>
                    <tr><td><strong>Owner Responsible</strong></td><td>:</td><td>{{ $form->penerima_owner_responsible }}</td></tr>
                    <tr><td><strong>Custodian</strong></td><td>:</td><td>{{ $form->penerima_custodian }}</td></tr>
                </table>
            </div>

            {{-- =================== KETERANGAN PENGGUNAAN =================== --}}
            <div style="font-size: 11px; margin-top: 25px; margin-left: 20px; line-height: 1.8;">
                Dipergunakan untuk alat bantu kerja <strong style="color: red; font-style: italic;">{{ $form->nama_unit ?: '<Nama Unit>' }}</strong>
                di wilayah <strong style="color: red; font-style: italic;">{{ $form->wilayah ?: '<Kantor Pusat/Daop/Divre/Balaiyasa>' }}</strong>
                dan selanjutnya barang tersebut menjadi tanggung jawab penerima sepenuhnya serta wajib dirawat dengan penuh tanggung jawab.
            </div>

            {{-- =================== TANDA TANGAN =================== --}}
            <table style="width: 100%; font-size: 11px; text-align: center; margin-top: 40px;">
                <tr>
                    <td style="width: 50%; vertical-align: top;">Yang Menyerahkan</td>
                    <td style="width: 50%; vertical-align: top;">Yang Menerima</td>
                </tr>
                <tr>
                    <td style="height: 80px; vertical-align: bottom;">
                        <div style="margin-bottom: 3px;">
                            <input type="text" name="ttd_penyerah_nama" id="ttd_penyerah_nama"
                                @isset($masterSigners) list="signer-list" @endisset
                                value="{{ old('ttd_penyerah_nama', $form->ttd_penyerah_nama) }}"
                                class="form-input-line" style="width: 180px; text-align: center;"
                                placeholder="..........................">
                        </div>
                        <div style="margin-top: 3px;">
                            NIPP.
                            <input type="text" name="ttd_penyerah_nipp" id="ttd_penyerah_nipp"
                                value="{{ old('ttd_penyerah_nipp', $form->ttd_penyerah_nipp) }}"
                                class="form-input-line" style="width: 110px; text-align: center;"
                                placeholder="..............">
                        </div>
                    </td>
                    <td style="height: 80px; vertical-align: bottom;">
                        <div style="margin-bottom: 3px;">
                            <input type="text" name="ttd_penerima_nama" id="ttd_penerima_nama"
                                @isset($masterSigners) list="signer-list" @endisset
                                value="{{ old('ttd_penerima_nama', $form->ttd_penerima_nama) }}"
                                class="form-input-line" style="width: 180px; text-align: center;"
                                placeholder="..........................">
                        </div>
                        <div style="margin-top: 3px;">
                            NIPP.
                            <input type="text" name="ttd_penerima_nipp" id="ttd_penerima_nipp"
                                value="{{ old('ttd_penerima_nipp', $form->ttd_penerima_nipp) }}"
                                class="form-input-line" style="width: 110px; text-align: center;"
                                placeholder="..............">
                        </div>
                    </td>
                </tr>
            </table>

            {{-- =================== CATATAN FOOTER =================== --}}
            <div style="font-size: 10px; margin-top: 30px; color: #000;">
                *Mohon setelah di tandatangani, BAST dikembalikan ke alamat pengirim
            </div>
        </div>
    </form>

<script>
    // Autofill NIPP dari daftar master penandatangan
    function setupAutofill(nameId, nippId) {
        const nameInput = document.getElementById(nameId);
        const nippInput = document.getElementById(nippId);
        const list = document.getElementById('signer-list');
        if (!nameInput || !nippInput || !list) return;

        nameInput.addEventListener('input', function() {
            const options = list.options;
            for (let i = 0; i < options.length; i++) {
                if (options[i].value === nameInput.value) {
                    nippInput.value = options[i].getAttribute('data-nipp') || '';
                    break;
                }
            }
        });
    }
    setupAutofill('ttd_penyerah_nama', 'ttd_penyerah_nipp');
    setupAutofill('ttd_penerima_nama', 'ttd_penerima_nipp');

    @if(request('print') == '1')
    window.addEventListener('load', function() {
        setTimeout(function() {
            window.print();
        }, 500);
    });
    @endif
</script>

</body>
</html>
