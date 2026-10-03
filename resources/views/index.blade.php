@extends('layouts.app')

@section('content')
@if(session('success'))
<div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded shadow-sm flex items-center justify-between">
    <span>✨ {{ session('success') }}</span>
    <button onclick="this.parentElement.remove()" class="font-bold opacity-50 hover:opacity-100">&times;</button>
</div>
@endif

<div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-kaiOrange" style="border-top-color: #F37021;">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-kaiBlue" style="color: #0b2259; margin: 0;">Daftar Dokumen Peninjauan</h2>
        
        <!-- BAGIAN TOTAL DOKUMEN & TOMBOL BUAT BARU -->
        <div style="display: flex; align-items: center; gap: 15px;">
            <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full font-medium">
                Total: {{ $reviews->total() }} Dokumen
            </span>
            <a href="{{ route('reviews.create') }}" style="background-color: #F37021; color: white; padding: 8px 16px; border-radius: 6px; font-weight: bold; text-decoration: none; font-size: 14px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                + Buat Dokumen Baru
            </a>
        </div>
    </div>
    
    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-white text-sm uppercase" style="background-color: #0b2259;">
                    <th class="p-3 border-b border-gray-200">Tanggal</th>
                    <th class="p-3 border-b border-gray-200">Obyek Sistem</th>
                    <th class="p-3 border-b border-gray-200">Pelaksana</th>
                    <th class="p-3 border-b border-gray-200 text-center" style="width: 200px;">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700 text-sm">
                @forelse($reviews as $review)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-3 font-medium">{{ \Carbon\Carbon::parse($review->tanggal_peninjauan)->format('d/m/Y') }}</td>
                    <td class="p-3 font-semibold text-gray-900">{{ $review->obyek_peninjauan }}</td>
                    <td class="p-3">{{ $review->pelaksana_peninjauan }}</td>
                    
                    <!-- BAGIAN TOMBOL AKSI YANG SUDAH DIPERBARUI -->
                    <td class="p-3 text-center flex justify-center items-center gap-2">
                        
                        <!-- 1. Tombol Lihat -->
                        <a href="{{ route('reviews.show', $review->id) }}" title="Lihat Detail Dokumen" class="bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white p-2 rounded transition text-base flex items-center justify-center">
                            👁️
                        </a>

                        <!-- 2. Tombol Print (Buka tab baru untuk print) -->
                        <a href="{{ route('reviews.show', $review->id) }}" target="_blank" title="Print Dokumen" class="bg-gray-100 text-gray-700 hover:bg-gray-600 hover:text-white p-2 rounded transition text-base flex items-center justify-center">
                            🖨️
                        </a>
                        
                        <!-- 3. Tombol Edit -->
                        <a href="{{ route('reviews.edit', $review->id) }}" title="Edit Dokumen" class="bg-yellow-50 text-yellow-600 hover:bg-yellow-500 hover:text-white p-2 rounded transition text-base flex items-center justify-center">
                            ✏️
                        </a>
                        
                        <!-- 4. Tombol Hapus -->
                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini? Tindakan ini tidak dapat dibatalkan.');" class="inline m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Hapus Dokumen" class="bg-red-50 text-red-600 hover:bg-red-600 hover:text-white p-2 rounded transition text-base flex items-center justify-center">
                                🗑️
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-gray-400 italic">Belum ada dokumen yang dibuat. Klik tombol "+ Buat Dokumen Baru" di kanan atas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $reviews->links() }}
    </div>
</div>
@endsection