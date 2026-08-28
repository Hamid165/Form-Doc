<?php

namespace App\Models\FormKeluarMasukBarangDcDrc;

use Illuminate\Database\Eloquent\Model;

class FormKeluarMasukBarangDcDrcItem extends Model
{
    protected $table = 'form_barang_items';

    protected $fillable = [
        'form_barang_id',
        'master_perangkat_id',
        'no_urut',
        'nama_jenis_aset',
        'part_no',
        'jumlah',
        'satuan',
        'merk_type',
        'kategori_aset',
        'lokasi_penyimpanan',
        'owner',
        'power_a',
        'berat_kg',
        'ukuran_u',
        'jenis_hw_sw',
        'kondisi_baru_bekas',
        'kondisi_baik_rusak',
        'keterangan',
    ];

    protected $casts = [
        'berat_kg' => 'decimal:2',
    ];

    public function FormKeluarMasukBarangDcDrc()
    {
        return $this->belongsTo(FormKeluarMasukBarangDcDrc::class, 'form_barang_id');
    }

    public function masterPerangkat()
    {
        return $this->belongsTo(\App\Models\FormPemeliharaan\MasterPerangkat::class, 'master_perangkat_id');
    }



    /**
     * Daftar kategori aset yang tersedia (9 pilihan tetap)
     */
    public static function kategoriOptions(): array
    {
        return [
            'Air Conditioning',
            'Data Center',
            'Electrical Devices',
            'Fire Suppression',
            'Mass Storage',
            'Network Device',
            'Server Hardware',
            'System Monitoring',
            'UPS',
        ];
    }
}
