<?php

namespace App\Models\FormMonitoringCCTV;

use Illuminate\Database\Eloquent\Model;

class FormMonitoringCCTVItem extends Model
{
    protected $table = 'form_monitoring_cctv_items';

    protected $fillable = [
        'form_monitoring_cctv_id',
        'nomor',
        'nama_titik_cctv',
        'm1_berfungsi',
        'm1_terbackup',
        'm2_berfungsi',
        'm2_terbackup',
        'm3_berfungsi',
        'm3_terbackup',
        'm4_berfungsi',
        'm4_terbackup',
        'note'
    ];

    public function formMonitoringCCTV()
    {
        return $this->belongsTo(FormMonitoringCCTV::class, 'form_monitoring_cctv_id');
    }
}