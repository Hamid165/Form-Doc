<?php

namespace App\Imports\FormPemeliharaanUps;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class FormPemeliharaanUpsItemImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    public function collection(Collection $rows)
    {
        $data = [];
        foreach ($rows as $row) {
            $tanggal = $row['tanggal'] ?? null;
            if (is_numeric($tanggal)) {
                $tanggal = Date::excelToDateTimeObject($tanggal)->format('Y-m-d');
            }

            $perawatan = strtoupper(trim($row['perawatan'] ?? '')) === 'V' ? 'V' : null;
            $perbaikan = strtoupper(trim($row['perbaikan'] ?? '')) === 'V' ? 'V' : null;
            
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
