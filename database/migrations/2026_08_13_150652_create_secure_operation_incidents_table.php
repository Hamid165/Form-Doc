<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('secure_operation_incidents', function (Blueprint $table) {
            $table->id();

            // Kolom Referensi Formulir Asli
            $table->string('no_ref')->nullable();
            $table->date('tanggal_ref')->nullable();
            $table->string('business_area')->nullable();

            // Header/Deskripsi Aplikasi
            $table->string('nama_aplikasi');
            $table->date('tanggal_checklist'); 
            $table->text('deskripsi');
            $table->string('versi_aplikasi');
            $table->string('modul');
            $table->text('fungsi');

            // Checklist 05 Secure Implement (Dropdown Ya/Tidak)
            $table->enum('incident_high_dilaporkan', ['Ya', 'Tidak']);
            $table->enum('incident_masuk_tiket', ['Ya', 'Tidak']);
            $table->enum('incident_tiket_closed', ['Ya', 'Tidak']);
            $table->enum('va_dilakukan', ['Ya', 'Tidak']);
            $table->enum('jadwal_pentest', ['Ya', 'Tidak']);

            // Kolom untuk Tempat dan Tanggal Tanda Tangan
            $table->string('tempat_ttd')->nullable();
            $table->string('tanggal_ttd')->nullable();

            // Relasi Tanda Tangan ke Tabel Master Signer (Foreign Key)
            $table->foreignId('mengetahui_id')
                  ->constrained('master_signer_secure_operations')
                  ->onDelete('cascade'); // <-- Ubah dari restrict ke cascade

            $table->foreignId('pelaksana_id')
                  ->constrained('master_signer_secure_operations')
                  ->onDelete('cascade'); // <-- Ubah dari restrict ke cascade
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('secure_operation_incidents');
    }
};
