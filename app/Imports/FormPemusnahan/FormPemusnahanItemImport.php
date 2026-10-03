<?php

namespace App\Imports\FormPemusnahan;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class FormPemusnahanItemImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    public function collection(Collection $rows)
    {
        // Import class ini tidak menyimpan langsung ke database.
        // Ia hanya mem-parsing baris Excel menjadi array supaya controller
        // bisa mengembalikannya sebagai JSON ke JavaScript di form.

        $data = [];
        foreach ($rows as $row) {
            $namaAset = trim($row['nama_aset'] ?? '');
            $jenisAset = trim($row['jenis_aset'] ?? '');
            $idAset = trim($row['id_aset'] ?? '');
            $alasan = trim($row['alasan_pemusnahan'] ?? '');

            // Lewati baris yang benar-benar kosong semua
            if ($namaAset === '' && $jenisAset === '' && $idAset === '' && $alasan === '') {
                continue;
            }

            $data[] = [
                'nama_aset' => $namaAset,
                'jenis_aset' => $jenisAset,
                'id_aset' => $idAset,
                'alasan_pemusnahan' => $alasan,
            ];
        }

        return collect($data);
    }
}
