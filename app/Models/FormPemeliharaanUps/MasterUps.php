<?php

namespace App\Models\FormPemeliharaanUps;

use Illuminate\Database\Eloquent\Model;

class MasterUps extends Model
{
    protected $table = 'master_ups';
    protected $fillable = ['nomor_inventaris', 'lokasi'];
}
