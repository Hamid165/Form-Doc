@extends('layouts.app')

@section('title', 'Detail Keluhan Pelanggan')

@section('content')

<div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <a href="{{ route('form-keluhan.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>Kembali ke Daftar
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8 mb-6">
    <div class="flex items-center gap-4 mb-6">
        <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-6l-4 4v-4z"></path></svg>
        </div>
        <div>
            <h1 class="text-xl font-bold text-gray-900">Detail Formulir Keluhan Pelanggan</h1>
        </div>
</div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">No. Ref</p>
            <p class="text-sm font-semibold text-gray-900">{{ $form->no_ref ?: '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Tanggal</p>
            <p class="text-sm font-semibold text-gray-900">{{ $form->tanggal ? \Carbon\Carbon::createFromFormat('d-m-Y', $form->tanggal)->format('d M Y') : '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Kota / Tanggal TTD</p>
            <p class="text-sm font-semibold text-gray-900">{{ $form->kota_tanggal ?: '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Dibuat Oleh (Pelaksana)</p>
            <p class="text-sm font-semibold text-gray-900">{{ $form->pelaksana_nama ?: '-' }}</p>
            <p class="text-xs text-gray-500 mt-0.5">NIPP: {{ $form->pelaksana_nipp ?: '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Mengetahui</p>
            <p class="text-sm font-semibold text-gray-900">{{ $form->mengetahui_nama ?: '-' }}</p>
            <p class="text-xs text-gray-500 mt-0.5">NIPP: {{ $form->mengetahui_nipp ?: '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Jabatan Mengetahui</p>
            <p class="text-sm font-semibold text-gray-900">{{ $form->mengetahui_jabatan ?: '-' }}</p>
        </div>
    </div>
</div>

<!-- Daftar Item Keluhan -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">
    <h2 class="text-lg font-bold text-gray-900 mb-4">Daftar Keluhan</h2>

    <div class="space-y-3">
        @forelse ($form->items as $item)
        <div class="border border-gray-200 rounded-xl bg-white overflow-hidden">
            
        <div class="flex items-center justify-between px-4 py-3 bg-blue-50/60 border-b border-gray-200">
            <div class="flex items-center gap-2.5">
                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-600 text-white text-xs font-bold shrink-0">
                    {{ $item->no }}</span>
                    <span class="text-sm font-semibold text-gray-900">Keluhan</span>
                </div>
                <span class="text-xs text-gray-500 font-medium">{{ $item->tanggal ?: '-' }}</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 px-4 py-4 border-b border-gray-100">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Pelanggan</p>
                    <p class="text-sm text-gray-900">{{ $item->pelanggan ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Sumber</p>
                    <p class="text-sm text-gray-900">{{ $item->sumber ?: '-' }}</p>
                </div>
            </div>
            
            <div class="px-4 py-4 border-b border-gray-100 space-y-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Deskripsi Keluhan</p>
                    <p class="text-sm text-gray-900 whitespace-pre-line">{{ $item->deskripsi_keluhan ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Tindakan Perbaikan &amp; Pencegahan</p>
                    <p class="text-sm text-gray-900 whitespace-pre-line">{{ $item->tindakan ?: '-' }}</p>
                </div>
            </div>

            <div class="px-4 py-4 border-b border-gray-100">
                <p class="text-xs font-bold uppercase tracking-wider text-blue-600 mb-3">Verifikasi</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Tanggal</p>
                        <p class="text-sm text-gray-900">{{ $item->verifikasi_tgl ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">PIC</p>
                        <p class="text-sm text-gray-900">{{ $item->verifikasi_pic ?: '-' }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Hasil Verifikasi</p>
                        <p class="text-sm text-gray-900 whitespace-pre-line">{{ $item->verifikasi_hasil ?: '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="px-4 py-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Keterangan</p>
                <p class="text-sm text-gray-900 whitespace-pre-line">{{ $item->keterangan ?: '-' }}</p>
            </div>
        </div>
        @empty
        <p class="text-sm text-gray-500 text-center py-8">Belum ada data keluhan yang diisi pada formulir ini.</p>
        @endforelse
    </div>
</div>

@endsection
