<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_log_peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('no_ref');
            $table->date('tanggal_ref');
            $table->string('business_area');
            $table->timestamps();
        });

        Schema::create('form_log_peminjaman_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('form_log_peminjaman')->onDelete('cascade');
            $table->string('nama_informasi')->nullable();
            $table->string('nama_peminjam')->nullable();
            $table->string('unit_kerja')->nullable();
            $table->string('tanggal_pinjam')->nullable();
            $table->string('paraf_peminjam_pinjam')->nullable();
            $table->string('tanggal_kembali')->nullable();
            $table->string('paraf_peminjam_kembali')->nullable();
            $table->string('paraf_p_jawab')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_log_peminjaman_details');
        Schema::dropIfExists('form_log_peminjaman');
    }
};
