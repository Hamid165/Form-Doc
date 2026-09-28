<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('no_ref')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('business_area')->nullable()->default('B060');
            $table->enum('jenis', ['masuk', 'keluar'])->default('masuk');
            $table->date('tanggal_masuk')->nullable();
            $table->time('jam_masuk')->nullable();
            $table->string('nama_pemohon')->nullable();
            $table->string('nomor_identitas')->nullable();
            $table->text('alamat')->nullable();
            $table->string('nomor_telepon')->nullable();
            $table->string('perusahaan_unit')->nullable();
            $table->string('kota_ttd')->nullable();
            $table->string('jabatan_pelaksana')->nullable();
            $table->string('nama_pelaksana')->nullable();
            $table->string('nipp_pelaksana')->nullable();
            $table->string('jabatan_mengetahui')->nullable();
            $table->string('nama_mengetahui')->nullable();
            $table->string('nipp_mengetahui')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_barangs');
    }
};
