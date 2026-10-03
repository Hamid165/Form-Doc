@extends('layouts.app')

@section('title', 'Formulir Laporan Backup')

@section('content')
    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
            class="mb-6 bg-[#f0fdf4] border border-[#bbf7d0] rounded-xl flex items-center p-3 relative shadow-sm">
            <div class="w-10 h-10 bg-[#dcfce7] rounded-lg flex items-center justify-center shrink-0 mr-4">
                <svg class="w-5 h-5 text-[#059669]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="flex flex-col">
                <h4 class="text-sm font-bold text-[#065f46] mb-0.5">Berhasil!</h4>
                <p class="text-[13px] font-medium text-[#059669]">{{ session('success') }}</p>
            </div>
            <button @click="show = false"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-[#10b981] hover:text-[#047857] transition-colors p-1 rounded-md hover:bg-[#dcfce7]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div x-data="{ show: true }" x-show="show" x-transition
            class="mb-6 bg-red-50 border border-red-200 rounded-xl flex items-center p-3 relative shadow-sm">
            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center shrink-0 mr-4">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="flex flex-col">
                <h4 class="text-sm font-bold text-red-800 mb-0.5">Terjadi Kesalahan!</h4>
                <ul class="text-[13px] font-medium text-red-600 list-none">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button @click="show = false"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-red-500 hover:text-red-700 transition-colors p-1 rounded-md hover:bg-red-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('formulir.index') }}"
            class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Kembali ke Katalog
        </a>
    </div>

    <!-- Bagian Tabel Utama Laporan Backup -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 flex flex-col mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-8 px-2">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center shadow-sm shrink-0">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2">
                        </path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">FORMULIR LAPORAN BACKUP</h1>
                    <p class="text-sm text-gray-500 mt-1">Daftar riwayat dan kelola formulir laporan backup</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <form action="{{ route('form-backup.index') }}" method="GET" class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="block w-56 pl-10 pr-3 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="Cari No. Ref...">
                </form>

                <a href="{{ route('form-backup.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-xl text-sm shadow-sm hover:bg-blue-700 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Buat Baru
                </a>
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-100 bg-white mb-4">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-[13px] font-semibold text-gray-600 uppercase tracking-wider">No. Ref</th>
                        <th class="px-6 py-4 text-left text-[13px] font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-[13px] font-semibold text-gray-600 uppercase tracking-wider">Business Area</th>
                        <th class="px-6 py-4 text-left text-[13px] font-semibold text-gray-600 uppercase tracking-wider">Penandatangan</th>
                        <th class="px-6 py-4 text-center text-[13px] font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 bg-white">
                    @forelse($forms as $form)
                        <tr class="hover:bg-blue-50/50 transition-colors group">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $form->no_ref }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $form->tanggal }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $form->business_area }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $form->mengetahui_nama ?: '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Tombol Preview -->
                                    <a href="{{ route('form-backup.show', $form->id) }}"
                                        class="p-1.5 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors" title="Preview">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </a>
                                    <!-- Tombol Cetak -->
                                    <a href="{{ route('form-backup.show', $form->id) }}?action=print" target="_blank"
                                        class="p-1.5 text-green-600 bg-green-50 hover:bg-green-100 rounded-lg transition-colors" title="Cetak Langsung">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                        </svg>
                                    </a>
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('form-backup.edit', $form->id) }}"
                                        class="p-1.5 text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors"
                                        title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>
                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('form-backup.destroy', $form->id) }}" method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus form ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="p-1.5 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors"
                                            title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada formulir</h3>
                                <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat form laporan backup baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($forms->hasPages())
            <div>{{ $forms->links() }}</div>
        @endif
    </div>

    <!-- WRAPPER ALPINE UNTUK MASTER DATA & MODAL EDIT -->
    <div x-data="{
        editModalOpen: false,
        editUrl: '',
        editKategori: '',
        editNama: '',
        editJabatan: '',
        editNipp: '',
        editLabelNama: 'Nama',
        editLabelJabatan: 'Jabatan',
        editLabelNipp: 'NIPP',
        showJabatan: false,
        showNipp: false,
    
        openEdit(url, kategori, nama, jabatan, nipp = '') {
            this.editUrl = url;
            this.editKategori = kategori;
            this.editNama = nama;
            this.editJabatan = jabatan;
            this.editNipp = nipp;
    
            if (kategori === 'pimpinan') {
                this.editLabelNama = 'Nama Lengkap';
                this.editLabelJabatan = 'Jabatan';
                this.showJabatan = true;
                this.showNipp = true;
            } else if (kategori === 'business_area') {
                this.editLabelNama = 'Kode BA (Misal: B060 - YK)';
                this.editLabelJabatan = 'Nama Kota (Misal: Yogyakarta)';
                this.showJabatan = true;
            } else {
                this.editLabelNama = 'Nama';
                this.showJabatan = false;
            }
            this.editModalOpen = true;
        }
    }">

        <!-- KELOMPOK 1: Master Data Tabel Utama (4 Kolom) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Metode -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <h3 class="font-bold text-gray-800 text-sm mb-3">Metode Backup</h3>
                <form action="{{ route('form-backup.master.store') }}" method="POST" class="flex gap-2 mb-3">
                    @csrf <input type="hidden" name="kategori" value="metode">
                    <input type="text" name="nama"
                        class="w-full border border-gray-300 rounded-lg px-2 py-1 text-sm" placeholder="Tambah..."
                        required>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded-lg text-sm font-medium">Simpan</button>
                </form>
                <div class="max-h-32 overflow-y-auto border border-gray-100 rounded-lg">
                    <table class="w-full text-sm text-left">
                        <tbody class="divide-y divide-gray-100">
                            @forelse($masterMetodes as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-2 py-1 text-gray-700">{{ $item->nama }}</td>
                                    <td class="px-2 py-1 text-right whitespace-nowrap">
                                        <div class="flex justify-end gap-1">
                                            <button type="button"
                                                @click="openEdit('{{ route('form-backup.master.update', $item->id) }}', 'metode', '{{ addslashes($item->nama) }}', '')"
                                                class="p-1.5 text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>
                                            <form action="{{ route('form-backup.master.destroy', $item->id) }}"
                                                method="POST" class="inline" onsubmit="return confirm('Hapus data ini?');">
                                                @csrf @method('DELETE') 
                                                <button type="submit" class="p-1.5 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty <tr>
                                    <td colspan="2" class="px-2 py-1 text-center text-xs text-gray-400">Kosong</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Periode -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <h3 class="font-bold text-gray-800 text-sm mb-3">Periode Backup</h3>
                <form action="{{ route('form-backup.master.store') }}" method="POST" class="flex gap-2 mb-3">
                    @csrf <input type="hidden" name="kategori" value="periode">
                    <input type="text" name="nama"
                        class="w-full border border-gray-300 rounded-lg px-2 py-1 text-sm" placeholder="Tambah..."
                        required>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded-lg text-sm font-medium">Simpan</button>
                </form>
                <div class="max-h-32 overflow-y-auto border border-gray-100 rounded-lg">
                    <table class="w-full text-sm text-left">
                        <tbody class="divide-y divide-gray-100">
                            @forelse($masterPeriodes as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-2 py-1 text-gray-700">{{ $item->nama }}</td>
                                    <td class="px-2 py-1 text-right whitespace-nowrap">
                                        <div class="flex justify-end gap-1">
                                            <button type="button"
                                                @click="openEdit('{{ route('form-backup.master.update', $item->id) }}', 'periode', '{{ addslashes($item->nama) }}', '')"
                                                class="p-1.5 text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>
                                            <form action="{{ route('form-backup.master.destroy', $item->id) }}"
                                                method="POST" class="inline" onsubmit="return confirm('Hapus?');">
                                                @csrf @method('DELETE') 
                                                <button type="submit" class="p-1.5 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty <tr>
                                    <td colspan="2" class="px-2 py-1 text-center text-xs text-gray-400">Kosong</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Retensi -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <h3 class="font-bold text-gray-800 text-sm mb-3">Retensi</h3>
                <form action="{{ route('form-backup.master.store') }}" method="POST" class="flex gap-2 mb-3">
                    @csrf <input type="hidden" name="kategori" value="retensi">
                    <input type="text" name="nama"
                        class="w-full border border-gray-300 rounded-lg px-2 py-1 text-sm" placeholder="Tambah..."
                        required>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded-lg text-sm font-medium">Simpan</button>
                </form>
                <div class="max-h-32 overflow-y-auto border border-gray-100 rounded-lg">
                    <table class="w-full text-sm text-left">
                        <tbody class="divide-y divide-gray-100">
                            @forelse($masterRetensis as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-2 py-1 text-gray-700">{{ $item->nama }}</td>
                                    <td class="px-2 py-1 text-right whitespace-nowrap">
                                        <div class="flex justify-end gap-1">
                                            <button type="button"
                                                @click="openEdit('{{ route('form-backup.master.update', $item->id) }}', 'retensi', '{{ addslashes($item->nama) }}', '')"
                                                class="p-1.5 text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>
                                            <form action="{{ route('form-backup.master.destroy', $item->id) }}"
                                                method="POST" class="inline" onsubmit="return confirm('Hapus?');">
                                                @csrf @method('DELETE') 
                                                <button type="submit" class="p-1.5 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty <tr>
                                    <td colspan="2" class="px-2 py-1 text-center text-xs text-gray-400">Kosong</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Status -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <h3 class="font-bold text-gray-800 text-sm mb-3">Status</h3>
                <form action="{{ route('form-backup.master.store') }}" method="POST" class="flex gap-2 mb-3">
                    @csrf <input type="hidden" name="kategori" value="status">
                    <input type="text" name="nama"
                        class="w-full border border-gray-300 rounded-lg px-2 py-1 text-sm" placeholder="Tambah..."
                        required>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded-lg text-sm font-medium">Simpan</button>
                </form>
                <div class="max-h-32 overflow-y-auto border border-gray-100 rounded-lg">
                    <table class="w-full text-sm text-left">
                        <tbody class="divide-y divide-gray-100">
                            @forelse($masterStatuses as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-2 py-1 text-gray-700">{{ $item->nama }}</td>
                                    <td class="px-2 py-1 text-right whitespace-nowrap">
                                        <div class="flex justify-end gap-1">
                                            <button type="button"
                                                @click="openEdit('{{ route('form-backup.master.update', $item->id) }}', 'status', '{{ addslashes($item->nama) }}', '')"
                                                class="p-1.5 text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>
                                            <form action="{{ route('form-backup.master.destroy', $item->id) }}"
                                                method="POST" class="inline" onsubmit="return confirm('Hapus?');">
                                                @csrf @method('DELETE') 
                                                <button type="submit" class="p-1.5 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty <tr>
                                    <td colspan="2" class="px-2 py-1 text-center text-xs text-gray-400">Kosong</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- KELOMPOK 2: Pimpinan Unit & Business Area (Sejajar Kiri-Kanan) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            <!-- Daftar Pimpinan Unit -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex flex-col">
                <div class="mb-4">
                    <h3 class="font-bold text-gray-800">Daftar Pimpinan Unit</h3>
                    <p class="text-xs text-gray-500 mt-1">Data penandatangan pada akhir dokumen laporan.</p>
                </div>

                <form action="{{ route('form-backup.master.store') }}" method="POST"
                    class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-5">
                    @csrf <input type="hidden" name="kategori" value="pimpinan">
                    <div>
                        <input type="text" name="jabatan"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500"
                            placeholder="Jabatan" required>
                    </div>
                    <div>
                        <input type="text" name="nama"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500"
                            placeholder="Nama Lengkap" required>
                    </div>
                    <div>
                        <input type="text" name="nipp"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500"
                            placeholder="NIPP" required>
                    </div>
                    <div class="sm:col-span-3">
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Tambah
                            Pimpinan</button>
                    </div>
                </form>

                <div class="overflow-y-auto flex-1 border border-gray-100 rounded-xl max-h-48">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 sticky top-0">
                            <tr>
                                <th class="px-4 py-2 text-xs font-semibold text-gray-600">Jabatan</th>
                                <th class="px-4 py-2 text-xs font-semibold text-gray-600">Nama Lengkap</th>
                                <th class="px-4 py-2 text-xs font-semibold text-gray-600">NIPP</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($masterPimpinans as $pimpinan)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 text-gray-700">{{ $pimpinan->jabatan }}</td>
                                    <td class="px-4 py-2 text-gray-700">{{ $pimpinan->nama }}</td>
                                    <td class="px-4 py-2 text-gray-700">{{ $pimpinan->nipp }}</td>
                                    <td class="px-4 py-2 text-center whitespace-nowrap">
                                        <div class="flex justify-center gap-2">
                                            <!-- Tombol Edit Icon -->
                                            <button type="button"
                                                @click="openEdit('{{ route('form-backup.master.update', $pimpinan->id) }}', 'pimpinan', '{{ addslashes($pimpinan->nama) }}', '{{ addslashes($pimpinan->jabatan) }}', '{{ addslashes($pimpinan->nipp) }}')"
                                                class="p-1.5 text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>

                                            <!-- Tombol Hapus Icon -->
                                            <form action="{{ route('form-backup.master.destroy', $pimpinan->id) }}"
                                                method="POST" class="inline-block"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-4 text-center text-gray-400 italic">Belum ada data.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Master Business Area -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex flex-col">
                <div class="mb-4">
                    <h3 class="font-bold text-gray-800">Daftar Business Area</h3>
                    <p class="text-xs text-gray-500 mt-1">Data lokasi BA yang akan mengatur otomatisasi kota tanda tangan.
                    </p>
                </div>

                <form action="{{ route('form-backup.master.store') }}" method="POST"
                    class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-5">
                    @csrf <input type="hidden" name="kategori" value="business_area">
                    <div>
                        <input type="text" name="nama"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500"
                            placeholder="Kode BA (Misal: B060 - YK)" required>
                    </div>
                    <div>
                        <!-- Disimpan ke kolom jabatan di database -->
                        <input type="text" name="jabatan"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500"
                            placeholder="Nama Kota (Misal: Yogyakarta)" required>
                    </div>
                    <div class="sm:col-span-2">
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Tambah
                            Business Area</button>
                    </div>
                </form>

                <div class="overflow-y-auto flex-1 border border-gray-100 rounded-xl max-h-48">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 sticky top-0">
                            <tr>
                                <th class="px-4 py-2 text-xs font-semibold text-gray-600">Kode Area</th>
                                <th class="px-4 py-2 text-xs font-semibold text-gray-600">Kota TTD</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($masterBusinessAreas ?? [] as $ba)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 text-gray-700 font-medium">{{ $ba->nama }}</td>
                                    <td class="px-4 py-2 text-gray-700">{{ $ba->jabatan }}</td>
                                    <td class="px-4 py-2 text-center whitespace-nowrap">
                                        <div class="flex justify-center gap-2">
                                            <!-- Tombol Edit Icon -->
                                            <button type="button"
                                                @click="openEdit('{{ route('form-backup.master.update', $ba->id) }}', 'business_area', '{{ addslashes($ba->nama) }}', '{{ addslashes($ba->jabatan) }}', '')"
                                                class="p-1.5 text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>

                                            <!-- Tombol Hapus Icon -->
                                            <form action="{{ route('form-backup.master.destroy', $ba->id) }}"
                                                method="POST" class="inline-block"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-4 text-center text-gray-400 italic">Belum ada data.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- MODAL EDIT MASTER DATA (Digerakkan oleh Alpine.js) -->
        <div x-show="editModalOpen" style="display: none;" class="relative z-50" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">

            <!-- Latar Belakang Abu-abu (Backdrop) -->
            <div x-show="editModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-600 bg-opacity-75 transition-opacity"></div>

            <!-- Posisi dan Pembungkus Modal (Z-index lebih tinggi) -->
            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

                    <!-- Kotak Putih Form Edit -->
                    <div x-show="editModalOpen" @click.away="editModalOpen = false"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                        <form :action="editUrl" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">Edit Data
                                    Master</h3>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1"
                                        x-text="editLabelNama"></label>
                                    <input type="text" name="nama" x-model="editNama"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500"
                                        required>
                                </div>

                                <div class="mb-2" x-show="showJabatan">
                                    <label class="block text-sm font-medium text-gray-700 mb-1"
                                        x-text="editLabelJabatan"></label>
                                    <input type="text" name="jabatan" x-model="editJabatan"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500">
                                </div>

                                <div class="mb-2" x-show="showNipp">
                                    <label class="block text-sm font-medium text-gray-700 mb-1"
                                        x-text="editLabelNipp"></label>
                                    <input type="text" name="nipp" x-model="editNipp"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500">
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-row-reverse gap-2">
                                <button type="submit"
                                    class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:w-auto sm:text-sm">Simpan
                                    Perubahan</button>
                                <button type="button" @click="editModalOpen = false"
                                    class="w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:w-auto sm:text-sm">Batal</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection