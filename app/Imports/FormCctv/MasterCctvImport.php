<?php

namespace App\Imports\FormCctv;

use App\Models\FormCctv\MasterCctv;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Facades\Log;

class MasterCctvImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Try different common column names for ID CCTV
        $idCctv = $row['id_cctv'] ?? $row['id'] ?? $row['cctv'] ?? $row['cctv_id'] ?? null;
        
        // Try different common column names for Lokasi
        $lokasi = $row['lokasi'] ?? $row['location'] ?? $row['tempat'] ?? null;

        if (!$idCctv || !$lokasi) {
            // Log missing data and skip the row
            Log::warning('MasterCctvImport: Missing id_cctv or lokasi in row: ' . json_encode($row));
            return null;
        }

        // Check if ID already exists. If yes, skip to prevent duplicates.
        $existing = MasterCctv::where('id_cctv', $idCctv)->first();
        if ($existing) {
            return null;
        }

        return new MasterCctv([
            'id_cctv' => $idCctv,
            'lokasi'  => $lokasi,
        ]);
    }
}
