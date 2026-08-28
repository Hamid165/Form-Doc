<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('form_monitoring_cctv_items', function (Blueprint $table) {
            $table->string('nama_titik_cctv')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('form_monitoring_cctv_items', function (Blueprint $table) {
            $table->string('nama_titik_cctv')->nullable(false)->change();
        });
    }
};
