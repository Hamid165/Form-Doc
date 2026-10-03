<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Dokumen Gagal - PT Kereta Api Indonesia (Persero)</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- Vite CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800 font-sans min-h-screen py-8 px-4 sm:px-6 lg:px-8">

    <div class="max-w-3xl mx-auto space-y-6">
        
        <!-- Header Brand (KAI Logo & System Name) -->
        <div class="p-6 bg-white rounded-2xl shadow-sm border border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('images/logo-kai.svg') }}" alt="KAI Logo" class="h-10 w-auto">
                <div>
                    <h1 class="text-base font-bold text-gray-900">PT KERETA API INDONESIA (PERSERO)</h1>
                    <p class="text-xs text-gray-500">Portal Verifikasi Dokumen Elektronik Resmi (SI-BASTIK)</p>
                </div>
            </div>
            <div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-800 border border-rose-200">
                    Tidak Valid
                </span>
            </div>
        </div>

        <!-- Verification Status Header Card -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-gray-50 p-6 rounded-xl border border-gray-200">
            <div class="flex items-start space-x-4">
                <div class="p-3 bg-white rounded-lg shadow-sm border border-gray-200">
                    <svg class="h-8 w-8 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center space-x-2 flex-wrap gap-y-1">
                        <h2 class="text-xl font-bold text-gray-900">✕ DOKUMEN TIDAK DAPAT DIVERIFIKASI</h2>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Kode verifikasi yang Anda pindai tidak terdaftar atau tidak valid dalam database sistem SI-BASTIK KAI.</p>
                </div>
            </div>
        </div>

        <!-- Information Box -->
        <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl shadow-sm space-y-2">
            <h3 class="text-sm font-bold text-rose-900">Kemungkinan Penyebab:</h3>
            <ul class="list-disc pl-5 space-y-1 text-xs text-rose-800">
                <li>Kode QR yang dipindai tidak valid atau bukan berasal dari sistem resmi SI-BASTIK.</li>
                <li>Dokumen belum resmi disetujui (approved) oleh Pimpinan.</li>
                <li>Dokumen telah dibatalkan atau dihapus dari sistem.</li>
            </ul>
        </div>

        <!-- Footer (Matching show.blade.php footer style) -->
        <div class="text-center py-6 text-xs text-gray-400 border-t border-gray-200 space-y-1">
            <p>© 2026 PT Kereta Api Indonesia (Persero)</p>
            <p class="text-[11px] text-gray-400">SI-BASTIK — Sistem Informasi Berita Acara & Penutupan Tiket Otomatis</p>
        </div>

    </div>

</body>
</html>
