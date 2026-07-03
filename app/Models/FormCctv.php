<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormCctv extends Model
{
    protected $fillable = [
        'no_ref',
        'tanggal',
        'business_area',
        'id_cctv',
        'lokasi',
        'kota_tanggal',
        'mengetahui_nama',
        'mengetahui_nipp',
    ];

    public function items()
    {
        return $this->hasMany(FormCctvItem::class);
    }
}
