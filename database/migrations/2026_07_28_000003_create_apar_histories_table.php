<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apar_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_apar_id')->nullable()->constrained('master_apars')->cascadeOnDelete();
            $table->string('kode_aset_lama')->nullable();
            $table->string('kode_aset_baru')->nullable();
            $table->date('tanggal_perubahan')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apar_histories');
    }
};
