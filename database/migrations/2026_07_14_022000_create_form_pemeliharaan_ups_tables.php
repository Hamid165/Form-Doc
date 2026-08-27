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
        // 1. Create master_ups table
        Schema::create('master_ups', function (Blueprint $table) {
            $table->id();
            $table->string('no_id');
            $table->string('lokasi')->nullable();
            $table->timestamps();
        });

        // 2. Create form_pemeliharaan_ups table
        Schema::create('form_pemeliharaan_ups', function (Blueprint $table) {
            $table->id();
            $table->string('no_ref')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('business_area')->nullable();
            $table->string('no_id')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('kota_tanggal')->nullable();
            $table->string('mengetahui_nama')->nullable();
            $table->string('mengetahui_nipp')->nullable();
            $table->string('mengetahui_jabatan')->nullable();
            $table->timestamps();
        });

        // 3. Create form_pemeliharaan_ups_items table
        Schema::create('form_pemeliharaan_ups_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_pemeliharaan_ups_id')
                  ->constrained('form_pemeliharaan_ups')
                  ->onDelete('cascade');
            $table->integer('no')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('jenis_kegiatan')->nullable(); // holds JSON like {"perawatan":"V","perbaikan":"-"}
            $table->text('keterangan')->nullable();
            $table->string('paraf')->nullable();
            $table->timestamps();
        });

        // 4. Seed template into form_templates
        DB::table('form_templates')->updateOrInsert(
            ['nama' => 'Checklist Pemeliharaan UPS'],
            [
                'kategori' => 'Umum',
                'route_name' => 'form-pemeliharaan-ups.index',
                'no_dokumen' => 'FR.SM/TI/015.004/10-2020',
                'tanggal_dokumen' => '12 Oktober 2020',
                'versi_dokumen' => '002-2020',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('form_templates')->where('nama', 'Checklist Pemeliharaan UPS')->delete();
        Schema::dropIfExists('form_pemeliharaan_ups_items');
        Schema::dropIfExists('form_pemeliharaan_ups');
        Schema::dropIfExists('master_ups');
    }
};
