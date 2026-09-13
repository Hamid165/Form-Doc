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
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 flex flex-col min-h-[500px] mb-6"
     x-data="{ 
        tab: '{{ session('active_tab') }}' || localStorage.getItem('pemeliharaan_tab') || 'forms',
        searchQuery: '',
        timeout: null,
        init() {
            const urlParams = new URLSearchParams(window.location.search);
            if (this.tab === 'forms') this.searchQuery = urlParams.get('search_forms') || urlParams.get('search') || '';
            else if (this.tab === 'perangkat') this.searchQuery = urlParams.get('search_perangkat') || '';
            else if (this.tab === 'petugas') this.searchQuery = urlParams.get('search_petugas') || '';
            else if (this.tab === 'signer') this.searchQuery = urlParams.get('search_signer') || '';
            
            this.$watch('tab', (val) => {
                localStorage.setItem('pemeliharaan_tab', val);
                this.searchQuery = ''; // Clear search input when switching tabs
            });
        },
        performSearch() {
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
                let param = 'search_forms';
                if (this.tab === 'perangkat') param = 'search_perangkat';
                if (this.tab === 'petugas') param = 'search_petugas';
                if (this.tab === 'signer') param = 'search_signer';
                
                window.location.href = '{{ route('form-pemeliharaan.index') }}?' + param + '=' + encodeURIComponent(this.searchQuery);
            }, 500);
        }
     }">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8 px-2">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-orange-100 rounded-xl flex items-center justify-center shadow-sm shrink-0">
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2v-4M9 21H5a2 2 0 01-2-2v-4m0 0h18"></path></svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">CHECKLIST PEMELIHARAAN PERANGKAT JARINGAN</h1>
                <p class="text-sm text-gray-500 mt-1">Daftar semua formulir pemeliharaan perangkat jaringan</p>
            </div>
        </div>
    </div>

    {{-- Tab Switcher --}}
    <div class="flex-1">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3 mb-6">
            <div class="flex flex-wrap gap-1 bg-gray-100 rounded-xl p-1 w-fit max-w-full">
                <button @click="tab = 'forms'" :class="tab === 'forms' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">Daftar Formulir</button>
                <button @click="tab = 'perangkat'" :class="tab === 'perangkat' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">Daftar Perangkat</button>
                <button @click="tab = 'petugas'" :class="tab === 'petugas' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">Daftar Petugas</button>
                <button @click="tab = 'signer'" :class="tab === 'signer' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">Daftar Penanda Tangan</button>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" x-model="searchQuery" @input="performSearch()" :placeholder="tab === 'forms' ? 'Cari formulir...' : (tab === 'perangkat' ? 'Cari perangkat...' : (tab === 'petugas' ? 'Cari petugas...' : 'Cari penanda tangan...'))"
                           class="pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-56">
                </div>
                <a href="{{ route('form-pemeliharaan.create') }}"
                   class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Buat Formulir
                </a>
            </div>
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
                                        {{-- 1. Lihat --}}
                                        <a href="{{ route('form-pemeliharaan.show', $form) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 h-[36px] w-[36px] flex items-center justify-center rounded-lg transition-colors" title="Lihat">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        
                                        {{-- 2. Edit --}}
                                        @if(!$form->isSelesai())
                                        <a href="{{ route('form-pemeliharaan.edit', $form) }}" class="text-amber-500 hover:text-amber-700 bg-amber-50 hover:bg-amber-100 h-[36px] w-[36px] flex items-center justify-center rounded-lg transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        @endif

                                        {{-- 3. Print --}}
                                        <form method="POST" action="{{ route('form-pemeliharaan.mark-dicetak', $form) }}" target="_blank" class="m-0" onsubmit="setTimeout(() => window.location.reload(), 1000)">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="text-purple-600 hover:text-purple-900 bg-purple-50 hover:bg-purple-100 h-[36px] w-[36px] flex items-center justify-center rounded-lg transition-colors" title="Print">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                            </button>
                                        </form>
                                        
                                        {{-- 4. Hapus --}}
                                        @if(!$form->isSelesai())
                                        <form method="POST" action="{{ route('form-pemeliharaan.destroy', $form) }}" class="m-0">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDelete(this.form)" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 h-[36px] w-[36px] flex items-center justify-center rounded-lg transition-colors" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                        @endif
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

        {{-- TAB: Daftar Petugas --}}
        <div x-show="tab === 'petugas'" x-data="{ showEditModal: false, editItem: null }" style="display: none;">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex flex-col h-full">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900">Data Petugas</h2>
                </div>
                
                <form action="{{ route('master-petugas.store') }}" method="POST" class="flex items-end gap-3 mb-6">
                    @csrf
                    <div class="flex-1">
                        <label class="block text-[12px] font-bold uppercase tracking-wider text-slate-500 mb-2">Nama <span class="text-red-500 ml-1">*</span></label>
                        <div class="relative">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 w-4 h-4 pointer-events-none z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <input type="text" name="nama" placeholder="Nama" required class="w-full h-[42px] pl-10 pr-3 border-2 border-slate-200 rounded-lg bg-slate-50 text-slate-900 text-sm font-medium focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                        </div>
                    </div>
                    <div class="flex-1">
                        <label class="block text-[12px] font-bold uppercase tracking-wider text-slate-500 mb-2">NIPP <span class="text-red-500 ml-1">*</span></label>
                        <div class="relative">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 w-4 h-4 pointer-events-none z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                            <input type="text" name="nipp" placeholder="NIPP" required class="w-full h-[42px] pl-10 pr-3 border-2 border-slate-200 rounded-lg bg-slate-50 text-slate-900 text-sm font-medium focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                        </div>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 h-[42px] rounded-lg text-sm font-semibold transition-all shadow-sm focus:ring-4 focus:ring-blue-500/20 shrink-0">Tambah</button>
                </form>
                
                <div class="space-y-2 mb-4 flex-1">
                    @forelse($masterPetugas as $petugas)
                        <div class="p-3 bg-gray-50 hover:bg-gray-100 transition-colors rounded-lg border border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col">
                                    <p class="font-semibold text-sm text-gray-900">{{ $petugas->nama }}</p>
                                    <p class="text-xs text-gray-500">NIPP: {{ $petugas->nipp }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button @click="editItem = {{ $petugas->toJson() }}; showEditModal = true" type="button" class="text-amber-500 hover:text-amber-700 bg-amber-50 hover:bg-amber-100 h-[36px] w-[36px] flex items-center justify-center rounded-lg transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <form action="{{ route('master-petugas.destroy', $petugas->id) }}" method="POST" class="m-0">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete(this.form)" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 h-[36px] w-[36px] flex items-center justify-center rounded-lg transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-4">Belum ada data Petugas</p>
                    @endforelse
                </div>
                <div class="mt-2">{{ $masterPetugas->links() }}</div>

                {{-- Edit Petugas Modal --}}
                <div x-show="showEditModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;">
                    <div @click.outside="showEditModal = false" class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4">
                        <div class="flex justify-center mb-3 mt-2">
                            <div style="background-color: #fef3c7; padding: 12px; border-radius: 14px; box-shadow: 0 4px 10px rgba(245, 158, 11, 0.15);">
                                <svg style="width: 28px; height: 28px; color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-5 text-center">Edit Petugas</h3>
                        <template x-if="editItem">
                            <form method="POST" :action="`/master-petugas/${editItem.id}`" class="space-y-4">
                                @csrf @method('PUT')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama" :value="editItem.nama" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">NIPP <span class="text-red-500">*</span></label>
                                    <input type="text" name="nipp" :value="editItem.nipp" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div class="flex justify-end pt-4" style="gap: 12px;">
                                    <button type="button" @click="showEditModal = false" class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                                    <button type="submit" style="background-color: #f59e0b;" class="px-4 py-2 text-sm bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors font-semibold">Perbarui</button>
                                </div>
                            </form>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB: Daftar Penanda Tangan --}}
        <div x-show="tab === 'signer'" x-data="{ showEditModal: false, editItem: null }" style="display: none;">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex flex-col h-full">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900">Data Penandatangan Formulir</h2>
                </div>
                
                <form action="{{ route('form-pemeliharaan-signer.store') }}" method="POST" class="flex items-end gap-3 mb-6">
                    @csrf
                    <div class="flex-1">
                        <label class="block text-[12px] font-bold uppercase tracking-wider text-slate-500 mb-2">Nama <span class="text-red-500 ml-1">*</span></label>
                        <div class="relative">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 w-4 h-4 pointer-events-none z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <input type="text" name="nama" placeholder="Nama" required class="w-full h-[42px] pl-10 pr-3 border-2 border-slate-200 rounded-lg bg-slate-50 text-slate-900 text-sm font-medium focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                        </div>
                    </div>
                    <div class="flex-1">
                        <label class="block text-[12px] font-bold uppercase tracking-wider text-slate-500 mb-2">NIPP <span class="text-red-500 ml-1">*</span></label>
                        <div class="relative">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 w-4 h-4 pointer-events-none z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                            <input type="text" name="nipp" placeholder="NIPP" required class="w-full h-[42px] pl-10 pr-3 border-2 border-slate-200 rounded-lg bg-slate-50 text-slate-900 text-sm font-medium focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                        </div>
                    </div>
                    <div class="flex-1">
                        <label class="block text-[12px] font-bold uppercase tracking-wider text-slate-500 mb-2">Jabatan</label>
                        <div class="relative">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 w-4 h-4 pointer-events-none z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <input type="text" name="jabatan" placeholder="Jabatan" class="w-full h-[42px] pl-10 pr-3 border-2 border-slate-200 rounded-lg bg-slate-50 text-slate-900 text-sm font-medium focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                        </div>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 h-[42px] rounded-lg text-sm font-semibold transition-all shadow-sm focus:ring-4 focus:ring-blue-500/20 shrink-0">Tambah</button>
                </form>

                <div class="space-y-2 mb-4 flex-1">
                    @forelse($masterSigners as $signer)
                        <div class="p-3 bg-gray-50 hover:bg-gray-100 transition-colors rounded-lg border border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col">
                                    <p class="font-semibold text-sm text-gray-900">{{ $signer->nama }}</p>
                                    <p class="text-xs text-gray-500">NIPP: {{ $signer->nipp }} @if($signer->jabatan) | Jabatan: {{ $signer->jabatan }} @endif</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button @click="editItem = {{ $signer->toJson() }}; showEditModal = true" type="button" class="text-amber-500 hover:text-amber-700 bg-amber-50 hover:bg-amber-100 h-[36px] w-[36px] flex items-center justify-center rounded-lg transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <form action="{{ route('form-pemeliharaan-signer.destroy', $signer->id) }}" method="POST" class="m-0">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete(this.form)" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 h-[36px] w-[36px] flex items-center justify-center rounded-lg transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-4">Belum ada data Penandatangan</p>
                    @endforelse
                </div>
                <div class="mt-2">{{ $masterSigners->links() }}</div>

                {{-- Edit Signer Modal --}}
                <div x-show="showEditModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;">
                    <div @click.outside="showEditModal = false" class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4">
                        <div class="flex justify-center mb-3 mt-2">
                            <div style="background-color: #fef3c7; padding: 12px; border-radius: 14px; box-shadow: 0 4px 10px rgba(245, 158, 11, 0.15);">
                                <svg style="width: 28px; height: 28px; color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-5 text-center">Edit Penanda Tangan</h3>
                        <template x-if="editItem">
                            <form method="POST" :action="`/form-pemeliharaan-signer/${editItem.id}`" class="space-y-4">
                                @csrf @method('PUT')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama" :value="editItem.nama" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">NIPP <span class="text-red-500">*</span></label>
                                    <input type="text" name="nipp" :value="editItem.nipp" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                                    <input type="text" name="jabatan" :value="editItem.jabatan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div class="flex justify-end pt-4" style="gap: 12px;">
                                    <button type="button" @click="showEditModal = false" class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                                    <button type="submit" style="background-color: #f59e0b;" class="px-4 py-2 text-sm bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors font-semibold">Perbarui</button>
                                </div>
                            </form>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB: Daftar Perangkat --}}
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
                            <th class="w-16 px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">NO</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-1/4">Kode / ID Aset</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-1/4">Jenis Perangkat</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Lokasi</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($masterPerangkats as $idx => $perangkat)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-4 py-3 text-gray-400">{{ $masterPerangkats->firstItem() + $idx }}</td>
                            <td class="px-4 py-3 font-mono font-semibold text-gray-800">{{ $perangkat->kode_aset }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $perangkat->jenis_perangkat }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $perangkat->lokasi ?? '-' }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button @click="editItem = {{ $perangkat->toJson() }}; showEditModal = true" class="text-amber-500 hover:text-amber-700 bg-amber-50 hover:bg-amber-100 h-[36px] w-[36px] flex items-center justify-center rounded-lg transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <form method="POST" action="{{ route('master-perangkat.destroy', $perangkat) }}" class="m-0">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete(this.form)" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 h-[36px] w-[36px] flex items-center justify-center rounded-lg transition-colors" title="Hapus">
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
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                            <input type="text" name="lokasi" placeholder="Contoh: Gedung A, Lantai 2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="flex justify-end gap-2 pt-5" style="margin-top: 24px;">
                            <button type="button" @click="showAddModal = false" class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                            <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Edit Modal --}}
            <div x-show="showEditModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                <div @click.outside="showEditModal = false" class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4">
                    <div class="flex justify-center mb-3 mt-2">
                        <div style="background-color: #fef3c7; padding: 12px; border-radius: 14px; box-shadow: 0 4px 10px rgba(245, 158, 11, 0.15);">
                            <svg style="width: 28px; height: 28px; color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-5 text-center">Edit Perangkat</h3>
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
                                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                                <input type="text" name="lokasi" :value="editItem.lokasi" placeholder="Contoh: Gedung A, Lantai 2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="flex justify-end pt-4" style="gap: 12px;">
                                <button type="button" @click="showEditModal = false" class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                                <button type="submit" style="background-color: #f59e0b;" class="px-4 py-2 text-sm bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors font-semibold">Perbarui</button>
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

