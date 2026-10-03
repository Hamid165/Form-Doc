@extends('layouts.app')

@section('title', 'Formulir Pemeliharaan AC')

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
        <p class="text-[13px] font-medium text-[#dc2626]">
            {{ session('error') ?? $errors->first() }}
        </p>
    </div>
    <button @click="show = false" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#f87171] hover:text-[#dc2626] transition-colors p-1 rounded-md hover:bg-[#fee2e2]">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>
@endif

<!-- Breadcrumb -->
<div class="mb-4">
    <a href="{{ route('formulir.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Katalog
    </a>
</div>

<!-- Content Wrapper -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 flex flex-col h-full min-h-[500px] mb-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-8 px-2">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center shadow-sm shrink-0">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">FORMULIR PEMELIHARAAN AC</h1>
                <p class="text-sm text-gray-500 mt-1">Daftar semua formulir pemeliharaan AC</p>
            </div>
        </div>
        
        <div class="flex flex-wrap items-center gap-2" x-data="{
            searchQuery: '{{ request('search') }}',
            timeout: null,
            performSearch() {
                clearTimeout(this.timeout);
                this.timeout = setTimeout(() => {
                    fetch('{{ route('form-pemeliharaan-ac.index') }}?search=' + encodeURIComponent(this.searchQuery))
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            document.getElementById('ac-list-container').innerHTML = doc.getElementById('ac-list-container').innerHTML;
                        });
                }, 300);
            }
        }">
            <div class="relative">
                <input type="text" x-model="searchQuery" @input="performSearch" placeholder="Cari No. Ref / ID AC..." class="h-[40px] pl-9 pr-4 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors w-full sm:w-64">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <a href="{{ route('form-pemeliharaan-ac.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 h-[40px] rounded-lg text-sm font-semibold transition-all shadow-sm focus:ring-4 focus:ring-blue-500/20 shrink-0 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Formulir
            </a>
        </div>
    </div>

    <!-- List of Submissions -->
    <div id="ac-list-container" class="space-y-2 flex-1 flex flex-col">
        @forelse ($forms as $form)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center gap-4 hover:shadow-md transition-shadow group relative">
            <div class="flex-1 grid grid-cols-1 md:grid-cols-12 gap-4 items-start md:items-center">
                <div class="col-span-1 md:col-span-2">
                    <p class="text-xs text-gray-500 font-medium mb-0.5">No. Ref</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $form->no_ref ?: '-' }}</p>
                </div>
                <div class="col-span-1 md:col-span-2">
                    <p class="text-xs text-gray-500 font-medium mb-0.5">ID AC</p>
                    <p class="text-sm font-medium text-gray-900">{{ $form->id_ac ?: '-' }}</p>
                </div>
                <div class="col-span-1 md:col-span-3">
                    <p class="text-xs text-gray-500 font-medium mb-0.5">Lokasi</p>
                    <p class="text-sm font-medium text-gray-900 truncate" title="{{ $form->lokasi }}">{{ $form->lokasi ?: '-' }}</p>
                </div>
                <div class="col-span-1 md:col-span-2">
                    <p class="text-xs text-gray-500 font-medium mb-0.5">Tanggal</p>
                    <p class="text-sm font-medium text-gray-900">{{ $form->tanggal ? \Carbon\Carbon::parse($form->tanggal)->format('d M Y') : '-' }}</p>
                </div>
                <div class="col-span-1 md:col-span-3 flex justify-start md:justify-end items-center mt-2 md:mt-0">
                    <!-- Actions -->
                    <div class="flex items-center gap-2">
                        <a href="{{ route('form-pemeliharaan-ac.edit', $form->id) }}" class="text-amber-500 hover:text-amber-700 bg-amber-50 hover:bg-amber-100 h-[40px] w-[40px] flex items-center justify-center rounded-lg transition-colors" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <a href="{{ route('form-pemeliharaan-ac.show', $form->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 h-[40px] w-[40px] flex items-center justify-center rounded-lg transition-colors" title="Lihat Dokumen">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                        <a href="{{ route('form-pemeliharaan-ac.show', [$form->id, 'print' => 'true']) }}" target="_blank" class="text-emerald-600 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 h-[40px] w-[40px] flex items-center justify-center rounded-lg transition-colors" title="Cetak / Lihat PDF">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        </a>
                        <form action="{{ route('form-pemeliharaan-ac.destroy', $form->id) }}" method="POST" class="inline-block m-0">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete(this.form)" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 h-[40px] w-[40px] flex items-center justify-center rounded-lg transition-colors" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <p class="text-gray-900 font-semibold mb-1">Belum ada data formulir</p>
            <p class="text-sm text-gray-500 mb-6">Silakan buat formulir baru untuk memulai pencatatan.</p>
            <div class="flex items-center justify-center gap-2">
                <a href="{{ route('form-pemeliharaan-ac.create') }}" class="inline-flex items-center justify-center px-4 h-[40px] bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-colors w-auto">
                    Tambah
                </a>
            </div>
        </div>
        @endforelse
    </div>

    @if($forms->hasPages())
        <div class="mt-auto pt-6">
            {{ $forms->appends(request()->except('form_page'))->links('pagination::tailwind') }}
        </div>
    @endif
