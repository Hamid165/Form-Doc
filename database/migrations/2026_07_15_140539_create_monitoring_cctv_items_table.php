<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_monitoring_cctv_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_monitoring_cctv_id')->constrained('form_monitoring_cctvs')->cascadeOnDelete();
            $table->string('nama_titik_cctv');
            $table->enum('m1_berfungsi', ['V', 'X'])->nullable();
            $table->enum('m1_terbackup', ['V', 'X'])->nullable();
            $table->enum('m2_berfungsi', ['V', 'X'])->nullable();
            $table->enum('m2_terbackup', ['V', 'X'])->nullable();
            $table->enum('m3_berfungsi', ['V', 'X'])->nullable();
            $table->enum('m3_terbackup', ['V', 'X'])->nullable();
            $table->enum('m4_berfungsi', ['V', 'X'])->nullable();
            $table->enum('m4_terbackup', ['V', 'X'])->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // UBAH NAMA TABEL DI SINI
        Schema::dropIfExists('form_monitoring_cctv_items');
    }
};