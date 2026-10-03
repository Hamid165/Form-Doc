<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_business_areas', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('daop_divre');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_business_areas');
    }
};
