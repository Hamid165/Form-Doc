@php
    $form = $form_apar ?? null;
    $actionUrl = $isEdit
        ? route('form-apar.update', $form)
        : route('form-apar.store');
    $method = $isEdit ? 'PUT' : 'POST';
@endphp

@if ($errors->any())
<div class="mb-6 bg-[#fef2f2] border border-[#fecaca] rounded-xl p-4 shadow-sm">
    <h4 class="text-sm font-bold text-red-700 mb-2">Terdapat kesalahan pada form:</h4>
    <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ $actionUrl }}" id="apar-form">
    @csrf
    @method($method)

    {{-- SECTION 1: Informasi Formulir --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
        <h2 class="text-base font-bold text-gray-800 mb-5 flex items-center gap-2">
            <span class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xs font-bold">1</span>
            Informasi Formulir
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">No. Referensi</label>
                <input type="text" name="no_ref" value="{{ old('no_ref', $form->no_ref ?? '') }}"
                       placeholder="Contoh: 001/APAR/VII/2026"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Pengecekan</label>
                <input type="date" name="tanggal" id="tanggal"
                       value="{{ old('tanggal', $form && $form->tanggal ? $form->tanggal->format('Y-m-d') : '') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Business Area</label>
                <div class="flex items-center gap-2">
                    <input type="text" id="business_area_input" name="business_area"
                           value="{{ old('business_area', $form->business_area ?? 'B060') }}"
                           class="w-full border border-gray-200 bg-gray-50 rounded-lg px-3 py-2 text-sm text-gray-500 focus:outline-none"
                           style="pointer-events: none;" readonly>
                    <button type="button" onclick="unlockBusinessArea()" title="Edit Business Area"
                            class="shrink-0 p-2 text-gray-400 hover:text-blue-600 border border-gray-200 rounded-lg hover:border-blue-400 transition-colors bg-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </button>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Bulan Pemantauan</label>
                <input type="text" name="bulan" value="{{ old('bulan', $form->bulan ?? '') }}"
                       placeholder="Contoh: Juli 2026"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
    </div>

    {{-- SECTION 2: Petugas & Penandatangan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
        <h2 class="text-base font-bold text-gray-800 mb-5 flex items-center gap-2">
            <span class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xs font-bold">2</span>
            Petugas & Penandatangan
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Petugas</label>
                <input type="text" name="petugas_name" value="{{ old('petugas_name', $form->petugas_name ?? '') }}"
                       placeholder="Nama lengkap petugas pelaksana"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">NIPP Petugas</label>
                <input type="text" name="petugas_nipp" value="{{ old('petugas_nipp', $form->petugas_nipp ?? '') }}"
                       placeholder="NIPP Petugas"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Mengetahui (Pejabat 1 - Halaman Depan)</label>
                <select name="mengetahui_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                    <option value="">-- Pilih Pejabat 1 --</option>
                    @foreach ($masterSigners as $signer)
                        <option value="{{ $signer->id }}" @selected(old('mengetahui_id', $form->mengetahui_id ?? '') == $signer->id)>
                            {{ $signer->nama }} — {{ $signer->jabatan }} (NIPP: {{ $signer->nipp }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Mengetahui (Pejabat 2 - Halaman Belakang)</label>
                <select name="mengetahui_2_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                    <option value="">-- Pilih Pejabat 2 --</option>
                    @foreach ($masterSigners as $signer)
                        <option value="{{ $signer->id }}" @selected(old('mengetahui_2_id', $form->mengetahui_2_id ?? '') == $signer->id)>
                            {{ $signer->nama }} — {{ $signer->jabatan }} (NIPP: {{ $signer->nipp }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- SECTION 3: Detail Item Pemantauan APAR --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
        <h2 class="text-base font-bold text-gray-800 mb-5 flex items-center gap-2">
            <span class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xs font-bold">3</span>
            Detail Pengecekan Unit APAR
        </h2>

        <div class="overflow-x-auto pb-4">
            <div id="items-container" class="space-y-4 min-w-[700px]">
            @if ($isEdit && $form->items->count() > 0)
                @foreach ($form->items as $idx => $item)
                <div class="item-row border border-gray-200 rounded-xl p-4 relative bg-gray-50">
                    <button type="button" onclick="removeRow(this)" style="right: 12px; top: 12px;" class="absolute text-red-400 hover:text-red-600 transition-colors" title="Hapus Item">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pr-6">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Kode / ID Aset APAR <span class="text-red-500">*</span></label>
                            <select name="items[{{ $idx }}][master_apar_id]" class="apar-select w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                <option value="">-- Pilih Aset APAR --</option>
                                @foreach ($masterApars as $apar)
                                    <option value="{{ $apar->id }}" @selected($item->master_apar_id == $apar->id)>
                                        {{ $apar->kode_aset }} @if($apar->lokasi) ({{ $apar->lokasi }}) @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Merk / Tipe</label>
                            <input type="text" class="merk-tipe w-full border border-gray-200 bg-gray-100 text-gray-500 rounded-lg px-3 py-2 text-sm" style="pointer-events:none;" readonly 
                                   value="{{ $item->apar ? ($item->apar->merk . ' / ' . $item->apar->tipe) : '' }}">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Media / Kapasitas</label>
                            <input type="text" class="media-kapasitas w-full border border-gray-200 bg-gray-100 text-gray-500 rounded-lg px-3 py-2 text-sm" style="pointer-events:none;" readonly 
                                   value="{{ $item->apar ? ($item->apar->media . ' / ' . $item->apar->kapasitas) : '' }}">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Lokasi</label>
                            <input type="text" class="lokasi-apar w-full border border-gray-200 bg-gray-100 text-gray-500 rounded-lg px-3 py-2 text-sm" style="pointer-events:none;" readonly 
                                   value="{{ $item->apar ? $item->apar->lokasi : '' }}">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Tgl Isi Ulang / Kadaluarsa</label>
                            <input type="text" class="tgl-isi-kadaluarsa w-full border border-gray-200 bg-gray-100 text-gray-500 rounded-lg px-3 py-2 text-sm" style="pointer-events:none;" readonly 
                                   value="{{ $item->apar ? (($item->apar->tanggal_isi_ulang ? $item->apar->tanggal_isi_ulang->format('d/m/Y') : '-') . ' / ' . ($item->apar->tanggal_kadaluarsa ? $item->apar->tanggal_kadaluarsa->format('d/m/Y') : '-')) : '' }}">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Waktu Pengecekan</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="date" name="items[{{ $idx }}][waktu_pengecekan_tgl]" value="{{ $item->waktu_pengecekan_tgl ? $item->waktu_pengecekan_tgl->format('Y-m-d') : '' }}" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <input type="text" name="items[{{ $idx }}][waktu_pengecekan_jam]" value="{{ $item->waktu_pengecekan_jam ?? '' }}" placeholder="09:00" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Indikator Tekanan Gas</label>
                            <select name="items[{{ $idx }}][indikator_tekanan]" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                <option value="">-- Pilih Indikator --</option>
                                <option value="Hijau" @selected($item->indikator_tekanan === 'Hijau')>Hijau (Kondisi Baik)</option>
                                <option value="Merah" @selected($item->indikator_tekanan === 'Merah')>Merah (Kondisi Kurang Baik)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Perlakuan Fisik</label>
                            <input type="text" name="items[{{ $idx }}][perlakuan_fisik]" value="{{ $item->perlakuan_fisik ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g. Terawat, tergantung di dinding">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Tindak Lanjut jika Rusak/Tidak Sesuai</label>
                            <input type="text" name="items[{{ $idx }}][tindak_lanjut]" value="{{ $item->tindak_lanjut ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g. Segera isi ulang, perbaiki gantungan">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Paraf Petugas Pengecek</label>
                            <input type="text" name="items[{{ $idx }}][paraf]" value="{{ $item->paraf ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Paraf">
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                {{-- Default 1 row kosong --}}
                <div class="item-row border border-gray-200 rounded-xl p-4 relative bg-gray-50">
                    <button type="button" onclick="removeRow(this)" style="right: 12px; top: 12px;" class="absolute text-red-400 hover:text-red-600 transition-colors" title="Hapus Item">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pr-6">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Kode / ID Aset APAR <span class="text-red-500">*</span></label>
                            <select name="items[0][master_apar_id]" class="apar-select w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                <option value="">-- Pilih Aset APAR --</option>
                                @foreach ($masterApars as $apar)
                                    <option value="{{ $apar->id }}">{{ $apar->kode_aset }} @if($apar->lokasi) ({{ $apar->lokasi }}) @endif</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Merk / Tipe</label>
                            <input type="text" class="merk-tipe w-full border border-gray-200 bg-gray-100 text-gray-500 rounded-lg px-3 py-2 text-sm" style="pointer-events:none;" readonly>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Media / Kapasitas</label>
                            <input type="text" class="media-kapasitas w-full border border-gray-200 bg-gray-100 text-gray-500 rounded-lg px-3 py-2 text-sm" style="pointer-events:none;" readonly>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Lokasi</label>
                            <input type="text" class="lokasi-apar w-full border border-gray-200 bg-gray-100 text-gray-500 rounded-lg px-3 py-2 text-sm" style="pointer-events:none;" readonly>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Tgl Isi Ulang / Kadaluarsa</label>
                            <input type="text" class="tgl-isi-kadaluarsa w-full border border-gray-200 bg-gray-100 text-gray-500 rounded-lg px-3 py-2 text-sm" style="pointer-events:none;" readonly>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Waktu Pengecekan</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="date" name="items[0][waktu_pengecekan_tgl]" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <input type="text" name="items[0][waktu_pengecekan_jam]" placeholder="09:00" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Indikator Tekanan Gas</label>
                            <select name="items[0][indikator_tekanan]" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                <option value="">-- Pilih Indikator --</option>
                                <option value="Hijau">Hijau (Kondisi Baik)</option>
                                <option value="Merah">Merah (Kondisi Kurang Baik)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Perlakuan Fisik</label>
                            <input type="text" name="items[0][perlakuan_fisik]" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g. Terawat, tergantung di dinding">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Tindak Lanjut jika Rusak/Tidak Sesuai</label>
                            <input type="text" name="items[0][tindak_lanjut]" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g. Segera isi ulang, perbaiki gantungan">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Paraf Petugas Pengecek</label>
                            <input type="text" name="items[0][paraf]" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Paraf">
                        </div>
                    </div>
                </div>
            @endif
            </div>
        </div>

        <button type="button" onclick="addRow()" class="mt-4 inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800 border border-blue-300 hover:border-blue-500 px-4 py-2 rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Baris APAR
        </button>

        <div class="mt-6 pt-6 border-t border-gray-200">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Catatan</label>
            <textarea name="catatan" rows="2" placeholder="Catatan mengenai pelaksanaan pengecekan APAR, jika ada"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('catatan', $form->catatan ?? '') }}</textarea>
        </div>
    </div>

    {{-- Submit --}}
    <div class="flex justify-end gap-3">
        <a href="{{ route('form-apar.index') }}" class="px-5 py-2.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors font-medium text-gray-700">Batal</a>
        <button type="submit" class="px-5 py-2.5 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-semibold shadow-sm">
            {{ $isEdit ? 'Perbarui Formulir' : 'Simpan Formulir' }}
        </button>
    </div>
</form>

@section('scripts')
<script>
    // Data APAR untuk auto-fill
    const aparData = @json($masterApars->keyBy('id'));
    let rowIndex = {{ $isEdit && $form->items->count() > 0 ? $form->items->count() : 1 }};

    function formatDate(dateStr) {
        if (!dateStr) return '-';
        // handle format YYYY-MM-DD
        const parts = dateStr.split('T')[0].split('-');
        if (parts.length === 3) {
            return `${parts[2]}/${parts[1]}/${parts[0]}`;
        }
        return dateStr;
    }

    function getRowTemplate(idx) {
        const options = Object.values(aparData).map(a =>
            `<option value="${a.id}">${a.kode_aset} ${a.lokasi ? '(' + a.lokasi + ')' : ''}</option>`
        ).join('');
        return `
        <div class="item-row border border-gray-200 rounded-xl p-4 relative bg-gray-50">
            <button type="button" onclick="removeRow(this)" style="right: 12px; top: 12px;" class="absolute text-red-400 hover:text-red-600 transition-colors" title="Hapus Item">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pr-6">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Kode / ID Aset APAR <span class="text-red-500">*</span></label>
                    <select name="items[${idx}][master_apar_id]" class="apar-select w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                        <option value="">-- Pilih Aset APAR --</option>${options}
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Merk / Tipe</label>
                    <input type="text" class="merk-tipe w-full border border-gray-200 bg-gray-100 text-gray-500 rounded-lg px-3 py-2 text-sm" style="pointer-events:none;" readonly>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Media / Kapasitas</label>
                    <input type="text" class="media-kapasitas w-full border border-gray-200 bg-gray-100 text-gray-500 rounded-lg px-3 py-2 text-sm" style="pointer-events:none;" readonly>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Lokasi</label>
                    <input type="text" class="lokasi-apar w-full border border-gray-200 bg-gray-100 text-gray-500 rounded-lg px-3 py-2 text-sm" style="pointer-events:none;" readonly>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Tgl Isi Ulang / Kadaluarsa</label>
                    <input type="text" class="tgl-isi-kadaluarsa w-full border border-gray-200 bg-gray-100 text-gray-500 rounded-lg px-3 py-2 text-sm" style="pointer-events:none;" readonly>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Waktu Pengecekan</label>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="date" name="items[${idx}][waktu_pengecekan_tgl]" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <input type="text" name="items[${idx}][waktu_pengecekan_jam]" placeholder="09:00" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Indikator Tekanan Gas</label>
                    <select name="items[${idx}][indikator_tekanan]" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                        <option value="">-- Pilih Indikator --</option>
                        <option value="Hijau">Hijau (Kondisi Baik)</option>
                        <option value="Merah">Merah (Kondisi Kurang Baik)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Perlakuan Fisik</label>
                    <input type="text" name="items[${idx}][perlakuan_fisik]" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g. Terawat, tergantung di dinding">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Tindak Lanjut jika Rusak/Tidak Sesuai</label>
                    <input type="text" name="items[${idx}][tindak_lanjut]" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g. Segera isi ulang, perbaiki gantungan">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Paraf Petugas Pengecek</label>
                    <input type="text" name="items[${idx}][paraf]" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Paraf">
                </div>
            </div>
        </div>`;
    }

    function addRow() {
        const container = document.getElementById('items-container');
        const wrapper = document.createElement('div');
        wrapper.innerHTML = getRowTemplate(rowIndex++);
        const newRow = wrapper.firstElementChild;
        container.appendChild(newRow);
        bindSelectListener(newRow.querySelector('.apar-select'));
        
        // Auto set check date to today's date for ease of use
        const dateInput = newRow.querySelector('input[type="date"]');
        if (dateInput) {
            const today = new Date().toISOString().split('T')[0];
            dateInput.value = today;
        }
    }

    function removeRow(btn) {
        const row = btn.closest('.item-row');
        const container = document.getElementById('items-container');
        if (container.querySelectorAll('.item-row').length > 1) {
            row.remove();
        }
    }

    function bindSelectListener(select) {
        select.addEventListener('change', function() {
            const row = this.closest('.item-row');
            const merkTipeInput = row.querySelector('.merk-tipe');
            const mediaKapasitasInput = row.querySelector('.media-kapasitas');
            const lokasiInput = row.querySelector('.lokasi-apar');
            const tglIsiKadaluarsaInput = row.querySelector('.tgl-isi-kadaluarsa');
            
            const apar = aparData[this.value];
            if (apar) {
                merkTipeInput.value = (apar.merk || '') + ' / ' + (apar.tipe || '');
                mediaKapasitasInput.value = (apar.media || '') + ' / ' + (apar.kapasitas || '');
                lokasiInput.value = apar.lokasi || '';
                
                const refillDate = formatCarbonDate(apar.tanggal_isi_ulang);
                const expiryDate = formatCarbonDate(apar.tanggal_kadaluarsa);
                tglIsiKadaluarsaInput.value = refillDate + ' / ' + expiryDate;
            } else {
                merkTipeInput.value = '';
                mediaKapasitasInput.value = '';
                lokasiInput.value = '';
                tglIsiKadaluarsaInput.value = '';
            }
        });
    }

    function formatCarbonDate(dateObj) {
        if (!dateObj) return '-';
        if (typeof dateObj === 'string') {
            return formatDate(dateObj);
        }
        // if dateObj is carbon format
        if (dateObj.date) {
            return formatDate(dateObj.date);
        }
        return '-';
    }

    // Bind all existing selects
    document.querySelectorAll('.apar-select').forEach(bindSelectListener);

    function unlockBusinessArea() {
        var input = document.getElementById('business_area_input');
        if (input.hasAttribute('readonly')) {
            input.removeAttribute('readonly');
            input.style.pointerEvents = 'auto';
            input.style.background = 'transparent';
            input.className = input.className.replace('bg-gray-50 text-gray-500', 'bg-white text-gray-800');
            input.classList.add('border-blue-400', 'ring-2', 'ring-blue-200');
            input.focus();
        } else {
            input.setAttribute('readonly', 'readonly');
            input.style.pointerEvents = 'none';
            input.style.background = '#f9fafb';
        }
    }
    
    // Set default date for first row on create
    @if(!$isEdit)
        document.querySelectorAll('.item-row input[type="date"]').forEach(input => {
            if (!input.value) {
                input.value = new Date().toISOString().split('T')[0];
            }
        });
        
        // Auto set main date to today
        const mainDate = document.getElementById('tanggal');
        if (mainDate && !mainDate.value) {
            mainDate.value = new Date().toISOString().split('T')[0];
        }
    @endif
</script>
@endsection