</div>

<!-- Master Data Section -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <!-- ID-AC -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex flex-col h-full">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <h2 class="text-lg font-bold text-gray-900">Data ID-AC</h2>
        </div>
        
        <form action="{{ route('master-ac.store') }}" method="POST" class="mb-6">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mb-3">
                <div>
                    <label class="block text-[12px] font-bold uppercase tracking-wider text-slate-500 mb-2">ID AC <span class="text-red-500 ml-1">*</span></label>
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 w-4 h-4 pointer-events-none z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                        <input type="text" name="id_ac" placeholder="Contoh: AC-01" required class="w-full h-[42px] pl-10 pr-3 border-2 border-slate-200 rounded-lg bg-slate-50 text-slate-900 text-sm font-medium focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-[12px] font-bold uppercase tracking-wider text-slate-500 mb-2">Lokasi <span class="text-red-500 ml-1">*</span></label>
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 w-4 h-4 pointer-events-none z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <input type="text" name="lokasi" placeholder="Lokasi" required class="w-full h-[42px] pl-10 pr-3 border-2 border-slate-200 rounded-lg bg-slate-50 text-slate-900 text-sm font-medium focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-[12px] font-bold uppercase tracking-wider text-slate-500 mb-2">Sub Lokasi</label>
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 w-4 h-4 pointer-events-none z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <input type="text" name="sub_lokasi" placeholder="Sub Lokasi" class="w-full h-[42px] pl-10 pr-3 border-2 border-slate-200 rounded-lg bg-slate-50 text-slate-900 text-sm font-medium focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-[12px] font-bold uppercase tracking-wider text-slate-500 mb-2">Jenis</label>
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 w-4 h-4 pointer-events-none z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        <input type="text" name="jenis" placeholder="Jenis" class="w-full h-[42px] pl-10 pr-3 border-2 border-slate-200 rounded-lg bg-slate-50 text-slate-900 text-sm font-medium focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-[12px] font-bold uppercase tracking-wider text-slate-500 mb-2">Merk</label>
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 w-4 h-4 pointer-events-none z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                        <input type="text" name="merk" placeholder="Merk" class="w-full h-[42px] pl-10 pr-3 border-2 border-slate-200 rounded-lg bg-slate-50 text-slate-900 text-sm font-medium focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-[12px] font-bold uppercase tracking-wider text-slate-500 mb-2">Kapasitas</label>
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 w-4 h-4 pointer-events-none z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        <input type="text" name="kapasitas" placeholder="Kapasitas" class="w-full h-[42px] pl-10 pr-3 border-2 border-slate-200 rounded-lg bg-slate-50 text-slate-900 text-sm font-medium focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-[12px] font-bold uppercase tracking-wider text-slate-500 mb-2">Tahun Pasang</label>
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 w-4 h-4 pointer-events-none z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <input type="text" name="tahun_pasang" placeholder="Tahun Pasang" class="w-full h-[42px] pl-10 pr-3 border-2 border-slate-200 rounded-lg bg-slate-50 text-slate-900 text-sm font-medium focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2 justify-end">
                <button type="button" onclick="document.getElementById('importAcModal').classList.remove('hidden')" class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white px-4 h-[42px] rounded-lg text-sm font-semibold transition-all shadow-sm focus:ring-4 focus:ring-green-500/20 shrink-0 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Import
                </button>
                <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-5 h-[42px] rounded-lg text-sm font-semibold transition-all shadow-sm focus:ring-4 focus:ring-blue-500/20 shrink-0">Tambah</button>
            </div>
        </form>

        <div class="space-y-2 mb-4 flex-1">
            @forelse($masterAcs as $ac)
                <div x-data="{ editing: false }" class="p-3 bg-gray-50 hover:bg-gray-100 transition-colors rounded-lg border border-gray-200">
                    <div x-show="!editing" class="flex items-start justify-between">
                        <div class="flex flex-col gap-1.5">
                            <div class="flex items-center gap-3">
                                <p class="font-semibold text-sm text-gray-900">{{ $ac->id_ac }}</p>
                                @if($ac->lokasi)
                                    <span class="text-xs text-gray-600 bg-gray-200 px-2 py-0.5 rounded-full">{{ $ac->lokasi }}</span>
                                @endif
                            </div>
                            <div class="flex flex-wrap items-center gap-1.5">
                                @if($ac->sub_lokasi)
                                    <span class="text-xs text-blue-700 bg-blue-50 px-2 py-0.5 rounded-full">Sub: {{ $ac->sub_lokasi }}</span>
                                @endif
                                @if($ac->jenis)
                                    <span class="text-xs text-purple-700 bg-purple-50 px-2 py-0.5 rounded-full">{{ $ac->jenis }}</span>
                                @endif
                                @if($ac->merk)
                                    <span class="text-xs text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">{{ $ac->merk }}</span>
                                @endif
                                @if($ac->kapasitas)
                                    <span class="text-xs text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full">{{ $ac->kapasitas }}</span>
                                @endif
                                @if($ac->tahun_pasang)
                                    <span class="text-xs text-slate-700 bg-slate-100 px-2 py-0.5 rounded-full">{{ $ac->tahun_pasang }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <button @click="editing = true" type="button" class="text-amber-500 hover:text-amber-700 bg-amber-50 hover:bg-amber-100 h-[36px] w-[36px] flex items-center justify-center rounded-lg transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <form action="{{ route('master-ac.destroy', $ac->id) }}" method="POST" class="m-0">
                                @csrf @method('DELETE')
                                <button type="button" onclick="confirmDelete(this.form)" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 h-[36px] w-[36px] flex items-center justify-center rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <form x-show="editing" style="display: none;" action="{{ route('master-ac.update', $ac->id) }}" method="POST" class="flex flex-col gap-2 w-full m-0">
                        @csrf @method('PUT')
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" name="id_ac" value="{{ $ac->id_ac }}" required placeholder="ID AC" class="h-[36px] px-3 rounded-lg border border-gray-300 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                            <input type="text" name="lokasi" value="{{ $ac->lokasi }}" required placeholder="Lokasi" class="h-[36px] px-3 rounded-lg border border-gray-300 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                            <input type="text" name="sub_lokasi" value="{{ $ac->sub_lokasi }}" placeholder="Sub Lokasi" class="h-[36px] px-3 rounded-lg border border-gray-300 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                            <input type="text" name="jenis" value="{{ $ac->jenis }}" placeholder="Jenis" class="h-[36px] px-3 rounded-lg border border-gray-300 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                            <input type="text" name="merk" value="{{ $ac->merk }}" placeholder="Merk" class="h-[36px] px-3 rounded-lg border border-gray-300 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                            <input type="text" name="kapasitas" value="{{ $ac->kapasitas }}" placeholder="Kapasitas" class="h-[36px] px-3 rounded-lg border border-gray-300 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                            <input type="text" name="tahun_pasang" value="{{ $ac->tahun_pasang }}" placeholder="Tahun Pasang" class="h-[36px] px-3 rounded-lg border border-gray-300 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                        </div>
                        <div class="flex gap-2 justify-end">
                            <button type="button" @click="editing = false" class="bg-red-500 hover:bg-red-600 text-white px-4 h-[32px] rounded-lg text-sm font-semibold transition-colors shadow-sm">Batal</button>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 h-[32px] rounded-lg text-sm font-semibold transition-colors shadow-sm">Simpan</button>
                        </div>
                    </form>
                </div>
            @empty
                <p class="text-sm text-gray-500 text-center py-4">Belum ada data ID-AC</p>
            @endforelse
        </div>
        
        @if($masterAcs->hasPages())
            <div class="mt-auto pt-4 border-t border-gray-50">
                {{ $masterAcs->appends(request()->except('ac_page'))->links('pagination::tailwind') }}
            </div>
        @endif
    </div>

    <!-- Master Signer -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex flex-col h-full">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            </div>
            <h2 class="text-lg font-bold text-gray-900">Data Penandatangan Formulir</h2>
        </div>
        
        <form action="{{ route('master-signer.store') }}" method="POST" class="flex items-end gap-3 mb-6">
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
                <div x-data="{ editing: false }" class="p-3 bg-gray-50 hover:bg-gray-100 transition-colors rounded-lg border border-gray-200">
                    <div x-show="!editing" class="flex items-center justify-between">
                        <div class="flex flex-wrap items-center gap-2 pr-2">
                            <p class="font-semibold text-sm text-gray-900" style="word-break: break-word;">{{ $signer->nama }}</p>
                            @if($signer->nipp)
                                <span class="text-xs text-gray-600 bg-gray-200 px-2 py-0.5 rounded-full whitespace-nowrap shrink-0">NIPP: {{ $signer->nipp }}</span>
                            @endif
                            @if($signer->jabatan)
                                <span class="text-xs text-gray-600 bg-gray-200 px-2 py-0.5 rounded-full text-center" style="word-break: break-word;">{{ $signer->jabatan }}</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <button @click="editing = true" type="button" class="text-amber-500 hover:text-amber-700 bg-amber-50 hover:bg-amber-100 h-[36px] w-[36px] flex items-center justify-center rounded-lg transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <form action="{{ route('master-signer.destroy', $signer->id) }}" method="POST" class="m-0">
                                @csrf @method('DELETE')
                                <button type="button" onclick="confirmDelete(this.form)" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 h-[36px] w-[36px] flex items-center justify-center rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <form x-show="editing" style="display: none;" action="{{ route('master-signer.update', $signer->id) }}" method="POST" class="flex flex-col gap-2 w-full m-0">
                        @csrf @method('PUT')
                        <div class="flex flex-col gap-2">
                            <input type="text" name="nama" value="{{ $signer->nama }}" required class="w-full h-[36px] px-3 rounded-lg border border-gray-300 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                            <input type="text" name="nipp" value="{{ $signer->nipp }}" required class="w-full h-[36px] px-3 rounded-lg border border-gray-300 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                            <input type="text" name="jabatan" value="{{ $signer->jabatan }}" class="w-full h-[36px] px-3 rounded-lg border border-gray-300 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                        </div>
                        <div class="flex gap-2 justify-end">
                            <button type="button" @click="editing = false" class="bg-red-500 hover:bg-red-600 text-white px-4 h-[32px] rounded-lg text-sm font-semibold transition-colors shadow-sm">Batal</button>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 h-[32px] rounded-lg text-sm font-semibold transition-colors shadow-sm">Simpan</button>
                        </div>
                    </form>
                </div>
            @empty
                <p class="text-sm text-gray-500 text-center py-4">Belum ada data Penandatangan</p>
            @endforelse
        </div>
        
        @if($masterSigners->hasPages())
            <div class="mt-auto pt-4 border-t border-gray-50">
                {{ $masterSigners->appends(request()->except('signer_page'))->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>

<!-- Import Excel Modal for Master AC -->
<div id="importAcModal" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 m-4" style="font-family: 'Inter', sans-serif;">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900 m-0">Import Data AC</h3>
            <button type="button" onclick="document.getElementById('importAcModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition-colors bg-transparent border-none cursor-pointer">
                <svg class="w-6 h-6" style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form action="{{ route('master-ac.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-5">
                <p class="text-sm text-gray-600 mb-3 mt-0">Silakan unduh template Excel terlebih dahulu untuk memastikan format kolom Anda sesuai.</p>
                <a href="{{ route('master-ac.template') }}" class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800 hover:underline mb-4" style="text-decoration: none;">
                    <svg class="w-4 h-4" style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download Template Excel (XLSX)
                </a>
                
                <label class="block text-[12px] font-bold uppercase tracking-wider text-slate-500 mb-2">File Excel <span class="text-red-500 ml-1">*</span></label>
                <div class="relative flex items-center border-2 border-slate-200 rounded-lg bg-slate-50 hover:bg-slate-100 transition-colors cursor-pointer w-full h-[42px] px-3 focus-within:border-blue-500 focus-within:ring-4 focus-within:ring-blue-500/10">
                    <input type="file" name="file" accept=".xlsx, .xls, .csv" required class="w-full text-sm text-slate-700 file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer outline-none">
                </div>
            </div>
            
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="document.getElementById('importAcModal').classList.add('hidden')" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 h-[42px] rounded-lg text-sm font-semibold transition-all border-none cursor-pointer">Batal</button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 h-[42px] rounded-lg text-sm font-semibold transition-all shadow-sm border-none cursor-pointer">Import Data</button>
            </div>
        </form>
    </div>
</div>

<script>
function confirmDelete(form) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        customClass: {
            container: 'font-sans'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
</script>

@endsection
