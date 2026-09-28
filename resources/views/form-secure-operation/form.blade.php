@extends('layouts.app')

@section('content')
<style>
    /* Base Styling meniru cetakan A4 */
    .a4-wrapper { display: flex; justify-content: center; padding: 20px; }
    .a4-container {
        width: 210mm; background: white; padding: 25mm 20mm;
        box-sizing: border-box; box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif; font-size: 11px; color: #000;
        position: relative; min-height: 297mm;
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
    .ref-table td:first-child { border-right: none; }
    .ref-table td:last-child { border-left: none; }
    .ref-label { width: 40%; }

    /* Inputs */
    .form-input-inline {
        border: none; border-bottom: 1px solid #000; background: transparent;
        font-family: inherit; font-size: inherit; padding: 2px 4px; width: 100%; box-sizing: border-box;
    }
    .form-input-inline:focus { outline: none; border-bottom: 1px dashed #00a4e4; }
    
    /* Tabel Box Deskripsi & Checklist */
    .box-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 11px; }
    .box-table th, .box-table td { border: 1px solid #000; padding: 6px; vertical-align: top; }
    .box-header { background-color: #f2f2f2; font-weight: bold; text-align: center; }
    
    /* Area Baris Data Deskripsi */
    .desc-row { display: flex; margin-bottom: 4px; }
    .desc-label { width: 120px; }
    .desc-colon { width: 10px; }
    .desc-input { flex: 1; }

    /* Buttons */
    .btn-submit {
        background-color: #16a34a; color: white; padding: 6px 16px; height: 36px;
        border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 13px;
    }
    .btn-cancel {
        background-color: #ef4444; color: white; padding: 6px 16px; height: 36px;
        border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 13px; margin-right: 10px; text-decoration: none;
    }
</style>

<div class="a4-wrapper" style="flex-direction: column; align-items: center;">
    
    <!-- Bagian Error Notifikasi -->
    <div style="width: 273mm; margin-bottom: 20px;">
        @if ($errors->any())
            <div class="relative flex items-center p-4 mb-6 border border-red-200 rounded-xl bg-red-50" role="alert">
                <div class="ml-4">
                    <h3 class="text-sm font-bold text-red-800">Gagal Menyimpan!</h3>
                    <ul class="text-sm text-red-600 mt-1 list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        <a href="{{ route('form-secure-operation.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors mb-6">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Formulir
        </a>
    </div>

    <!-- Kertas A4 -->
    <div style="zoom: 1.3;">
        <div class="a4-container">
            <form action="{{ $action }}" method="POST">
                @csrf
                @if(isset($method) && $method === 'PUT')
                    @method('PUT')
                @endif
                
                <!-- BAGIAN INI YANG MASIH DATA DUMMY -->
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
                <table style="border-collapse: collapse; width: 350px; margin-top: 15px; margin-bottom: 20px;">
                    <tr>
                        <td style="border: 1px solid black; padding: 6px 8px; width: 110px;">No. Ref</td>
                        <td style="border: 1px solid black; padding: 6px 4px; width: 10px; border-right: none; text-align: center;">:</td>
                        <td style="border: 1px solid black; padding: 6px 8px; border-left: none;">
                            <input type="text" name="no_ref" value="{{ old('no_ref', $form->no_ref ?? '') }}" style="width: 100%; box-sizing: border-box; border: none; border-bottom: 1px solid #000; outline: none; background: transparent; padding-bottom: 2px;" placeholder="_ _ / _ _" autocomplete="off">
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 6px 8px;">Tanggal</td>
                        <td style="border: 1px solid black; padding: 6px 4px; border-right: none; text-align: center;">:</td>
                        <td style="border: 1px solid black; padding: 6px 8px; border-left: none;">
                            <input type="text" name="tanggal_ref" value="{{ old('tanggal_ref', isset($form->tanggal_ref) ? date('Y-m-d', strtotime($form->tanggal_ref)) : '') }}" class="custom-date-picker" style="width: 100%; box-sizing: border-box; border: none; border-bottom: 1px solid #000; outline: none; background: transparent; padding-bottom: 2px; cursor: pointer;" placeholder="Pilih Tanggal" autocomplete="off">
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 6px 8px;">Business Area</td>
                        <td style="border: 1px solid black; padding: 6px 4px; border-right: none; text-align: center;">:</td>
                        <td style="border: 1px solid black; padding: 6px 8px; border-left: none;">
                            <input type="text" name="business_area" value="{{ old('business_area', $form->business_area ?? '') }}" style="width: 100%; box-sizing: border-box; border: none; border-bottom: 1px solid #000; outline: none; background: transparent; padding-bottom: 2px;" placeholder="____" autocomplete="off">
                        </td>
                    </tr>
                </table>

                <!-- Deskripsi Aplikasi -->
                <table class="box-table" style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <th class="box-header" style="text-align: center; padding: 15px; border-bottom: 1px solid black;">
                            DESKRIPSI<br>
                            <input type="text" name="nama_aplikasi" value="{{ old('nama_aplikasi', $form->nama_aplikasi ?? '') }}" style="border:none; border-bottom:1px solid #000; background:transparent; font-weight:bold; text-align:center; width:250px; outline:none; margin-top: 5px;" placeholder="Nama Aplikasi" required>
                        </th>
                    </tr>
                    <tr>
                        <td style="padding: 15px 20px;">
                            <!-- Baris Tanggal -->
                            <div class="desc-row" style="display: flex; align-items: flex-start; margin-bottom: 12px;">
                                <div class="desc-label" style="width: 130px; margin-top: 4px;">Tanggal Checklist</div>
                                <div class="desc-colon" style="width: 15px; margin-top: 4px;">:</div>
                                <div class="desc-val" style="flex: 1;">
                                    <input type="text" name="tanggal_checklist" value="{{ old('tanggal_checklist', isset($form->tanggal_checklist) ? date('Y-m-d', strtotime($form->tanggal_checklist)) : '') }}" class="custom-date-picker" style="width: 100%; box-sizing: border-box; border: none; border-bottom: 1px solid #000; outline: none; background: transparent; padding-left: 10px; padding-bottom: 5px; cursor: pointer;" placeholder="Tanggal Melakukan Checklist" autocomplete="off" required>
                                </div>
                            </div>

                            <!-- Baris Deskripsi -->
                            <div class="desc-row" style="display: flex; align-items: flex-start; margin-bottom: 25px;">
                                <div class="desc-label" style="width: 130px; margin-top: 4px;">Deskripsi</div>
                                <div class="desc-colon" style="width: 15px; margin-top: 4px;">:</div>
                                <div class="desc-input" style="flex: 1;">
                                    <input type="text" name="deskripsi" value="{{ old('deskripsi', $form->deskripsi ?? '') }}" style="width: 100%; box-sizing: border-box; border: none; border-bottom: 1px solid #000; outline: none; background: transparent; padding-left: 10px; padding-bottom: 5px;" placeholder="Penjelasan Aplikasi" required>
                                </div>
                            </div>
                            
                            <!-- Baris Versi Aplikasi -->
                            <div class="desc-row" style="display: flex; align-items: flex-start; margin-bottom: 12px;">
                                <div class="desc-label" style="width: 130px; margin-top: 4px;">Versi Aplikasi</div>
                                <div class="desc-colon" style="width: 15px; margin-top: 4px;">:</div>
                                <div class="desc-input" style="flex: 1;">
                                    <input type="text" name="versi_aplikasi" value="{{ old('versi_aplikasi', $form->versi_aplikasi ?? '') }}" style="width: 100%; box-sizing: border-box; border: none; border-bottom: 1px solid #000; outline: none; background: transparent; padding-left: 10px; padding-bottom: 5px;" placeholder="Versi Aplikasi" required>
                                </div>
                            </div>

                            <!-- Baris Modul -->
                            <div class="desc-row" style="display: flex; align-items: flex-start; margin-bottom: 12px;">
                                <div class="desc-label" style="width: 130px; margin-top: 4px;">Modul</div>
                                <div class="desc-colon" style="width: 15px; margin-top: 4px;">:</div>
                                <div class="desc-input" style="flex: 1;">
                                    <input type="text" name="modul" value="{{ old('modul', $form->modul ?? '') }}" style="width: 100%; box-sizing: border-box; border: none; border-bottom: 1px solid #000; outline: none; background: transparent; padding-left: 10px; padding-bottom: 5px;" placeholder="Nama Modul pada Aplikasi" required>
                                </div>
                            </div>

                            <!-- Baris Fungsi -->
                            <div class="desc-row" style="display: flex; align-items: flex-start; margin-bottom: 12px;">
                                <div class="desc-label" style="width: 130px; margin-top: 4px;">Fungsi</div>
                                <div class="desc-colon" style="width: 15px; margin-top: 4px;">:</div>
                                <div class="desc-input" style="flex: 1;">
                                    <textarea name="fungsi" style="width: 100%; min-height: 100px; resize: vertical; box-sizing: border-box; border: none; border-bottom: 1px solid #000; outline: none; background: transparent; padding-left: 10px; padding-bottom: 5px; font-family: inherit; font-size: inherit; line-height: 1.5;" placeholder="Fungsi pada Aplikasi&#10;a. &#10;b. &#10;c. &#10;dll." required>{{ old('fungsi', $form->fungsi ?? '') }}</textarea>
                                </div>
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
                        <td style="width: 20%;">Check</td>
                    </tr>
                    <!-- Baris 1 -->
                    <tr>
                        <td style="text-align: center;">1</td>
                        <td>Incident dengan kategori High dilaporkan ke CDD IT</td>
                        <td>
                            <label><input type="radio" name="incident_high_dilaporkan" value="Ya" {{ old('incident_high_dilaporkan', $form->incident_high_dilaporkan ?? '') == 'Ya' ? 'checked' : '' }} required> Ya</label> &nbsp;&nbsp;
                            <label><input type="radio" name="incident_high_dilaporkan" value="Tidak" {{ old('incident_high_dilaporkan', $form->incident_high_dilaporkan ?? '') == 'Tidak' ? 'checked' : '' }} required> Tidak</label>
                        </td>
                    </tr>
                    <!-- Baris 2 -->
                    <tr>
                        <td style="text-align: center;">2</td>
                        <td>Incident sudah dimasukkan ke dalam sistem Trouble Ticket dan ditindak lanjuti</td>
                        <td>
                            <label><input type="radio" name="incident_masuk_tiket" value="Ya" {{ old('incident_masuk_tiket', $form->incident_masuk_tiket ?? '') == 'Ya' ? 'checked' : '' }} required> Ya</label> &nbsp;&nbsp;
                            <label><input type="radio" name="incident_masuk_tiket" value="Tidak" {{ old('incident_masuk_tiket', $form->incident_masuk_tiket ?? '') == 'Tidak' ? 'checked' : '' }} required> Tidak</label>
                        </td>
                    </tr>
                    <!-- Baris 3 -->
                    <tr>
                        <td style="text-align: center;">3</td>
                        <td>Incident tiket yang ada sudah ditindak lanjuti dan sudah di-close</td>
                        <td>
                            <label><input type="radio" name="incident_tiket_closed" value="Ya" {{ old('incident_tiket_closed', $form->incident_tiket_closed ?? '') == 'Ya' ? 'checked' : '' }} required> Ya</label> &nbsp;&nbsp;
                            <label><input type="radio" name="incident_tiket_closed" value="Tidak" {{ old('incident_tiket_closed', $form->incident_tiket_closed ?? '') == 'Tidak' ? 'checked' : '' }} required> Tidak</label>
                        </td>
                    </tr>
                    <!-- Baris 4 -->
                    <tr>
                        <td style="text-align: center;">4</td>
                        <td>Vulnerability Assessment (VA) dilakukan untuk incident yang sudah di-close<br><span style="font-size: 10px;">Bila Ya, ada dokumen VA result</span></td>
                        <td>
                            <label><input type="radio" name="va_dilakukan" value="Ya" {{ old('va_dilakukan', $form->va_dilakukan ?? '') == 'Ya' ? 'checked' : '' }} required> Ya</label> &nbsp;&nbsp;
                            <label><input type="radio" name="va_dilakukan" value="Tidak" {{ old('va_dilakukan', $form->va_dilakukan ?? '') == 'Tidak' ? 'checked' : '' }} required> Tidak</label>
                        </td>
                    </tr>
                    <!-- Baris 5 -->
                    <tr>
                        <td style="text-align: center;">5</td>
                        <td>Untuk sistem yang mengalami incident dilakukan penjadwalan untuk masuk dalam regular Penetration Test berikutnya</td>
                        <td>
                            <label><input type="radio" name="jadwal_pentest" value="Ya" {{ old('jadwal_pentest', $form->jadwal_pentest ?? '') == 'Ya' ? 'checked' : '' }} required> Ya</label> &nbsp;&nbsp;
                            <label><input type="radio" name="jadwal_pentest" value="Tidak" {{ old('jadwal_pentest', $form->jadwal_pentest ?? '') == 'Tidak' ? 'checked' : '' }} required> Tidak</label>
                        </td>
                    </tr>
                </table>

                <!-- Input Tempat & Tanggal Tanda Tangan -->
                <div style="text-align: right; font-size: 11px; margin-top: 20px; margin-bottom: 30px;">
                    <input type="text" name="tempat_ttd" value="{{ old('tempat_ttd', $form->tempat_ttd) }}" class="form-input-line" style="width: 120px; text-align: right; border-bottom: 1px dashed black;" placeholder="Tempat">,
                    <span style="margin: 0 8px;">,</span>
                    <input type="text" name="tanggal_ttd" value="{{ old('tanggal_ttd', $form->tanggal_ttd) }}" class="custom-date-picker" style="width: 130px; text-align: center; border: none; border-bottom: 1px dashed black; font-family: inherit; font-size: inherit; outline: none;" placeholder="Tanggal" autocomplete="off" required>
                </div>

                <!-- Data List Suggestions -->
                <datalist id="data_penandatangan">
                    @foreach($masterSigners as $signer)
                        <option value="{{ $signer->nama }}" data-nipp="{{ $signer->nipp }}" data-jabatan="{{ $signer->jabatan }}"></option>
                    @endforeach
                </datalist>

                <!-- Tabel Kolom Tanda Tangan -->
    <table style="width: 100%; border-collapse: collapse; border: 1px solid #000;">
        <tr>
            <td style="width: 50%; border: 1px solid #000; text-align: center; padding: 8px;">Mengetahui,</td>
            <td style="width: 50%; border: 1px solid #000; text-align: center; padding: 8px;">Pelaksana Checklist,</td>
        </tr>
        <tr>
            <!-- Kolom Mengetahui -->
            <td style="border: 1px solid #000; text-align: center; vertical-align: top; padding: 10px;">
                <!-- Input Jabatan persis di bawah garis -->
                <input type="text" name="mengetahui_jabatan" id="mengetahui_jabatan" value="{{ old('mengetahui_jabatan', $form->mengetahui->jabatan ?? '') }}" style="width: 100%; text-align: center; border: none; outline: none; font-size: 13px; background: transparent; font-family: inherit;" placeholder="Jabatan">
                
                <!-- Ruang kosong buatan untuk Tanda Tangan -->
                <div style="height: 70px;"></div> 
                
                <!-- Input Nama & NIPP -->
                <input type="text" name="mengetahui_nama" id="mengetahui_nama" list="data_penandatangan" oninput="autoFillSigner('mengetahui')" value="{{ old('mengetahui_nama', $form->mengetahui->nama ?? '') }}" style="width: 80%; text-align: center; font-weight: bold; border: none; border-bottom: 1px solid #000; outline: none; background: transparent; margin-bottom: 5px; font-family: inherit;" placeholder="Pilih / Ketik Nama..." required autocomplete="off">
                <div style="display: flex; align-items: center; justify-content: center; gap: 4px; font-size: 13px;">
                    <span>NIPP.</span>
                    <input type="text" name="mengetahui_nipp" id="mengetahui_nipp" value="{{ old('mengetahui_nipp', $form->mengetahui->nipp ?? '') }}" style="width: 100px; text-align: center; border: none; outline: none; background: transparent; font-family: inherit;" placeholder="........" required>
                </div>
            </td>
            
            <!-- Kolom Pelaksana -->
            <td style="border: 1px solid #000; text-align: center; vertical-align: top; padding: 10px;">
                <!-- Input Jabatan persis di bawah garis -->
                <input type="text" name="pelaksana_jabatan" id="pelaksana_jabatan" value="{{ old('pelaksana_jabatan', $form->pelaksana->jabatan ?? '') }}" style="width: 100%; text-align: center; border: none; outline: none; font-size: 13px; background: transparent; font-family: inherit;" placeholder="Jabatan">
                
                <!-- Ruang kosong buatan untuk Tanda Tangan -->
                <div style="height: 70px;"></div> 
                
                <!-- Input Nama & NIPP -->
                <input type="text" name="pelaksana_nama" id="pelaksana_nama" list="data_penandatangan" oninput="autoFillSigner('pelaksana')" value="{{ old('pelaksana_nama', $form->pelaksana->nama ?? '') }}" style="width: 80%; text-align: center; font-weight: bold; border: none; border-bottom: 1px solid #000; outline: none; background: transparent; margin-bottom: 5px; font-family: inherit;" placeholder="Pilih / Ketik Nama..." required autocomplete="off">
                <div style="display: flex; align-items: center; justify-content: center; gap: 4px; font-size: 13px;">
                    <span>NIPP.</span>
                    <input type="text" name="pelaksana_nipp" id="pelaksana_nipp" value="{{ old('pelaksana_nipp', $form->pelaksana->nipp ?? '') }}" style="width: 100px; text-align: center; border: none; outline: none; background: transparent; font-family: inherit;" placeholder="........" required>
                </div>
            </td>
        </tr>
    </table>

            <!-- Tombol Aksi (Hanya tampil di web, hilang saat print) -->
            <div class="no-print" style="margin-top: 40px; display: flex; justify-content: center; gap: 12px; border-top: 1px solid #eaeaea; padding-top: 20px;">
                <!-- Tombol Batal -->
                <a href="{{ route('form-secure-operation.index') }}" style="display: flex; align-items: center; justify-content: center; width: 95px; height: 36px; background-color: #f24545; color: white; text-decoration: none; font-weight: bold; font-size: 14px; border-radius: 6px; box-shadow: 0 3px 8px rgba(242, 69, 69, 0.3); transition: 0.2s; font-family: inherit;">
                    Batal
                </a>

                <!-- Tombol Simpan / Perbarui -->
                <button type="submit" style="display: flex; align-items: center; justify-content: center; width: 95px; height: 36px; background-color: #1aae4f; color: white; border: none; font-weight: bold; font-size: 14px; border-radius: 6px; box-shadow: 0 3px 8px rgba(26, 174, 79, 0.3); cursor: pointer; transition: 0.2s; font-family: inherit;">
                    {{ $form->exists ? 'Perbarui' : 'Simpan' }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
            <!-- Script Autofill -->
            <script>
                function autoFillSigner(type) {
                    const nameInput = document.getElementById(type + '_nama');
                    const nippInput = document.getElementById(type + '_nipp');
                    const jabatanInput = document.getElementById(type + '_jabatan');
                    const datalist = document.getElementById('data_penandatangan');
                    
                    for (let option of datalist.options) {
                        if (option.value === nameInput.value) {
                            nippInput.value = option.getAttribute('data-nipp');
                            jabatanInput.value = option.getAttribute('data-jabatan'); 
                            return;
                        }
                    }
                }
            </script>
@endsection