<style>
    /* Konfigurasi Ukuran A4 Landscape */
    @page {
        size: A4 landscape;
        margin: 1cm;
    }
    
    @media print {
        body {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            background-color: white !important;
        }
        .a4-landscape-container {
            width: 100% !important;
            min-height: auto !important;
            margin: 0 !important;
            padding: 0 !important;
            box-shadow: none !important;
            border: none !important;
        }
        tr { page-break-inside: avoid; }
        .signature-section { page-break-inside: avoid; }
    }

    .a4-landscape-container {
        width: 29.7cm;       /* Lebar A4 Horizontal */
        min-height: 21cm;    /* Tinggi A4 Horizontal */
        margin: 2rem auto;
        padding: 1cm;
        background: white;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        box-sizing: border-box;
    }

    /* CSS Dasar untuk Tabel */
    .form-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
        color: #000;
    }
    .form-table th, .form-table td {
        border: 1px solid #000;
    }

    /* Input Styling */
    .input-transparent {
        width: 100%;
        border: none;
        background: transparent;
        outline: none;
        font-size: 11px;
        font-family: inherit;
    }

    /* Memaksa Dropdown persis di tengah dan tanpa panah */
    .select-center {
        text-align: center !important;
        text-align-last: center !important;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background: transparent;
        border: none;
        outline: none;
        width: 100%;
        cursor: pointer;
        font-family: inherit;
    }

    /* Styling seragam untuk text input dan date picker */
    .form-input-inline {
        border: none;
        border-bottom: 1px dashed #000;
        background: transparent;
        font-family: inherit;
        font-size: inherit;
        padding: 2px 4px;
    }
    .form-input-inline:focus {
        outline: none;
        border-bottom: 1px solid #00a4e4;
    }
    
    .form-input-table {
        width: 100%;
        border: none;
        background: transparent;
        text-align: center;
        outline: none;
        font-family: inherit;
        font-size: inherit;
    }
</style>

<div class="a4-landscape-container text-black font-sans">
    
    <!-- KOP FORMULIR -->
    <table class="w-full border-collapse border border-black mb-4 bg-white text-[10px]">
        <tr>
            <!-- Kiri Atas: Logo -->
            <td rowspan="2" class="border border-black w-[20%] text-center align-middle py-3">
                <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI" class="h-8 mx-auto">
            </td>
            <!-- Tengah Atas: Judul PT -->
            <td rowspan="2" class="border border-black w-[50%] text-center align-middle py-3">
                <h2 class="text-sm font-bold uppercase m-0 leading-tight">PT. KERETA API INDONESIA (PERSERO)</h2>
                <h3 class="text-xs font-bold m-0 leading-tight">Sistem Informasi</h3>
            </td>
            <!-- Kanan Atas: Dokumen Kontrol -->
            <td class="border border-black border-r-0 px-2 py-1 w-[1%] whitespace-nowrap">Nomor</td>
            <td class="border border-black border-l-0 px-2 py-1 whitespace-nowrap">: FR.SM/TI/015.017/10-2020</td>
        </tr>
        <tr>
            <td class="border border-black border-r-0 px-2 py-1 w-[1%] whitespace-nowrap">Tanggal Terbit</td>
            <td class="border border-black border-l-0 px-2 py-1 whitespace-nowrap">: 12 Oktober 2020</td>
        </tr>
        <tr>
            <!-- Kiri Bawah: Status -->
            <td rowspan="2" class="border border-black text-center align-middle py-3">
                <span class="border border-yellow-400 text-yellow-600 font-bold px-4 py-0.5 uppercase text-[12px] tracking-widest inline-block bg-white">
                    Terbatas
                </span>
            </td>
            <!-- Tengah Bawah: Nama Formulir -->
            <td rowspan="2" class="border border-black text-center align-middle py-3">
                <h4 class="text-sm font-bold uppercase m-0 tracking-wider">FORMULIR MONITORING CCTV</h4>
            </td>
            <!-- Kanan Bawah: Versi -->
            <td class="border border-black border-r-0 px-2 py-1 w-[1%] whitespace-nowrap">Versi</td>
            <td class="border border-black border-l-0 px-2 py-1 whitespace-nowrap">: 002-2020</td>
        </tr>
        <tr>
            <td class="border border-black border-r-0 px-2 py-1 w-[1%] whitespace-nowrap">Halaman</td>
            <td class="border border-black border-l-0 px-2 py-1 whitespace-nowrap">: 1 dari 1</td>
        </tr>
    </table>

    <!-- TABEL NO REF KECIL -->
    <table class="border-collapse border border-black mb-4 text-xs w-[30%] bg-white">
        <tr class="border-b border-black">
            <td class="whitespace-nowrap w-24 pl-2 py-1 border-r border-black">No Ref</td>
            <td class="w-1 px-1 py-1">:</td>
            <td class="p-0 pr-2">
                <input type="text" name="no_ref" value="{{ old('no_ref', $monitoring->no_ref ?? '') }}" class="w-full outline-none bg-transparent h-full py-1 text-[11px] px-1" placeholder="__ / __ / ____">
            </td>
        </tr>
        <tr class="border-b border-black">
            <td class="whitespace-nowrap pl-2 py-1 border-r border-black">Tanggal</td>
            <td class="px-1 py-1">:</td>
            <td class="p-0 pr-2 relative">
                <input type="text" name="tanggal" id="input_tanggal_utama" value="{{ old('tanggal', $monitoring->tanggal ?? '') }}" class="w-full outline-none bg-transparent h-full py-1 text-[11px] px-1 text-left custom-date-picker" style="cursor: pointer;" data-format="id" autocomplete="off" placeholder="Pilih Tanggal" onchange="updateBulanOtomatis()" required>
            </td>
        </tr>
        <tr>
            <td class="whitespace-nowrap pl-2 py-1 border-r border-black">Business Area</td>
            <td class="px-1 py-1">:</td>
            <td class="p-0 pr-2">
                <input type="text" name="business_area" value="{{ old('business_area', $monitoring->business_area ?? '') }}" class="w-full outline-none bg-transparent h-full py-1 text-[11px] px-1">
            </td>
        </tr>
    </table>

