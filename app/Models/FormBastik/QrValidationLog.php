<?php

namespace App\Models\FormBastik;

use Illuminate\Database\Eloquent\Model;

class QrValidationLog extends Model
{
    protected $table = 'qr_validation_logs';

    protected $fillable = [
        'form_bastik_id',
        'ip_address',
        'user_agent',
    ];

    public function formBastik()
    {
        return $this->belongsTo(FormBastik::class, 'form_bastik_id');
    }
}
