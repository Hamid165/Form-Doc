<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita_acara_serah_terima_barang_items', function (Blueprint $table) {
            $table->id();
            // foreignId needs matching column or configured reference since table name is long
            $table->unsignedBigInteger('berita_acara_serah_terima_barang_id');
            $table->foreign('berita_acara_serah_terima_barang_id', 'fk_bast_barang_items_parent')
                  ->references('id')
                  ->on('berita_acara_serah_terima_barangs')
                  ->onDelete('cascade');
            
            $table->string('nama_barang')->nullable();
            $table->string('brand_series')->nullable();
            $table->string('no_inventaris')->nullable();
            $table->string('serial_number')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_acara_serah_terima_barang_items');
    }
};
