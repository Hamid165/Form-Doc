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
        Schema::create('rencana_pelatihans', function (Blueprint $table) {
            $table->id();

            $table->string('no_dokumen')->nullable();
            $table->string('tanggal_terbit')->nullable();
            $table->string('versi')->nullable();
            $table->string('pemilik_dokumen')->default('Unit Sistem Informasi (CI)');

            $table->json('penyusun')->nullable();

            // Data Disetujui
            $table->string('disetujui_nama')->nullable();
            $table->string('disetujui_nipp')->nullable();
            $table->string('disetujui_jabatan')->nullable(); // Kolom Jabatan Disetujui

            // Data Disahkan
            $table->string('disahkan_nama')->nullable();
            $table->string('disahkan_nipp')->nullable();
            $table->string('disahkan_jabatan')->nullable(); // Kolom Jabatan Disahkan

            $table->json('riwayat_perubahan')->nullable();
            $table->json('analisa_kebutuhan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rencana_pelatihans');
    }
};
