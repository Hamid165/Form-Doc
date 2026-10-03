<?php

namespace App\Http\Controllers\FormApar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormApar\MasterSigner;

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

        $master_signer->update($request->all());

        return back()->with('success', "Penandatangan {$request->nama} berhasil diperbarui.");
    }

    public function destroy(MasterSigner $master_signer)
    {
        $nama = $master_signer->nama;
        $master_signer->delete();
        return back()->with('success', "Penandatangan {$nama} berhasil dihapus.");
    }
}
