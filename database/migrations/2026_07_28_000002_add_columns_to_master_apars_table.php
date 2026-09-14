<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_apars', function (Blueprint $table) {
            $table->string('seri')->nullable()->after('tipe');
            $table->string('jenis')->nullable()->after('media');
            $table->string('sub_lokasi')->nullable()->after('lokasi');
            $table->foreignId('vendor_id')->nullable()->after('tanggal_kadaluarsa')->constrained('master_vendors')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('master_apars', function (Blueprint $table) {
            $table->dropForeign(['vendor_id']);
            $table->dropColumn(['seri', 'jenis', 'sub_lokasi', 'vendor_id']);
        });
    }
};
