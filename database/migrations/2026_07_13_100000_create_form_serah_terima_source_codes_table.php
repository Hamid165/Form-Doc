<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('form_serah_terima_source_codes')) {
            return;
        }

        Schema::create('form_serah_terima_source_codes', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_dokumen')->nullable();
            $table->date('tanggal_terbit')->nullable();
            $table->string('versi_dokumen')->nullable();
            $table->string('halaman_dokumen')->nullable();
            $table->string('no_ref')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('business_area')->nullable();
            $table->string('hari')->nullable();
            $table->string('bulan')->nullable();
            $table->string('tahun')->nullable();
            $table->string('pihak_pertama_nama')->nullable();
            $table->string('pihak_pertama_diwakili')->nullable();
            $table->string('pihak_pertama_jabatan')->nullable();
            $table->string('pihak_kedua_nama')->nullable();
            $table->string('pihak_kedua_alamat')->nullable();
            $table->string('pihak_kedua_diwakili')->nullable();
            $table->string('pihak_kedua_jabatan')->nullable();
            $table->string('jenis_serah_terima')->nullable();
            $table->string('jenis_serah_terima_lainnya')->nullable();
            $table->string('nama_aplikasi')->nullable();
            $table->string('versi_aplikasi')->nullable();
            $table->text('deskripsi_aplikasi')->nullable();
            $table->longText('modul_aplikasi')->nullable();
            $table->string('bahasa_pemrograman')->nullable();
            $table->string('database_digunakan')->nullable();
            $table->string('development_platform')->nullable();
            $table->text('catatan_lain')->nullable();
            $table->string('nama_ttd_pihak_pertama')->nullable();
            $table->string('nama_ttd_pihak_kedua')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_serah_terima_source_codes');
    }
};