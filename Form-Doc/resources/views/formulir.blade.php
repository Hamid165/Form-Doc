@extends('layouts.app')

@section('title', 'Kategori Formulir')

@section('content')
    <!-- Alert Success -->
    @if (session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition 
         class="mb-6 bg-[#f0fdf4] border border-[#bbf7d0] rounded-xl flex items-center p-3 relative shadow-sm">
        <div class="w-10 h-10 bg-[#dcfce7] rounded-lg flex items-center justify-center shrink-0 mr-4">
            <svg class="w-5 h-5 text-[#059669]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="flex flex-col">
            <h4 class="text-sm font-bold text-[#065f46] mb-0.5">Berhasil!</h4>
            <p class="text-[13px] font-medium text-[#059669]">{{ session('success') }}</p>
        </div>
        <button @click="show = false" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#10b981] hover:text-[#047857] transition-colors p-1 rounded-md hover:bg-[#dcfce7]">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    @endif

<!-- Content Wrapper -->
<div x-data="{ activeTab: 'All' }" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
    <!-- Header -->
    <div class="flex justify-between items-start mb-8">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center shadow-sm">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Katalog Formulir</h1>
                <p class="text-sm text-gray-500 mt-1">Sistem Informasi Manajemen Formulir</p>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-gray-100 rounded-lg p-1.5 mb-8 flex space-x-1 w-full border border-gray-200 overflow-x-auto">
        <a href="{{ route('formulir.index', ['kategori' => 'All']) }}" class="flex-1 text-center py-2 px-4 rounded-md text-sm font-semibold transition-colors whitespace-nowrap {{ $activeTab === 'All' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">All</a>
        <a href="{{ route('formulir.index', ['kategori' => 'Umum']) }}" class="flex-1 text-center py-2 px-4 rounded-md text-sm font-semibold transition-colors whitespace-nowrap {{ $activeTab === 'Umum' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">Umum</a>
        <a href="{{ route('formulir.index', ['kategori' => 'Terbatas']) }}" class="flex-1 text-center py-2 px-4 rounded-md text-sm font-semibold transition-colors whitespace-nowrap {{ $activeTab === 'Terbatas' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">Terbatas</a>
        <a href="{{ route('formulir.index', ['kategori' => 'Lainnya']) }}" class="flex-1 text-center py-2 px-4 rounded-md text-sm font-semibold transition-colors whitespace-nowrap {{ $activeTab === 'Lainnya' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">Lainnya</a>
    </div>

    <!-- List of Forms -->
    <div class="space-y-2 relative min-h-[200px]">
        
        @forelse ($formulirs as $form)
        <div class="block {{ !$loop->first ? 'mt-2' : '' }}" x-data="{ editing: false }">
            <div class="bg-white hover:bg-blue-50 rounded-xl shadow-sm border border-gray-200 hover:border-blue-200 p-4 transition-all group relative">
                
                <!-- Display Mode -->
                <div x-show="!editing">
                    <a href="{{ $form['route'] }}" class="absolute inset-0 z-10 rounded-xl"></a>
                    <div class="flex-1 grid grid-cols-12 gap-4 items-center">
                        <div class="col-span-3">
                            <p class="text-xs text-gray-500 font-medium mb-0.5">Formulir</p>
                            <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $form['nama'] }}</p>
                        </div>
                        <div class="col-span-1 text-center">
                            <p class="text-xs text-gray-500 font-medium mb-0.5">Kategori</p>
                            <p class="text-sm font-medium text-gray-900">{{ $form['kategori'] }}</p>
                        </div>
                        <div class="col-span-6 grid grid-cols-6 gap-3">
                            <div class="col-span-3">
                                <p class="text-xs text-gray-500 font-medium mb-0.5">No Dokumen</p>
                                <p class="text-sm font-medium text-gray-900 truncate" title="{{ $form['no_dokumen'] ?? '-' }}">{{ $form['no_dokumen'] ?? '-' }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-xs text-gray-500 font-medium mb-0.5">Tanggal</p>
                                <p class="text-sm font-medium text-gray-900 truncate" title="{{ $form['tanggal_dokumen'] ?? '-' }}">{{ $form['tanggal_dokumen'] ?? '-' }}</p>
                            </div>
                            <div class="col-span-1">
                                <p class="text-xs text-gray-500 font-medium mb-0.5">Versi</p>
                                <p class="text-sm font-medium text-gray-900 truncate" title="{{ $form['versi_dokumen'] ?? '-' }}">{{ $form['versi_dokumen'] ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-span-2 flex justify-end items-center gap-3">
                            <div class="text-right">
                                <p class="text-xs text-gray-500 font-medium mb-0.5">Total Data</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $form['total'] }} Formulir</p>
                            </div>
                            <button type="button" @click="editing = true" title="Edit Metadata Template" class="relative z-20 inline-flex items-center justify-center w-8 h-8 rounded-xl bg-amber-50 text-amber-600 hover:bg-amber-100 transition-colors focus:outline-none focus:ring-2 focus:ring-amber-500 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Edit Mode -->
                <div x-show="editing" style="display: none;" class="relative z-20">
                    <form method="POST" action="/formulir/template/{{ $form['id'] }}" class="flex flex-col gap-4">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-12 gap-4 items-center">
                            <div class="col-span-3">
                                <p class="text-xs text-gray-500 font-medium mb-0.5">Formulir</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $form['nama'] }}</p>
                            </div>
                            <div class="col-span-1 text-center">
                                <p class="text-xs text-gray-500 font-medium mb-0.5">Kategori</p>
                                <p class="text-sm font-medium text-gray-900">{{ $form['kategori'] }}</p>
                            </div>
                            <div class="col-span-8 grid grid-cols-6 gap-3">
                                <div class="col-span-3">
                                    <p class="text-xs text-gray-500 font-medium mb-0.5">No Dokumen</p>
                                    <input type="text" name="no_dokumen" value="{{ $form['no_dokumen'] }}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-2 py-1" required>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-xs text-gray-500 font-medium mb-0.5">Tanggal</p>
                                    <input type="text" name="tanggal_dokumen" value="{{ $form['tanggal_dokumen'] }}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-2 py-1" required>
                                </div>
                                <div class="col-span-1">
                                    <p class="text-xs text-gray-500 font-medium mb-0.5">Versi</p>
                                    <input type="text" name="versi_dokumen" value="{{ $form['versi_dokumen'] }}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-2 py-1" required>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end gap-2 mt-2 pt-3 border-t border-gray-100">
                            <button type="button" @click="editing = false" class="px-3 py-1.5 text-sm font-semibold text-white bg-red-500 border border-transparent rounded-md shadow-sm hover:bg-red-600 transition-colors">Batal</button>
                            <button type="submit" class="px-3 py-1.5 text-sm font-semibold text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 transition-colors">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <!-- Empty State -->
        <div class="text-center py-12 absolute inset-0">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada formulir</h3>
            <p class="mt-1 text-sm text-gray-500">Tidak ada formulir dalam kategori ini.</p>
        </div>
        @endforelse

        @if($formulirs->hasPages())
            <div class="mt-4 pt-4 border-t border-gray-100 pb-2">
                {{ $formulirs->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>



@endsection
