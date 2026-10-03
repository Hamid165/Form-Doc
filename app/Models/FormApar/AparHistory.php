<?php

namespace App\Models\FormApar;

use Illuminate\Database\Eloquent\Model;

class AparHistory extends Model
{
    protected $table = 'apar_histories';

    protected $fillable = [
        'master_apar_id',
        'jenis_perubahan',
        'data_lama',
        'data_baru',
        'kode_aset_lama',
        'kode_aset_baru',
        'tanggal_perubahan',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_perubahan' => 'date',
    ];

    public function masterApar()
    {
        return $this->belongsTo(MasterApar::class, 'master_apar_id');
    }
}
