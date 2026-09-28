<?php

namespace App\Http\Controllers\FormPemusnahan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormPemusnahan\DataAset;

class DataAsetController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_aset' => 'required|string|max:100|unique:data_asets,id_aset',
            'nama_aset' => 'required|string|max:255',
            'jenis_aset' => 'nullable|string|max:255',
        ], [
            'id_aset.unique' => 'ID Aset ini sudah terdaftar. Gunakan ID yang berbeda.',
        ]);

        DataAset::create($request->only(['id_aset', 'nama_aset', 'jenis_aset']));

        return redirect()->route('form-pemusnahan.index', ['tab' => 'aset'])->with('success', "Aset {$request->id_aset} berhasil ditambahkan.");
    }

    public function update(Request $request, DataAset $data_aset)
    {
        $request->validate([
            'id_aset' => 'required|string|max:100|unique:data_asets,id_aset,' . $data_aset->id,
            'nama_aset' => 'required|string|max:255',
            'jenis_aset' => 'nullable|string|max:255',
        ], [
            'id_aset.unique' => 'ID Aset ini sudah terdaftar. Gunakan ID yang berbeda.',
        ]);

        $data_aset->update($request->only(['id_aset', 'nama_aset', 'jenis_aset']));

        return redirect()->route('form-pemusnahan.index', ['tab' => 'aset'])->with('success', "Aset {$request->id_aset} berhasil diperbarui.");
    }

    public function destroy(DataAset $data_aset)
    {
        $id = $data_aset->id_aset;
        $data_aset->delete();

        return redirect()->route('form-pemusnahan.index', ['tab' => 'aset'])->with('success', "Aset {$id} berhasil dihapus.");
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(
                new \App\Imports\FormPemusnahan\DataAsetImport,
                $request->file('file')
            );
            return redirect()->route('form-pemusnahan.index', ['tab' => 'aset'])->with('success', 'Data aset berhasil diimpor!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Data Aset Import Error: ' . $e->getMessage());
            return redirect()->route('form-pemusnahan.index', ['tab' => 'aset'])->with('error', 'Terjadi kesalahan saat impor data. Pastikan format file benar.');
        }
    }

    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\FormPemusnahan\DataAsetTemplateExport,
            'Template_Data_Aset.xlsx'
        );
    }

    public function getInfo(DataAset $data_aset)
    {
        return response()->json([
            'id_aset' => $data_aset->id_aset,
            'nama_aset' => $data_aset->nama_aset,
            'jenis_aset' => $data_aset->jenis_aset,
        ]);
    }
}
