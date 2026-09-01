<?php

namespace App\Models\FormPemeliharaan;

use Illuminate\Database\Eloquent\Model;

class FormPemeliharaanItem extends Model
{
    protected $fillable = [
        'form_pemeliharaan_id',
        'master_perangkat_id',
        'deskripsi',
        'pekerjaan',
        'permasalahan',
        'solusi',
        'keterangan',
    ];

    public function formPemeliharaan()
    {
        return $this->belongsTo(FormPemeliharaan::class);
    }

    public function perangkat()
    {
        return $this->belongsTo(MasterPerangkat::class, 'master_perangkat_id');
    }
}
