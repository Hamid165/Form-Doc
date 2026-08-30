<?php

namespace App\Exports\FormPemusnahan;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FormPemusnahanItemTemplateExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    public function headings(): array
    {
        return [
            'Nama Aset',
            'Jenis Aset',
            'ID Aset',
            'Alasan Pemusnahan',
        ];
    }

    public function array(): array
    {
        return [
            ['Switch Cisco 2960-X', 'fisik', 'SW-001', 'Rusak permanen, sudah tidak bisa diperbaiki'],
            ['Akun HC John Doe', 'HC', 'HC-2024-001', 'Karyawan resign, akses tidak diperlukan lagi'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
