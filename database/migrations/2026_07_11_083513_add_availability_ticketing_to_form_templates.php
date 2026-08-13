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
        DB::table('form_templates')->insert([
            [
                'nama' => 'Availability System Ticketing',
                'kategori' => 'Umum',
                'route_name' => 'form-availability.index',
                'no_dokumen' => 'FR.SM/TI/015.016/07-2026',
                'tanggal_dokumen' => '11 Juli 2026',
                'versi_dokumen' => '001-2026',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('form_templates')
            ->where('nama', 'Availability System Ticketing')
            ->delete();
    }
};
