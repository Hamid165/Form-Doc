<?php

namespace App\Exports\FormPemeliharaan;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MasterSignerTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'nama',
            'nipp',
            'jabatan',
        ];
    }

    public function array(): array
    {
        return [
            ['Budi Santoso', '123456', 'Manager IT'],
        ];
    }
}
