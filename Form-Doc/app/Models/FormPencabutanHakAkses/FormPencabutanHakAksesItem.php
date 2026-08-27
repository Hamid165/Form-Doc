<?php

namespace App\Models\FormPencabutanHakAkses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormPencabutanHakAksesItem extends Model
{
    use HasFactory;

    protected $table = 'form_revocation_items';

    protected $fillable = [
        'form_revocation_id',
        'no',
        'nama_pengguna',
        'jenis_akun',
        'unit_kerja',
        'alasan',
    ];

    public function formPencabutanHakAkses()
    {
        return $this->belongsTo(FormPencabutanHakAkses::class, 'form_revocation_id');
    }
}
