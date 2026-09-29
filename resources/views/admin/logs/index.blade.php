@extends('layouts.app')

@section('title', 'Log Aktivitas Sistem')

@section('content')

@if (session('success'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition 
     class="mb-6 bg-[#f0fdf4] border border-[#bbf7d0] rounded-xl flex items-center p-4 relative shadow-sm">
    <div class="w-10 h-10 bg-[#dcfce7] rounded-lg flex items-center justify-center shrink-0 mr-4">
        <svg class="w-5 h-5 text-[#059669]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    </div>
    <div class="flex flex-col">
        <h4 class="text-sm font-bold text-[#065f46] mb-0.5">Berhasil!</h4>
        <p class="text-[13px] font-medium text-[#059669]">{{ session('success') }}</p>
    </div>
    <button @click="show = false" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#10b981] hover:text-[#047857] p-1 rounded-md hover:bg-[#dcfce7]">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>
@endif

<!-- Page Header -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:p-8 mb-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center shadow-sm text-blue-600 shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Log Aktivitas & Audit Trail</h1>
                <p class="text-xs text-gray-500 mt-1">Catatan riwayat aktivitas pengguna, pergantian peran, pembuatan, dan persetujuan formulir</p>
            </div>
        </div>

        <form action="{{ route('logs.clear') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus seluruh log aktivitas?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 h-[42px] bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-xl text-xs font-bold transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                <span>Bersihkan Log</span>
            </button>
        </form>
    </div>

    <!-- Search & Filter Bar -->
    <form method="GET" action="{{ route('logs.index') }}" class="flex flex-col sm:flex-row items-center gap-3 pt-4 border-t border-gray-100">
        <div class="relative flex-1 w-full">
            <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, aksi, atau rincian aktivitas..." class="w-full h-10 pl-10 pr-4 text-xs bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
        </div>

        <div class="w-full sm:w-48">
            <select name="role" onchange="this.form.submit()" class="w-full h-10 px-3 text-xs bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 font-medium text-gray-700">
                <option value="">Semua Peran</option>
                <option value="petugas" {{ request('role') === 'petugas' ? 'selected' : '' }}>Petugas</option>
                <option value="pimpinan" {{ request('role') === 'pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin Sistem</option>
            </select>
        </div>

        <button type="submit" class="w-full sm:w-auto px-4 h-10 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-lg transition border border-gray-200">
            Cari
        </button>
    </form>
</div>

<!-- Logs Table -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-gray-50 border-b border-gray-200 uppercase tracking-wider text-gray-500 font-bold">
                <tr>
                    <th class="px-6 py-3.5 w-12">#</th>
                    <th class="px-6 py-3.5">Waktu</th>
                    <th class="px-6 py-3.5">Pengguna</th>
                    <th class="px-6 py-3.5">Aksi Aktivitas</th>
                    <th class="px-6 py-3.5">Rincian Deskripsi</th>
                    <th class="px-6 py-3.5 text-right">IP Address</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 font-medium text-gray-800">
                @forelse($logs as $index => $log)
                    <tr class="hover:bg-gray-50/80 transition-colors">
                        <td class="px-6 py-4 text-gray-400 font-semibold">{{ $logs->firstItem() + $index }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                            {{ $log->created_at ? $log->created_at->format('d M Y H:i:s') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2.5">
                                <span class="font-bold text-gray-900">{{ $log->user_name }}</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $log->role === 'admin' ? 'bg-purple-50 text-purple-700 border border-purple-200' : ($log->role === 'pimpinan' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-blue-50 text-blue-700 border border-blue-200') }}">
                                    {{ $log->role }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-800 whitespace-nowrap">
                            {{ $log->action }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $log->description ?: '-' }}
                        </td>
                        <td class="px-6 py-4 text-right font-mono text-gray-400 text-[11px]">
                            {{ $log->ip_address ?: '127.0.0.1' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            <p class="text-sm font-semibold text-gray-800">Belum ada riwayat aktivitas</p>
                            <p class="text-xs text-gray-400 mt-1">Aktivitas pembuatan dan persetujuan dokumen akan tercatat secara otomatis.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $logs->links() }}
        </div>
    @endif
</div>

@endsection
