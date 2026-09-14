<?php

namespace App\Models\FormChecklistPc;

use Illuminate\Database\Eloquent\Model;

class FormChecklistPcItem extends Model
{
    protected $fillable = [
        'form_checklist_pc_id',
        'nama_aset',
        'id_aset',
        'nipp',
        'checklist',
        'paraf',
    ];

    protected $casts = [
        'checklist' => 'array',
    ];

    public function formChecklistPc()
    {
        return $this->belongsTo(FormChecklistPc::class);
    }
}