<?php

namespace App\Http\Controllers\FormPemeliharaanAc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormPemeliharaanAc\MasterAc;

class MasterAcController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_ac' => 'required|string|max:255|unique:master_acs,id_ac',
            'lokasi' => 'required|string|max:255',
            'sub_lokasi' => 'nullable|string|max:255',
            'jenis' => 'nullable|string|max:255',
            'merk' => 'nullable|string|max:255',
            'kapasitas' => 'nullable|string|max:255',
            'tahun_pasang' => 'nullable|string|max:255',
        ], [
            'id_ac.unique' => 'ID AC ini sudah terdaftar di database. Silakan gunakan ID yang berbeda.',
        ]);

        MasterAc::create($request->all());

        return back()->with('success', "ID AC {$request->id_ac} berhasil ditambahkan.");
    }

    public function update(Request $request, MasterAc $master_ac)
    {
        $request->validate([
            'id_ac' => 'required|string|max:255|unique:master_acs,id_ac,' . $master_ac->id,
            'lokasi' => 'required|string|max:255',
            'sub_lokasi' => 'nullable|string|max:255',
            'jenis' => 'nullable|string|max:255',
            'merk' => 'nullable|string|max:255',
            'kapasitas' => 'nullable|string|max:255',
            'tahun_pasang' => 'nullable|string|max:255',
        ], [
            'id_ac.unique' => 'ID AC ini sudah terdaftar di database. Silakan gunakan ID yang berbeda.',
        ]);

        $oldIdAc = $master_ac->id_ac;

        $master_ac->update($request->all());

        // Update existing forms that used the old ID
        \App\Models\FormPemeliharaanAc\FormPemeliharaanAc::where('id_ac', $oldIdAc)->update([
            'id_ac' => $request->id_ac,
            'lokasi' => $request->lokasi,
        ]);

        return back()->with('success', "ID AC {$request->id_ac} berhasil diperbarui.");
    }

    public function destroy(MasterAc $master_ac)
    {
        $id_ac = $master_ac->id_ac;
        $master_ac->delete();
        return back()->with('success', "ID AC {$id_ac} berhasil dihapus.");
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\FormPemeliharaanAc\MasterAcImport, $request->file('file'));
            return back()->with('success', 'Data AC berhasil diimpor!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('AC Import Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat impor data. Pastikan format file benar.');
        }
    }

    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\FormPemeliharaanAc\MasterAcTemplateExport, 'Template_Data_AC.xlsx');
    }
}
