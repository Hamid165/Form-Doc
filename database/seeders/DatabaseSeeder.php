<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        if (!User::where('email', 'rina@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Rina Amelia',
                'email' => 'rina@example.com',
                'role' => 'petugas',
                'nip_kwt' => 'K.998811',
                'unit_kerja' => 'TI Service Desk'
            ]);
        }

        if (!User::where('email', 'sutrisno@example.com')->exists()) {
            User::factory()->create([
                'name' => 'B. Sutrisno',
                'email' => 'sutrisno@example.com',
                'role' => 'pimpinan',
                'nip_kwt' => 'P.112233',
                'unit_kerja' => 'TI Operations'
            ]);
        }

        if (!\App\Models\FormCctv\MasterSigner::where('nama', 'B. Sutrisno')->exists()) {
            \App\Models\FormCctv\MasterSigner::create([
                'nama' => 'B. Sutrisno',
                'nipp' => 'P.112233',
                'jabatan' => 'Manager TI Operations',
            ]);
        }

        if (!User::where('email', 'admin@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Admin Sistem',
                'email' => 'admin@example.com',
                'role' => 'admin',
                'nip_kwt' => 'A.000001',
                'unit_kerja' => 'TI Administrator'
            ]);
        }

        if (!\App\Models\FormTemplate::where('nama', 'Berita Acara Penutupan Tiket Incident/Work Order')->exists()) {
            \App\Models\FormTemplate::create([
                'nama' => 'Berita Acara Penutupan Tiket Incident/Work Order',
                'kategori' => 'Terbatas',
                'route_name' => 'form-bastik.index',
                'no_dokumen' => 'FR.SM/TI/031.005/02-2023',
                'tanggal_dokumen' => '13 Februari 2023',
                'versi_dokumen' => '001-2023',
            ]);
        }

        if (!\App\Models\FormTemplate::where('nama', 'Pemeliharaan CCTV')->exists()) {
            \App\Models\FormTemplate::create([
                'nama' => 'Pemeliharaan CCTV',
                'kategori' => 'Umum',
                'route_name' => 'form-cctv.index',
                'no_dokumen' => 'FR.SM/TI/015.013/10-2020',
                'tanggal_dokumen' => '12 Oktober 2020',
                'versi_dokumen' => '002-2020',
            ]);
        }

        if (!\App\Models\FormTemplate::where('nama', 'Permohonan Pencabutan Hak Akses')->exists()) {
            \App\Models\FormTemplate::create([
                'nama' => 'Permohonan Pencabutan Hak Akses',
                'kategori' => 'Lainnya',
                'route_name' => 'form-pencabutan-hak-akses.index',
                'no_dokumen' => 'FR.SM/TI/013.004/10-2020',
                'tanggal_dokumen' => '12 Oktober 2020',
                'versi_dokumen' => '002-2020',
            ]);
        }

        if (!\App\Models\FormTemplate::where('nama', 'Checklist Pemeliharaan AC')->exists()) {
            \App\Models\FormTemplate::create([
                'nama' => 'Checklist Pemeliharaan AC',
                'kategori' => 'Terbatas',
                'route_name' => 'form-pemeliharaan-ac.index',
                'no_dokumen' => 'FR.SM/TI/015.011/10-2020',
                'tanggal_dokumen' => '12 Oktober 2020',
                'versi_dokumen' => '002-2020',
            ]);
        }

        if (!\App\Models\FormTemplate::where('nama', 'Checklist Pemeliharaan Perangkat Jaringan')->exists()) {
            \App\Models\FormTemplate::create([
                'nama' => 'Checklist Pemeliharaan Perangkat Jaringan',
                'kategori' => 'Terbatas',
                'route_name' => 'form-pemeliharaan.index',
                'no_dokumen' => 'FR.SM/TI/015.015/07-2026',
                'tanggal_dokumen' => '01 Juli 2026',
                'versi_dokumen' => '001-2026',
            ]);
        }

        if (!\App\Models\FormTemplate::where('nama', 'Formulir IT Business Request')->exists()) {
            \App\Models\FormTemplate::create([
                'nama' => 'Formulir IT Business Request',
                'kategori' => 'Lainnya',
                'route_name' => 'form-it-business-request.index',
                'no_dokumen' => 'FR.SM/TI/026.001/10-2020',
                'tanggal_dokumen' => '15 Oktober 2020',
                'versi_dokumen' => '001-2020',
            ]);
        }

        if (!\App\Models\FormTemplate::where('nama', 'Berita Acara Stock Opname')->exists()) {
            \App\Models\FormTemplate::create([
                'nama' => 'Berita Acara Stock Opname',
                'kategori' => 'Terbatas',
                'route_name' => 'form-ba-stock-opname.index',
                'no_dokumen' => 'FR.SM/TI/011.010/04-2026',
                'tanggal_dokumen' => '13 April 2026',
                'versi_dokumen' => '001-2026',
            ]);
        }
        
        if (!\App\Models\FormTemplate::where('nama', 'Monitoring CCTV')->exists()) {
            \App\Models\FormTemplate::create([
                'nama' => 'Monitoring CCTV',
                'kategori' => 'Terbatas',
                'route_name' => 'form-monitoring-cctv.index',
                'no_dokumen' => 'FR.SM/TI/015.014/10-2020',
                'tanggal_dokumen' => '12 Oktober 2020',
                'versi_dokumen' => '002-2020',
            ]);
        }

        if (!\App\Models\FormTemplate::where('nama', 'Formulir Checklist Pemantauan APAR')->exists()) {
            \App\Models\FormTemplate::create([
                'nama' => 'Formulir Checklist Pemantauan APAR',
                'kategori' => 'Terbatas',
                'route_name' => 'form-apar.index',
                'no_dokumen' => 'FR.SM/TI/015.007/10-2020',
                'tanggal_dokumen' => '12 Oktober 2020',
                'versi_dokumen' => '002-2020',
            ]);
        }

        if (!\App\Models\FormTemplate::where('nama', 'Log Peminjaman Informasi / Dokumen')->exists()) {
            \App\Models\FormTemplate::create([
                'nama' => 'Log Peminjaman Informasi / Dokumen',
                'kategori' => 'Terbatas',
                'route_name' => 'form-log-peminjaman.index',
                'no_dokumen' => 'FR.SM/TI/004.004/10-2020',
                'tanggal_dokumen' => '12 Oktober 2020',
                'versi_dokumen' => '002-2020',
            ]);
        }

        $this->call([
            MasterPerangkatSeeder::class,
            MasterSignerSeeder::class,
            FormItBusinessRequestSeeder::class,
            FormMonitoringIsiRakDcDrcSeeder::class,
        ]);
    }
}