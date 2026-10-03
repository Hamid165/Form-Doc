<?php

namespace App\Imports\FormPemeliharaanAc;

use App\Models\FormPemeliharaanAc\MasterAc;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Facades\Log;

class MasterAcImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Try different common column names for ID AC
        $idAc = $row['id_ac'] ?? $row['id'] ?? $row['ac'] ?? $row['ac_id'] ?? null;
        
        // Try different common column names for Lokasi
        $lokasi = $row['lokasi'] ?? $row['location'] ?? $row['tempat'] ?? null;

        // Try different common column names for new fields
        $subLokasi = $row['sub_lokasi'] ?? $row['sub lokasi'] ?? null;
        $jenis = $row['jenis'] ?? $row['type'] ?? null;
        $merk = $row['merk'] ?? $row['merek'] ?? $row['brand'] ?? null;
        $kapasitas = $row['kapasitas'] ?? $row['capacity'] ?? null;
        $tahunPasang = $row['tahun_pasang'] ?? $row['tahun pasang'] ?? $row['year'] ?? null;

        if (!$idAc || !$lokasi) {
            // Log missing data and skip the row
            Log::warning('MasterAcImport: Missing id_ac or lokasi in row: ' . json_encode($row));
            return null;
        }

        // Check if ID already exists. If yes, skip to prevent duplicates.
        $existing = MasterAc::where('id_ac', $idAc)->first();
        if ($existing) {
            return null;
        }

        return new MasterAc([
            'id_ac' => $idAc,
            'lokasi'  => $lokasi,
            'sub_lokasi' => $subLokasi,
            'jenis' => $jenis,
            'merk' => $merk,
            'kapasitas' => $kapasitas,
            'tahun_pasang' => $tahunPasang,
        ]);
    }
}
