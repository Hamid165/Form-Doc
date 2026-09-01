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
        Schema::create('form_serah_terima_user_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_serah_terima_user_id')
                  ->constrained('form_serah_terima_users')
                  ->onDelete('cascade');
            $table->string('nama_aplikasi')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_serah_terima_user_items');
    }
};
