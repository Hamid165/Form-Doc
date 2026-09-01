<?php

namespace App\Exports\FormPencabutanHakAkses;

use App\Models\FormPencabutanHakAkses\MasterPemohon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MasterPemohonTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'Nama Pemohon',
            'NIP Pemohon',
        ];
    }

    public function array(): array
    {
        return [
            ['John Doe', '123456789'],
            ['Jane Doe', '987654321'],
        ];
    }
}
