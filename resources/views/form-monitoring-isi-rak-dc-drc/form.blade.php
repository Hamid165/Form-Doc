@extends('layouts.app')

@section('content')
<style>
    .a4-wrapper { display: flex; justify-content: center; padding: 20px; }
    .a4-container { width: 297mm; background: white; padding: 12mm 15mm; box-sizing: border-box; box-shadow: 0 4px 15px rgba(0,0,0,0.1); font-family: Arial, sans-serif; font-size: 11px; color: #000; position: relative; margin-bottom: 20px; }
    .kop-table { width: 100%; border-collapse: collapse; font-size: 11px; }
    .kop-table td { border: 1px solid #000; padding: 4px 6px; vertical-align: middle; }
    .form-input-line { width: 100%; border: none; border-bottom: 1px solid black; outline: none; background: transparent; font-family: inherit; font-size: inherit; padding: 2px 4px; box-sizing: border-box; }
    .form-input-line:focus { background-color: #f0f8ff; border-bottom: 1px solid #00a4e4; }
    .form-input-line::placeholder { color: #9ca3af; font-style: italic; }
    .table-input { width: 100%; border: none; outline: none; background: transparent; font-family: inherit; font-size: 10px; text-align: center; padding: 2px; }
    .table-input-left { text-align: left; }
    .data-table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 10px; text-align: center; }
    .data-table th, .data-table td { border: 1px solid #000; padding: 3px 2px; position: relative; vertical-align: middle; }
    .data-table th { background-color: #7b94b0; color: #000; font-weight: bold; }
    .btn-submit { background-color: #16a34a; color: white; padding: 6px 18px; height: 38px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 13px; transition: background 0.2s; }
    .btn-cancel { background-color: #ef4444; color: white; padding: 6px 18px; height: 38px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 13px; margin-right: 10px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; }
    .btn-tambah-baris { display: inline-flex; height: 32px; padding: 4px 12px; background-color: #f59e0b; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 11px; align-items: center; gap: 4px; }
    .btn-delete-row { position: absolute; right: -28px; top: 50%; transform: translateY(-50%); background-color: #fef2f2; border: none; color: #dc2626; cursor: pointer; padding: 4px; border-radius: 4px; display: flex; align-items: center; justify-content: center; }
</style>

<div class="a4-wrapper" style="flex-direction: column; align-items: center;">
    <form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="mainForm" style="width: 100%; display: flex; flex-direction: column; align-items: center;"
          x-data="{
              items: {{ json_encode(old('items', isset($form) && $form->items->count() > 0 ? $form->items->toArray() : array_fill(0, 15, ['cable'=>'', 'pp'=>'', 'id_machine'=>'', 'id_server_name_server'=>'', 'pic'=>'', 'nic'=>'', 'power_a'=>'', 'weight_kg'=>'', 'capacity_storage_gb'=>'', 'capacity_memory_gb'=>'', 'ip_address_local'=>'', 'ip_address_public'=>'', 'status'=>'', 'note'=>'']))) }},
              addRow() {
                  this.items.push({
                      cable: '', pp: '', id_machine: '', id_server_name_server: '', pic: '', nic: '', power_a: '', weight_kg: '', capacity_storage_gb: '', capacity_memory_gb: '', ip_address_local: '', ip_address_public: '', status: '', note: ''
                  });
              },
              removeRow(index) {
                  if (this.items.length > 1) {
                      this.items.splice(index, 1);
                  }
              }
          }">
        @csrf
        @if(isset($method) && $method === 'PUT') @method('PUT') @endif

        <datalist id="signer-list">
            @if(isset($masterSigners))
                @foreach($masterSigners as $ms)
                    <option value="{{ $ms->nama }}" data-nipp="{{ $ms->nipp }}">{{ $ms->jabatan }}</option>
                @endforeach
            @endif
        </datalist>

        <div style="width: 297mm; margin-bottom: 20px;">
            <a href="{{ route('form-monitoring-isi-rak-dc-drc.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Formulir
            </a>
        </div>

        <div style="zoom: 1.0;">
            <div class="a4-container">
                <!-- Header Kop Table -->
                <table class="kop-table">
                    <tr>
                        <td rowspan="2" style="width: 18%; text-align: center; vertical-align: middle;">
                            <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI" style="width: 100%; max-width: 90px; height: auto; display: block; margin: 0 auto 6px auto;">
                            <div style="border: 2px solid #eadc04; color: #eadc04; font-weight: bold; font-size: 11px; padding: 2px 8px; display: inline-block;">TERBATAS</div>
                        </td>
                        <td rowspan="2" style="width: 54%; text-align: center; font-weight: bold; font-size: 12px; line-height: 1.4;">
                            PT. KERETA API INDONESIA (PERSERO)<br>
                            <span style="font-size: 11px; font-weight: normal;">Sistem Informasi</span><br>
                            FORMULIR<br>
                            MONITORING ISI RAK DC / DRC
                        </td>
                        <td style="width: 10%;">Nomor</td>
                        <td style="width: 18%;">: {{ $formTemplate->no_dokumen ?? 'FR.SM/TI/015.024/10-2020' }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Terbit</td>
                        <td>: {{ $formTemplate->tanggal_dokumen ?? '12 Oktober 2020' }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border: none;"></td>
                        <td>Versi</td>
                        <td>: {{ $formTemplate->versi_dokumen ?? '002-2020' }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border: none;"></td>
                        <td>Halaman</td>
                        <td>: 1 dari 1</td>
                    </tr>
                </table>

                <!-- Header Meta Inputs (No Ref, Tanggal, Business Area) -->
                <table style="border-collapse: collapse; width: 250px; font-size: 11px; margin-top: 15px;">
                    <tr>
                        <td style="border: 1px solid black; padding: 3px 6px; width: 90px;">No Ref</td>
                        <td style="border: 1px solid black; padding: 3px 6px; width: 10px; border-right: none;">:</td>
                        <td style="border: 1px solid black; padding: 3px 6px; border-left: none;">
                            <input type="text" name="no_ref" value="{{ old('no_ref', $form->no_ref ?? '') }}" class="form-input-line" placeholder="___/___/___">
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 3px 6px;">Tanggal</td>
                        <td style="border: 1px solid black; padding: 3px 6px; border-right: none;">:</td>
                        <td style="border: 1px solid black; padding: 3px 6px; border-left: none;">
                            <input type="text" name="tanggal" value="{{ old('tanggal', isset($form->tanggal) ? \Carbon\Carbon::parse($form->tanggal)->format('Y-m-d') : '') }}" class="form-input-line custom-date-picker" placeholder="___/___/___" autocomplete="off">
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 3px 6px;">Business Area</td>
                        <td style="border: 1px solid black; padding: 3px 6px; border-right: none;">:</td>
                        <td style="border: 1px solid black; padding: 3px 6px; border-left: none;">
                            <input type="text" name="business_area" value="{{ old('business_area', $form->business_area ?? '') }}" class="form-input-line" placeholder="_______">
                        </td>
                    </tr>
                </table>

                <!-- Rack Information Meta Details -->
                <div style="font-size: 11px; margin-top: 15px; width: 350px;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 11px;">
                        <tr>
                            <td style="width: 100px; padding: 2px 0; font-weight: bold;">Nomor Rak</td>
                            <td style="width: 15px;">:</td>
                            <td><input type="text" name="nomor_rak" value="{{ old('nomor_rak', $form->nomor_rak ?? '') }}" class="form-input-line"></td>
                        </tr>
                        <tr>
                            <td style="padding: 2px 0; font-weight: bold;">Last Update</td>
                            <td>:</td>
                            <td><input type="text" name="last_update" value="{{ old('last_update', $form->last_update ?? '') }}" class="form-input-line"></td>
                        </tr>
                        <tr>
                            <td style="padding: 2px 0; font-weight: bold;">Kode Rak</td>
                            <td>:</td>
                            <td><input type="text" name="kode_rak" value="{{ old('kode_rak', $form->kode_rak ?? '') }}" class="form-input-line"></td>
                        </tr>
                        <tr>
                            <td style="padding: 2px 0; font-weight: bold;">Ukuran Rak</td>
                            <td>:</td>
                            <td><input type="text" name="ukuran_rak" value="{{ old('ukuran_rak', $form->ukuran_rak ?? '') }}" class="form-input-line"></td>
                        </tr>
                        <tr>
                            <td style="padding: 2px 0; font-weight: bold;">Lokasi</td>
                            <td>:</td>
                            <td><input type="text" name="lokasi" value="{{ old('lokasi', $form->lokasi ?? '') }}" class="form-input-line"></td>
                        </tr>
                        <tr>
                            <td style="padding: 2px 0; font-weight: bold;">Lantai</td>
                            <td>:</td>
                            <td><input type="text" name="lantai" value="{{ old('lantai', $form->lantai ?? '') }}" class="form-input-line"></td>
                        </tr>
                        <tr>
                            <td style="padding: 2px 0; font-weight: bold;">Alamat</td>
                            <td>:</td>
                            <td><input type="text" name="alamat" value="{{ old('alamat', $form->alamat ?? '') }}" class="form-input-line"></td>
                        </tr>
                    </table>
                </div>

                <!-- Main Grid Data Table -->
                <table class="data-table">
                    <thead>
                        <tr>
                            <th rowspan="2" style="width: 30px;">No</th>
                            <th rowspan="2" style="width: 65px;">Cable</th>
                            <th rowspan="2" style="width: 50px;">PP</th>
                            <th rowspan="2" style="width: 75px;">ID Machine</th>
                            <th rowspan="2" style="width: 120px;">ID Server/Name Server</th>
                            <th rowspan="2" style="width: 65px;">PIC</th>
                            <th rowspan="2" style="width: 55px;">NIC</th>
                            <th rowspan="2" style="width: 60px;">Power (A)</th>
                            <th rowspan="2" style="width: 65px;">Weight (kg)</th>
                            <th colspan="2">Capacity</th>
                            <th colspan="2">IP Addres</th>
                            <th rowspan="2" style="width: 70px;">Status</th>
                            <th rowspan="2">Note</th>
                        </tr>
                        <tr>
                            <th style="width: 65px;">Storage (GB)</th>
                            <th style="width: 65px;">Memory (GB)</th>
                            <th style="width: 80px;">local</th>
                            <th style="width: 80px;">Public</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(item, index) in items" :key="index">
                            <tr>
                                <td x-text="index + 1" style="font-weight: bold; background: #f9fafb;"></td>
                                <td>
                                    <input type="hidden" :name="'items[' + index + '][no]'" :value="index + 1">
                                    <input type="text" :name="'items[' + index + '][cable]'" x-model="item.cable" class="table-input">
                                </td>
                                <td><input type="text" :name="'items[' + index + '][pp]'" x-model="item.pp" class="table-input"></td>
                                <td><input type="text" :name="'items[' + index + '][id_machine]'" x-model="item.id_machine" class="table-input"></td>
                                <td><input type="text" :name="'items[' + index + '][id_server_name_server]'" x-model="item.id_server_name_server" class="table-input table-input-left"></td>
                                <td><input type="text" :name="'items[' + index + '][pic]'" x-model="item.pic" class="table-input"></td>
                                <td><input type="text" :name="'items[' + index + '][nic]'" x-model="item.nic" class="table-input"></td>
                                <td><input type="text" :name="'items[' + index + '][power_a]'" x-model="item.power_a" class="table-input"></td>
                                <td><input type="text" :name="'items[' + index + '][weight_kg]'" x-model="item.weight_kg" class="table-input"></td>
                                <td><input type="text" :name="'items[' + index + '][capacity_storage_gb]'" x-model="item.capacity_storage_gb" class="table-input"></td>
                                <td><input type="text" :name="'items[' + index + '][capacity_memory_gb]'" x-model="item.capacity_memory_gb" class="table-input"></td>
                                <td><input type="text" :name="'items[' + index + '][ip_address_local]'" x-model="item.ip_address_local" class="table-input"></td>
                                <td><input type="text" :name="'items[' + index + '][ip_address_public]'" x-model="item.ip_address_public" class="table-input"></td>
                                <td><input type="text" :name="'items[' + index + '][status]'" x-model="item.status" class="table-input"></td>
                                <td>
                                    <input type="text" :name="'items[' + index + '][note]'" x-model="item.note" class="table-input table-input-left">
                                    <button type="button" @click="removeRow(index)" class="btn-delete-row" title="Hapus Baris" x-show="items.length > 1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>

                <div style="margin-top: 10px;">
                    <button type="button" @click="addRow()" class="btn-tambah-baris">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Baris
                    </button>
                </div>

                <!-- Footer Signatures -->
                <div style="margin-top: 40px; display: flex; justify-content: flex-end;">
                    <div style="width: 250px; text-align: center; font-size: 11px;">
                        <div style="font-weight: bold; margin-bottom: 60px;">Mengetahui</div>
                        <div>
                            <input type="text" name="mengetahui_nama" value="{{ old('mengetahui_nama', $form->mengetahui_nama ?? '') }}" list="signer-list" class="form-input-line" style="text-align: center;" placeholder="Nama Mengetahui">
                        </div>
                        <div style="margin-top: 4px;">
                            NIPP. <input type="text" name="mengetahui_nipp" value="{{ old('mengetahui_nipp', $form->mengetahui_nipp ?? '') }}" class="form-input-line" style="width: 140px; text-align: center;" placeholder="...................">
                        </div>
                    </div>
                </div>

            </div>

            <!-- Form Action Buttons -->
            <div style="margin-top: 20px; display: flex; justify-content: flex-end; padding-bottom: 40px;">
                <a href="{{ route('form-monitoring-isi-rak-dc-drc.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">
                    {{ isset($method) && $method === 'PUT' ? 'Perbarui Formulir' : 'Simpan Formulir' }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
