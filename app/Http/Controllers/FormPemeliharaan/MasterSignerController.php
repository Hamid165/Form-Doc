<?php

namespace App\Http\Controllers\FormPemeliharaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormPemeliharaan\MasterSigner;

class MasterSignerController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'    => 'required|string|max:255',
            'nipp'    => 'required|string|max:100|unique:master_signers,nipp',
            'jabatan' => 'nullable|string|max:255',
        ]);

        MasterSigner::create($validated);
        return back()->with('success', 'Penanda tangan berhasil ditambahkan.');
    }

    public function update(Request $request, MasterSigner $form_pemeliharaan_signer)
    {
        $validated = $request->validate([
            'nama'    => 'required|string|max:255',
            'nipp'    => 'required|string|max:100|unique:master_signers,nipp,' . $form_pemeliharaan_signer->id,
            'jabatan' => 'nullable|string|max:255',
        ]);

        $form_pemeliharaan_signer->update($validated);
        return back()->with('success', 'Data penanda tangan berhasil diperbarui.');
    }

    public function destroy(MasterSigner $form_pemeliharaan_signer)
    {
        $form_pemeliharaan_signer->delete();
        return back()->with('success', 'Penanda tangan berhasil dihapus.');
    }
}
