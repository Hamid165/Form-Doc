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
        Schema::table('master_ups', function (Blueprint $table) {
            $table->renameColumn('no_id', 'nomor_inventaris');
        });

        Schema::table('form_pemeliharaan_ups', function (Blueprint $table) {
            $table->renameColumn('no_id', 'nomor_inventaris');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_ups', function (Blueprint $table) {
            $table->renameColumn('nomor_inventaris', 'no_id');
        });

        Schema::table('form_pemeliharaan_ups', function (Blueprint $table) {
            $table->renameColumn('nomor_inventaris', 'no_id');
        });
    }
};
