<?php

namespace App\Models\FormMonitoringIsiRakDcDrc;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormMonitoringIsiRakDcDrc extends Model
{
    protected $table = 'form_monitoring_isi_rak_dc_drcs';

    protected $guarded = ['id'];

    public function items(): HasMany
    {
        return $this->hasMany(FormMonitoringIsiRakDcDrcItem::class, 'form_monitoring_isi_rak_dc_drc_id')->orderBy('no', 'asc');
    }
}
