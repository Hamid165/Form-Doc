<?php

namespace App\Models\FormPemeliharaanUps;

use Illuminate\Database\Eloquent\Model;

class FormPemeliharaanUpsItem extends Model
{
    protected $table = 'form_pemeliharaan_ups_items';

    protected $fillable = [
        'form_pemeliharaan_ups_id',
        'no',
        'tanggal',
        'jenis_kegiatan',
        'keterangan',
        'paraf',
    ];

    public function formUps()
    {
        return $this->belongsTo(FormPemeliharaanUps::class, 'form_pemeliharaan_ups_id');
    }
}
