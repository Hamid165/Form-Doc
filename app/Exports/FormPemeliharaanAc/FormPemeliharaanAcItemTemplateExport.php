<?php

namespace App\Exports\FormPemeliharaanAc;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FormPemeliharaanAcItemTemplateExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    public function headings(): array
    {
        return [
            'Tanggal',
            'Perawatan (V/Kosong)',
            'Perbaikan (V/Kosong)',
            'Keterangan',
            'Paraf',
        ];
    }

    public function array(): array
    {
        return [
            ['10 Juli 2026', 'V', '', 'Pembersihan filter AC', 'Teknisi'],
            ['11 Juli 2026', '', 'V', 'Ganti kapasitor blower', 'Teknisi B'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
