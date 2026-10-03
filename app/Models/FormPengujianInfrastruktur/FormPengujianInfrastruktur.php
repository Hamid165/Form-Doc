<?php

namespace App\Models\FormPengujianInfrastruktur;

use Illuminate\Database\Eloquent\Model;
use App\Models\FormCctv\MasterSigner;

class FormPengujianInfrastruktur extends Model
{
    protected $fillable = [
        'no_ref',
        'tanggal',
        'business_area',
        'tanggal_pengujian',
        'objek_pengujian',
        'pelaksana_pengujian',
        'pelaksana_nipp',
        'deskripsi_pengujian',
        'analisa_kesimpulan',
        'kota_tanggal',
        'mengetahui_nama',
        'mengetahui_jabatan',
        'mengetahui_id',
    ];

    public function items()
    {
        return $this->hasMany(FormPengujianInfrastrukturItem::class);
    }

    public function mengetahui()
    {
        return $this->belongsTo(MasterSigner::class, 'mengetahui_id');
    }

    public function setTanggalAttribute($value)
    {
        $this->attributes['tanggal'] = $this->normalizeDate($value);
    }

    public function getTanggalAttribute($value)
    {
        return $this->displayDate($value);
    }

    public function setTanggalPengujianAttribute($value)
    {
        $this->attributes['tanggal_pengujian'] = $this->normalizeDate($value);
    }

    public function getTanggalPengujianAttribute($value)
    {
        return $this->displayDate($value);
    }

    private function normalizeDate($value)
    {
        if (empty($value)) {
            return null;
        }
        if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $value)) {
            return \Carbon\Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
        }
        return $value;
    }

    private function displayDate($value)
    {
        if ($value && preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return \Carbon\Carbon::parse($value)->format('d-m-Y');
        }
        return $value;
    }
}
