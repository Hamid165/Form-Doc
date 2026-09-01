<?php

namespace App\Models\FormPemeliharaanAc;

use Illuminate\Database\Eloquent\Model;

class MasterAc extends Model
{
    protected $fillable = ['id_ac', 'lokasi', 'sub_lokasi', 'jenis', 'merk', 'kapasitas', 'tahun_pasang'];
}
