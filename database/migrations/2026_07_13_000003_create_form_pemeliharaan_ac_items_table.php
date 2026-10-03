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
        Schema::create('form_pemeliharaan_ac_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_pemeliharaan_ac_id')->constrained('form_pemeliharaan_acs')->onDelete('cascade');
            $table->integer('no')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('jenis_kegiatan')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('paraf')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_pemeliharaan_ac_items');
    }
};
