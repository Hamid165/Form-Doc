<?php

namespace App\Imports\FormCctv;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class FormCctvItemImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    public function collection(Collection $rows)
    {
        // This import class doesn't save to database directly.
        // It just parses the rows into a collection so the controller can return them as JSON.
        
        $data = [];
        foreach ($rows as $row) {
            // Read date. If it's an excel date (numeric), parse it. Otherwise treat as string.
            $tanggal = $row['tanggal'] ?? null;
            if (is_numeric($tanggal)) {
                $tanggal = Date::excelToDateTimeObject($tanggal)->format('Y-m-d');
            }

            // Normalisasi checklist (V/v)
            $perawatan = strtoupper(trim($row['perawatan_vkosong'] ?? $row['perawatan'] ?? '')) === 'V' ? 'V' : null;
            $perbaikan = strtoupper(trim($row['perbaikan_vkosong'] ?? $row['perbaikan'] ?? '')) === 'V' ? 'V' : null;
            
            $data[] = [
                'tanggal' => $tanggal,
                'perawatan' => $perawatan,
                'perbaikan' => $perbaikan,
                'keterangan' => $row['keterangan'] ?? '',
                'paraf' => $row['paraf'] ?? '',
            ];
        }

        return collect($data);
    }
}
