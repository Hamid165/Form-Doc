<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('implementation_reviews', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_peninjauan');
            $table->string('periode_peninjauan');
            $table->string('pelaksana_peninjauan');
            $table->string('lokasi_peninjauan');
            $table->string('obyek_peninjauan');
            $table->text('deskripsi_sistem');
            $table->text('analisa');
            $table->text('tindak_lanjut');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('implementation_reviews');
    }
};