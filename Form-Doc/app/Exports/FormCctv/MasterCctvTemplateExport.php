<?php

namespace App\Exports\FormCctv;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MasterCctvTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'ID CCTV',
            'Lokasi',
        ];
    }

    public function array(): array
    {
        return [
            ['CCTV-X1', 'Stasiun Tugu (Contoh)'],
            ['CCTV-X2', 'Ruang Server (Contoh)'],
        ];
    }
}
