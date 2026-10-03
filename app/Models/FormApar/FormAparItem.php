<?php

namespace App\Models\FormApar;

use Illuminate\Database\Eloquent\Model;

class FormAparItem extends Model
{
    protected $fillable = [
        'form_apar_id',
        'master_apar_id',
        'waktu_pengecekan_tgl',
        'waktu_pengecekan_jam',
        'indikator_tekanan',
        'perlakuan_fisik',
        'tindak_lanjut',
        'paraf',
    ];

    protected $casts = [
        'waktu_pengecekan_tgl' => 'date',
    ];

    public function form()
    {
        return $this->belongsTo(FormApar::class, 'form_apar_id');
    }

    public function apar()
    {
        return $this->belongsTo(MasterApar::class, 'master_apar_id');
    }
}
