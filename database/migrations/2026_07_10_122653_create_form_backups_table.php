<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_backups', function (Blueprint $table) {
            $table->id();
            $table->string('no_ref')->nullable();
            $table->date('tanggal');
            $table->string('business_area')->nullable();
            
            // Kolom metadata dokumen (Kop Kanan Atas)
            $table->string('doc_nomor')->default('DK.SM/TI/012.002/02-2023');
            $table->date('doc_tanggal')->default('2023-02-13');
            $table->string('doc_versi')->default('001-2023');
            
            // Kolom Tanda Tangan (Footer)
            $table->string('kota_tanggal')->nullable(); // Contoh: Yogyakarta, 10 Juli 2026
            $table->string('mengetahui_nama')->nullable();
            $table->string('mengetahui_nipp')->nullable();
            $table->string('mengetahui_jabatan')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_backups');
    }
};