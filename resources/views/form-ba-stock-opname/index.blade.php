@extends('layouts.app')

@section('title', 'Berita Acara Stock Opname')

@section('content')

@if (session('success'))
<div id="success-alert" class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center justify-between text-emerald-800 shadow-sm transition-all duration-500 ease-in-out">
    <div class="flex items-center gap-4">
        <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-bold">Berhasil!</p>
            <p class="text-[13px] text-emerald-600 mt-0.5">{{ session('success') }}</p>
        </div>
    </div>
    <button onclick="dismissAlert()" class="text-emerald-400 hover:text-emerald-600 p-2 rounded-lg hover:bg-emerald-100 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>
<script>
    function dismissAlert() {
        const alert = document.getElementById('success-alert');
        if (alert) {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.style.display = 'none', 500);
        }
    }
    document.addEventListener('DOMContentLoaded', () => setTimeout(dismissAlert, 5000));
</script>
@endif

<div class="mb-6 flex justify-start">
    <a href="{{ route('formulir.index') }}" class="inline-flex items-center gap-2 text-[14px] font-semibold text-slate-500 hover:text-blue-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Katalog
    </a>
</div>

<!-- Main Card Daftar Formulir -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8" x-data="{
    search: '',
    get hasResults() {
        if (this.search === '') return true;
        const searchLower = this.search.toLowerCase();
        if (!this.$refs.list) return true;
        return Array.from(this.$refs.list.children).some(
            el => el.getAttribute('data-searchable') === 'true' && el.innerText.toLowerCase().includes(searchLower)
        );
    }
}">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 border border-blue-100 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <div>
                <h1 class="text-[17px] font-bold text-slate-900 uppercase">BA STOCK OPNAME</h1>
                <p class="text-[13px] text-slate-500 mt-0.5">Daftar semua formulir berita acara stock opname</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" x-model="search" placeholder="Cari data..." class="w-[240px] pl-9 pr-4 h-[40px] bg-white border border-slate-200 rounded-lg text-[13px] focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all">
            </div>

            <a href="{{ route('form-ba-stock-opname.create') }}" class="inline-flex h-[40px] px-5 bg-[#1d4ed8] hover:bg-blue-800 text-white rounded-lg text-[13px] font-semibold items-center justify-center transition-colors whitespace-nowrap">
                Tambah Formulir
            </a>
        </div>
    </div>

    @if($forms->count() == 0)
    <div class="text-center py-14 px-4 border border-dashed border-slate-200 rounded-xl bg-slate-50/50">
        <h3 class="text-[15px] font-bold text-slate-900 mb-1">Belum ada data formulir BA Stock Opname</h3>
        <p class="text-[13px] text-slate-500 mb-5">Silakan buat formulir baru untuk memulai pencatatan.</p>
    </div>
    @else

    <div class="space-y-4" x-ref="list">
        @foreach ($forms as $form)
        <div data-searchable="true" x-show="search === '' || $el.innerText.toLowerCase().includes(search.toLowerCase())" class="bg-white rounded-xl border border-slate-200 p-5 flex items-center justify-between hover:border-blue-300 transition-all">
            <div class="grid grid-cols-3 gap-8 flex-1">
                <div>
                    <p class="text-[11px] text-slate-500 font-bold mb-1 uppercase tracking-wider">Tanggal</p>
                    <p class="text-[14px] font-bold text-slate-900">{{ $form->tanggal_stock_opname ? \Carbon\Carbon::parse($form->tanggal_stock_opname)->locale('id')->translatedFormat('d M Y') : '-' }}</p>
                </div>
                <div>
                    <p class="text-[11px] text-slate-500 font-bold mb-1 uppercase tracking-wider">Unit Kerja</p>
                    <p class="text-[14px] font-bold text-slate-900">{{ $form->unit_kerja ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-[11px] text-slate-500 font-bold mb-1 uppercase tracking-wider">Tempat Kedudukan</p>
                    <p class="text-[14px] font-bold text-slate-900">{{ $form->tempat_kedudukan ?: '-' }}</p>
                </div>
            </div>

            <div class="flex items-center gap-2 ml-6">
                <a href="{{ route('form-ba-stock-opname.edit', $form->id) }}" class="text-amber-500 hover:text-amber-600 bg-amber-50 hover:bg-amber-100 h-[38px] w-[38px] flex items-center justify-center rounded-lg transition-colors" title="Edit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </a>
                <a href="{{ route('form-ba-stock-opname.show', $form->id) }}" class="text-emerald-500 hover:text-emerald-600 bg-emerald-50 hover:bg-emerald-100 h-[38px] w-[38px] flex items-center justify-center rounded-lg transition-colors" title="Cetak">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                </a>
                <form action="{{ route('form-ba-stock-opname.destroy', $form->id) }}" method="POST" class="inline-block m-0">
                    @csrf @method('DELETE')
                    <button type="button" onclick="confirmDelete(this.form)" class="text-red-500 hover:text-red-600 bg-red-50 hover:bg-red-100 h-[38px] w-[38px] flex items-center justify-center rounded-lg transition-colors" title="Hapus">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <div x-show="!hasResults" style="display: none;" class="text-center py-12 px-4 border border-dashed border-slate-200 rounded-xl bg-slate-50/50 mt-4">
        <h3 class="text-[15px] font-bold text-slate-900 mb-1">Data tidak ditemukan</h3>
        <p class="text-[13px] text-slate-500 mb-0">Tidak ada formulir yang cocok dengan pencarian "<span x-text="search" class="font-semibold text-slate-700"></span>".</p>
    </div>

    @if($forms->hasPages())
        <div class="mt-6 border-t border-slate-100 pt-6">
            {{ $forms->appends(request()->except('form_page'))->links('pagination::tailwind') }}
        </div>
    @endif
    @endif
</div>

<!-- Data Penandatanganan Formulir -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-8 h-8 rounded-full flex items-center justify-center text-blue-600 bg-blue-50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
        </div>
        <h2 class="text-[16px] font-bold text-slate-900">Data Penandatanganan Formulir</h2>
    </div>

    <form action="{{ route('master-bastock.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase mb-2">NAMA</label>
                <input type="text" name="nama" class="w-full border-gray-300 rounded-md" placeholder="Nama Lengkap" required>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase mb-2">JABATAN</label>
                <input type="text" name="jabatan" class="w-full border-gray-300 rounded-md" placeholder="Jabatan">
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase mb-2">NIPP</label>
                <div class="flex gap-2">
                    <input type="text" name="nipp" class="w-full border-gray-300 rounded-md" placeholder="NIPP">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md font-semibold text-sm">Tambah</button>
                </div>
            </div>
        </div>
    </form>

    <div class="space-y-3">
        @forelse ($masterSigners ?? [] as $signer)
        <div x-data="{ editing: false }" class="bg-white rounded-lg border border-slate-200 p-4 flex items-center justify-between">

            <!-- LIST ITEM DENGAN GRID SEJAJAR HEADER -->
            <div x-show="!editing" class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4 items-center pr-4">
                <span class="text-[14px] font-bold text-slate-900">{{ $signer->nama }}</span>
                <span class="text-[13px] text-slate-500">{{ $signer->jabatan ?: 'Tanpa Jabatan' }}</span>
                <span class="text-[13px] text-slate-500 font-mono">NIPP: {{ $signer->nipp ?: '-' }}</span>
            </div>

            <!-- TOMBOL EDIT/HAPUS -->
            <div x-show="!editing" class="flex items-center gap-2">
                <button type="button" @click="editing = true" class="text-amber-500 hover:text-amber-600 bg-amber-50 hover:bg-amber-100 h-8 w-8 flex items-center justify-center rounded-lg transition-colors" title="Edit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </button>
                <form action="{{ route('master-bastock.destroy', $signer->id) }}" method="POST" class="m-0">
                    @csrf @method('DELETE')
                    <button type="button" onclick="confirmDelete(this.form)" class="text-red-500 hover:text-red-600 bg-red-50 hover:bg-red-100 h-8 w-8 flex items-center justify-center rounded-lg transition-colors" title="Hapus">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>

            <!-- FORM EDIT -->
            <form x-show="editing" style="display: none;" action="{{ route('master-bastock.update', $signer->id) }}" method="POST" class="w-full flex gap-3 items-center">
                @csrf @method('PUT')
                <input type="text" name="nama" value="{{ $signer->nama }}" class="flex-1 h-[36px] px-3 border border-slate-200 rounded-lg text-[13px]" required>
                <input type="text" name="jabatan" value="{{ $signer->jabatan }}" class="flex-1 h-[36px] px-3 border border-slate-200 rounded-lg text-[13px]">
                <input type="text" name="nipp" value="{{ $signer->nipp }}" class="w-[150px] h-[36px] px-3 border border-slate-200 rounded-lg text-[13px]" placeholder="NIPP">
                <button type="button" @click="editing = false" class="h-[36px] px-4 bg-slate-200 text-slate-700 rounded-lg text-[12px] font-semibold">Batal</button>
                <button type="submit" class="h-[36px] px-4 bg-[#16a34a] text-white rounded-lg text-[12px] font-semibold">Simpan</button>
            </form>
        </div>
        @empty
        <div class="text-center py-10 text-slate-500 text-[13px]">
            Belum ada data penandatangan.
        </div>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')
<style> div.swal2-popup.custom-swal-popup { border-radius: 24px !important; } </style>
<script>
    function confirmDelete(form) {
        Swal.fire({
            html: `
                <div class="flex flex-col items-center pt-4">
                    <div class="relative flex items-center justify-center w-16 h-16 mb-6">
                        <div class="absolute inset-0 bg-[#ef4444] blur-xl opacity-20 rounded-full"></div>
                        <svg class="w-10 h-10 text-[#ef4444] relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </div>
                    <h2 class="text-[20px] font-bold text-slate-900 mb-2 text-center">Apakah Anda yakin?</h2>
                    <p class="text-[14px] font-medium text-slate-500 text-center leading-relaxed">Data ini akan dihapus secara permanen.</p>
                </div>
            `,
            width: '340px',
            showConfirmButton: true, showCancelButton: true, confirmButtonText: 'Hapus', cancelButtonText: 'Batal',
            reverseButtons: true, buttonsStyling: false,
            customClass: {
                popup: 'custom-swal-popup p-6 shadow-xl border-0',
                confirmButton: 'rounded-xl bg-[#ef4444] hover:bg-[#dc2626] text-white text-[14px] font-semibold px-6 py-3 ml-3 flex-1',
                cancelButton: 'rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-[14px] font-semibold px-6 py-3 flex-1',
                actions: 'mt-6 w-full flex justify-center gap-2 px-2 pb-2',
            }
        }).then((result) => { if (result.isConfirmed) form.submit(); });
    }
</script>
@endsection
