<?php

namespace App\Models\FormPencabutanHakAkses;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterPemohon extends Model
{
    use HasFactory;
    
    protected $fillable = ['nama_pemohon', 'nip_pemohon'];
}
