<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_pemohons', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('nip', 100)->nullable();
            $table->timestamps();
            $table->unique(['nama', 'nip']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_pemohons');
    }
};
