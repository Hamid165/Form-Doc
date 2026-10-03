<?php

namespace App\Exports\FormLogPeminjaman;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FormLogPeminjamanExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [];
    }

    public function headings(): array
    {
        return [
            'Nama Informasi / Dokumen',
            'Nama Peminjam',
            'Unit Kerja / Instansi',
            'Tanggal Pinjam',
            'Paraf Peminjam (Pinjam)',
            'Tanggal Kembali',
            'Paraf Peminjam (Kembali)',
            'Paraf Penanggung Jawab',
            'Keterangan'
        ];
    }
}