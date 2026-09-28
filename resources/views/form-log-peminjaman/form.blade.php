@extends('layouts.app')

@section('content')
<style>
    .a4-wrapper { display: flex; justify-content: center; padding: 20px; }
    .a4-container { width: 297mm; background: white; padding: 15mm 20mm; box-sizing: border-box; box-shadow: 0 4px 15px rgba(0,0,0,0.1); font-family: Arial, sans-serif; font-size: 11px; color: #000; position: relative; margin-bottom: 20px; }
    .kop-table { width: 100%; border-collapse: collapse; font-size: 11px; }
    .kop-table td { border: 1px solid #000; padding: 5px 8px; vertical-align: middle; }
    .form-input-line { width: 100%; border: none; border-bottom: 1px solid black; outline: none; background: transparent; font-family: inherit; font-size: inherit; padding: 2px 4px; box-sizing: border-box; }
    .form-input-line:focus { background-color: #f0f8ff; border-bottom: 1px solid #00a4e4; }

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

        <div style="width: 297mm; margin-bottom: 20px;">
            <a href="{{ route('form-log-peminjaman.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors mb-6">
                Kembali ke Daftar Formulir
            </a>
        </div>

        <div style="zoom: 1.1;">
            <div class="a4-container">
                <table class="kop-table">
                    <tr>
                        <td rowspan="2" style="width: 15%; text-align: center; vertical-align: middle;">
                            <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI" style="width: 100%; max-width: 90px; height: auto; display: inline-block;">
                        </td>
                        <td rowspan="2" style="width: 45%; text-align: center; font-weight: bold; font-size: 12px;">
                            PT KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI
                        </td>
                        <td style="width: 10%;">Nomor</td>
                        <td style="width: 30%;">{{ $template->no_dokumen ?? 'FR.SM/TI/004.004/10-2020' }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>{{ $template->tanggal_dokumen ?? '12 Oktober 2020' }}</td>
                    </tr>
                    <tr>
                        <td rowspan="2" style="text-align: center; padding: 10px;">
                            <div style="border: 2px solid #eadc04; color: #eadc04; font-weight: bold; font-size: 14px; padding: 6px 12px; display: inline-block;">TERBATAS</div>
                        </td>
                        <td rowspan="2" style="text-align: center; font-weight: bold; font-size: 12px;">
                            FORMULIR<br>LOG PEMINJAMAN INFORMASI / DOKUMEN
                        </td>
                        <td>Versi</td>
                        <td>{{ $template->versi_dokumen ?? '002-2020' }}</td>
                    </tr>
                    <tr>
                        <td>Halaman</td>
                        <td>1 dari 1</td>
                    </tr>
                </table>

                <table style="border-collapse: collapse; width: 350px; font-size: 11px; margin-top: 20px; margin-bottom: 20px;">
                    <tr>
                        <td style="border: 1px solid black; padding: 4px 6px; width: 100px;">No. Ref</td>
                        <td style="border: 1px solid black; padding: 4px 6px; width: 10px; border-right: none;">:</td>
                        <td style="border: 1px solid black; padding: 4px 6px; border-left: none;">
                            <input type="text" name="no_ref" value="{{ old('no_ref', $form->no_ref) }}" class="form-input-line" required>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 4px 6px;">Tanggal</td>
                        <td style="border: 1px solid black; padding: 4px 6px; border-right: none;">:</td>
                        <td style="border: 1px solid black; padding: 4px 6px; border-left: none;">
                            <input type="text" name="tanggal_ref" value="{{ old('tanggal_ref', $form->tanggal_ref) }}" class="form-input-line custom-date-picker" autocomplete="off" required>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 4px 6px;">Business Area</td>
                        <td style="border: 1px solid black; padding: 4px 6px; border-right: none;">:</td>
                        <td style="border: 1px solid black; padding: 4px 6px; border-left: none;">
                            <input type="text" name="business_area" value="{{ old('business_area', $form->business_area) }}" class="form-input-line" required>
                        </td>
                    </tr>
                </table>

                <table class="data-table" id="items-table">
                    <thead>
                        <tr style="background-color: #f1f5f9;">
                            <th style="width: 3%;">No.</th>
                            <th style="width: 15%;">Nama Informasi / Dokumen</th>
                            <th style="width: 12%;">Nama Peminjam</th>
                            <th style="width: 12%;">Unit Kerja / Instansi</th>
                            <th style="width: 8%;">Tanggal Pinjam</th>
                            <th style="width: 10%;">Paraf Peminjam</th>
                            <th style="width: 8%;">Tanggal Kembali</th>
                            <th style="width: 10%;">Paraf Peminjam</th>
                            <th style="width: 10%;">Paraf P. Jawab</th>
                            <th style="width: 12%;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $oldItems = old('items', $items ?? []); $rowCount = max(1, count($oldItems)); @endphp
                        @for ($i = 0; $i < $rowCount; $i++)
                            @php $item = $oldItems[$i] ?? null; @endphp
                            <tr class="item-row">
                                <td>{{ $i + 1 }}</td>
                                <td><input type="text" name="items[{{$i}}][nama_informasi]" value="{{ $item['nama_informasi'] ?? '' }}" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
                                <td><input type="text" name="items[{{$i}}][nama_peminjam]" value="{{ $item['nama_peminjam'] ?? '' }}" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
                                <td><input type="text" name="items[{{$i}}][unit_kerja]" value="{{ $item['unit_kerja'] ?? '' }}" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
                                <td><input type="text" name="items[{{$i}}][tanggal_pinjam]" value="{{ $item['tanggal_pinjam'] ?? '' }}" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
                                <td><input type="text" name="items[{{$i}}][paraf_peminjam_pinjam]" value="{{ $item['paraf_peminjam_pinjam'] ?? '' }}" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
                                <td><input type="text" name="items[{{$i}}][tanggal_kembali]" value="{{ $item['tanggal_kembali'] ?? '' }}" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
                                <td><input type="text" name="items[{{$i}}][paraf_peminjam_kembali]" value="{{ $item['paraf_peminjam_kembali'] ?? '' }}" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
                                <td><input type="text" name="items[{{$i}}][paraf_p_jawab]" value="{{ $item['paraf_p_jawab'] ?? '' }}" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
                                <td>
                                    <input type="text" name="items[{{$i}}][keterangan]" value="{{ $item['keterangan'] ?? '' }}" class="form-input-line" style="text-align: center; border-bottom: none;">
                                    @if($i > 0)
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

                <div class="no-print" style="margin-top: 40px; text-align: center; border-top: 1px solid #eaeaea; padding-top: 20px;">
                    <a href="{{ route('form-log-peminjaman.index') }}" class="btn-cancel">Batal</a>
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

        <h3 class="text-[17px] font-bold text-slate-800 mb-2">Import Isi Tabel Peminjaman</h3>
        <p class="text-[13px] text-slate-500 mb-4 leading-relaxed">Silakan upload file Excel berformat .xlsx yang berisi data tabel log peminjaman.</p>

        <a href="{{ route('form-log-peminjaman.template') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 text-[13px] font-semibold mb-6 transition-colors">
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
        const fileInput = document.getElementById('excelFileInput');
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                let fileName = e.target.files[0] ? e.target.files[0].name : 'Tidak ada file yang dipilih';
                document.getElementById('fileNameDisplay').innerText = fileName;
            });
        }
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
                    if(inputs[6] && rowData[6] !== undefined) inputs[6].value = rowData[6];
                    if(inputs[7] && rowData[7] !== undefined) inputs[7].value = rowData[7];
                    if(inputs[8] && rowData[8] !== undefined) inputs[8].value = rowData[8];

                    dataDitambahkan++;
                }

                while(rowIndex < 1) {
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
            <td><input type="text" name="items[${rowIndex}][nama_informasi]" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
            <td><input type="text" name="items[${rowIndex}][nama_peminjam]" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
            <td><input type="text" name="items[${rowIndex}][unit_kerja]" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
            <td><input type="text" name="items[${rowIndex}][tanggal_pinjam]" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
            <td><input type="text" name="items[${rowIndex}][paraf_peminjam_pinjam]" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
            <td><input type="text" name="items[${rowIndex}][tanggal_kembali]" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
            <td><input type="text" name="items[${rowIndex}][paraf_peminjam_kembali]" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
            <td><input type="text" name="items[${rowIndex}][paraf_p_jawab]" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
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