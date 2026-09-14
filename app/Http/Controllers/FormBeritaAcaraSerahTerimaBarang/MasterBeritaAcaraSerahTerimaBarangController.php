<?php

namespace App\Http\Controllers\FormBeritaAcaraSerahTerimaBarang;

use App\Http\Controllers\Controller;
use App\Models\FormBeritaAcaraSerahTerimaBarang\MasterBeritaAcaraSerahTerimaBarang;
use Illuminate\Http\Request;

class MasterBeritaAcaraSerahTerimaBarangController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        $data['nipp'] = $request->input('nipp', '-');

        MasterBeritaAcaraSerahTerimaBarang::create($data);
        return back()->with('success', 'Penandatangan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
        ]);

        $signer = MasterBeritaAcaraSerahTerimaBarang::findOrFail($id);
        $signer->update($request->all());
        return back()->with('success', 'Penandatangan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $signer = MasterBeritaAcaraSerahTerimaBarang::findOrFail($id);
        $signer->delete();
        return back()->with('success', 'Penandatangan berhasil dihapus.');
    }
}
