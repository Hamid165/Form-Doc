<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita_acara_serah_terima_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('no_ref')->nullable();
            $table->date('tanggal_ref')->nullable();
            $table->string('business_area')->nullable();

            // Hari & Tanggal serah terima
            $table->string('hari')->nullable();
            $table->date('tanggal_serah_terima')->nullable();

            // Data Penyerah (Yang Menyerahkan)
            $table->string('penyerah_nama')->nullable();
            $table->string('penyerah_nipp')->nullable();
            $table->string('penyerah_jabatan')->nullable();
            $table->string('penyerah_tempat_kedudukan')->nullable();
            $table->string('penyerah_personal_area')->nullable();

            // Data Penerima (Kepada)
            $table->string('penerima_nama')->nullable();
            $table->string('penerima_nipp')->nullable();
            $table->string('penerima_jabatan')->nullable();
            $table->string('penerima_tempat_kedudukan')->nullable();
            $table->string('penerima_personal_area')->nullable();
            $table->string('penerima_owner_responsible')->nullable();
            $table->string('penerima_custodian')->nullable();

            // Keterangan Penggunaan
            $table->string('nama_unit')->nullable();
            $table->string('wilayah')->nullable();

            // Tanda Tangan
            $table->string('ttd_penyerah_nama')->nullable();
            $table->string('ttd_penyerah_nipp')->nullable();
            $table->string('ttd_penerima_nama')->nullable();
            $table->string('ttd_penerima_nipp')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_acara_serah_terima_barangs');
    }
};
