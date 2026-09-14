<?php

namespace App\Models\FormPcLaptopChecking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormPcLaptopChecking extends Model
{
    use HasFactory;

    protected $table = 'form_pc_laptop_checkings';

    protected $fillable = [
        'no_ref',
        'tanggal',
        'business_area',
        'periode_pemeriksaan',
        'tanggal_pemeriksaan',
        'catatan',
        'mengetahui_nama',
        'mengetahui_nipp',
        'mengetahui_jabatan',
    ];

    public function items()
    {
        return $this->hasMany(FormPcLaptopCheckingItem::class, 'form_pc_laptop_checking_id');
    }

    public function setTanggalAttribute($value)
    {
        if ($value && preg_match('/^\d{2}-\d{2}-\d{4}$/', $value)) {
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
