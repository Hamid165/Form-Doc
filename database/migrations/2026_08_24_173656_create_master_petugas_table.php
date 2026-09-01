<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
    Schema::create('master_petugas', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('nipp');
        $table->timestamps();
        });
    }
};
