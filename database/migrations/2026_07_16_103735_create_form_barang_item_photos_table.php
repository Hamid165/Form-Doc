<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_barang_item_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_barang_item_id')->constrained('form_barang_items')->cascadeOnDelete();
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_barang_item_photos');
    }
};
