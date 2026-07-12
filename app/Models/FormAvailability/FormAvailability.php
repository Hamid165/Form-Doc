<?php

namespace App\Models\FormAvailability;

use Illuminate\Database\Eloquent\Model;
use App\Models\FormCctv\MasterSigner;

class FormAvailability extends Model
{
    protected $table = 'form_availability_ticketings';

    protected $fillable = [
        'no_ref',
        'tanggal',
        'business_area',
        'daop_divre',
        'jumlah_total_station',
        'jumlah_perangkat_ticketing',
        'catatan',
        'petugas_name',
        'petugas_nipp',
        'mengetahui_id',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];


    public function items()
    {
        return $this->hasMany(
            FormAvailabilityItem::class,
            'form_availability_ticketing_id'
        );
    }


    public function mengetahui()
    {
        return $this->belongsTo(
            MasterSigner::class,
            'mengetahui_id'
        );
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


    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft'   => 'Draft',
            'dicetak' => 'Dicetak',
            'selesai' => 'Selesai',
            default   => 'Unknown',
        };
    }
}
