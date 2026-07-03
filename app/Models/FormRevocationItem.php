<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormRevocationItem extends Model
{
    protected $fillable = [
        'form_revocation_id',
        'no',
        'nama_pengguna',
        'jenis_akun',
        'unit_kerja',
        'alasan',
    ];

    public function formRevocation()
    {
        return $this->belongsTo(FormRevocation::class);
    }
}
