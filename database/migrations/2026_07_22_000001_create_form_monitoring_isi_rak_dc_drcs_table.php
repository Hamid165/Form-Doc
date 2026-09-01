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
        Schema::create('form_monitoring_isi_rak_dc_drcs', function (Blueprint $table) {
            $table->id();
            $table->string('no_ref')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('business_area')->nullable();

            $table->string('nomor_rak')->nullable();
            $table->string('last_update')->nullable();
            $table->string('kode_rak')->nullable();
            $table->string('ukuran_rak')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('lantai')->nullable();
            $table->text('alamat')->nullable();

            $table->string('mengetahui_nama')->nullable();
            $table->string('mengetahui_nipp')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_monitoring_isi_rak_dc_drcs');
    }
};
