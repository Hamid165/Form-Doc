<?php

namespace App\Exports\FormBaStockOpname;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BaStockTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [];
    }

    public function headings(): array
    {
        return [
            'Nomor Inventaris Aset',
            'Serial Number',
            'Jenis Aset TI',
            'Merek',
            'Sumber Data',
            'Keterangan'
        ];
    }
}
