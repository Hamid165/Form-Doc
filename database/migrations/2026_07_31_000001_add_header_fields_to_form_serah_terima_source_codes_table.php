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
            if (!Schema::hasColumn('form_serah_terima_source_codes', 'nomor_dokumen')) {
                $table->string('nomor_dokumen')->nullable()->after('id');
            }

            if (!Schema::hasColumn('form_serah_terima_source_codes', 'tanggal_terbit')) {
                $table->date('tanggal_terbit')->nullable()->after('nomor_dokumen');
            }

            if (!Schema::hasColumn('form_serah_terima_source_codes', 'versi_dokumen')) {
                $table->string('versi_dokumen')->nullable()->after('tanggal_terbit');
            }

            if (!Schema::hasColumn('form_serah_terima_source_codes', 'halaman_dokumen')) {
                $table->string('halaman_dokumen')->nullable()->after('versi_dokumen');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('form_serah_terima_source_codes')) {
            return;
        }

        Schema::table('form_serah_terima_source_codes', function (Blueprint $table) {
            $columns = ['nomor_dokumen', 'tanggal_terbit', 'versi_dokumen', 'halaman_dokumen'];

            foreach ($columns as $column) {
                if (Schema::hasColumn('form_serah_terima_source_codes', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
