<?php

namespace App\Http\Controllers\FormBaStockOpname;

use App\Http\Controllers\Controller;
use App\Models\FormBaStockOpname\MasterBaStock;
use Illuminate\Http\Request;

class MasterBAStockController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'nipp' => 'nullable|string|max:255', // Tambahkan validasi untuk NIPP
        ]);

        // Langsung simpan data dari request (tidak perlu dimanipulasi lagi)
        MasterBaStock::create($request->all());

        return back()->with('success', 'Penandatangan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
        ]);

        $signer = MasterBaStock::findOrFail($id);
        $signer->update($request->all());
        return back()->with('success', 'Penandatangan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $signer = MasterBaStock::findOrFail($id);
        $signer->delete();
        return back()->with('success', 'Penandatangan berhasil dihapus.');
    }
}
