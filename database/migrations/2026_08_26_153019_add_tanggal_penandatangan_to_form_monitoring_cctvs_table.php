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
        Schema::table('form_monitoring_cctvs', function (Blueprint $table) {
            $table->date('mengetahui_tanggal')->nullable();
            $table->date('petugas_tanggal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_monitoring_cctvs', function (Blueprint $table) {
            $table->dropColumn(['mengetahui_tanggal', 'petugas_tanggal']);
        });
    }
};
