<?php

namespace App\Http\Controllers\FormPemusnahan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormPemusnahan\DataPemohon;

class DataPemohonController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:100',
        ]);

        DataPemohon::firstOrCreate([
            'nama' => $request->nama,
            'nip' => $request->nip,
        ]);

        return redirect()->route('form-pemusnahan.index', ['tab' => 'pemohon'])->with('success', 'Data pemohon berhasil ditambahkan.');
    }

    public function update(Request $request, DataPemohon $data_pemohon)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:100',
        ]);

        $data_pemohon->update($request->only(['nama', 'nip']));

        return redirect()->route('form-pemusnahan.index', ['tab' => 'pemohon'])->with('success', 'Data pemohon berhasil diperbarui.');
    }

    public function destroy(DataPemohon $data_pemohon)
    {
        $data_pemohon->delete();

        return redirect()->route('form-pemusnahan.index', ['tab' => 'pemohon'])->with('success', 'Data pemohon berhasil dihapus.');
    }
}
