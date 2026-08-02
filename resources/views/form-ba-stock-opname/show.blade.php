<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara Stock Opname KAI</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #e2e8f0; margin: 0; padding: 30px 20px; display: flex; flex-direction: column; align-items: center; }
        .a4-container { background-color: white; width: 210mm; min-height: 297mm; padding: 15mm 20mm; box-shadow: 0 10px 25px rgba(0,0,0,0.1); box-sizing: border-box; color: #000; position: relative; margin-bottom: 20px; font-size: 11px; }
        .kop-table { width: 100%; border-collapse: collapse; font-size: 11px; }
        .kop-table td { border: 1px solid #000; padding: 5px 8px; vertical-align: middle; }
        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 10px; text-align: center; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 5px; }

        /* Input untuk field tanda tangan yang bisa diedit langsung dari halaman ini */
        .form-input-line { width: 100%; border: none; border-bottom: 1px solid black; outline: none; background: transparent; font-family: inherit; font-size: inherit; padding: 2px 4px; box-sizing: border-box; text-align: center; }
        .form-input-line:focus { background-color: #f0f8ff; border-bottom: 1px solid #00a4e4; }
        .form-input-line::placeholder { color: #9ca3af; font-style: italic; }

        .btn-print { width: 100px; height: 36px; line-height: 36px; background-color: #16a34a; color: white; border: none; cursor: pointer; border-radius: 6px; font-weight: bold; text-align: center; display: inline-block; }
        .btn-kembali { width: 100px; height: 36px; line-height: 36px; background-color: #ef4444; color: white; border: none; cursor: pointer; border-radius: 6px; font-weight: bold; text-align: center; display: inline-block; text-decoration: none; }
        .btn-simpan-ttd { height: 36px; line-height: 36px; padding: 0 16px; background-color: #2563eb; color: white; border: none; cursor: pointer; border-radius: 6px; font-weight: bold; text-align: center; display: inline-block; }

        /* PENGATURAN CETAK SUPER PRESISI FULL A4 (TEPAT 2 HALAMAN) */
        @page { size: A4 portrait; margin: 10mm 15mm; }
        @media print {
            body { margin: 0; padding: 0; background-color: white; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .a4-container { box-shadow: none; padding: 0; margin: 0; width: 100%; height: auto; min-height: auto; margin-bottom: 0; }
            .page-break { page-break-before: always; }
            .no-print { display: none !important; }
            .form-input-line { border-bottom: none !important; }
        }
    </style>
</head>
<body>

    @php
        $tgl_ref = $form->tanggal_ref;
        try { if($tgl_ref) $tgl_ref = \Carbon\Carbon::parse($tgl_ref)->locale('id')->translatedFormat('d F Y'); } catch(\Exception $e) {}

        $tgl_so = $form->tanggal_stock_opname;
        try { if($tgl_so) $tgl_so = \Carbon\Carbon::parse($tgl_so)->locale('id')->translatedFormat('d F Y'); } catch(\Exception $e) {}

        $tgl_ttd = $form->tanggal_ttd;
        try { if($tgl_ttd) $tgl_ttd = \Carbon\Carbon::parse($tgl_ttd)->locale('id')->translatedFormat('d - m - Y'); } catch(\Exception $e) {}

        $items = collect($form->details)->toArray();
    @endphp

    <div class="no-print" style="width: 210mm; display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 20px;">
        <a href="{{ route('form-ba-stock-opname.index') }}" class="btn-kembali">Kembali</a>
        <button type="submit" form="signerForm" class="btn-simpan-ttd">Simpan Tanda Tangan</button>
        <button onclick="window.print()" class="btn-print">Print PDF</button>
    </div>

    {{-- Satu form membungkus kedua halaman. Field non-tanda-tangan dikirim sebagai hidden input
         supaya data yang sudah ada tidak ikut hilang ketika hanya tanda tangan yang diubah. --}}
    <form action="{{ route('form-ba-stock-opname.update', $form->id) }}" method="POST" id="signerForm">
        @csrf
        @method('PUT')

        <input type="hidden" name="no_ref" value="{{ $form->no_ref }}">
        <input type="hidden" name="tanggal_ref" value="{{ $form->tanggal_ref }}">
        <input type="hidden" name="business_area" value="{{ $form->business_area }}">
        <input type="hidden" name="tanggal_stock_opname" value="{{ $form->tanggal_stock_opname }}">
        <input type="hidden" name="unit_kerja" value="{{ $form->unit_kerja }}">
        <input type="hidden" name="tempat_kedudukan" value="{{ $form->tempat_kedudukan }}">
        <input type="hidden" name="analisa" value="{{ $form->analisa }}">
        <input type="hidden" name="tindak_lanjut" value="{{ $form->tindak_lanjut }}">
        <input type="hidden" name="tempat_ttd" value="{{ $form->tempat_ttd }}">
        <input type="hidden" name="tanggal_ttd" value="{{ $form->tanggal_ttd }}">
        @foreach ($items as $index => $item)
            <input type="hidden" name="items[{{ $index }}][nomor_inventaris_aset]" value="{{ $item['nomor_inventaris_aset'] ?? '' }}">
            <input type="hidden" name="items[{{ $index }}][serial_number]" value="{{ $item['serial_number'] ?? '' }}">
            <input type="hidden" name="items[{{ $index }}][jenis_aset_ti]" value="{{ $item['jenis_aset_ti'] ?? '' }}">
            <input type="hidden" name="items[{{ $index }}][merek]" value="{{ $item['merek'] ?? '' }}">
            <input type="hidden" name="items[{{ $index }}][sumber_data]" value="{{ $item['sumber_data'] ?? '' }}">
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
            <table class="kop-table">
                <tr>
                    <td rowspan="2" style="width: 20%; text-align: center; vertical-align: middle;">
                        <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI" style="width: 100%; max-width: 90px; height: auto; display: inline-block;">
                    </td>
                    <td rowspan="2" style="width: 45%; text-align: center; font-weight: bold; font-size: 12px;">
                        PT KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI
                    </td>
                    <td style="width: 12%;">Nomor</td>
                    <td style="width: 23%;">FR.SM/TI/011.010/04-2021</td>
                </tr>
                <tr><td>Tanggal</td><td>13 April 2021</td></tr>
                <tr>
                    <td rowspan="2" style="text-align: center; padding: 10px;">
                        <div style="border: 2px solid #eadc04; color: #eadc04; font-weight: bold; font-size: 14px; padding: 6px 12px; display: inline-block;">TERBATAS</div>
                    </td>
                    <td rowspan="2" style="text-align: center; font-weight: bold; font-size: 12px;">
                        FORMULIR BERITA ACARA<br>STOCK OPNAME ASET TEKNOLOGI INFORMASI
                    </td>
                    <td>Versi</td><td>001-2021</td>
                </tr>
                <tr><td>Halaman</td><td>1 dari 2</td></tr>
            </table>

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

            <div style="font-size: 11px; margin-top: 20px;">
                <div style="font-weight: bold; font-size: 11px;">I. <span style="margin-left: 10px;">Pelaksanaan Stock Opname</span></div>
                <div style="margin-left: 25px; margin-bottom: 10px;">Dilaksanakan Stock Opname, sebagai berikut:</div>

                <div style="border-top: 1px solid black; border-bottom: 1px solid black; margin-left: 25px; padding: 15px 0;">
                    <table style="width: 100%; font-size: 11px; border-collapse: separate; border-spacing: 0 10px;">
                        <tr>
                            <td style="width: 150px;">Tanggal Stock Opname</td>
                            <td style="width: 20px;">:</td>
                            <td style="border-bottom: 1px solid black;">{{ $tgl_so }}</td>
                        </tr>
                        <tr>
                            <td>Unit Kerja</td>
                            <td>:</td>
                            <td style="border-bottom: 1px solid black;">{{ $form->unit_kerja }}</td>
                        </tr>
                        <tr>
                            <td>Tempat Kedudukan</td>
                            <td>:</td>
                            <td style="border-bottom: 1px solid black;">{{ $form->tempat_kedudukan }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div style="font-size: 11px; margin-top: 25px;">
                <div style="font-weight: bold; font-size: 11px; margin-bottom: 10px;">II. <span style="margin-left: 10px;">Analisa & Tindak Lanjut</span></div>

                <div style="border: 1px solid black; margin-left: 25px;">
                    <div style="padding: 10px 15px; border-bottom: 1px solid black;">
                        <div style="text-decoration: underline; font-style: italic; margin-bottom: 2px;">Analisa:</div>
                        <div style="color: red; margin-bottom: 10px;">(Hasil dari Stock Opname data Aset Teknologi Informasi antara data & fisik asset aktual / saat ini dan/atau peraturan yang berlaku)</div>
                        <div style="min-height: 60px; white-space: pre-wrap;">{{ $form->analisa }}</div>
                        <div style="margin-top: 10px;">Detail Data Aset TI dituangkan pada lampiran yang menjadi bagian tidak terpisahkan dari Berita Acara Stock Opname Aset Teknologi Informasi ini.</div>
                    </div>
                    <div style="padding: 10px 15px;">
                        <div style="text-decoration: underline; font-style: italic; margin-bottom: 2px;">Tindak Lanjut:</div>
                        <div style="color: red; margin-bottom: 10px;">(Tindak lanjut yang akan dilakukan untuk memperbaiki ketidaksesuaian dari hasil stock opname data Aset TI)</div>
                        <div style="min-height: 60px; white-space: pre-wrap;">{{ $form->tindak_lanjut }}</div>
                    </div>
                </div>
            </div>

            <div style="font-size: 11px; margin-top: 20px;">
                Demikian Berita Acara ini dibuat dengan sebenarnya untuk dapat digunakan sebagaimana mestinya.
            </div>

            <div style="text-align: right; font-size: 11px; margin-top: 20px; margin-bottom: 30px;">
                {{ $form->tempat_ttd ?? 'Yogyakarta' }}, {{ $tgl_ttd ?: '....... - ....... - ................' }}
            </div>

            <table style="width:100%; border-collapse:collapse; font-size:11px; text-align:center; margin-top:20px;">
            <tr>
                <td style="width:50%;">
                    <div style="height:40px;">
                        Pimpinan Unit Kerja
                    </div>
                </td>

                <td style="width:50%;">
                    <div style="height:40px;">
                        Pimpinan IT Kantor Pusat/Daerah<br>
                        (Pengelola Aset TI)
                    </div>
                </td>
            </tr>

            <tr>
                <!-- Pimpinan Unit Kerja -->
                <td style="padding-top:60px;">

                    <div style="margin-bottom:8px;">
                        (
                        <input
                            type="text"
                            name="pimpinan_unit_kerja"
                            id="pimpinan_unit_kerja"
                            @isset($masterSigners) list="signer-list" @endisset
                            value="{{ old('pimpinan_unit_kerja', $form->pimpinan_unit_kerja) }}"
                            class="form-input-line"
                            style="width:180px; text-align:center;"
                            placeholder="Nama Pimpinan Unit Kerja"
                        >
                        )
                    </div>

                    <div style="margin-top:3px;">
                        NIPP.
                        <input
                            type="text"
                            name="nipp_pimpinan_unit_kerja"
                            id="nipp_pimpinan_unit_kerja"
                            value="{{ old('nipp_pimpinan_unit_kerja', $form->nipp_pimpinan_unit_kerja) }}"
                            class="form-input-line"
                            style="width:110px; text-align:center;"
                            placeholder="NIPP"
                        >
                    </div>

                </td>

                <!-- Pimpinan IT -->
                <td style="padding-top:60px;">

                    <div style="margin-bottom:8px;">
                        (
                        <input
                            type="text"
                            name="pimpinan_it"
                            id="pimpinan_it"
                            @isset($masterSigners) list="signer-list" @endisset
                            value="{{ old('pimpinan_it', $form->pimpinan_it) }}"
                            class="form-input-line"
                            style="width:180px; text-align:center;"
                            placeholder="Nama Pimpinan IT"
                        >
                        )
                    </div>

                    <div style="margin-top:3px;">
                        NIPP.
                        <input
                            type="text"
                            name="nipp_pimpinan_it"
                            id="nipp_pimpinan_it"
                            value="{{ old('nipp_pimpinan_it', $form->nipp_pimpinan_it ?? '') }}"
                            class="form-input-line"
                            style="width:110px; text-align:center;"
                            placeholder="NIPP"
                        >
                    </div>

                </td>
            </tr>
        </table>
        </div>

        <!-- HALAMAN 2 -->
        <div class="a4-container page-break">
            <table class="kop-table">
                <tr>
                    <td rowspan="2" style="width: 20%; text-align: center; vertical-align: middle;">
                        <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI" style="width: 100%; max-width: 90px; height: auto; display: inline-block;">
                    </td>
                    <td rowspan="2" style="width: 45%; text-align: center; font-weight: bold; font-size: 12px;">
                        PT KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI
                    </td>
                    <td style="width: 12%;">Nomor</td>
                    <td style="width: 23%;">FR.SM/TI/011.010/04-2021</td>
                </tr>
                <tr><td>Tanggal</td><td>13 April 2021</td></tr>
                <tr>
                    <td rowspan="2" style="text-align: center; padding: 10px;">
                        <div style="border: 2px solid #eadc04; color: #eadc04; font-weight: bold; font-size: 14px; padding: 6px 12px; display: inline-block;">TERBATAS</div>
                    </td>
                    <td rowspan="2" style="text-align: center; font-weight: bold; font-size: 12px;">
                        FORMULIR BERITA ACARA<br>STOCK OPNAME ASET TEKNOLOGI INFORMASI
                    </td>
                    <td>Versi</td><td>001-2021</td>
                </tr>
                <tr><td>Halaman</td><td>2 dari 2</td></tr>
            </table>

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

            <div style="text-align: right; font-size: 8px; margin-top: 30px; margin-bottom: 20px;">
                Lampiran Formulir<br>Stock Opname Data Aset Teknologi Informasi
            </div>

            <div style="text-align: center; font-size: 11px; font-weight: bold; margin-bottom: 15px;">
                Stock Opname<br>Data Aset Teknologi Informasi
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 18%;">Nomor Invetaris Aset</th>
                        <th style="width: 18%;">Serial Number</th>
                        <th style="width: 15%;">Jenis Aset TI</th>
                        <th style="width: 12%;">Merek</th>
                        <th style="width: 12%;">Sumber Data</th>
                        <th style="width: 20%;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item['nomor_inventaris_aset'] ?? '' }}</td>
                            <td>{{ $item['serial_number'] ?? '' }}</td>
                            <td>{{ $item['jenis_aset_ti'] ?? '' }}</td>
                            <td>{{ $item['merek'] ?? '' }}</td>
                            <td>{{ $item['sumber_data'] ?? '' }}</td>
                            <td>{{ $item['keterangan'] ?? '' }}</td>
                        </tr>
                    @endforeach
                    @for ($i = count($items); $i < 4; $i++)
                        <tr>
                            <td style="height: 25px;"></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                    @endfor
                </tbody>
            </table>

            <div style="display: flex; justify-content: flex-end; margin-top: 50px;">
            <table style="width:300px; border-collapse:collapse; font-size:11px; text-align:center;">

                <tr>
                    <td style="border:1px solid black; padding:6px; font-weight:normal;">
                        Petugas IT Stock Opname
                    </td>
                </tr>

                <tr>
                    <td style="border:1px solid black; padding-top:65px; padding-bottom:10px;">

                        <div style="margin-bottom:8px;">
                            (
                            <input
                                type="text"
                                name="petugas_it"
                                id="petugas_it"
                                @isset($masterSigners) list="signer-list" @endisset
                                value="{{ old('petugas_it', $form->petugas_it) }}"
                                class="form-input-line"
                                style="width:190px; text-align:center; font-weight:bold;"
                                placeholder="Nama Petugas IT"
                            >
                            )
                        </div>

                        <div style="margin-top:3px;">
                            NIPP.
                            <input
                                type="text"
                                name="nipp_petugas_it"
                                id="nipp_petugas_it"
                                value="{{ old('nipp_petugas_it', $form->nipp_petugas_it ?? '') }}"
                                class="form-input-line"
                                style="width:110px; text-align:center;"
                                placeholder="NIPP"
                            >
                        </div>

                    </td>
                </tr>

            </table>
            </div>
            <div style="clear: both;"></div>
        </div>
    </form>

<script>
    // Autofill NIPP dari daftar master penandatangan (jika tersedia)
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
    setupAutofill('pimpinan_unit_kerja', 'nipp_pimpinan_unit_kerja');
    setupAutofill('pimpinan_it', 'nipp_pimpinan_it');
    setupAutofill('petugas_it', 'nipp_petugas_it');
</script>

</body>
</html>
