<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_monitoring_cctvs', function (Blueprint $table) {
            $table->id();
            $table->string('no_ref')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('business_area')->nullable();
            $table->string('bulan')->nullable();
            $table->date('tgl_pelaksanaan_m1')->nullable();
            $table->date('tgl_pelaksanaan_m2')->nullable();
            $table->date('tgl_pelaksanaan_m3')->nullable();
            $table->date('tgl_pelaksanaan_m4')->nullable();
            $table->text('catatan')->nullable();
            $table->string('petugas_nama')->nullable();
            $table->string('petugas_nipp')->nullable();
            $table->foreignId('mengetahui_id')->nullable()->constrained('master_signers')->nullOnDelete();
            $table->enum('status', ['draft', 'dicetak', 'selesai'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_monitoring_cctvs');
    }
};