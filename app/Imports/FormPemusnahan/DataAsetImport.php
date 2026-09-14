<?php

namespace App\Imports\FormPemusnahan;

use App\Models\FormPemusnahan\DataAset;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Facades\Log;

class DataAsetImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        $idAset = $row['id_aset'] ?? $row['id aset'] ?? $row['kode_aset'] ?? null;
        $namaAset = $row['nama_aset'] ?? $row['nama aset'] ?? null;
        $jenisAset = $row['jenis_aset'] ?? $row['jenis aset'] ?? null;

        if (!$idAset || !$namaAset) {
            Log::warning('DataAsetImport: Missing id_aset or nama_aset in row: ' . json_encode($row));
            return null;
        }

        // Lewati id_aset yang sudah ada (hindari duplikat)
        if (DataAset::where('id_aset', $idAset)->exists()) {
            return null;
        }

        return new DataAset([
            'id_aset' => $idAset,
            'nama_aset' => $namaAset,
            'jenis_aset' => $jenisAset,
        ]);
    }
}
