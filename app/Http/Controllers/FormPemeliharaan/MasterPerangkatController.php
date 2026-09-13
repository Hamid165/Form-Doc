<?php

namespace App\Http\Controllers\FormPemeliharaan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormPemeliharaan\MasterPerangkat;

class MasterPerangkatController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kode_aset'       => 'required|string|max:100|unique:master_perangkats,kode_aset',
            'jenis_perangkat' => 'required|string|max:255',
            'lokasi'          => 'nullable|string|max:255',
        ], [
            'kode_aset.unique' => 'Kode aset ini sudah terdaftar. Gunakan kode yang berbeda.',
        ]);

        MasterPerangkat::create($request->only(['kode_aset', 'jenis_perangkat', 'lokasi']));

        return back()->with([
            'success' => "Perangkat {$request->kode_aset} berhasil ditambahkan.",
            'active_tab' => 'perangkat'
        ]);
    }

    public function update(Request $request, MasterPerangkat $master_perangkat)
    {
        $request->validate([
            'kode_aset'       => 'required|string|max:100|unique:master_perangkats,kode_aset,' . $master_perangkat->id,
            'jenis_perangkat' => 'required|string|max:255',
            'lokasi'          => 'nullable|string|max:255',
        ], [
            'kode_aset.unique' => 'Kode aset ini sudah terdaftar. Gunakan kode yang berbeda.',
        ]);

        $master_perangkat->update($request->only(['kode_aset', 'jenis_perangkat', 'lokasi']));

        return back()->with([
            'success' => "Perangkat {$request->kode_aset} berhasil diperbarui.",
            'active_tab' => 'perangkat'
        ]);
    }

    public function destroy(MasterPerangkat $master_perangkat)
    {
        $kode = $master_perangkat->kode_aset;
        $master_perangkat->delete();

        return back()->with([
            'success' => "Perangkat {$kode} berhasil dihapus.",
            'active_tab' => 'perangkat'
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(
                new \App\Imports\FormPemeliharaan\MasterPerangkatImport,
                $request->file('file')
            );
            return back()->with([
                'success' => 'Data perangkat berhasil diimpor!',
                'active_tab' => 'perangkat'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->with([
                'error' => $e->validator->errors()->first(),
                'active_tab' => 'perangkat'
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Perangkat Import Error: ' . $e->getMessage());
            return back()->with([
                'error' => 'Terjadi kesalahan saat impor data. Pastikan format file benar.',
                'active_tab' => 'perangkat'
            ]);
        }
    }

    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\FormPemeliharaan\MasterPerangkatTemplateExport,
            'Template_Data_Perangkat.xlsx'
        );
    }

    public function getInfo(MasterPerangkat $master_perangkat)
    {
        return response()->json([
            'kode_aset'       => $master_perangkat->kode_aset,
            'jenis_perangkat' => $master_perangkat->jenis_perangkat,
            'lokasi'          => $master_perangkat->lokasi,
        ]);
    }
}
