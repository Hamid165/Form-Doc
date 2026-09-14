<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('form_barang_items', function (Blueprint $table) {
            $table->text('part_no')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('form_barang_items', function (Blueprint $table) {
            $table->string('part_no')->nullable()->change();
        });
    }
};
