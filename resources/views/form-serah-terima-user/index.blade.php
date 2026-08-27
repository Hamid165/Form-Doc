@extends('layouts.app')

@section('title', 'Berita Acara Serah Terima User Aplikasi')

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
        setTimeout(dismissAlert, 5000);
    });
</script>
@endif

@if (session('error'))
<div id="error-alert" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl flex items-center gap-4 text-red-800 shadow-sm transition-all duration-500 ease-in-out">
    <div class="flex-shrink-0 w-10 h-10 bg-red-100 text-red-600 rounded-xl flex items-center justify-center">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    </div>
    <div class="flex-1">
        <p class="text-sm font-semibold">Gagal!</p>
        <p class="text-xs text-red-600 mt-0.5">{{ session('error') }}</p>
    </div>
    <button onclick="dismissErrorAlert()" class="text-red-400 hover:text-red-600 p-1.5 rounded-lg hover:bg-red-100 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>

<script>
    function dismissErrorAlert() {
        const alert = document.getElementById('error-alert');
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
        setTimeout(dismissErrorAlert, 5000);
    });
</script>
@endif

<div class="mb-4 flex justify-start">
    <a href="{{ route('formulir.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Katalog
    </a>
</div>

<!-- ======================= BAGIAN ATAS: DAFTAR FORMULIR ======================= -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 mb-8" x-data="{ 
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
    <!-- Header -->
    <div class="flex justify-between items-end mb-8">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center shadow-sm">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Serah Terima User Aplikasi</h1>
                <p class="text-sm text-gray-500 mt-1">Daftar semua formulir berita acara serah terima user aplikasi</p>
            </div>
        </div>
        
        <!-- Search and Actions -->
        <div class="flex items-center gap-3">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" x-model="search" placeholder="Cari data..." class="w-64 pl-10 pr-4 h-[40px] bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
            </div>
            
            <a href="{{ route('form-serah-terima-user.create') }}" class="inline-flex items-center justify-center px-4 h-[40px] bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-colors w-auto">
                Tambah Formulir
            </a>
        </div>
    </div>

    <!-- List of Submissions -->
    <div class="space-y-2" x-ref="list">
        @forelse ($forms as $form)
        <div data-searchable="true" x-show="search === '' || $el.innerText.toLowerCase().includes(search.toLowerCase())" class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center gap-4 hover:shadow-md transition-shadow group relative">
            <div class="flex-1 grid grid-cols-12 gap-4 items-center">
                <div class="col-span-2">
                    <p class="text-xs text-gray-500 font-medium mb-0.5">No. Ref</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $form->no_ref ?: '-' }}</p>
                </div>
                <div class="col-span-3">
                    <p class="text-xs text-gray-500 font-medium mb-0.5">Yang Menyerahkan</p>
                    <p class="text-sm font-medium text-gray-900">{{ $form->nama_penyerah ?: '-' }}</p>
                </div>
                <div class="col-span-3">
                    <p class="text-xs text-gray-500 font-medium mb-0.5">Yang Menerima</p>
                    <p class="text-sm font-medium text-gray-900 truncate" title="{{ $form->nama_penerima }}">{{ $form->nama_penerima ?: '-' }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-xs text-gray-500 font-medium mb-0.5">Tanggal</p>
                    <p class="text-sm font-medium text-gray-900">{{ $form->tanggal ? \Carbon\Carbon::parse($form->tanggal)->locale('id')->translatedFormat('d M Y') : '-' }}</p>
                </div>
                <div class="col-span-2 flex justify-end items-center">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('form-serah-terima-user.preview', $form->id) }}" class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 h-[40px] w-[40px] flex items-center justify-center rounded-lg transition-colors" title="Lihat Dokumen">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                        <a href="{{ route('form-serah-terima-user.edit', $form->id) }}" class="text-amber-500 hover:text-amber-700 bg-amber-50 hover:bg-amber-100 h-[40px] w-[40px] flex items-center justify-center rounded-lg transition-colors" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <button onclick="printDocument('{{ route('form-serah-terima-user.show', $form->id) }}')" class="text-emerald-600 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 h-[40px] w-[40px] flex items-center justify-center rounded-lg transition-colors" title="Cetak / Lihat PDF">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        </button>
                        <form action="{{ route('form-serah-terima-user.destroy', $form->id) }}" method="POST" class="inline-block m-0">
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
                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            </div>
            <p class="text-gray-900 font-semibold mb-1">Belum ada data formulir serah terima user</p>
            <p class="text-sm text-gray-500 mb-6">Silakan buat formulir baru untuk memulai pencatatan.</p>
            <div class="flex items-center justify-center gap-2">
                <a href="{{ route('form-serah-terima-user.create') }}" class="inline-flex items-center justify-center px-4 h-[40px] bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-colors w-auto">
                    Tambah Formulir
                </a>
            </div>
        </div>
        @endforelse
    </div>

    @if($forms->count() > 0)
    <div x-show="!hasResults" style="display: none;" class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center mt-4">
        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
        </div>
        <p class="text-gray-900 font-semibold mb-1">Data tidak ditemukan</p>
        <p class="text-sm text-gray-500 mb-0">Tidak ada formulir yang cocok dengan pencarian "<span x-text="search" class="font-semibold text-gray-700"></span>".</p>
    </div>
    @endif
    
    @if($forms->hasPages())
        <div class="mt-6 border-t border-gray-100 pt-6">
            {{ $forms->appends(request()->except('form_page'))->links('pagination::tailwind') }}
        </div>
    @endif
</div>

