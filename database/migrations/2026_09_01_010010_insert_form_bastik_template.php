<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!DB::table('form_templates')->where('nama', 'Berita Acara Penutupan Tiket Incident/Work Order')->exists()) {
            DB::table('form_templates')->insert([
                [
                    'nama' => 'Berita Acara Penutupan Tiket Incident/Work Order',
                    'kategori' => 'Terbatas',
                    'route_name' => 'form-bastik.index',
                    'no_dokumen' => 'FR.SM/TI/031.005/02-2023',
                    'tanggal_dokumen' => '13 Februari 2023',
                    'versi_dokumen' => '001-2023',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('form_templates')
            ->where('nama', 'Berita Acara Penutupan Tiket Incident/Work Order')
            ->delete();
    }
};
