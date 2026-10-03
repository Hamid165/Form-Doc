@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mb-12">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Dokumen Peninjauan</h2>
        <a href="{{ route('reviews.index') }}" class="text-sm font-semibold text-gray-600 hover:text-blue-900 transition flex items-center gap-1">
            ⬅ Kembali ke Daftar
        </a>
    </div>

    <!-- KERTAS A4 (Formulir) -->
    <div class="bg-white p-8 md:p-12 shadow-2xl border border-gray-200 text-black">
        <form action="{{ route('reviews.update', $review->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- KOP SURAT KAI -->
            <table class="w-full border-collapse border border-black mb-6">
                <tr>
                    <td rowspan="2" class="border border-black w-1/4 text-center align-middle p-4">
                        <h1 class="text-5xl font-extrabold text-blue-900 italic tracking-tighter m-0" style="color: #0b2259;">KAI<span class="text-orange-500">_</span></h1>
                    </td>
                    <td class="border border-black w-2/4 text-center align-middle p-2 font-bold uppercase text-[15px] leading-tight">
                        PT Kereta Api Indonesia (Persero)<br>Sistem Informasi
                    </td>
                    <td class="border border-black w-1/4 p-0 align-top">
                        <table class="w-full text-xs h-full border-collapse">
                            <tr><td class="p-1.5 border-b border-black w-1/3 bg-gray-50">Nomor</td><td class="p-1.5 border-b border-black">: FR.SM/TI/020.005/10-2020</td></tr>
                            <tr><td class="p-1.5 border-b border-black bg-gray-50">Tanggal</td><td class="p-1.5 border-b border-black">: 12 Oktober 2020</td></tr>
                            <tr><td class="p-1.5 border-b border-black bg-gray-50">Versi</td><td class="p-1.5 border-b border-black">: 002-2020</td></tr>
                            <tr><td class="p-1.5 bg-gray-50">Halaman</td><td class="p-1.5">: 1 dari 1</td></tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="border border-black text-center p-3 font-extrabold uppercase text-base tracking-wide bg-gray-50">
                        Formulir Post Implementation Review
                    </td>
                    <td class="border border-black bg-gray-100"></td>
                </tr>
            </table>

            <hr class="border-t-[4px] border-double border-black mb-6">

            <!-- DATA PELAKSANAAN -->
            <table class="w-full text-sm mb-6">
                <tbody>
                    <tr>
                        <td class="py-2 w-[180px] font-semibold">Tanggal Peninjauan <span class="text-red-500">*</span></td>
                        <td class="py-2 w-[10px]">:</td>
                        <td class="py-2">
                            <input type="date" name="tanggal_peninjauan" value="{{ old('tanggal_peninjauan', $review->tanggal_peninjauan) }}" class="w-[200px] border border-gray-300 p-2 focus:border-blue-900 focus:ring-1 focus:ring-blue-900 bg-blue-50/30">
                            @error('tanggal_peninjauan') <span class="text-red-500 text-xs ml-2">{{ $message }}</span> @enderror
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 font-semibold">Periode Peninjauan <span class="text-red-500">*</span></td>
                        <td class="py-2">:</td>
                        <td class="py-2">
                            <input type="text" name="periode_peninjauan" value="{{ old('periode_peninjauan', $review->periode_peninjauan) }}" placeholder="Contoh: Juli 2026 - Agustus 2026" class="w-full border border-gray-300 p-2 focus:border-blue-900 focus:ring-1 focus:ring-blue-900 bg-blue-50/30">
                            @error('periode_peninjauan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 font-semibold">Pelaksana Peninjauan <span class="text-red-500">*</span></td>
                        <td class="py-2">:</td>
                        <td class="py-2">
                            <input type="text" name="pelaksana_peninjauan" value="{{ old('pelaksana_peninjauan', $review->pelaksana_peninjauan) }}" placeholder="Nama Personil atau Tim" class="w-full border border-gray-300 p-2 focus:border-blue-900 focus:ring-1 focus:ring-blue-900 bg-blue-50/30">
                            @error('pelaksana_peninjauan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 font-semibold">Lokasi Peninjauan <span class="text-red-500">*</span></td>
                        <td class="py-2">:</td>
                        <td class="py-2">
                            <input type="text" name="lokasi_peninjauan" value="{{ old('lokasi_peninjauan', $review->lokasi_peninjauan) }}" placeholder="Contoh: Bandung, Jakarta, dll." class="w-full border border-gray-300 p-2 focus:border-blue-900 focus:ring-1 focus:ring-blue-900 bg-blue-50/30">
                            @error('lokasi_peninjauan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </td>
                    </tr>
                </tbody>
            </table>

            <hr class="border-t-[4px] border-double border-black mb-8">

            <!-- OBYEK PENINJAUAN -->
            <div class="mb-8">
                <div class="font-bold text-base mb-3 flex">
                    <span class="w-8">I.</span> 
                    <span>Obyek Peninjauan <span class="text-red-500">*</span></span>
                </div>
                <div class="ml-8 bg-gray-100 border border-gray-400 p-4">
                    <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Nama Sistem / Aplikasi</label>
                    <input type="text" name="obyek_peninjauan" value="{{ old('obyek_peninjauan', $review->obyek_peninjauan) }}" placeholder="Contoh: Pemantauan E-Tiket" class="w-full font-bold text-base border border-gray-300 p-2 mb-3 focus:border-blue-900 focus:ring-1 focus:ring-blue-900 bg-white">
                    @error('obyek_peninjauan') <p class="text-red-500 text-xs mt-[-8px] mb-3">{{ $message }}</p> @enderror
                    
                    <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Deskripsi Sistem</label>
                    <textarea name="deskripsi_sistem" rows="2" placeholder="Jelaskan secara singkat mengenai sistem ini..." class="w-full border border-gray-300 p-2 focus:border-blue-900 focus:ring-1 focus:ring-blue-900 bg-white resize-none">{{ old('deskripsi_sistem', $review->deskripsi_sistem) }}</textarea>
                    @error('deskripsi_sistem') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- ANALISA & TINDAK LANJUT -->
            <div class="mb-10">
                <div class="font-bold text-base mb-3 flex">
                    <span class="w-8">II.</span> 
                    <span>Analisa & Tindak Lanjut <span class="text-red-500">*</span></span>
                </div>
                <div class="ml-8 border-2 border-black">
                    <!-- Analisa -->
                    <div class="border-b-2 border-black bg-blue-50/20 p-4">
                        <div class="italic underline font-bold mb-2 text-black">Analisa:</div>
                        <textarea name="analisa" rows="4" placeholder="Ketik hasil analisa di sini..." class="w-full border border-gray-300 p-3 focus:border-blue-900 focus:ring-1 focus:ring-blue-900 bg-white resize-none">{{ old('analisa', $review->analisa) }}</textarea>
                        @error('analisa') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <!-- Tindak Lanjut -->
                    <div class="bg-blue-50/20 p-4">
                        <div class="italic underline font-bold mb-2 text-black">Tindak Lanjut:</div>
                        <textarea name="tindak_lanjut" rows="4" placeholder="Ketik rencana tindak lanjut di sini..." class="w-full border border-gray-300 p-3 focus:border-blue-900 focus:ring-1 focus:ring-blue-900 bg-white resize-none">{{ old('tindak_lanjut', $review->tindak_lanjut) }}</textarea>
                        @error('tindak_lanjut') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="flex justify-end pt-6 mt-6 border-t border-gray-200 gap-4">
                <a href="{{ route('reviews.index') }}" class="bg-gray-200 text-gray-700 font-bold py-3 px-6 rounded hover:bg-gray-300 transition shadow-sm flex items-center justify-center">
                    Batal
                </a>
                <button type="submit" style="background-color: #0b2259;" class="text-white font-bold py-3 px-8 rounded hover:bg-blue-800 transition shadow-lg flex items-center gap-2 text-base">
                    🖫 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection