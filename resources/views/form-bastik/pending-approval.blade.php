@extends('layouts.app')

@section('title', 'Persetujuan Berita Acara (Pending Approval)')

@section('content')
<div class="p-8 bg-white rounded-2xl shadow-sm border border-gray-200">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center shadow-sm shrink-0">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Menunggu Persetujuan (Pending Approval)</h1>
                <p class="text-sm text-gray-500 mt-1">Daftar Berita Acara (BASTIK) yang membutuhkan peninjauan dan persetujuan Pimpinan.</p>
            </div>
        </div>
        <div>
            <a href="{{ route('form-bastik.index') }}" class="inline-flex items-center justify-center h-[40px] px-4 py-2 text-sm font-semibold rounded-lg text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors">
                Kembali ke Semua Berita Acara
            </a>
        </div>
    </div>

    <!-- Filter & Search Panel -->
    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 mb-6">
        <form action="{{ route('form-bastik.pending-approval') }}" method="GET" class="flex flex-col md:flex-row md:items-center gap-4">
            <div class="flex-grow relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari perihal, kota, business area, atau petugas..." class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-amber-500 focus:border-amber-500 bg-white">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 border border-gray-200 text-sm font-semibold rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition">
                    Cari
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('form-bastik.pending-approval') }}" class="px-4 py-2 text-sm font-semibold rounded-lg text-gray-500 hover:text-gray-700 transition">
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
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Dokumen</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Submit</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kota & Area</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pembuat (Petugas)</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="relative px-6 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    @forelse($documents as $doc)
                        <tr class="hover:bg-amber-50/30 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('form-bastik.show', $doc->id) }}" class="font-semibold text-gray-900 hover:text-amber-600 transition">
                                    {{ $doc->nomor_surat ?? "Berita Acara #{$doc->id}" }}
                                </a>
                                <span class="block text-xs text-gray-400">{{ $doc->items->count() }} tiket ditutup</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                {{ $doc->updated_at ? $doc->updated_at->format('d-m-Y H:i') : '-' }}
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
                                <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500 mr-1.5"></span>
                                    Menunggu Persetujuan
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-semibold space-x-1.5">
                                <a href="{{ route('form-bastik.show', $doc->id) }}" class="inline-flex items-center px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg transition shadow-sm font-semibold">
                                    Lihat Detail & Review
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-350 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="block text-sm font-semibold">Tidak Ada Berita Acara Menunggu Persetujuan</span>
                                <span class="text-xs text-gray-400 mt-1">Semua pengajuan telah diproses atau belum ada dokumen baru yang disubmit.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($documents->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $documents->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
