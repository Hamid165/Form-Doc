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
        Schema::create('form_pc_laptop_checkings', function (Blueprint $table) {
            $table->id();
            $table->string('no_ref')->nullable()->unique();
            $table->date('tanggal')->nullable();
            $table->string('business_area')->nullable();
            
            $table->string('periode_pemeriksaan')->nullable();
            $table->string('tanggal_pemeriksaan')->nullable();
            
            $table->text('catatan')->nullable();
            $table->string('mengetahui_nama')->nullable();
            $table->string('mengetahui_nipp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_pc_laptop_checkings');
    }
};
