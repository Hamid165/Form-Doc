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
            if (!Schema::hasColumn('form_serah_terima_source_codes', 'nama_ttd_pihak_pertama')) {
                $table->string('nama_ttd_pihak_pertama')->nullable()->after('catatan_lain');
            }
            if (!Schema::hasColumn('form_serah_terima_source_codes', 'nama_ttd_pihak_kedua')) {
                $table->string('nama_ttd_pihak_kedua')->nullable()->after('nama_ttd_pihak_pertama');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('form_serah_terima_source_codes')) {
            return;
        }

        Schema::table('form_serah_terima_source_codes', function (Blueprint $table) {
            foreach (['nama_ttd_pihak_pertama', 'nama_ttd_pihak_kedua'] as $column) {
                if (Schema::hasColumn('form_serah_terima_source_codes', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
