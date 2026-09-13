<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_perangkats', function (Blueprint $table) {
            $table->dropColumn('deskripsi');
        });

        Schema::table('form_pemeliharaans', function (Blueprint $table) {
            $table->dropColumn(['petugas_name', 'petugas_nipp']);
            $table->foreignId('petugas_id')->nullable()->after('catatan')->constrained('master_petugas')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_pemeliharaans', function (Blueprint $table) {
            $table->dropForeign(['petugas_id']);
            $table->dropColumn('petugas_id');
            $table->string('petugas_name')->nullable();
            $table->string('petugas_nipp', 50)->nullable();
        });

        Schema::table('master_perangkats', function (Blueprint $table) {
            $table->text('deskripsi')->nullable();
        });
    }
};
