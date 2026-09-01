<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_perangkats', function (Blueprint $table) {
            $table->id();
            $table->string('kode_aset', 100)->unique();
            $table->string('jenis_perangkat', 255);
            $table->string('deskripsi', 500)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_perangkats');
    }
};
