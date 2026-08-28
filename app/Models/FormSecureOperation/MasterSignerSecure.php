<?php

namespace App\Models\FormSecureOperation;

use Illuminate\Database\Eloquent\Model;

class MasterSignerSecure extends Model
{
    // Nama tabel di database tetap sama
    protected $table = 'master_signer_secure_operations';

    protected $fillable = [
        'nama',
        'nipp',
        'jabatan',
    ];
}