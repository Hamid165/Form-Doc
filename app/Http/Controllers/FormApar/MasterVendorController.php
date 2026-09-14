<?php

namespace App\Http\Controllers\FormApar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormApar\MasterVendor;

class MasterVendorController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_vendor'           => 'required|string|max:255',
            'alamat'                => 'nullable|string',
            'nomor_telepon'         => 'nullable|string|max:50',
            'no_rekomendasi_damkar' => 'nullable|string|max:255',
        ]);

        MasterVendor::create($request->all());

        return back()->with('success', "Vendor {$request->nama_vendor} berhasil ditambahkan.");
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_vendor'           => 'required|string|max:255',
            'alamat'                => 'nullable|string',
            'nomor_telepon'         => 'nullable|string|max:50',
            'no_rekomendasi_damkar' => 'nullable|string|max:255',
        ]);

        $vendor = MasterVendor::findOrFail($id);
        $vendor->update($request->all());

        return back()->with('success', "Vendor {$request->nama_vendor} berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $vendor = MasterVendor::findOrFail($id);
        $nama = $vendor->nama_vendor;
        $vendor->delete();

        return back()->with('success', "Vendor {$nama} berhasil dihapus.");
    }
}
