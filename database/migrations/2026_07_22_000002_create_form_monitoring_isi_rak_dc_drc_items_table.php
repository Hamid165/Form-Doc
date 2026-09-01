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
        Schema::dropIfExists('form_monitoring_isi_rak_dc_drc_items');
        Schema::create('form_monitoring_isi_rak_dc_drc_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_monitoring_isi_rak_dc_drc_id')
                  ->constrained('form_monitoring_isi_rak_dc_drcs', 'id', 'fk_rak_items_rak_id')
                  ->onDelete('cascade');
            
            $table->integer('no')->nullable();
            $table->string('cable')->nullable();
            $table->string('pp')->nullable();
            $table->string('id_machine')->nullable();
            $table->string('id_server_name_server')->nullable();
            $table->string('pic')->nullable();
            $table->string('nic')->nullable();
            $table->string('power_a')->nullable();
            $table->string('weight_kg')->nullable();
            $table->string('capacity_storage_gb')->nullable();
            $table->string('capacity_memory_gb')->nullable();
            $table->string('ip_address_local')->nullable();
            $table->string('ip_address_public')->nullable();
            $table->string('status')->nullable();
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_monitoring_isi_rak_dc_drc_items');
    }
};
