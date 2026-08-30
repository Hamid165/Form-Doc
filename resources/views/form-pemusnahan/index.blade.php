@extends('layouts.app')

@section('title', 'Formulir Permohonan Pemusnahan Aset')

@section('content')

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
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
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
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>
@endif

<div class="mb-4">
    <a href="{{ route('formulir.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Katalog
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 flex flex-col min-h-[500px] mb-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-8 px-2">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center shadow-sm shrink-0">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">FORMULIR PERMOHONAN PEMUSNAHAN ASET</h1>
                <p class="text-sm text-gray-500 mt-1">Daftar semua formulir permohonan pemusnahan aset</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <form method="GET" class="relative">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari No. Ref / Nama / Business Area..." class="h-[40px] pl-9 pr-4 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors w-full sm:w-64">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </form>
            <a href="{{ route('form-pemusnahan.create') }}" class="h-[40px] px-4 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah
            </a>
        </div>
    </div>

    {{-- Tab Switcher --}}
    <div x-data="{ tab: (new URLSearchParams(window.location.search)).get('tab') || 'forms' }" class="flex-1">
    <div class="flex gap-1 bg-gray-100 rounded-xl p-1 mb-6 w-fit">
        <button @click="tab = 'forms'; window.history.replaceState(null, '', '?tab=forms')" :class="tab === 'forms' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">Daftar Formulir</button>
        <button @click="tab = 'aset'; window.history.replaceState(null, '', '?tab=aset')" :class="tab === 'aset' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">Data Aset Perangkat</button>
        <button @click="tab = 'pemohon'; window.history.replaceState(null, '', '?tab=pemohon')" :class="tab === 'pemohon' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">Data Pemohon</button>
    </div>

        {{-- TAB: Daftar Formulir --}}
        <div x-show="tab === 'forms'" class="space-y-2">
            @forelse ($forms as $form)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center gap-4 hover:shadow-md transition-shadow group relative">
                <div class="flex-1 grid grid-cols-1 md:grid-cols-12 gap-4 items-start md:items-center">
                    <div class="col-span-1 md:col-span-2">
                        <p class="text-xs text-gray-500 font-medium mb-0.5">No. Ref</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $form->no_ref ?: '-' }}</p>
                    </div>
                    <div class="col-span-1 md:col-span-3">
                        <p class="text-xs text-gray-500 font-medium mb-0.5">Nama &amp; NIP</p>
                        <p class="text-sm font-medium text-gray-900 truncate" title="{{ $form->nama_nip }}">{{ $form->nama_nip ?: '-' }}</p>
                    </div>
                    <div class="col-span-1 md:col-span-3">
                        <p class="text-xs text-gray-500 font-medium mb-0.5">Unit Kerja</p>
                        <p class="text-sm font-medium text-gray-900 truncate" title="{{ $form->unit_kerja }}">{{ $form->unit_kerja ?: '-' }}</p>
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <p class="text-xs text-gray-500 font-medium mb-0.5">Tanggal</p>
                        <p class="text-sm font-medium text-gray-900">{{ $form->tanggal_permohonan ? \Carbon\Carbon::parse($form->tanggal_permohonan)->format('d M Y') : '-' }}</p>
                    </div>
                    <div class="col-span-1 md:col-span-2 flex justify-start md:justify-end items-center mt-2 md:mt-0">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('form-pemusnahan.show', $form->id) }}" class="text-blue-500 hover:text-blue-700 transition-colors" title="Lihat">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            <a href="{{ route('form-pemusnahan.show', $form->id) }}?print=1" class="text-emerald-600 hover:text-emerald-800 transition-colors" title="Print">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a1 1 0 001-1v-4a1 1 0 00-1-1H9a1 1 0 00-1 1v4a1 1 0 001 1zm8-14V4a1 1 0 00-1-1H8a1 1 0 00-1 1v3h10z"></path></svg>
                            </a>
                            <a href="{{ route('form-pemusnahan.edit', $form->id) }}" class="text-amber-500 hover:text-amber-700 transition-colors" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('form-pemusnahan.destroy', $form->id) }}" method="POST" onsubmit="confirmDelete(this); return false;">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition-colors" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="flex flex-col items-center justify-center text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <p class="text-sm font-semibold text-gray-900 mb-1">Belum ada data formulir</p>
                <p class="text-sm text-gray-500 mb-4">Silakan buat formulir baru untuk memulai pencatatan.</p>
                <a href="{{ route('form-pemusnahan.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 h-[40px] rounded-lg text-sm font-semibold transition-colors shadow-sm">Tambah</a>
            </div>
            @endforelse

            @if ($forms->hasPages())
                <div class="mt-6 pt-4 border-t border-gray-100">
                    {{ $forms->appends(['search' => $search])->links('pagination::tailwind') }}
                </div>
            @endif
        </div>

        {{-- TAB: Data Aset Perangkat --}}
        <div x-show="tab === 'aset'" x-data="{
            showAddModal: false,
            editItem: null,
            showEditModal: false,
            showImportModal: false,
        }">
            <div class="flex justify-end gap-2 mb-4">
                <a href="{{ route('data-aset.template') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-600 border border-gray-300 hover:bg-gray-50 px-3 py-2 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Template Excel
                </a>
                <button @click="showImportModal = true" class="inline-flex items-center gap-1.5 text-sm text-gray-600 border border-gray-300 hover:bg-gray-50 px-3 py-2 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l4-4m0 0l4 4m-4-4v12"></path></svg>
                    Import Excel
                </button>
                <button @click="showAddModal = true" class="inline-flex items-center gap-1.5 text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg transition-colors font-semibold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Aset
                </button>
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-4 py-3 text-left font-semibold text-gray-600 w-10">#</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">ID Aset</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama Aset</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">Jenis Aset</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($dataAsets as $idx => $aset)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-400">{{ $dataAsets->firstItem() + $idx }}</td>
                            <td class="px-4 py-3 font-mono font-semibold text-gray-800">{{ $aset->id_aset }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $aset->nama_aset }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $aset->jenis_aset ?: '-' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <button @click="editItem = {{ $aset->toJson() }}; showEditModal = true" class="text-yellow-600 hover:text-yellow-800 transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <form method="POST" action="{{ route('data-aset.destroy', $aset) }}" onsubmit="confirmDelete(this, 'Aset ini akan dihapus untuk semua orang'); return false;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-4 py-10 text-center text-gray-400">Belum ada data aset</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $dataAsets->appends(['tab' => 'aset'])->links() }}</div>

            {{-- Add Modal --}}
            <div x-show="showAddModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                <div @click.outside="showAddModal = false" class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Tambah Aset</h3>
                    <form method="POST" action="{{ route('data-aset.store') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">ID Aset <span class="text-red-500">*</span></label>
                            <input type="text" name="id_aset" required placeholder="Contoh: SW-001" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Aset <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_aset" required placeholder="Contoh: Switch Cisco 2960-X" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Aset</label>
                            <input type="text" name="jenis_aset" placeholder="Contoh: fisik, jaringan, informasi (HC/SC)" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Edit Aset</h3>
                    <template x-if="editItem">
                        <form method="POST" :action="`/data-aset/${editItem.id}`" class="space-y-4">
                            @csrf @method('PUT')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ID Aset <span class="text-red-500">*</span></label>
                                <input type="text" name="id_aset" :value="editItem.id_aset" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Aset <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_aset" :value="editItem.nama_aset" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Aset</label>
                                <input type="text" name="jenis_aset" :value="editItem.jenis_aset" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Import Data Aset</h3>
                    <form method="POST" action="{{ route('data-aset.import') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">File Excel (.xlsx, .xls, .csv)</label>
                            <input type="file" name="file" accept=".xlsx,.xls,.csv" required class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-gray-400 mt-1">Download <a href="{{ route('data-aset.template') }}" class="text-blue-600 underline">template Excel</a> untuk format yang benar</p>
                        </div>
                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" @click="showImportModal = false" class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                            <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- TAB: Data Pemohon --}}
        <div x-show="tab === 'pemohon'" x-data="{
            showAddModalPemohon: false,
            editPemohon: null,
            showEditModalPemohon: false,
        }">
            <div class="flex justify-end gap-2 mb-4">
                <button @click="showAddModalPemohon = true" class="inline-flex items-center gap-1.5 text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg transition-colors font-semibold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Pemohon
                </button>
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-4 py-3 text-left font-semibold text-gray-600 w-10">#</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">NIP</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($dataPemohons as $idx => $pemohon)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-400">{{ $dataPemohons->firstItem() + $idx }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $pemohon->nama }}</td>
                            <td class="px-4 py-3 font-mono text-gray-500">{{ $pemohon->nip ?: '-' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <button @click="editPemohon = {{ $pemohon->toJson() }}; showEditModalPemohon = true" class="text-yellow-600 hover:text-yellow-800 transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <form method="POST" action="{{ route('data-pemohon.destroy', $pemohon) }}" onsubmit="confirmDelete(this, 'Data pemohon ini akan dihapus untuk semua orang'); return false;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-4 py-10 text-center text-gray-400">Belum ada data pemohon</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $dataPemohons->appends(['tab' => 'pemohon'])->links() }}</div>

            {{-- Add Modal --}}
            <div x-show="showAddModalPemohon" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                <div @click.outside="showAddModalPemohon = false" class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Tambah Pemohon</h3>
                    <form method="POST" action="{{ route('data-pemohon.store') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                            <input type="text" name="nip" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" @click="showAddModalPemohon = false" class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                            <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Edit Modal --}}
            <div x-show="showEditModalPemohon" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                <div @click.outside="showEditModalPemohon = false" class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Edit Pemohon</h3>
                    <template x-if="editPemohon">
                        <form method="POST" :action="`/data-pemohon/${editPemohon.id}`" class="space-y-4">
                            @csrf @method('PUT')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama <span class="text-red-500">*</span></label>
                                <input type="text" name="nama" :value="editPemohon.nama" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                                <input type="text" name="nip" :value="editPemohon.nip" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" @click="showEditModalPemohon = false" class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                                <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">Perbarui</button>
                            </div>
                        </form>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function confirmDelete(form, message) {
        Swal.fire({
            html: `
                <div class="flex flex-col items-center pt-4">
                    <div class="relative flex items-center justify-center w-16 h-16 mb-6">
                        <div class="absolute inset-0 bg-[#f44336] blur-xl opacity-30 rounded-full"></div>
                        <svg class="w-10 h-10 text-[#f44336] relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </div>
                    <h2 class="text-[22px] font-bold text-gray-900 mb-2 text-center">Apakah Anda yakin?</h2>
                    <p class="text-[15px] font-medium text-gray-600 text-center leading-relaxed">${message || 'Data ini akan dihapus untuk semua orang'}</p>
                </div>
            `,
            width: '360px',
            scrollbarPadding: false,
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            buttonsStyling: false,
            customClass: {
                popup: 'custom-swal-popup p-6 shadow-2xl border-0',
                htmlContainer: 'm-0',
                confirmButton: 'rounded-2xl bg-[#f44336] hover:bg-[#d32f2f] text-white text-base font-semibold px-8 py-3.5 ml-3 transition-colors flex-1',
                cancelButton: 'rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-600 text-base font-semibold px-8 py-3.5 transition-colors flex-1',
                actions: 'mt-6 w-full flex justify-center gap-2 px-4 pb-2',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
@endsection
