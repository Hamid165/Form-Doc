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
        Schema::table('form_keluhans', function (Blueprint $table) {
            $table->string('mengetahui_jabatan')->nullable()->after('kota_tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_keluhans', function (Blueprint $table) {
            $table->dropColumn('mengetahui_jabatan');
        });
    }
};
