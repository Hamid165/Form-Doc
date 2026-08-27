<?php

namespace App\Imports\FormPemeliharaanUps;

use App\Models\FormPemeliharaanUps\MasterUps;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Facades\Log;

class MasterUpsImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        $nomorInventaris = $row['nomor_inventaris'] ?? $row['no_id'] ?? $row['id'] ?? $row['ups_id'] ?? $row['id_ups'] ?? null;
        $lokasi = $row['lokasi'] ?? $row['location'] ?? $row['tempat'] ?? null;

        if (!$nomorInventaris || !$lokasi) {
            Log::warning('MasterUpsImport: Missing nomor_inventaris or lokasi in row: ' . json_encode($row));
            return null;
        }

        $existing = MasterUps::where('nomor_inventaris', $nomorInventaris)->first();
        if ($existing) {
            return null;
        }

        return new MasterUps([
            'nomor_inventaris' => $nomorInventaris,
            'lokasi'  => $lokasi,
        ]);
    }
}
