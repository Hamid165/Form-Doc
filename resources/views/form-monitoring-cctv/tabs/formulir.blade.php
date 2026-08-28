<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50/50 border-b border-gray-100 text-gray-500 font-medium">
                <tr>
                    <th class="p-4 w-12 text-center">No</th>
                    <th class="p-4">No Ref</th>
                    <th class="p-4">Tanggal</th>
                    <th class="p-4">Business Area</th>
                    <th class="p-4">Bulan</th>
                    <th class="p-4 text-center">Status</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($formulirs as $index => $form)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="p-4 text-center">{{ $formulirs->firstItem() + $index }}</td>
                    <td class="p-4 font-medium text-gray-800">{{ $form->no_ref ?? '-' }}</td>
                    <td class="p-4">{{ $form->tanggal ? \Carbon\Carbon::parse($form->tanggal)->translatedFormat('d M Y') : '-' }}</td>
                    <td class="p-4">{{ $form->business_area ?? '-' }}</td>
                    <td class="p-4">{{ $form->bulan ?? '-' }}</td>
                    <td class="p-4 text-center">
                        <!-- Logika Warna Status -->
                        @if(strtolower($form->status) === 'draft')
                            <span class="px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium uppercase tracking-wide">
                                Draft
                            </span>
                        @else
                            <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium uppercase tracking-wide">
                                Selesai
                            </span>
                        @endif
                    </td>
                    <td class="p-4 flex items-center justify-center gap-3">
                        <!-- Tombol Lihat -->
                        <a href="{{ route('form-monitoring-cctv.show', $form->id) }}" class="text-blue-500 hover:text-blue-700" title="Lihat">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                        
                        <!-- Tombol Edit -->
                        <a href="{{ route('form-monitoring-cctv.edit', $form->id) }}" class="text-yellow-500 hover:text-yellow-700" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>

                        <!-- Tombol Cetak / Tandai Selesai -->
                        <button type="button" onclick="confirmPrint('{{ route('form-monitoring-cctv.print', $form->id) }}')" class="text-purple-500 hover:purple-700" title="Cetak & Selesaikan">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        </button>

                        <!-- Tombol Hapus -->
                        <form action="{{ route('form-monitoring-cctv.destroy', $form->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete(this, 'Yakin ingin menghapus formulir ini?')" class="p-1.5 text-red-500 hover:bg-red-50 rounded" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-12 text-center text-gray-400">
                        Belum ada data formulir.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    @if(isset($formulirs) && $formulirs->hasPages())
    <div class="p-4 border-t border-gray-100">
        {{ $formulirs->appends(request()->query())->links() }}
    </div>
    @endif
</div>