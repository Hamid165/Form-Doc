<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImplementationReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_peninjauan',
        'periode_peninjauan',
        'pelaksana_peninjauan',
        'lokasi_peninjauan',
        'obyek_peninjauan',
        'deskripsi_sistem',
        'analisa',
        'tindak_lanjut',
    ];
}