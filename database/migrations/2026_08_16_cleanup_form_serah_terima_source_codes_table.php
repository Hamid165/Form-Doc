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
            // Drop unnecessary columns if they exist
            if (Schema::hasColumn('form_serah_terima_source_codes', 'tanggal_num1')) {
                $table->dropColumn('tanggal_num1');
            }
            if (Schema::hasColumn('form_serah_terima_source_codes', 'tanggal_num2')) {
                $table->dropColumn('tanggal_num2');
            }
            if (Schema::hasColumn('form_serah_terima_source_codes', 'tanggal_num3')) {
                $table->dropColumn('tanggal_num3');
            }
            if (Schema::hasColumn('form_serah_terima_source_codes', 'pihak_kedua_keterangan')) {
                $table->dropColumn('pihak_kedua_keterangan');
            }
            // Add simpler field if not exists
            if (!Schema::hasColumn('form_serah_terima_source_codes', 'tanggal_str')) {
                $table->string('tanggal_str')->nullable()->after('tanggal');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('form_serah_terima_source_codes')) {
            return;
        }

        Schema::table('form_serah_terima_source_codes', function (Blueprint $table) {
            if (Schema::hasColumn('form_serah_terima_source_codes', 'tanggal_str')) {
                $table->dropColumn('tanggal_str');
            }
        });
    }
};
