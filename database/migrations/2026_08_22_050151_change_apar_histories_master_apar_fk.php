<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('apar_histories', function (Blueprint $table) {
            $table->dropForeign(['master_apar_id']);

            $table->foreign('master_apar_id')
                ->references('id')
                ->on('master_apars')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('apar_histories', function (Blueprint $table) {
            $table->dropForeign(['master_apar_id']);

            $table->foreign('master_apar_id')
                ->references('id')
                ->on('master_apars')
                ->cascadeOnDelete();
        });
    }
};