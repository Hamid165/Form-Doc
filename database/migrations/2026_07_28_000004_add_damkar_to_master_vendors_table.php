<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_vendors', function (Blueprint $table) {
            $table->string('no_rekomendasi_damkar')->nullable()->after('nomor_telepon');
        });
    }

    public function down(): void
    {
        Schema::table('master_vendors', function (Blueprint $table) {
            $table->dropColumn('no_rekomendasi_damkar');
        });
    }
};
