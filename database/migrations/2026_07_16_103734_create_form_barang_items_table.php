<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_barang_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_barang_id')->constrained('form_barangs')->cascadeOnDelete();
            $table->foreignId('master_perangkat_id')->nullable()->constrained('master_perangkats')->nullOnDelete();
            $table->integer('no_urut');
            $table->string('nama_jenis_aset');
            $table->string('part_no')->nullable();
            $table->integer('jumlah')->default(1);
            $table->string('satuan');
            $table->string('merk_type');
            $table->string('kategori_aset');
            $table->string('lokasi_penyimpanan');
            $table->string('owner')->nullable();
            $table->string('power_a')->nullable();
            $table->decimal('berat_kg', 8, 2)->nullable();
            $table->string('ukuran_u')->nullable();
            $table->string('jenis_hw_sw')->nullable();
            $table->enum('kondisi_baru_bekas', ['baru', 'bekas'])->default('baru');
            $table->enum('kondisi_baik_rusak', ['baik', 'rusak'])->default('baik');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_barang_items');
    }
};
