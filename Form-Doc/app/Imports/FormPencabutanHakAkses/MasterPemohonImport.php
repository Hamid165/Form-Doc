<?php

namespace App\Imports\FormPencabutanHakAkses;

use App\Models\FormPencabutanHakAkses\MasterPemohon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Facades\Log;

class MasterPemohonImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public $importedCount = 0;

    public function model(array $row)
    {
        // Try common column names
        $nama = $row['nama_pemohon'] ?? $row['nama'] ?? $row['pemohon'] ?? null;
        $nip = $row['nip_pemohon'] ?? $row['nip'] ?? $row['nik'] ?? '';

        if (!$nama) {
            Log::warning('MasterPemohonImport: Missing nama_pemohon in row: ' . json_encode($row));
            return null;
        }

        // Prevent duplicates: Skip if Name exists OR (if NIP is provided) NIP exists
        $query = MasterPemohon::where('nama_pemohon', $nama);
        
        if (!empty($nip)) {
            $query->orWhere('nip_pemohon', $nip);
        }

        if ($query->exists()) {
            return null; // Skip this row
        }

        $this->importedCount++;

        return new MasterPemohon([
            'nama_pemohon' => $nama,
            'nip_pemohon'  => $nip,
        ]);
    }
}
