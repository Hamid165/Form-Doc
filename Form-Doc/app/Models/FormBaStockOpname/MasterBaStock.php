<?php

namespace App\Models\FormBaStockOpname;

use Illuminate\Database\Eloquent\Model;

class MasterBaStock extends Model
{
    protected $table = 'master_ba_stocks';

    protected $fillable = [
        'nama',
        'nipp',
        'jabatan'
    ];
}
