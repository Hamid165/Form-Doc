@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md border-t-4 border-kaiOrange">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-kaiBlue">Edit Dokumen Peninjauan</h2>
        <a href="{{ route('reviews.index') }}" class="text-sm font-semibold text-gray-500 hover:text-kaiBlue flex items-center gap-1">⬅ Batal</a>
    </div>

    <form action="{{ route('reviews.update', $review->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700">Tanggal Peninjauan <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_peninjauan" value="{{ old('tanggal_peninjauan', $review->tanggal_peninjauan) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-kaiOrange focus:ring focus:ring-orange-200 p-2 border">
                @error('tanggal_peninjauan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700">Periode Peninjauan <span class="text-red-500">*</span></label>
                <input type="text" name="periode_peninjauan" value="{{ old('periode_peninjauan', $review->periode_peninjauan) }}" placeholder="Contoh: Januari 2026 – Maret 2026" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-kaiOrange focus:ring focus:ring-orange-200 p-2 border">
                @error('periode_peninjauan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700">Pelaksana Peninjauan <span class="text-red-500">*</span></label>
            <input type="text" name="pelaksana_peninjauan" value="{{ old('pelaksana_peninjauan', $review->pelaksana_peninjauan) }}" placeholder="Nama Personil / Tim" class="mt-1 block w-full rounded border-gray-300 shadow-sm p-2 border">
            @error('pelaksana_peninjauan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700">Tempat / Lokasi Peninjauan <span class="text-red-500">*</span></label>
            <input type="text" name="lokasi_peninjauan" value="{{ old('lokasi_peninjauan', $review->lokasi_peninjauan) }}" placeholder="Contoh: Bandung, Jakarta, atau Yogyakarta" class="mt-1 block w-full rounded border-gray-300 shadow-sm p-2 border">
            @error('lokasi_peninjauan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <hr class="border-gray-200">

        <div>
            <label class="block text-sm font-semibold text-gray-700">Obyek Peninjauan (Sistem) <span class="text-red-500">*</span></label>
            <input type="text" name="obyek_peninjauan" value="{{ old('obyek_peninjauan', $review->obyek_peninjauan) }}" placeholder="Nama Aplikasi / Sistem" class="mt-1 block w-full rounded border-gray-300 shadow-sm p-2 border">
            @error('obyek_peninjauan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700">Deskripsi Sistem <span class="text-red-500">*</span></label>
            <textarea name="deskripsi_sistem" rows="3" class="mt-1 block w-full rounded border-gray-300 shadow-sm p-2 border">{{ old('deskripsi_sistem', $review->deskripsi_sistem) }}</textarea>
            @error('deskripsi_sistem') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <hr class="border-gray-200">

        <div class="bg-gray-50 p-4 rounded border border-gray-200 space-y-4">
            <h3 class="font-bold text-kaiBlue">Analisa & Tindak Lanjut</h3>
            <div>
                <label class="block text-sm font-semibold text-gray-700">Analisa <span class="text-red-500">*</span></label>
                <textarea name="analisa" rows="4" class="mt-1 block w-full rounded border-gray-300 shadow-sm p-2 border">{{ old('analisa', $review->analisa) }}</textarea>
                @error('analisa') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700">Tindak Lanjut <span class="text-red-500">*</span></label>
                <textarea name="tindak_lanjut" rows="4" class="mt-1 block w-full rounded border-gray-300 shadow-sm p-2 border">{{ old('tindak_lanjut', $review->tindak_lanjut) }}</textarea>
                @error('tindak_lanjut') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('reviews.index') }}" class="bg-gray-100 text-gray-700 font-bold py-3 px-6 rounded hover:bg-gray-200 transition">Batal</a>
            <button type="submit" class="bg-kaiBlue text-white font-bold py-3 px-8 rounded hover:bg-blue-900 transition shadow-md">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection