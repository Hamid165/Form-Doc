<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ba_stock_opname_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ba_stock_opname_id')->constrained()->cascadeOnDelete();
            $table->string('nomor_inventaris_aset')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('jenis_aset_ti')->nullable();
            $table->string('merek')->nullable();
            $table->string('sumber_data')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ba_stock_opname_details');
    }
};
