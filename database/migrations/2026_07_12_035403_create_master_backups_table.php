<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('master_backups', function (Blueprint $table) {
            $table->id();
            $table->string('kategori'); // Untuk membedakan: metode, periode, retensi, status, pimpinan
            $table->string('nama');     // Isi datanya
            $table->string('jabatan')->nullable(); // Khusus untuk pimpinan, sisanya dibiarkan kosong
            $table->string('nipp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_backups');
    }
};
