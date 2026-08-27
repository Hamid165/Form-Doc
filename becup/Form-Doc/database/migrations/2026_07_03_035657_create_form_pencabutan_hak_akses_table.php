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
        Schema::create('form_revocations', function (Blueprint $table) {
            $table->id();
            $table->string('no_ref')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('business_area')->nullable();
            $table->date('tanggal_permohonan')->nullable();
            $table->string('nama_pemohon')->nullable();
            $table->string('bagian_fungsi')->nullable();
            $table->string('kota_tanggal_pemohon')->nullable();
            $table->string('status_persetujuan')->nullable();
            $table->string('kota_tanggal_setuju')->nullable();
            $table->string('mengetahui_nama')->nullable();
            $table->string('jabatan_mengetahui')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_revocations');
    }
};
