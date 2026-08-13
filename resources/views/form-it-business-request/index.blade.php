@extends('layouts.app')

@section('title', 'Formulir IT Business Request')

@section('content')

@if (session('success'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition 
     class="mb-6 bg-[#f0fdf4] border border-[#bbf7d0] rounded-xl flex items-center p-3 relative shadow-sm">
    <div class="w-10 h-10 bg-[#dcfce7] rounded-lg flex items-center justify-center shrink-0 mr-4">
        <svg class="w-5 h-5 text-[#059669]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </div>
    <div class="flex flex-col">
        <h4 class="text-sm font-bold text-[#065f46] mb-0.5">Berhasil!</h4>
        <p class="text-[13px] font-medium text-[#059669]">{{ session('success') }}</p>
    </div>
    <button @click="show = false" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#10b981] hover:text-[#047857] transition-colors p-1 rounded-md hover:bg-[#dcfce7]">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>
@endif

@if ($errors->any() || session('error'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition 
     class="mb-6 bg-[#fef2f2] border border-[#fecaca] rounded-xl flex items-center p-3 relative shadow-sm">
    <div class="w-10 h-10 bg-[#fee2e2] rounded-lg flex items-center justify-center shrink-0 mr-4">
        <svg class="w-5 h-5 text-[#dc2626]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </div>
    <div class="flex flex-col">
        <h4 class="text-sm font-bold text-[#991b1b] mb-0.5">Gagal!</h4>
        <p class="text-[13px] font-medium text-[#dc2626]">
            {{ session('error') ?? $errors->first() }}
        </p>
    </div>
    <button @click="show = false" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#f87171] hover:text-[#dc2626] transition-colors p-1 rounded-md hover:bg-[#fee2e2]">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>
@endif

<div class="mb-4">
    <a href="{{ route('formulir.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Katalog
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 flex flex-col h-full min-h-[500px] mb-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-8 px-2">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center shadow-sm shrink-0">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">FORMULIR IT BUSINESS REQUEST</h1>
                <p class="text-sm text-gray-500 mt-1">Daftar semua IT Business Request</p>
            </div>
        </div>
        
        <div class="flex flex-wrap items-center gap-2" x-data="{
            searchQuery: '{{ request('search') }}',
            timeout: null,
            performSearch() {
                clearTimeout(this.timeout);
                this.timeout = setTimeout(() => {
                    window.location.href = '{{ route('form-it-business-request.index') }}?search=' + encodeURIComponent(this.searchQuery);
                }, 500);
            }
        }">
            <div class="relative">
                <input type="text" x-model="searchQuery" @input="performSearch" placeholder="Cari No. Ref..." class="h-[40px] pl-9 pr-4 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors w-full sm:w-64">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <a href="{{ route('form-it-business-request.create') }}" class="inline-flex items-center justify-center px-4 h-[40px] bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-colors">
                Tambah
            </a>
        </div>
    </div>

    <div id="it-request-list-container" class="space-y-2 flex-1 flex flex-col">
        @forelse ($forms as $form)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center gap-4 hover:shadow-md transition-shadow group relative">
            <div class="flex-1 grid grid-cols-1 md:grid-cols-12 gap-4 items-start md:items-center">
                <div class="col-span-1 md:col-span-3">
                    <p class="text-xs text-gray-500 font-medium mb-0.5">No. Ref</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $form->no_ref ?: '-' }}</p>
                </div>
                <div class="col-span-1 md:col-span-4">
                    <p class="text-xs text-gray-500 font-medium mb-0.5">Deskripsi</p>
                    <p class="text-sm font-medium text-gray-900 truncate" title="{{ $form->deskripsi_umum }}">{{ $form->deskripsi_umum ?: '-' }}</p>
                </div>
                <div class="col-span-1 md:col-span-2">
                    <p class="text-xs text-gray-500 font-medium mb-0.5">Tanggal</p>
                    <p class="text-sm font-medium text-gray-900">{{ $form->tanggal ? \Carbon\Carbon::parse($form->tanggal)->format('d M Y') : '-' }}</p>
                </div>
                <div class="col-span-1 md:col-span-3 flex justify-start md:justify-end items-center mt-2 md:mt-0">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('form-it-business-request.edit', $form->id) }}" class="text-amber-500 hover:text-amber-700 bg-amber-50 hover:bg-amber-100 h-[40px] w-[40px] flex items-center justify-center rounded-lg transition-colors" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <a href="{{ route('form-it-business-request.show', $form->id) }}" class="text-emerald-600 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 h-[40px] w-[40px] flex items-center justify-center rounded-lg transition-colors" title="Lihat">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                        <form action="{{ route('form-it-business-request.destroy', $form->id) }}" method="POST" class="inline-block m-0">
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
            <p class="text-gray-900 font-semibold mb-1">Belum ada data formulir</p>
            <p class="text-sm text-gray-500 mb-6">Silakan buat formulir baru untuk memulai pencatatan.</p>
            <div class="flex items-center justify-center gap-2">
                <a href="{{ route('form-it-business-request.create') }}" class="inline-flex items-center justify-center px-4 h-[40px] bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-colors w-auto">
                    Tambah
                </a>
            </div>
        </div>
        @endforelse
    </div>

    @if($forms->hasPages())
        <div class="mt-auto pt-6">
            {{ $forms->appends(request()->except('page'))->links('pagination::tailwind') }}
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
