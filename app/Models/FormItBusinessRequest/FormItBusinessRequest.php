<?php

namespace App\Models\FormItBusinessRequest;

use Illuminate\Database\Eloquent\Model;

class FormItBusinessRequest extends Model
{
    protected $fillable = [
        'no_ref',
        'tanggal',
        'jabatan',
        'klasifikasi_permintaan',
        'catatan_persetujuan',
        'catatan_kondisi',
        'distribusi_salinan',
        
        'deskripsi_umum',
        'latar_belakang',
        'tujuan',
        'target_waktu',
        'pihak_terkait_internal',
        
        'kategori_layanan',
        'layanan_yang_dibutuhkan',
        
        'pemohon_nama',
        'pemohon_nipp',
        'pemohon_jabatan',
        
        'penerima_nama',
        'penerima_nipp',
        'penerima_jabatan',
        
        'pimpinan_nama',
        'pimpinan_nipp',
        'pimpinan_jabatan',

        'vp_nama',
        'vp_nipp',
        'vp_jabatan',
    ];

    protected $casts = [
        'kategori_layanan' => 'array',
    ];

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
