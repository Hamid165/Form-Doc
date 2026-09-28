<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('form_keluhans', function (Blueprint $table) {
            $table->string('pelaksana_nama')->nullable()->after('kota_tanggal');
            $table->string('pelaksana_nipp')->nullable()->after('pelaksana_nama');
        });
    }

    public function down(): void
    {
        Schema::table('form_keluhans', function (Blueprint $table) {
            $table->dropColumn(['pelaksana_nama', 'pelaksana_nipp']);
        });
    }
};