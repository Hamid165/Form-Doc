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
                'nama' => 'Pengelolaan dan Penanganan Keluhan Pelanggan',
                'kategori' => 'Terbatas',
                'route_name' => 'form-keluhan.index',
                'no_dokumen' => 'FR.SM/TI/033.001/10-2020',
                'tanggal_dokumen' => '12 Oktober 2020',
                'versi_dokumen' => '002-2020',
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
            ->where('nama', 'Pengelolaan dan Penanganan Keluhan Pelanggan')
            ->delete();
    }
};
