<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('form_pemusnahans', function (Blueprint $table) {
            // Baris "....................., .... - .... - ...." di atas kolom tanda tangan
            $table->string('tempat_persetujuan')->nullable()->after('unit_kerja');
            $table->date('tanggal_persetujuan')->nullable()->after('tempat_persetujuan');

            // Kolom "Atasan Pengguna Aset"
            $table->string('nama_atasan')->nullable()->after('tanggal_persetujuan');

            // Kolom "Pengelola Aset"
            $table->string('nama_pengelola')->nullable()->after('nama_atasan');

            // Baris "Menyetujui / Tidak Menyetujui *,"
            $table->enum('keputusan', ['setuju', 'tidak_setuju'])->nullable()->after('nama_pengelola');

            // "VP IT Operation/ Pimpinan Unit Sistem Informasi Daerah"
            $table->string('nama_vp')->nullable()->after('keputusan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_pemusnahans', function (Blueprint $table) {
            $table->dropColumn([
                'tempat_persetujuan',
                'tanggal_persetujuan',
                'nama_atasan',
                'nama_pengelola',
                'keputusan',
                'nama_vp',
            ]);
        });
    }
};
