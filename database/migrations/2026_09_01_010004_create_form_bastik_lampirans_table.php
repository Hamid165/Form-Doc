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
        Schema::create('form_bastik_lampirans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_bastik_id')->constrained('form_bastiks')->onDelete('cascade');
            $table->foreignId('form_bastik_item_id')->nullable()->constrained('form_bastik_items')->onDelete('cascade');
            $table->string('file_path', 255);
            $table->tinyInteger('urutan_konfirmasi'); // 1, 2, 3
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_bastik_lampirans');
    }
};
