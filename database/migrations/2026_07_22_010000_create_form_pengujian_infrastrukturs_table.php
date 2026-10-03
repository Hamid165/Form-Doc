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
        Schema::create('form_pengujian_infrastrukturs', function (Blueprint $table) {
            $table->id();
            $table->string('no_ref')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('business_area')->nullable();

            $table->date('tanggal_pengujian')->nullable();
            $table->string('objek_pengujian')->nullable();
            $table->string('pelaksana_pengujian')->nullable();

            $table->text('deskripsi_pengujian')->nullable();
            $table->text('analisa_kesimpulan')->nullable();

            $table->string('kota_tanggal')->nullable();
            $table->string('mengetahui_nama')->nullable();
            $table->string('mengetahui_jabatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_pengujian_infrastrukturs');
    }
};
