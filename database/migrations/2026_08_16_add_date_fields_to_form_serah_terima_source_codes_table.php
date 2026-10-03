<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('form_serah_terima_source_codes')) {
            return;
        }

        Schema::table('form_serah_terima_source_codes', function (Blueprint $table) {
            if (!Schema::hasColumn('form_serah_terima_source_codes', 'bulan')) {
                $table->string('bulan')->nullable()->after('tanggal');
            }
            if (!Schema::hasColumn('form_serah_terima_source_codes', 'tahun')) {
                $table->string('tahun')->nullable()->after('bulan');
            }
            if (!Schema::hasColumn('form_serah_terima_source_codes', 'tanggal_num1')) {
                $table->string('tanggal_num1')->nullable()->after('tahun');
            }
            if (!Schema::hasColumn('form_serah_terima_source_codes', 'tanggal_num2')) {
                $table->string('tanggal_num2')->nullable()->after('tanggal_num1');
            }
            if (!Schema::hasColumn('form_serah_terima_source_codes', 'tanggal_num3')) {
                $table->string('tanggal_num3')->nullable()->after('tanggal_num2');
            }
            if (!Schema::hasColumn('form_serah_terima_source_codes', 'pihak_kedua_keterangan')) {
                $table->string('pihak_kedua_keterangan')->nullable()->after('pihak_kedua_nama');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('form_serah_terima_source_codes')) {
            return;
        }

        Schema::table('form_serah_terima_source_codes', function (Blueprint $table) {
            foreach (['bulan', 'tahun', 'tanggal_num1', 'tanggal_num2', 'tanggal_num3', 'pihak_kedua_keterangan'] as $column) {
                if (Schema::hasColumn('form_serah_terima_source_codes', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
