<?php

namespace App\Models\FormBeritaAcaraSerahTerimaBarang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BeritaAcaraSerahTerimaBarangItem extends Model
{
    protected $guarded = ['id'];

    public function beritaAcaraSerahTerimaBarang(): BelongsTo
    {
        return $this->belongsTo(BeritaAcaraSerahTerimaBarang::class, 'berita_acara_serah_terima_barang_id');
    }
}
