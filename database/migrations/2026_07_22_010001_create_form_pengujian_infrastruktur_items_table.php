<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_pengujian_infrastruktur_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_pengujian_infrastruktur_id');
            $table->integer('no')->nullable();
            $table->text('rencana_pengujian')->nullable();
            $table->string('hasil')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('form_pengujian_infrastruktur_id', 'fk_pengujian_item_id')
                  ->references('id')
                  ->on('form_pengujian_infrastrukturs')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_pengujian_infrastruktur_items');
    }
};