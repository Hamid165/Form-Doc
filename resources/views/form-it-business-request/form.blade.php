@extends('layouts.app')

@section('content')
<style>
    /* Base Styling untuk meniru cetakan A4 */
    .a4-wrapper {
        display: flex;
        justify-content: center;
        padding: 20px;
    }
    .a4-container {
        width: 210mm;
        background: white;
        padding: 20mm;
        box-sizing: border-box;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11px;
        color: #000;
    }
    
    /* Table Reset */
    .a4-container table {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 15px;
    }
    
    .main-table th, .main-table td {
        border: 1px solid black;
        padding: 4px 8px;
        vertical-align: top;
    }

    .main-table th {
        background-color: #f9f9f9;
        font-weight: bold;
    }

    /* Tabel Kop Surat */
    .kop-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
        font-size: 11px;
    }
    .kop-table td {
        border: 1px solid #000;
        padding: 4px 6px;
        vertical-align: middle;
    }

    /* Inputs */
    .form-input {
        width: 100%;
        box-sizing: border-box;
        border: none;
        padding: 4px;
        background-color: #fcfcfc;
        border-bottom: 1px dotted #ccc;
        font-family: inherit;
        font-size: 11px;
    }
    .form-input:focus {
        border-color: #00a4e4;
        outline: none;
        background-color: #fff;
    }
    
    textarea.form-input {
        resize: vertical;
        min-height: 60px;
    }

    .header-title {
        text-align: center;
        font-weight: bold;
        font-size: 14px;
        margin-bottom: 20px;
        text-transform: uppercase;
    }

    .section-title {
        font-weight: bold;
        background-color: #eee;
        padding: 5px;
        margin-top: 15px;
        border: 1px solid black;
    }

    /* Footer Signature */
    .signature-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        margin-top: 20px;
        text-align: center;
    }

    .signature-box {
        border: 1px solid black;
        padding: 5px;
        min-height: 120px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .btn-submit {
        background-color: #16a34a; 
        color: white;
        padding: 4px 12px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        font-size: 11px;
        transition: background 0.2s;
    }
    .btn-submit:hover {
        background-color: #15803d;
    }
    
    .btn-kembali {
        display: inline-flex; align-items: center; justify-content: center; height: 30px; padding: 4px 12px; background-color: #ef4444; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; font-family: inherit; font-size: 11px; box-sizing: border-box;
        transition: background-color 0.2s;
    }
    .btn-kembali:hover {
        background-color: #dc2626;
    }
</style>

<div class="a4-wrapper" style="flex-direction: column; align-items: center;">
    <div class="top-nav-container" style="width: 100%; max-width: 273mm; margin-bottom: 20px;">
        <a href="{{ route('form-it-business-request.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors mb-6">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar IT Business Request
        </a>
    </div>
    
    <div class="zoom-container" style="zoom: 1.3; width: 100%; display: flex; justify-content: center;">
        <div class="a4-container" style="max-width: 100%; overflow-x: auto;">
            <form action="{{ $action }}" method="POST">
                @csrf
                @if(isset($method) && $method === 'PUT')
                    @method('PUT')
                @endif

                <!-- Kop Surat KAI -->
                @php
                    $kategori = strtoupper($formTemplate->kategori ?? 'Lainnya');
                    if ($kategori === 'PUBLIC' || $kategori === 'ALL') {
                        $kategori = 'UMUM';
                    }
                    $borderColor = '#5cb85c'; // green for UMUM
                    if ($kategori === 'TERBATAS') {
                        $borderColor = '#eadc04'; // yellow
                    } elseif ($kategori === 'RAHASIA') {
                        $borderColor = '#d9534f'; // red
                    }
                @endphp
                <table class="kop-table">
                    <tr>
                        <td rowspan="2" style="width: 20%; text-align: center; vertical-align: middle;">
                            <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI" style="width: 100%; max-width: 90px; height: auto; display: inline-block;">
                        </td>
                        <td rowspan="2" style="width: 45%; text-align: center; font-weight: bold; font-size: 12px; vertical-align: middle;">
                            PT KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI
                        </td>
                        <td style="width: 12%; font-weight: bold;">Nomor</td>
                        <td style="width: 23%;">: {{ $formTemplate->no_dokumen ?? 'FR.SM/TI/026.001/10-2020' }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Tanggal</td>
                        <td>: {{ $formTemplate->tanggal_dokumen ?? '15 Oktober 2020' }}</td>
                    </tr>
                    <tr>
                        <td rowspan="2" style="text-align: center; padding: 10px; vertical-align: middle;">
                            <div style="border: 2px solid {{ $borderColor }}; color: {{ $borderColor }}; font-weight: bold; font-size: 14px; padding: 6px 12px; display: inline-block;">{{ $kategori }}</div>
                        </td>
                        <td rowspan="2" style="text-align: center; font-weight: bold; font-size: 12px; vertical-align: middle;">
                            FORMULIR PENGELOLAAN TI <br> KEBUTUHAN BISNIS (IT BUSINESS REQUEST)
                        </td>
                        <td style="font-weight: bold;">Versi</td>
                        <td>: {{ $formTemplate->versi_dokumen ?? '001-2020' }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Halaman</td>
                        <td>: 1 dari 4</td>
                    </tr>
                </table>


            <table class="main-table">
                <tr>
                    <td style="width: 25%;"><strong>No Ref</strong></td>
                    <td><input type="text" name="no_ref" value="{{ old('no_ref', $form->no_ref) }}" class="form-input" placeholder="Isi No Ref"></td>
                </tr>
                <tr>
                    <td><strong>Tanggal</strong></td>
                    <td>
                        @php
                            $formatted_tanggal = '';
                            if (old('tanggal')) {
                                $formatted_tanggal = old('tanggal');
                            } elseif ($form->tanggal) {
                                try {
                                    $formatted_tanggal = \Carbon\Carbon::createFromFormat('d-m-Y', $form->tanggal)->format('Y-m-d');
                                } catch (\Exception $e) {
                                    try {
                                        $formatted_tanggal = \Carbon\Carbon::parse($form->tanggal)->format('Y-m-d');
                                    } catch (\Exception $ex) {
                                        $formatted_tanggal = $form->tanggal;
                                    }
                                }
                            }
                        @endphp
                        <input type="date" name="tanggal" value="{{ $formatted_tanggal }}" class="form-input">
                    </td>
                </tr>
                <tr>
                    <td><strong>Jabatan Pemohon</strong></td>
                    <td><input type="text" name="jabatan" value="{{ old('jabatan', $form->jabatan) }}" class="form-input" placeholder="Isi Jabatan"></td>
                </tr>
            </table>

            <div class="section-title">1. DESKRIPSI UMUM</div>
            <textarea name="deskripsi_umum" class="form-input" placeholder="Isi Deskripsi Umum">{{ old('deskripsi_umum', $form->deskripsi_umum) }}</textarea>

            <div class="section-title">2. LATAR BELAKANG</div>
            <textarea name="latar_belakang" class="form-input" placeholder="Isi Latar Belakang">{{ old('latar_belakang', $form->latar_belakang) }}</textarea>

            <div class="section-title">3. TUJUAN</div>
            <textarea name="tujuan" class="form-input" placeholder="Isi Tujuan">{{ old('tujuan', $form->tujuan) }}</textarea>

            <div class="section-title">4. TARGET WAKTU</div>
            <input type="text" name="target_waktu" value="{{ old('target_waktu', $form->target_waktu) }}" class="form-input" placeholder="Isi Target Waktu">

            <div class="section-title">5. PIHAK TERKAIT (INTERNAL)</div>
            <textarea name="pihak_terkait_internal" class="form-input" placeholder="Isi Pihak Terkait Internal">{{ old('pihak_terkait_internal', $form->pihak_terkait_internal) }}</textarea>

            <div class="section-title">6. KATEGORI LAYANAN</div>
            <div style="padding: 10px; border: 1px solid black; border-top: none;">
                @php
                    $kategori_list = [
                        'Layanan Profesional TI', 'Layanan Teknis', 'Layanan Analisa Produk Aplikasi/Sistem',
                        'Layanan Co Location', 'Layanan Dukungan Teknis', 'Layanan Hosting Email, SAP',
                        'Layanan Integrasi Data', 'Layanan Pembangunan dan Pengembangan Sistem/Aplikasi',
                        'Layanan Lainnya', 'Layanan Pengembangan Jaringan', 'Layanan Lisensi Perangkat Lunak',
                        'Layanan Perangkat Kerja', 'Layanan Pengembangan Aplikasi (Baru)',
                        'Layanan Uji Kelayakan Sistem/Aplikasi'
                    ];
                    $selected_kategori = is_array(old('kategori_layanan', $form->kategori_layanan)) 
                        ? old('kategori_layanan', $form->kategori_layanan) 
                        : (json_decode($form->kategori_layanan ?? '[]', true) ?? []);
                @endphp
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 5px;">
                    @foreach($kategori_list as $kategori)
                        <label style="display: flex; align-items: center; gap: 5px;">
                            <input type="checkbox" name="kategori_layanan[]" value="{{ $kategori }}" 
                                {{ in_array($kategori, $selected_kategori) ? 'checked' : '' }}>
                            {{ $kategori }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="section-title">7. LAYANAN YANG DIBUTUHKAN</div>
            <textarea name="layanan_yang_dibutuhkan" class="form-input" placeholder="Isi Rincian Layanan">{{ old('layanan_yang_dibutuhkan', $form->layanan_yang_dibutuhkan) }}</textarea>

            <div class="section-title">8. KLASIFIKASI & PERSETUJUAN</div>
            <table class="main-table" style="border-top: none; margin-top: 0;">
                <tr>
                    <td style="width: 30%;"><strong>Klasifikasi Permintaan</strong></td>
                    <td>
                        <label><input type="radio" name="klasifikasi_permintaan" value="High" {{ old('klasifikasi_permintaan', $form->klasifikasi_permintaan) == 'High' ? 'checked' : '' }}> High</label>
                        <label style="margin-left: 10px;"><input type="radio" name="klasifikasi_permintaan" value="Medium" {{ old('klasifikasi_permintaan', $form->klasifikasi_permintaan) == 'Medium' ? 'checked' : '' }}> Medium</label>
                        <label style="margin-left: 10px;"><input type="radio" name="klasifikasi_permintaan" value="Low" {{ old('klasifikasi_permintaan', $form->klasifikasi_permintaan) == 'Low' ? 'checked' : '' }}> Low</label>
                    </td>
                </tr>
                <tr>
                    <td><strong>Catatan Persetujuan</strong></td>
                    <td>
                        <label><input type="radio" name="catatan_persetujuan" value="Disetujui" {{ old('catatan_persetujuan', $form->catatan_persetujuan) == 'Disetujui' ? 'checked' : '' }}> Disetujui</label>
                        <label style="margin-left: 10px;"><input type="radio" name="catatan_persetujuan" value="Ditolak" {{ old('catatan_persetujuan', $form->catatan_persetujuan) == 'Ditolak' ? 'checked' : '' }}> Ditolak</label>
                        <label style="margin-left: 10px;"><input type="radio" name="catatan_persetujuan" value="Disetujui dengan Kondisi" {{ old('catatan_persetujuan', $form->catatan_persetujuan) == 'Disetujui dengan Kondisi' ? 'checked' : '' }}> Disetujui dgn Kondisi</label>
                    </td>
                </tr>
                <tr>
                    <td><strong>Jelaskan (Kondisi/Catatan)</strong></td>
                    <td><textarea name="catatan_kondisi" class="form-input">{{ old('catatan_kondisi', $form->catatan_kondisi) }}</textarea></td>
                </tr>
                <tr>
                    <td><strong>Distribusi Salinan</strong></td>
                    <td><input type="text" name="distribusi_salinan" value="{{ old('distribusi_salinan', $form->distribusi_salinan) }}" class="form-input"></td>
                </tr>
            </table>

            <div class="signature-grid">
                <div class="signature-box">
                    <div>Pemohon<br><input type="text" name="pemohon_jabatan" value="{{ old('pemohon_jabatan', $form->pemohon_jabatan) }}" class="form-input" placeholder="Jabatan"></div>
                    <div>
                        <input type="text" name="pemohon_nama" value="{{ old('pemohon_nama', $form->pemohon_nama) }}" class="form-input" placeholder="Nama Lengkap">
                        <input type="text" name="pemohon_nipp" value="{{ old('pemohon_nipp', $form->pemohon_nipp) }}" class="form-input" placeholder="NIPP">
                    </div>
                </div>
                <div class="signature-box">
                    <div>Penerima Layanan<br><input type="text" name="penerima_jabatan" value="{{ old('penerima_jabatan', $form->penerima_jabatan) }}" class="form-input" placeholder="Jabatan"></div>
                    <div>
                        <input type="text" name="penerima_nama" value="{{ old('penerima_nama', $form->penerima_nama) }}" class="form-input" placeholder="Nama Lengkap">
                        <input type="text" name="penerima_nipp" value="{{ old('penerima_nipp', $form->penerima_nipp) }}" class="form-input" placeholder="NIPP">
                    </div>
                </div>
                <div class="signature-box">
                    <div>Pimpinan Unit SI<br><input type="text" name="pimpinan_jabatan" value="{{ old('pimpinan_jabatan', $form->pimpinan_jabatan) }}" class="form-input" placeholder="Jabatan"></div>
                    <div>
                        <input type="text" name="pimpinan_nama" value="{{ old('pimpinan_nama', $form->pimpinan_nama) }}" class="form-input" placeholder="Nama Lengkap">
                        <input type="text" name="pimpinan_nipp" value="{{ old('pimpinan_nipp', $form->pimpinan_nipp) }}" class="form-input" placeholder="NIPP">
                    </div>
                </div>
                <div class="signature-box">
                    <div>VP IT/CDD<br><input type="text" name="vp_jabatan" value="{{ old('vp_jabatan', $form->vp_jabatan) }}" class="form-input" placeholder="Jabatan"></div>
                    <div>
                        <input type="text" name="vp_nama" value="{{ old('vp_nama', $form->vp_nama) }}" class="form-input" placeholder="Nama Lengkap">
                        <input type="text" name="vp_nipp" value="{{ old('vp_nipp', $form->vp_nipp) }}" class="form-input" placeholder="NIPP">
                    </div>
                </div>
            </div>

            <div style="text-align: right; display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <a href="{{ route('form-it-business-request.index') }}" class="btn-kembali">Batal</a>
                <button type="submit" class="btn-submit">{{ isset($method) && $method === 'PUT' ? 'Perbarui' : 'Simpan' }}</button>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection
