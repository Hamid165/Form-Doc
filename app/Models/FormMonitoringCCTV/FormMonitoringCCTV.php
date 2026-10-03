<?php

namespace App\Models\FormMonitoringCCTV;

use Illuminate\Database\Eloquent\Model;
use App\Models\FormCctv\MasterSigner;

class FormMonitoringCCTV extends Model
{
    protected $table = 'form_monitoring_cctvs';

    protected $fillable = [
        'no_ref',
        'tanggal',
        'business_area',
        'bulan',
        'tgl_pelaksanaan_m1',
        'tgl_pelaksanaan_m2',
        'tgl_pelaksanaan_m3',
        'tgl_pelaksanaan_m4',
        'catatan',
        'petugas_nama',
        'petugas_nipp',
        'mengetahui_id',
        'mengetahui_tanggal',
        'petugas_tanggal',
        'status'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tgl_pelaksanaan_m1' => 'date',
        'tgl_pelaksanaan_m2' => 'date',
        'tgl_pelaksanaan_m3' => 'date',
        'tgl_pelaksanaan_m4' => 'date',
        'mengetahui_tanggal' => 'date',
        'petugas_tanggal'    => 'date',
    ];

    public function items()
    {
        return $this->hasMany(FormMonitoringCCTVItem::class, 'form_monitoring_cctv_id');
    }

    public function mengetahui()
    {
        return $this->belongsTo(MasterSigner::class, 'mengetahui_id');
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isDicetak(): bool
    {
        return $this->status === 'dicetak';
    }

    public function isSelesai(): bool
    {
        return $this->status === 'selesai';
    }
}