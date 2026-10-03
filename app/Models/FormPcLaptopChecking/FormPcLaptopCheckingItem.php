<?php

namespace App\Models\FormPcLaptopChecking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormPcLaptopCheckingItem extends Model
{
    use HasFactory;

    protected $table = 'form_pc_laptop_checking_items';

    protected $fillable = [
        'form_pc_laptop_checking_id',
        'no',
        'nama_pengguna',
        'unit',
        'nda',
        'login_strong_password',
        'screensaver_lock',
        'hak_akses_khusus',
        'cleardesk',
        'mp3_video_etc',
        'antivirus_install',
        'antivirus_update',
        'full_scan_auto_schedule',
        'os_license',
        'sinkronisasi_ntp',
        'label_pc',
        'pemeriksa',
        'pegawai_ybs',
    ];

    public function formPcLaptopChecking()
    {
        return $this->belongsTo(FormPcLaptopChecking::class, 'form_pc_laptop_checking_id');
    }
}
