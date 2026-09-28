@extends('layouts.app')

@section('title', 'Formulir Checklist Pemantauan APAR')

@section('content')

{{-- Alert Success --}}
@if (session('success'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
     class="mb-6 bg-[#f0fdf4] border border-[#bbf7d0] rounded-xl flex items-center p-3 relative shadow-sm">
    <div class="w-10 h-10 bg-[#dcfce7] rounded-lg flex items-center justify-center shrink-0 mr-4">
        <svg class="w-5 h-5 text-[#059669]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </div>
    <div class="flex flex-col">
        <h4 class="text-sm font-bold text-[#065f46] mb-0.5">Berhasil!</h4>
        <p class="text-[13px] font-medium text-[#059669]">{{ session('success') }}</p>
    </div>
    <button @click="show = false" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#10b981] hover:text-[#047857] transition-colors p-1 rounded-md hover:bg-[#dcfce7]">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>
@endif

@if ($errors->any() || session('error'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
     class="mb-6 bg-[#fef2f2] border border-[#fecaca] rounded-xl flex items-center p-3 relative shadow-sm">
    <div class="w-10 h-10 bg-[#fee2e2] rounded-lg flex items-center justify-center shrink-0 mr-4">
        <svg class="w-5 h-5 text-[#dc2626]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </div>
    <div class="flex flex-col">
        <h4 class="text-sm font-bold text-[#991b1b] mb-0.5">Gagal!</h4>
        <p class="text-[13px] font-medium text-[#dc2626]">{{ session('error') ?? $errors->first() }}</p>
    </div>
    <button @click="show = false" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#f87171] hover:text-[#dc2626] transition-colors p-1 rounded-md hover:bg-[#fee2e2]">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>
@endif

{{-- Breadcrumb --}}
<div class="mb-4">
    <a href="{{ route('formulir.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Katalog
    </a>
</div>

{{-- Main Card --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 flex flex-col min-h-[500px] mb-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-8 px-2">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-red-100 rounded-xl flex items-center justify-center shadow-sm shrink-0">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">FORMULIR CHECKLIST PEMANTAUAN APAR</h1>
                <p class="text-sm text-gray-500 mt-1">Daftar semua formulir checklist pemantauan APAR</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2" x-data="{
            searchQuery: '{{ request('search') }}',
            timeout: null,
            performSearch() {
                clearTimeout(this.timeout);
                this.timeout = setTimeout(() => {
                    window.location.href = '{{ route('form-apar.index') }}?search=' + encodeURIComponent(this.searchQuery);
                }, 400);
            }
        }">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" x-model="searchQuery" @input="performSearch()" placeholder="Cari formulir..."
                       class="pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-56">
            </div>
            <a href="{{ route('form-apar.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Formulir
            </a>
        </div>
    </div>

    <div x-data="{ 
        tab: new URLSearchParams(window.location.search).get('tab') || localStorage.getItem('active_tab') || '{{ request('tab', 'forms') }}',
        init() {
            this.$watch('tab', value => {
                localStorage.setItem('active_tab', value);
                const url = new URL(window.location.href);
                url.searchParams.set('tab', value);
                window.history.replaceState({}, '', url);
            });
            const queryTab = new URLSearchParams(window.location.search).get('tab');
            if (queryTab) {
                localStorage.setItem('active_tab', queryTab);
            }
        }
    }" class="flex-1">
        <div class="flex flex-wrap gap-1 bg-gray-100 rounded-xl p-1 mb-6 w-fit">
            <button @click="tab = 'forms'" :class="tab === 'forms' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">Daftar Formulir</button>
            <button @click="tab = 'apar'" :class="tab === 'apar' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">Master APAR</button>
            <button @click="tab = 'vendor'" :class="tab === 'vendor' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">Vendor</button>
            <button @click="tab = 'history'" :class="tab === 'history' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">History</button>
            <button @click="tab = 'signer'" :class="tab === 'signer' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">Data Penandatangan</button>
        </div>

        {{-- TAB: Daftar Formulir --}}
        <div x-show="tab === 'forms'">
            @if ($forms->isEmpty())
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-1">Belum ada formulir</h3>
                    <p class="text-sm text-gray-400">Klik "Buat Formulir" untuk memulai</p>
                </div>
            @else
                <div class="overflow-x-auto rounded-xl border border-gray-200">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-4 py-3 text-left font-semibold text-gray-600 w-10">No</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">No. Referensi</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Bulan</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Petugas</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($forms as $index => $form)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-400">{{ $forms->firstItem() + $index }}</td>
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $form->no_ref ?: '-' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $form->tanggal ? $form->tanggal->translatedFormat('d M Y') : '-' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $form->bulan ?: '-' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $form->petugas_name ?: '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $form->status_badge }}">
                                        {{ $form->status_label }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('form-apar.show', $form) }}" class="text-blue-600 hover:text-blue-800 transition-colors" title="Lihat">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        <a href="{{ route('form-apar.edit', $form) }}" class="text-yellow-600 hover:text-yellow-800 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <button onclick="printForm('{{ route('form-apar.show', $form) }}')" class="text-green-600 hover:text-green-800 transition-colors focus:outline-none" title="Print">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        </button>

                                        @if ($form->isDicetak())
                                        <form method="POST" action="{{ route('form-apar.confirm', $form) }}" class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="text-purple-600 hover:text-purple-800 transition-colors" title="Konfirmasi Selesai">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </button>
                                        </form>
                                        @endif
                                        <form method="POST" action="{{ route('form-apar.destroy', $form) }}" class="inline"
                                              onsubmit="return confirm('Hapus formulir ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition-colors" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $forms->appends(['tab' => 'forms'])->links() }}</div>
            @endif
        </div>

        {{-- TAB: Master APAR --}}
        <div x-show="tab === 'apar'" x-data="{
            subtab: '{{ request('subtab', 'aktif') }}',
            showAddModal: false,
            editItem: null,
            showEditModal: false,
            replaceItem: null,
            showReplaceModal: false,
            reactivateItem: null,
            showReactivateModal: false,
            showImportModal: false,
        }">
            {{-- Sub-tab Switcher --}}
            <div class="flex border-b border-gray-200 mb-6">
                <button @click="subtab = 'aktif'; const url = new URL(window.location); url.searchParams.set('subtab', 'aktif'); window.history.replaceState({}, '', url);"
                        :class="subtab === 'aktif' ? 'border-b-2 border-blue-600 text-blue-600 font-bold' : 'text-gray-500 hover:text-gray-700'"
                        class="px-4 py-2 text-sm font-semibold transition-all focus:outline-none">
                    APAR Aktif
                </button>
                <button @click="subtab = 'nonactive'; const url = new URL(window.location); url.searchParams.set('subtab', 'nonactive'); window.history.replaceState({}, '', url);"
                        :class="subtab === 'nonactive' ? 'border-b-2 border-blue-600 text-blue-600 font-bold' : 'text-gray-500 hover:text-gray-700'"
                        class="px-4 py-2 text-sm font-semibold transition-all focus:outline-none">
                    APAR Non Aktif
                </button>
            </div>

            {{-- SUB-TAB: APAR Aktif --}}
            <div x-show="subtab === 'aktif'">
                <div class="flex justify-end gap-2 mb-4">
                    <a href="{{ route('master-apar.template') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-600 border border-gray-300 hover:bg-gray-50 px-3 py-2 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Template Excel
                    </a>
                    <button @click="showImportModal = true" class="inline-flex items-center gap-1.5 text-sm text-gray-600 border border-gray-300 hover:bg-gray-50 px-3 py-2 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l4-4m0 0l4 4m-4-4v12"></path></svg>
                        Import Excel
                    </button>
                    <button @click="showAddModal = true" class="inline-flex items-center gap-1.5 text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg transition-colors font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah APAR
                    </button>
                </div>

                <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-4 py-3 text-left font-semibold text-gray-600 w-10">No</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Kode Aset</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Merk</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Nomor Seri</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Tipe</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Jenis</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Kapasitas</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Lokasi</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Sub Lokasi</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal Isi Ulang</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal Kedaluwarsa</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Vendor</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($masterApars as $idx => $apar)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-400">{{ $masterApars->firstItem() + $idx }}</td>
                                <td class="px-4 py-3 font-mono font-semibold text-gray-800">{{ $apar->kode_aset }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $apar->merk ?: '-' }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $apar->seri ?: '-' }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $apar->tipe ?: '-' }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $apar->jenis ?: ($apar->media ?: '-') }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $apar->kapasitas ?: '-' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $apar->lokasi ?: '-' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $apar->sub_lokasi ?: '-' }}</td>
                                <td class="px-4 py-3 text-gray-600 font-mono text-xs">{{ $apar->tanggal_isi_ulang ? $apar->tanggal_isi_ulang->format('d/m/Y') : '-' }}</td>
                                <td class="px-4 py-3 text-gray-600 font-mono text-xs">{{ $apar->tanggal_kadaluarsa ? $apar->tanggal_kadaluarsa->format('d/m/Y') : '-' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $apar->vendor?->nama_vendor ?: '-' }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-1.5">
                                        <button @click="editItem = {
                                            id: '{{ $apar->id }}',
                                            kode_aset: '{{ $apar->kode_aset }}',
                                            merk: '{{ $apar->merk }}',
                                            tipe: '{{ $apar->tipe }}',
                                            seri: '{{ $apar->seri }}',
                                            media: '{{ $apar->media }}',
                                            jenis: '{{ $apar->jenis }}',
                                            kapasitas: '{{ $apar->kapasitas }}',
                                            lokasi: '{{ $apar->lokasi }}',
                                            sub_lokasi: '{{ $apar->sub_lokasi }}',
                                            tanggal_isi_ulang: '{{ $apar->tanggal_isi_ulang ? $apar->tanggal_isi_ulang->format('Y-m-d') : '' }}',
                                            tanggal_kadaluarsa: '{{ $apar->tanggal_kadaluarsa ? $apar->tanggal_kadaluarsa->format('Y-m-d') : '' }}',
                                            vendor_id: '{{ $apar->vendor_id }}'
                                        }; showEditModal = true" class="inline-flex items-center gap-1 text-xs text-yellow-600 hover:text-yellow-800 font-semibold transition-colors border border-yellow-200 bg-yellow-50 px-2 py-1 rounded" title="Edit">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            Edit
                                        </button>
                                        <button @click="replaceItem = {
                                            id: '{{ $apar->id }}',
                                            kode_aset: '{{ $apar->kode_aset }}',
                                            seri: '{{ $apar->seri }}',
                                            merk: '{{ $apar->merk }}',
                                            tipe: '{{ $apar->tipe }}',
                                            media: '{{ $apar->media }}',
                                            jenis: '{{ $apar->jenis }}',
                                            kapasitas: '{{ $apar->kapasitas }}',
                                            lokasi: '{{ $apar->lokasi }}',
                                            sub_lokasi: '{{ $apar->sub_lokasi }}',
                                            vendor_id: '{{ $apar->vendor_id }}'
                                        }; showReplaceModal = true"
                                        class="inline-flex items-center justify-center text-blue-600 hover:text-blue-800 transition-colors border border-blue-200 bg-blue-50 hover:bg-blue-100 p-2 rounded"
                                        title="Penggantian Aset APAR">

                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h5M20 20v-5h-5M5.5 9A7 7 0 0 1 18 6.5M18.5 15A7 7 0 0 1 6 17.5">
                                                </path>
                                            </svg>

                                        </button>
                                        <form method="POST" action="{{ route('master-apar.destroy', $apar) }}" onsubmit="return confirm('Hapus aset APAR ini?')" class="inline m-0">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center p-1 text-red-500 hover:text-red-700 transition-colors border border-red-200 bg-red-50 rounded" title="Hapus">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="13" class="px-4 py-10 text-center text-gray-400">Belum ada data APAR Aktif</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $masterApars->appends(['tab' => 'apar', 'subtab' => 'aktif'])->links() }}</div>
            </div>

            {{-- SUB-TAB: APAR Non Aktif --}}
            <div x-show="subtab === 'nonactive'">
               <p class="text-sm text-gray-500 mb-4 font-semibold !italic" style="font-style: italic;">
                    Data APAR Non Aktif bersifat read-only. Gunakan tombol pada kolom Aksi untuk mengaktifkan kembali.
                </p>

                <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-4 py-3 text-left font-semibold text-gray-600 w-10">No</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Kode Aset</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Merk</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Nomor Seri</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Tipe</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Jenis</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Kapasitas</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Lokasi</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Sub Lokasi</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal Isi Ulang</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal Kedaluwarsa</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Vendor</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($nonActiveApars as $idx => $apar)
                            <tr class="bg-gray-50/50">
                                <td class="px-4 py-3 text-gray-400">{{ $nonActiveApars->firstItem() + $idx }}</td>
                                <td class="px-4 py-3 font-mono font-semibold text-gray-500">{{ $apar->kode_aset }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $apar->merk ?: '-' }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $apar->seri ?: '-' }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $apar->tipe ?: '-' }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $apar->jenis ?: ($apar->media ?: '-') }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $apar->kapasitas ?: '-' }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $apar->lokasi ?: '-' }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $apar->sub_lokasi ?: '-' }}</td>
                                <td class="px-4 py-3 text-gray-500 font-mono text-xs">{{ $apar->tanggal_isi_ulang ? $apar->tanggal_isi_ulang->format('d/m/Y') : '-' }}</td>
                                <td class="px-4 py-3 text-gray-500 font-mono text-xs">{{ $apar->tanggal_kadaluarsa ? $apar->tanggal_kadaluarsa->format('d/m/Y') : '-' }}</td>
                                <td class="px-4 py-3 text-gray-500">
                                    {{ $apar->vendor?->nama_vendor ?: '-' }}
                                </td>

                                {{-- Status --}}
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-500 border border-gray-200">
                                        Non Aktif
                                    </span>
                                </td>

                                {{-- Aksi --}}
                                <td class="px-4 py-3">
                                    <button
                                        type="button"
                                        @click="reactivateItem = {
                                            id: '{{ $apar->id }}',
                                            kode_aset: @js($apar->kode_aset),
                                            seri: @js($apar->seri),
                                            merk: @js($apar->merk),
                                            tipe: @js($apar->tipe),
                                            media: @js($apar->media),
                                            jenis: @js($apar->jenis),
                                            kapasitas: @js($apar->kapasitas),
                                            lokasi: @js($apar->lokasi),
                                            sub_lokasi: @js($apar->sub_lokasi),
                                            tanggal_isi_ulang: '{{ $apar->tanggal_isi_ulang?->format('Y-m-d') }}',
                                            tanggal_kadaluarsa: '{{ $apar->tanggal_kadaluarsa?->format('Y-m-d') }}',
                                            vendor_id: '{{ $apar->vendor_id }}'
                                        }; showReactivateModal = true"
                                        class="inline-flex items-center justify-center p-1.5 text-green-600 hover:text-green-800 transition-colors border border-green-200 bg-green-50 rounded"
                                        title="Aktifkan Kembali"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M4 4v5h5M20 20v-5h-5M18.36 5.64A8 8 0 0 0 4 9M5.64 18.36A8 8 0 0 0 20 15"
                                            ></path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="13" class="px-4 py-10 text-center text-gray-400">Belum ada data APAR Non Aktif</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $nonActiveApars->appends(['tab' => 'apar', 'subtab' => 'nonactive'])->links() }}</div>
            </div>

            {{-- Add Modal --}}
            <div x-show="showAddModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;">
                <div @click.outside="showAddModal = false"
                    class="bg-white rounded-2xl shadow-xl mx-4 flex flex-col overflow-hidden"
                    style="width: 520px; max-width: calc(100vw - 32px); max-height: 85vh;">
                    {{-- Header --}}
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center shrink-0">
                        <h3 class="text-lg font-bold text-gray-900">Tambah APAR</h3>
                        <button type="button" @click="showAddModal = false" class="text-gray-400 hover:text-gray-600 font-bold text-lg">&times;</button>
                    </div>

                    {{-- Form --}}
                    <form method="POST" action="{{ route('master-apar.store') }}" class="flex flex-col flex-1 overflow-hidden">
                        @csrf
                        
                        {{-- Body (Scrollable) --}}
                        <div class="px-6 py-5 overflow-y-auto flex-1 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kode Aset <span class="text-red-500">*</span></label>
                                <input type="text" name="kode_aset" required placeholder="Contoh: APAR-001" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Merk</label>
                                    <input type="text" name="merk" placeholder="Contoh: Yamato" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                                    <input type="text" name="tipe" placeholder="Contoh: Stored Pressure" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Seri</label>
                                <input type="text" name="seri" placeholder="Contoh: S-12345" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Media Pemadam</label>
                                    <select name="media" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                        <option value="">-- Pilih Media --</option>
                                        <option value="Air">Air</option>
                                        <option value="Busa">Busa</option>
                                        <option value="Serbuk">Serbuk</option>
                                        <option value="CO2">CO2</option>
                                        <option value="Halon Free">Halon Free</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis (Detail)</label>
                                    <input type="text" name="jenis" placeholder="Contoh: ABC Powder" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kapasitas</label>
                                <input type="text" name="kapasitas" placeholder="Contoh: 6 Kg" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                                    <input type="text" name="lokasi" placeholder="Contoh: Lobby Stasiun" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Sub Lokasi</label>
                                    <input type="text" name="sub_lokasi" placeholder="Contoh: Dekat Pintu Utama" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tgl Isi Ulang</label>
                                    <input type="date" name="tanggal_isi_ulang" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tgl Kadaluarsa</label>
                                    <input type="date" name="tanggal_kadaluarsa" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Vendor</label>
                                <select name="vendor_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    <option value="">-- Pilih Vendor --</option>
                                    @foreach ($allVendors as $v)
                                        <option value="{{ $v->id }}">{{ $v->nama_vendor }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Footer (Fixed) --}}
                        <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-2 bg-gray-50 rounded-b-2xl shrink-0">
                            <button type="button" @click="showAddModal = false" class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                            <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Edit Modal --}}
            <div x-show="showEditModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;">
                <div @click.outside="showEditModal = false"
                    class="bg-white rounded-2xl shadow-xl mx-4 flex flex-col max-h-[85vh] overflow-hidden"
                    style="width: min(600px, calc(100vw - 32px)); max-width: 600px;">
                    {{-- Header --}}
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center shrink-0">
                        <h3 class="text-lg font-bold text-gray-900">Edit APAR</h3>
                        <button type="button" @click="showEditModal = false" class="text-gray-400 hover:text-gray-600 font-bold text-lg">&times;</button>
                    </div>

                    {{-- Form --}}
                    <template x-if="editItem">
                        <form method="POST" :action="`/master-apar/${editItem.id}`" class="flex flex-col flex-1 overflow-hidden">
                            @csrf @method('PUT')
                            
                            {{-- Body (Scrollable) --}}
                            <div class="px-6 py-5 overflow-y-auto flex-1 space-y-4">
                                <p class="text-xs text-yellow-600 bg-yellow-50 p-3 rounded-lg border border-yellow-100">Identitas aset (Kode Aset, Seri, Merk, Tipe, Media, Kapasitas) tidak dapat diubah melalui menu Edit.</p>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-505 mb-1">Kode Aset</label>
                                    <input type="text" disabled :value="editItem.kode_aset" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-505 mb-1">Merk</label>
                                        <input type="text" disabled :value="editItem.merk" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-505 mb-1">Tipe</label>
                                        <input type="text" disabled :value="editItem.tipe" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-505 mb-1">Nomor Seri</label>
                                    <input type="text" disabled :value="editItem.seri" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-505 mb-1">Media Pemadam</label>
                                        <select disabled class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                                            <option value="" :selected="editItem.media == ''">-- Pilih Media --</option>
                                            <option value="Air" :selected="editItem.media == 'Air'">Air</option>
                                            <option value="Busa" :selected="editItem.media == 'Busa'">Busa</option>
                                            <option value="Serbuk" :selected="editItem.media == 'Serbuk'">Serbuk</option>
                                            <option value="CO2" :selected="editItem.media == 'CO2'">CO2</option>
                                            <option value="Halon Free" :selected="editItem.media == 'Halon Free'">Halon Free</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-505 mb-1">Jenis (Detail)</label>
                                        <input type="text" disabled :value="editItem.jenis" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-505 mb-1">Kapasitas</label>
                                    <input type="text" disabled :value="editItem.kapasitas" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                                </div>

                                <hr class="border-gray-200 my-2">

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi <span class="text-red-500">*</span></label>
                                        <input type="text" name="lokasi" required :value="editItem.lokasi" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Sub Lokasi</label>
                                        <input type="text" name="sub_lokasi" :value="editItem.sub_lokasi" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tgl Isi Ulang <span class="text-red-500">*</span></label>
                                        <input type="date" name="tanggal_isi_ulang" required :value="editItem.tanggal_isi_ulang" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tgl Kadaluarsa <span class="text-red-500">*</span></label>
                                        <input type="date" name="tanggal_kadaluarsa" required :value="editItem.tanggal_kadaluarsa" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Vendor <span class="text-red-500">*</span></label>
                                    <select name="vendor_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                        <option value="">-- Pilih Vendor --</option>
                                        @foreach ($allVendors as $v)
                                            <option value="{{ $v->id }}" :selected="editItem.vendor_id == '{{ $v->id }}'">{{ $v->nama_vendor }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Footer (Fixed) --}}
                            <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-2 bg-gray-50 rounded-b-2xl shrink-0">
                                <button type="button" @click="showEditModal = false" class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                                <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">Perbarui</button>
                            </div>
                        </form>
                    </template>
                </div>
            </div>

            {{-- Reactivate Modal --}}
            <div x-show="showReactivateModal" x-transition
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                style="display: none;">

                 <div @click.outside="showReactivateModal = false"
                    class="bg-white rounded-2xl shadow-xl mx-4 flex flex-col overflow-hidden"
                    style="width: 460px !important; max-width: calc(100vw - 32px) !important; max-height: 85vh;">

                    {{-- Header --}}
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center shrink-0">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">
                                Aktifkan Kembali APAR
                            </h3>
                            <p class="text-xs text-gray-500 mt-1">
                                Periksa data APAR sebelum diaktifkan kembali.
                            </p>
                        </div>

                        <button type="button"
                            @click="showReactivateModal = false"
                            class="text-gray-400 hover:text-gray-600 font-bold text-lg">
                            &times;
                        </button>
                    </div>

                    {{-- Form --}}
                    <template x-if="reactivateItem">
                        <form method="POST"
                            :action="`/master-apar/${reactivateItem.id}/aktifkan`"
                            class="flex flex-col flex-1 overflow-hidden">

                            @csrf

                            {{-- Body --}}
                            <div class="px-6 py-5 overflow-y-auto flex-1 space-y-4">

                                <p class="text-xs text-blue-600 bg-blue-50 p-3 rounded-lg border border-blue-100">
                                    Identitas aset tidak dapat diubah.
                                    Data lokasi, sub lokasi, tanggal isi ulang, tanggal kedaluwarsa,
                                    dan vendor dapat diperbarui sebelum APAR diaktifkan.
                                </p>

                                {{-- Kode Aset --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">
                                        Kode Aset
                                    </label>

                                    <input type="text"
                                        disabled
                                        :value="reactivateItem.kode_aset"
                                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                                </div>

                                {{-- Merk & Tipe --}}
                                <div class="grid grid-cols-2 gap-4">

                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">
                                            Merk
                                        </label>

                                        <input type="text"
                                            disabled
                                            :value="reactivateItem.merk"
                                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">
                                            Tipe
                                        </label>

                                        <input type="text"
                                            disabled
                                            :value="reactivateItem.tipe"
                                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                                    </div>

                                </div>

                                {{-- Nomor Seri --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">
                                        Nomor Seri
                                    </label>

                                    <input type="text"
                                        disabled
                                        :value="reactivateItem.seri"
                                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                                </div>

                                {{-- Media & Jenis --}}
                                <div class="grid grid-cols-2 gap-4">

                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">
                                            Media Pemadam
                                        </label>

                                        <input type="text"
                                            disabled
                                            :value="reactivateItem.media"
                                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">
                                            Jenis
                                        </label>

                                        <input type="text"
                                            disabled
                                            :value="reactivateItem.jenis"
                                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                                    </div>

                                </div>

                                {{-- Kapasitas --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">
                                        Kapasitas
                                    </label>

                                    <input type="text"
                                        disabled
                                        :value="reactivateItem.kapasitas"
                                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                                </div>

                                <hr class="border-gray-200 my-2">

                                {{-- Lokasi & Sub Lokasi --}}
                                <div class="grid grid-cols-2 gap-4">

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Lokasi <span class="text-red-500">*</span>
                                        </label>

                                        <input type="text"
                                            name="lokasi"
                                            required
                                            :value="reactivateItem.lokasi"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Sub Lokasi
                                        </label>

                                        <input type="text"
                                            name="sub_lokasi"
                                            :value="reactivateItem.sub_lokasi"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    </div>

                                </div>

                                {{-- Tanggal --}}
                                <div class="grid grid-cols-2 gap-4">

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Tgl Isi Ulang <span class="text-red-500">*</span>
                                        </label>

                                        <input type="date"
                                            name="tanggal_isi_ulang"
                                            required
                                            :value="reactivateItem.tanggal_isi_ulang"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Tgl Kedaluwarsa <span class="text-red-500">*</span>
                                        </label>

                                        <input type="date"
                                            name="tanggal_kadaluarsa"
                                            required
                                            :value="reactivateItem.tanggal_kadaluarsa"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    </div>

                                </div>

                                {{-- Vendor --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Vendor <span class="text-red-500">*</span>
                                    </label>

                                    <select name="vendor_id"
                                        required
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">

                                        <option value="">
                                            -- Pilih Vendor --
                                        </option>

                                        @foreach ($allVendors as $v)
                                            <option value="{{ $v->id }}"
                                                :selected="reactivateItem.vendor_id == '{{ $v->id }}'">
                                                {{ $v->nama_vendor }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>

                            </div>

                            {{-- Footer --}}
                            <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-2 bg-gray-50 rounded-b-2xl shrink-0">

                                <button type="button"
                                    @click="showReactivateModal = false"
                                    class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    Batal
                                </button>

                                <button type="submit"
                                    class="px-4 py-2 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold">
                                    Aktifkan
                                </button>

                            </div>

                        </form>
                    </template>

                </div>
</div>

            {{-- Replace Modal (Penggantian Aset APAR) --}}
            <div x-show="showReplaceModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;">
                <div @click.outside="showReplaceModal = false"
                    class="bg-white rounded-2xl shadow-xl mx-4 flex flex-col max-h-[85vh] overflow-hidden"
                    style="width: min(600px, calc(100vw - 32px)); max-width: 600px;">
                    {{-- Header --}}
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center shrink-0">
                        <h3 class="text-lg font-bold text-gray-900">Penggantian Aset APAR</h3>
                        <button type="button" @click="showReplaceModal = false" class="text-gray-400 hover:text-gray-600 font-bold text-lg">&times;</button>
                    </div>

                    {{-- Form --}}
                    <template x-if="replaceItem">
                        <form method="POST" :action="`/master-apar/${replaceItem.id}/ganti-tabung`" class="flex flex-col flex-1 overflow-hidden">
                            @csrf
                            
                            {{-- Body (Scrollable) --}}
                            <div class="px-6 py-5 overflow-y-auto flex-1 space-y-4">
                                <!-- DATA APAR LAMA (Read Only) -->
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Data APAR Lama (Referensi)</h4>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-400">Kode Aset Lama</label>
                                            <span class="text-sm font-mono font-bold text-gray-700" x-text="replaceItem.kode_aset"></span>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-400">Nomor Seri Lama</label>
                                            <span class="text-sm font-semibold text-gray-700" x-text="replaceItem.seri || '-'"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- DATA APAR BARU -->
                                <h4 class="text-xs font-bold text-blue-600 uppercase tracking-wider">Data APAR Baru / Pengganti</h4>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Aset Baru <span class="text-red-500">*</span></label>
                                    <input type="text" name="kode_aset" required placeholder="Input manual nomor inventaris baru KAI" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Merk Baru <span class="text-red-500">*</span></label>
                                        <input type="text" name="merk" required :value="replaceItem.merk" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Baru <span class="text-red-500">*</span></label>
                                        <input type="text" name="tipe" required :value="replaceItem.tipe" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Seri Baru <span class="text-red-500">*</span></label>
                                    <input type="text" name="seri" required placeholder="Contoh: S-99999" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Media Pemadam <span class="text-red-500">*</span></label>
                                        <select name="media" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                            <option value="">-- Pilih Media --</option>
                                            <option value="Air" :selected="replaceItem.media == 'Air'">Air</option>
                                            <option value="Busa" :selected="replaceItem.media == 'Busa'">Busa</option>
                                            <option value="Serbuk" :selected="replaceItem.media == 'Serbuk'">Serbuk</option>
                                            <option value="CO2" :selected="replaceItem.media == 'CO2'">CO2</option>
                                            <option value="Halon Free" :selected="replaceItem.media == 'Halon Free'">Halon Free</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis (Detail)</label>
                                        <input type="text" name="jenis" :value="replaceItem.jenis" placeholder="Contoh: ABC Powder" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kapasitas Baru <span class="text-red-500">*</span></label>
                                    <input type="text" name="kapasitas" required :value="replaceItem.kapasitas" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi Baru <span class="text-red-500">*</span></label>
                                        <input type="text" name="lokasi" required :value="replaceItem.lokasi" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Sub Lokasi Baru</label>
                                        <input type="text" name="sub_lokasi" :value="replaceItem.sub_lokasi" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tgl Isi Ulang Baru <span class="text-red-500">*</span></label>
                                        <input type="date" name="tanggal_isi_ulang" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tgl Kadaluarsa Baru <span class="text-red-500">*</span></label>
                                        <input type="date" name="tanggal_kadaluarsa" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Vendor Baru <span class="text-red-500">*</span></label>
                                    <select name="vendor_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                        <option value="">-- Pilih Vendor --</option>
                                        @foreach ($allVendors as $v)
                                            <option value="{{ $v->id }}" :selected="replaceItem.vendor_id == '{{ $v->id }}'">{{ $v->nama_vendor }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Footer (Fixed) --}}
                            <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-2 bg-gray-50 rounded-b-2xl shrink-0">
                                <button type="button" @click="showReplaceModal = false" class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                                <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">Simpan</button>
                            </div>
                        </form>
                    </template>
                </div>
            </div>

            {{-- Import Modal --}}
            <div x-show="showImportModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;">
                <div @click.outside="showImportModal = false" class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Import Data APAR</h3>
                    <form method="POST" action="{{ route('master-apar.import') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">File Excel (.xlsx, .xls, .csv)</label>
                            <input type="file" name="file" accept=".xlsx,.xls,.csv" required class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-gray-400 mt-1">Download <a href="{{ route('master-apar.template') }}" class="text-blue-600 underline">template Excel</a> untuk format yang benar</p>
                        </div>
                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" @click="showImportModal = false" class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                            <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- TAB: Vendor --}}
        <div x-show="tab === 'vendor'">
            <form action="{{ route('master-vendor.store') }}" method="POST" class="flex flex-col sm:flex-row items-stretch sm:items-end gap-3 mb-6 bg-gray-50 p-4 rounded-xl border border-gray-200">
                @csrf
                <input type="hidden" name="tab" value="vendor">
                <div class="flex-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Nama Vendor <span class="text-red-500 ml-1">*</span></label>
                    <input type="text" name="nama_vendor" placeholder="Nama Vendor" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Alamat</label>
                    <input type="text" name="alamat" placeholder="Alamat" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Nomor Telepon</label>
                    <input type="text" name="nomor_telepon" placeholder="Nomor Telepon" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">No. Rekomendasi Damkar</label>
                    <input type="text" name="no_rekomendasi_damkar" placeholder="No. Rekomendasi Damkar" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition-all shadow-sm focus:ring-4 focus:ring-blue-500/20 shrink-0 h-[38px] flex items-center justify-center">Tambah</button>
            </form>

            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-4 py-3 text-left font-semibold text-slate-600 w-10">No</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Nama Vendor</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Alamat</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Nomor Telepon</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">No. Rekomendasi Damkar</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($masterVendors as $idx => $vendor)
                        <tr class="hover:bg-gray-50 transition-colors" x-data="{ editing: false }">
                            <td class="px-4 py-3 text-gray-400">{{ $masterVendors->firstItem() + $idx }}</td>
                            <td class="px-4 py-3 font-semibold text-slate-900">
                                <span x-show="!editing">{{ $vendor->nama_vendor }}</span>
                                <input x-show="editing" type="text" name="nama_vendor" value="{{ $vendor->nama_vendor }}" class="edit-nama-input border border-gray-300 rounded px-2 py-1 text-xs w-full" style="display: none;">
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                <span x-show="!editing">{{ $vendor->alamat ?: '-' }}</span>
                                <input x-show="editing" type="text" name="alamat" value="{{ $vendor->alamat }}" class="edit-alamat-input border border-gray-300 rounded px-2 py-1 text-xs w-full" style="display: none;">
                            </td>
                            <td class="px-4 py-3 text-slate-500">
                                <span x-show="!editing">{{ $vendor->nomor_telepon ?: '-' }}</span>
                                <input x-show="editing" type="text" name="nomor_telepon" value="{{ $vendor->nomor_telepon }}" class="edit-telepon-input border border-gray-300 rounded px-2 py-1 text-xs w-full" style="display: none;">
                            </td>
                            <td class="px-4 py-3 text-slate-500">
                                <span x-show="!editing">{{ $vendor->no_rekomendasi_damkar ?: '-' }}</span>
                                <input x-show="editing" type="text" name="no_rekomendasi_damkar" value="{{ $vendor->no_rekomendasi_damkar }}" class="edit-damkar-input border border-gray-300 rounded px-2 py-1 text-xs w-full" style="display: none;">
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2" x-show="!editing">
                                    <button @click="editing = true" class="text-yellow-600 hover:text-yellow-800 transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <form method="POST" action="{{ route('master-vendor.destroy', $vendor->id) }}" onsubmit="return confirm('Hapus vendor ini?')" class="inline m-0">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                                <div class="flex items-center gap-2" x-show="editing" style="display: none;">
                                    <button type="button" @click="editing = false" class="bg-slate-100 hover:bg-slate-200 text-slate-800 px-3 py-1 rounded text-xs transition-colors border border-slate-300">Batal</button>
                                    <button type="button" @click="
                                        const row = $el.closest('tr');
                                        const form = document.createElement('form');
                                        form.method = 'POST';
                                        form.action = '/master-vendor/' + '{{ $vendor->id }}';
                                        
                                        const csrf = document.createElement('input');
                                        csrf.type = 'hidden';
                                        csrf.name = '_token';
                                        csrf.value = '{{ csrf_token() }}';
                                        form.appendChild(csrf);
                                        
                                        const method = document.createElement('input');
                                        method.type = 'hidden';
                                        method.name = '_method';
                                        method.value = 'PUT';
                                        form.appendChild(method);
                                        
                                        ['nama_vendor', 'alamat', 'nomor_telepon', 'no_rekomendasi_damkar'].forEach(f => {
                                            const val = row.querySelector('.edit-' + (f === 'nama_vendor' ? 'nama' : (f === 'nomor_telepon' ? 'telepon' : (f === 'no_rekomendasi_damkar' ? 'damkar' : f))) + '-input').value;
                                            const inp = document.createElement('input');
                                            inp.type = 'hidden';
                                            inp.name = f;
                                            inp.value = val;
                                            form.appendChild(inp);
                                        });
                                        
                                        document.body.appendChild(form);
                                        form.submit();
                                    " class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs transition-colors font-semibold">Simpan</button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada data vendor</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $masterVendors->appends(['tab' => 'vendor'])->links() }}</div>
        </div>

        {{-- TAB: History --}}
        <div x-show="tab === 'history'">
            {{-- Search & Filters --}}
            <form method="GET" action="{{ route('form-apar.index') }}" class="flex flex-wrap items-end gap-3 mb-6 bg-gray-50 p-4 rounded-xl border border-gray-200">
                <input type="hidden" name="tab" value="history">
                
                {{-- Search --}}
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Cari Riwayat</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" name="history_search" value="{{ $historySearch }}" placeholder="Cari keterangan, kode, dll..."
                               class="pl-9 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full bg-white">
                    </div>
                </div>

                {{-- Filter Tanggal --}}
                <div class="w-48">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Filter Tanggal</label>
                    <input type="date" name="history_date" value="{{ $historyDate }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                </div>

                {{-- Filter Jenis Perubahan --}}
                <div class="w-60">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Filter Jenis Perubahan</label>
                    <select name="history_type" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                        <option value="">-- Semua Jenis Perubahan --</option>
                        <option value="Penggantian Aset APAR" {{ $historyType === 'Penggantian Aset APAR' ? 'selected' : '' }}>Penggantian Aset APAR</option>
                        <option value="Lokasi" {{ $historyType === 'Lokasi' ? 'selected' : '' }}>Lokasi</option>
                        <option value="Sub Lokasi" {{ $historyType === 'Sub Lokasi' ? 'selected' : '' }}>Sub Lokasi</option>
                        <option value="Vendor" {{ $historyType === 'Vendor' ? 'selected' : '' }}>Vendor</option>
                        <option value="Tanggal Isi Ulang" {{ $historyType === 'Tanggal Isi Ulang' ? 'selected' : '' }}>Tanggal Isi Ulang</option>
                        <option value="Tanggal Kedaluwarsa" {{ $historyType === 'Tanggal Kedaluwarsa' ? 'selected' : '' }}>Tanggal Kedaluwarsa</option>
                    </select>
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all shadow-sm shrink-0 h-[38px] flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter
                    </button>
                    @if($historySearch || $historyDate || $historyType)
                        <a href="{{ route('form-apar.index', ['tab' => 'history']) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg text-sm font-semibold transition-all shadow-sm shrink-0 h-[38px] flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white">
                <table class="w-full text-sm">
                    <thead>
                         <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-4 py-3 text-left font-semibold text-slate-600 whitespace-nowrap w-10">
                                No
                            </th>

                            <th class="px-4 py-3 text-left font-semibold text-slate-600 whitespace-nowrap">
                                Tanggal
                            </th>

                            <th class="px-4 py-3 text-left font-semibold text-slate-600 whitespace-nowrap">
                                Kode Aset
                            </th>

                            <th class="px-4 py-3 text-left font-semibold text-slate-600 whitespace-nowrap">
                                Jenis Perubahan
                            </th>

                            <th class="px-4 py-3 text-left font-semibold text-slate-600 whitespace-nowrap">
                                Data Lama
                            </th>

                            <th class="px-4 py-3 text-left font-semibold text-slate-600 whitespace-nowrap">
                                Data Baru
                            </th>

                            <th class="px-4 py-3 text-left font-semibold text-slate-600 whitespace-nowrap">
                                Keterangan
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($aparHistories as $idx => $history)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-gray-400">{{ $aparHistories->firstItem() + $idx }}</td>
                            <td class="px-4 py-3 text-slate-600 font-mono text-xs">
                                {{ $history->tanggal_perubahan ? $history->tanggal_perubahan->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-4 py-3 text-slate-900 font-mono font-semibold">
                                {{ $history->kode_aset_lama ?: ($history->kode_aset_baru ?: ($history->masterApar?->kode_aset ?? '-')) }}
                            </td>
                            <td class="px-4 py-3 text-slate-900 font-semibold">
                                {{ $history->jenis_perubahan ?: '-' }}
                            </td>
                            <td class="px-4 py-3 text-slate-700">
                                {{ $history->data_lama ?: ($history->kode_aset_lama ?: '-') }}
                            </td>
                            <td class="px-4 py-3 text-slate-900 font-semibold">
                                {{ $history->data_baru ?: ($history->kode_aset_baru ?: '-') }}
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ $history->keterangan ?: '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="px-4 py-8 text-center text-gray-400">Belum ada riwayat perubahan otomatis</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $aparHistories->appends(['tab' => 'history', 'history_search' => $historySearch, 'history_date' => $historyDate, 'history_type' => $historyType])->links() }}</div>
        </div>

        {{-- TAB: Data Penandatangan --}}
        <div x-show="tab === 'signer'">
            <form action="{{ route('master-signer.store') }}" method="POST" class="flex flex-col sm:flex-row items-stretch sm:items-end gap-3 mb-6 bg-gray-50 p-4 rounded-xl border border-gray-200">
                @csrf
                <div class="flex-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Nama <span class="text-red-500 ml-1">*</span></label>
                    <input type="text" name="nama" placeholder="Nama" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">NIPP <span class="text-red-500 ml-1">*</span></label>
                    <input type="text" name="nipp" placeholder="NIPP" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Jabatan (Default)</label>
                    <input type="text" name="jabatan" placeholder="Jabatan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition-all shadow-sm focus:ring-4 focus:ring-blue-500/20 shrink-0 h-[38px] flex items-center justify-center">Tambah</button>
            </form>

            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Nama</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">NIPP</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Jabatan (Default)</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($masterSigners as $signer)
                        <tr class="hover:bg-gray-50 transition-colors" x-data="{ editing: false }">
                            <td class="px-4 py-3">
                                <span x-show="!editing" class="font-medium text-slate-900">{{ $signer->nama }}</span>
                                <input x-show="editing" type="text" name="nama" value="{{ $signer->nama }}" class="edit-nama-input border border-gray-300 rounded px-2 py-1 text-xs w-full" style="display: none;">
                            </td>
                            <td class="px-4 py-3">
                                <span x-show="!editing" class="text-slate-600">{{ $signer->nipp }}</span>
                                <input x-show="editing" type="text" name="nipp" value="{{ $signer->nipp }}" class="edit-nipp-input border border-gray-300 rounded px-2 py-1 text-xs w-full" style="display: none;">
                            </td>
                            <td class="px-4 py-3">
                                <span x-show="!editing" class="text-slate-500">{{ $signer->jabatan ?: '-' }}</span>
                                <input x-show="editing" type="text" name="jabatan" value="{{ $signer->jabatan }}" class="edit-jabatan-input border border-gray-300 rounded px-2 py-1 text-xs w-full" style="display: none;">
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2" x-show="!editing">
                                    <button @click="editing = true" class="text-yellow-600 hover:text-yellow-800 transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <form method="POST" action="{{ route('master-signer.destroy', $signer->id) }}" onsubmit="return confirm('Hapus penandatangan ini?')" class="inline m-0">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                                <div class="flex items-center gap-2" x-show="editing" style="display: none;">
                                    <button type="button" @click="editing = false" class="bg-slate-100 hover:bg-slate-200 text-slate-800 px-3 py-1 rounded text-xs transition-colors border border-slate-300">Batal</button>
                                    <button type="button" @click="
                                        const row = $el.closest('tr');
                                        const form = document.createElement('form');
                                        form.method = 'POST';
                                        form.action = '/master-signer/' + '{{ $signer->id }}';
                                        
                                        const csrf = document.createElement('input');
                                        csrf.type = 'hidden';
                                        csrf.name = '_token';
                                        csrf.value = '{{ csrf_token() }}';
                                        form.appendChild(csrf);
                                        
                                        const method = document.createElement('input');
                                        method.type = 'hidden';
                                        method.name = '_method';
                                        method.value = 'PUT';
                                        form.appendChild(method);
                                        
                                        ['nama', 'nipp', 'jabatan'].forEach(f => {
                                            const val = row.querySelector('.edit-' + f + '-input').value;
                                            const inp = document.createElement('input');
                                            inp.type = 'hidden';
                                            inp.name = f;
                                            inp.value = val;
                                            form.appendChild(inp);
                                        });
                                        
                                        document.body.appendChild(form);
                                        form.submit();
                                    " class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs transition-colors font-semibold">Simpan</button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-4 py-8 text-center text-gray-400">Belum ada data penandatangan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function printForm(url) {
    let iframe = document.getElementById('print-iframe');
    if (!iframe) {
        iframe = document.createElement('iframe');
        iframe.id = 'print-iframe';
        iframe.style.position = 'fixed';
        iframe.style.right = '0';
        iframe.style.bottom = '0';
        iframe.style.width = '0';
        iframe.style.height = '0';
        iframe.style.border = '0';
        document.body.appendChild(iframe);
    }
    iframe.src = url;
    iframe.onload = function() {
        iframe.contentWindow.focus();
        iframe.contentWindow.print();
    };
}
</script>
@endsection
