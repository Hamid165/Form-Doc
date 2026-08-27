<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ba_stock_opnames', function (Blueprint $table) {
            $table->string('nipp_pimpinan_unit_kerja')->nullable()->after('pimpinan_unit_kerja');
            $table->string('nipp_pimpinan_it')->nullable()->after('pimpinan_it');
            $table->string('nipp_petugas_it')->nullable()->after('petugas_it');
        });
    }

    public function down()
    {
        Schema::table('ba_stock_opnames', function (Blueprint $table) {
            $table->dropColumn(['nipp_pimpinan_unit_kerja', 'nipp_pimpinan_it', 'nipp_petugas_it']);
        });
    }
};
