@extends('layouts.app')

@section('title', 'Checklist Pemeliharaan Perangkat Jaringan')

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
            <div class="w-16 h-16 bg-orange-100 rounded-xl flex items-center justify-center shadow-sm shrink-0">
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2v-4M9 21H5a2 2 0 01-2-2v-4m0 0h18"></path></svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">CHECKLIST PEMELIHARAAN PERANGKAT JARINGAN</h1>
                <p class="text-sm text-gray-500 mt-1">Daftar semua formulir pemeliharaan perangkat jaringan</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2" x-data="{
            searchQuery: '{{ request('search') }}',
            timeout: null,
            performSearch() {
                clearTimeout(this.timeout);
                this.timeout = setTimeout(() => {
                    window.location.href = '{{ route('form-pemeliharaan.index') }}?search=' + encodeURIComponent(this.searchQuery);
                }, 400);
            }
        }">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" x-model="searchQuery" @input="performSearch()" placeholder="Cari formulir..."
                       class="pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-56">
            </div>
            <a href="{{ route('form-pemeliharaan.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Formulir
            </a>
        </div>
    </div>

    {{-- Tab Switcher --}}
    <div x-data="{ tab: 'forms' }" class="flex-1">
        <div class="flex gap-1 bg-gray-100 rounded-xl p-1 mb-6 w-fit">
            <button @click="tab = 'forms'" :class="tab === 'forms' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">Daftar Formulir</button>
            <button @click="tab = 'perangkat'" :class="tab === 'perangkat' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">Master Perangkat</button>
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
                                <th class="px-4 py-3 text-left font-semibold text-gray-600 w-10">#</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">No. Referensi</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Lokasi</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Jenis</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Bulan</th>
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
                                <td class="px-4 py-3 text-gray-600">{{ $form->lokasi ?: '-' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $form->jenis_pemeliharaan ?: '-' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $form->bulan_pemeliharaan ?: '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $form->status_badge }}">
                                        {{ $form->status_label }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('form-pemeliharaan.show', $form) }}" class="text-blue-600 hover:text-blue-800 transition-colors" title="Lihat">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        <a href="{{ route('form-pemeliharaan.edit', $form) }}" class="text-yellow-600 hover:text-yellow-800 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>

                                        @if ($form->isDicetak())
                                        <form method="POST" action="{{ route('form-pemeliharaan.confirm', $form) }}" class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="text-purple-600 hover:text-purple-800 transition-colors" title="Konfirmasi Selesai">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </button>
                                        </form>
                                        @endif
                                        <form method="POST" action="{{ route('form-pemeliharaan.destroy', $form) }}" class="inline"
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
                <div class="mt-4">{{ $forms->links() }}</div>
            @endif
        </div>

        {{-- TAB: Master Perangkat --}}
        <div x-show="tab === 'perangkat'" x-data="{
            showAddModal: false,
            editItem: null,
            showEditModal: false,
            showImportModal: false,
        }">
            <div class="flex justify-end gap-2 mb-4">
                <a href="{{ route('master-perangkat.template') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-600 border border-gray-300 hover:bg-gray-50 px-3 py-2 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Template Excel
                </a>
                <button @click="showImportModal = true" class="inline-flex items-center gap-1.5 text-sm text-gray-600 border border-gray-300 hover:bg-gray-50 px-3 py-2 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l4-4m0 0l4 4m-4-4v12"></path></svg>
                    Import Excel
                </button>
                <button @click="showAddModal = true" class="inline-flex items-center gap-1.5 text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg transition-colors font-semibold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Perangkat
                </button>
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-4 py-3 text-left font-semibold text-gray-600 w-10">#</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">Kode Aset</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">Jenis Perangkat</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">Deskripsi</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($masterPerangkats as $idx => $perangkat)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-400">{{ $masterPerangkats->firstItem() + $idx }}</td>
                            <td class="px-4 py-3 font-mono font-semibold text-gray-800">{{ $perangkat->kode_aset }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $perangkat->jenis_perangkat }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $perangkat->deskripsi ?: '-' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <button @click="editItem = {{ $perangkat->toJson() }}; showEditModal = true" class="text-yellow-600 hover:text-yellow-800 transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <form method="POST" action="{{ route('master-perangkat.destroy', $perangkat) }}" onsubmit="return confirm('Hapus perangkat ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-4 py-10 text-center text-gray-400">Belum ada data perangkat</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $masterPerangkats->links() }}</div>

            {{-- Add Modal --}}
            <div x-show="showAddModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                <div @click.outside="showAddModal = false" class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Tambah Perangkat</h3>
                    <form method="POST" action="{{ route('master-perangkat.store') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kode Aset <span class="text-red-500">*</span></label>
                            <input type="text" name="kode_aset" required placeholder="Contoh: SW-001" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Perangkat <span class="text-red-500">*</span></label>
                            <input type="text" name="jenis_perangkat" required placeholder="Contoh: Switch, Router, Firewall" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <input type="text" name="deskripsi" placeholder="Contoh: Cisco Catalyst 2960" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" @click="showAddModal = false" class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                            <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Edit Modal --}}
            <div x-show="showEditModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                <div @click.outside="showEditModal = false" class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Edit Perangkat</h3>
                    <template x-if="editItem">
                        <form method="POST" :action="`/master-perangkat/${editItem.id}`" class="space-y-4">
                            @csrf @method('PUT')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kode Aset <span class="text-red-500">*</span></label>
                                <input type="text" name="kode_aset" :value="editItem.kode_aset" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Perangkat <span class="text-red-500">*</span></label>
                                <input type="text" name="jenis_perangkat" :value="editItem.jenis_perangkat" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                <input type="text" name="deskripsi" :value="editItem.deskripsi" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" @click="showEditModal = false" class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                                <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">Perbarui</button>
                            </div>
                        </form>
                    </template>
                </div>
            </div>

            {{-- Import Modal --}}
            <div x-show="showImportModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                <div @click.outside="showImportModal = false" class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Import Data Perangkat</h3>
                    <form method="POST" action="{{ route('master-perangkat.import') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">File Excel (.xlsx, .xls, .csv)</label>
                            <input type="file" name="file" accept=".xlsx,.xls,.csv" required class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-gray-400 mt-1">Download <a href="{{ route('master-perangkat.template') }}" class="text-blue-600 underline">template Excel</a> untuk format yang benar</p>
                        </div>
                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" @click="showImportModal = false" class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                            <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
