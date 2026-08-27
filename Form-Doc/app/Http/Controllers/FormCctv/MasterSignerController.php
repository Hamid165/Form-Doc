<?php

namespace App\Http\Controllers\FormCctv;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormCctv\MasterSigner;

class MasterSignerController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nipp' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
        ]);

        MasterSigner::create($request->all());

        return back()->with('success', "Penandatangan {$request->nama} berhasil ditambahkan.");
    }

    public function update(Request $request, MasterSigner $master_signer)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nipp' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
        ]);

        $oldNama = $master_signer->nama;

        $master_signer->update($request->all());

        // Update existing forms that used this old name
        \App\Models\FormCctv\FormCctv::where('mengetahui_nama', $oldNama)->update([
            'mengetahui_nama' => $master_signer->nama,
            'mengetahui_nipp' => $master_signer->nipp,
            'mengetahui_jabatan' => $master_signer->jabatan,
        ]);

        \App\Models\FormPencabutanHakAkses\FormPencabutanHakAkses::where('mengetahui_nama', $oldNama)->update([
            'mengetahui_nama' => $request->nama,
            'jabatan_mengetahui' => $request->jabatan,
        ]);

        return back()->with('success', "Penandatangan {$request->nama} berhasil diperbarui.");
    }

    public function destroy(MasterSigner $master_signer)
    {
        $nama = $master_signer->nama;
        $master_signer->delete();
        return back()->with('success', "Penandatangan {$nama} berhasil dihapus.");
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(
                new \App\Imports\FormPemeliharaan\MasterSignerImport,
                $request->file('file')
            );
            return back()->with('success', 'Data penandatangan berhasil diimpor!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Signer Import Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat impor data. Pastikan format file benar.');
        }
    }

    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\FormPemeliharaan\MasterSignerTemplateExport,
            'Template_Data_Penandatangan.xlsx'
        );
    }
}
