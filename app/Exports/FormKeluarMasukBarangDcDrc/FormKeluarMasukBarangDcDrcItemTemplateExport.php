<?php

namespace App\Exports\FormKeluarMasukBarangDcDrc;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FormKeluarMasukBarangDcDrcItemTemplateExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    /**
     * Sample data untuk mencontohkan cara pengisian
     */
    public function array(): array
    {
        return [
            // Baris 2: Contoh data 1 (single serial)
            [
                1,
                'Server Dell PowerEdge R740',
                'DELL-R740-SN001',
                1,
                'unit',
                'Dell',
                'Server Hardware',
                'Rak A1',
                'Divisi TI',
                '5A',
                25,
                '2U',
                'Hardware',
                'Baru',
                'Baik',
                '',
            ],
            // Baris 3: Contoh data 2 (multiple serial - pisahkan dengan koma)
            [
                2,
                'Switch Cisco Catalyst',
                'CSCO-SW001, CSCO-SW002, CSCO-SW003',
                3,
                'unit',
                'Cisco',
                'Network Device',
                'Rak B2',
                'Divisi TI',
                '2A',
                4,
                '1U',
                'Hardware',
                'Baru',
                'Baik',
                'Contoh: 3 unit dengan 3 serial number',
            ],
        ];
    }

    /**
     * Header kolom sesuai struktur template
     * Format Title Case
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Jenis Aset',
            'Part No / ID Number / Serial Number',
            'Jumlah',
            'Satuan',
            'Merk Type',
            'Kategori Aset',
            'Lokasi Penyimpanan',
            'Owner',
            'Power A',
            'Berat KG',
            'Ukuran U',
            'Jenis HW SW',
            'Kondisi Baru Bekas',
            'Kondisi Baik Rusak',
            'Keterangan',
        ];
    }

    /**
     * Styling header row
     * Font: Calibri 11, bold, warna teks hitam
     */
    public function styles(Worksheet $sheet): array
    {
        // Style untuk header (baris 1)
        $sheet->getStyle('A1:P1')->applyFromArray([
            'font' => [
                'name' => 'Calibri',
                'size' => 11,
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'alignment' => [
                'wrapText' => true,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Style untuk data (baris 2-3)
        $sheet->getStyle('A2:P3')->applyFromArray([
            'font' => [
                'name' => 'Calibri',
                'size' => 11,
            ],
            'alignment' => [
                'wrapText' => true,
            ],
        ]);

        // Set row height untuk header agar teks wrap
        $sheet->getRowDimension(1)->setRowHeight(30);

        return [];
    }

    /**
     * Lebar kolom sesuai konten
     */
    public function columnWidths(): array
    {
        return [
            'A' => 4,      // No
            'B' => 32,     // Nama Jenis Aset
            'C' => 40,     // Part No / ID Number / Serial Number (diperlebar untuk multiple serial)
            'D' => 8,      // Jumlah
            'E' => 8,      // Satuan
            'F' => 14,     // Merk Type
            'G' => 18,     // Kategori Aset
            'H' => 22,     // Lokasi Penyimpanan
            'I' => 12,     // Owner
            'J' => 10,     // Power A
            'K' => 10,     // Berat KG
            'L' => 10,     // Ukuran U
            'M' => 12,     // Jenis HW SW
            'N' => 18,     // Kondisi Baru Bekas
            'O' => 18,     // Kondisi Baik Rusak
            'P' => 20,     // Keterangan (diperlebar untuk instruksi)
        ];
    }
}
