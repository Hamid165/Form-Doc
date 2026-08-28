@extends('layouts.app')

@section('title', 'Secure Operation Formulir Checklist 05')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <div class="mb-6">
        <a href="{{ url('/katalog') }}" class="flex items-center text-sm text-gray-500 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Katalog
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg flex items-center justify-between shadow-sm">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.style.display='none'" class="text-green-700 font-bold">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-200 text-red-700 rounded-lg flex items-center justify-between shadow-sm">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.style.display='none'" class="text-red-700 font-bold">&times;</button>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Formulir Secure Implement</h2>
                    <p class="text-sm text-gray-500">Daftar semua formulir checklist 05 secure implement</p>
                </div>
            </div>
            
            <div class="mt-4 md:mt-0 flex gap-3 w-full md:w-auto">
                <div class="relative flex-1 md:w-64">
                    <svg class="w-4 h-4 absolute left-3 top-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" placeholder="Cari data..." class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <a href="{{ route('form-secure-operation.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors">
                    Tambah Formulir
                </a>
            </div>
        </div>

        <div class="space-y-3">
            <div class="hidden md:grid grid-cols-4 gap-4 px-4 py-2 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase">
                <div>Nama Aplikasi</div>
                <div>Versi / Modul</div>
                <div>Tanggal Checklist</div>
                <div class="text-right">Aksi</div>
            </div>

            @forelse($incidents as $incident)
                <div class="flex flex-col md:flex-row items-center justify-between p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition-colors">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 w-full">
                        <div class="text-sm font-bold text-gray-800">{{ $incident->nama_aplikasi }}</div>
                        <div class="text-sm text-gray-600">{{ $incident->versi_aplikasi }} / {{ $incident->modul }}</div>
                        <div class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($incident->tanggal_checklist)->format('d M Y') }}</div>
                    </div>
                    
                    <div class="flex items-center gap-2 mt-4 md:mt-0">
                        <a href="{{ route('form-secure-operation.show', $incident->id) }}" class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg" title="Lihat">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </a>
                        <a href="{{ route('form-secure-operation.edit', $incident->id) }}" class="p-2 text-yellow-600 bg-yellow-50 hover:bg-yellow-100 rounded-lg" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <a href="{{ route('form-secure-operation.show', [$incident->id, 'print' => 'yes']) }}" target="_blank" class="p-2 text-green-600 bg-green-50 hover:bg-green-100 rounded-lg" title="Print">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        </a>
                        <form action="{{ route('form-secure-operation.destroy', $incident->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus formulir ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg" title="Hapus"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500 border border-dashed border-gray-200 rounded-xl">Belum ada data formulir.</div>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center gap-4 mb-6">
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            </div>
            <h2 class="text-xl font-bold text-gray-800">Data Penandatangan Formulir</h2>
        </div>

        <div class="grid grid-cols-12 gap-4 mb-2 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">
            <div class="col-span-3">NAMA</div>
            <div class="col-span-4">JABATAN</div>
            <div class="col-span-3">NIPP</div>
            <div class="col-span-2 text-right">AKSI</div>
        </div>

        <form action="{{ route('signer.baru') }}" method="POST" class="mb-6 px-4">
            @csrf
            <div class="grid grid-cols-12 gap-4 items-center">
                <div class="col-span-3">
                    <input type="text" name="nama" placeholder="Nama Lengkap" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm" required>
                </div>
                <div class="col-span-4">
                    <input type="text" name="jabatan" placeholder="Jabatan" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
                <div class="col-span-3">
                    <input type="text" name="nipp" placeholder="NIPP" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm" required>
                </div>
                <div class="col-span-2 flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors text-sm w-full">Tambah</button>
                </div>
            </div>
        </form>

        <hr class="border-gray-100 mb-4">

        <div class="space-y-2">
            @forelse($signers as $signer)
                <div id="view-row-{{ $signer->id }}" class="grid grid-cols-12 gap-4 items-center px-4 py-3 border border-gray-100 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="col-span-3 font-bold text-gray-800 text-sm">{{ $signer->nama }}</div>
                    <div class="col-span-4 text-sm text-gray-500">{{ $signer->jabatan ?: '-' }}</div>
                    <div class="col-span-3 text-sm text-gray-500">NIPP: {{ $signer->nipp }}</div>
                    
                    <div class="col-span-2 flex items-center justify-end gap-2">
                        <button type="button" onclick="toggleEdit('{{ $signer->id }}')" class="p-1.5 text-yellow-500 hover:bg-yellow-50 rounded-md transition-colors" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        
                        <form action="{{ route('signer.buang', $signer->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus penandatangan ini?');">
                            @csrf 
                            <button type="submit" class="p-1.5 text-red-500 hover:bg-red-50 rounded-md transition-colors" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <form id="edit-row-{{ $signer->id }}" action="{{ route('signer.ubah', $signer->id) }}" method="POST" class="hidden grid grid-cols-12 gap-4 items-center px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 shadow-inner">
                    @csrf
                    
                    <div class="col-span-3">
                        <input type="text" name="nama" value="{{ $signer->nama }}" class="w-full px-3 py-1.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 text-sm" required>
                    </div>
                    <div class="col-span-4">
                        <input type="text" name="jabatan" value="{{ $signer->jabatan }}" class="w-full px-3 py-1.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                    <div class="col-span-3">
                        <input type="text" name="nipp" value="{{ $signer->nipp }}" class="w-full px-3 py-1.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 text-sm" required>
                    </div>
                    <div class="col-span-2 flex items-center justify-end gap-2">
                        <button type="button" onclick="toggleEdit('{{ $signer->id }}')" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-1.5 px-3 rounded-md transition-colors text-xs">Batal</button>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-1.5 px-3 rounded-md transition-colors text-xs">Simpan</button>
                    </div>
                </form>
            @empty
                <div class="text-center text-sm text-gray-500 py-4">Belum ada data penandatangan.</div>
            @endforelse
        </div>
    </div>
</div>

<script>
    function toggleEdit(id) {
        let viewRow = document.getElementById('view-row-' + id);
        let editRow = document.getElementById('edit-row-' + id);

        if (editRow.classList.contains('hidden')) {
            editRow.classList.remove('hidden');
            viewRow.classList.add('hidden');
        } else {
            editRow.classList.add('hidden');
            viewRow.classList.remove('hidden');
        }
    }
</script>
@endsection