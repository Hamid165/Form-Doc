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
    Schema::create('form_pemusnahan_items', function (Blueprint $table) {
        $table->id();

        $table->foreignId('form_pemusnahan_id')
              ->constrained('form_pemusnahans')
              ->cascadeOnDelete();

        $table->string('nama_aset');
        $table->string('jenis_aset');
        $table->string('id_aset');
        $table->text('alasan_pemusnahan');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_pemusnahan_items');
    }
};
