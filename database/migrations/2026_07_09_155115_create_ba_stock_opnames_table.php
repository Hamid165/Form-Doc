<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ba_stock_opnames', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_stock_opname');
            $table->string('unit_kerja');
            $table->string('tempat_kedudukan');
            $table->text('analisa');
            $table->text('tindak_lanjut');
            $table->string('pimpinan_unit_kerja')->nullable();
            $table->string('tempat_ttd')->nullable();
            $table->date('tanggal_ttd')->nullable();
            $table->string('pimpinan_it')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ba_stock_opnames');
    }
};
