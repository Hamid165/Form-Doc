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
        Schema::table('form_pemeliharaan_items', function (Blueprint $table) {
            $table->text('deskripsi')->nullable()->after('master_perangkat_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_pemeliharaan_items', function (Blueprint $table) {
            $table->dropColumn('deskripsi');
        });
    }
};
