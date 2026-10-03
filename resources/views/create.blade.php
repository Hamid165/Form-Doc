@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mb-10">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800">Buat Dokumen Baru</h2>
        <a href="{{ route('reviews.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-800">⬅ Kembali</a>
    </div>

    <!-- KERTAS A4 (Formulir) -->
    <div class="bg-white p-10 shadow-xl border border-gray-300 font-sans text-sm text-black">
        <form action="{{ route('reviews.store') }}" method="POST">
            @csrf

            <!-- 1. HEADER TABEL DOKUMEN -->
            <table class="w-full border-collapse border border-black mb-6">
                <tr>
                    <td rowspan="2" class="border border-black w-1/4 text-center p-4">
                        <!-- Placeholder Logo KAI -->
                        <h1 class="text-4xl font-extrabold text-blue-900 italic tracking-tighter" style="color: #0b2259;">KAI<span class="text-orange-500">_</span></h1>
                    </td>
                    <td class="border border-black w-2/4 text-center p-2 font-bold uppercase text-base">
                        PT Kereta Api Indonesia (Persero)<br>Sistem Informasi
                    </td>
                    <td class="border border-black w-1/4 p-0 align-top">
                        <table class="w-full text-xs h-full">
                            <tr><td class="p-1 border-b border-black w-1/3">Nomor</td><td class="p-1 border-b border-black">: FR.SM/TI/020.005/10-2020</td></tr>
                            <tr><td class="p-1 border-b border-black">Tanggal</td><td class="p-1 border-b border-black">: 12 Oktober 2020</td></tr>
                            <tr><td class="p-1 border-b border-black">Versi</td><td class="p-1 border-b border-black">: 002-2020</td></tr>
                            <tr><td class="p-1">Halaman</td><td class="p-1">: 1 dari 1</td></tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="border border-black text-center p-2 font-bold uppercase text-base">
                        Formulir Post Implementation Review
                    </td>
                    <td class="border border-black bg-gray-100"></td>
                </tr>
            </table>

            <!-- GARIS GANDA -->
            <hr class="border-t-[3px] border-double border-black mb-4">

            <!-- 2. INFORMASI PELAKSANAAN -->
            <div class="grid grid-cols-[160px_10px_1fr] gap-y-3 mb-4">
                <div class="font-semibold">Tanggal Peninjauan <span class="text-red-500">*</span></div><div>:</div>
                <div>
                    <input type="date" name="tanggal_peninjauan" value="{{ old('tanggal_peninjauan') }}" class="w-1/2 border-b border-gray-400 focus:border-black focus:ring-0 p-0 text-sm bg-transparent">
                    @error('tanggal_peninjauan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="font-semibold">Periode Peninjauan <span class="text-red-500">*</span></div><div>:</div>
                <div>
                    <input type="text" name="periode_peninjauan" value="{{ old('periode_peninjauan') }}" placeholder="Contoh: Juli 2026 - Agustus 2026" class="w-full border-b border-gray-400 focus:border-black focus:ring-0 p-0 text-sm bg-transparent">
                    @error('periode_peninjauan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="font-semibold">Pelaksana Peninjauan <span class="text-red-500">*</span></div><div>:</div>
                <div>
                    <input type="text" name="pelaksana_peninjauan" value="{{ old('pelaksana_peninjauan') }}" placeholder="Nama Personil / Tim" class="w-full border-b border-gray-400 focus:border-black focus:ring-0 p-0 text-sm bg-transparent">
                    @error('pelaksana_peninjauan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="font-semibold">Lokasi Peninjauan <span class="text-red-500">*</span></div><div>:</div>
                <div>
                    <input type="text" name="lokasi_peninjauan" value="{{ old('lokasi_peninjauan') }}" placeholder="Contoh: Bandung" class="w-full border-b border-gray-400 focus:border-black focus:ring-0 p-0 text-sm bg-transparent">
                    @error('lokasi_peninjauan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- GARIS GANDA -->
            <hr class="border-t-[3px] border-double border-black mb-6">

            <!-- 3. OBYEK PENINJAUAN -->
            <div class="mb-6">
                <div class="font-bold text-base mb-2 flex items-center">
                    <span class="w-8">I.</span> Obyek Peninjauan <span class="text-red-500 ml-1">*</span>
                </div>
                <div class="ml-8 bg-gray-200 border border-gray-300 p-2">
                    <input type="text" name="obyek_peninjauan" value="{{ old('obyek_peninjauan') }}" placeholder="<Nama Aplikasi / Sistem yang ditinjau>" class="w-full font-bold bg-transparent border-none focus:ring-0 p-1 placeholder-gray-500 text-sm">
                    @error('obyek_peninjauan') <p class="text-red-500 text-xs px-1">{{ $message }}</p> @enderror
                    
                    <textarea name="deskripsi_sistem" rows="2" placeholder="Deskripsi Singkat Sistem..." class="w-full bg-transparent border-none focus:ring-0 p-1 mt-1 placeholder-gray-500 text-sm resize-none">{{ old('deskripsi_sistem') }}</textarea>
                    @error('deskripsi_sistem') <p class="text-red-500 text-xs px-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- 4. ANALISA & TINDAK LANJUT -->
            <div class="mb-8">
                <div class="font-bold text-base mb-2 flex items-center">
                    <span class="w-8">II.</span> Analisa & Tindak Lanjut <span class="text-red-500 ml-1">*</span>
                </div>
                <div class="ml-8 border border-black">
                    <!-- Kotak Analisa -->
                    <div class="border-b border-black p-3">
                        <div class="italic underline font-semibold mb-2">Analisa:</div>
                        <textarea name="analisa" rows="4" placeholder="Ketik hasil analisa di sini..." class="w-full border-none focus:ring-0 p-0 text-sm resize-none">{{ old('analisa') }}</textarea>
                        @error('analisa') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <!-- Kotak Tindak Lanjut -->
                    <div class="p-3">
                        <div class="italic underline font-semibold mb-2">Tindak Lanjut:</div>
                        <textarea name="tindak_lanjut" rows="4" placeholder="Ketik tindak lanjut di sini..." class="w-full border-none focus:ring-0 p-0 text-sm resize-none">{{ old('tindak_lanjut') }}</textarea>
                        @error('tindak_lanjut') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- TOMBOL SIMPAN -->
            <div class="flex justify-end border-t border-dashed border-gray-300 pt-6 mt-10">
                <button type="submit" style="background-color: #0b2259;" class="text-white font-bold py-3 px-8 rounded hover:bg-blue-800 transition shadow-md flex items-center gap-2">
                    🖫 Simpan & Lihat Hasil Cetak
                </button>
            </div>
        </form>
    </div>
</div>
@endsection