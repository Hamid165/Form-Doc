<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_checklist_pc_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_checklist_pc_id')->constrained()->cascadeOnDelete();
            $table->string('nama_aset')->nullable();
            $table->string('id_aset')->nullable();
            $table->string('nipp')->nullable();
            $table->json('checklist')->nullable();
            $table->string('paraf')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_checklist_pc_items');
    }
};