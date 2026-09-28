<?php

namespace App\Models\FormPengujianInfrastruktur;

use Illuminate\Database\Eloquent\Model;

class FormPengujianInfrastrukturItem extends Model
{
    protected $fillable = [
        'form_pengujian_infrastruktur_id',
        'no',
        'rencana_pengujian',
        'hasil',
        'keterangan',
    ];

    public function formPengujianInfrastruktur()
    {
        return $this->belongsTo(FormPengujianInfrastruktur::class);
    }
}
