<?php

namespace App\Exports\FormPemusnahan;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataAsetTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return ['ID Aset', 'Nama Aset', 'Jenis Aset'];
    }

    public function array(): array
    {
        return [
            ['SW-001', 'Switch Cisco 2960-X', 'fisik'],
            ['HC-2024-001', 'Akun HC John Doe', 'HC'],
        ];
    }
}
