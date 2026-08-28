<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_berita_acara_serah_terima_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nipp')->nullable();
            $table->string('jabatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_berita_acara_serah_terima_barangs');
    }
};
