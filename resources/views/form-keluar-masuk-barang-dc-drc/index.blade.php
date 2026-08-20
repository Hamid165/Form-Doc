@extends('layouts.app')

@section('title', 'Keluar/Masuk Barang DC/DRC')

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

<!-- Breadcrumb -->
<div class="mb-4">
    <a href="{{ route('formulir.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Katalog
    </a>
</div>

<!-- Tabs -->
<div class="flex space-x-2 mb-6">
    <a href="{{ route('form-keluar-masuk-barang-dc-drc.index') }}" class="px-4 py-2 {{ $activeTab === 'formulir' ? 'bg-white border border-gray-200 text-blue-600 shadow-sm' : 'bg-gray-100 border border-transparent text-gray-600 hover:bg-gray-200' }} rounded-lg text-sm font-medium transition-colors">Daftar Formulir</a>
    <a href="{{ route('form-keluar-masuk-barang-dc-drc.index', ['tab' => 'master']) }}" class="px-4 py-2 {{ $activeTab === 'master' ? 'bg-white border border-gray-200 text-blue-600 shadow-sm' : 'bg-gray-100 border border-transparent text-gray-600 hover:bg-gray-200' }} rounded-lg text-sm font-medium transition-colors">Master Petugas</a>
</div>

<!-- Content Wrapper -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 flex flex-col h-full min-h-[500px] mb-6">
    @if($activeTab === 'formulir')
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-8 px-2">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center shadow-sm shrink-0">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">KELUAR/MASUK BARANG DC/DRC</h1>
                    <p class="text-sm text-gray-500 mt-1">Daftar semua formulir keluar/masuk barang</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <!-- Search -->
                <div class="relative" x-data="{ searchQuery: '{{ request('search') }}', timeout: null }">
                    <input type="text"
                        x-model="searchQuery"
                        @input="clearTimeout(timeout); timeout = setTimeout(() => { window.location = '{{ route('form-keluar-masuk-barang-dc-drc.index') }}?search=' + encodeURIComponent(searchQuery) }, 500)"
                        placeholder="Cari data..."
                        class="pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none w-64 bg-gray-50">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                <!-- Tambah Formulir -->
                <a href="{{ route('form-keluar-masuk-barang-dc-drc.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Formulir
                </a>
            </div>
        </div>

        <!-- List Data -->
        @if($forms->isEmpty())
            <!-- Empty State -->
            <div class="flex-1 flex flex-col items-center justify-center py-16">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">Belum ada data formulir keluar/masuk barang</h3>
                <p class="text-sm text-gray-500 mb-6">Mulai dengan menambahkan formulir baru</p>
                <a href="{{ route('form-keluar-masuk-barang-dc-drc.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Formulir
                </a>
            </div>
        @else
            <!-- Table List -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-4 font-semibold text-gray-600 uppercase text-xs tracking-wider">No Ref</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-600 uppercase text-xs tracking-wider">Tanggal</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-600 uppercase text-xs tracking-wider">Jenis</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-600 uppercase text-xs tracking-wider">Pemohon</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-600 uppercase text-xs tracking-wider">Business Area</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-600 uppercase text-xs tracking-wider">Jumlah Aset</th>
                            <th class="text-right py-3 px-4 font-semibold text-gray-600 uppercase text-xs tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($forms as $form)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3.5 px-4">
                                <span class="font-semibold text-gray-900">{{ $form->no_ref }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-gray-600">{{ $form->tanggal ?? '-' }}</td>
                            <td class="py-3.5 px-4">
                                @if($form->jenis === 'masuk')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                        Barang Masuk
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-700">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                        Barang Keluar
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-gray-700">{{ $form->nama_pemohon }}</td>
                            <td class="py-3.5 px-4 text-gray-600">{{ $form->business_area ?? '-' }}</td>
                            <td class="py-3.5 px-4 text-gray-600">{{ $form->items->count() }} item</td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('form-keluar-masuk-barang-dc-drc.show', $form->id) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('form-keluar-masuk-barang-dc-drc.show', $form->id) }}?print=true" target="_blank" class="p-2 text-blue-500 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors" title="Cetak/Export">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    </a>
                                    <a href="{{ route('form-keluar-masuk-barang-dc-drc.edit', $form->id) }}" class="p-2 text-amber-500 hover:text-amber-700 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('form-keluar-masuk-barang-dc-drc.destroy', $form->id) }}" method="POST" class="inline" x-data
                                        @submit.prevent="Swal.fire({title: 'Hapus formulir?', text: 'Data yang dihapus tidak dapat dikembalikan.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#EF4444', cancelButtonColor: '#6B7280', confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal'}).then((r) => { if(r.isConfirmed) $el.closest('form').submit() })">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 px-2">
                {{ $forms->links() }}
            </div>
        @endif
    @else
        <!-- Master Data Tab -->
        <!-- Form Tambah -->
        <div class="bg-gray-50 rounded-xl p-6 mb-6 border border-gray-200">
            <h3 class="text-sm font-bold text-gray-700 mb-4">Tambah Petugas Baru</h3>
            <form action="{{ route('form-keluar-masuk-barang-dc-drc.master-signers.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Jabatan *</label>
                        <input type="text" name="jabatan" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                            placeholder="Contoh: Manager IT" value="{{ old('jabatan') }}">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Nama *</label>
                        <input type="text" name="nama" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                            placeholder="Contoh: Budi Santoso" value="{{ old('nama') }}">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">NIPP *</label>
                        <input type="text" name="nipp" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                            placeholder="Contoh: 1234567890" value="{{ old('nipp') }}">
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Petugas
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabel Data -->
        @if($signers->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left py-3 px-4 font-semibold text-gray-600 text-xs tracking-wider border-r border-gray-200">#</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-600 text-xs tracking-wider border-r border-gray-200">Jabatan</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-600 text-xs tracking-wider border-r border-gray-200">Nama</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-600 text-xs tracking-wider border-r border-gray-200">NIPP</th>
                        <th class="text-center py-3 px-4 font-semibold text-gray-600 text-xs tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($signers as $index => $signer)
                    <tr class="hover:bg-gray-50 transition-colors" x-data="{ editing: false }">
                        {{-- View Mode --}}
                        <td class="py-3 px-4 text-gray-500 border-r border-gray-200" x-show="!editing">{{ $index + 1 }}</td>
                        <td class="py-3 px-4 font-medium text-gray-900 border-r border-gray-200" x-show="!editing">{{ $signer->jabatan }}</td>
                        <td class="py-3 px-4 text-gray-700 border-r border-gray-200" x-show="!editing">{{ $signer->nama }}</td>
                        <td class="py-3 px-4 text-gray-600 border-r border-gray-200" x-show="!editing">{{ $signer->nipp }}</td>
                        <td class="py-3 px-4" x-show="!editing">
                            <div class="flex items-center justify-center gap-2">
                                <button @click="editing = true" class="p-2 text-amber-500 hover:text-amber-700 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form action="{{ route('form-keluar-masuk-barang-dc-drc.master-signers.destroy', $signer->id) }}" method="POST" class="inline" x-data
                                    @submit.prevent="Swal.fire({title: 'Hapus data?', text: '{{ $signer->nama }} - {{ $signer->jabatan }}', icon: 'warning', showCancelButton: true, confirmButtonColor: '#EF4444', cancelButtonColor: '#6B7280', confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal'}).then((r) => { if(r.isConfirmed) $el.closest('form').submit() })">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>

                        {{-- Edit Mode --}}
                        <td colspan="5" class="p-4 bg-blue-50 border-b border-blue-100" x-show="editing" x-cloak>
                            <form action="{{ route('form-keluar-masuk-barang-dc-drc.master-signers.update', $signer->id) }}" method="POST" class="flex items-end gap-3">
                                @csrf
                                @method('PUT')
                                <div class="flex-1">
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Jabatan</label>
                                    <input type="text" name="jabatan" value="{{ $signer->jabatan }}" required
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                                </div>
                                <div class="flex-1">
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nama</label>
                                    <input type="text" name="nama" value="{{ $signer->nama }}" required
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                                </div>
                                <div class="flex-1">
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">NIPP</label>
                                    <input type="text" name="nipp" value="{{ $signer->nipp }}" required
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                                </div>
                                <div class="flex gap-2">
                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-semibold hover:bg-green-700 transition-colors">Simpan</button>
                                    <button type="button" @click="editing = false" class="px-4 py-2 bg-gray-400 text-white rounded-lg text-sm font-semibold hover:bg-gray-500 transition-colors">Batal</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <!-- Empty State -->
        <div class="flex flex-col items-center justify-center py-12">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-gray-700 mb-1">Belum ada data petugas</h3>
            <p class="text-sm text-gray-500">Tambahkan data Pelaksana Pekerjaan dan Mengetahui menggunakan form di atas</p>
        </div>
        @endif
    @endif
</div>
@endsection
