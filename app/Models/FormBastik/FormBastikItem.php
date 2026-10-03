<?php

namespace App\Models\FormBastik;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'form_bastik_id',
    'urutan_baris',
    'no_tiket',
    'detail_tiket',
    'user_pemohon',
    'nipp',
    'unit'
])]
class FormBastikItem extends Model
{
    public function formBastik()
    {
        return $this->belongsTo(FormBastik::class, 'form_bastik_id');
    }

    public function lampirans()
    {
        return $this->hasMany(FormBastikLampiran::class, 'form_bastik_item_id');
    }
}
