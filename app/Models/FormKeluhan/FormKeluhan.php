<?php

namespace App\Models\FormKeluhan;

use Illuminate\Database\Eloquent\Model;

class FormKeluhan extends Model
{
    protected $fillable = [
        'no_ref',
        'tanggal',
        'kota_tanggal',
        'pelaksana_nama',
        'pelaksana_nipp',
        'mengetahui_jabatan',
        'mengetahui_nama',
        'mengetahui_nipp',
    ];

    public function items()
    {
        return $this->hasMany(FormKeluhanItem::class);
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
