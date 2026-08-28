<?php

namespace App\Models\FormMonitoringGrounding;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormMonitoringGroundingItem extends Model
{
    use HasFactory;

    protected $table = 'form_monitoring_grounding_items';

    protected $fillable = [
        'form_monitoring_grounding_id',
        'no',
        'lokasi_grounding',
        'nilai_grounding_standard',
        'hasil_pengukuran',
        'kondisi_bak_grounding',
        'tindak_lanjut',
    ];

    public function formMonitoringGrounding()
    {
        return $this->belongsTo(FormMonitoringGrounding::class, 'form_monitoring_grounding_id');
    }
}
