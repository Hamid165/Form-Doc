<?php

namespace App\Models\FormPemeliharaan;

use Illuminate\Database\Eloquent\Model;
use App\Models\FormCctv\MasterSigner;

class FormPemeliharaan extends Model
{
    protected $fillable = [
        'no_ref',
        'tanggal',
        'business_area',
        'lokasi',
        'jenis_pemeliharaan',
        'bulan_pemeliharaan',
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
        return $this->hasMany(FormPemeliharaanItem::class);
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

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'draft'   => 'bg-yellow-100 text-yellow-800',
            'dicetak' => 'bg-blue-100 text-blue-800',
            'selesai' => 'bg-green-100 text-green-800',
            default   => 'bg-gray-100 text-gray-800',
        };
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
