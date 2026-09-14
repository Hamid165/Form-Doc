<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_signer_secure_operations', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nipp', 50);
            $table->string('jabatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_signer_secure_operations');
    }
};