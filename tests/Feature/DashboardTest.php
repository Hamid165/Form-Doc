<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\FormTemplate;
use App\Models\FormBastik\FormBastik;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_renders_with_dynamic_data_and_authenticated_user(): void
    {
        $user = User::factory()->create([
            'name' => 'Petugas Test',
            'email' => 'petugas@example.com',
            'role' => 'petugas',
        ]);

        FormTemplate::create([
            'nama' => 'Pemeliharaan CCTV',
            'kategori' => 'Umum',
            'route_name' => 'form-cctv.index',
            'no_dokumen' => 'FR.SM/TI/015.013/10-2020',
            'tanggal_dokumen' => '12 Oktober 2020',
            'versi_dokumen' => '002-2020',
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertViewHas([
            'totalKategori',
            'totalJenisFormulir',
            'totalFormulirBulanIni',
            'totalPengguna',
            'recentForms',
            'formStats',
            'pendingBastikCount',
        ]);
        $response->assertSee('Total Kategori');
        $response->assertSee('Jenis Formulir');
        $response->assertSee('Ringkasan Formulir');
    }
}
