<?php

namespace App\Models\FormChecklistPc;

use Illuminate\Database\Eloquent\Model;

class FormChecklistPc extends Model
{
    // 21 item checklist sesuai form kertas "Checklist Pemeliharaan PC-Notebook-Printer"
    public const CHECKLIST_ITEMS = [
        1  => 'Kosongkan Recycle Bin',
        2  => 'Hapus Temporary Files',
        3  => 'Hapus Obsolete Files',
        4  => 'Hapus Cache & History Browser',
        5  => 'Fungsi HDD (Scan Disk & Defragment)',
        6  => 'Backup Informasi Penting',
        7  => 'Update Anti Virus',
        8  => 'Full-Scan Anti Virus',
        9  => 'Update Service Pack OS Terbaru',
        10 => 'Update Drivers Terbaru',
        11 => 'Fungsi Pendingin & Fan',
        12 => 'Fungsi Sumber Daya Listrik',
        13 => 'Fungsi Konektivitas (LAN/WiFi)',
        14 => 'Fungsi Port Akses',
        15 => 'Fungsi Input (Keyboard/Trackpad)',
        16 => 'Fungsi Layar / Monitor',
        17 => 'Fungsi CD/DVD Drive',
        18 => 'Fungsi Pencetakan',
        19 => 'Fungsi Copy / Scan',
        20 => 'Status Tinta / Toner',
        21 => 'Kebersihan Fisik',
    ];

    protected $fillable = [
        'no_ref',
        'tanggal',
        'business_area',
        'pelaksana_name',
        'tanggal_pemeriksaan',
        'analisa_kesimpulan',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_pemeriksaan' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(FormChecklistPcItem::class);
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isDicetak(): bool
    {
        return $this->status === 'dicetak';
    }

    public function isSelesai(): bool
    {
        return $this->status === 'selesai';
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'draft'   => 'bg-yellow-100 text-yellow-800',
            'dicetak' => 'bg-blue-100 text-blue-800',
            'selesai' => 'bg-green-100 text-green-800',
            default   => 'bg-gray-100 text-gray-800',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft'   => 'Draft',
            'dicetak' => 'Dicetak',
            'selesai' => 'Selesai',
            default   => 'Unknown',
        };
    }
}