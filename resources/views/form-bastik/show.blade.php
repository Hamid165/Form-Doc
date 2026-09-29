@extends('layouts.app')

@section('title', 'Detail Berita Acara (BASTIK)')

@section('back_button')
<a href="{{ route('form-bastik.index') }}" class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors text-gray-500 hover:text-gray-700 shrink-0" title="Kembali ke Daftar">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
</a>
@endsection

@section('content')
@php
    $authUser = auth()->user();
    $hari = '-';
    $tanggalBulanTahun = '-';
    if (!empty($bastik->tanggal_surat)) {
        $parsedDate = \Carbon\Carbon::parse($bastik->tanggal_surat)->locale('id');
        $hari = $parsedDate->isoFormat('dddd');
        $tanggalBulanTahun = $parsedDate->isoFormat('D MMMM YYYY');
    }
@endphp

<div class="p-6 bg-gray-100 min-h-screen rounded-2xl" x-data="{ rejectModalOpen: false, previewModalOpen: false, previewUrl: '', previewTitle: '', isImage: true }">
    <div class="space-y-6 max-w-7xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="no-print flex text-sm text-gray-500 space-x-2 mb-4">
            <a href="{{ route('form-bastik.index') }}" class="hover:text-orange-500 transition">Daftar Berita Acara</a>
            <span>/</span>
            <span class="text-gray-800 font-semibold">Detail Berita Acara</span>
        </nav>

        <!-- Rejection Warning Banner -->
        @if($bastik->status === 'rejected')
            <div class="no-print bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-rose-800">DOKUMEN DITOLAK OLEH PIMPINAN</h3>
                        <p class="text-xs text-rose-700 mt-1"><strong>Alasan Penolakan:</strong> "{{ $bastik->rejection_note }}"</p>
                        @if($authUser && $authUser->role === 'petugas')
                            <p class="text-xs text-rose-600 mt-2 font-medium">Silakan lakukan perbaikan/revisi pada dokumen ini dengan mengklik tombol <strong>Edit / Revisi</strong> di bawah, kemudian submit ulang.</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Document Operations Bar (Actions Header) -->
        <div class="no-print flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-start space-x-4">
                <div class="p-3 bg-gray-50 rounded-lg text-gray-700 shadow-sm border border-gray-200">
                    <svg class="h-8 w-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <div class="flex items-center space-x-2 flex-wrap gap-y-1">
                        <h2 class="text-xl font-bold text-gray-900">{{ $bastik->nomor_surat ?? 'DRAFT BERITA ACARA' }}</h2>
                        
                        @if($bastik->status === 'draft')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 border border-gray-200">Draft</span>
                        @elseif($bastik->status === 'submitted')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-200">Menunggu Persetujuan</span>
                        @elseif($bastik->status === 'signed')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">✓ Approved / Signed</span>
                        @elseif($bastik->status === 'rejected')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800 border border-rose-200">Ditolak (Rejected)</span>
                        @elseif($bastik->status === 'final')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">Final (Legacy)</span>
                        @elseif($bastik->status === 'void')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800 border border-rose-200">Void / Batal</span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Pratinjau Resmi Dokumen Digital (Digital Document Preview)</p>
                </div>
            </div>

            <!-- Header Actions -->
            <div class="flex flex-wrap items-center gap-2">
                <!-- Edit / Revisi (Draft or Rejected) -->
                @if(in_array($bastik->status, ['draft', 'rejected']))
                    <a href="{{ route('form-bastik.edit', $bastik->id) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 transition shadow-sm" title="Edit Dokumen">
                        Edit / Revisi
                    </a>
                @endif

                <!-- Hapus Berita Acara (Draft or Rejected or Admin) -->
                @if(in_array($bastik->status, ['draft', 'rejected']) || ($authUser && $authUser->role === 'admin'))
                    <a href="{{ route('form-bastik.delete', $bastik->id) }}" onclick="return confirmBastikDelete(event, this.href)" class="px-4 py-2 border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-sm font-semibold transition shadow-sm" title="Hapus Dokumen">
                        Hapus
                    </a>
                @endif

                <!-- Submit for Approval (Petugas or Admin, if Draft or Rejected) -->
                @if(in_array($bastik->status, ['draft', 'rejected']))
                    <a href="{{ route('form-bastik.submit', $bastik->id) }}" onclick="return confirmBastikSubmit(event, this.href)" class="px-4 py-2 border border-transparent bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm font-semibold transition shadow-md inline-flex items-center" title="Submit Persetujuan">
                        Submit Persetujuan
                    </a>
                @endif

                <!-- Approve & Reject Actions (Pimpinan only, if Submitted) -->
                @if($bastik->status === 'submitted' && $authUser && $authUser->role === 'pimpinan')
                    @if($bastik->petugas_id !== $authUser->id)
                        <!-- Approve Button -->
                        <a href="{{ route('form-bastik.approve', $bastik->id) }}" onclick="return confirmBastikApprove(event, this.href)" class="px-4 py-2 border border-transparent bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold transition shadow-md flex items-center gap-1.5" title="Setujui Dokumen">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Approve / ACC
                        </a>

                        <!-- Reject Button (Opens Modal) -->
                        <button type="button" @click="rejectModalOpen = true" class="px-4 py-2 border border-transparent bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-semibold transition shadow-md flex items-center gap-1.5" title="Tolak Dokumen">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            Reject / Tolak
                        </button>
                    @else
                        <span class="text-xs text-amber-700 bg-amber-50 border border-amber-200 px-3 py-2 rounded-lg font-semibold">
                            Separation of Duties: Anda tidak dapat menyetujui dokumen buatan sendiri.
                        </span>
                    @endif
                @endif

                <!-- Cetak / Unduh PDF (Triggers print directly on current document) -->
                <button type="button" onclick="window.print()" class="inline-flex items-center px-4 py-2 border border-transparent bg-gray-900 hover:bg-gray-800 text-white rounded-lg text-sm font-semibold transition shadow-md gap-1.5" title="Cetak surat resmi">
                    <span>Cetak / Unduh PDF</span>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                </button>

                <!-- Unduh Word (Hanya untuk dokumen draft/revisi sebelum disahkan) -->
                @if(!in_array($bastik->status, ['signed', 'final', 'void']))
                    <a href="{{ route('form-bastik.download-docx', $bastik->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 rounded-lg text-sm font-semibold transition shadow-sm gap-1.5" title="Unduh format Word (.docx)">
                        <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span>Unduh Word</span>
                    </a>
                @endif

                <!-- Void Surat (Admin Only) -->
                @if(in_array($bastik->status, ['final', 'signed']) && $authUser && $authUser->role === 'admin')
                    <a href="{{ route('form-bastik.void', $bastik->id) }}" onclick="return confirmBastikVoid(event, this.href)" class="px-4 py-2 border border-transparent bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-semibold transition shadow" title="Batalkan Dokumen">
                        Void / Batalkan Surat
                    </a>
                @endif
            </div>
        </div>

        <!-- Main Layout Grid: Left (Digital Document Preview) & Right (System Info) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left Column: DIGITAL DOCUMENT PREVIEW (Matches PDF layout 100%) -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- White Paper Document Box -->
                <div class="printable-document bg-white p-6 sm:p-10 border border-gray-300 rounded-lg shadow-md font-sans text-gray-900 space-y-6">
                    
                    <!-- 1. KAI Kop Header Table (Identical to pdf.blade.php) -->
                    <div class="border border-gray-900 overflow-x-auto">
                        <table class="w-full text-xs text-center border-collapse border-spacing-0">
                            <tr class="h-10">
                                <!-- Logo KAI -->
                                <td rowspan="2" class="w-[20%] border border-gray-900 p-2 align-middle">
                                    <img src="{{ asset('images/logo-kai.svg') }}" alt="KAI Logo" class="h-9 w-auto mx-auto">
                                </td>
                                <!-- Nama Instansi -->
                                <td rowspan="2" class="w-[40%] border border-gray-900 p-2 align-middle font-bold text-gray-900 text-xs sm:text-sm leading-tight">
                                    PT. KERETA API INDONESIA (PERSERO)<br>
                                    <span class="text-[11px] font-semibold text-gray-700">SISTEM INFORMASI</span>
                                </td>
                                <!-- Label Nomor -->
                                <td class="w-[14%] border border-gray-900 p-1 align-middle font-semibold text-left">
                                    Nomor
                                </td>
                                <!-- Nomor Formulir Tetap -->
                                <td class="w-[26%] border border-gray-900 p-1 align-middle whitespace-nowrap text-left">
                                    FR.SM/TI/031.005/02-2023
                                </td>
                            </tr>
                            <tr class="h-10">
                                <td class="border border-gray-900 p-1 align-middle font-semibold text-left">
                                    Tanggal Terbit
                                </td>
                                <td class="border border-gray-900 p-1 align-middle whitespace-nowrap text-left">
                                    13 Februari 2023
                                </td>
                            </tr>
                            <tr class="h-10">
                                <!-- Status Dokumen -->
                                <td rowspan="2" class="border border-gray-900 p-2 align-middle">
                                    <span class="inline-block border-2 border-amber-400 text-amber-600 font-bold px-2 py-0.5 text-xs tracking-wider uppercase">
                                        TERBATAS
                                    </span>
                                </td>
                                <!-- Judul Formulir -->
                                <td rowspan="2" class="border border-gray-900 p-2 align-middle font-bold text-gray-900 text-xs sm:text-sm uppercase leading-tight">
                                    FORMULIR BERITA ACARA<br>
                                    PENUTUPAN TIKET INCIDENT/WORK ORDER
                                </td>
                                <td class="border border-gray-900 p-1 align-middle font-semibold text-left">
                                    Versi
                                </td>
                                <td class="border border-gray-900 p-1 align-middle text-left">
                                    001-2023
                                </td>
                            </tr>
                            <tr class="h-10">
                                <td class="border border-gray-900 p-1 align-middle font-semibold text-left">
                                    Halaman
                                </td>
                                <td class="border border-gray-900 p-1 align-middle text-left">
                                    1 dari 1
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- 2. Reference Metadata Table (100% Full Width - Identical to pdf.blade.php) -->
                    <div class="border border-gray-900 overflow-x-auto">
                        <table class="w-full text-xs border-collapse">
                            <tr>
                                <td class="border border-gray-900 p-2 font-bold w-[25%] bg-gray-50">No. Ref</td>
                                <td class="border border-gray-900 p-2 font-semibold text-gray-900 w-[75%]">: {{ $bastik->nomor_surat ?? '__/__/____' }}</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-900 p-2 font-bold bg-gray-50">Tanggal</td>
                                <td class="border border-gray-900 p-2 font-semibold text-gray-900">: {{ $bastik->tanggal_surat ? date('d - m - Y', strtotime($bastik->tanggal_surat)) : '__ - __ - ____' }}</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-900 p-2 font-bold bg-gray-50">Business Area</td>
                                <td class="border border-gray-900 p-2 font-semibold text-gray-900">: {{ $bastik->business_area ?? ($bastik->petugas->unit_kerja ?? '-') }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- 3. Document Opening Statement -->
                    <p class="text-sm text-gray-900 leading-relaxed">
                        Pada hari ini, <strong class="text-rose-700">{{ $hari }}, {{ $tanggalBulanTahun }}</strong>, yang bertanda tangan di bawah ini:
                    </p>

                    <!-- Petugas Identity Box -->
                    <div class="pl-2">
                        <p class="font-bold text-xs uppercase text-gray-800 mb-1">PETUGAS SERVICE DESK</p>
                        <table class="text-xs text-gray-800 space-y-1">
                            <tr>
                                <td class="w-24 font-semibold py-0.5">Nama</td>
                                <td class="w-4 py-0.5">:</td>
                                <td class="font-bold py-0.5">{{ $bastik->petugas->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold py-0.5">NIPKWT</td>
                                <td class="py-0.5">:</td>
                                <td class="py-0.5">{{ $bastik->petugas->nip_kwt ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>

                    <p class="text-xs text-gray-800 leading-relaxed text-justify">
                        Telah dilakukan konfirmasi tiket sebanyak 3 (tiga) kali kepada user yang bersangkutan namun belum ada respon dari pihak terkait. Adapun tiket yang telah di konfirmasi diantaranya sebagai berikut:
                    </p>

                    <!-- 4. Ticket Table (Identical structure to pdf.blade.php) -->
                    <div class="border border-gray-900 overflow-x-auto">
                        <table class="w-full text-xs text-left border-collapse">
                            <thead class="bg-gray-100 font-bold border-b border-gray-900">
                                <tr>
                                    <th class="p-2 border-r border-gray-900 w-[15%]">No Tiket</th>
                                    <th class="p-2 border-r border-gray-900 w-[35%]">Detail Tiket</th>
                                    <th class="p-2 border-r border-gray-900 w-[20%]">User Pemohon</th>
                                    <th class="p-2 border-r border-gray-900 w-[15%] text-center">NIPP</th>
                                    <th class="p-2 w-[15%]">Unit</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-900">
                                @foreach($bastik->items as $item)
                                    <tr>
                                        <td class="p-2 border-r border-gray-900 font-mono font-bold">{{ $item->no_tiket }}</td>
                                        <td class="p-2 border-r border-gray-900">{{ $item->detail_tiket }}</td>
                                        <td class="p-2 border-r border-gray-900 font-medium">{{ $item->user_pemohon }}</td>
                                        <td class="p-2 border-r border-gray-900 text-center font-mono">{{ $item->nipp }}</td>
                                        <td class="p-2">{{ $item->unit }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <p class="text-[11px] text-gray-600 italic mt-1">*Lampirkan bukti konfirmasi</p>
                    <p class="text-xs text-gray-900 my-4">Demikian Berita Acara ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>

                    <div class="pt-4 border-t border-dashed border-gray-300">
                        <p class="text-right text-xs text-gray-800 mb-6">{{ $bastik->kota }}, <strong class="text-rose-700">{{ $tanggalBulanTahun }}</strong></p>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 text-xs max-w-2xl mx-auto">
                            <!-- Petugas Service Desk Column -->
                            <div class="flex flex-col items-center text-center">
                                <p class="font-bold text-gray-800 mb-3">Petugas Service desk,</p>
                                
                                {{-- Digital Signature Box --}}
                                @php
                                    $petugasName = $bastik->petugas->name ?? '';
                                    $initials = collect(explode(' ', trim($petugasName)))
                                        ->filter()
                                        ->map(fn($w) => strtoupper($w[0]))
                                        ->take(2)
                                        ->implode('');
                                @endphp
                                <div class="flex flex-col items-center gap-1 my-4">
                                    <div class="relative w-28 h-14 border border-blue-200 rounded bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center overflow-hidden shadow-sm">
                                        <span class="font-bold text-blue-700 select-none"
                                              style="font-family: 'Brush Script MT', 'Dancing Script', cursive; font-size: 1.8rem; transform: rotate(-4deg); display:inline-block;">
                                            {{ $petugasName ? $initials : '—' }}
                                        </span>
                                        <div class="absolute inset-0 opacity-10" style="background: repeating-linear-gradient(-45deg, #3b82f6 0px, #3b82f6 1px, transparent 1px, transparent 10px);"></div>
                                    </div>
                                    <span class="text-[9px] text-blue-600 font-semibold tracking-wider uppercase">Tanda Tangan Digital</span>
                                </div>

                                <div class="mt-auto">
                                    <p class="font-bold text-gray-950 underline">( {{ $bastik->petugas->name ?? '-' }} )</p>
                                    <p class="text-[11px] text-gray-600 mt-0.5">NIPP/NIPKWT {{ $bastik->petugas->nip_kwt ?? '-' }}</p>
                                </div>
                            </div>
                            
                            <!-- Pimpinan / QR Column -->
                            <div class="flex flex-col items-center text-center">
                                <p class="font-bold text-gray-800 mb-3">Mengetahui,</p>
                                
                                <div class="my-4">
                                    @if(in_array($bastik->status, ['signed', 'final']))
                                        <!-- QR Code Digital Signature (KAI RDS Style) -->
                                        <div class="flex flex-col items-center gap-1.5">
                                            <div class="bg-white p-2 rounded border border-gray-400 shadow inline-block">
                                                {!! QrCode::size(90)->generate(route('form-bastik.verify', $bastik->qr_token)) !!}
                                            </div>
                                            <span class="inline-flex items-center gap-0.5 px-2 py-0.5 rounded text-[8px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300 tracking-wide">
                                                ✓ TANDA TANGAN ELEKTRONIK
                                            </span>
                                            <span class="text-[9px] text-gray-400 italic">Scan QR untuk verifikasi</span>
                                        </div>
                                    @elseif($bastik->status === 'submitted')
                                        <div class="px-3 py-2 border-2 border-dashed border-amber-300 bg-amber-50 text-center rounded text-amber-700 text-[11px] font-semibold">
                                            Menunggu Persetujuan Pimpinan
                                        </div>
                                    @elseif($bastik->status === 'rejected')
                                        <div class="px-3 py-2 border-2 border-dashed border-rose-300 bg-rose-50 text-center rounded text-rose-700 text-[11px] font-semibold">
                                            Dokumen Ditolak
                                        </div>
                                    @else
                                        <div class="px-3 py-2 bg-gray-100 text-center rounded text-gray-400 text-[11px] font-semibold cursor-not-allowed">
                                            Surat Berstatus Draft
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-auto">
                                    <p class="font-bold text-gray-950 underline">( {{ strtoupper($bastik->pimpinan->nama ?? '-') }} )</p>
                                    <p class="text-[11px] text-gray-600 mt-0.5">NIPP. {{ $bastik->pimpinan->nipp ?? '-' }}</p>
                                    @if(!empty($bastik->pimpinan->jabatan))
                                        <p class="text-[10px] text-gray-500 mt-0.5 italic">{{ $bastik->pimpinan->jabatan }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- 6. Confirmation Images Attachment Gallery (Matches Page 2 PDF layout) -->
                @if($bastik->lampirans->count() > 0)
                    <div class="bg-white p-6 border border-gray-300 rounded-lg shadow-md font-sans text-gray-900 space-y-4">
                        <h3 class="font-bold text-xs uppercase tracking-wider text-center border-b-2 border-gray-900 pb-2">
                            LAMPIRAN BUKTI KONFIRMASI ({{ $bastik->lampirans->count() }} FILE)
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                            @foreach($bastik->lampirans as $lampiran)
                                @php
                                    $ext = strtolower(pathinfo($lampiran->file_path, PATHINFO_EXTENSION));
                                    $isImg = in_array($ext, ['png', 'jpg', 'jpeg', 'gif', 'webp']);
                                    $fileUrl = route('form-bastik.lampiran.open', $lampiran->id);
                                    $fileTitle = 'Tiket ' . ($lampiran->item->no_tiket ?? '-') . ' - Bukti Konfirmasi Ke-' . $lampiran->urutan_konfirmasi;
                                @endphp
                                <div class="bg-gray-50 border border-gray-300 rounded-lg p-3 text-center space-y-2 group hover:border-blue-500 hover:shadow-md transition-all duration-200">
                                    <div class="font-bold text-xs text-gray-800 border-b border-gray-200 pb-2 flex justify-between items-center px-1">
                                        <span class="truncate">Tiket: {{ $lampiran->item->no_tiket ?? '-' }}</span>
                                        <a href="{{ $fileUrl }}" target="_blank" class="text-[11px] font-semibold text-blue-600 hover:text-blue-800 hover:underline inline-flex items-center gap-1 bg-blue-50 px-2 py-0.5 rounded border border-blue-200" title="Buka file di tab baru">
                                            <span>Buka</span>
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </a>
                                    </div>
                                    
                                    <div class="h-36 flex items-center justify-center overflow-hidden bg-gray-100 rounded-md relative cursor-pointer group-hover:bg-gray-200 transition-colors"
                                         @click="previewModalOpen = true; previewUrl = '{{ $fileUrl }}'; previewTitle = '{{ addslashes($fileTitle) }}'; isImage = {{ $isImg ? 'true' : 'false' }};"
                                         title="Klik untuk melihat / mengecek lampiran">
                                        @if($isImg)
                                            <img src="{{ $fileUrl }}" alt="Bukti Konfirmasi" class="max-h-32 max-w-full object-contain group-hover:scale-105 transition-transform duration-200">
                                            <!-- Hover Overlay -->
                                            <div class="absolute inset-0 bg-blue-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-1 text-white text-xs font-semibold backdrop-blur-[1px]">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                                <span>Klik untuk Perbesar</span>
                                            </div>
                                        @else
                                            <div class="text-center p-3 group-hover:scale-105 transition-transform duration-200 flex flex-col items-center justify-center">
                                                <div class="w-10 h-10 bg-blue-100 text-blue-700 rounded-lg flex items-center justify-center font-bold text-xs uppercase mb-1">
                                                    {{ $ext }}
                                                </div>
                                                <span class="text-xs text-gray-700 block truncate max-w-[160px] font-semibold">{{ $lampiran->original_name ?: basename($lampiran->file_path) }}</span>
                                                <span class="inline-flex items-center gap-1 text-[10px] text-blue-600 font-semibold mt-1 bg-blue-50 px-2 py-0.5 rounded border border-blue-200">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                    Klik untuk Lihat / Cek File
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="text-[11px] font-semibold text-gray-600 border-t border-gray-200 pt-2 flex justify-between items-center px-1">
                                        <span>Bukti Konfirmasi Ke-{{ $lampiran->urutan_konfirmasi }}</span>
                                        <a href="{{ $fileUrl }}" download class="text-[10px] text-gray-500 hover:text-gray-900 underline flex items-center gap-0.5">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            Unduh
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

            <!-- Right Column: SYSTEM INFORMATION (Operations, Approval History & Audit Logs) -->
            <div class="no-print space-y-6">
                
                <!-- System Verification Info Card -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden p-6 space-y-4">
                    <div class="flex items-center space-x-2">
                        <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Keaslian & Status Sistem</h3>
                    </div>
                    
                    <p class="text-xs text-gray-600 leading-relaxed">QR Code resmi tercetak pada area tanda tangan di dalam dokumen digital. Siapa pun dapat menguji dan memverifikasi keaslian dokumen secara online.</p>
                    
                    <div>
                        <a href="{{ route('form-bastik.verify', $bastik->qr_token) }}" target="_blank" class="inline-flex items-center text-xs text-gray-900 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-lg px-3 py-2 font-bold transition shadow-sm">
                            Uji Link Verifikasi Publik
                            <svg class="ml-1.5 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Approval History Timeline -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="bg-gray-900 text-white px-6 py-4 flex items-center justify-between">
                        <h3 class="text-sm font-bold tracking-wider uppercase">Histori Approval</h3>
                        <span class="text-[10px] text-gray-400">Audit Trail</span>
                    </div>
                    <div class="p-6">
                        @if($bastik->approvalHistories->count() > 0)
                            <div class="flow-root">
                                <ul class="-mb-8">
                                    @foreach($bastik->approvalHistories as $index => $history)
                                        <li>
                                            <div class="relative pb-8">
                                                @if($index !== $bastik->approvalHistories->count() - 1)
                                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                                @endif
                                                <div class="relative flex space-x-3">
                                                    <div>
                                                        @if($history->action === 'SUBMIT')
                                                            <span class="h-8 w-8 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center ring-8 ring-white font-bold text-xs">
                                                                SUB
                                                            </span>
                                                        @elseif($history->action === 'APPROVE')
                                                            <span class="h-8 w-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center ring-8 ring-white font-bold text-xs">
                                                                ACC
                                                            </span>
                                                        @elseif($history->action === 'REJECT')
                                                            <span class="h-8 w-8 rounded-full bg-rose-100 text-rose-700 flex items-center justify-center ring-8 ring-white font-bold text-xs">
                                                                REJ
                                                            </span>
                                                        @elseif($history->action === 'REVISE')
                                                            <span class="h-8 w-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center ring-8 ring-white font-bold text-xs">
                                                                REV
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow min-w-0 pt-1 flex justify-between space-x-4">
                                                        <div>
                                                            <div class="flex items-center space-x-2">
                                                                <span class="text-xs font-bold text-gray-900">{{ $history->action }}</span>
                                                                <span class="text-[10px] text-gray-400">({{ $history->from_status }} → {{ $history->to_status }})</span>
                                                            </div>
                                                            <p class="text-xs text-gray-600 mt-0.5">Oleh: <strong>{{ $history->user->name ?? 'User' }}</strong></p>
                                                            @if($history->note)
                                                                <p class="text-xs text-rose-600 bg-rose-50 p-2 rounded border border-rose-100 mt-1">"{{ $history->note }}"</p>
                                                            @endif
                                                        </div>
                                                        <div class="text-right text-[10px] whitespace-nowrap text-gray-400">
                                                            <time datetime="{{ $history->created_at }}">{{ $history->created_at->format('d-m-Y H:i') }}</time>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="text-center py-6 text-gray-400 text-xs">
                                Belum ada histori persetujuan tercatat.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Audit Log Scan QR -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="bg-gray-900 text-white px-6 py-4">
                        <h3 class="text-sm font-bold tracking-wider uppercase">Audit Log Scan QR</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-xs text-gray-500 mb-4">Mencatat riwayat aktivitas pemindaian QR Code pada dokumen ini.</p>
                        
                        @if($bastik->qrValidationLogs->count() > 0)
                            <div class="flow-root">
                                <ul class="-mb-8">
                                    @foreach($bastik->qrValidationLogs as $index => $log)
                                        <li>
                                            <div class="relative pb-8">
                                                @if($index !== $bastik->qrValidationLogs->count() - 1)
                                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                                @endif
                                                <div class="relative flex space-x-3">
                                                    <div>
                                                        <span class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center ring-8 ring-white text-gray-500">
                                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <div class="flex-grow min-w-0 pt-1.5 flex justify-between space-x-4">
                                                        <div>
                                                            <p class="text-xs text-gray-600 font-semibold">Scanned from IP: {{ $log->ip_address }}</p>
                                                            <p class="text-[10px] text-gray-400 mt-0.5 truncate max-w-[150px]">{{ $log->user_agent }}</p>
                                                        </div>
                                                        <div class="text-right text-[10px] whitespace-nowrap text-gray-500">
                                                            <time datetime="{{ $log->created_at }}">{{ $log->created_at->format('d-m H:i:s') }}</time>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="text-center py-6 text-gray-400 text-xs">
                                Belum ada pemindaian tercatat.
                            </div>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Rejection Modal -->
    <div x-show="rejectModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="rejectModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="rejectModalOpen = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="rejectModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                
                <form action="{{ route('form-bastik.reject', $bastik->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="bg-rose-600 px-6 py-4 text-white">
                        <h3 class="text-lg font-bold" id="modal-title">Penolakan Berita Acara</h3>
                        <p class="text-xs text-rose-100 mt-0.5">Berikan alasan penolakan untuk dikirimkan kembali ke Petugas Service Desk.</p>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <label for="rejection_note" class="block text-sm font-bold text-gray-700 mb-1">
                                Alasan Penolakan <span class="text-rose-500">*</span>
                            </label>
                            <textarea id="rejection_note" name="rejection_note" rows="4" required placeholder="Contoh: Nomor tiket dan rincian user pemohon belum sesuai dengan konfirmasi fisik." class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500"></textarea>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 border-t border-gray-200">
                        <button type="button" @click="rejectModalOpen = false" class="px-4 py-2 text-sm font-semibold rounded-lg border border-gray-300 text-gray-700 bg-white hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 text-sm font-semibold rounded-lg bg-rose-600 hover:bg-rose-700 text-white shadow">
                            Konfirmasi Penolakan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Attachment File Preview / Lightbox Modal -->
    <div x-show="previewModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-preview-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-6">
            <div x-show="previewModalOpen" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-gray-900 bg-opacity-80 backdrop-blur-sm transition-opacity" 
                 @click="previewModalOpen = false"></div>

            <div x-show="previewModalOpen" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" 
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" 
                 class="inline-block bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all max-w-4xl w-full z-10 relative">
                
                <div class="bg-gray-900 px-6 py-4 text-white flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold truncate max-w-lg" x-text="previewTitle" id="modal-preview-title"></h3>
                        <p class="text-[11px] text-gray-400">Pratinjau Bukti Konfirmasi Lampiran Dokumen</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a :href="previewUrl" target="_blank" class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-blue-600 hover:bg-blue-500 text-white flex items-center gap-1 shadow-sm transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            <span>Buka Tab Baru</span>
                        </a>
                        <button type="button" @click="previewModalOpen = false" class="p-1.5 rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>

                <div class="p-4 bg-gray-950 flex items-center justify-center min-h-[350px] max-h-[75vh] overflow-auto">
                    <template x-if="isImage">
                        <img :src="previewUrl" :alt="previewTitle" class="max-h-[70vh] max-w-full object-contain rounded shadow-lg">
                    </template>
                    <template x-if="!isImage">
                        <div class="w-full h-[65vh] flex flex-col items-center justify-center text-white bg-gray-900 rounded-lg p-2 space-y-4">
                            <iframe :src="previewUrl" class="w-full h-full rounded border border-gray-700 bg-white" title="Document Preview"></iframe>
                        </div>
                    </template>
                </div>

                <div class="bg-gray-50 px-6 py-3 flex justify-between items-center border-t border-gray-200 text-xs text-gray-500">
                    <span class="flex items-center gap-1.5 text-gray-600">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Klik "Buka Tab Baru" jika ingin mengunduh atau mencetak file secara langsung.
                    </span>
                    <button type="button" @click="previewModalOpen = false" class="px-4 py-2 text-xs font-semibold rounded-lg border border-gray-300 text-gray-700 bg-white hover:bg-gray-100 shadow-sm transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmBastikSubmit(event, submitUrl) {
    if (event) event.preventDefault();
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            html: `
                <div class="flex flex-col items-center pt-4">
                    <div class="relative flex items-center justify-center w-16 h-16 mb-6">
                        <div class="absolute inset-0 bg-amber-500 blur-xl opacity-30 rounded-full"></div>
                        <svg class="w-10 h-10 text-amber-500 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h2 class="text-[22px] font-bold text-gray-900 mb-2 text-center">Ajukan Persetujuan?</h2>
                    <p class="text-[15px] font-medium text-gray-600 text-center leading-relaxed">Dokumen akan diajukan ke Pimpinan untuk ditinjau dan ditandatangani.</p>
                </div>
            `,
            width: '380px',
            scrollbarPadding: false,
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ajukan Sekarang',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            buttonsStyling: false,
            customClass: {
                popup: 'custom-swal-popup p-6 shadow-2xl border-0',
                htmlContainer: 'm-0',
                confirmButton: 'rounded-2xl bg-amber-500 hover:bg-amber-600 text-white text-base font-semibold px-6 py-3.5 ml-3 transition-colors flex-1',
                cancelButton: 'rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-600 text-base font-semibold px-6 py-3.5 transition-colors flex-1',
                actions: 'mt-6 w-full flex justify-center gap-2 px-4 pb-2',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = submitUrl;
            }
        });
        return false;
    } else {
        if (confirm('Apakah Anda yakin ingin mengajukan Berita Acara ini ke Pimpinan untuk disetujui?')) {
            window.location.href = submitUrl;
        }
        return false;
    }
}

function confirmBastikApprove(event, approveUrl) {
    if (event) event.preventDefault();
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            html: `
                <div class="flex flex-col items-center pt-4">
                    <div class="relative flex items-center justify-center w-16 h-16 mb-6">
                        <div class="absolute inset-0 bg-emerald-500 blur-xl opacity-30 rounded-full"></div>
                        <svg class="w-10 h-10 text-emerald-600 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <h2 class="text-[22px] font-bold text-gray-900 mb-2 text-center">Setujui Dokumen?</h2>
                    <p class="text-[15px] font-medium text-gray-600 text-center leading-relaxed">Nomor surat resmi akan langsung diterbitkan dan naskah dinas dinyatakan sah.</p>
                </div>
            `,
            width: '380px',
            scrollbarPadding: false,
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: 'Setujui (Approve)',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            buttonsStyling: false,
            customClass: {
                popup: 'custom-swal-popup p-6 shadow-2xl border-0',
                htmlContainer: 'm-0',
                confirmButton: 'rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-base font-semibold px-6 py-3.5 ml-3 transition-colors flex-1',
                cancelButton: 'rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-600 text-base font-semibold px-6 py-3.5 transition-colors flex-1',
                actions: 'mt-6 w-full flex justify-center gap-2 px-4 pb-2',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = approveUrl;
            }
        });
        return false;
    } else {
        if (confirm('Apakah Anda yakin ingin menyetujui dokumen ini? Nomor surat resmi akan langsung diterbitkan.')) {
            window.location.href = approveUrl;
        }
        return false;
    }
}

