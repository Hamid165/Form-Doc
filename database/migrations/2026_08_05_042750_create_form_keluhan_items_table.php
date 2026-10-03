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
        Schema::create('form_keluhan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_keluhan_id')->constrained('form_keluhans')->onDelete('cascade');
            $table->integer('no')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('pelanggan')->nullable();
            $table->string('sumber')->nullable();
            $table->text('deskripsi_keluhan')->nullable();
            $table->text('tindakan')->nullable();
            $table->string('verifikasi_tgl')->nullable();
            $table->string('verifikasi_pic')->nullable();
            $table->string('verifikasi_hasil')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_keluhan_items');
    }
};
