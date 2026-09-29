<?php

namespace App\Models\FormBastik;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'form_bastik_id',
    'form_bastik_item_id',
    'file_path',
    'original_name',
    'urutan_konfirmasi'
])]
class FormBastikLampiran extends Model
{
    public function formBastik()
    {
        return $this->belongsTo(FormBastik::class, 'form_bastik_id');
    }

    public function formBastikItem()
    {
        return $this->belongsTo(FormBastikItem::class, 'form_bastik_item_id');
    }

    public function item()
    {
        return $this->belongsTo(
            FormBastikItem::class,
            'form_bastik_item_id'
        );
    }
}
