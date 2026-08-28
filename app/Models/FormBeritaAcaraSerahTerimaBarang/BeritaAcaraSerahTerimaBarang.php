<?php

namespace App\Models\FormBeritaAcaraSerahTerimaBarang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BeritaAcaraSerahTerimaBarang extends Model
{
    protected $guarded = ['id'];

    public function items(): HasMany
    {
        return $this->hasMany(BeritaAcaraSerahTerimaBarangItem::class, 'berita_acara_serah_terima_barang_id');
    }
}
