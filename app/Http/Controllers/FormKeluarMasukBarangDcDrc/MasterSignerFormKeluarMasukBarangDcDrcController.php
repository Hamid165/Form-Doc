<?php

namespace App\Http\Controllers\FormKeluarMasukBarangDcDrc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormCctv\MasterSigner;

class MasterSignerFormKeluarMasukBarangDcDrcController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jabatan' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'nipp' => 'required|string|max:255',
        ]);

        MasterSigner::create($validated);

        return redirect()->route('form-keluar-masuk-barang-dc-drc.index', ['tab' => 'master'])->with('success', 'Data petugas berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $signer = MasterSigner::findOrFail($id);

        $validated = $request->validate([
            'jabatan' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'nipp' => 'required|string|max:255',
        ]);

        $signer->update($validated);

        return redirect()->route('form-keluar-masuk-barang-dc-drc.index', ['tab' => 'master'])->with('success', 'Data petugas berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $signer = MasterSigner::findOrFail($id);
        $signer->delete();

        return redirect()->route('form-keluar-masuk-barang-dc-drc.index', ['tab' => 'master'])->with('success', 'Data petugas berhasil dihapus.');
    }
}
