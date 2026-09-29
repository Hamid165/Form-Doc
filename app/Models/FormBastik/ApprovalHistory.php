<?php

namespace App\Models\FormBastik;

use Illuminate\Database\Eloquent\Model;

class ApprovalHistory extends Model
{
    protected $table = 'approval_histories';

    protected $fillable = [
        'form_bastik_id',
        'user_id',
        'action',
        'from_status',
        'to_status',
        'note',
    ];

    public function formBastik()
    {
        return $this->belongsTo(FormBastik::class, 'form_bastik_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
