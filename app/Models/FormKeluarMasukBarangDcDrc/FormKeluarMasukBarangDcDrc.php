<?php

namespace App\Models\FormKeluarMasukBarangDcDrc;

use Illuminate\Database\Eloquent\Model;

class FormKeluarMasukBarangDcDrc extends Model
{
    protected $table = 'form_barangs';

    protected $fillable = [
        'no_ref',
        'tanggal',
        'business_area',
        'jenis',
        'tanggal_masuk',
        'jam_masuk',
        'nama_pemohon',
        'nomor_identitas',
        'alamat',
        'nomor_telepon',
        'perusahaan_unit',
        'kota_ttd',
        'jabatan_pelaksana',
        'nama_pelaksana',
        'nipp_pelaksana',
        'jabatan_mengetahui',
        'nama_mengetahui',
        'nipp_mengetahui',
        'created_by',
    ];

    public function items()
    {
        return $this->hasMany(FormKeluarMasukBarangDcDrcItem::class, 'form_barang_id');
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    // Date accessor/mutator (dd-mm-yyyy display, Y-m-d storage)
    public function setTanggalAttribute($value)
    {
        if ($value && preg_match('/^\d{2}-\d{2}-\d{4}$/', $value)) {
            $this->attributes['tanggal'] = \Carbon\Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
        } else {
            $this->attributes['tanggal'] = $value;
        }
    }

    public function getTanggalAttribute($value)
    {
        if ($value && preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return \Carbon\Carbon::parse($value)->format('d-m-Y');
        }
        return $value;
    }

    public function setTanggalMasukAttribute($value)
    {
        if ($value && preg_match('/^\d{2}-\d{2}-\d{4}$/', $value)) {
            $this->attributes['tanggal_masuk'] = \Carbon\Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
        } else {
            $this->attributes['tanggal_masuk'] = $value;
        }
    }

    public function getTanggalMasukAttribute($value)
    {
        if ($value && preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return \Carbon\Carbon::parse($value)->format('d-m-Y');
        }
        return $value;
    }

    /**
     * Generate no_ref otomatis: KMB/YYYYMM/XXXX
     */
    public static function generateNoRef()
    {
        $prefix = 'KMB/' . date('Ym') . '/';
        $last = self::where('no_ref', 'like', $prefix . '%')
            ->orderByRaw('CAST(SUBSTRING(no_ref, -4) AS UNSIGNED) DESC')
            ->first();

        $next = $last ? intval(substr($last->no_ref, -4)) + 1 : 1;
        return $prefix . str_pad($next, 4, '0', STR_PAD_LEFT);
    }
}
