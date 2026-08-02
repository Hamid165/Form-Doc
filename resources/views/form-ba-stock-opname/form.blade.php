@extends('layouts.app')

@section('content')
<style>
    .a4-wrapper { display: flex; justify-content: center; padding: 20px; }
    .a4-container { width: 210mm; background: white; padding: 15mm 20mm; box-sizing: border-box; box-shadow: 0 4px 15px rgba(0,0,0,0.1); font-family: Arial, sans-serif; font-size: 11px; color: #000; position: relative; margin-bottom: 20px; }
    .kop-table { width: 100%; border-collapse: collapse; font-size: 11px; }
    .kop-table td { border: 1px solid #000; padding: 5px 8px; vertical-align: middle; }
    .form-input-line { width: 100%; border: none; border-bottom: 1px solid black; outline: none; background: transparent; font-family: inherit; font-size: inherit; padding: 2px 4px; box-sizing: border-box; }
    .form-input-line:focus { background-color: #f0f8ff; border-bottom: 1px solid #00a4e4; }
    .form-input-line::placeholder { color: #9ca3af; font-style: italic; }
    .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 10px; text-align: center; }
    .data-table th, .data-table td { border: 1px solid #000; padding: 5px; position: relative; }
    .btn-submit { background-color: #16a34a; color: white; padding: 6px 16px; height: 36px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 13px; transition: background 0.2s; }
    .btn-cancel { background-color: #ef4444; color: white; padding: 6px 16px; height: 36px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 13px; margin-right: 10px; text-decoration: none; }
    .btn-tambah-baris { display: inline-flex; height: 30px; padding: 4px 12px; background-color: #f59e0b; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 11px; }
    .btn-import-data { display: inline-flex; height: 30px; padding: 4px 12px; background-color: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 11px; margin-right: 8px; }
    .btn-delete-row { position: absolute; right: -32px; top: 50%; transform: translateY(-50%); background-color: #fef2f2; border: none; color: #dc2626; cursor: pointer; padding: 6px; border-radius: 6px; display: flex; align-items: center; justify-content: center; }
</style>

<div class="a4-wrapper" style="flex-direction: column; align-items: center;">
    <form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="mainForm" style="width: 100%; display: flex; flex-direction: column; align-items: center;">
        @csrf
        @if(isset($method) && $method === 'PUT') @method('PUT') @endif

        <datalist id="signer-list">
            @foreach($masterSigners as $ms)
                <option value="{{ $ms->nama }}" data-nipp="{{ $ms->nipp }}">{{ $ms->jabatan }}</option>
            @endforeach
        </datalist>

        <div style="width: 273mm; margin-bottom: 20px;">
            <a href="{{ route('form-ba-stock-opname.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors mb-6">
                Kembali ke Daftar Formulir
            </a>
        </div>

        <div style="zoom: 1.3;">
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
                        <td style="border: 1px solid black; padding: 4px 6px; border-left: none;">
                            <input type="text" name="no_ref" id="input_no_ref" value="{{ old('no_ref', $form->no_ref) }}" class="form-input-line" required>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 4px 6px;">Tanggal</td>
                        <td style="border: 1px solid black; padding: 4px 6px; border-right: none;">:</td>
                        <td style="border: 1px solid black; padding: 4px 6px; border-left: none;">
                            <input type="text" name="tanggal_ref" id="input_tanggal_ref" value="{{ old('tanggal_ref', $form->tanggal_ref) }}" class="form-input-line custom-date-picker" autocomplete="off" required>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 4px 6px;">Business Area</td>
                        <td style="border: 1px solid black; padding: 4px 6px; border-right: none;">:</td>
                        <td style="border: 1px solid black; padding: 4px 6px; border-left: none;">
                            <input type="text" name="business_area" id="input_business_area" value="{{ old('business_area', $form->business_area) }}" class="form-input-line" required>
                        </td>
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
                                <td><input type="text" name="tanggal_stock_opname" value="{{ old('tanggal_stock_opname', $form->tanggal_stock_opname) }}" class="form-input-line custom-date-picker" autocomplete="off" required></td>
                            </tr>
                            <tr>
                                <td>Unit Kerja</td>
                                <td>:</td>
                                <td><input type="text" name="unit_kerja" value="{{ old('unit_kerja', $form->unit_kerja) }}" class="form-input-line" required></td>
                            </tr>
                            <tr>
                                <td>Tempat Kedudukan</td>
                                <td>:</td>
                                <td><input type="text" name="tempat_kedudukan" value="{{ old('tempat_kedudukan', $form->tempat_kedudukan) }}" class="form-input-line" placeholder="Kantor Pusat / DAOP ....... / DIVRE ....... / Sub DIVRE ....... / Balai Yasa ......." required></td>
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
                            <textarea name="analisa" style="width: 100%; min-height: 80px; border: none; outline: none; font-family: inherit; font-size: inherit; resize: vertical;" required>{{ old('analisa', $form->analisa) }}</textarea>
                            <div style="margin-top: 10px;">Detail Data Aset TI dituangkan pada lampiran yang menjadi bagian tidak terpisahkan dari Berita Acara Stock Opname Aset Teknologi Informasi ini.</div>
                        </div>
                        <div style="padding: 10px 15px;">
                            <div style="text-decoration: underline; font-style: italic; margin-bottom: 2px;">Tindak Lanjut:</div>
                            <div style="color: red; margin-bottom: 10px;">(Tindak lanjut yang akan dilakukan untuk memperbaiki ketidaksesuaian dari hasil stock opname data Aset TI)</div>
                            <textarea name="tindak_lanjut" style="width: 100%; min-height: 80px; border: none; outline: none; font-family: inherit; font-size: inherit; resize: vertical;" required>{{ old('tindak_lanjut', $form->tindak_lanjut) }}</textarea>
                        </div>
                    </div>
                </div>

                <div style="font-size: 11px; margin-top: 20px;">
                    Demikian Berita Acara ini dibuat dengan sebenarnya untuk dapat digunakan sebagaimana mestinya.
                </div>

                <div style="text-align: right; font-size: 11px; margin-top: 20px; margin-bottom: 30px;">
                    <input type="text" name="tempat_ttd" value="{{ old('tempat_ttd', $form->tempat_ttd) }}" class="form-input-line" style="width: 120px; text-align: right; border-bottom: 1px dashed black;" placeholder="Tempat">,
                    <input type="text" name="tanggal_ttd" value="{{ old('tanggal_ttd', $form->tanggal_ttd) }}" class="custom-date-picker" style="width: 130px; text-align: center; border: none; border-bottom: 1px dashed black; font-family: inherit; font-size: inherit; outline: none;" placeholder="Tanggal" autocomplete="off" required>
                </div>

                <table style="width: 100%; font-size: 11px; text-align: center;">
                    <tr>
                        <td style="width: 50%; vertical-align: top;">Pimpinan Unit Kerja</td>
                        <td style="width: 50%; vertical-align: top;">Pimpinan IT Kantor Pusat/Daerah<br>(Pengelola Aset TI)</td>
                    </tr>
                    <tr>
                        <td style="height: 80px; vertical-align: bottom;">
                        <div style="margin-bottom: 3px;">
                            ( <input type="text" name="pimpinan_unit_kerja" id="pimpinan_unit_kerja" list="signer-list" value="{{ old('pimpinan_unit_kerja', $form->pimpinan_unit_kerja) }}" class="form-input-line" style="width: 200px; text-align: center;" required> )
                        </div>
                        <div>
                            NIPP. <input type="text" name="nipp_pimpinan_unit_kerja" id="nipp_pimpinan_unit_kerja" value="{{ old('nipp_pimpinan_unit_kerja', $form->nipp_pimpinan_unit_kerja) }}" class="form-input-line" style="width: 160px; text-align: center;" required>
                        </div>
                        </td>
                        <td style="height: 80px; vertical-align: bottom;">
                            <div style="margin-bottom: 3px;">
                                ( <input type="text" name="pimpinan_it" id="pimpinan_it" list="signer-list" value="{{ old('pimpinan_it', $form->pimpinan_it) }}" class="form-input-line" style="width: 200px; text-align: center;" required> )
                            </div>
                            <div>
                                NIPP. <input type="text" name="nipp_pimpinan_it" id="nipp_pimpinan_it" value="{{ old('nipp_pimpinan_it', $form->nipp_pimpinan_it ?? '') }}" class="form-input-line" style="width: 160px; text-align: center;" required>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

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
                    <tr><td>Halaman</td><td>2 dari 2</td></tr>
                </table>

                <table style="border-collapse: collapse; width: 350px; font-size: 11px; margin-top: 15px;">
                    <tr>
                        <td style="border: 1px solid black; padding: 4px 6px; width: 100px;">No. Ref</td>
                        <td style="border: 1px solid black; padding: 4px 6px; width: 10px; border-right: none;">:</td>
                        <td style="border: 1px solid black; padding: 4px 6px; border-left: none;"><span id="display_no_ref"></span></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 4px 6px;">Tanggal</td>
                        <td style="border: 1px solid black; padding: 4px 6px; border-right: none;">:</td>
                        <td style="border: 1px solid black; padding: 4px 6px; border-left: none;"><span id="display_tanggal_ref"></span></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 4px 6px;">Business Area</td>
                        <td style="border: 1px solid black; padding: 4px 6px; border-right: none;">:</td>
                        <td style="border: 1px solid black; padding: 4px 6px; border-left: none;"><span id="display_business_area"></span></td>
                    </tr>
                </table>

                <div style="text-align: right; font-size: 8px; margin-top: 30px; margin-bottom: 20px;">
                    Lampiran Formulir<br>Stock Opname Data Aset Teknologi Informasi
                </div>

                <div style="text-align: center; font-size: 11px; font-weight: bold; margin-bottom: 15px;">
                    Stock Opname<br>Data Aset Teknologi Informasi
                </div>

                <table class="data-table" id="items-table">
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
                        @php $oldItems = old('items', $items ?? []); $rowCount = max(4, count($oldItems)); @endphp
                        @for ($i = 0; $i < $rowCount; $i++)
                            @php $item = $oldItems[$i] ?? null; @endphp
                            <tr class="item-row">
                                <td>{{ $i + 1 }}</td>
                                <td><input type="text" name="items[{{$i}}][nomor_inventaris_aset]" value="{{ $item['nomor_inventaris_aset'] ?? '' }}" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
                                <td><input type="text" name="items[{{$i}}][serial_number]" value="{{ $item['serial_number'] ?? '' }}" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
                                <td><input type="text" name="items[{{$i}}][jenis_aset_ti]" value="{{ $item['jenis_aset_ti'] ?? '' }}" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
                                <td><input type="text" name="items[{{$i}}][merek]" value="{{ $item['merek'] ?? '' }}" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
                                <td><input type="text" name="items[{{$i}}][sumber_data]" value="{{ $item['sumber_data'] ?? '' }}" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
                                <td>
                                    <input type="text" name="items[{{$i}}][keterangan]" value="{{ $item['keterangan'] ?? '' }}" class="form-input-line" style="text-align: center; border-bottom: none;">
                                    @if($i >= 4)
                                    <button type="button" class="btn-delete-row" onclick="removeRow(this)">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>

                <div style="margin-top: 15px; margin-right: 0; margin-bottom: 20px; text-align: right;" class="no-print">
                    <button type="button" class="btn-import-data" onclick="openImportModal()">Import Data</button>
                    <button type="button" class="btn-tambah-baris" onclick="addRow()">Tambah Baris</button>
                </div>

                <div style="display: flex; justify-content: flex-end; margin-top: 50px;">
                    <table style="width: 250px; border-collapse: collapse; font-size: 11px; text-align: center;">
                        <tr>
                            <td style="border: 1px solid black; padding: 4px;">Petugas IT Stock Opname</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; height: 80px; vertical-align: bottom; padding: 5px;">
                                <div style="margin-bottom: 3px;">
                                    ( <input type="text" name="petugas_it" id="petugas_it" list="signer-list" value="{{ old('petugas_it', $form->petugas_it) }}" class="form-input-line" style="text-align: center; font-weight: bold; width: 200px;" required> )
                                </div>
                                <div style="font-weight: normal;">
                                    NIPP. <input type="text" name="nipp_petugas_it" id="nipp_petugas_it" value="{{ old('nipp_petugas_it', $form->nipp_petugas_it ?? '') }}" class="form-input-line" style="text-align: center; width: 160px;" required>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="clear: both;"></div>

                <div class="no-print" style="margin-top: 40px; text-align: center; border-top: 1px solid #eaeaea; padding-top: 20px;">
                    <a href="{{ route('form-ba-stock-opname.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">{{ $form->exists ? 'Perbarui' : 'Simpan' }}</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="importModal" class="fixed inset-0 bg-slate-900/50 hidden z-[100] items-center justify-center backdrop-blur-sm transition-all duration-300 opacity-0">
    <div class="bg-white rounded-xl w-[400px] p-6 shadow-xl relative transform transition-all scale-95" id="importModalContent">
        <button type="button" onclick="closeImportModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <h3 class="text-[17px] font-bold text-slate-800 mb-2">Import Isi Tabel Aset</h3>
        <p class="text-[13px] text-slate-500 mb-4 leading-relaxed">Silakan upload file Excel berformat .xlsx yang berisi data tabel aset Stock Opname.</p>

        <a href="{{ route('form-ba-stock-opname.template') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 text-[13px] font-semibold mb-6 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Download Template Excel (XLSX)
        </a>

        <div class="mb-6">
            <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-wider">FILE EXCEL <span class="text-red-500">*</span></label>
            <div class="border border-slate-200 rounded-lg p-2 flex items-center gap-3 bg-slate-50/50">
                <label class="cursor-pointer bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-1.5 rounded-md text-[12px] font-semibold transition-colors">
                    Pilih File
                    <input type="file" id="excelFileInput" class="hidden" accept=".xlsx, .xls, .csv">
                </label>
                <span id="fileNameDisplay" class="text-slate-400 text-[13px] truncate w-[200px]">Tidak ada file yang dipilih</span>
            </div>
        </div>

        <div class="flex justify-end gap-2 pt-2 border-t border-slate-100">
            <button type="button" onclick="closeImportModal()" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-lg text-[13px] font-semibold hover:bg-slate-200 transition-colors">Batal</button>
            <button type="button" onclick="processExcelImport()" class="px-5 py-2.5 bg-[#2563eb] text-white rounded-lg text-[13px] font-semibold hover:bg-blue-700 transition-colors">Import Data</button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fields = ['no_ref', 'tanggal_ref', 'business_area'];
        fields.forEach(field => {
            const input = document.getElementById('input_' + field);
            const display = document.getElementById('display_' + field);
            if (input && display) {
                const updateValue = () => { display.innerText = input.value || ''; };
                input.addEventListener('input', updateValue);
                input.addEventListener('change', updateValue);
                setTimeout(updateValue, 100);
            }
        });

        const fileInput = document.getElementById('excelFileInput');
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                let fileName = e.target.files[0] ? e.target.files[0].name : 'Tidak ada file yang dipilih';
                document.getElementById('fileNameDisplay').innerText = fileName;
            });
        }

    function setupAutofill(nameId, nippId) {
        const nameInput = document.getElementById(nameId);
        const nippInput = document.getElementById(nippId);
        if (!nameInput || !nippInput) return;

        nameInput.addEventListener('input', function() {
            const options = document.getElementById('signer-list').options;
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
    });

    function openImportModal() {
        const modal = document.getElementById('importModal');
        const content = document.getElementById('importModalContent');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 10);
    }

    function closeImportModal() {
        const modal = document.getElementById('importModal');
        const content = document.getElementById('importModalContent');
        modal.classList.add('opacity-0');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');

            let fileInput = document.getElementById('excelFileInput');
            if(fileInput) fileInput.value = '';
            let fileNameDisplay = document.getElementById('fileNameDisplay');
            if(fileNameDisplay) fileNameDisplay.innerText = 'Tidak ada file yang dipilih';
        }, 300);
    }

    function processExcelImport() {
        try {
            if (typeof XLSX === 'undefined') {
                alert('Sistem pembaca Excel belum siap! Pastikan koneksi internet kamu aktif untuk memuat library XLSX.');
                return;
            }

            const fileInput = document.getElementById('excelFileInput');
            if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                alert('Silakan pilih file Excel terlebih dahulu!');
                return;
            }

            const file = fileInput.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, {type: 'array'});
                const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                const rows = XLSX.utils.sheet_to_json(firstSheet, {header: 1, defval: ""});

                if (rows.length <= 1) {
                    alert('File Excel kosong atau hanya berisi judul kolom! Silakan isi datanya terlebih dahulu.');
                    return;
                }

                const tbody = document.querySelector('#items-table tbody');
                tbody.innerHTML = '';
                rowIndex = 0;

                let dataDitambahkan = 0;

                for (let i = 1; i < rows.length; i++) {
                    let rowData = rows[i];

                    if (!rowData || rowData.length === 0 || rowData.every(val => val === "")) continue;

                    addRow();

                    let lastRow = tbody.lastElementChild;
                    let inputs = lastRow.querySelectorAll('input');

                    if(inputs[0] && rowData[0] !== undefined) inputs[0].value = rowData[0];
                    if(inputs[1] && rowData[1] !== undefined) inputs[1].value = rowData[1];
                    if(inputs[2] && rowData[2] !== undefined) inputs[2].value = rowData[2];
                    if(inputs[3] && rowData[3] !== undefined) inputs[3].value = rowData[3];
                    if(inputs[4] && rowData[4] !== undefined) inputs[4].value = rowData[4];
                    if(inputs[5] && rowData[5] !== undefined) inputs[5].value = rowData[5];

                    dataDitambahkan++;
                }

                while(rowIndex < 4) {
                    addRow();
                }

                closeImportModal();
                alert('Berhasil! ' + dataDitambahkan + ' baris data dari Excel telah ditambahkan ke tabel.');
            };

            reader.readAsArrayBuffer(file);

        } catch (error) {
            console.error('Terjadi kesalahan import:', error);
            alert('Terjadi kesalahan sistem saat membaca file. Pastikan format file adalah .xlsx');
        }
    }

    let rowIndex = {{ isset($rowCount) ? $rowCount : 0 }};
    function addRow() {
        const tbody = document.querySelector('#items-table tbody');
        const tr = document.createElement('tr');
        tr.className = 'item-row';
        tr.innerHTML = `
            <td>${rowIndex + 1}</td>
            <td><input type="text" name="items[${rowIndex}][nomor_inventaris_aset]" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
            <td><input type="text" name="items[${rowIndex}][serial_number]" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
            <td><input type="text" name="items[${rowIndex}][jenis_aset_ti]" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
            <td><input type="text" name="items[${rowIndex}][merek]" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
            <td><input type="text" name="items[${rowIndex}][sumber_data]" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
            <td>
                <input type="text" name="items[${rowIndex}][keterangan]" class="form-input-line" style="text-align: center; border-bottom: none;">
                <button type="button" class="btn-delete-row" onclick="removeRow(this)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
        rowIndex++;
        updateRowNumbers();
    }

    function removeRow(btn) {
        btn.closest('tr').remove();
        updateRowNumbers();
    }

    function updateRowNumbers() {
        document.querySelectorAll('#items-table tbody tr').forEach((row, index) => {
            row.querySelector('td:first-child').innerText = index + 1;
        });
    }
</script>
@endsection
