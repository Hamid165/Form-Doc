<style>
    /* Reset & Base Print Styles */
    *, *::before, *::after { box-sizing: border-box; }
    
    .paper-wrapper { display: flex; justify-content: center; padding: 20px; background: #e5e7eb; }
    .paper-container {
        width: 210mm;
        min-height: 297mm;
        background: white;
        padding: 1.5cm;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        font-family: Arial, Helvetica, sans-serif !important;
        font-size: 11px !important;
        color: #000 !important;
    }

    /* Typography & Inputs */
    .paper-container *, .paper-container table, .paper-container td, .paper-container th, .paper-container div, .paper-container p, .paper-container span {
        font-family: Arial, Helvetica, sans-serif !important;
        font-size: 11px !important;
        color: #000 !important;
        line-height: 1.4;
    }

    .input-borderless { border: none; outline: none; width: 100%; background: transparent; font-family: inherit; font-size: inherit; }
    .input-inline { border: none; border-bottom: 1px dotted #000; outline: none; background: transparent; font-family: inherit; font-size: inherit; padding: 0 2px; }
    .status-coret { text-decoration: line-through; color: #4b5563; }
    
    /* Checklist Table Styling */
    .table-main { width: 100%; border-collapse: collapse; margin-top: 5px; }
    .table-main th, .table-main td { border: 1px solid black; padding: 4px; vertical-align: middle; }
    
    .checkbox-status {
        appearance: none; -webkit-appearance: none;
        width: 14px; height: 14px; border: 1px solid #000;
        outline: none; background-color: #fff; cursor: pointer;
        display: inline-block; vertical-align: middle; position: relative;
        text-align: center; line-height: 12px; font-size: 11px; font-weight: bold;
    }
    .checkbox-status:checked::after {
        content: attr(value); position: absolute; top: 0; left: 0; width: 100%; height: 100%; color: #000;
    }

    .textarea-auto {
        width: 100%; border: none; resize: none; overflow: hidden;
        background: transparent; padding: 2px 0; word-wrap: break-word; font-family: inherit; font-size: inherit; line-height: 1.4;
    }

    /* Styling Select Penandatangan */
    .select-signer {
        width: 100%; max-width: 200px; padding: 4px;
        border: none; border-bottom: 1px dashed #000;
        font-family: inherit; font-size: 11px; color: #000;
        outline: none; background-color: transparent; text-align: center;
        appearance: none; cursor: pointer; text-overflow: ellipsis;
    }

    /* Print Settings */
    @media print {
        body * { visibility: hidden; }
        .paper-container, .paper-container * { visibility: visible; }
        .paper-container { position: absolute; left: 0; top: 0; width: 100%; padding: 0.5cm; box-shadow: none; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .print-hidden { display: none !important; }
        @page { size: A4; margin: 1cm; }
    }
</style>

@php
    $isView = isset($mode) && $mode === 'show';
    $isEdit = isset($method) && $method === 'PUT';
    $detail = $baItService->detail_penanganan ?? [];
    $statusTerima = old('status_terima', $baItService->status_terima ?? 'Diterima');
    $signersList = $signers ?? collect(); 
@endphp

<div class="paper-wrapper">
    <div class="paper-container">
        <form action="{{ $action ?? '#' }}" method="POST" id="form-ba">
            @if ($errors->any())
                <div style="background-color: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 8px; margin-bottom: 15px; font-weight: bold; border: 1px solid #f87171;">
                    ⚠️ {{ $errors->first() }}
                </div>
            @endif
            @csrf
            @if($isEdit) @method('PUT') @endif

            <!-- 1. KOP SURAT (SINGLE TABLE GRID) -->
            <table style="width: 100%; border-collapse: collapse; border: 1px solid black; margin-bottom: 15px;">
                <tr>
                    <td rowspan="2" style="width: 18%; border: 1px solid black; text-align: center; padding: 10px;">
                        <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI" style="height: 35px; object-fit: contain;">
                    </td>
                    <td rowspan="2" style="width: 44%; border: 1px solid black; text-align: center; font-weight: bold; font-size: 11.5px !important; padding: 10px;">
                        PT KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI
                    </td>
                    <td style="width: 12%; border: 1px solid black; padding: 4px 6px;">Nomor</td>
                    <td style="width: 26%; border: 1px solid black; padding: 4px 6px; white-space: nowrap;">
                        @if($isView) 
                            {{ $baItService->no_dokumen ?? 'FR.SM/IT/011.005/10-2020' }} 
                        @else 
                            <input type="text" name="no_dokumen" class="input-borderless" value="{{ old('no_dokumen', $baItService->no_dokumen ?? 'FR.SM/IT/011.005/10-2020') }}" readonly>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 4px 6px;">Tanggal</td>
                    <td style="border: 1px solid black; padding: 4px 6px;">
                        @if($isView)
                            12 Oktober 2020
                        @else
                            <input type="text" name="tanggal_dokumen" class="input-borderless" value="12 Oktober 2020" readonly>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td rowspan="2" style="border: 1px solid black; text-align: center; padding: 8px;">
                        <div style="border: 2px solid #fff700; color: #fff700 !important; font-weight: bold; font-size: 13px !important; text-align: center; padding: 3px 0; width: 90%; margin: 0 auto;">
                            TERBATAS
                        </div>
                    </td>
                    <td rowspan="2" style="border: 1px solid black; text-align: center; font-weight: bold; font-size: 11.5px !important; padding: 10px;">
                        BERITA ACARA INSTALASI DAN<br>TROUBLESHOOTING LAYANAN IT
                    </td>
                    <td style="border: 1px solid black; padding: 4px 6px;">Versi</td>
                    <td style="border: 1px solid black; padding: 4px 6px;">
                        @if($isView) 
                            {{ $baItService->versi ?? '002-2020' }} 
                        @else 
                            <input type="text" name="versi" class="input-borderless" value="{{ old('versi', $baItService->versi ?? '002-2020') }}" readonly> 
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 4px 6px;">Halaman</td>
                    <td style="border: 1px solid black; padding: 4px 6px;">1 dari 2</td>
                </tr>
            </table>

<!-- 2. TABEL REF (DENGAN BORDER & PLACEHOLDER) -->
            <table style="width: 45%; margin-bottom: 15px; border-collapse: collapse; border: 1px solid black;">
                <tr>
                    <td style="width: 35%; border: 1px solid black; padding: 4px 6px;">No. Ref</td>
                    <td style="border: 1px solid black; padding: 4px 6px;">: 
                        @if($isView) {{ $baItService->no_ref ?? '' }} 
                        @else <input type="text" name="no_ref" class="input-inline" value="{{ old('no_ref', $baItService->no_ref ?? '') }}" placeholder="___ / ___ / ______" autocomplete="off" style="width: 80%;"> @endif
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 4px 6px;">Tanggal</td>
                    <td style="border: 1px solid black; padding: 4px 6px;">: 
                        @if($isView) {{ $baItService->tgl_ref ?? '' }} 
                        @else 
                            <!-- Menggunakan trik onfocus agar bisa memunculkan garis bawah saat kosong, tapi tetap memunculkan kalender saat diklik -->
                            <input type="text" name="tgl_ref" class="input-inline" value="{{ old('tgl_ref', $baItService->tgl_ref ?? '') }}" placeholder="___ - ___ - ______" onfocus="(this.type='date')" onblur="if(!this.value) this.type='text'" autocomplete="off" style="width: 80%;"> 
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 4px 6px;">Business Area</td>
                    <td style="border: 1px solid black; padding: 4px 6px;">: 
                        @if($isView) {{ $baItService->business_area ?? '' }} 
                        @else <input type="text" name="business_area" class="input-inline" value="{{ old('business_area', $baItService->business_area ?? '') }}" placeholder="______" autocomplete="off" style="width: 80%;"> @endif
                    </td>
                </tr>
            </table>

            <!-- 3. DATA PEMOHON -->
            <div style="margin-bottom: 15px;">
                <div style="margin-bottom: 4px;">Permintaan Layanan dari :</div>
                <table style="width: 100%; border: none; border-collapse: collapse;">
                    <tr>
                        <td style="width: 150px; padding: 2px 0;">Nama</td>
                        <td style="padding: 2px 0;">: 
                            @if($isView) {{ $baItService->pemohon_nama ?? '' }} 
                            @else <input type="text" name="pemohon_nama" class="input-inline" value="{{ old('pemohon_nama', $baItService->pemohon_nama ?? '') }}" style="width: 250px;" required> @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 2px 0;">Unit</td>
                        <td style="padding: 2px 0;">: 
                            @if($isView) {{ $baItService->pemohon_unit ?? '' }} 
                            @else <input type="text" name="pemohon_unit" class="input-inline" value="{{ old('pemohon_unit', $baItService->pemohon_unit ?? '') }}" style="width: 250px;" required> @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 2px 0;">Telepon / Toka / Email</td>
                        <td style="padding: 2px 0;">: 
                            @if($isView) {{ $baItService->pemohon_kontak ?? '' }} 
                            @else <input type="text" name="pemohon_kontak" class="input-inline" value="{{ old('pemohon_kontak', $baItService->pemohon_kontak ?? '') }}" style="width: 250px;"> @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 2px 0;">Waktu Pengerjaan</td>
                        <td style="padding: 2px 0;">
                            : Tanggal 
                            @if($isView)
                                {{ isset($baItService->waktu_mulai) ? $baItService->waktu_mulai->format('Y-m-d') : '................' }}
                            @else
                                <input type="date" name="waktu_mulai_tgl" class="input-inline text-center" value="{{ old('waktu_mulai_tgl', isset($baItService->waktu_mulai) ? $baItService->waktu_mulai->format('Y-m-d') : '') }}" style="width: 100px; margin: 0 4px;">
                            @endif
                            Pukul : 
                            @if($isView)
                                {{ isset($baItService->waktu_mulai) ? $baItService->waktu_mulai->format('H:i') : '........' }}
                            @else
                                <input type="time" name="waktu_mulai_jam" class="input-inline text-center" value="{{ old('waktu_mulai_jam', isset($baItService->waktu_mulai) ? $baItService->waktu_mulai->format('H:i') : '') }}" style="width: 60px; margin: 0 4px;">
                            @endif
                            <span style="margin: 0 8px;">s.d</span>
                            Tanggal : 
                            @if($isView)
                                {{ isset($baItService->waktu_selesai) ? $baItService->waktu_selesai->format('Y-m-d') : '................' }}
                            @else
                                <input type="date" name="waktu_selesai_tgl" class="input-inline text-center" value="{{ old('waktu_selesai_tgl', isset($baItService->waktu_selesai) ? $baItService->waktu_selesai->format('Y-m-d') : '') }}" style="width: 100px; margin: 0 4px;">
                            @endif
                            Pukul : 
                            @if($isView)
                                {{ isset($baItService->waktu_selesai) ? $baItService->waktu_selesai->format('H:i') : '........' }}
                            @else
                                <input type="time" name="waktu_selesai_jam" class="input-inline text-center" value="{{ old('waktu_selesai_jam', isset($baItService->waktu_selesai) ? $baItService->waktu_selesai->format('H:i') : '') }}" style="width: 60px; margin: 0 4px;">
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <!-- 4. TABEL CHECKLIST -->
            <div style="margin-bottom: 15px;">
                <div style="margin-bottom: 4px;">Hasil Penanganan Instalasi dan/atau <i>Troubleshooting</i> :</div>
                <table class="table-main">
                    <tr>
                        <td colspan="8" style="text-align: left; padding: 4px 8px;">
                            Nomor Inventaris Aset : 
                            @if($isView) {{ $baItService->no_inventaris_aset ?? '' }}
                            @else <input type="text" name="no_inventaris_aset" class="input-inline" value="{{ old('no_inventaris_aset', $baItService->no_inventaris_aset ?? '') }}" style="width: 300px;"> @endif
                        </td>
                    </tr>
                    <tr style="text-align: center; font-weight: bold;">
                        <td rowspan="2" style="width: 5%;">No.</td>
                        <td rowspan="2" style="width: 18%;">Kategori Layanan</td>
                        <td colspan="2" style="width: 18%;">Jenis Layanan</td>
                        <td rowspan="2" style="width: 25%;">Detail Pekerjaan</td>
                        <td colspan="2" style="width: 9%;">Status</td>
                        <td rowspan="2" style="width: 25%;">Keterangan</td>
                    </tr>
                    <tr style="text-align: center; font-weight: bold;">
                        <td style="width: 6%;">No.</td>
                        <td style="width: 12%;">Nama</td>
                        <td>V</td><td>X</td>
                    </tr>
                    @php $rows = [['1.1', '1_1', 'Aplikasi'], ['1.2', '1_2', 'Jaringan'], ['1.3', '1_3', 'PC / Laptop'], ['1.4', '1_4', 'Printer'], ['1.5', '1_5', 'Lainnya :'], ['2.1', '2_1', 'Aplikasi'], ['2.2', '2_2', 'Sistem Operasi'], ['2.3', '2_3', 'Jaringan'], ['2.4', '2_4', 'PC / Laptop'], ['2.5', '2_5', 'Printer'], ['2.6', '2_6', 'Lainnya :']]; @endphp
                    @foreach($rows as $idx => $r)
                        @php $st = $detail[$r[1]]['status'] ?? ''; $isLain = str_contains($r[2], 'Lain'); @endphp
                        <tr>
                            @if($idx == 0) <td rowspan="5" style="text-align: center;">1</td><td rowspan="5" style="padding-left: 5px;">Troubleshooting</td> @elseif($idx == 5) <td rowspan="6" style="text-align: center;">2</td><td rowspan="6" style="padding-left: 5px;">Instalasi</td> @endif
                            <td style="text-align: center;">{{ $r[0] }}</td>
                            <td style="text-align: left; padding: 4px;">
                                {{ $r[2] }} 
                                @if($isLain) 
                                    @if($isView) <br>{{ $detail[$r[1]]['detail_lain'] ?? '' }}
                                    @else <input type="text" name="penanganan[{{ $r[1] }}][detail_lain]" class="input-inline" value="{{ $detail[$r[1]]['detail_lain'] ?? '' }}" style="width: 90%; margin-top:2px;"> @endif
                                @endif
                            </td>
                            <td>
                                @if($isView) {{ $detail[$r[1]]['detail'] ?? '' }}
                                @else <textarea name="penanganan[{{ $r[1] }}][detail]" class="textarea-auto" rows="1" oninput="this.style.height='auto';this.style.height=this.scrollHeight+'px'">{{ $detail[$r[1]]['detail'] ?? '' }}</textarea> @endif
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                @if($isView)
                                    <span style="font-weight: bold; font-size: 12px;">{{ ($st == '√' || $st == 'V') ? 'V' : '' }}</span>
                                @else
                                    <input type="radio" name="penanganan[{{ $r[1] }}][status]" value="V" class="checkbox-status" {{ $st == '√' || $st == 'V' ? 'checked' : '' }}>
                                @endif
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                @if($isView)
                                    <span style="font-weight: bold; font-size: 12px;">{{ ($st == 'X' || $st == '✖') ? 'X' : '' }}</span>
                                @else
                                    <input type="radio" name="penanganan[{{ $r[1] }}][status]" value="X" class="checkbox-status" {{ $st == 'X' || $st == '✖' ? 'checked' : '' }}>
                                @endif
                            </td>
                            <td>
                                @if($isView) {{ $detail[$r[1]]['keterangan'] ?? '' }}
                                @else <textarea name="penanganan[{{ $r[1] }}][keterangan]" class="textarea-auto" rows="1" oninput="this.style.height='auto';this.style.height=this.scrollHeight+'px'">{{ $detail[$r[1]]['keterangan'] ?? '' }}</textarea> @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

            <!-- 5. PERNYATAAN -->
            <div style="margin-bottom: 25px;">
                <div style="margin-bottom: 5px;">* V : Selesai; X : Gagal</div>
                <div style="margin-bottom: 5px; text-align: justify;">
                    Menyatakan bahwa , penanganan instalasi dan atau troubleshooting telah diperiksa dan dilakukan oleh pihak Sistem Informasi dan pihak 
                    @if($isView) {{ $baItService->pihak_terkait ?? '....................' }}
                    @else <input type="text" name="pihak_terkait" class="input-inline text-center" value="{{ old('pihak_terkait', $baItService->pihak_terkait ?? '') }}" style="width:150px;"> @endif
                    dengan hasil seperti dijelaskan diatas.
                </div>
                <div>
                    Selanjutnya, 
                    @if($isView)
                        <span class="{{ $statusTerima == 'Ditolak' ? 'status-coret' : '' }}">Diterima</span> / <span class="{{ $statusTerima == 'Diterima' ? 'status-coret' : '' }}">Ditolak</span> *)
                    @else
                        <select name="status_terima" class="input-inline" style="width: 80px; font-weight: bold;">
                            <option value="Diterima" {{ $statusTerima == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="Ditolak" {{ $statusTerima == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select> *)
                    @endif
                </div>
            </div>

            <!-- 6. TANDA TANGAN (TABLE LAYOUT ASIMETRIS WORD) -->
            <div x-data="{
                signers: {{ $signersList->toJson() }},
                stafNipp: '{{ old('ttd_staf_nipp', $baItService->ttd_staf_nipp ?? '') }}',
                mengetahuiNipp: '{{ old('ttd_mengetahui_nipp', $baItService->ttd_mengetahui_nipp ?? '') }}'
            }">
                <table style="width: 100%; text-align: center; border: none; margin-top: 10px; table-layout: fixed;">
                    <!-- Baris 1: Judul Staf IT & User -->
                    <tr>
                        <td style="width: 33.33%; vertical-align: top; padding: 0 10px;">
                            <div style="margin-bottom: 2px;">Staf IT</div>
                            @if($isView)
                                @php $staf = $signersList->firstWhere('nipp', $baItService->ttd_staf_nipp ?? ''); @endphp
                                <div style="min-height: 15px;">{{ $staf->jabatan ?? '' }}</div>
                            @else
                                <select x-model="stafNipp" class="select-signer"><option value="">-- Pilih Jabatan --</option><template x-for="s in signers" :key="s.nipp"><option :value="s.nipp" x-text="s.jabatan"></option></template></select>
                            @endif
                        </td>
                        <td style="width: 33.33%; vertical-align: top; padding: 0 10px;"></td>
                        <td style="width: 33.33%; vertical-align: top; padding: 0 10px;">
                            <div style="margin-bottom: 2px;">User,</div>
                            <div style="min-height: 15px;"></div>
                        </td>
                    </tr>
                    
                    <!-- Baris 2: Spasi 3 Baris untuk Staf/User, dan memunculkan "Mengetahui" -->
                    <tr>
                        <td style="height: 45px;"></td>
                        <td style="vertical-align: top; padding: 0 10px;">
                            <div style="margin-bottom: 2px;">Mengetahui,</div>
                            @if($isView)
                                @php $mengetahui = $signersList->firstWhere('nipp', $baItService->ttd_mengetahui_nipp ?? ''); @endphp
                                <div style="min-height: 15px;">{{ $mengetahui->jabatan ?? '' }}</div>
                            @else
                                <select x-model="mengetahuiNipp" class="select-signer"><option value="">-- Pilih Jabatan --</option><template x-for="s in signers" :key="s.nipp"><option :value="s.nipp" x-text="s.jabatan"></option></template></select>
                            @endif
                        </td>
                        <td style="height: 45px;"></td>
                    </tr>

                    <!-- Baris 3: Nama/NIPP Staf & User -->
                    <tr>
                        <td style="vertical-align: top; padding: 0 10px;">
                            @if($isView)
                                <div style="font-weight: bold; text-decoration: underline; margin-bottom: 4px;">{{ $staf->nama ?? '..........................................' }}</div>
                                <div>NIPP. {{ $staf->nipp ?? '................' }}</div>
                            @else
                                <select x-model="stafNipp" class="select-signer"><option value="">-- Pilih Nama --</option><template x-for="s in signers" :key="s.nipp"><option :value="s.nipp" x-text="s.nama"></option></template></select>
                                <div style="height: 4px;"></div>
                                <select name="ttd_staf_nipp" x-model="stafNipp" class="select-signer"><option value="">-- Pilih NIPP --</option><template x-for="s in signers" :key="s.nipp"><option :value="s.nipp" x-text="'NIPP. ' + s.nipp"></option></template></select>
                            @endif
                        </td>
                        <td style="height: 45px;"></td> <!-- Spasi 3 baris untuk TTD Mengetahui -->
                        <td style="vertical-align: top; padding: 0 10px;">
                            @if($isView)
                                <div style="font-weight: bold; text-decoration: underline; margin-bottom: 4px;">{{ $baItService->pemohon_nama ?? '..........................................' }}</div>
                                <div>NIPP. {{ $baItService->ttd_user_nipp ?? '................' }}</div>
                            @else
                                <input type="text" placeholder="-- Nama User --" class="select-signer" value="{{ old('pemohon_nama', $baItService->pemohon_nama ?? '') }}" readonly>
                                <div style="height: 4px;"></div>
                                <input type="text" name="ttd_user_nipp" placeholder="-- Ketik NIPP --" class="select-signer" value="{{ old('ttd_user_nipp', $baItService->ttd_user_nipp ?? '') }}">
                            @endif
                        </td>
                    </tr>

                    <!-- Baris 4: Nama/NIPP Mengetahui -->
                    <tr>
                        <td></td>
                        <td style="vertical-align: top; padding: 0 10px;">
                            @if($isView)
                                <div style="font-weight: bold; text-decoration: underline; margin-bottom: 4px;">{{ $mengetahui->nama ?? '..........................................' }}</div>
                                <div>NIPP. {{ $mengetahui->nipp ?? '................' }}</div>
                            @else
                                <select x-model="mengetahuiNipp" class="select-signer"><option value="">-- Pilih Nama --</option><template x-for="s in signers" :key="s.nipp"><option :value="s.nipp" x-text="s.nama"></option></template></select>
                                <div style="height: 4px;"></div>
                                <select name="ttd_mengetahui_nipp" x-model="mengetahuiNipp" class="select-signer"><option value="">-- Pilih NIPP --</option><template x-for="s in signers" :key="s.nipp"><option :value="s.nipp" x-text="'NIPP. ' + s.nipp"></option></template></select>
                            @endif
                        </td>
                        <td></td>
                    </tr>
                </table>
            </div>

            <!-- ACTION BUTTONS -->
            @unless($isView)
                <div class="flex-row justify-end mt-8 print-hidden" style="gap: 12px;">
                    <a href="{{ route('ba-it.index') }}" style="padding: 10px 20px; font-size: 14px; font-weight: bold; color: #ffffff !important; background: #ff0000; border-radius: 8px; text-decoration: none;">Batal</a>
                    <button type="submit" style="padding: 10px 20px; font-size: 14px; font-weight: bold; color: white !important; background: #059669; border: none; border-radius: 8px; cursor: pointer;">{{ $isEdit ? 'Perbarui' : 'Simpan' }}</button>
                </div>
            @else
                <div class="flex-row justify-end mt-8 print-hidden" style="gap: 12px;">
                    <a href="{{ route('ba-it.index') }}" style="padding: 8px 16px; font-size: 12px; font-weight: bold; color: white !important; background: #6b7280; border-radius: 8px; text-decoration: none;">Kembali</a>
                    <a href="{{ route('ba-it.pdf', $baItService->id) }}" target="_blank" style="padding: 8px 16px; font-size: 12px; font-weight: bold; color: white !important; background: #059669; border-radius: 8px; text-decoration: none;">Cetak PDF</a>
                </div>
                @if(request()->is('*/pdf'))
                    <script>window.onload = function() { window.print(); };</script>
                @endif
            @endunless
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.textarea-auto').forEach(function(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        });
    });
</script>