<?php

namespace App\Imports\FormPemeliharaan;

use App\Models\FormCctv\MasterSigner;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MasterSignerImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new MasterSigner([
            'nama'    => $row['nama'],
            'nipp'    => $row['nipp'],
            'jabatan' => $row['jabatan'] ?? null,
        ]);
    }
}
