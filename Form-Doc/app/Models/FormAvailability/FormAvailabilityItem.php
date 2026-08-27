<?php

namespace App\Models\FormAvailability;

use Illuminate\Database\Eloquent\Model;

class FormAvailabilityItem extends Model
{
    protected $table = 'form_availability_ticketing_items';

    protected $fillable = [
        'form_availability_ticketing_id',
        'nomor',
        'station',
        'rts_pts_ng',
        'jumlah_perangkat_ticketing',
        'jumlah_gangguan',
        'lama_gangguan',
        'keterangan',
    ];

    public function formAvailability()
    {
        return $this->belongsTo(
            FormAvailability::class,
            'form_availability_ticketing_id'
        );
    }
}
