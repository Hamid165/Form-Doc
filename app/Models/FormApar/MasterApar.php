<?php

namespace App\Models\FormApar;

use Illuminate\Database\Eloquent\Model;

class MasterApar extends Model
{
    protected $table = 'master_apars';

    protected $fillable = [
        'kode_aset',
        'merk',
        'tipe',
        'seri',
        'media',
        'jenis',
        'kapasitas',
        'lokasi',
        'sub_lokasi',
        'tanggal_isi_ulang',
        'tanggal_kadaluarsa',
        'vendor_id',
        'status',
    ];

    protected $casts = [
        'tanggal_isi_ulang' => 'date',
        'tanggal_kadaluarsa' => 'date',
    ];

    public function vendor()
    {
        return $this->belongsTo(MasterVendor::class, 'vendor_id');
    }

    public function histories()
    {
        return $this->hasMany(AparHistory::class, 'master_apar_id');
    }
}
