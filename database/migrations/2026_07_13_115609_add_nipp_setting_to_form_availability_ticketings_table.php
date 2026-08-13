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
                /*
                 * master:
                 * memakai NIPP dari master_signers.
                 *
                 * custom:
                 * memakai NIPP khusus laporan.
                 *
                 * hidden:
                 * NIPP tidak ditampilkan.
                 */
                $table->string(
                    'mengetahui_nipp_mode',
                    20
                )
                    ->default('master')
                    ->after('mengetahui_id');

                $table->string(
                    'mengetahui_nipp_override',
                    50
                )
                    ->nullable()
                    ->after('mengetahui_nipp_mode');
            }
        );
    }

    public function down(): void
    {
        Schema::table(
            'form_availability_ticketings',
            function (Blueprint $table) {
                $table->dropColumn([
                    'mengetahui_nipp_mode',
                    'mengetahui_nipp_override',
                ]);
            }
        );
    }
};
