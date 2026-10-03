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
        Schema::create('form_bastiks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petugas_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pimpinan_id')->nullable()->constrained('master_signers')->onDelete('set null');
            $table->string('nomor_surat', 50)->nullable()->unique();
            $table->date('tanggal_surat')->nullable();
            $table->string('kota', 50)->default('Bandung');
            $table->string('business_area', 100)->nullable();
            $table->enum('status', ['draft', 'final', 'signed', 'void'])->default('draft');
            $table->string('qr_token', 100)->unique()->index();
            $table->string('file_pdf_path', 255)->nullable();
            $table->string('file_docx_path', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_bastiks');
    }
};
