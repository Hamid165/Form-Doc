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
    .btn-cancel { background-color: #ef4444; color: white; padding: 6px 16px; height: 36px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 13px; margin-right: 10px; text-decoration: none; display: inline-block; text-align: center; line-height: 24px; }
    .btn-tambah-baris { display: inline-flex; height: 30px; padding: 4px 12px; background-color: #f59e0b; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 11px; align-items: center; justify-content: center; }
    .btn-delete-row { position: absolute; right: -32px; top: 50%; transform: translateY(-50%); background-color: #fef2f2; border: none; color: #dc2626; cursor: pointer; padding: 6px; border-radius: 6px; display: flex; align-items: center; justify-content: center; }
</style>

<div class="a4-wrapper" style="flex-direction: column; align-items: center;">
    <form action="{{ $action }}" method="POST" id="mainForm" style="width: 100%; display: flex; flex-direction: column; align-items: center;">
        @csrf
        @if(isset($method) && $method === 'PUT') @method('PUT') @endif

        <datalist id="user-datalist">
            @foreach($masterUsers as $mu)
                <option value="{{ $mu->nama }}" data-nipp="{{ $mu->nipp }}" data-jabatan="{{ $mu->jabatan }}" data-tempat="{{ $mu->tempat_kedudukan }}" data-personal="{{ $mu->personal_area }}">{{ $mu->nama }} ({{ $mu->nipp }})</option>
            @endforeach
        </datalist>

        <div style="width: 273mm; margin-bottom: 20px;">
            <a href="{{ route('form-serah-terima-user.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors mb-6">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Formulir
            </a>
        </div>

        <div style="zoom: 1.3;">
            <div class="a4-container">
                <!-- Header Kop Surat -->
                <table class="kop-table">
                    <tr>
                        <td rowspan="2" style="width: 20%; text-align: center; vertical-align: middle;">
                            <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI" style="width: 100%; max-width: 90px; height: auto; display: inline-block;">
                        </td>
                        <td rowspan="2" style="width: 45%; text-align: center; font-weight: bold; font-size: 12px;">
                            PT KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI
                        </td>
                        <td style="width: 12%;">Nomor</td>
                        <td style="width: 23%;">{{ $formTemplate->no_dokumen ?? 'FR.SM/TI/011.002/10-2020' }}</td>
                    </tr>
                    <tr><td>Tanggal Terbit</td><td>{{ $formTemplate->tanggal_dokumen ?? '12 Oktober 2020' }}</td></tr>
                    <tr>
                        <td rowspan="2" style="text-align: center; padding: 10px;">
                            <div style="border: 2px solid #ef4444; color: #ef4444; font-weight: bold; font-size: 12px; padding: 4px 8px; display: inline-block; letter-spacing: 1px;">RAHASIA</div>
                        </td>
                        <td rowspan="2" style="text-align: center; font-weight: bold; font-size: 11px;">
                            FORMULIR BERITA ACARA<br>SERAH TERIMA USER APLIKASI
                        </td>
                        <td>Versi</td><td>{{ $formTemplate->versi_dokumen ?? '02-2020' }}</td>
                    </tr>
                    <tr><td>Halaman</td><td>1 dari 1</td></tr>
                </table>

                <!-- Referensi & Tanggal Dokumen -->
                <table style="border-collapse: collapse; width: 350px; font-size: 11px; margin-top: 15px;">
                    <tr>
                        <td style="border: 1px solid black; padding: 4px 6px; width: 100px;">No. Ref</td>
                        <td style="border: 1px solid black; padding: 4px 6px; width: 10px; border-right: none;">:</td>
                        <td style="border: 1px solid black; padding: 4px 6px; border-left: none;">
                            <input type="text" name="no_ref" id="input_no_ref" value="{{ old('no_ref', $form->no_ref) }}" class="form-input-line" placeholder="___/___/___" required>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 4px 6px;">Tanggal</td>
                        <td style="border: 1px solid black; padding: 4px 6px; border-right: none;">:</td>
                        <td style="border: 1px solid black; padding: 4px 6px; border-left: none;">
                            <input type="text" name="tanggal_ref" id="input_tanggal_ref" value="{{ old('tanggal_ref', $form->tanggal_ref ? \Carbon\Carbon::parse($form->tanggal_ref)->locale('id')->translatedFormat('d F Y') : '') }}" class="form-input-line custom-date-picker" placeholder="Pilih Tanggal" autocomplete="off" required>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 4px 6px;">Business Area</td>
                        <td style="border: 1px solid black; padding: 4px 6px; border-right: none;">:</td>
                        <td style="border: 1px solid black; padding: 4px 6px; border-left: none;">
                            <input type="text" name="business_area" id="input_business_area" value="{{ old('business_area', $form->business_area) }}" class="form-input-line" placeholder="Contoh: B060" required>
                        </td>
                    </tr>
                </table>

                <!-- Kata Pengantar Serah Terima -->
                <div style="font-size: 11px; margin-top: 20px; line-height: 1.5;">
                    Pada hari ini, 
                    <input type="text" name="hari" id="input_hari" value="{{ old('hari', $form->hari) }}" class="form-input-line" style="width: 120px; display: inline-block;" placeholder="Senin" required>
                    tanggal
                    <input type="text" name="tanggal" id="input_tanggal" value="{{ old('tanggal', $form->tanggal ? \Carbon\Carbon::parse($form->tanggal)->locale('id')->translatedFormat('d F Y') : '') }}" class="form-input-line custom-date-picker" style="width: 180px; display: inline-block;" placeholder="Pilih Tanggal" autocomplete="off" required>
                </div>

                <!-- Penyerah -->
                <div style="font-size: 11px; margin-top: 15px;">
                    <table style="width: 100%; font-size: 11px; border-collapse: separate; border-spacing: 0 8px;">
                        <tr>
                            <td style="width: 150px;">Nama</td>
                            <td style="width: 20px;">:</td>
                            <td>
                                <input type="text" name="nama_penyerah" id="nama_penyerah" value="{{ old('nama_penyerah', $form->nama_penyerah) }}" class="form-input-line" list="user-datalist" placeholder="Nama Pihak Yang Menyerahkan" required>
                            </td>
                        </tr>
                        <tr>
                            <td>NIPP</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="nipp_penyerah" id="nipp_penyerah" value="{{ old('nipp_penyerah', $form->nipp_penyerah) }}" class="form-input-line" placeholder="NIPP">
                            </td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="jabatan_penyerah" id="jabatan_penyerah" value="{{ old('jabatan_penyerah', $form->jabatan_penyerah) }}" class="form-input-line" placeholder="Jabatan">
                            </td>
                        </tr>
                        <tr>
                            <td>Tempat Kedudukan</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="tempat_kedudukan_penyerah" id="tempat_kedudukan_penyerah" value="{{ old('tempat_kedudukan_penyerah', $form->tempat_kedudukan_penyerah) }}" class="form-input-line" placeholder="Tempat Kedudukan">
                            </td>
                        </tr>
                        <tr>
                            <td>Personal Area</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="personal_area_penyerah" id="personal_area_penyerah" value="{{ old('personal_area_penyerah', $form->personal_area_penyerah) }}" class="form-input-line" placeholder="Personal Area">
                            </td>
                        </tr>
                    </table>
                </div>

                <div style="font-size: 11px; margin-top: 15px; font-weight: normal;">
                    Menyerahkan user aplikasi sebagai berikut:
                </div>

                <!-- Alpine.js Table for Dynamic Items -->
                <div x-data="itemsComponent()" style="margin-top: 10px;">
                    <table class="data-table">
                        <thead>
                            <tr style="background-color: #f3f4f6;">
                                <th style="width: 5%;">No</th>
                                <th style="width: 35%;">Nama Aplikasi</th>
                                <th style="width: 30%;">Username</th>
                                <th style="width: 30%;">Password</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(item, index) in items" :key="index">
                                <tr>
                                    <td style="height: 35px;" x-text="index + 1"></td>
                                    <td>
                                        <input type="text" :name="'items['+index+'][nama_aplikasi]'" x-model="item.nama_aplikasi" class="form-input-line" style="border-bottom: none; text-align: center;" placeholder="Input Nama Aplikasi" required>
                                    </td>
                                    <td>
                                        <input type="text" :name="'items['+index+'][username]'" x-model="item.username" class="form-input-line" style="border-bottom: none; text-align: center;" placeholder="Input Username" required>
                                    </td>
                                    <td>
                                        <input type="text" :name="'items['+index+'][password]'" x-model="item.password" class="form-input-line" style="border-bottom: none; text-align: center;" placeholder="Input Password" required>
                                        <button type="button" @click="removeItem(index)" class="btn-delete-row" title="Hapus Baris">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>

                    <div style="margin-top: 12px; display: flex; justify-content: flex-end;">
                        <button type="button" @click="addItem()" class="btn-tambah-baris">
                            + Tambah Baris Aplikasi
                        </button>
                    </div>
                </div>

                <!-- Kepada / Penerima -->
                <div style="font-size: 11px; margin-top: 15px; font-weight: bold;">
                    Kepada
                </div>
                <div style="font-size: 11px;">
                    <table style="width: 100%; font-size: 11px; border-collapse: separate; border-spacing: 0 8px;">
                        <tr>
                            <td style="width: 150px;">Nama</td>
                            <td style="width: 20px;">:</td>
                            <td>
                                <input type="text" name="nama_penerima" id="nama_penerima" value="{{ old('nama_penerima', $form->nama_penerima) }}" class="form-input-line" list="user-datalist" placeholder="Nama Pihak Yang Menerima" required>
                            </td>
                        </tr>
                        <tr>
                            <td>NIPP / No Identitas</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="nipp_penerima" id="nipp_penerima" value="{{ old('nipp_penerima', $form->nipp_penerima) }}" class="form-input-line" placeholder="NIPP / No KTP / Paspor">
                            </td>
                        </tr>
                        <tr>
                            <td>Jabatan / Instansi</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="jabatan_penerima" id="jabatan_penerima" value="{{ old('jabatan_penerima', $form->jabatan_penerima) }}" class="form-input-line" placeholder="Jabatan / Instansi">
                            </td>
                        </tr>
                        <tr>
                            <td>Tempat Kedudukan</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="tempat_kedudukan_penerima" id="tempat_kedudukan_penerima" value="{{ old('tempat_kedudukan_penerima', $form->tempat_kedudukan_penerima) }}" class="form-input-line" placeholder="Tempat Kedudukan">
                            </td>
                        </tr>
                        <tr>
                            <td>Personal Area</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="personal_area_penerima" id="personal_area_penerima" value="{{ old('personal_area_penerima', $form->personal_area_penerima) }}" class="form-input-line" placeholder="Personal Area">
                            </td>
                        </tr>
                        <tr>
                            <td>Owner Responsible</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="owner_responsible_penerima" id="owner_responsible_penerima" value="{{ old('owner_responsible_penerima', $form->owner_responsible_penerima) }}" class="form-input-line" placeholder="Owner Responsible">
                            </td>
                        </tr>
                        <tr>
                            <td>Custodian</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="custodian_penerima" id="custodian_penerima" value="{{ old('custodian_penerima', $form->custodian_penerima) }}" class="form-input-line" placeholder="Custodian">
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Keperluan -->
                <div style="font-size: 11px; margin-top: 15px;">
                    <table style="width: 100%; font-size: 11px; border-collapse: separate; border-spacing: 0 8px;">
                        <tr>
                            <td style="width: 150px; vertical-align: top; padding-top: 4px;">Keperluan</td>
                            <td style="width: 20px; vertical-align: top; padding-top: 4px;">:</td>
                            <td>
                                <textarea name="keperluan" id="keperluan" class="form-input-line" style="border: 1px solid #d1d5db; border-radius: 4px; min-height: 50px; font-family: inherit; resize: vertical;" placeholder="Tuliskan keperluan penggunaan user aplikasi..." required>{{ old('keperluan', $form->keperluan) }}</textarea>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Masa Aktif -->
                <div style="font-size: 11px; margin-top: 15px;">
                    <table style="width: 100%; font-size: 11px; border-collapse: separate; border-spacing: 0 8px;">
                        <tr>
                            <td style="width: 150px;">Masa Aktif User</td>
                            <td style="width: 20px;">:</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <span>Mulai Tanggal</span>
                                    <input type="text" name="masa_aktif_mulai" id="masa_aktif_mulai" value="{{ old('masa_aktif_mulai', $form->masa_aktif_mulai ? \Carbon\Carbon::parse($form->masa_aktif_mulai)->locale('id')->translatedFormat('d F Y') : '') }}" class="form-input-line custom-date-picker" style="width: 150px;" autocomplete="off" placeholder="Pilih Tanggal" required>
                                    <span>s/d Tanggal</span>
                                    <input type="text" name="masa_aktif_selesai" id="masa_aktif_selesai" value="{{ old('masa_aktif_selesai', $form->masa_aktif_selesai ? \Carbon\Carbon::parse($form->masa_aktif_selesai)->locale('id')->translatedFormat('d F Y') : '') }}" class="form-input-line custom-date-picker" style="width: 150px;" autocomplete="off" placeholder="Pilih Tanggal" required>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Footer / Tombol Simpan -->
                <div style="margin-top: 30px; border-top: 1px solid #e5e7eb; padding-top: 20px; display: flex; justify-content: flex-end; gap: 10px;" class="no-print">
                    <a href="{{ route('form-serah-terima-user.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">Simpan Formulir</button>
                </div>

            </div>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
    // Alpine.js component for dynamic application items table
    function itemsComponent() {
        return {
            items: {!! json_encode(
                $form->items && (is_countable($form->items) ? count($form->items) : 0) > 0
                    ? $form->items->map(function($item) {
                        return [
                            'nama_aplikasi' => $item->nama_aplikasi ?? '',
                            'username' => $item->username ?? '',
                            'password' => $item->password ?? '',
                        ];
                    })->values()
                    : [['nama_aplikasi' => '', 'username' => '', 'password' => '']]
            ) !!},
            addItem() {
                this.items.push({ nama_aplikasi: '', username: '', password: '' });
            },
            removeItem(index) {
                if (this.items.length > 1) {
                    this.items.splice(index, 1);
                } else {
                    this.items = [{ nama_aplikasi: '', username: '', password: '' }];
                }
            }
        };
    }

    // Autocomplete script using the user-datalist
    function setupUserAutocomplete(nameId, nippId, jabatanId, tempatId, personalId) {
        const nameInput = document.getElementById(nameId);
        const nippInput = document.getElementById(nippId);
        const jabatanInput = document.getElementById(jabatanId);
        const tempatInput = document.getElementById(tempatId);
        const personalInput = document.getElementById(personalId);
        const datalist = document.getElementById('user-datalist');
        
        if (!nameInput || !datalist) return;

        nameInput.addEventListener('input', function() {
            const options = datalist.options;
            for (let i = 0; i < options.length; i++) {
                if (options[i].value === nameInput.value) {
                    if (nippInput) nippInput.value = options[i].getAttribute('data-nipp') || '';
                    if (jabatanInput) jabatanInput.value = options[i].getAttribute('data-jabatan') || '';
                    if (tempatInput) tempatInput.value = options[i].getAttribute('data-tempat') || '';
                    if (personalInput) personalInput.value = options[i].getAttribute('data-personal') || '';
                    break;
                }
            }
        });
    }

    // Helper to parse date in dd-mm-yyyy or Indonesian "d F Y" format
    function parseIndonesianDate(str) {
        if (!str) return null;
        str = str.trim();
        
        // 1. dd-mm-yyyy format (e.g. 02-08-2026)
        const dmyMatch = str.match(/^(\d{1,2})-(\d{1,2})-(\d{4})$/);
        if (dmyMatch) {
            const day = parseInt(dmyMatch[1], 10);
            const month = parseInt(dmyMatch[2], 10) - 1;
            const year = parseInt(dmyMatch[3], 10);
            return new Date(year, month, day);
        }
        
        // 2. d F Y format with Indonesian month names (e.g. 02 Agustus 2026)
        const monthNamesId = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        const parts = str.split(/\s+/);
        if (parts.length === 3) {
            const day = parseInt(parts[0], 10);
            const month = monthNamesId.indexOf(parts[1]);
            const year = parseInt(parts[2], 10);
            if (month !== -1 && !isNaN(day) && !isNaN(year)) {
                return new Date(year, month, day);
            }
        }
        
        // 3. Fallback
        const parsed = new Date(str);
        return isNaN(parsed) ? null : parsed;
    }

    document.addEventListener('DOMContentLoaded', function() {
        setupUserAutocomplete('nama_penyerah', 'nipp_penyerah', 'jabatan_penyerah', 'tempat_kedudukan_penyerah', 'personal_area_penyerah');
        setupUserAutocomplete('nama_penerima', 'nipp_penerima', 'jabatan_penerima', 'tempat_kedudukan_penerima', 'personal_area_penerima');

        // Auto-fill day and date based on input_tanggal_ref
        const dateRefInput = document.getElementById('input_tanggal_ref');
        const dayInput = document.getElementById('input_hari');
        const dateInput = document.getElementById('input_tanggal');

        if (dateRefInput && dayInput && dateInput) {
            dateRefInput.addEventListener('change', function() {
                const val = dateRefInput.value;
                const parsedDate = parseIndonesianDate(val);
                if (parsedDate) {
                    const dayNamesId = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
                    const dayName = dayNamesId[parsedDate.getDay()];
                    
                    dayInput.value = dayName;
                    dateInput.value = val;
                    
                    // Dispatch change & input events to ensure validity/listeners are updated
                    dayInput.dispatchEvent(new Event('input', { bubbles: true }));
                    dayInput.dispatchEvent(new Event('change', { bubbles: true }));
                    
                    dateInput.dispatchEvent(new Event('input', { bubbles: true }));
                    dateInput.dispatchEvent(new Event('change', { bubbles: true }));
                } else {
                    dayInput.value = '';
                    dateInput.value = '';
                }
            });
        }
    });
</script>
@endsection
