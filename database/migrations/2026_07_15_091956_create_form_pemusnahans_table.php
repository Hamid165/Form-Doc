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
    Schema::create('form_pemusnahans', function (Blueprint $table) {
        $table->id();

        // Header
        $table->string('no_ref')->nullable();
        $table->date('tanggal_ref')->nullable();
        $table->string('business_area')->nullable();

        // Data Pemohon
        $table->date('tanggal_permohonan')->nullable();
        $table->string('nama_nip')->nullable();
        $table->string('unit_kerja')->nullable();

        // Status Form
        $table->enum('status', ['draft', 'approved', 'rejected'])
              ->default('draft');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_pemusnahans');
    }
};
