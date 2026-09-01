@extends('layouts.app')

@section('title', 'Formulir Checklist Pemeliharaan UPS')

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
                <!-- UPS Icon svg -->
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">FORMULIR CHECKLIST PEMELIHARAAN UPS</h1>
                <p class="text-sm text-gray-500 mt-1">Daftar semua formulir checklist pemeliharaan UPS</p>
            </div>
        </div>
        
        <div class="flex flex-wrap items-center gap-2" x-data="{
            searchQuery: '{{ request('search') }}',
            timeout: null,
            performSearch() {
                clearTimeout(this.timeout);
                this.timeout = setTimeout(() => {
                    window.location.href = '{{ route('form-pemeliharaan-ups.index') }}?search=' + encodeURIComponent(this.searchQuery);
                }, 800);
            }
        }">
            <div class="relative">
                <input type="text" x-model="searchQuery" @input="performSearch" placeholder="Cari No. Ref / Nomor Inventaris..." class="h-[40px] pl-9 pr-4 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors w-full sm:w-64">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <a href="{{ route('form-pemeliharaan-ups.create') }}" class="inline-flex items-center justify-center px-4 h-[40px] bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-colors">
                Tambah Formulir
            </a>
        </div>
    </div>

    <!-- List of Submissions -->
    <div id="ups-list-container" class="space-y-2 flex-1 flex flex-col">
        @forelse ($forms as $form)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center gap-4 hover:shadow-md transition-shadow group relative">
            <div class="flex-1 grid grid-cols-1 md:grid-cols-12 gap-4 items-start md:items-center">
                <div class="col-span-1 md:col-span-2">
                    <p class="text-xs text-gray-500 font-medium mb-0.5">No. Ref</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $form->no_ref ?: '-' }}</p>
                </div>
                <div class="col-span-1 md:col-span-2">
                    <p class="text-xs text-gray-500 font-medium mb-0.5">Nomor Inventaris</p>
                    <p class="text-sm font-medium text-gray-900">{{ $form->nomor_inventaris ?: '-' }}</p>
                </div>
                <div class="col-span-1 md:col-span-3">
                    <p class="text-xs text-gray-500 font-medium mb-0.5">Lokasi</p>
                    <p class="text-sm font-medium text-gray-900 truncate" title="{{ $form->lokasi }}">{{ $form->lokasi ?: '-' }}</p>
                </div>
                <div class="col-span-1 md:col-span-2">
                    <p class="text-xs text-gray-500 font-medium mb-0.5">Tanggal</p>
                    <p class="text-sm font-medium text-gray-900">{{ $form->tanggal ?: '-' }}</p>
                </div>
                <div class="col-span-1 md:col-span-3 flex justify-start md:justify-end items-center mt-2 md:mt-0">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('form-pemeliharaan-ups.show', $form->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 h-[40px] w-[40px] flex items-center justify-center rounded-lg transition-colors" title="Lihat Dokumen">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                        <a href="{{ route('form-pemeliharaan-ups.edit', $form->id) }}" class="text-amber-500 hover:text-amber-700 bg-amber-50 hover:bg-amber-100 h-[40px] w-[40px] flex items-center justify-center rounded-lg transition-colors" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <a href="{{ route('form-pemeliharaan-ups.show', $form->id) }}?print=true" target="_blank" class="text-emerald-600 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 h-[40px] w-[40px] flex items-center justify-center rounded-lg transition-colors" title="Cetak / Lihat PDF">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        </a>
                        <form action="{{ route('form-pemeliharaan-ups.destroy', $form->id) }}" method="POST" class="inline-block m-0">
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
    <!-- Nomor Inventaris -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex flex-col h-full">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <h2 class="text-lg font-bold text-gray-900">Data Nomor Inventaris</h2>
        </div>
        
        <form action="{{ route('master-ups.store') }}" method="POST" class="flex flex-col sm:flex-row items-stretch sm:items-end gap-3 mb-6">
            @csrf
            <div class="flex-1">
                <label class="block text-[12px] font-bold uppercase tracking-wider text-slate-500 mb-2">Nomor Inventaris <span class="text-red-500 ml-1">*</span></label>
                <div class="relative">
                    <input type="text" name="nomor_inventaris" placeholder="Nomor Inventaris" required class="w-full h-[42px] px-3 border-2 border-slate-200 rounded-lg bg-slate-50 text-slate-900 text-sm font-medium focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                </div>
            </div>
            <div class="flex-1">
                <label class="block text-[12px] font-bold uppercase tracking-wider text-slate-500 mb-2">Lokasi <span class="text-red-500 ml-1">*</span></label>
                <div class="relative">
                    <input type="text" name="lokasi" placeholder="Lokasi" required class="w-full h-[42px] px-3 border-2 border-slate-200 rounded-lg bg-slate-50 text-slate-900 text-sm font-medium focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                </div>
            </div>
            <div class="flex items-center gap-2 mt-2 sm:mt-0">
                <button type="button" onclick="document.getElementById('importUpsModal').classList.remove('hidden')" class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white px-4 h-[42px] rounded-lg text-sm font-semibold transition-all shadow-sm shrink-0 flex items-center justify-center gap-2">
                    Import
                </button>
                <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-5 h-[42px] rounded-lg text-sm font-semibold transition-all shadow-sm shrink-0">Tambah</button>
            </div>
        </form>

        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="pb-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Nomor Inventaris</th>
                        <th class="pb-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Lokasi</th>
                        <th class="pb-3 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($masterUps as $ups)
                    <tr x-data="{ editing: false, nomor_inventaris: '{{ $ups->nomor_inventaris }}', lokasi: '{{ $ups->lokasi }}' }">
                        <td class="py-3.5 text-sm font-medium text-gray-900">
                            <span x-show="!editing" x-text="nomor_inventaris"></span>
                            <input x-show="editing" type="text" x-model="nomor_inventaris" class="px-2 py-1 text-xs border rounded w-full">
                        </td>
                        <td class="py-3.5 text-sm text-gray-600">
                            <span x-show="!editing" x-text="lokasi"></span>
                            <input x-show="editing" type="text" x-model="lokasi" class="px-2 py-1 text-xs border rounded w-full">
                        </td>
                        <td class="py-3.5 text-right">
                            <div class="flex justify-end gap-1.5">
                                <button x-show="!editing" @click="editing = true" class="p-1.5 text-gray-400 hover:text-amber-500 rounded transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button x-show="editing" @click="
                                    editing = false;
                                    var form = document.createElement('form');
                                    form.method = 'POST';
                                    form.action = '{{ route('master-ups.update', $ups->id) }}';
                                    form.innerHTML = `<input type='hidden' name='_token' value='{{ csrf_token() }}'><input type='hidden' name='_method' value='PUT'><input type='hidden' name='nomor_inventaris' value='${nomor_inventaris}'><input type='hidden' name='lokasi' value='${lokasi}'>`;
                                    document.body.appendChild(form);
                                    form.submit();
                                " class="p-1.5 text-emerald-600 hover:text-emerald-800 rounded transition-colors" title="Simpan">
                                    ✓
                                </button>
                                <button x-show="editing" @click="editing = false; nomor_inventaris='{{ $ups->nomor_inventaris }}'; lokasi='{{ $ups->lokasi }}';" class="p-1.5 text-red-600 hover:text-red-800 rounded transition-colors" title="Batal">
                                    ✕
                                </button>
                                <form action="{{ route('master-ups.destroy', $ups->id) }}" method="POST" class="inline m-0" x-show="!editing">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete(this.form)" class="p-1.5 text-gray-400 hover:text-red-500 rounded transition-colors" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-4 text-sm text-gray-500 text-center">Belum ada master data UPS.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($masterUps->hasPages())
        <div class="mt-4">
            {{ $masterUps->appends(request()->except('ups_page'))->links('pagination::tailwind') }}
        </div>
        @endif
    </div>

    <!-- Signers List -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex flex-col h-full">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            </div>
            <h2 class="text-lg font-bold text-gray-900">Data Penandatangan / Pejabat Mengetahui</h2>
        </div>
        
        <form action="{{ route('master-signer.store') }}" method="POST" class="flex flex-col sm:flex-row items-stretch sm:items-end gap-3 mb-6">
            @csrf
            <div class="flex-1">
                <label class="block text-[12px] font-bold uppercase tracking-wider text-slate-500 mb-2">Nama <span class="text-red-500 ml-1">*</span></label>
                <div class="relative">
                    <input type="text" name="nama" placeholder="Nama" required class="w-full h-[42px] px-3 border-2 border-slate-200 rounded-lg bg-slate-50 text-slate-900 text-sm font-medium focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                </div>
            </div>
            <div class="flex-1">
                <label class="block text-[12px] font-bold uppercase tracking-wider text-slate-500 mb-2">NIPP <span class="text-red-500 ml-1">*</span></label>
                <div class="relative">
                    <input type="text" name="nipp" placeholder="NIPP" required class="w-full h-[42px] px-3 border-2 border-slate-200 rounded-lg bg-slate-50 text-slate-900 text-sm font-medium focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                </div>
            </div>
            <div class="flex-1">
                <label class="block text-[12px] font-bold uppercase tracking-wider text-slate-500 mb-2">Jabatan</label>
                <div class="relative">
                    <input type="text" name="jabatan" placeholder="Jabatan" class="w-full h-[42px] px-3 border-2 border-slate-200 rounded-lg bg-slate-50 text-slate-900 text-sm font-medium focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                </div>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 h-[42px] rounded-lg text-sm font-semibold transition-all shadow-sm focus:ring-4 focus:ring-blue-500/20 shrink-0">Tambah</button>
        </form>

        <div class="space-y-2 mb-4 flex-1">
            @forelse($masterSigners as $signer)
                <div x-data="{ editing: false, nama: '{{ $signer->nama }}', nipp: '{{ $signer->nipp }}', jabatan: '{{ $signer->jabatan }}' }" class="p-3 bg-gray-50 hover:bg-gray-100 transition-colors rounded-lg border border-gray-200">
                    <div x-show="!editing" class="flex items-center justify-between">
                        <div class="flex flex-wrap items-center gap-2 pr-2">
                            <p class="font-semibold text-sm text-gray-900" style="word-break: break-word;" x-text="nama"></p>
                            <span class="text-xs text-gray-600 bg-gray-200 px-2 py-0.5 rounded-full whitespace-nowrap shrink-0" x-text="'NIPP: ' + nipp"></span>
                            <span class="text-xs text-gray-600 bg-gray-200 px-2 py-0.5 rounded-full text-center" style="word-break: break-word;" x-show="jabatan" x-text="jabatan"></span>
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
                        <div class="flex gap-2">
                            <input type="text" name="nama" x-model="nama" required class="flex-1 min-w-0 h-[36px] px-3 rounded-lg border border-gray-300 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none" placeholder="Nama">
                            <input type="text" name="nipp" x-model="nipp" required class="flex-1 min-w-0 h-[36px] px-3 rounded-lg border border-gray-300 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none" placeholder="NIPP">
                            <input type="text" name="jabatan" x-model="jabatan" class="flex-1 min-w-0 h-[36px] px-3 rounded-lg border border-gray-300 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none" placeholder="Jabatan">
                        </div>
                        <div class="flex gap-2 justify-end">
                            <button type="button" @click="editing = false; nama='{{ $signer->nama }}'; nipp='{{ $signer->nipp }}'; jabatan='{{ $signer->jabatan }}';" class="bg-red-500 hover:bg-red-600 text-white px-4 h-[32px] rounded-lg text-sm font-semibold transition-colors shadow-sm">Batal</button>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 h-[32px] rounded-lg text-sm font-semibold transition-colors shadow-sm">Simpan</button>
                        </div>
                    </form>
                </div>
            @empty
                <p class="text-sm text-gray-500 text-center py-4">Belum ada pejabat terdaftar.</p>
            @endforelse
        </div>

        @if($masterSigners->hasPages())
            <div class="mt-auto pt-4 border-t border-gray-50">
                {{ $masterSigners->appends(request()->except('signer_page'))->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>

<!-- Import Modal for UPS Assets -->
<div id="importUpsModal" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 m-4" style="font-family: 'Inter', sans-serif;">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900 m-0">Import Data UPS</h3>
            <button type="button" onclick="document.getElementById('importUpsModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition-colors bg-transparent border-none cursor-pointer">
                ✕
            </button>
        </div>
        
        <form action="{{ route('master-ups.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-5">
                <p class="text-sm text-gray-600 mb-3 mt-0">Upload file Excel (.xlsx / .csv) berisi kolom: <strong>No ID</strong> dan <strong>Lokasi</strong>.</p>
                <a href="{{ route('master-ups.template') }}" class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800 hover:underline mb-4" style="text-decoration: none;">
                    Download Template Excel
                </a>
                
                <label class="block text-[12px] font-bold uppercase tracking-wider text-slate-500 mb-2">File Excel <span class="text-red-500 ml-1">*</span></label>
                <input type="file" name="file" accept=".xlsx, .xls, .csv" required class="w-full border rounded-lg p-2 text-sm">
            </div>
            
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="document.getElementById('importUpsModal').classList.add('hidden')" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 h-[42px] rounded-lg text-sm font-semibold transition-all border-none cursor-pointer">Batal</button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 h-[42px] rounded-lg text-sm font-semibold transition-all shadow-sm border-none cursor-pointer">Import Data</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
function confirmDelete(form) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data ini akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
</script>
@endsection
