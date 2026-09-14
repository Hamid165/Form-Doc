<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center gap-2 mb-6">
        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
        <h2 class="text-lg font-bold text-gray-800">
            {{ isset($editSigner) ? 'Edit Data Penanda Tangan' : 'Data Penanda Tangan Formulir' }}
        </h2>
    </div>

    <!-- Form selalu dalam mode Tambah Baru -->
    <form action="{{ route('form-monitoring-cctv.store-signer') }}" method="POST" class="flex flex-col md:flex-row gap-4 items-end mb-8 pb-8 border-b border-gray-100">
        @csrf
        <div class="w-full">
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nama <span class="text-red-500">*</span></label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></div>
                <input type="text" name="nama" placeholder="Nama" class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
            </div>
        </div>
        <div class="w-full">
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">NIPP <span class="text-red-500">*</span></label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg></div>
                <input type="text" name="nipp" placeholder="NIPP" class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
            </div>
        </div>
        <div class="w-full">
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Jabatan</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></div>
                <input type="text" name="jabatan" placeholder="Jabatan" class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
        </div>
        
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-6 py-2 rounded-lg transition-colors shrink-0">
            Tambah
        </button>
    </form>

    <div class="space-y-4">
        @forelse($penandatangans ?? [] as $signer)
        <div class="flex items-center justify-between p-4 border border-gray-100 rounded-lg bg-gray-50/50 hover:bg-gray-100 transition-colors">
            <div>
                <h3 class="font-bold text-gray-800 text-sm">{{ $signer->nama }}</h3>
                <p class="text-xs text-gray-500">NIPP: {{ $signer->nipp }} <span class="mx-1">|</span> Jabatan: {{ $signer->jabatan }}</p>
            </div>
            <div class="flex gap-2">
                <!-- Tombol Edit me-load parameter edit_signer_id via Pop up -->
                <button type="button" onclick="editSigner({{ $signer->id }}, {{ json_encode($signer->nama) }}, {{ json_encode($signer->nipp) }}, {{ json_encode($signer->jabatan ?? '') }})" class="p-1.5 text-yellow-500 hover:bg-yellow-200 hover:text-yellow-700 rounded transition-colors" title="Edit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </button>
                
                <!-- Tombol Hapus dengan form method DELETE -->
                <form action="{{ route('form-monitoring-cctv.destroy-signer', $signer->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="confirmDelete(this, 'Yakin ingin menghapus {{ addslashes($signer->nama) }}?')" class="p-1.5 text-red-500 hover:bg-red-50 rounded" title="Hapus">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="text-center text-gray-400 py-4 text-sm">Belum ada data penanda tangan.</div>
        @endforelse
    </div>
    @if(isset($penandatangans) && $penandatangans->hasPages())
    <div class="mt-4 pt-4 border-t border-gray-100">
        {{ $penandatangans->appends(request()->query())->links() }}
    </div>
    @endif
</div>
