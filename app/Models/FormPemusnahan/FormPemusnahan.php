<?php

namespace App\Models\FormPemusnahan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormPemusnahan extends Model
{
    protected $table = 'form_pemusnahans';

    protected $fillable = [
        'no_ref',
        'tanggal_ref',
        'business_area',
        'tanggal_permohonan',
        'nama',
        'nip',
        'nama_nip',
        'unit_kerja',
        'tempat_persetujuan',
        'tanggal_persetujuan',
        'nama_atasan',
        'nama_pengelola',
        'keputusan',
        'nama_vp',
        'status',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(FormPemusnahanItem::class);
    }
}