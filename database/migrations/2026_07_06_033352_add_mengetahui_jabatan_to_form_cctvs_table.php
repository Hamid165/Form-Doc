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
        Schema::table('form_cctvs', function (Blueprint $table) {
            $table->string('mengetahui_jabatan')->nullable()->after('mengetahui_nipp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_cctvs', function (Blueprint $table) {
            $table->dropColumn('mengetahui_jabatan');
        });
    }
};
