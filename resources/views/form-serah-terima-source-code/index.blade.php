@extends('layouts.app')

@section('title', 'Serah Terima Source Code')

@section('content')

@if (session('success'))
<div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-900">
    {{ session('success') }}
</div>
@endif

<div class="mb-4 flex justify-start">
    <a href="{{ route('formulir.index') }}" class="inline-flex items-center gap-2 text-[14px] font-semibold text-slate-500 hover:text-blue-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Katalog
    </a>
</div>

<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold">Daftar Berita Acara Serah Terima Source Code</h1>
    <a href="{{ route('form-serah-terima-source-code.create') }}" class="inline-flex items-center justify-center px-4 h-[40px] bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-[13px] font-semibold transition-colors">Tambah Formulir</a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
    <div class="mb-4">
        <input type="text" x-data x-model="search" placeholder="Cari aplikasi atau pihak kedua..." class="w-full border border-slate-300 rounded-lg px-4 py-3" />
    </div>

    @if($forms->count() === 0)
        <div class="text-center py-10 text-slate-500">Belum ada data formulir.</div>
    @else
        <div class="space-y-3">
            @foreach($forms as $form)
                <div class="flex items-center justify-between gap-4 bg-white rounded-xl p-5 border border-slate-200 hover:border-blue-300 transition-all">
                    <div>
                        <p class="text-[11px] text-slate-500 font-bold mb-1 uppercase tracking-wider">Aplikasi</p>
                        <h2 class="text-[14px] font-bold text-slate-900">{{ $form->nama_aplikasi ?: '-' }}</h2>
                        <p class="text-[13px] text-slate-500 mt-1">Pihak Kedua: {{ $form->pihak_kedua_nama ?: '-' }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('form-serah-terima-source-code.show', $form->id) }}" title="Lihat" class="text-slate-500 hover:text-slate-700 bg-slate-50 hover:bg-slate-100 h-[40px] w-[40px] flex items-center justify-center rounded-lg transition-colors" aria-label="Lihat">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </a>
                        <a href="{{ route('form-serah-terima-source-code.edit', $form->id) }}" title="Edit" class="text-amber-500 hover:text-amber-700 bg-amber-50 hover:bg-amber-100 h-[40px] w-[40px] flex items-center justify-center rounded-lg transition-colors" aria-label="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <a href="{{ route('form-serah-terima-source-code.print', $form->id) }}" target="_blank" title="Cetak" class="text-emerald-600 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 h-[40px] w-[40px] flex items-center justify-center rounded-lg transition-colors" aria-label="Cetak">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        </a>
                        <form action="{{ route('form-serah-terima-source-code.destroy', $form->id) }}" method="POST" class="inline-block m-0">
                            @csrf @method('DELETE')
                            <button type="button" onclick="confirmDelete(this.form)" class="text-red-500 hover:text-red-700 bg-[#fef2f2] hover:bg-red-100 h-[40px] w-[40px] flex items-center justify-center rounded-lg transition-colors" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">{{ $forms->links() }}</div>
    @endif
</div>

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
