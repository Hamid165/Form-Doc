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
        Schema::table('form_pengujian_infrastrukturs', function (Blueprint $table) {
            $table->string('pelaksana_nipp')->nullable()->after('pelaksana_pengujian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_pengujian_infrastrukturs', function (Blueprint $table) {
            $table->dropColumn('pelaksana_nipp');
        });
    }
};
