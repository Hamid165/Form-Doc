<?php

namespace App\Models\FormApar;

use Illuminate\Database\Eloquent\Model;

class MasterSigner extends Model
{
    protected $table = 'master_signers';
    protected $fillable = ['nama', 'nipp', 'jabatan'];
}
