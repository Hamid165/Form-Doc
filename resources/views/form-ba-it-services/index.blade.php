@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <a href="{{ route('formulir.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-2 mb-4 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Katalog
    </a>
    <!-- 1. Card Tabel Riwayat BA IT -->
    <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-xl font-bold text-gray-900">Berita Acara Instalasi dan Troubleshooting Layanan IT</h1>
                <p class="text-sm text-gray-500 mt-1">Daftar riwayat penanganan troubleshooting layanan IT</p>
            </div>
            
            <a href="{{ route('ba-it.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition-colors">
                Tambah Formulir
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 text-green-700 rounded-lg text-sm font-medium border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="py-3 px-4 text-sm font-bold text-gray-500">Tgl Dibuat</th>
                        <th class="py-3 px-4 text-sm font-bold text-gray-500">Nama Pemohon</th>
                        <th class="py-3 px-4 text-sm font-bold text-gray-500">Unit</th>
                        <th class="py-3 px-4 text-sm font-bold text-gray-500 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($baItServices as $ba)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4 text-sm text-gray-900">{{ \Carbon\Carbon::parse($ba->created_at)->format('d M Y') }}</td>
                        <td class="py-3 px-4 text-sm text-gray-900">{{ $ba->pemohon_nama }}</td>
                        <td class="py-3 px-4 text-sm text-gray-900">{{ $ba->pemohon_unit }}</td>
                        <td class="py-3 px-4 flex justify-center gap-2">
                            <a href="{{ route('ba-it.show', $ba->id) }}" class="p-1.5 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            <a href="{{ route('ba-it.edit', $ba->id) }}" class="p-1.5 text-amber-500 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <a href="{{ route('ba-it.pdf', $ba->id) }}" target="_blank" class="p-1.5 text-emerald-500 hover:bg-emerald-50 rounded-lg transition-colors" title="Cetak PDF">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            </a>
                            <form action="{{ route('ba-it.destroy', $ba->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus formulir ini?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-6 text-center text-gray-500 text-sm">Belum ada data formulir yang ditambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 2. Card Master Data Penandatangan -->
    <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200 w-full lg:w-3/4">
        <div class="flex items-center gap-2 mb-6">
            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            <h2 class="text-lg font-bold text-gray-900">Data Penandatangan Formulir</h2>
        </div>

        <!-- Form Tambah Data Signer -->
        <form action="{{ route('ba-it-signer.store') }}" method="POST" class="mb-6">
            @csrf
            <div class="grid grid-cols-12 gap-3 items-end">
                <div class="col-span-3">
                    <label class="block text-xs font-bold text-gray-500 mb-1">NAMA <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <input type="text" name="nama" placeholder="Nama" class="block w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                </div>
                <div class="col-span-3">
                    <label class="block text-xs font-bold text-gray-500 mb-1">NIPP <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                        </div>
                        <input type="text" name="nipp" placeholder="NIPP" class="block w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                </div>
                <div class="col-span-4">
                    <label class="block text-xs font-bold text-gray-500 mb-1">JABATAN</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <input type="text" name="jabatan" placeholder="Jabatan" class="block w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="col-span-2">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-sm font-semibold transition-colors">
                        Tambah
                    </button>
                </div>
            </div>
        </form>

        <!-- Daftar Signer (Master Data) -->
        <div class="space-y-3">
            @forelse($signers as $signer)
            <div class="flex items-center justify-between p-3 border border-gray-100 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                <div class="flex items-center gap-3">
                    <span class="text-sm font-bold text-gray-900">{{ $signer->nama }}</span>
                    <span class="px-2 py-1 bg-gray-200 text-gray-700 text-[11px] font-semibold rounded-md">NIPP: {{ $signer->nipp }}</span>
                    <span class="px-2 py-1 bg-gray-200 text-gray-700 text-[11px] font-semibold rounded-md">{{ $signer->jabatan }}</span>
                </div>
                
                <!-- Tombol Edit/Delete (Saat ini sekadar UI mengikuti tampilan aslinya, bisa disambung ke route controller MasterSigner jika diperlukan) -->
                <div class="flex gap-2">
                    <button type="button" class="p-1.5 text-amber-500 hover:bg-amber-50 rounded-lg transition-colors" title="Edit Data">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </button>
                    <button type="button" class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Data">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            </div>
            @empty
            <div class="text-center py-4 text-gray-500 text-sm">
                Belum ada data penandatangan.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection