<?php

namespace App\Models\FormBastik;

use Illuminate\Database\Eloquent\Model;

class NomorSuratCounter extends Model
{
    protected $table = 'nomor_surat_counters';

    protected $fillable = [
        'tahun',
        'bulan',
        'kode_jenis_surat',
        'kode_unit',
        'last_number',
    ];
}
