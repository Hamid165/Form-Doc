<?php

namespace App\Imports\FormKeluarMasukBarangDcDrc;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use App\Models\FormKeluarMasukBarangDcDrc\FormKeluarMasukBarangDcDrcItem;

class FormKeluarMasukBarangDcDrcItemImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    public function collection(Collection $rows)
    {
        // Parse rows into collection for JSON response.
        // Does NOT save to database directly.
        
        $data = [];
        $kategoriValid = FormKeluarMasukBarangDcDrcItem::kategoriOptions();
        
        foreach ($rows as $row) {
            // Normalisasi kategori_aset (header: Kategori Aset -> kategori_aset)
            $kategori = $row['kategori_aset'] ?? $row['kategori'] ?? '';
            $kategori = trim($kategori);
            
            // Normalisasi kondisi_baru_bekas (header: Kondisi Baru Bekas -> kondisi_baru_bekas)
            $kondisiBaruBekas = strtolower(trim($row['kondisi_baru_bekas'] ?? $row['kondisi_baru'] ?? 'baru'));
            if (!in_array($kondisiBaruBekas, ['baru', 'bekas'])) {
                $kondisiBaruBekas = 'baru';
            }
            
            // Normalisasi kondisi_baik_rusak (header: Kondisi Baik Rusak -> kondisi_baik_rusak)
            $kondisiBaikRusak = strtolower(trim($row['kondisi_baik_rusak'] ?? $row['kondisi_baik'] ?? 'baik'));
            if (!in_array($kondisiBaikRusak, ['baik', 'rusak'])) {
                $kondisiBaikRusak = 'baik';
            }
            
            // Normalisasi jumlah (integer)
            $jumlah = $row['jumlah'] ?? 1;
            $jumlah = is_numeric($jumlah) ? (int) $jumlah : 1;
            
            // Ambil part_no / serial number (header: Part No / ID Number / Serial Number -> part_no_id_number_serial_number)
            $partNo = $row['part_no_id_number_serial_number'] ?? $row['part_no'] ?? $row['part'] ?? '';
            $partNo = trim($partNo) ?: null;
            if ($partNo) {
                // Ganti baris baru (Alt+Enter) dengan koma agar aman saat masuk ke input text frontend
                $partNo = str_replace(["\r\n", "\r", "\n"], ', ', $partNo);
            }
            
            // Normalisasi berat_kg (decimal) - header: Berat KG -> berat_kg
            $beratKg = $row['berat_kg'] ?? $row['berat'] ?? null;
            if (is_numeric($beratKg)) {
                $beratKg = round((float) $beratKg, 2);
            } else {
                $beratKg = null;
            }
            
            // Normalisasi power_a (header: Power A -> power_a)
            $powerA = $row['power_a'] ?? $row['power'] ?? null;
            if (is_numeric($powerA)) {
                $powerA = (string) $powerA;
            }
            
            // Normalisasi ukuran_u (header: Ukuran U -> ukuran_u)
            $ukuranU = $row['ukuran_u'] ?? $row['ukuran'] ?? null;
            
            // Normalisasi jenis_hw_sw (header: Jenis HW SW -> jenis_hw_sw)
            $jenisHwSw = $row['jenis_hw_sw'] ?? $row['jenis'] ?? null;
            
            $data[] = [
                'no_urut' => (int) ($row['no'] ?? $row['no_urut'] ?? 0),
                'nama_jenis_aset' => trim($row['nama_jenis_aset'] ?? $row['nama_aset'] ?? $row['nama'] ?? ''),
                'part_no' => $partNo,
                'jumlah' => $jumlah,
                'satuan' => trim($row['satuan'] ?? 'unit'),
                'merk_type' => trim($row['merk_type'] ?? $row['merk'] ?? ''),
                'kategori_aset' => $kategori,
                'lokasi_penyimpanan' => trim($row['lokasi_penyimpanan'] ?? $row['lokasi'] ?? ''),
                'owner' => trim($row['owner'] ?? '') ?: null,
                'power_a' => trim($powerA ?? '') ?: null,
                'berat_kg' => $beratKg,
                'ukuran_u' => trim($ukuranU ?? '') ?: null,
                'jenis_hw_sw' => trim($jenisHwSw ?? '') ?: null,
                'kondisi_baru_bekas' => $kondisiBaruBekas,
                'kondisi_baik_rusak' => $kondisiBaikRusak,
                'keterangan' => trim($row['keterangan'] ?? $row['ket'] ?? '') ?: null,
            ];
        }

        return collect($data);
    }
}
