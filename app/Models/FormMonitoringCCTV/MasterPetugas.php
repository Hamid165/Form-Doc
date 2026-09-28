<?php

namespace App\Models\FormMonitoringCCTV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPetugas extends Model
{
    use HasFactory;

    protected $table = 'master_petugas';
    protected $fillable = ['nama', 'nipp'];
}