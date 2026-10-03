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
        Schema::create('form_bastik_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_bastik_id')->constrained('form_bastiks')->onDelete('cascade');
            $table->integer('urutan_baris')->default(0);
            $table->string('no_tiket', 30);
            $table->text('detail_tiket')->nullable();
            $table->string('user_pemohon', 150)->nullable();
            $table->string('nipp', 30)->nullable();
            $table->string('unit', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_bastik_items');
    }
};
