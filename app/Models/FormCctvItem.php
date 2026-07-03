<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormCctvItem extends Model
{
    protected $fillable = [
        'form_cctv_id',
        'no',
        'tanggal',
        'jenis_kegiatan',
        'keterangan',
        'paraf',
    ];

    public function formCctv()
    {
        return $this->belongsTo(FormCctv::class);
    }
}
