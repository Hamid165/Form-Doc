<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_backup_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_backup_id')->constrained('form_backups')->cascadeOnDelete();
            $table->integer('no');
            $table->string('nama_informasi')->nullable();
            $table->string('metode_backup')->nullable();
            $table->string('periode_backup')->nullable();
            $table->string('retensi')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_backup_items');
    }
};