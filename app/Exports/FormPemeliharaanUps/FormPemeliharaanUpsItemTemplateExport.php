<?php

namespace App\Exports\FormPemeliharaanUps;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FormPemeliharaanUpsItemTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'Tanggal',
            'Perawatan',
            'Perbaikan',
            'Keterangan',
            'Paraf',
        ];
    }

    public function array(): array
    {
        return [
            ['2026-07-14', 'V', '', 'Melakukan perawatan rutin UPS', 'Pitra'],
            ['2026-07-15', '', 'V', 'Mengganti baterai UPS yang drop', 'Hamid'],
        ];
    }
}
