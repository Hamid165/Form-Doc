@extends('layouts.app')

@section('title', 'Dashboard Berita Acara (BASTIK)')

@section('content')
<div class="p-8 bg-white rounded-2xl shadow-sm border border-gray-200">
    
    <!-- Top Action & Title Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center shadow-sm shrink-0">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Dashboard Berita Acara (BASTIK)</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola dan terbitkan Berita Acara Penutupan Tiket Incident / Work Order secara otomatis.</p>
            </div>
        </div>
        <div>
            <a href="{{ route('form-bastik.create') }}" class="inline-flex items-center justify-center h-[40px] px-4 py-2 text-sm font-semibold rounded-lg text-white bg-orange-500 hover:bg-orange-600 shadow transition-colors">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Berita Acara Baru
            </a>
        </div>
    </div>

    <!-- Filter & Search Panel -->
    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 mb-6">
        <form action="{{ route('form-bastik.index') }}" method="GET" class="flex flex-col md:flex-row md:items-center gap-4">
            <!-- Search Input -->
            <div class="flex-grow relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor surat, kota, business area, atau petugas..." class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500 bg-white">
            </div>

            <!-- Status Dropdown -->
            <div class="w-full md:w-48">
                <select name="status" class="block w-full py-2 px-3 border border-gray-200 bg-white rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                    <option value="signed" {{ request('status') === 'signed' ? 'selected' : '' }}>Approved / Signed</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak (Rejected)</option>
                    <option value="final" {{ request('status') === 'final' ? 'selected' : '' }}>Final (Legacy)</option>
                    <option value="void" {{ request('status') === 'void' ? 'selected' : '' }}>Void / Batal</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 border border-gray-200 text-sm font-semibold rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition">
                    Filter
                </button>
                @if(request()->filled('search') || request()->filled('status'))
                    <a href="{{ route('form-bastik.index') }}" class="px-4 py-2 text-sm font-semibold rounded-lg text-gray-500 hover:text-gray-700 transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Documents List Table -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nomor Surat</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kota & Area</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pembuat</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="relative px-6 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    @forelse($documents as $doc)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('form-bastik.show', $doc->id) }}" class="font-semibold text-gray-900 hover:text-orange-500 transition">
                                    {{ $doc->nomor_surat ?? '[DRAFT - BELUM GENERATE]' }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                {{ $doc->tanggal_surat ? date('d-m-Y', strtotime($doc->tanggal_surat)) : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                <span class="font-medium text-gray-800">{{ $doc->kota }}</span> 
                                <span class="text-xs text-gray-400">/ {{ $doc->business_area ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="font-medium text-gray-900">{{ $doc->petugas->name ?? '-' }}</span>
                                    <span class="text-xs text-gray-400">NIPKWT: {{ $doc->petugas->nip_kwt ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($doc->status === 'draft')
                                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-gray-400 mr-1.5"></span>
                                        Draft
                                    </span>
                                @elseif($doc->status === 'submitted')
                                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500 mr-1.5"></span>
                                        Menunggu Persetujuan
                                    </span>
                                @elseif($doc->status === 'signed')
                                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                        Approved / Signed
                                    </span>
                                @elseif($doc->status === 'rejected')
                                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-rose-500 mr-1.5"></span>
                                        Ditolak (Rejected)
                                    </span>
                                @elseif($doc->status === 'final')
                                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-blue-500 mr-1.5"></span>
                                        Final (Legacy)
                                    </span>
                                @elseif($doc->status === 'void')
                                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-rose-500 mr-1.5"></span>
                                        Void / Batal
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-semibold">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- Cetak / PDF (Icon Print - Paling Kiri) -->
                                    <a href="{{ route('form-bastik.print', $doc->id) }}" target="_blank" class="w-8 h-8 flex items-center justify-center bg-emerald-50 text-emerald-600 hover:bg-emerald-100 hover:text-emerald-800 rounded-lg transition border border-emerald-200 shadow-sm" title="Cetak / PDF">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                        </svg>
                                    </a>

                                    <!-- Lihat / Detail (Icon Mata) -->
                                    <a href="{{ route('form-bastik.show', $doc->id) }}" class="w-8 h-8 flex items-center justify-center bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-800 rounded-lg transition border border-blue-200 shadow-sm" title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    <!-- Edit / Revisi (Icon Pencil) -->
                                    <a href="{{ route('form-bastik.edit', $doc->id) }}" class="w-8 h-8 flex items-center justify-center bg-amber-50 text-amber-600 hover:bg-amber-100 hover:text-amber-800 rounded-lg transition border border-amber-200 shadow-sm" title="Edit Dokumen">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    <!-- Hapus (Icon Trash) -->
                                    <a href="{{ route('form-bastik.delete', $doc->id) }}"
                                        onclick="return confirmBastikDelete(event, this.href)"
                                        class="w-8 h-8 flex items-center justify-center bg-rose-50 text-rose-600 hover:bg-rose-100 hover:text-rose-800 rounded-lg transition border border-rose-200 shadow-sm"
                                        title="Hapus Dokumen">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-350 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span class="block text-sm font-semibold">Tidak Ada Berita Acara</span>
                                <span class="text-xs text-gray-400 mt-1">Belum ada Berita Acara yang dibuat atau dicari. Klik tombol diatas untuk membuat baru.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Section -->
        @if($documents->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $documents->links() }}
            </div>
        @endif
    </div>
</div>

<script>
function confirmBastikDelete(event, deleteUrl) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            html: `
                <div class="flex flex-col items-center pt-4">
                    <div class="relative flex items-center justify-center w-16 h-16 mb-6">
                        <div class="absolute inset-0 bg-[#f44336] blur-xl opacity-30 rounded-full"></div>
                        <svg class="w-10 h-10 text-[#f44336] relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </div>
                    <h2 class="text-[22px] font-bold text-gray-900 mb-2 text-center">Apakah Anda yakin?</h2>
                    <p class="text-[15px] font-medium text-gray-600 text-center leading-relaxed">Berita Acara ini akan dihapus secara permanen.</p>
                </div>
            `,
            width: '360px',
            scrollbarPadding: false,
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            buttonsStyling: false,
            customClass: {
                popup: 'custom-swal-popup p-6 shadow-2xl border-0',
                htmlContainer: 'm-0',
                confirmButton: 'rounded-2xl bg-[#f44336] hover:bg-[#d32f2f] text-white text-base font-semibold px-8 py-3.5 ml-3 transition-colors flex-1',
                cancelButton: 'rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-600 text-base font-semibold px-8 py-3.5 transition-colors flex-1',
                actions: 'mt-6 w-full flex justify-center gap-2 px-4 pb-2',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = deleteUrl;
            }
        });
        return false;
    } else {
        if (confirm('Apakah Anda yakin ingin menghapus Berita Acara ini?')) {
            window.location.href = deleteUrl;
        }
        return false;
    }
}
</script>
@endsection
