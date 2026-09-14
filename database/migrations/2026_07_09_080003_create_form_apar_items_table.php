<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_apar_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_apar_id')->constrained('form_apars')->cascadeOnDelete();
            $table->foreignId('master_apar_id')->nullable()->constrained('master_apars')->nullOnDelete();
            $table->date('waktu_pengecekan_tgl')->nullable();
            $table->string('waktu_pengecekan_jam', 10)->nullable();
            $table->string('indikator_tekanan', 20)->nullable(); // Hijau, Merah
            $table->string('perlakuan_fisik', 255)->nullable();
            $table->text('tindak_lanjut')->nullable();
            $table->string('paraf', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_apar_items');
    }
};
