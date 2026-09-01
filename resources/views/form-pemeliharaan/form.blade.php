@php
    $form = $form_pemeliharaan ?? null;
    $actionUrl = $isEdit
        ? route('form-pemeliharaan.update', $form)
        : route('form-pemeliharaan.store');
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

<form method="POST" action="{{ $actionUrl }}" id="pemeliharaan-form">
    @csrf
    @method($method)

    {{-- SECTION: Header Informasi --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
        <h2 class="text-base font-bold text-gray-800 mb-5 flex items-center gap-2">
            <span class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xs font-bold">1</span>
            Informasi Formulir
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">No. Referensi</label>
                <input type="text" name="no_ref" value="{{ old('no_ref', $form->no_ref ?? '') }}"
                       placeholder="Contoh: 001/MAINT/VII/2026"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal"
                       value="{{ old('tanggal', $form && $form->tanggal ? $form->tanggal->format('Y-m-d') : '') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Business Area</label>
                <div class="flex items-center gap-2">
                    <input type="text" id="business_area_input" name="business_area"
                           value="{{ old('business_area', $form->business_area ?? 'DAOP 6 Yogyakarta') }}"
                           class="w-full border border-gray-200 bg-gray-50 rounded-lg px-3 py-2 text-sm text-gray-500 focus:outline-none"
                           style="pointer-events: none;" readonly>
                    <button type="button" onclick="unlockBusinessArea()" title="Edit Business Area"
                            class="shrink-0 p-2 text-gray-400 hover:text-blue-600 border border-gray-200 rounded-lg hover:border-blue-400 transition-colors bg-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </button>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Lokasi</label>
                <input type="text" name="lokasi" value="{{ old('lokasi', $form->lokasi ?? '') }}"
                       placeholder="Contoh: Stasiun Tugu Yogyakarta"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Pemeliharaan</label>
                <select name="jenis_pemeliharaan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                    <option value="">-- Pilih Jenis --</option>
                    <option value="Terencana" @selected(old('jenis_pemeliharaan', $form->jenis_pemeliharaan ?? '') === 'Terencana')>Terencana</option>
                    <option value="Tak Terencana" @selected(old('jenis_pemeliharaan', $form->jenis_pemeliharaan ?? '') === 'Tak Terencana')>Tak Terencana</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Bulan Pemeliharaan</label>
                <input type="text" name="bulan_pemeliharaan" value="{{ old('bulan_pemeliharaan', $form->bulan_pemeliharaan ?? '') }}"
                       placeholder="Contoh: Juli 2026"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
    </div>

    {{-- SECTION: Petugas & Penandatangan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
        <h2 class="text-base font-bold text-gray-800 mb-5 flex items-center gap-2">
            <span class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xs font-bold">2</span>
            Petugas & Penandatangan
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Petugas</label>
                <input type="text" name="petugas_name" value="{{ old('petugas_name', $form->petugas_name ?? '') }}"
                       placeholder="Nama lengkap petugas"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">NIPP Petugas</label>
                <input type="text" name="petugas_nipp" value="{{ old('petugas_nipp', $form->petugas_nipp ?? '') }}"
                       placeholder="Nomor Induk Pegawai"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Mengetahui (Pejabat)</label>
                <select name="mengetahui_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                    <option value="">-- Pilih Pejabat --</option>
                    @foreach ($masterSigners as $signer)
                        <option value="{{ $signer->id }}" @selected(old('mengetahui_id', $form->mengetahui_id ?? '') == $signer->id)>
                            {{ $signer->nama }} — {{ $signer->jabatan }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- SECTION: Detail Item Pemeliharaan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
        <h2 class="text-base font-bold text-gray-800 mb-5 flex items-center gap-2">
            <span class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xs font-bold">3</span>
            Detail Item Pemeliharaan
        </h2>

        <div class="overflow-x-auto pb-4">
            <div id="items-container" class="space-y-4 min-w-[700px]">
            @if ($isEdit && $form->items->count() > 0)
                @foreach ($form->items as $idx => $item)
                <div class="item-row border border-gray-200 rounded-xl p-4 relative bg-gray-50">
                    <button type="button" onclick="removeRow(this)" style="right: 12px; top: 12px;" class="absolute text-red-400 hover:text-red-600 transition-colors" title="Hapus Item">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pr-6">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Perangkat</label>
                            <select name="items[{{ $idx }}][master_perangkat_id]" class="perangkat-select w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                <option value="">-- Pilih Perangkat --</option>
                                @foreach ($masterPerangkats as $p)
                                    <option value="{{ $p->id }}" @selected($item->master_perangkat_id == $p->id)>
                                        {{ $p->kode_aset }} — {{ $p->jenis_perangkat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi Perangkat</label>
                            <input type="text" name="items[{{ $idx }}][deskripsi]" value="{{ $item->deskripsi ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Spesifikasi / deskripsi perangkat">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Pekerjaan</label>
                            <input type="text" name="items[{{ $idx }}][pekerjaan]" value="{{ $item->pekerjaan }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Uraian pekerjaan">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Permasalahan</label>
                            <input type="text" name="items[{{ $idx }}][permasalahan]" value="{{ $item->permasalahan }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Permasalahan ditemukan">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Solusi</label>
                            <input type="text" name="items[{{ $idx }}][solusi]" value="{{ $item->solusi }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Solusi yang diterapkan">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Keterangan</label>
                            <input type="text" name="items[{{ $idx }}][keterangan]" value="{{ $item->keterangan }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Keterangan tambahan">
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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pr-6">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Perangkat</label>
                            <select name="items[0][master_perangkat_id]" class="perangkat-select w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                <option value="">-- Pilih Perangkat --</option>
                                @foreach ($masterPerangkats as $p)
                                    <option value="{{ $p->id }}">{{ $p->kode_aset }} — {{ $p->jenis_perangkat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi Perangkat</label>
                            <input type="text" name="items[0][deskripsi]" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Spesifikasi / deskripsi perangkat">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Pekerjaan</label>
                            <input type="text" name="items[0][pekerjaan]" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Uraian pekerjaan">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Permasalahan</label>
                            <input type="text" name="items[0][permasalahan]" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Permasalahan ditemukan">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Solusi</label>
                            <input type="text" name="items[0][solusi]" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Solusi yang diterapkan">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Keterangan</label>
                            <input type="text" name="items[0][keterangan]" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Keterangan tambahan">
                        </div>
                    </div>
                </div>
            @endif
            </div>
        </div>

        <button type="button" onclick="addRow()" class="mt-4 inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800 border border-blue-300 hover:border-blue-500 px-4 py-2 rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Item
        </button>

        <div class="mt-6 pt-6 border-t border-gray-200">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Catatan</label>
            <textarea name="catatan" rows="2" placeholder="Catatan mengenai pelaksanaan pemeliharaan perangkat jaringan, jika ada"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('catatan', $form->catatan ?? '') }}</textarea>
        </div>
    </div>

    {{-- Submit --}}
    <div class="flex justify-end gap-3">
        <a href="{{ route('form-pemeliharaan.index') }}" class="px-5 py-2.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors font-medium text-gray-700">Batal</a>
        <button type="submit" class="px-5 py-2.5 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-semibold shadow-sm">
            {{ $isEdit ? 'Perbarui Formulir' : 'Simpan Formulir' }}
        </button>
    </div>
</form>

@section('scripts')
<script>
    // Daftar perangkat untuk auto-fill
    const perangkatData = @json($masterPerangkats->keyBy('id'));
    let rowIndex = {{ $isEdit && $form->items->count() > 0 ? $form->items->count() : 1 }};

    function getRowTemplate(idx) {
        const options = Object.values(perangkatData).map(p =>
            `<option value="${p.id}">${p.kode_aset} — ${p.jenis_perangkat}</option>`
        ).join('');
        return `
        <div class="item-row border border-gray-200 rounded-xl p-4 relative bg-gray-50">
            <button type="button" onclick="removeRow(this)" style="right: 12px; top: 12px;" class="absolute text-red-400 hover:text-red-600 transition-colors" title="Hapus Item">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pr-6">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Perangkat</label>
                    <select name="items[${idx}][master_perangkat_id]" class="perangkat-select w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                        <option value="">-- Pilih Perangkat --</option>${options}
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi Perangkat</label>
                    <input type="text" name="items[${idx}][deskripsi]" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Spesifikasi / deskripsi perangkat">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Pekerjaan</label>
                    <input type="text" name="items[${idx}][pekerjaan]" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Uraian pekerjaan">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Permasalahan</label>
                    <input type="text" name="items[${idx}][permasalahan]" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Permasalahan ditemukan">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Solusi</label>
                    <input type="text" name="items[${idx}][solusi]" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Solusi yang diterapkan">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Keterangan</label>
                    <input type="text" name="items[${idx}][keterangan]" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Keterangan tambahan">
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
        bindSelectListener(newRow.querySelector('.perangkat-select'));
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
            const jenisInput = row.querySelector('.jenis-perangkat');
            const perangkat = perangkatData[this.value];
            jenisInput.value = perangkat ? perangkat.jenis_perangkat : '';
        });
    }

    // Bind all existing selects
    document.querySelectorAll('.perangkat-select').forEach(bindSelectListener);

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
</script>
@endsection
