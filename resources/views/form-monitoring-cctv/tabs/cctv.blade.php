<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center gap-2 mb-6">
        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
        <h2 class="text-lg font-bold text-gray-800">
            {{ isset($editCctv) ? 'Edit Data Titik CCTV' : 'Data Titik CCTV' }}
        </h2>
    </div>

    <form action="{{ route('form-monitoring-cctv.store-cctv') }}" method="POST" class="flex flex-col md:flex-row gap-4 items-end mb-8 pb-8 border-b border-gray-100">
        @csrf
        <div class="w-full">
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nama Titik CCTV <span class="text-red-500">*</span></label>
            <input type="text" name="nama_titik" placeholder="Contoh: Kamera Stasiun" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
        </div>
        <div class="w-full">
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Lokasi</label>
            <input type="text" name="lokasi" placeholder="Lokasi CCTV" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-6 py-2 rounded-lg transition-colors shrink-0">
            Tambah
        </button>
    </form>

    <div class="space-y-4">
        @forelse($cctvs ?? [] as $cctv)
        <div class="flex items-center justify-between p-4 border border-gray-100 rounded-lg bg-gray-50/50 hover:bg-gray-100 transition-colors">
            <div>
                <h3 class="font-bold text-gray-800 text-sm">{{ $cctv->id_cctv }}</h3>
                <p class="text-xs text-gray-500">{{ $cctv->lokasi ?? 'Tidak ada keterangan lokasi' }}</p>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="editCctv({{ $cctv->id }}, {{ json_encode($cctv->id_cctv) }}, {{ json_encode($cctv->lokasi ?? '') }})" class="p-1.5 text-yellow-500 hover:bg-yellow-200 hover:text-yellow-700 rounded transition-colors" title="Edit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </button>
                <form action="{{ route('form-monitoring-cctv.destroy-cctv', $cctv->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="confirmDelete(this, 'Anda yakin ingin menghapus Data Titik CCTV ini?')" class="p-1.5 text-red-500 hover:bg-red-50 rounded">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="text-center text-gray-400 py-4 text-sm">Belum ada data referensi CCTV.</div>
        @endforelse
    </div>
    @if(isset($cctvs) && $cctvs->hasPages())
    <div class="mt-4 pt-4 border-t border-gray-100">
        {{ $cctvs->appends(request()->query())->links() }}
    </div>
    @endif
</div>
