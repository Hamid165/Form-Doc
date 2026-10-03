<?php

namespace App\Models\FormPemeliharaanAc;

use Illuminate\Database\Eloquent\Model;

class FormPemeliharaanAcItem extends Model
{
    protected $table = 'form_pemeliharaan_ac_items';

    protected $fillable = [
        'form_pemeliharaan_ac_id',
        'no',
        'tanggal',
        'jenis_kegiatan',
        'keterangan',
        'paraf',
    ];

    public function formPemeliharaanAc()
    {
        return $this->belongsTo(FormPemeliharaanAc::class);
    }

    public function getTanggalAttribute($value)
    {
        if ($value && preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            $months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            $date = \Carbon\Carbon::parse($value);
            return sprintf('%02d %s %04d', $date->day, $months[$date->month - 1], $date->year);
        }
        return $value;
    }
}
