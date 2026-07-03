@extends('layouts.app')

@section('title', 'Kategori Formulir')

@section('content')
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
        <button @click="activeTab = 'All'" :class="activeTab === 'All' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-600 hover:text-gray-900'" class="flex-1 py-2 px-4 rounded-md text-sm font-semibold transition-colors whitespace-nowrap">All</button>
        <button @click="activeTab = 'Umum'" :class="activeTab === 'Umum' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-600 hover:text-gray-900'" class="flex-1 py-2 px-4 rounded-md text-sm font-semibold transition-colors whitespace-nowrap">Umum</button>
        <button @click="activeTab = 'Public'" :class="activeTab === 'Public' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-600 hover:text-gray-900'" class="flex-1 py-2 px-4 rounded-md text-sm font-semibold transition-colors whitespace-nowrap">Public</button>
        <button @click="activeTab = 'Terbatas'" :class="activeTab === 'Terbatas' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-600 hover:text-gray-900'" class="flex-1 py-2 px-4 rounded-md text-sm font-semibold transition-colors whitespace-nowrap">Terbatas</button>
    </div>

    <!-- List of Forms -->
    <div class="space-y-2 relative min-h-[200px]">
        
        <!-- CONTOH 1: Form Kategori Umum (CCTV) -->
        <div x-show="activeTab === 'All' || activeTab === 'Umum'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="block">
            <a href="{{ route('form-cctv.index') }}" class="block">
                <div class="bg-white hover:bg-blue-50 rounded-xl shadow-sm border border-gray-200 hover:border-blue-200 p-4 flex items-center gap-4 hover:shadow-md transition-all group cursor-pointer">
                    <div class="flex-1 grid grid-cols-12 gap-4 items-center">
                        <div class="col-span-4">
                            <p class="text-xs text-gray-500 font-medium mb-0.5">Formulir</p>
                            <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">Formulir CCTV</p>
                        </div>
                        <div class="col-span-4 text-center">
                            <p class="text-xs text-gray-500 font-medium mb-0.5">Kategori</p>
                            <p class="text-sm font-medium text-gray-900">Umum</p>
                        </div>
                        <div class="col-span-4 flex justify-end items-center gap-4">
                            <div class="text-right">
                                <p class="text-xs text-gray-500 font-medium mb-0.5">Total Data</p>
                                <p class="text-sm font-semibold text-gray-900">{{ \App\Models\FormCctv::count() }} Formulir</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- CONTOH 2: Form Kategori Public (Pencabutan Hak Akses) -->
        <div x-show="activeTab === 'All' || activeTab === 'Public'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="block mt-2">
            <a href="{{ route('form-revocation.index') }}" class="block">
                <div class="bg-white hover:bg-blue-50 rounded-xl shadow-sm border border-gray-200 hover:border-blue-200 p-4 flex items-center gap-4 hover:shadow-md transition-all group cursor-pointer">
                    <div class="flex-1 grid grid-cols-12 gap-4 items-center">
                        <div class="col-span-4">
                            <p class="text-xs text-gray-500 font-medium mb-0.5">Formulir</p>
                            <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">Permohonan Pencabutan Hak Akses</p>
                        </div>
                        <div class="col-span-4 text-center">
                            <p class="text-xs text-gray-500 font-medium mb-0.5">Kategori</p>
                            <p class="text-sm font-medium text-gray-900">Public</p>
                        </div>
                        <div class="col-span-4 flex justify-end items-center gap-4">
                            <div class="text-right">
                                <p class="text-xs text-gray-500 font-medium mb-0.5">Total Data</p>
                                <p class="text-sm font-semibold text-gray-900">{{ \App\Models\FormRevocation::count() }} Formulir</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>



        <!-- Empty State (Hanya muncul jika tab yang dipilih adalah Terbatas, karena All, Umum, Public sudah ada isinya) -->
        <div x-show="activeTab === 'Terbatas'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="text-center py-12 absolute inset-0">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada formulir</h3>
            <p class="mt-1 text-sm text-gray-500">Tidak ada formulir dalam kategori <span x-text="activeTab"></span> ini.</p>
        </div>
    </div>
</div>
@endsection
