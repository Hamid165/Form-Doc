<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_apars', function (Blueprint $table) {
            $table->string('status')->default('Aktif')->after('vendor_id');
        });

        Schema::table('apar_histories', function (Blueprint $table) {
            $table->string('jenis_perubahan')->nullable()->after('master_apar_id');
            $table->string('data_lama')->nullable()->after('jenis_perubahan');
            $table->string('data_baru')->nullable()->after('data_lama');
        });
    }

    public function down(): void
    {
        Schema::table('master_apars', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('apar_histories', function (Blueprint $table) {
            $table->dropColumn(['jenis_perubahan', 'data_lama', 'data_baru']);
        });
    }
};
