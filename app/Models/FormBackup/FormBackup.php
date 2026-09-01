<?php

namespace App\Models\FormBackup;

use Illuminate\Database\Eloquent\Model;

class FormBackup extends Model
{
    protected $table = 'form_backups';

    protected $fillable = [
        'no_ref',
        'tanggal',
        'business_area',
        'doc_nomor',
        'doc_tanggal',
        'doc_versi',
        'kota_tanggal',
        'mengetahui_nama',
        'mengetahui_nipp',
        'mengetahui_jabatan',
    ];

    public function items()
    {
        return $this->hasMany(FormBackupItem::class, 'form_backup_id');
    }

    // Mutator agar input format d-m-Y otomatis tersimpan Y-m-d ke MySQL
    public function setTanggalAttribute($value)
    {
        if (preg_match('/^\\d{2}-\\d{2}-\\d{4}$/', $value)) {
            $this->attributes['tanggal'] = \Carbon\Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
        } else {
            $this->attributes['tanggal'] = $value;
        }
    }

    public function getTanggalAttribute($value)
    {
        if ($value && preg_match('/^\\d{4}-\\d{2}-\\d{2}$/', $value)) {
            return \Carbon\Carbon::parse($value)->format('d-m-Y');
        }
        return $value;
    }
}