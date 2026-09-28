<?php

namespace App\Http\Controllers\FormRencanaPelatihan;

use App\Http\Controllers\Controller;
use App\Models\FormRencanaPelatihan\MasterPenandatanganRencana;
use Illuminate\Http\Request;

class MasterPenandatanganRencanaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'nipp' => 'nullable|string|max:255',
        ]);
        MasterPenandatanganRencana::create($request->all());
        return back()->with('success', 'Data penandatangan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $signer = MasterPenandatanganRencana::findOrFail($id);
        $signer->update($request->all());
        return back()->with('success', 'Data penandatangan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        MasterPenandatanganRencana::findOrFail($id)->delete();
        return back()->with('success', 'Data penandatangan berhasil dihapus.');
    }
}
