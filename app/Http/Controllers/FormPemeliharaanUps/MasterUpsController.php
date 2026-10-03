<?php

namespace App\Http\Controllers\FormPemeliharaanUps;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormPemeliharaanUps\MasterUps;

class MasterUpsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nomor_inventaris' => 'required|string|max:255|unique:master_ups,nomor_inventaris',
            'lokasi' => 'required|string|max:255',
        ], [
            'nomor_inventaris.unique' => 'Nomor Inventaris ini sudah terdaftar di database. Silakan gunakan nomor yang berbeda.',
        ]);

        MasterUps::create($request->all());

        return back()->with('success', "Nomor Inventaris {$request->nomor_inventaris} berhasil ditambahkan.");
    }

    public function update(Request $request, MasterUps $master_up)
    {
        $request->validate([
            'nomor_inventaris' => 'required|string|max:255|unique:master_ups,nomor_inventaris,' . $master_up->id,
            'lokasi' => 'required|string|max:255',
        ], [
            'nomor_inventaris.unique' => 'Nomor Inventaris ini sudah terdaftar di database. Silakan gunakan nomor yang berbeda.',
        ]);

        $oldNomorInventaris = $master_up->nomor_inventaris;

        $master_up->update($request->all());

        // Update existing forms that used the old Nomor Inventaris
        \App\Models\FormPemeliharaanUps\FormPemeliharaanUps::where('nomor_inventaris', $oldNomorInventaris)->update([
            'nomor_inventaris' => $request->nomor_inventaris,
            'lokasi' => $request->lokasi,
        ]);

        return back()->with('success', "Nomor Inventaris {$request->nomor_inventaris} berhasil diperbarui.");
    }

    public function destroy(MasterUps $master_up)
    {
        $nomorInventaris = $master_up->nomor_inventaris;
        $master_up->delete();
        return back()->with('success', "Nomor Inventaris {$nomorInventaris} berhasil dihapus.");
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\FormPemeliharaanUps\MasterUpsImport, $request->file('file'));
            return back()->with('success', 'Data UPS berhasil diimpor!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('UPS Import Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat impor data. Pastikan format file benar.');
        }
    }

    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\FormPemeliharaanUps\MasterUpsTemplateExport, 'Template_Data_UPS.xlsx');
    }
}
