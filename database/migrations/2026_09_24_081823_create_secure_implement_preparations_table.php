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
        Schema::create('secure_implement_preparations', function (Blueprint $table) {
    $table->id();

    // Informasi Referensi
    $table->string('no_ref')->unique();
    $table->date('tanggal');
    $table->string('business_area')->nullable();

    // Deskripsi Aplikasi
    $table->string('nama_aplikasi');
    $table->date('tanggal_checklist');
    $table->text('deskripsi')->nullable();
    $table->string('versi_aplikasi')->nullable();
    $table->string('modul')->nullable();
    $table->text('fungsi')->nullable();

    // Checklist
    $table->string('check_tsd')->nullable();
    $table->string('check_user_manual')->nullable();

    // Tanda Tangan
    $table->string('tempat')->nullable();
    $table->date('tanggal_ttd')->nullable();

    $table->string('mengetahui_nama')->nullable();
    $table->string('mengetahui_nipp')->nullable();

    $table->string('pelaksana_nama')->nullable();
    $table->string('pelaksana_nipp')->nullable();

    $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secure_implement_preparations');
    }
};
