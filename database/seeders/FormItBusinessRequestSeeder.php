<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormItBusinessRequest\FormItBusinessRequest;

class FormItBusinessRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $requests = [
            [
                'no_ref' => 'ITBR/2026/0001',
                'tanggal' => '10-07-2026',
                'jabatan' => 'Manager Marketing',
                'klasifikasi_permintaan' => 'Medium',
                'catatan_persetujuan' => 'Disetujui',
                'catatan_kondisi' => null,
                'distribusi_salinan' => 'IT Support, Marketing Unit',
                'deskripsi_umum' => 'Pengembangan modul promo code dan voucher diskon pada aplikasi KAI Access untuk menyambut anniversary KAI.',
                'latar_belakang' => 'Meningkatkan loyalitas pelanggan dan penjualan tiket kereta api komersial melalui promo tematik.',
                'tujuan' => 'Menarik minat pengguna baru dan meningkatkan volume transaksi KAI Access sebesar 15%.',
                'target_waktu' => '31 Agustus 2026',
                'pihak_terkait_internal' => 'Tim Aplikasi KAI Access, Tim Marketing, Tim Keuangan',
                'kategori_layanan' => ['Layanan Pembangunan dan Pengembangan Sistem/Aplikasi', 'Layanan Integrasi Data'],
                'layanan_yang_dibutuhkan' => "1. Pembuatan REST API untuk voucher code.\n2. Integrasi ke payment gateway untuk perhitungan diskon.\n3. Dashboard monitoring penggunaan voucher.",
                'pemohon_nama' => 'Ahmad Fauzi',
                'pemohon_nipp' => '45678',
                'pemohon_jabatan' => 'Manager Marketing',
                'penerima_nama' => 'Budi Hartono',
                'penerima_nipp' => '12345',
                'penerima_jabatan' => 'Manager IT Development',
                'pimpinan_nama' => 'Hendrawan',
                'pimpinan_nipp' => '98765',
                'pimpinan_jabatan' => 'Senior Manager System Information',
                'vp_nama' => 'Dharmawan',
                'vp_nipp' => '11223',
                'vp_jabatan' => 'VP Information Technology',
            ],
            [
                'no_ref' => 'ITBR/2026/0002',
                'tanggal' => '12-07-2026',
                'jabatan' => 'Assistant Manager Logistik',
                'klasifikasi_permintaan' => 'High',
                'catatan_persetujuan' => 'Disetujui dengan Kondisi',
                'catatan_kondisi' => 'Harus diselesaikan sebelum migrasi server utama pada awal September.',
                'distribusi_salinan' => 'IT Infrastructure, Unit Logistik',
                'deskripsi_umum' => 'Integrasi sistem inventaris gudang dengan SAP KAI untuk tracking suku cadang lokomotif secara real-time.',
                'latar_belakang' => 'Sering terjadi keterlambatan pencatatan suku cadang masuk dan keluar yang menghambat maintenance lokomotif.',
                'tujuan' => 'Mempercepat tracking suku cadang dan meminimalisir kesalahan manual data entri.',
                'target_waktu' => '25 Agustus 2026',
                'pihak_terkait_internal' => 'Tim SAP Basis, Tim Logistik & Sarana, Tim Database Administrator',
                'kategori_layanan' => ['Layanan Integrasi Data', 'Layanan Lisensi Perangkat Lunak'],
                'layanan_yang_dibutuhkan' => "1. Sinkronisasi database lokal inventaris dengan tabel SAP.\n2. Lisensi modul SAP logistik tambahan.\n3. Uji kelayakan transfer data.",
                'pemohon_nama' => 'Siti Rahmawati',
                'pemohon_nipp' => '67890',
                'pemohon_jabatan' => 'Assistant Manager Logistik',
                'penerima_nama' => 'Budi Hartono',
                'penerima_nipp' => '12345',
                'penerima_jabatan' => 'Manager IT Development',
                'pimpinan_nama' => 'Hendrawan',
                'pimpinan_nipp' => '98765',
                'pimpinan_jabatan' => 'Senior Manager System Information',
                'vp_nama' => 'Dharmawan',
                'vp_nipp' => '11223',
                'vp_jabatan' => 'VP Information Technology',
            ],
            [
                'no_ref' => 'ITBR/2026/0003',
                'tanggal' => '15-07-2026',
                'jabatan' => 'Supervisor Keamanan Stasiun',
                'klasifikasi_permintaan' => 'Low',
                'catatan_persetujuan' => 'Disetujui',
                'catatan_kondisi' => null,
                'distribusi_salinan' => 'IT Security, Unit Pengamanan Stasiun',
                'deskripsi_umum' => 'Penambahan kapasitas bandwidth internet dan pemasangan Access Point tambahan di ruang tunggu VIP Stasiun Gambir.',
                'latar_belakang' => 'Banyak keluhan dari penumpang VIP mengenai koneksi internet yang lambat dan sering terputus.',
                'tujuan' => 'Meningkatkan kenyamanan penumpang VIP di Stasiun Gambir.',
                'target_waktu' => '10 Agustus 2026',
                'pihak_terkait_internal' => 'Tim Network & Infrastructure, Unit Stasiun Gambir',
                'kategori_layanan' => ['Layanan Pengembangan Jaringan', 'Layanan Perangkat Kerja'],
                'layanan_yang_dibutuhkan' => "1. Penarikan kabel FO baru.\n2. Instalasi 2 unit Access Point Ruijie.\n3. Konfigurasi pembatasan bandwidth per pengguna.",
                'pemohon_nama' => 'Roni Wijaya',
                'pemohon_nipp' => '89012',
                'pemohon_jabatan' => 'Supervisor Keamanan Stasiun',
                'penerima_nama' => 'Taufik Hidayat',
                'penerima_nipp' => '12346',
                'penerima_jabatan' => 'Manager IT Infrastructure',
                'pimpinan_nama' => 'Hendrawan',
                'pimpinan_nipp' => '98765',
                'pimpinan_jabatan' => 'Senior Manager System Information',
                'vp_nama' => 'Dharmawan',
                'vp_nipp' => '11223',
                'vp_jabatan' => 'VP Information Technology',
            ],
        ];

        foreach ($requests as $data) {
            FormItBusinessRequest::firstOrCreate(['no_ref' => $data['no_ref']], $data);
        }
    }
}
