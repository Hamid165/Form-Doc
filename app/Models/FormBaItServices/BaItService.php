<?php

namespace App\Models\FormBaItServices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaItService extends Model
{
    use HasFactory;

    // Mengizinkan semua kolom diisi secara massal (Mass Assignment)
    protected $guarded = ['id'];

    // Otomatis mengubah JSON menjadi Array dan format Tanggal
    protected $fillable = [
        'no_dokumen',
        'versi',
        'pemohon_nama',
        'pemohon_unit',
        'pemohon_kontak',
        'no_ref',
        'tgl_ref',
        'business_area',
        'waktu_mulai',
        'waktu_selesai',
        'no_inventaris_aset',
        'detail_penanganan',
        'pihak_terkait',
        'ttd_staf_nipp',
        'ttd_mengetahui_nipp',
        'ttd_user_nipp',
        'status_terima',
    ];

    // Tambahkan casts agar otomatis terbaca sebagai format tanggal/waktu oleh Eloquent
    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'detail_penanganan' => 'array',
    ];
}