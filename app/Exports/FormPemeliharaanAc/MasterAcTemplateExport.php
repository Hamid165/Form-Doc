<?php

namespace App\Exports\FormPemeliharaanAc;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MasterAcTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'ID AC',
            'Lokasi',
            'Sub Lokasi',
            'Jenis',
            'Merk',
            'Kapasitas',
            'Tahun Pasang',
        ];
    }

    public function array(): array
    {
        return [
            ['AC-01', 'Ruang Kepala Stasiun (Contoh)', 'Lantai 1', 'Split', 'Daikin', '1 PK', '2020'],
            ['AC-02', 'Ruang Server (Contoh)', 'Lantai 2', 'Standing', 'LG', '2 PK', '2021'],
        ];
    }
}
