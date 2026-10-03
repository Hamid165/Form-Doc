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
        Schema::create('form_pemeliharaan_acs', function (Blueprint $table) {
            $table->id();
            $table->string('no_ref')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('business_area')->nullable();
            $table->string('id_ac')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('mengetahui_nama')->nullable();
            $table->string('mengetahui_nipp')->nullable();
            $table->string('mengetahui_jabatan')->nullable();
            $table->string('kota_tanggal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_pemeliharaan_acs');
    }
};
