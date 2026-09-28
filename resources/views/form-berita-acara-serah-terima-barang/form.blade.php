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
    .btn-delete-row { position: absolute; right: -32px; top: 50%; transform: translateY(-50%); background-color: #fef2f2; border: none; color: #dc2626; cursor: pointer; padding: 6px; border-radius: 6px; display: flex; align-items: center; justify-content: center; }
    .info-field-table { width: 100%; border-collapse: separate; border-spacing: 0 6px; font-size: 11px; }
    .info-field-table td:first-child { width: 150px; font-weight: bold; }
    .info-field-table td:nth-child(2) { width: 15px; }
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
            <a href="{{ route('form-berita-acara-serah-terima-barang.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors mb-6">
                Kembali ke Daftar Formulir
            </a>
        </div>

        <div style="zoom: 1.3;">
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
                        <td style="border: 1px solid black; padding: 4px 6px; border-left: none;">
                            <input type="text" name="no_ref" value="{{ old('no_ref', $form->no_ref) }}" class="form-input-line" placeholder="__/__/____">
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 4px 6px;">Tanggal</td>
                        <td style="border: 1px solid black; padding: 4px 6px; border-right: none;">:</td>
                        <td style="border: 1px solid black; padding: 4px 6px; border-left: none;">
                            <input type="text" name="tanggal_ref" value="{{ old('tanggal_ref', $form->tanggal_ref) }}" class="form-input-line custom-date-picker" autocomplete="off" placeholder="__ - __ - ____">
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 4px 6px;">Business Area</td>
                        <td style="border: 1px solid black; padding: 4px 6px; border-right: none;">:</td>
                        <td style="border: 1px solid black; padding: 4px 6px; border-left: none;">
                            <input type="text" name="business_area" value="{{ old('business_area', $form->business_area) }}" class="form-input-line">
                        </td>
                    </tr>
                </table>

                {{-- =================== PEMBUKA & DATA PENYERAH =================== --}}
                <div style="font-size: 11px; margin-top: 25px; margin-left: 20px;">
                    <div style="margin-bottom: 15px;">
                        Pada hari ini,
                        <input type="text" name="hari" value="{{ old('hari', $form->hari) }}" class="form-input-line" style="width: 100px;" placeholder="............">
                        tanggal
                        <input type="text" name="tanggal_serah_terima" value="{{ old('tanggal_serah_terima', $form->tanggal_serah_terima) }}" class="form-input-line custom-date-picker" style="width: 150px;" autocomplete="off" placeholder="..................">
                    </div>

                    <table class="info-field-table">
                        <tr>
                            <td><strong>Nama Lengkap</strong></td>
                            <td>:</td>
                            <td><input type="text" name="penyerah_nama" id="penyerah_nama" list="signer-list" value="{{ old('penyerah_nama', $form->penyerah_nama) }}" class="form-input-line"></td>
                        </tr>
                        <tr>
                            <td><strong>Nipp</strong></td>
                            <td>:</td>
                            <td><input type="text" name="penyerah_nipp" id="penyerah_nipp" value="{{ old('penyerah_nipp', $form->penyerah_nipp) }}" class="form-input-line"></td>
                        </tr>
                        <tr>
                            <td><strong>Jabatan</strong></td>
                            <td>:</td>
                            <td><input type="text" name="penyerah_jabatan" value="{{ old('penyerah_jabatan', $form->penyerah_jabatan) }}" class="form-input-line"></td>
                        </tr>
                        <tr>
                            <td><strong>Tempat Kedudukan</strong></td>
                            <td>:</td>
                            <td><input type="text" name="penyerah_tempat_kedudukan" value="{{ old('penyerah_tempat_kedudukan', $form->penyerah_tempat_kedudukan) }}" class="form-input-line"></td>
                        </tr>
                        <tr>
                            <td><strong>Personal Area</strong></td>
                            <td>:</td>
                            <td><input type="text" name="penyerah_personal_area" value="{{ old('penyerah_personal_area', $form->penyerah_personal_area) }}" class="form-input-line"></td>
                        </tr>
                    </table>
                </div>

                {{-- =================== TABEL BARANG =================== --}}
                <div style="font-size: 11px; margin-top: 20px; margin-left: 20px;">
                    <div style="margin-bottom: 10px;">Menyerahkan barang-barang sebagai berikut:</div>

                    <table class="data-table" id="items-table">
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
                            @php $oldItems = old('items', $items ?? []); $rowCount = max(3, count($oldItems)); @endphp
                            @for ($i = 0; $i < $rowCount; $i++)
                                @php $item = $oldItems[$i] ?? null; @endphp
                                <tr class="item-row">
                                    <td>{{ $i + 1 }}</td>
                                    <td><input type="text" name="items[{{$i}}][nama_barang]" value="{{ $item['nama_barang'] ?? '' }}" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
                                    <td><input type="text" name="items[{{$i}}][brand_series]" value="{{ $item['brand_series'] ?? '' }}" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
                                    <td><input type="text" name="items[{{$i}}][no_inventaris]" value="{{ $item['no_inventaris'] ?? '' }}" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
                                    <td><input type="text" name="items[{{$i}}][serial_number]" value="{{ $item['serial_number'] ?? '' }}" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
                                    <td>
                                        <input type="text" name="items[{{$i}}][keterangan]" value="{{ $item['keterangan'] ?? '' }}" class="form-input-line" style="text-align: center; border-bottom: none;">
                                        @if($i >= 3)
                                        <button type="button" class="btn-delete-row" onclick="removeRow(this)">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>

                    <div style="margin-top: 10px; text-align: right;" class="no-print">
                        <button type="button" class="btn-tambah-baris" onclick="addRow()">Tambah Baris</button>
                    </div>
                </div>

                {{-- =================== DATA PENERIMA =================== --}}
                <div style="font-size: 11px; margin-top: 25px; margin-left: 20px;">
                    <div style="margin-bottom: 10px;"><strong>Kepada :</strong></div>

                    <table class="info-field-table">
                        <tr>
                            <td><strong>Nama Lengkap</strong></td>
                            <td>:</td>
                            <td><input type="text" name="penerima_nama" id="penerima_nama" list="signer-list" value="{{ old('penerima_nama', $form->penerima_nama) }}" class="form-input-line"></td>
                        </tr>
                        <tr>
                            <td><strong>Nipp</strong></td>
                            <td>:</td>
                            <td><input type="text" name="penerima_nipp" id="penerima_nipp" value="{{ old('penerima_nipp', $form->penerima_nipp) }}" class="form-input-line"></td>
                        </tr>
                        <tr>
                            <td><strong>Jabatan</strong></td>
                            <td>:</td>
                            <td><input type="text" name="penerima_jabatan" value="{{ old('penerima_jabatan', $form->penerima_jabatan) }}" class="form-input-line"></td>
                        </tr>
                        <tr>
                            <td><strong>Tempat Kedudukan</strong></td>
                            <td>:</td>
                            <td><input type="text" name="penerima_tempat_kedudukan" value="{{ old('penerima_tempat_kedudukan', $form->penerima_tempat_kedudukan) }}" class="form-input-line"></td>
                        </tr>
                        <tr>
                            <td><strong>Personal Area</strong></td>
                            <td>:</td>
                            <td><input type="text" name="penerima_personal_area" value="{{ old('penerima_personal_area', $form->penerima_personal_area) }}" class="form-input-line"></td>
                        </tr>
                        <tr>
                            <td><strong>Owner Responsible</strong></td>
                            <td>:</td>
                            <td><input type="text" name="penerima_owner_responsible" value="{{ old('penerima_owner_responsible', $form->penerima_owner_responsible) }}" class="form-input-line"></td>
                        </tr>
                        <tr>
                            <td><strong>Custodian</strong></td>
                            <td>:</td>
                            <td><input type="text" name="penerima_custodian" value="{{ old('penerima_custodian', $form->penerima_custodian) }}" class="form-input-line"></td>
                        </tr>
                    </table>
                </div>

                {{-- =================== KETERANGAN PENGGUNAAN =================== --}}
                <div style="font-size: 11px; margin-top: 25px; margin-left: 20px; line-height: 1.8;">
                    Dipergunakan untuk alat bantu kerja
                    <input type="text" name="nama_unit" value="{{ old('nama_unit', $form->nama_unit) }}" class="form-input-line" style="width: 150px; color: red; font-style: italic;" placeholder="<Nama Unit>">
                    di wilayah
                    <input type="text" name="wilayah" value="{{ old('wilayah', $form->wilayah) }}" class="form-input-line" style="width: 250px; color: red; font-style: italic;" placeholder="<Kantor Pusat/Daop/Divre/Balaiyasa>">
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
                                <input type="text" name="ttd_penyerah_nama" id="ttd_penyerah_nama" list="signer-list" value="{{ old('ttd_penyerah_nama', $form->ttd_penyerah_nama) }}" class="form-input-line" style="width: 200px; text-align: center;" placeholder="..........................">
                            </div>
                            <div>
                                NIPP. <input type="text" name="ttd_penyerah_nipp" id="ttd_penyerah_nipp" value="{{ old('ttd_penyerah_nipp', $form->ttd_penyerah_nipp) }}" class="form-input-line" style="width: 130px; text-align: center;" placeholder="..............">
                            </div>
                        </td>
                        <td style="height: 80px; vertical-align: bottom;">
                            <div style="margin-bottom: 3px;">
                                <input type="text" name="ttd_penerima_nama" id="ttd_penerima_nama" list="signer-list" value="{{ old('ttd_penerima_nama', $form->ttd_penerima_nama) }}" class="form-input-line" style="width: 200px; text-align: center;" placeholder="..........................">
                            </div>
                            <div>
                                NIPP. <input type="text" name="ttd_penerima_nipp" id="ttd_penerima_nipp" value="{{ old('ttd_penerima_nipp', $form->ttd_penerima_nipp) }}" class="form-input-line" style="width: 130px; text-align: center;" placeholder="..............">
                            </div>
                        </td>
                    </tr>
                </table>

                {{-- =================== CATATAN FOOTER =================== --}}
                <div style="font-size: 10px; margin-top: 30px; color: #000;">
                    *Mohon setelah di tandatangani, BAST dikembalikan ke alamat pengirim
                </div>

                {{-- =================== TOMBOL SIMPAN =================== --}}
                <div class="no-print" style="margin-top: 40px; text-align: center; border-top: 1px solid #eaeaea; padding-top: 20px;">
                    <a href="{{ route('form-berita-acara-serah-terima-barang.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">{{ $form->exists ? 'Perbarui' : 'Simpan' }}</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Autofill NIPP dari signer-list
        function setupAutofill(nameId, nippId) {
            const nameInput = document.getElementById(nameId);
            const nippInput = document.getElementById(nippId);
            if (!nameInput || !nippInput) return;

            nameInput.addEventListener('input', function() {
                const options = document.getElementById('signer-list').options;
                for (let i = 0; i < options.length; i++) {
                    if (options[i].value === nameInput.value) {
                        nippInput.value = options[i].getAttribute('data-nipp') || '';
                        nippInput.dispatchEvent(new Event('input'));
                        break;
                    }
                }
            });
        }
        setupAutofill('penyerah_nama', 'penyerah_nipp');
        setupAutofill('penerima_nama', 'penerima_nipp');
        setupAutofill('ttd_penyerah_nama', 'ttd_penyerah_nipp');
        setupAutofill('ttd_penerima_nama', 'ttd_penerima_nipp');

        // Sinkronisasi tanggal dan hari
        const tanggalRef = document.querySelector('input[name="tanggal_ref"]');
        const tanggalSerahTerima = document.querySelector('input[name="tanggal_serah_terima"]');
        const hariInput = document.querySelector('input[name="hari"]');

        function updateHari(dateString) {
            if (!hariInput) return;
            if (!dateString) {
                hariInput.value = '';
                return;
            }
            
            let cleanStr = dateString.replace(/[^\d\-\/]/g, '');
            let parts = cleanStr.split(/[\-\/]/);
            let d, m, y;
            if (parts.length === 3) {
                if (parts[0].length === 4) { // yyyy-mm-dd
                    y = parseInt(parts[0]);
                    m = parseInt(parts[1]) - 1;
                    d = parseInt(parts[2]);
                } else { // dd-mm-yyyy
                    d = parseInt(parts[0]);
                    m = parseInt(parts[1]) - 1;
                    y = parseInt(parts[2]);
                }
                
                let dateObj = new Date(y, m, d);
                if (!isNaN(dateObj.getTime())) {
                    const namaHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    hariInput.value = namaHari[dateObj.getDay()];
                }
            }
        }

        if (tanggalRef && tanggalSerahTerima) {
            const syncDate = function() {
                tanggalSerahTerima.value = this.value;
                updateHari(this.value);
            };
            tanggalRef.addEventListener('input', syncDate);
            tanggalRef.addEventListener('change', syncDate);
        }
        
        if (tanggalSerahTerima) {
            const syncHariOnly = function() {
                updateHari(this.value);
            };
            tanggalSerahTerima.addEventListener('input', syncHariOnly);
            tanggalSerahTerima.addEventListener('change', syncHariOnly);
        }

        // Sinkronisasi Penyerah ke Tanda Tangan Penyerah
        const penyerahNama = document.getElementById('penyerah_nama');
        const penyerahNipp = document.getElementById('penyerah_nipp');
        const ttdPenyerahNama = document.getElementById('ttd_penyerah_nama');
        const ttdPenyerahNipp = document.getElementById('ttd_penyerah_nipp');

        if (penyerahNama && ttdPenyerahNama) {
            penyerahNama.addEventListener('input', function() {
                ttdPenyerahNama.value = this.value;
            });
        }
        if (penyerahNipp && ttdPenyerahNipp) {
            penyerahNipp.addEventListener('input', function() {
                ttdPenyerahNipp.value = this.value;
            });
        }

        // Sinkronisasi Penerima ke Tanda Tangan Penerima
        const penerimaNama = document.getElementById('penerima_nama');
        const penerimaNipp = document.getElementById('penerima_nipp');
        const ttdPenerimaNama = document.getElementById('ttd_penerima_nama');
        const ttdPenerimaNipp = document.getElementById('ttd_penerima_nipp');

        if (penerimaNama && ttdPenerimaNama) {
            penerimaNama.addEventListener('input', function() {
                ttdPenerimaNama.value = this.value;
            });
        }
        if (penerimaNipp && ttdPenerimaNipp) {
            penerimaNipp.addEventListener('input', function() {
                ttdPenerimaNipp.value = this.value;
            });
        }
    });

    let rowIndex = {{ isset($rowCount) ? $rowCount : 0 }};
    function addRow() {
        const tbody = document.querySelector('#items-table tbody');
        const tr = document.createElement('tr');
        tr.className = 'item-row';
        tr.innerHTML = `
            <td>${rowIndex + 1}</td>
            <td><input type="text" name="items[${rowIndex}][nama_barang]" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
            <td><input type="text" name="items[${rowIndex}][brand_series]" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
            <td><input type="text" name="items[${rowIndex}][no_inventaris]" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
            <td><input type="text" name="items[${rowIndex}][serial_number]" class="form-input-line" style="text-align: center; border-bottom: none;"></td>
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
