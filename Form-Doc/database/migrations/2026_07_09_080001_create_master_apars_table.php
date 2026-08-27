<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_apars', function (Blueprint $table) {
            $table->id();
            $table->string('kode_aset', 100)->unique();
            $table->string('merk')->nullable();
            $table->string('tipe')->nullable();
            $table->string('media')->nullable(); // Air, Busa, Serbuk, CO2, Halon Free
            $table->string('kapasitas')->nullable(); // e.g., 6 Kg
            $table->string('lokasi')->nullable();
            $table->date('tanggal_isi_ulang')->nullable();
            $table->date('tanggal_kadaluarsa')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_apars');
    }
};
