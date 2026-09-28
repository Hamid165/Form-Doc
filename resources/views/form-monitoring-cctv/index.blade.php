@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    
    <!-- Tombol Kembali -->
    <div class="mb-4">
        <a href="{{ route('dashboard') }}" class="flex items-center text-sm text-gray-500 hover:text-gray-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Katalog
        </a>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center text-orange-500 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-800 uppercase">FORMULIR MONITORING CCTV</h1>
                <p class="text-sm text-gray-500">Daftar semua formulir pemantauan CCTV</p>
            </div>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">
            <form action="{{ route('form-monitoring-cctv.index') }}" method="GET" class="flex gap-2 w-full md:w-auto">
                <input type="hidden" name="tab" value="{{ $activeTab }}">
                <div class="relative w-full md:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari data..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <select name="sort" onchange="this.form.submit()" class="px-4 py-2 border border-gray-200 rounded-lg text-sm bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 min-w-[140px] appearance-none" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%236B7280%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 12px top 50%; background-size: 10px auto;">
                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Urut: Terbaru</option>
                    <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Urut: Terlama</option>
                </select>
                
                <!-- Tombol Submit Tersembunyi (untuk dipicu Enter pada text input) -->
                <button type="submit" class="hidden"></button>
            </form>
            
            @if($activeTab == 'formulir')
            <a href="{{ route('form-monitoring-cctv.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg flex items-center gap-2 transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Buat Formulir
            </a>
            @endif
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="flex gap-2 mb-6 border-b border-gray-200 overflow-x-auto">
        <a href="{{ route('form-monitoring-cctv.index', ['tab' => 'formulir']) }}" 
           class="px-4 py-2 text-sm font-semibold whitespace-nowrap {{ $activeTab == 'formulir' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
            Daftar Formulir
        </a>
        <a href="{{ route('form-monitoring-cctv.index', ['tab' => 'cctv']) }}" 
           class="px-4 py-2 text-sm font-semibold whitespace-nowrap {{ $activeTab == 'cctv' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
            Daftar CCTV
        </a>
        <a href="{{ route('form-monitoring-cctv.index', ['tab' => 'petugas']) }}" 
           class="px-4 py-2 text-sm font-semibold whitespace-nowrap {{ $activeTab == 'petugas' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
            Daftar Petugas
        </a>
        <a href="{{ route('form-monitoring-cctv.index', ['tab' => 'penandatangan']) }}" 
           class="px-4 py-2 text-sm font-semibold whitespace-nowrap {{ $activeTab == 'penandatangan' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
            Daftar Penanda Tangan
        </a>
    </div>

    <!-- Area Konten Tab Dinamis -->
    <div>
        @if($activeTab == 'formulir')
            @include('form-monitoring-cctv.tabs.formulir')
        @elseif($activeTab == 'cctv')
            @include('form-monitoring-cctv.tabs.cctv')
        @elseif($activeTab == 'petugas')
            @include('form-monitoring-cctv.tabs.petugas')
        @elseif($activeTab == 'penandatangan')
            @include('form-monitoring-cctv.tabs.penandatangan')
        @endif
    </div>
</div>

<style>
    div.swal2-popup.custom-swal-popup {
        border-radius: 36px !important;
    }
</style>
<script>
function confirmPrint(url) {
    Swal.fire({
        html: `
            <div class="flex flex-col items-center pt-4">
                <div class="relative flex items-center justify-center w-16 h-16 mb-6">
                    <div class="absolute inset-0 bg-[#3b82f6] blur-xl opacity-30 rounded-full"></div>
                    <svg class="w-10 h-10 text-[#3b82f6] relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                </div>
                <h2 class="text-[22px] font-bold text-gray-900 mb-2 text-center">Konfirmasi Cetak</h2>
                <p class="text-[15px] font-medium text-gray-600 text-center leading-relaxed">Apakah Anda yakin ingin mencetak formulir ini dan menandainya sebagai 'Selesai'?</p>
            </div>
        `,
        width: '360px',
        scrollbarPadding: false,
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya, Cetak',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        buttonsStyling: false,
        customClass: {
            popup: 'custom-swal-popup p-6 shadow-2xl border-0',
            htmlContainer: 'm-0',
            confirmButton: 'rounded-2xl bg-[#3b82f6] hover:bg-[#2563eb] text-white text-base font-semibold px-8 py-3.5 ml-3 transition-colors flex-1',
            cancelButton: 'rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-600 text-base font-semibold px-8 py-3.5 transition-colors flex-1',
            actions: 'mt-6 w-full flex justify-center gap-2 px-4 pb-2',
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Buka tab baru untuk print PDF
            window.open(url, '_blank');
            // Refresh halaman saat ini agar status berubah menjadi Selesai di tampilan
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }
    });
}

