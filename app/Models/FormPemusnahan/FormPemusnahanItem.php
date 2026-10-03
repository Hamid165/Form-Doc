<?php

namespace App\Models\FormPemusnahan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormPemusnahanItem extends Model
{
    protected $table = 'form_pemusnahan_items';

    protected $fillable = [
        'form_pemusnahan_id',
        'nama_aset',
        'jenis_aset',
        'id_aset',
        'alasan_pemusnahan',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(FormPemusnahan::class);
    }
}