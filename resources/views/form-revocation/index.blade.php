@extends('layouts.app')

@section('title', 'Permohonan Pencabutan Hak Akses')

@section('content')

@if (session('success'))
<div id="success-alert" class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-4 text-emerald-800 shadow-sm transition-all duration-500 ease-in-out">
    <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    </div>
    <div class="flex-1">
        <p class="text-sm font-semibold">Berhasil!</p>
        <p class="text-xs text-emerald-600 mt-0.5">{{ session('success') }}</p>
    </div>
    <button onclick="dismissAlert()" class="text-emerald-400 hover:text-emerald-600 p-1.5 rounded-lg hover:bg-emerald-100 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>

<script>
    function dismissAlert() {
        const alert = document.getElementById('success-alert');
        if (alert) {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                alert.style.removeProperty('display');
                alert.setAttribute('style', 'display: none !important;');
            }, 500);
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(dismissAlert, 5000); // 5 seconds
    });
</script>
@endif

<!-- Tombol Kembali -->
<div class="mb-4 flex justify-start">
    <a href="{{ route('formulir.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-900 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Katalog
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
<!-- Header -->
<div class="flex justify-between items-start mb-8">
    <div class="flex items-center gap-4">
        <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center shadow-sm">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pencabutan Hak Akses</h1>
            <p class="text-sm text-gray-500 mt-1">Daftar semua formulir permohonan pencabutan hak akses</p>
        </div>
    </div>
</div>

<!-- Toolbar -->
<div class="flex justify-end items-center mb-4 px-2">
    <div class="flex items-center gap-2">
        <a href="{{ route('form-revocation.create') }}" class="inline-flex items-center justify-center px-4 h-[40px] bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-colors w-auto">
            Tambah Formulir
        </a>
    </div>
</div>

<!-- List of Submissions -->
<div class="space-y-2">
    @forelse ($forms as $form)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center gap-4 hover:shadow-md transition-shadow group relative">

        <div class="flex-1 grid grid-cols-12 gap-4 items-center">
            <div class="col-span-2">
                <p class="text-xs text-gray-500 font-medium mb-0.5">No. Ref</p>
                <p class="text-sm font-semibold text-gray-900">{{ $form->no_ref ?: '-' }}</p>
            </div>
            <div class="col-span-3">
                <p class="text-xs text-gray-500 font-medium mb-0.5">Nama Pemohon</p>
                <p class="text-sm font-medium text-gray-900">{{ $form->nama_pemohon ?: '-' }}</p>
            </div>
            <div class="col-span-3">
                <p class="text-xs text-gray-500 font-medium mb-0.5">Bagian / Fungsi</p>
                <p class="text-sm font-medium text-gray-900 truncate" title="{{ $form->bagian_fungsi }}">{{ $form->bagian_fungsi ?: '-' }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-xs text-gray-500 font-medium mb-0.5">Tanggal</p>
                <p class="text-sm font-medium text-gray-900">{{ $form->tanggal ? \Carbon\Carbon::parse($form->tanggal)->format('d M Y') : '-' }}</p>
            </div>
            <div class="col-span-2 flex justify-end items-center">
                <!-- Actions -->
                <div class="flex items-center gap-2">
                    <a href="{{ route('form-revocation.edit', $form->id) }}" class="text-amber-500 hover:text-amber-700 bg-amber-50 hover:bg-amber-100 h-[40px] w-[40px] flex items-center justify-center rounded-lg transition-colors" title="Edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </a>
                    <a href="{{ route('form-revocation.show', $form->id) }}" class="text-emerald-600 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 h-[40px] w-[40px] flex items-center justify-center rounded-lg transition-colors" title="Cetak / Lihat PDF">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    </a>
                    <form action="{{ route('form-revocation.destroy', $form->id) }}" method="POST" class="inline-block m-0">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete(this.form)" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 h-[40px] w-[40px] flex items-center justify-center rounded-lg transition-colors" title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <p class="text-gray-900 font-semibold mb-1">Belum ada data formulir pencabutan hak akses</p>
        <p class="text-sm text-gray-500 mb-6">Silakan buat formulir baru untuk memulai pencatatan.</p>
        <div class="flex items-center justify-center gap-2">
            <a href="{{ route('form-revocation.create') }}" class="inline-flex items-center justify-center px-4 h-[40px] bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-colors w-auto">
                Tambah Formulir
            </a>
        </div>
    </div>
    @endforelse
</div>
</div>
@endsection

@section('scripts')
<style>
    div.swal2-popup.custom-swal-popup {
        border-radius: 36px !important;
    }
</style>
<script>
    function confirmDelete(form) {
        Swal.fire({
            html: `
                <div class="flex flex-col items-center pt-4">
                    <div class="relative flex items-center justify-center w-16 h-16 mb-6">
                        <div class="absolute inset-0 bg-[#f44336] blur-xl opacity-30 rounded-full"></div>
                        <svg class="w-10 h-10 text-[#f44336] relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </div>
                    <h2 class="text-[22px] font-bold text-gray-900 mb-2 text-center">Apakah Anda yakin?</h2>
                    <p class="text-[15px] font-medium text-gray-600 text-center leading-relaxed">Data ini akan dihapus untuk semua orang</p>
                </div>
            `,
            width: '360px',
            scrollbarPadding: false,
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            buttonsStyling: false,
            customClass: {
                popup: 'custom-swal-popup p-6 shadow-2xl border-0',
                htmlContainer: 'm-0',
                confirmButton: 'rounded-2xl bg-[#f44336] hover:bg-[#d32f2f] text-white text-base font-semibold px-8 py-3.5 ml-3 transition-colors flex-1',
                cancelButton: 'rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-600 text-base font-semibold px-8 py-3.5 transition-colors flex-1',
                actions: 'mt-6 w-full flex justify-center gap-2 px-4 pb-2',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
@endsection
