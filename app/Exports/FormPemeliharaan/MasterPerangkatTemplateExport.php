<?php

namespace App\Exports\FormPemeliharaan;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MasterPerangkatTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return ['Kode Aset', 'Jenis Perangkat', 'Deskripsi'];
    }

    public function array(): array
    {
        return [
            ['SW-001', 'Switch', 'Cisco Catalyst 2960 (Contoh)'],
            ['RT-001', 'Router', 'MikroTik RB750 (Contoh)'],
        ];
    }
}
