<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormTemplate extends Model
{
    protected $fillable = [
        'nama',
        'kategori',
        'route_name',
        'no_dokumen',
        'tanggal_dokumen',
        'versi_dokumen'
    ];
}
