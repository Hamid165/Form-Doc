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

        if (!\App\Models\FormTemplate::where('nama', 'Keluar Masuk Barang DC DRC')->exists()) {
            \App\Models\FormTemplate::create([
                'nama' => 'Keluar Masuk Barang DC DRC',
                'kategori' => 'Umum',
                'route_name' => 'form-keluar-masuk-barang-dc-drc.index',
                'no_dokumen' => 'FR.SM/TI/014.003/10-2020',
                'tanggal_dokumen' => '12 Oktober 2020',
                'versi_dokumen' => ': 002-2020',
            ]);
        }

        if (!\App\Models\FormTemplate::where('nama', 'Formulir Pengujian Infrastruktur')->exists()) {
            \App\Models\FormTemplate::create([
                'nama' => 'Formulir Pengujian Infrastruktur',
                'kategori' => 'Terbatas',
                'route_name' => 'form-pengujian-infrastruktur.index',
                'no_dokumen' => 'FR.SM/TI/025.002/10-2020',
                'tanggal_dokumen' => '12 Oktober 2020',
                'versi_dokumen' => '002-2020',
            ]);
        }

        if (!\App\Models\FormTemplate::where('nama', 'Berita Acara Serah Terima Barang')->exists()) {
            \App\Models\FormTemplate::create([
                'nama' => 'Berita Acara Serah Terima Barang',
                'kategori' => 'Terbatas',
                'route_name' => 'form-berita-acara-serah-terima-barang.index',
                'no_dokumen' => 'FR.SM/TI/011.002/10-2020',
                'tanggal_dokumen' => '12 Oktober 2020',
                'versi_dokumen' => '02-2020',
            ]);
        }

        if (!\App\Models\FormTemplate::where('nama', 'Rencana Pelatihan Pegawai')->exists()) {
            \App\Models\FormTemplate::create([
                'nama' => 'Rencana Pelatihan Pegawai',
                'kategori' => 'Terbatas',
                'route_name' => 'form-rencana-pelatihan.index',
                'no_dokumen' => 'DK.SM/TI/003.002/08-2022',
                'tanggal_dokumen' => '29 Agustus 2022',
                'versi_dokumen' => '002-2022',
            ]);
        }

        if (!\App\Models\FormTemplate::where('nama', 'Monitoring Grounding')->exists()) {
            \App\Models\FormTemplate::create([
                'nama' => 'Monitoring Grounding',
                'kategori' => 'Terbatas',
                'route_name' => 'form-monitoring-grounding.index',
                'no_dokumen' => 'FR.SM/TI/015.018/10-2020',
                'tanggal_dokumen' => '12 Oktober 2020',
                'versi_dokumen' => '002-2020',
            ]);
        }

        if (!\App\Models\FormTemplate::where('nama', 'Monitoring Grounding')->exists()) {
            \App\Models\FormTemplate::create([
                'nama' => 'Monitoring Grounding',
                'kategori' => 'Terbatas',
                'route_name' => 'form-monitoring-grounding.index',
                'no_dokumen' => 'FR.SM/TI/015.018/10-2020',
                'tanggal_dokumen' => '12 Oktober 2020',
                'versi_dokumen' => '002-2020',
            ]);
        }

        // Seeder untuk Form Secure Operation Incident
        if (!\App\Models\FormTemplate::where('nama', 'Secure Operation Incident')->exists()) {
            \App\Models\FormTemplate::create([
                'nama' => 'Secure Operation Incident',
                'kategori' => 'Terbatas',
                'route_name' => 'form-secure-operation.index',
                'no_dokumen' => 'FR.IK/TI/006.03/10-2020',
                'tanggal_dokumen' => '12 Oktober 2020',
                'versi_dokumen' => '002-2020',
            ]);
        }

        if (!\App\Models\FormTemplate::where('nama', 'Formulir Laporan Backup')->exists()) {
            \App\Models\FormTemplate::create([
                'nama' => 'Formulir Laporan Backup',
                'kategori' => 'Terbatas',
                'route_name' => 'form-backup.index',
                'no_dokumen' => 'DK.SM/TI/012.002/02-2023',
                'tanggal_dokumen' => '13 Februari 2023',
                'versi_dokumen' => '001-2023',
            ]);
        }

        $this->call([
            MasterPerangkatSeeder::class,
            MasterSignerSeeder::class,
            FormItBusinessRequestSeeder::class,
        ]);
    }
}