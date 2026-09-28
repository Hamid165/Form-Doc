<?php

namespace App\Models\FormLogPeminjaman;

use Illuminate\Database\Eloquent\Model;

class FormLogPeminjamanDetail extends Model
{
    protected $table = 'form_log_peminjaman_details';
    protected $guarded = ['id'];

    public function form()
    {
        return $this->belongsTo(FormLogPeminjaman::class, 'form_id');
    }
}
