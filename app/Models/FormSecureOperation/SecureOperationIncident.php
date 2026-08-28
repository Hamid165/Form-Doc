<?php

namespace App\Models\FormSecureOperation;

use Illuminate\Database\Eloquent\Model;

class SecureOperationIncident extends Model
{
    protected $table = 'secure_operation_incidents';

    protected $fillable = [
        'no_ref',
        'tanggal_ref',
        'business_area',
        'nama_aplikasi',
        'tanggal_checklist',
        'deskripsi',
        'versi_aplikasi',
        'modul',
        'fungsi',
        'incident_high_dilaporkan',
        'incident_masuk_tiket',
        'incident_tiket_closed',
        'va_dilakukan',
        'jadwal_pentest',
        'mengetahui_id',
        'pelaksana_id',
        'tempat_ttd',   
        'tanggal_ttd',
    ];

    // Relasi ke Master Signer (Mengetahui)
    public function mengetahui()
    {
        return $this->belongsTo(MasterSignerSecure::class, 'mengetahui_id');
    }

    // Relasi ke Master Signer (Pelaksana)
    public function pelaksana()
    {
        return $this->belongsTo(MasterSignerSecure::class, 'pelaksana_id');
    }
}