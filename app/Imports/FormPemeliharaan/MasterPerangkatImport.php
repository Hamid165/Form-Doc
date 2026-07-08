<?php

namespace App\Imports\FormPemeliharaan;

use App\Models\FormPemeliharaan\MasterPerangkat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Facades\Log;

class MasterPerangkatImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        $kodeAset      = $row['kode_aset'] ?? $row['kode'] ?? $row['asset_code'] ?? null;
        $jenisPerangkat = $row['jenis_perangkat'] ?? $row['jenis'] ?? $row['type'] ?? null;
        $deskripsi     = $row['deskripsi'] ?? $row['description'] ?? null;

        if (!$kodeAset || !$jenisPerangkat) {
            Log::warning('MasterPerangkatImport: Missing kode_aset or jenis_perangkat in row: ' . json_encode($row));
            return null;
        }

        // Skip duplicate kode_aset
        if (MasterPerangkat::where('kode_aset', $kodeAset)->exists()) {
            return null;
        }

        return new MasterPerangkat([
            'kode_aset'       => $kodeAset,
            'jenis_perangkat' => $jenisPerangkat,
            'deskripsi'       => $deskripsi,
        ]);
    }
}
