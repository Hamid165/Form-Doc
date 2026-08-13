<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_availability_ticketings', function (Blueprint $table) {
            $table->id();

            // Header Form
            $table->string('no_ref')->nullable();
            $table->date('tanggal')->nullable();

            $table->string('business_area')->nullable();
            $table->string('daop_divre')->nullable();

            // Ringkasan
            $table->integer('jumlah_total_station')
                  ->default(0);

            $table->integer('jumlah_perangkat_ticketing')
                  ->default(0);

            $table->text('catatan')
                  ->nullable();


            // Petugas
            $table->string('petugas_name')
                  ->nullable();

            $table->string('petugas_nipp', 50)
                  ->nullable();


            // Mengetahui / Approval
            $table->foreignId('mengetahui_id')
                  ->nullable()
                  ->constrained('master_signers')
                  ->nullOnDelete();


            // Status form
            $table->enum('status', [
                'draft',
                'dicetak',
                'selesai'
            ])
            ->default('draft');


            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('form_availability_ticketings');
    }
};