<!-- ======================= BAGIAN BAWAH: CRUD DATA MASTER USER ======================= -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
    <!-- Header -->
    <div class="flex items-center gap-4 mb-8">
        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">Data Master Pegawai / User</h1>
    </div>

    <!-- Quick Add Form -->
    <form action="{{ route('master-serah-terima-user.store') }}" method="POST" class="mb-8 bg-slate-50 border border-slate-100 rounded-xl p-6">
        @csrf
        <h3 class="text-sm font-bold text-slate-700 mb-4 uppercase">Tambah Data Master Baru</h3>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-2 uppercase">Nama <span class="text-red-500">*</span></label>
                <input type="text" name="nama" placeholder="" class="w-full px-3 h-[42px] bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20" required>
            </div>
            
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-2 uppercase">NIPP / No Identitas</label>
                <input type="text" name="nipp" placeholder="" class="w-full px-3 h-[42px] bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 mb-2 uppercase">Jabatan / Instansi</label>
                <input type="text" name="jabatan" placeholder="" class="w-full px-3 h-[42px] bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 mb-2 uppercase">Tempat Kedudukan</label>
                <input type="text" name="tempat_kedudukan" placeholder=" " class="w-full px-3 h-[42px] bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 mb-2 uppercase">Personal Area</label>
                <input type="text" name="personal_area" placeholder=" " class="w-full px-3 h-[42px] bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20">
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <button type="submit" class="h-[42px] px-6 bg-[#1d4ed8] hover:bg-blue-800 text-white font-semibold rounded-xl text-sm transition-colors shadow-sm">
                Tambah Data
            </button>
        </div>
    </form>

    <!-- List of Data -->
    <div class="space-y-3">
        @forelse ($masterUsers as $user)
        <div x-data="{ editing: false }" class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 hover:shadow-md transition-shadow">
            
            <!-- VIEW MODE -->
            <div x-show="!editing" class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 flex-1">
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase">Nama</p>
                        <span class="text-sm font-bold text-gray-900">{{ $user->nama }}</span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase">NIPP / Identitas</p>
                        <span class="text-sm text-gray-700 font-medium">{{ $user->nipp ?: '-' }}</span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase">Jabatan / Instansi</p>
                        <span class="text-sm text-gray-700 font-medium">{{ $user->jabatan ?: '-' }}</span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase">Kedudukan</p>
                        <span class="text-sm text-gray-700 font-medium">{{ $user->tempat_kedudukan ?: '-' }}</span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase">Personal Area</p>
                        <span class="text-sm text-gray-700 font-medium">{{ $user->personal_area ?: '-' }}</span>
                    </div>
                </div>
                
                <div class="flex items-center gap-2 self-end md:self-auto">
                    <button type="button" @click="editing = true" class="text-amber-500 hover:text-amber-700 bg-[#fffbeb] hover:bg-amber-100 h-[38px] w-[38px] flex items-center justify-center rounded-lg transition-colors" title="Edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </button>
                    <form action="{{ route('master-serah-terima-user.destroy', $user->id) }}" method="POST" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete(this.form)" class="text-red-500 hover:text-red-700 bg-[#fef2f2] hover:bg-red-100 h-[38px] w-[38px] flex items-center justify-center rounded-lg transition-colors" title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- EDIT MODE -->
            <form x-show="editing" style="display: none;" action="{{ route('master-serah-terima-user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2 uppercase">Nama</label>
                        <input type="text" name="nama" value="{{ $user->nama }}" class="w-full h-[42px] px-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2 uppercase">NIPP / Identitas</label>
                        <input type="text" name="nipp" value="{{ $user->nipp }}" class="w-full h-[42px] px-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2 uppercase">Jabatan / Instansi</label>
                        <input type="text" name="jabatan" value="{{ $user->jabatan }}" class="w-full h-[42px] px-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2 uppercase">Kedudukan</label>
                        <input type="text" name="tempat_kedudukan" value="{{ $user->tempat_kedudukan }}" class="w-full h-[42px] px-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2 uppercase">Personal Area</label>
                        <input type="text" name="personal_area" value="{{ $user->personal_area }}" class="w-full h-[42px] px-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="editing = false" class="h-[42px] px-5 bg-[#ef4444] hover:bg-[#dc2626] text-white font-semibold rounded-xl text-sm transition-colors">Batal</button>
                    <button type="submit" class="h-[42px] px-5 bg-[#16a34a] hover:bg-[#15803d] text-white font-semibold rounded-xl text-sm transition-colors">Simpan</button>
                </div>
            </form>

        </div>
        @empty
        <div class="text-center py-10 text-slate-500 text-sm">
            Belum ada data master user.
        </div>
        @endforelse
    </div>
    
    @if($masterUsers->hasPages())
        <div class="mt-6 border-t border-gray-100 pt-6">
            {{ $masterUsers->appends(request()->except('master_page'))->links('pagination::tailwind') }}
        </div>
    @endif
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
                    <p class="text-[15px] font-medium text-gray-600 text-center leading-relaxed">Data ini akan dihapus permanen</p>
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

    function printDocument(url) {
        // Show loading Swal
        Swal.fire({
            title: 'Mempersiapkan Dokumen...',
            html: 'Mohon tunggu sebentar...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Create hidden iframe
        const iframe = document.createElement('iframe');
        iframe.style.position = 'fixed';
        iframe.style.right = '0';
        iframe.style.bottom = '0';
        iframe.style.width = '0';
        iframe.style.height = '0';
        iframe.style.border = '0';
        iframe.src = url;

        iframe.onload = function() {
            // Prevent onload from firing again
            iframe.onload = null;

            // Close Swal loader
            Swal.close();
            
            setTimeout(() => {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
                
                // Cleanup iframe after print dialog closes
                iframe.contentWindow.onafterprint = function() {
                    if (iframe.parentNode) {
                        document.body.removeChild(iframe);
                    }
                };
            }, 300);
        };

        document.body.appendChild(iframe);
    }
</script>
@endsection
