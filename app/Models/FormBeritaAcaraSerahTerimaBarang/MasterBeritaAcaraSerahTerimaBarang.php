<?php

namespace App\Models\FormBeritaAcaraSerahTerimaBarang;

use Illuminate\Database\Eloquent\Model;

class MasterBeritaAcaraSerahTerimaBarang extends Model
{
    protected $table = 'master_berita_acara_serah_terima_barangs';

    protected $fillable = [
        'nama',
        'nipp',
        'jabatan'
    ];
}
