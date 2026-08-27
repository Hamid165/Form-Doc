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
        Schema::table('form_revocations', function (Blueprint $table) {
            $table->string('nip_pemohon')->nullable()->after('nama_pemohon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_revocations', function (Blueprint $table) {
            $table->dropColumn('nip_pemohon');
        });
    }
};
