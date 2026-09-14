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
        Schema::table('ba_it_services', function (Blueprint $table) {
            // Menambahkan kolom status_terima setelah kolom ttd_user_nipp
            $table->string('status_terima')->default('Diterima')->nullable()->after('ttd_user_nipp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ba_it_services', function (Blueprint $table) {
            $table->dropColumn('status_terima');
        });
    }
};