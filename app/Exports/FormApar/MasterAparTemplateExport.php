<?php

namespace App\Exports\FormApar;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MasterAparTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'Kode Aset',
            'Merk',
            'Tipe',
            'Seri',
            'Media',
            'Jenis',
            'Kapasitas',
            'Tanggal Isi Ulang',
            'Tanggal Kadaluarsa',
            'Lokasi',
            'Sub Lokasi',
            'Vendor'
        ];
    }

    public function array(): array
    {
        return [
            [
                'APAR-001',
                'Yamato',
                'Stored Pressure',
                'S-12345',
                'Serbuk',
                'ABC Powder',
                '6 Kg',
                '2025-10-12',
                '2026-10-12',
                'Lobby Gedung Utama',
                'Pintu Masuk Barat',
                'PT. Proteksi Abadi'
            ],
            [
                'APAR-002',
                'Chubb',
                'Cartridge',
                'C-98765',
                'CO2',
                'Carbon Dioxide',
                '5 Kg',
                '2025-05-15',
                '2026-05-15',
                'Ruang Server',
                'Rak Server A',
                'PT. Mandiri Jaya'
            ],
        ];
    }
}
