<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_pemeliharaans', function (Blueprint $table) {
            $table->id();
            $table->string('no_ref')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('business_area')->nullable();
            $table->string('lokasi')->nullable();
            $table->enum('jenis_pemeliharaan', ['Terencana', 'Tak Terencana'])->nullable();
            $table->string('bulan_pemeliharaan', 100)->nullable();
            $table->text('catatan')->nullable();
            $table->string('petugas_name')->nullable();
            $table->string('petugas_nipp', 50)->nullable();
            $table->foreignId('mengetahui_id')->nullable()->constrained('master_signers')->nullOnDelete();
            $table->enum('status', ['draft', 'dicetak', 'selesai'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_pemeliharaans');
    }
};
