<?php

namespace App\Models\FormCctv;

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
        'mengetahui_jabatan',
    ];

    public function items()
    {
        return $this->hasMany(FormCctvItem::class);
    }

    public function setTanggalAttribute($value)
    {
        if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $value)) {
            $this->attributes['tanggal'] = \Carbon\Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
        } else {
            $this->attributes['tanggal'] = $value;
        }
    }

    public function getTanggalAttribute($value)
    {
        if ($value && preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return \Carbon\Carbon::parse($value)->format('d-m-Y');
        }
        return $value;
    }
}
