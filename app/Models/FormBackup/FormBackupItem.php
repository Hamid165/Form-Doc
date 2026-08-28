<?php

namespace App\Models\FormBackup;

use Illuminate\Database\Eloquent\Model;

class FormBackupItem extends Model
{
    protected $table = 'form_backup_items';

    protected $fillable = [
        'form_backup_id',
        'no',
        'nama_informasi',
        'metode_backup',
        'periode_backup',
        'retensi',
        'status',
    ];

    public function formBackup()
    {
        return $this->belongsTo(FormBackup::class, 'form_backup_id');
    }
}