<?php

namespace App\Models\FormPemeliharaan;

use Illuminate\Database\Eloquent\Model;

class MasterSigner extends Model
{
    protected $table = 'form_pemeliharaan_master_signers';
    protected $fillable = ['nama', 'nipp', 'jabatan'];
}