function confirmBastikDelete(event, deleteUrl) {
    if (event) event.preventDefault();
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            html: `
                <div class="flex flex-col items-center pt-4">
                    <div class="relative flex items-center justify-center w-16 h-16 mb-6">
                        <div class="absolute inset-0 bg-[#f44336] blur-xl opacity-30 rounded-full"></div>
                        <svg class="w-10 h-10 text-[#f44336] relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </div>
                    <h2 class="text-[22px] font-bold text-gray-900 mb-2 text-center">Apakah Anda yakin?</h2>
                    <p class="text-[15px] font-medium text-gray-600 text-center leading-relaxed">Berita Acara ini akan dihapus secara permanen.</p>
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
                window.location.href = deleteUrl;
            }
        });
        return false;
    } else {
        if (confirm('Apakah Anda yakin ingin menghapus Berita Acara ini secara permanen?')) {
            window.location.href = deleteUrl;
        }
        return false;
    }
}

function confirmBastikVoid(event, voidUrl) {
    if (event) event.preventDefault();
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            html: `
                <div class="flex flex-col items-center pt-4">
                    <div class="relative flex items-center justify-center w-16 h-16 mb-6">
                        <div class="absolute inset-0 bg-[#f44336] blur-xl opacity-30 rounded-full"></div>
                        <svg class="w-10 h-10 text-[#f44336] relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <h2 class="text-[22px] font-bold text-gray-900 mb-2 text-center">Batalkan (Void) Surat?</h2>
                    <p class="text-[15px] font-medium text-gray-600 text-center leading-relaxed">Membatalkan dokumen akan membuat status surat ini tidak berlaku secara permanen.</p>
                </div>
            `,
            width: '380px',
            scrollbarPadding: false,
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya, Batalkan Surat',
            cancelButtonText: 'Kembali',
            reverseButtons: true,
            buttonsStyling: false,
            customClass: {
                popup: 'custom-swal-popup p-6 shadow-2xl border-0',
                htmlContainer: 'm-0',
                confirmButton: 'rounded-2xl bg-[#f44336] hover:bg-[#d32f2f] text-white text-base font-semibold px-6 py-3.5 ml-3 transition-colors flex-1',
                cancelButton: 'rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-600 text-base font-semibold px-6 py-3.5 transition-colors flex-1',
                actions: 'mt-6 w-full flex justify-center gap-2 px-4 pb-2',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = voidUrl;
            }
        });
        return false;
    } else {
        if (confirm('PERINGATAN: Membatalkan dokumen (void) akan membuat status surat ini tidak berlaku secara permanen. Lanjutkan?')) {
            window.location.href = voidUrl;
        }
        return false;
    }
}
</script>
@endsection
