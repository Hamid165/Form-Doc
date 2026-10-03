<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ba_it_services', function (Blueprint $table) {
            $table->id();
            
            // 1. Header & Referensi Dokumen
            $table->string('no_dokumen')->default('FR.SM/IT/011.005/10-2020');
            $table->string('versi')->default('002-2020');
            $table->string('no_ref')->nullable();
            $table->date('tgl_ref')->nullable();
            $table->string('business_area')->nullable();

            // 2. Data Pemohon
            $table->string('pemohon_nama');
            $table->string('pemohon_unit');
            $table->string('pemohon_kontak');
            $table->dateTime('waktu_mulai')->nullable();
            $table->dateTime('waktu_selesai')->nullable();

            // 3. Inti Formulir (Hasil Penanganan)
            $table->string('no_inventaris_aset')->nullable();
            $table->json('detail_penanganan')->nullable(); // Di sinilah seluruh data V, X, dan Keterangan akan disimpan

            // 4. Data Tanda Tangan
            $table->string('pihak_terkait')->nullable();
            $table->string('ttd_staf_nipp')->nullable();
            $table->string('ttd_mengetahui_nipp')->nullable();
            $table->string('ttd_user_nipp')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ba_it_services');
    }
};
