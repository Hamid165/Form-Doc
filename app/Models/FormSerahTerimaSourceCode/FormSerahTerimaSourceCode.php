<?php

namespace App\Models\FormSerahTerimaSourceCode;

use Illuminate\Database\Eloquent\Model;

class FormSerahTerimaSourceCode extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_serah_terima' => 'date',
        'tanggal_terbit' => 'date',
        'tanggal' => 'date',
        'jenis_serah_terima' => 'array',
    ];
}
