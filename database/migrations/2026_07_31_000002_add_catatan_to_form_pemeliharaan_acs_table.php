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
        Schema::table('form_pemeliharaan_acs', function (Blueprint $table) {
            $table->text('catatan')->nullable()->after('kota_tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_pemeliharaan_acs', function (Blueprint $table) {
            $table->dropColumn('catatan');
        });
    }
};
