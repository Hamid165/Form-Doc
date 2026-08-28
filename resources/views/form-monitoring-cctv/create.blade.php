@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    
    <!-- Link Kembali (Opsional, mempermanis UX) -->
    <div class="mb-4">
        <a href="{{ route('form-monitoring-cctv.index', ['tab' => 'formulir']) }}" class="inline-flex items-center text-sm text-gray-500 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Formulir
        </a>
    </div>

    <!-- Container Form -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100">
        <form action="{{ route('form-monitoring-cctv.store') }}" method="POST">
            @csrf
            
            <!-- Memanggil form.blade.php -->
            @include('form-monitoring-cctv.form')

            <!-- BAGIAN TOMBOL YANG DIPERBARUI -->
            <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-gray-100">
                <!-- Tombol Batal -->
                <a href="{{ route('form-monitoring-cctv.index', ['tab' => 'formulir']) }}" 
                   class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    Batal
                </a>
                
                <!-- Tombol Simpan -->
                <button type="submit" 
                        class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    Simpan Formulir
                </button>
            </div>
        </form>
    </div>
</div>
@endsection