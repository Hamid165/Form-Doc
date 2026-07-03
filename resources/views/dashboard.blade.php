@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card 1 -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </div>
        <div>
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Total Kategori</p>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalKategori) }}</p>
        </div>
    </div>
    <!-- Card 2 -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
        </div>
        <div>
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Jenis Formulir</p>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalJenisFormulir) }}</p>
        </div>
    </div>
    <!-- Card 3 -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Terisi (Bulan Ini)</p>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalFormulirBulanIni) }}</p>
        </div>
    </div>
    <!-- Card 4 -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 bg-red-50 text-red-600 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <div>
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Total Pengguna</p>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalPengguna) }}</p>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 lg:w-2/3">
    <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Aktivitas Terbaru
    </h2>
    <div class="space-y-6">
        @forelse($recentForms as $form)
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 border border-blue-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div class="flex-1 border-b border-gray-100 pb-4">
                <p class="text-sm text-gray-900 font-medium mb-1">
                    Formulir CCTV <a href="{{ route('form-cctv.show', $form->id) }}" class="text-blue-600 hover:underline">{{ $form->no_ref }}</a> ditambahkan
                </p>
                <p class="text-xs text-gray-500">{{ $form->created_at->diffForHumans() }} (Area: {{ $form->lokasi }})</p>
            </div>
        </div>
        @empty
        <div class="text-center py-8">
            <p class="text-sm text-gray-500">Belum ada aktivitas formulir saat ini.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
