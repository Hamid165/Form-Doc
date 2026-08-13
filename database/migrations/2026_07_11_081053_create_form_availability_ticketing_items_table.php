<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_availability_ticketing_items', function (Blueprint $table) {

            $table->id();

            // Relasi ke form utama
            $table->foreignId('form_availability_ticketing_id');

            $table->foreign(
                'form_availability_ticketing_id',
                'fk_availability_ticket_items'
            )
            ->references('id')
            ->on('form_availability_ticketings')
            ->cascadeOnDelete();


            // Nomor urut
            $table->integer('nomor')
                  ->nullable();


            // Nama station
            $table->string('station')
                  ->nullable();


            // RTS / PTS
            $table->string('rts_pts_ng')
                  ->nullable();


            // Jumlah perangkat ticketing
            $table->integer('jumlah_perangkat_ticketing')
                  ->default(0);


            // Jumlah gangguan
            $table->integer('jumlah_gangguan')
                  ->default(0);


            // Keterangan gangguan
            $table->text('keterangan')
                  ->nullable();


            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('form_availability_ticketing_items');
    }
};
