<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('form_serah_terima_users', function (Blueprint $table) {
            $table->id();
            $table->string('no_ref')->nullable();
            $table->date('tanggal_ref')->nullable();
            $table->string('business_area')->nullable();
            $table->string('hari')->nullable();
            $table->date('tanggal')->nullable();

            // Pihak yang menyerahkan
            $table->string('nama_penyerah')->nullable();
            $table->string('nipp_penyerah')->nullable();
            $table->string('jabatan_penyerah')->nullable();
            $table->string('tempat_kedudukan_penyerah')->nullable();
            $table->string('personal_area_penyerah')->nullable();

            // Pihak yang menerima
            $table->string('nama_penerima')->nullable();
            $table->string('nipp_penerima')->nullable();
            $table->string('jabatan_penerima')->nullable();
            $table->string('tempat_kedudukan_penerima')->nullable();
            $table->string('personal_area_penerima')->nullable();
            $table->string('owner_responsible_penerima')->nullable();
            $table->string('custodian_penerima')->nullable();

            $table->text('keperluan')->nullable();
            $table->date('masa_aktif_mulai')->nullable();
            $table->date('masa_aktif_selesai')->nullable();

            // Kolom Tanda Tangan
            $table->string('nama_yang_menyerahkan')->nullable();
            $table->string('nipp_yang_menyerahkan')->nullable();
            $table->string('nama_yang_menerima')->nullable();
            $table->string('nipp_yang_menerima')->nullable();
            $table->string('tempat_ttd')->nullable();
            $table->date('tanggal_ttd')->nullable();

            $table->timestamps();
        });

        // Insert new form template to form_templates
        DB::table('form_templates')->insert([
            'nama' => 'Berita Acara Serah Terima User Aplikasi',
            'kategori' => 'Terbatas',
            'route_name' => 'form-serah-terima-user.index',
            'no_dokumen' => 'FR.SM/TI/011.002/10-2020',
            'tanggal_dokumen' => '12 Oktober 2020',
            'versi_dokumen' => '02-2020',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_serah_terima_users');

        DB::table('form_templates')
            ->where('nama', 'Berita Acara Serah Terima User Aplikasi')
            ->delete();
    }
};
