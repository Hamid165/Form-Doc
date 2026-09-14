<?php

namespace App\Models\FormKeluhan;

use Illuminate\Database\Eloquent\Model;

class FormKeluhanItem extends Model
{
    protected $fillable = [
        'form_keluhan_id',
        'no',
        'tanggal',
        'pelanggan',
        'sumber',
        'deskripsi_keluhan',
        'tindakan',
        'verifikasi_tgl',
        'verifikasi_pic',
        'verifikasi_hasil',
        'keterangan',
    ];

    public function formKeluhan()
    {
        return $this->belongsTo(FormKeluhan::class);
    }
}
