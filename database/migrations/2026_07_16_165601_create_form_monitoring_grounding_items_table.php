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
        Schema::create('form_monitoring_grounding_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_monitoring_grounding_id');
            $table->foreign('form_monitoring_grounding_id', 'fk_grounding_items_grounding_id')
                  ->references('id')->on('form_monitoring_groundings')->onDelete('cascade');
            $table->integer('no')->default(0);
            $table->string('lokasi_grounding')->nullable();
            $table->string('nilai_grounding_standard')->nullable()->default('≤ 1 OHM');
            $table->string('hasil_pengukuran')->nullable();
            $table->string('kondisi_bak_grounding')->nullable();
            $table->text('tindak_lanjut')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_monitoring_grounding_items');
    }
};
