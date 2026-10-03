<?php

namespace App\Models\FormSerahTerimaUser;

use Illuminate\Database\Eloquent\Model;

class MasterSerahTerimaUser extends Model
{
    protected $table = 'master_serah_terima_users';
    
    protected $fillable = [
        'nama',
        'nipp',
        'jabatan',
        'tempat_kedudukan',
        'personal_area'
    ];
}
