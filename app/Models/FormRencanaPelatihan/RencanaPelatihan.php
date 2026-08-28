<?php

namespace App\Models\FormRencanaPelatihan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaPelatihan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'penyusun' => 'array',
        'riwayat_perubahan' => 'array',
        'analisa_kebutuhan' => 'array',
    ];
}
