<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Tanda Tangan Elektronik - PT Kereta Api Indonesia (Persero)</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-100 min-h-screen py-8 px-4">

    <div class="max-w-lg mx-auto space-y-4">

        {{-- Header KAI --}}
        <div class="text-center py-4">
            <img src="{{ asset('images/logo-kai.svg') }}" alt="KAI Logo" class="h-10 w-auto mx-auto mb-2">
            <p class="text-sm font-bold text-gray-800">PT Kereta Api Indonesia (Persero)</p>
            <p class="text-xs text-gray-500">Kantor Pusat</p>
        </div>

        {{-- Kartu Utama --}}
        <div class="bg-white rounded-2xl shadow border border-gray-200 overflow-hidden">

            {{-- Judul --}}
            <div class="px-6 py-5 border-b border-gray-200">
                <h1 class="text-base font-bold text-gray-900">Verifikasi Tanda Tangan Elektronik</h1>
            </div>

            {{-- Tabel Info Dokumen --}}
            <div class="divide-y divide-gray-100">
                <div class="flex px-6 py-3.5">
                    <span class="w-40 text-sm text-gray-500 flex-shrink-0">Nomor Dokumen</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $bastik->nomor_surat ?? 'Belum diterbitkan' }}</span>
                </div>
                <div class="flex px-6 py-3.5">
                    <span class="w-40 text-sm text-gray-500 flex-shrink-0">Tanggal Dokumen</span>
                    <span class="text-sm text-gray-800">
                        @if($bastik->tanggal_surat)
                            {{ \Carbon\Carbon::parse($bastik->tanggal_surat)->locale('id')->isoFormat('D MMMM YYYY') }}
                        @else
                            -
                        @endif
                    </span>
                </div>
                <div class="flex px-6 py-3.5">
                    <span class="w-40 text-sm text-gray-500 flex-shrink-0">Perihal</span>
                    <span class="text-sm text-gray-800">Berita Acara Penutupan Tiket Incident/Work Order — {{ $bastik->business_area ?? '-' }}</span>
                </div>
                <div class="flex px-6 py-3.5">
                    <span class="w-40 text-sm text-gray-500 flex-shrink-0">Pengirim</span>
                    <div class="text-sm text-gray-800">
                        <span class="font-medium">{{ $bastik->petugas->name ?? '-' }}</span>
                        @if($bastik->petugas->nip_kwt)
                            <span class="text-gray-500 text-xs block">NIPKWT: {{ $bastik->petugas->nip_kwt }}</span>
                        @endif
                    </div>
                </div>
                <div class="flex px-6 py-3.5">
                    <span class="w-40 text-sm text-gray-500 flex-shrink-0">Penerima</span>
                    <div class="text-sm text-gray-800">
                        @if($bastik->pimpinan->nama)
                            <span class="font-medium">{{ strtoupper($bastik->pimpinan->nama) }}</span>
                        @endif
                        @if($bastik->pimpinan->jabatan)
                            <span class="text-gray-500 text-xs block">{{ $bastik->pimpinan->jabatan }}</span>
                        @endif
                        @if($bastik->pimpinan->nipp)
                            <span class="text-gray-400 text-xs block">NIPP: {{ $bastik->pimpinan->nipp }}</span>
                        @endif
                    </div>
                </div>
                <div class="flex px-6 py-3.5 items-center">
                    <span class="w-40 text-sm text-gray-500 flex-shrink-0">Status</span>
                    @if(in_array($bastik->status, ['signed', 'final']))
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 inline-block"></span>DOKUMEN VALID (Sah &amp; Terverifikasi)
                        </span>
                    @elseif($bastik->status === 'submitted')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-200">Menunggu Persetujuan</span>
                    @elseif($bastik->status === 'rejected')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800 border border-rose-200">Ditolak</span>
                    @elseif($bastik->status === 'void')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800 border border-rose-200">Void / Batal</span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">Draft</span>
                    @endif
                </div>
            </div>

            {{-- Box Tanda Tangan Elektronik --}}
            @if(in_array($bastik->status, ['signed', 'final']))
                <div class="px-6 pb-6 pt-4 space-y-3">

                    {{-- Box 1: Identitas Penandatangan --}}
                    <div class="border border-gray-300 rounded-lg p-4 flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <img src="{{ asset('images/logo-kai.svg') }}" alt="KAI" class="h-8 w-auto">
                        </div>
                        <div class="text-sm leading-snug">
                            <p class="text-gray-500 text-xs mb-1">Ditandatangani secara elektronik oleh: <strong class="text-gray-900">{{ strtoupper($bastik->pimpinan->nama ?? '-') }}</strong></p>
                            <p class="text-gray-700">{{ $bastik->pimpinan->jabatan ?? 'Pimpinan Unit TI' }}</p>
                            <p class="font-bold text-gray-900 text-xs mt-0.5">PT. KERETA API INDONESIA</p>
                        </div>
                    </div>

                    {{-- Box 2: Pernyataan Waktu --}}
                    <div class="border border-gray-300 rounded-lg p-4 text-sm text-gray-700 leading-relaxed">
                        @php $approvedAt = $bastik->approved_at ?? $bastik->updated_at; @endphp
                        <p>Dokumen telah ditandatangani secara elektronik menggunakan aplikasi <strong class="text-gray-900">SI-BASTIK</strong> oleh: <strong class="text-gray-900">{{ strtoupper($bastik->pimpinan->nama ?? '-') }}</strong></p>
                        <p class="text-gray-600 mt-0.5">{{ $bastik->pimpinan->jabatan ?? 'Pimpinan Unit TI' }}</p>
                        @if($approvedAt)
                            <p class="font-bold text-gray-900 mt-1">pada {{ \Carbon\Carbon::parse($approvedAt)->locale('id')->isoFormat('D MMMM YYYY') }}</p>
                        @endif
                        <p class="text-xs text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-lg p-2.5 mt-3 font-medium">Dokumen ini terdaftar dan telah diverifikasi melalui SI-BASTIK.</p>
                    </div>

                </div>
            @elseif($bastik->status === 'void')
                <div class="px-6 pb-6 pt-4">
                    <div class="bg-rose-50 border border-rose-300 rounded-lg p-4 text-sm text-rose-800">
                        <p class="font-bold">⚠ Dokumen Tidak Berlaku (VOID)</p>
                        <p class="mt-1 text-xs">Berita Acara ini telah dibatalkan. Dokumen cetak atau salinan digital yang beredar dinyatakan <strong>tidak berlaku</strong>.</p>
                    </div>
                </div>
            @else
                <div class="px-6 pb-6 pt-4">
                    <div class="bg-amber-50 border border-amber-300 rounded-lg p-4 text-sm text-amber-800">
                        <p class="font-bold">⏳ Dokumen Belum Disetujui</p>
                        <p class="mt-1 text-xs">Berstatus <strong>{{ strtoupper($bastik->status) }}</strong> dan belum ditandatangani secara resmi.</p>
                    </div>
                </div>
            @endif

        </div>{{-- /kartu utama --}}

        {{-- Footer --}}
        <div class="text-center py-4 text-xs text-gray-400 space-y-0.5">
            <p>© {{ date('Y') }} PT Kereta Api Indonesia (Persero)</p>
            <p>SI-BASTIK — Sistem Informasi Berita Acara &amp; Penutupan Tiket</p>
        </div>

    </div>

</body>
</html>
