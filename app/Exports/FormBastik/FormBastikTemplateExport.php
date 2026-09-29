<?php

namespace App\Exports\FormBastik;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FormBastikTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            [
                'INC00012345',
                'Gangguan koneksi jaringan pada perangkat pelanggan',
                'Andi Wijaya',
                '00.9988',
                'Unit Kerja A'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'No Tiket',
            'Detail Tiket',
            'User Pemohon',
            'NIPP',
            'Unit'
        ];
    }
}
