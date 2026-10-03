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
        Schema::table('form_availability_ticketing_items', function (Blueprint $table) {

            $table->integer('lama_gangguan')
                  ->default(0)
                  ->after('jumlah_gangguan');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_availability_ticketing_items', function (Blueprint $table) {

            $table->dropColumn('lama_gangguan');

        });
    }
};
