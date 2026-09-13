<?php

namespace App\Imports\FormPemeliharaan;

use App\Models\FormPemeliharaan\MasterPerangkat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Facades\Log;

class MasterPerangkatImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    private $seenKodeAset = [];

    public function model(array $row)
    {
        $kodeAset      = $row['kode_aset'] ?? $row['kode'] ?? $row['asset_code'] ?? null;
        $jenisPerangkat = $row['jenis_perangkat'] ?? $row['jenis'] ?? $row['type'] ?? null;

        if (!$kodeAset || !$jenisPerangkat) {
            Log::warning('MasterPerangkatImport: Missing kode_aset or jenis_perangkat in row: ' . json_encode($row));
            return null;
        }

        // Cek duplikat di database atau di file excel (baris yang sama)
        if (MasterPerangkat::where('kode_aset', $kodeAset)->exists() || in_array($kodeAset, $this->seenKodeAset)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'file' => "Data perangkat tidak boleh sama. Kode aset $kodeAset sudah ada."
            ]);
        }

        $this->seenKodeAset[] = $kodeAset;

        return new MasterPerangkat([
            'kode_aset'       => $kodeAset,
            'jenis_perangkat' => $jenisPerangkat,
        ]);
    }
}
