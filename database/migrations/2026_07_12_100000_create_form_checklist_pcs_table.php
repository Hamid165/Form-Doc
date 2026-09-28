<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_checklist_pcs', function (Blueprint $table) {
            $table->id();
            $table->string('no_ref')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('business_area')->nullable();
            $table->string('pelaksana_name')->nullable();
            $table->date('tanggal_pemeriksaan')->nullable();
            $table->text('analisa_kesimpulan')->nullable();
            $table->enum('status', ['draft', 'dicetak', 'selesai'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_checklist_pcs');
    }
};