function confirmDelete(button, message) {
    Swal.fire({
        html: `
            <div class="flex flex-col items-center pt-4">
                <div class="relative flex items-center justify-center w-16 h-16 mb-6">
                    <div class="absolute inset-0 bg-[#f44336] blur-xl opacity-30 rounded-full"></div>
                    <svg class="w-10 h-10 text-[#f44336] relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </div>
                <h2 class="text-[22px] font-bold text-gray-900 mb-2 text-center">Apakah Anda yakin?</h2>
                <p class="text-[15px] font-medium text-gray-600 text-center leading-relaxed">${message || 'Data ini akan dihapus untuk semua orang'}</p>
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
            button.closest('form').submit();
        }
    });
}

function editCctv(id, nama, lokasi) {
    Swal.fire({
        html: `
            <div class="flex flex-col items-center pt-2">
                <div class="relative flex items-center justify-center w-16 h-16 mb-4">
                    <div class="absolute inset-0 bg-[#eab308] blur-xl opacity-30 rounded-full"></div>
                    <svg class="w-10 h-10 text-[#eab308] relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <h2 class="text-[22px] font-bold text-gray-900 mb-6 text-center">Edit Titik CCTV</h2>
                
                <form id="editCctvForm" action="/form-monitoring-cctv/cctv/${id}" method="POST" class="text-left w-full px-2">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Titik CCTV <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_titik" id="swal-nama" value="${nama}" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#eab308] focus:border-transparent outline-none transition-all" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Lokasi</label>
                        <input type="text" name="lokasi" id="swal-lokasi" value="${lokasi}" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#eab308] focus:border-transparent outline-none transition-all">
                    </div>
                </form>
            </div>
        `,
        width: '400px',
        scrollbarPadding: false,
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        buttonsStyling: false,
        customClass: {
            popup: 'custom-swal-popup p-6 shadow-2xl border-0',
            htmlContainer: 'm-0',
            confirmButton: 'rounded-2xl bg-[#eab308] hover:bg-[#ca8a04] text-white text-base font-semibold px-8 py-3.5 ml-3 transition-colors flex-1',
            cancelButton: 'rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-600 text-base font-semibold px-8 py-3.5 transition-colors flex-1',
            actions: 'mt-6 w-full flex justify-center gap-2 px-4 pb-2',
        },
        preConfirm: () => {
            const nama = document.getElementById('swal-nama').value;
            if (!nama) {
                Swal.showValidationMessage('Nama Titik CCTV harus diisi!');
                return false;
            }
            document.getElementById('editCctvForm').submit();
        }
    });
}

function editPetugas(id, nama, nipp) {
    Swal.fire({
        html: `
            <div class="flex flex-col items-center pt-2">
                <div class="relative flex items-center justify-center w-16 h-16 mb-4">
                    <div class="absolute inset-0 bg-[#eab308] blur-xl opacity-30 rounded-full"></div>
                    <svg class="w-10 h-10 text-[#eab308] relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <h2 class="text-[22px] font-bold text-gray-900 mb-6 text-center">Edit Data Petugas</h2>
                
                <form id="editPetugasForm" action="/form-monitoring-cctv/petugas/${id}" method="POST" class="text-left w-full px-2">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" id="swal-petugas-nama" value="${nama}" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#eab308] outline-none transition-all" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">NIPP <span class="text-red-500">*</span></label>
                        <input type="text" name="nipp" id="swal-petugas-nipp" value="${nipp}" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#eab308] outline-none transition-all" required>
                    </div>
                </form>
            </div>
        `,
        width: '400px',
        scrollbarPadding: false,
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        buttonsStyling: false,
        customClass: {
            popup: 'custom-swal-popup p-6 shadow-2xl border-0',
            htmlContainer: 'm-0',
            confirmButton: 'rounded-2xl bg-[#eab308] hover:bg-[#ca8a04] text-white text-base font-semibold px-8 py-3.5 ml-3 transition-colors flex-1',
            cancelButton: 'rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-600 text-base font-semibold px-8 py-3.5 transition-colors flex-1',
            actions: 'mt-6 w-full flex justify-center gap-2 px-4 pb-2',
        },
        preConfirm: () => {
            const nama = document.getElementById('swal-petugas-nama').value;
            const nipp = document.getElementById('swal-petugas-nipp').value;
            if (!nama || !nipp) {
                Swal.showValidationMessage('Nama dan NIPP harus diisi!');
                return false;
            }
            document.getElementById('editPetugasForm').submit();
        }
    });
}

function editSigner(id, nama, nipp, jabatan) {
    Swal.fire({
        html: `
            <div class="flex flex-col items-center pt-2">
                <div class="relative flex items-center justify-center w-16 h-16 mb-4">
                    <div class="absolute inset-0 bg-[#eab308] blur-xl opacity-30 rounded-full"></div>
                    <svg class="w-10 h-10 text-[#eab308] relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <h2 class="text-[22px] font-bold text-gray-900 mb-6 text-center">Edit Penanda Tangan</h2>
                
                <form id="editSignerForm" action="/form-monitoring-cctv/signer/${id}" method="POST" class="text-left w-full px-2">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" id="swal-signer-nama" value="${nama}" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#eab308] outline-none transition-all" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">NIPP <span class="text-red-500">*</span></label>
                        <input type="text" name="nipp" id="swal-signer-nipp" value="${nipp}" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#eab308] outline-none transition-all" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jabatan</label>
                        <input type="text" name="jabatan" value="${jabatan}" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#eab308] outline-none transition-all">
                    </div>
                </form>
            </div>
        `,
        width: '400px',
        scrollbarPadding: false,
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        buttonsStyling: false,
        customClass: {
            popup: 'custom-swal-popup p-6 shadow-2xl border-0',
            htmlContainer: 'm-0',
            confirmButton: 'rounded-2xl bg-[#eab308] hover:bg-[#ca8a04] text-white text-base font-semibold px-8 py-3.5 ml-3 transition-colors flex-1',
            cancelButton: 'rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-600 text-base font-semibold px-8 py-3.5 transition-colors flex-1',
            actions: 'mt-6 w-full flex justify-center gap-2 px-4 pb-2',
        },
        preConfirm: () => {
            const nama = document.getElementById('swal-signer-nama').value;
            const nipp = document.getElementById('swal-signer-nipp').value;
            if (!nama || !nipp) {
                Swal.showValidationMessage('Nama dan NIPP harus diisi!');
                return false;
            }
            document.getElementById('editSignerForm').submit();
        }
    });
}
</script>
@endsection