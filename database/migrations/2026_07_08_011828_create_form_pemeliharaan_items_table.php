<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_pemeliharaan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_pemeliharaan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('master_perangkat_id')->nullable()->constrained('master_perangkats')->nullOnDelete();
            $table->string('pekerjaan', 500)->nullable();
            $table->text('permasalahan')->nullable();
            $table->text('solusi')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_pemeliharaan_items');
    }
};
