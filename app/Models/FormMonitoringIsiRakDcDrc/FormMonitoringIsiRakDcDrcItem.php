<?php

namespace App\Models\FormMonitoringIsiRakDcDrc;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormMonitoringIsiRakDcDrcItem extends Model
{
    protected $table = 'form_monitoring_isi_rak_dc_drc_items';

    protected $guarded = ['id'];

    public function monitoring(): BelongsTo
    {
        return $this->belongsTo(FormMonitoringIsiRakDcDrc::class, 'form_monitoring_isi_rak_dc_drc_id');
    }
}
