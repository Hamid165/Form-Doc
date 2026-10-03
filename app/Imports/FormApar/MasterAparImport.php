<?php

namespace App\Imports\FormApar;

use App\Models\FormApar\MasterApar;
use App\Models\FormApar\MasterVendor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Log;

class MasterAparImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        $kodeAset = $row['kode_aset'] ?? $row['kode'] ?? $row['id_aset'] ?? $row['asset_code'] ?? null;
        $merk = $row['merk'] ?? $row['brand'] ?? null;
        $tipe = $row['tipe'] ?? $row['type'] ?? null;
        $seri = $row['seri'] ?? null;
        $media = $row['media'] ?? $row['media_pemadam'] ?? null;
        $jenis = $row['jenis'] ?? null;
        $kapasitas = $row['kapasitas'] ?? $row['capacity'] ?? null;
        $lokasi = $row['lokasi'] ?? $row['location'] ?? null;
        $subLokasi = $row['sub_lokasi'] ?? null;
        
        $tglIsiUlang = $row['tanggal_isi_ulang'] ?? $row['tgl_isi_ulang'] ?? $row['last_refill'] ?? null;
        $tglKadaluarsa = $row['tanggal_kadaluarsa'] ?? $row['tgl_kadaluarsa'] ?? $row['expiry_date'] ?? null;
        
        $vendorName = $row['vendor'] ?? $row['nama_vendor'] ?? null;
        $vendorId = null;

        if (!$kodeAset) {
            Log::warning('MasterAparImport: Missing kode_aset in row: ' . json_encode($row));
            return null;
        }

        // Skip duplicate kode_aset
        if (MasterApar::where('kode_aset', $kodeAset)->exists()) {
            return null;
        }

        // Parse dates
        if (is_numeric($tglIsiUlang)) {
            $tglIsiUlang = Date::excelToDateTimeObject($tglIsiUlang)->format('Y-m-d');
        }
        if (is_numeric($tglKadaluarsa)) {
            $tglKadaluarsa = Date::excelToDateTimeObject($tglKadaluarsa)->format('Y-m-d');
        }

        // Handle Vendor
        if ($vendorName) {
            $vendor = MasterVendor::firstOrCreate(['nama_vendor' => trim($vendorName)]);
            $vendorId = $vendor->id;
        }

        return new MasterApar([
            'kode_aset'          => $kodeAset,
            'merk'               => $merk,
            'tipe'               => $tipe,
            'seri'               => $seri,
            'media'              => $media,
            'jenis'              => $jenis,
            'kapasitas'          => $kapasitas,
            'lokasi'             => $lokasi,
            'sub_lokasi'         => $subLokasi,
            'tanggal_isi_ulang'  => $tglIsiUlang ?: null,
            'tanggal_kadaluarsa' => $tglKadaluarsa ?: null,
            'vendor_id'          => $vendorId,
        ]);
    }
}
