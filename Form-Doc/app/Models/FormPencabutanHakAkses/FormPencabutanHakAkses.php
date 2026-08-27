<?php

namespace App\Models\FormPencabutanHakAkses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormPencabutanHakAkses extends Model
{
    use HasFactory;

    protected $table = 'form_revocations';

    protected $fillable = [
        'no_ref',
        'tanggal',
        'business_area',
        'tanggal_permohonan',
        'nama_pemohon',
        'nip_pemohon',
        'bagian_fungsi',
        'kota_tanggal_pemohon',
        'status_persetujuan',
        'kota_tanggal_setuju',
        'mengetahui_nama',
        'jabatan_mengetahui',
    ];

    public function items()
    {
        return $this->hasMany(FormPencabutanHakAksesItem::class, 'form_revocation_id');
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

    public function setTanggalPermohonanAttribute($value)
    {
        if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $value)) {
            $this->attributes['tanggal_permohonan'] = \Carbon\Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
        } else {
            $this->attributes['tanggal_permohonan'] = $value;
        }
    }

    public function getTanggalPermohonanAttribute($value)
    {
        if ($value && preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return \Carbon\Carbon::parse($value)->format('d-m-Y');
        }
        return $value;
    }
}
