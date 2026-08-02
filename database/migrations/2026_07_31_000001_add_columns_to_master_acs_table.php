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
        Schema::table('master_acs', function (Blueprint $table) {
            $table->string('sub_lokasi')->nullable()->after('lokasi');
            $table->string('jenis')->nullable()->after('sub_lokasi');
            $table->string('merk')->nullable()->after('jenis');
            $table->string('kapasitas')->nullable()->after('merk');
            $table->string('tahun_pasang')->nullable()->after('kapasitas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_acs', function (Blueprint $table) {
            $table->dropColumn(['sub_lokasi', 'jenis', 'merk', 'kapasitas', 'tahun_pasang']);
        });
    }
};
