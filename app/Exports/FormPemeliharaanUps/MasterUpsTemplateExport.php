<?php

namespace App\Exports\FormPemeliharaanUps;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MasterUpsTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'Nomor Inventaris',
            'Lokasi',
        ];
    }

    public function array(): array
    {
        return [
            ['UPS-01', 'Stasiun Tugu (Contoh)'],
            ['UPS-02', 'Stasiun Lempuyangan (Contoh)'],
        ];
    }
}
