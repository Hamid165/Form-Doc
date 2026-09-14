@extends('layouts.app')

@section('title', 'Checklist Pemeliharaan PC-Notebook-Printer')

@section('content')

{{-- Alert Success --}}
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
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
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
        <p class="text-[13px] font-medium text-[#dc2626]">{{ session('error') ?? $errors->first() }}</p>
    </div>
    <button @click="show = false" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#f87171] hover:text-[#dc2626] transition-colors p-1 rounded-md hover:bg-[#fee2e2]">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>
@endif

{{-- Breadcrumb --}}
<div class="mb-4">
    <a href="{{ route('formulir.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Katalog
    </a>
</div>

{{-- Main Card --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 flex flex-col min-h-[500px] mb-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-8 px-2">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center shadow-sm shrink-0">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">CHECKLIST PEMELIHARAAN PC-NOTEBOOK-PRINTER</h1>
                <p class="text-sm text-gray-500 mt-1">Daftar semua formulir checklist pemeliharaan PC / Notebook / Printer</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2" x-data="{
            searchQuery: '{{ request('search') }}',
            timeout: null,
            performSearch() {
                clearTimeout(this.timeout);
                this.timeout = setTimeout(() => {
                    window.location.href = '{{ route('form-checklist-pc.index') }}?search=' + encodeURIComponent(this.searchQuery);
                }, 400);
            }
        }">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" x-model="searchQuery" @input="performSearch()" placeholder="Cari formulir..."
                       class="pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-56">
            </div>
            <a href="{{ route('form-checklist-pc.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Formulir
            </a>
        </div>
    </div>

    @if ($forms->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-1">Belum ada formulir</h3>
            <p class="text-sm text-gray-400">Klik "Buat Formulir" untuk memulai</p>
        </div>
    @else
        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 w-10">#</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">No. Referensi</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Business Area</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Pelaksana</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Jml Aset</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($forms as $index => $form)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 text-gray-400">{{ $forms->firstItem() + $index }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $form->no_ref ?: '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $form->tanggal ? $form->tanggal->translatedFormat('d M Y') : '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $form->business_area ?: '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $form->pelaksana_name ?: '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $form->items()->count() }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('form-checklist-pc.show', $form) }}" class="text-blue-600 hover:text-blue-800 transition-colors" title="Lihat">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                <a href="{{ route('form-checklist-pc.edit', $form) }}" class="text-yellow-600 hover:text-yellow-800 transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <a href="{{ route('form-checklist-pc.pdf', $form) }}" onclick="printChecklistPdf(event, this.href)" class="text-slate-600 hover:text-slate-900 transition-colors" title="Print">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2M6 14h12v8H6v-8z"></path></svg>
                                </a>
                                <form method="POST" action="{{ route('form-checklist-pc.destroy', $form) }}" class="inline"
                                      onsubmit="return confirm('Hapus formulir ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition-colors" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $forms->links() }}</div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    // Cetak PDF LANGSUNG tanpa menampilkan formulirnya dulu ke user:
    // PDF dimuat ke <iframe> yang diposisikan JAUH DI LUAR LAYAR (bukan ukuran 0x0!).
    // Catatan penting: kalau iframe dibuat 0x0 atau display:none, PDF plugin browser
    // (Chrome PDFium dkk) sering GAGAL merender kontennya sama sekali, sehingga
    // print() gagal/di-skip dan browser jatuh ke fallback (buka tab baru penuh
    // seperti sebelumnya). Makanya di sini iframe tetap diberi ukuran normal,
    // hanya posisinya digeser jauh ke luar area yang terlihat (left/top negatif besar).
    function printChecklistPdf(event, url) {
        event.preventDefault();

        const old = document.getElementById('checklist-print-frame');
        if (old) old.remove();

        const iframe = document.createElement('iframe');
        iframe.id = 'checklist-print-frame';
        iframe.style.position = 'fixed';
        iframe.style.top = '-10000px';
        iframe.style.left = '-10000px';
        iframe.style.width = '900px';
        iframe.style.height = '650px';
        iframe.style.border = '0';
        iframe.src = url;

        let printed = false;
        const triggerPrint = () => {
            if (printed) return;
            printed = true;
            try {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
            } catch (e) {
                window.open(url, '_blank');
            }
        };

        // onload PDF plugin kadang terpicu sebelum konten benar2 selesai dirender,
        // jadi kasih jeda singkat sebelum print() dipanggil.
        iframe.onload = () => setTimeout(triggerPrint, 400);
        // Jaring pengaman kalau event onload PDF plugin tidak pernah terpicu.
        setTimeout(triggerPrint, 2500);

        document.body.appendChild(iframe);

        // Bersihkan iframe beberapa saat setelah dialog print biasanya sudah tertutup.
        setTimeout(() => iframe.remove(), 60000);
    }
</script>
@endsection