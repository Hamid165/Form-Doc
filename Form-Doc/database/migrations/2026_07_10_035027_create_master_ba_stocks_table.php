<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('master_ba_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nipp')->nullable();
            $table->string('jabatan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('master_ba_stocks');
    }
};
