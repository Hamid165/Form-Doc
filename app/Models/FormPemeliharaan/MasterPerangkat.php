<?php

namespace App\Models\FormPemeliharaan;

use Illuminate\Database\Eloquent\Model;

class MasterPerangkat extends Model
{
    protected $fillable = ['kode_aset', 'lokasi', 'jenis_perangkat'];

    public function items()
    {
        return $this->hasMany(FormPemeliharaanItem::class);
    }
}