<!-- TABEL UTAMA MONITORING -->
    <div class="w-full mb-4 bg-white">
        <table class="form-table text-xs border-black">
            <thead class="bg-gray-300">
                <!-- BARIS 1: BULAN -->
                <tr>
                    <th rowspan="4" class="p-1 w-10 text-center align-middle border-black font-normal">No</th>
                    <th class="p-1 text-left px-2 font-bold w-56 border-black">Bulan</th>
                    <th colspan="8" class="p-1 align-bottom pb-1 bg-white border-black">
                        <input type="text" name="bulan" id="input_bulan_utama" value="{{ old('bulan', $monitoring->bulan ?? '') }}" placeholder="Isikan Bulan" class="w-full text-center outline-none bg-transparent font-bold text-xs">
                    </th>
                    <th rowspan="4" class="p-1 w-48 text-center align-middle border-black font-bold">Note</th>
                </tr>
                <!-- BARIS 2: MINGGU -->
                <tr>
                    <th class="p-1 text-left px-2 font-bold border-black">Minggu</th>
                    <th colspan="2" class="p-1 text-center font-bold border-black w-32">M1</th>
                    <th colspan="2" class="p-1 text-center font-bold border-black w-32">M2</th>
                    <th colspan="2" class="p-1 text-center font-bold border-black w-32">M3</th>
                    <th colspan="2" class="p-1 text-center font-bold border-black w-32">M4</th>
                </tr>
                <!-- BARIS 3: TANGGAL PELAKSANAAN -->
                <tr>
                    <th class="p-1 text-left px-2 font-bold border-black">Tanggal Pelaksanaan</th>
                    <th colspan="2" class="p-1 bg-white border-black relative">
                        <input type="text" name="tgl_pelaksanaan_m1" value="{{ old('tgl_pelaksanaan_m1', $monitoring->tgl_pelaksanaan_m1 ?? '') }}" class="form-input-table custom-date-picker border-b border-dotted border-black" style="cursor: pointer;" data-format="id" autocomplete="off" placeholder="Pilih Tgl">
                    </th>
                    <th colspan="2" class="p-1 bg-white border-black relative">
                        <input type="text" name="tgl_pelaksanaan_m2" value="{{ old('tgl_pelaksanaan_m2', $monitoring->tgl_pelaksanaan_m2 ?? '') }}" class="form-input-table custom-date-picker border-b border-dotted border-black" style="cursor: pointer;" data-format="id" autocomplete="off" placeholder="Pilih Tgl">
                    </th>
                    <th colspan="2" class="p-1 bg-white border-black relative">
                        <input type="text" name="tgl_pelaksanaan_m3" value="{{ old('tgl_pelaksanaan_m3', $monitoring->tgl_pelaksanaan_m3 ?? '') }}" class="form-input-table custom-date-picker border-b border-dotted border-black" style="cursor: pointer;" data-format="id" autocomplete="off" placeholder="Pilih Tgl">
                    </th>
                    <th colspan="2" class="p-1 bg-white border-black relative">
                        <input type="text" name="tgl_pelaksanaan_m4" value="{{ old('tgl_pelaksanaan_m4', $monitoring->tgl_pelaksanaan_m4 ?? '') }}" class="form-input-table custom-date-picker border-b border-dotted border-black" style="cursor: pointer;" data-format="id" autocomplete="off" placeholder="Pilih Tgl">
                    </th>
                </tr>
                <!-- BARIS 4: NAMA TITIK & STATUS -->
                <tr class="text-[9px]">
                    <th class="p-0 text-center font-bold border-black bg-gray-300">
                        <input type="text" name="header_nama_titik_cctv" value="{{ old('header_nama_titik_cctv', $monitoring->header_nama_titik_cctv ?? 'Nama Titik CCTV') }}" class="w-full text-center outline-none bg-transparent h-full font-bold">
                    </th>
                    <th class="p-1 w-16 text-center border-black font-normal">BERFUNGSI</th>
                    <th class="p-1 w-16 text-center border-black font-normal">TERBACKUP</th>
                    <th class="p-1 w-16 text-center border-black font-normal">BERFUNGSI</th>
                    <th class="p-1 w-16 text-center border-black font-normal">TERBACKUP</th>
                    <th class="p-1 w-16 text-center border-black font-normal">BERFUNGSI</th>
                    <th class="p-1 w-16 text-center border-black font-normal">TERBACKUP</th>
                    <th class="p-1 w-16 text-center border-black font-normal">BERFUNGSI</th>
                    <th class="p-1 w-16 text-center border-black font-normal">TERBACKUP</th>
                </tr>
            </thead>
            <tbody class="bg-white" id="cctv-table-body">
                @php
                    $rowCount = isset($monitoring) && $monitoring->items->count() > 0 ? $monitoring->items->count() : 10;
                @endphp
                @for ($i = 1; $i <= $rowCount; $i++)
                @php
                    $item = isset($monitoring) && $monitoring->items->count() >= $i ? $monitoring->items[$i-1] : null;
                @endphp
                <tr>
                    <td class="text-center font-bold border-black p-0">
                        <input type="text" name="items[{{ $i }}][nomor]" value="{{ old('items.'.$i.'.nomor', $item->nomor ?? ($i == 10 ? '<n>' : $i)) }}" class="w-full text-center outline-none bg-transparent py-1.5">
                    </td>
                    <td class="p-0 border-black">
                        <select name="items[{{ $i }}][nama_titik_cctv]" class="cctv-select w-full px-2 py-1.5" data-row="{{ $i }}">
                            <option value="">Pilih / Ketik CCTV</option>
                            @foreach ($cctvs ?? [] as $cctv)
                                <option value="{{ $cctv->id_cctv }}" {{ old('items.'.$i.'.nama_titik_cctv', $item->nama_titik_cctv ?? '') == $cctv->id_cctv ? 'selected' : '' }}>
                                    {{ $cctv->id_cctv }}
                                </option>
                            @endforeach
                            @php $currentVal = old('items.'.$i.'.nama_titik_cctv', $item->nama_titik_cctv ?? ''); @endphp
                            @if($currentVal && !collect($cctvs ?? [])->contains('id_cctv', $currentVal))
                                <option value="{{ $currentVal }}" selected>{{ $currentVal }}</option>
                            @endif
                        </select>
                    </td>
                    @foreach (['m1', 'm2', 'm3', 'm4'] as $m)
                    <td class="p-0 align-middle border-black">
                        <select name="items[{{ $i }}][{{ $m }}_berfungsi]" class="select-center h-full py-1.5 text-black font-bold">
                            <option value=""></option>
                            <option value="V" {{ old('items.'.$i.'.'.$m.'_berfungsi', $item->{$m.'_berfungsi'} ?? '') == 'V' ? 'selected' : '' }}>V</option>
                            <option value="X" {{ old('items.'.$i.'.'.$m.'_berfungsi', $item->{$m.'_berfungsi'} ?? '') == 'X' ? 'selected' : '' }}>X</option>
                        </select>
                    </td>
                    <td class="p-0 align-middle border-black">
                        <select name="items[{{ $i }}][{{ $m }}_terbackup]" class="select-center h-full py-1.5 text-black font-bold">
                            <option value=""></option>
                            <option value="V" {{ old('items.'.$i.'.'.$m.'_terbackup', $item->{$m.'_terbackup'} ?? '') == 'V' ? 'selected' : '' }}>V</option>
                            <option value="X" {{ old('items.'.$i.'.'.$m.'_terbackup', $item->{$m.'_terbackup'} ?? '') == 'X' ? 'selected' : '' }}>X</option>
                        </select>
                    </td>
                    @endforeach
                    
                    <td class="p-0 border-black bg-white">
                        <input type="text" name="items[{{ $i }}][note]" value="{{ old('items.'.$i.'.note', $item->note ?? '') }}" class="input-transparent px-2 py-1.5 font-bold">
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>
    
    <div class="flex justify-end gap-2 mt-3 mb-5">
        <button type="button" id="removeRowBtn" class="px-4 py-1.5 bg-red-50 text-red-600 border border-red-200 rounded hover:bg-red-100 text-xs font-bold transition-colors">
            - Kurangi Baris
        </button>
        <button type="button" id="addRowBtn" class="px-4 py-1.5 bg-blue-50 text-blue-600 border border-blue-200 rounded hover:bg-blue-100 text-xs font-bold transition-colors">
            + Tambah Baris
        </button>
    </div>

    <!-- CATATAN SECTION -->
    <div class="mb-4 bg-white">
        <label class="block text-[11px] mb-1 text-black font-bold">Catatan :</label>
        <div class="w-full border border-black h-20 bg-white">
            <textarea name="catatan" class="w-full h-full bg-transparent resize-none outline-none text-[11px] p-2 text-black">{{ old('catatan', $monitoring->catatan ?? '') }}</textarea>
        </div>
    </div>

    <!-- FOOTER (KETERANGAN & TANDA TANGAN) -->
    <div class="flex justify-between text-[11px] mt-4 mb-6 text-black bg-white signature-section">
        <!-- Keterangan -->
        <div class="w-1/4 leading-tight pt-2">
            <p>Keterangan :</p>
            <p>V : YA</p>
            <p>X : TIDAK</p>
        </div>
        
        <!-- Mengetahui -->
        <div class="w-1/3 text-center flex flex-col items-center justify-between h-32">
            <!-- GRUP ATAS: Mengetahui & Tanggal -->
            <div class="mt-2 w-64 px-4">
                <p class="mb-1">Mengetahui,</p>
                <div class="flex items-center justify-center">
                    <span class="text-[11px] font-bold whitespace-nowrap">Yogyakarta, </span>
                    <input type="text" name="mengetahui_tanggal" value="{{ old('mengetahui_tanggal', $monitoring->mengetahui_tanggal ?? '') }}" class="form-input-inline custom-date-picker ml-1" style="width: 100px; text-align: center; cursor: pointer; border-bottom: 1px dotted #000;" data-format="id" autocomplete="off" placeholder="Pilih Tgl" required>
                </div>
            </div>
            
            <!-- GRUP BAWAH: Nama & NIPP -->
            <div class="w-64 px-4">
                <select name="mengetahui_id" id="mengetahui_id" class="w-full text-center outline-none border-b border-dotted border-black mb-1 bg-transparent font-bold text-xs select-center" onchange="updateMengetahuiInfo()" required>
                    <option value="" disabled selected>-- Pilih Mengetahui --</option>
                    @foreach($signers ?? [] as $signer)
                        <option value="{{ $signer->id }}" data-nipp="{{ $signer->nipp }}" {{ old('mengetahui_id', $monitoring->mengetahui_id ?? '') == $signer->id ? 'selected' : '' }}>
                            {{ $signer->nama }}
                        </option>
                    @endforeach
                </select>

                <div class="flex items-center text-left mt-1">
                    <span class="mr-1">NIPP.</span>
                    <input type="text" id="mengetahui_nipp" value="{{ old('mengetahui_nipp', $monitoring->mengetahui->nipp ?? '') }}" class="w-full bg-transparent text-[11px] outline-none" placeholder="isikan NIPP Mengetahui" readonly tabindex="-1">
                </div>
            </div>
        </div>
        
        <!-- Petugas -->
        <div class="w-1/3 text-center flex flex-col items-center justify-between h-32">
            <!-- GRUP ATAS: Petugas & Tanggal -->
            <div class="mt-2 w-64 px-4">
                <div class="flex items-center justify-center mb-1">
                    <span class="text-[11px] font-bold whitespace-nowrap">Yogyakarta, </span>
                    <input type="text" name="petugas_tanggal" value="{{ old('petugas_tanggal', $monitoring->petugas_tanggal ?? '') }}" class="form-input-inline custom-date-picker ml-1" style="width: 100px; text-align: center; cursor: pointer; border-bottom: 1px dotted #000;" data-format="id" autocomplete="off" placeholder="Pilih Tgl" required>
                </div>
                <p class="text-center m-0">Petugas</p>
            </div>
            
            <!-- GRUP BAWAH: Nama & NIPP -->
            <div class="w-64 px-4">
                <select id="petugas_select" class="w-full text-center outline-none border-b border-dotted border-black mb-1 bg-transparent font-bold text-xs select-center" onchange="updatePetugasInfo()" required>
                    <option value="" disabled selected>-- Pilih Petugas --</option>
                    @foreach($petugas ?? [] as $p)
                        <option value="{{ $p->nama }}" data-nipp="{{ $p->nipp }}" {{ old('petugas_nama', $monitoring->petugas_nama ?? '') == $p->nama ? 'selected' : '' }}>
                            {{ $p->nama }}
                        </option>
                    @endforeach
                </select>

                <input type="hidden" name="petugas_nama" id="petugas_nama" value="{{ old('petugas_nama', $monitoring->petugas_nama ?? '') }}">
                
                <div class="flex items-center text-left mt-1">
                    <span class="mr-1">NIPP.</span>
                    <input type="text" name="petugas_nipp" id="petugas_nipp" value="{{ old('petugas_nipp', $monitoring->petugas_nipp ?? '') }}" class="w-full bg-transparent text-[11px] outline-none" placeholder="isikan NIPP Petugas" readonly tabindex="-1">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateBulanOtomatis() {
        const tglInput = document.getElementById('input_tanggal_utama');
        const bulanInput = document.getElementById('input_bulan_utama');

        if (!tglInput || !bulanInput || !tglInput.value) return;

        const val = tglInput.value.trim();
        const namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        let bulanHasil = "";

        if (/^\d{4}-\d{2}-\d{2}$/.test(val)) {
            const indexBulan = parseInt(val.substring(5, 7), 10) - 1;
            bulanHasil = namaBulan[indexBulan];
        }
        else if (/^\d{2}[\/\-]\d{2}[\/\-]\d{4}$/.test(val)) {
            const indexBulan = parseInt(val.substring(3, 5), 10) - 1;
            bulanHasil = namaBulan[indexBulan];
        }
        else {
            const regexBulan = /(januari|februari|maret|april|mei|juni|juli|agustus|september|oktober|november|desember)/i;
            const match = val.match(regexBulan);
            if (match) {
                bulanHasil = match[0];
            }
        }

        if (bulanHasil) {
            bulanInput.value = bulanHasil.toUpperCase(); 
        }
    }

    function updatePetugasInfo() {
        const select = document.getElementById('petugas_select');
        const selectedOption = select.options[select.selectedIndex];
        
        if(selectedOption && selectedOption.value !== "") {
            document.getElementById('petugas_nama').value = selectedOption.value;
            document.getElementById('petugas_nipp').value = selectedOption.getAttribute('data-nipp');
        } else {
            document.getElementById('petugas_nama').value = "";
            document.getElementById('petugas_nipp').value = "";
        }
    }

    function updateMengetahuiInfo() {
        const select = document.getElementById('mengetahui_id');
        const selectedOption = select.options[select.selectedIndex];
        
        if(selectedOption && selectedOption.value !== "") {
            document.getElementById('mengetahui_nipp').value = selectedOption.getAttribute('data-nipp');
        } else {
            document.getElementById('mengetahui_nipp').value = "";
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        if(document.getElementById('petugas_select') && document.getElementById('petugas_select').value !== "") {
            updatePetugasInfo();
        }
        if(document.getElementById('mengetahui_id') && document.getElementById('mengetahui_id').value !== "") {
            updateMengetahuiInfo();
        }

        const tglUtama = document.getElementById('input_tanggal_utama');
        if (tglUtama) {
            tglUtama.addEventListener('input', updateBulanOtomatis);
            tglUtama.addEventListener('change', updateBulanOtomatis);
            if(tglUtama.value !== "") updateBulanOtomatis();
        }

        // Fungsi untuk menginisialisasi satu elemen TomSelect
        function initTomSelect(selectEl, rowNum) {
            return new TomSelect(selectEl, {
                create: true, // Mengizinkan entri teks kustom
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                placeholder: "Pilih / Ketik CCTV",
                onChange: function(value) {
                    if (value && value !== '-eof') {
                        // Mencari baris selanjutnya
                        const nextRowSelect = document.querySelector(`.cctv-select[data-row="${rowNum + 1}"]`);
                        if (nextRowSelect && nextRowSelect.tomselect) {
                            const nextTs = nextRowSelect.tomselect;
                            // Jika baris selanjutnya kosong, isi otomatis dengan -eof
                            if (!nextTs.getValue()) {
                                nextTs.addOption({value: '-eof', text: '-eof'});
                                nextTs.setValue('-eof');
                            }
                        }
                    }
                }
            });
        }

        // Inisialisasi TomSelect untuk dropdown CCTV yang sudah ada
        const cctvSelects = document.querySelectorAll('.cctv-select');
        cctvSelects.forEach((select) => {
            const rowNum = parseInt(select.getAttribute('data-row'), 10);
            initTomSelect(select, rowNum);
        });

        // Fitur Tambah/Kurangi Baris secara Dinamis
        const tableBody = document.getElementById('cctv-table-body');
        const addRowBtn = document.getElementById('addRowBtn');
        const removeRowBtn = document.getElementById('removeRowBtn');

        // Fungsi untuk mengurutkan nomor baris dan memastikan <n> ada di paling akhir
        function updateRowNumbers() {
            const rows = tableBody.querySelectorAll('tr');
            rows.forEach((row, index) => {
                const nomorInput = row.querySelector('input[name$="[nomor]"]');
                if (nomorInput) {
                    if (index === rows.length - 1) {
                        nomorInput.value = '<n>';
                    } else {
                        nomorInput.value = index + 1;
                    }
                }
            });
        }

        if(addRowBtn) {
            addRowBtn.addEventListener('click', function() {
                const rows = tableBody.querySelectorAll('tr');
                const lastRow = rows[rows.length - 1];
                const newRowNum = rows.length + 1;

                // Gandakan (clone) baris terakhir
                const newRow = lastRow.cloneNode(true);
                
                // Perbarui nama atribut pada input
                newRow.querySelectorAll('input').forEach(input => {
                    const oldName = input.getAttribute('name');
                    if(oldName) {
                        input.setAttribute('name', oldName.replace(/\[\d+\]/, `[${newRowNum}]`));
                    }
                    if(!input.name.includes('[nomor]')) {
                        input.value = '';
                    }
                });

                // Perbarui nama atribut pada select
                newRow.querySelectorAll('select').forEach(select => {
                    const oldName = select.getAttribute('name');
                    if(oldName) {
                        select.setAttribute('name', oldName.replace(/\[\d+\]/, `[${newRowNum}]`));
                    }
                    if (select.classList.contains('cctv-select')) {
                        select.setAttribute('data-row', newRowNum);
                        select.classList.remove('tomselected', 'ts-hidden-accessible');
                        // Kembalikan pilihan ke default (kosongkan pilihan sebelumnya)
                        select.innerHTML = `<option value="">Pilih / Ketik CCTV</option>
                            @foreach ($cctvs ?? [] as $cctv)
                                <option value="{{ $cctv->id_cctv }}">{{ $cctv->id_cctv }}</option>
                            @endforeach`;
                    } else {
                        select.value = '';
                    }
                });

                // Hapus elemen pembungkus TomSelect bawaan dari hasil clone
                const tsControl = newRow.querySelector('.ts-wrapper');
                if(tsControl) tsControl.remove();

                tableBody.appendChild(newRow);

                // Inisialisasi ulang TomSelect pada elemen select yang baru ditambahkan
                const newSelect = newRow.querySelector('.cctv-select');
                if(newSelect) initTomSelect(newSelect, newRowNum);
                
                // Update nomor
                updateRowNumbers();
            });
        }

        if(removeRowBtn) {
            removeRowBtn.addEventListener('click', function() {
                const rows = tableBody.querySelectorAll('tr');
                if (rows.length > 1) {
                    const lastRow = rows[rows.length - 1];
                    const select = lastRow.querySelector('.cctv-select');
                    if (select && select.tomselect) {
                        select.tomselect.destroy();
                    }
                    lastRow.remove();
                    
                    // Update nomor
                    updateRowNumbers();
                }
            });
        }

        // Jalankan saat pertama kali halaman dimuat untuk memastikan urutan benar
        if (tableBody.querySelectorAll('tr').length > 0) {
            updateRowNumbers();
        }
    });
</script>