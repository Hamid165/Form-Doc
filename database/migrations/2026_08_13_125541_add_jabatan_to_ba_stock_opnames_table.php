<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ba_stock_opnames', function (Blueprint $table) {
            $table->string('jabatan_pimpinan_unit_kerja')->nullable()->after('nipp_pimpinan_unit_kerja');
            $table->string('jabatan_pimpinan_it')->nullable()->after('nipp_pimpinan_it');
            $table->string('jabatan_petugas_it')->nullable()->after('nipp_petugas_it');
        });
    }

    public function down()
    {
        Schema::table('ba_stock_opnames', function (Blueprint $table) {
            $table->dropColumn([
                'jabatan_pimpinan_unit_kerja',
                'jabatan_pimpinan_it',
                'jabatan_petugas_it'
            ]);
        });
    }
};
