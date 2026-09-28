<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('form_serah_terima_source_codes', function (Blueprint $table) {
            $columns = [
                'nomor_dokumen' => 'string',
                'tanggal_terbit' => 'date',
                'versi_dokumen' => 'string',
                'halaman_dokumen' => 'string',
                'no_ref' => 'string',
                'tanggal' => 'date',
                'business_area' => 'string',
                'hari' => 'string',
                'bulan' => 'string',
                'tahun' => 'string',
                'pihak_pertama_diwakili' => 'string',
                'pihak_kedua_diwakili' => 'string',
                'pihak_kedua_jabatan' => 'string',
                'jenis_serah_terima_lainnya' => 'string',
                'database_digunakan' => 'string',
                'nama_ttd_pihak_pertama' => 'string',
                'nama_ttd_pihak_kedua' => 'string',
            ];

            foreach ($columns as $column => $type) {
                if (!Schema::hasColumn('form_serah_terima_source_codes', $column)) {
                    if ($type === 'date') {
                        $table->date($column)->nullable();
                    } else {
                        $table->string($column)->nullable();
                    }
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('form_serah_terima_source_codes', function (Blueprint $table) {
            $columns = [
                'nomor_dokumen', 'tanggal_terbit', 'versi_dokumen', 'halaman_dokumen',
                'no_ref', 'tanggal', 'business_area', 'hari', 'bulan', 'tahun',
                'pihak_pertama_diwakili', 'pihak_kedua_diwakili', 'pihak_kedua_jabatan',
                'jenis_serah_terima_lainnya',
                'database_digunakan', 'nama_ttd_pihak_pertama', 'nama_ttd_pihak_kedua',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('form_serah_terima_source_codes', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};