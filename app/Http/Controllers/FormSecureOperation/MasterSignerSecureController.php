<?php

namespace App\Http\Controllers\FormSecureOperation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormSecureOperation\MasterSignerSecure;

class MasterSignerSecureController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nipp' => 'required|string|max:50',
            'jabatan' => 'nullable|string|max:255',
        ]);

        MasterSignerSecure::create($validatedData);

        return back()->with('success', 'Data Penandatangan Berhasil Ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $signer = MasterSignerSecure::find($id);

        if (!$signer) {
            return back()->with('error', 'Gagal Edit: Data dengan ID ' . $id . ' tidak ditemukan!');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'nipp' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
        ]);

        $signer->update([
            'nama' => $request->nama,
            'nipp' => $request->nipp,
            'jabatan' => $request->jabatan,
        ]);

        return back()->with('success', 'Data Penandatangan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $signer = MasterSignerSecure::find($id);

        if (!$signer) {
            return back()->with('error', 'Gagal Hapus: Data dengan ID ' . $id . ' tidak ditemukan!');
        }

        $signer->delete();

        return back()->with('success', 'Data Penandatangan Berhasil Dihapus.');
    }
}