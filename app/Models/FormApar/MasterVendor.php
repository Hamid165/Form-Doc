<?php

namespace App\Models\FormApar;

use Illuminate\Database\Eloquent\Model;

class MasterVendor extends Model
{
    protected $table = 'master_vendors';

    protected $fillable = [
        'nama_vendor',
        'alamat',
        'nomor_telepon',
        'no_rekomendasi_damkar',
    ];

    public function apars()
    {
        return $this->hasMany(MasterApar::class, 'vendor_id');
    }
}
