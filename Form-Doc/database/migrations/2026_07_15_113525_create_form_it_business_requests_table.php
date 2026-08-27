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
        Schema::create('form_it_business_requests', function (Blueprint $table) {
            $table->id();
            $table->string('no_ref')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('klasifikasi_permintaan')->nullable(); // High, Medium, Low
            $table->string('catatan_persetujuan')->nullable(); // Disetujui, Ditolak, Disetujui dengan Kondisi
            $table->text('catatan_kondisi')->nullable(); // Jelaskan jika disetujui dengan kondisi
            $table->string('distribusi_salinan')->nullable();
            
            $table->text('deskripsi_umum')->nullable();
            $table->text('latar_belakang')->nullable();
            $table->text('tujuan')->nullable();
            $table->text('target_waktu')->nullable();
            $table->text('pihak_terkait_internal')->nullable();
            
            $table->json('kategori_layanan')->nullable(); // Checklist services
            $table->text('layanan_yang_dibutuhkan')->nullable(); // Description
            
            // Signatures tracking (we can use JSON or separate columns, let's use separate columns for simplicity)
            $table->string('pemohon_nama')->nullable();
            $table->string('pemohon_nipp')->nullable();
            $table->string('pemohon_jabatan')->nullable();
            
            $table->string('penerima_nama')->nullable();
            $table->string('penerima_nipp')->nullable();
            $table->string('penerima_jabatan')->nullable();
            
            $table->string('pimpinan_nama')->nullable();
            $table->string('pimpinan_nipp')->nullable();
            $table->string('pimpinan_jabatan')->nullable();

            $table->string('vp_nama')->nullable();
            $table->string('vp_nipp')->nullable();
            $table->string('vp_jabatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_it_business_requests');
    }
};
