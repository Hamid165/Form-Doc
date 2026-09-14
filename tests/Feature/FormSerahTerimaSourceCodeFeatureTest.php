<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\FormSerahTerimaSourceCode\FormSerahTerimaSourceCode;
use Tests\TestCase;

class FormSerahTerimaSourceCodeFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_store_show_and_edit_form_flow_works(): void
    {
        $createResponse = $this->get(route('form-serah-terima-source-code.create'));
        $createResponse->assertOk();

        $payload = [
            'nomor_dokumen' => 'DOC-001',
            'tanggal_terbit' => '2026-07-01',
            'versi_dokumen' => 'v1.0',
            'halaman_dokumen' => '1',
            'hari_serah_terima' => 'Senin',
            'tanggal_serah_terima' => '2026-07-01',
            'pihak_pertama_nama' => 'PT KAI',
            'pihak_pertama_jabatan' => 'Manager',
            'pihak_kedua_nama' => 'CV Teknologi',
            'pihak_kedua_alamat' => 'Bandung',
            'pihak_kedua_diwakili_nama' => 'Budi',
            'pihak_kedua_diwakili_jabatan' => 'Direktur',
            'jenis_serah_terima' => 'app_dan_db',
            'nama_aplikasi' => 'Aplikasi Test',
            'versi_aplikasi' => '1.0.0',
            'deskripsi_aplikasi' => 'Deskripsi aplikasi test',
            'modul_aplikasi' => "Modul 1\nModul 2",
            'bahasa_pemrograman' => 'PHP',
            'database_yang_digunakan' => 'MySQL',
            'development_platform' => 'Laravel',
        ];

        $storeResponse = $this->post(route('form-serah-terima-source-code.store'), $payload);
        $storeResponse->assertRedirect(route('form-serah-terima-source-code.index'));

        $this->assertDatabaseHas('form_serah_terima_source_codes', [
            'nama_aplikasi' => 'Aplikasi Test',
            'pihak_kedua_nama' => 'CV Teknologi',
        ]);

        $form = FormSerahTerimaSourceCode::first();

        $showResponse = $this->get(route('form-serah-terima-source-code.show', $form));
        $showResponse->assertOk();
        $showResponse->assertSee('Aplikasi Test');

        $printResponse = $this->get(route('form-serah-terima-source-code.print', $form));
        $printResponse->assertOk();
        $printResponse->assertSee('BERITA ACARA SERAH TERIMA');

        $editResponse = $this->get(route('form-serah-terima-source-code.edit', $form));
        $editResponse->assertOk();
    }
}
