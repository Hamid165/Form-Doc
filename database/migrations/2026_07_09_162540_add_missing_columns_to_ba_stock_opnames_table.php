<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ba_stock_opnames', function (Blueprint $table) {
            $table->string('no_ref')->nullable()->after('id');
            $table->date('tanggal_ref')->nullable()->after('no_ref');
            $table->string('business_area')->nullable()->after('tanggal_ref');
            $table->string('petugas_it')->nullable()->after('pimpinan_it');
        });
    }

    public function down(): void
    {
        Schema::table('ba_stock_opnames', function (Blueprint $table) {
            $table->dropColumn(['no_ref', 'tanggal_ref', 'business_area', 'petugas_it']);
        });
    }
};
