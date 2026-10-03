@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold uppercase">PT. Kereta Api Indonesia (Persero)</h2>
            <h3 class="text-xl font-semibold">Sistem Informasi</h3>
            <h4 class="text-lg font-bold mt-2 uppercase">Edit Formulir Monitoring CCTV</h4>
        </div>

        <form action="{{ route('form-monitoring-cctv.update', $monitoring->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Memanggil form.blade.php dengan data $monitoring -->
            @include('form-monitoring-cctv.form')

            <!-- Tombol Batal & Simpan -->
            <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                <!-- Tombol Batal -->
                <a href="{{ route('form-monitoring-cctv.index') }}" 
                   class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    Batal
                </a>
                
                <!-- Tombol Update -->
                <button type="submit" 
                        class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    Update Formulir
                </button>
            </div>
        </form>
    </div>
</div>
@endsection