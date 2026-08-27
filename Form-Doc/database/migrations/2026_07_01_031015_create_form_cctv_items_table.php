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
        Schema::create('form_cctv_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_cctv_id')->constrained('form_cctvs')->onDelete('cascade');
            $table->integer('no')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('jenis_kegiatan')->nullable(); // changed to string to hold json or comma separated
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
        Schema::dropIfExists('form_cctv_items');
    }
};
