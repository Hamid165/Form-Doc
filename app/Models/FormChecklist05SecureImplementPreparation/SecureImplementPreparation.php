<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecureImplementPreparation extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_ref',
        'tanggal',
        'business_area',
        'nama_aplikasi',
        'tanggal_checklist',
        'deskripsi',
        'versi_aplikasi',
        'modul',
        'fungsi',
        'check_tsd',
        'check_user_manual',
        'tempat',
        'tanggal_ttd',
        'mengetahui_nama',
        'mengetahui_nipp',
        'pelaksana_nama',
        'pelaksana_nipp',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_checklist' => 'date',
        'tanggal_ttd' => 'date',
    ];
}