@section('scripts')
<script>
    function confirmDelete(form) {
        Swal.fire({
            html: `
                <style>
                    .swal-custom-popup { border-radius: 16px !important; width: 360px !important; padding: 20px !important; }
                    .swal-custom-confirm { background-color: #ef4444 !important; color: white !important; font-weight: 600 !important; padding: 8px 16px !important; border-radius: 8px !important; transition: 0.2s !important; margin-right: 8px !important; width: 100px !important; border: none !important; font-size: 13px !important; cursor: pointer !important; }
                    .swal-custom-confirm:hover { background-color: #dc2626 !important; }
                    .swal-custom-cancel { background-color: #f1f5f9 !important; color: #475569 !important; font-weight: 600 !important; padding: 8px 16px !important; border-radius: 8px !important; transition: 0.2s !important; margin-left: 8px !important; width: 100px !important; border: none !important; font-size: 13px !important; cursor: pointer !important; }
                    .swal-custom-cancel:hover { background-color: #e2e8f0 !important; }
                    .swal-custom-actions { margin-top: 20px !important; width: 100% !important; display: flex !important; justify-content: center !important; }
                </style>
                <div style="display:flex; justify-content:center; margin-bottom: 12px; margin-top: 8px;">
                    <div style="background-color: #fee2e2; padding: 12px; border-radius: 14px; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.15);">
                        <svg style="width: 28px; height: 28px; color: #ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </div>
                </div>
                <h2 style="font-size: 18px; font-weight: 700; color: #111827; margin-bottom: 6px; font-family: ui-sans-serif, system-ui, sans-serif;">Apakah Anda yakin?</h2>
                <p style="color: #64748b; font-size: 13px; font-weight: 500; font-family: ui-sans-serif, system-ui, sans-serif;">Data ini akan dihapus untuk semua orang</p>
            `,
            showCancelButton: true,
            showConfirmButton: true,
            focusConfirm: true,
            buttonsStyling: false,
            reverseButtons: true,
            customClass: {
                popup: 'swal-custom-popup',
                confirmButton: 'swal-custom-confirm',
                cancelButton: 'swal-custom-cancel',
                actions: 'swal-custom-actions'
            },
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            showCloseButton: false
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
@endsection
