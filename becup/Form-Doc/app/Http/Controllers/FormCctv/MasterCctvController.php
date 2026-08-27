<?php

namespace App\Http\Controllers\FormCctv;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormCctv\MasterCctv;

class MasterCctvController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_cctv' => 'required|string|max:255|unique:master_cctvs,id_cctv',
            'lokasi' => 'required|string|max:255',
        ], [
            'id_cctv.unique' => 'ID CCTV ini sudah terdaftar di database. Silakan gunakan ID yang berbeda.',
        ]);

        MasterCctv::create($request->all());

        return back()->with('success', "ID {$request->id_cctv} berhasil ditambahkan.");
    }

    public function update(Request $request, MasterCctv $master_cctv)
    {
        $request->validate([
            'id_cctv' => 'required|string|max:255|unique:master_cctvs,id_cctv,' . $master_cctv->id,
            'lokasi' => 'required|string|max:255',
        ], [
            'id_cctv.unique' => 'ID CCTV ini sudah terdaftar di database. Silakan gunakan ID yang berbeda.',
        ]);

        $oldIdCctv = $master_cctv->id_cctv;

        $master_cctv->update($request->all());

        // Update existing forms that used the old ID
        \App\Models\FormCctv\FormCctv::where('id_cctv', $oldIdCctv)->update([
            'id_cctv' => $request->id_cctv,
            'lokasi' => $request->lokasi,
        ]);

        return back()->with('success', "ID {$request->id_cctv} berhasil diperbarui.");
    }

    public function destroy(MasterCctv $master_cctv)
    {
        $id_cctv = $master_cctv->id_cctv;
        $master_cctv->delete();
        return back()->with('success', "ID {$id_cctv} berhasil dihapus.");
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\FormCctv\MasterCctvImport, $request->file('file'));
            return back()->with('success', 'Data CCTV berhasil diimpor!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('CCTV Import Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat impor data. Pastikan format file benar.');
        }
    }

    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\FormCctv\MasterCctvTemplateExport, 'Template_Data_CCTV.xlsx');
    }
}
