<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(
            'form_availability_ticketings',
            function (Blueprint $table) {
                $table->string(
                    'mengetahui_nama_override',
                    255
                )
                    ->nullable()
                    ->after('mengetahui_nipp_override');
            }
        );
    }

    public function down(): void
    {
        Schema::table(
            'form_availability_ticketings',
            function (Blueprint $table) {
                $table->dropColumn(
                    'mengetahui_nama_override'
                );
            }
        );
    }
};
