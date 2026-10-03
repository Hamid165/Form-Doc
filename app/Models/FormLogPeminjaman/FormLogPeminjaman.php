<?php

namespace App\Models\FormLogPeminjaman;

use Illuminate\Database\Eloquent\Model;

class FormLogPeminjaman extends Model
{
    protected $table = 'form_log_peminjaman';
    protected $guarded = ['id'];

    public function details()
    {
        return $this->hasMany(FormLogPeminjamanDetail::class, 'form_id');
    }
}
