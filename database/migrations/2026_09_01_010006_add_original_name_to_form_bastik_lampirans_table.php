<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom nama asli file lampiran.
     */
    public function up(): void
    {
        Schema::table('form_bastik_lampirans', function (Blueprint $table) {
            $table->string('original_name', 255)
                ->nullable()
                ->after('file_path');
        });
    }

    /**
     * Menghapus kolom jika migrasi dibatalkan.
     */
    public function down(): void
    {
        Schema::table('form_bastik_lampirans', function (Blueprint $table) {
            $table->dropColumn('original_name');
        });
    }
};