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
            if (!Schema::hasColumn('form_serah_terima_source_codes', 'no_ref')) {
                $table->string('no_ref')->nullable()->after('halaman_dokumen');
            }
            if (!Schema::hasColumn('form_serah_terima_source_codes', 'tanggal')) {
                $table->date('tanggal')->nullable()->after('no_ref');
            }
            if (!Schema::hasColumn('form_serah_terima_source_codes', 'business_area')) {
                $table->string('business_area')->nullable()->after('tanggal');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('form_serah_terima_source_codes')) {
            return;
        }

        Schema::table('form_serah_terima_source_codes', function (Blueprint $table) {
            $columns = ['no_ref', 'tanggal', 'business_area'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('form_serah_terima_source_codes', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
