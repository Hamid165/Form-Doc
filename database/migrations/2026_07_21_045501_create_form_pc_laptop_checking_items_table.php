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
        Schema::create('form_pc_laptop_checking_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_pc_laptop_checking_id');
            $table->foreign('form_pc_laptop_checking_id', 'fk_pc_check_items_to_pc_check')
                  ->references('id')->on('form_pc_laptop_checkings')->onDelete('cascade');
            
            $table->integer('no')->default(0);
            $table->string('nama_pengguna')->nullable();
            $table->string('unit')->nullable();
            
            $table->string('nda')->nullable();
            $table->string('login_strong_password')->nullable();
            $table->string('screensaver_lock')->nullable();
            $table->string('hak_akses_khusus')->nullable();
            $table->string('cleardesk')->nullable();
            $table->string('mp3_video_etc')->nullable();
            
            $table->string('antivirus_install')->nullable();
            $table->string('antivirus_update')->nullable();
            $table->string('full_scan_auto_schedule')->nullable();
            
            $table->string('os_license')->nullable();
            $table->string('sinkronisasi_ntp')->nullable();
            $table->string('label_pc')->nullable();
            
            $table->string('pemeriksa')->nullable();
            $table->string('pegawai_ybs')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_pc_laptop_checking_items');
    }
};
