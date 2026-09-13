<?php

namespace App\Http\Controllers\FormPemeliharaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MasterPetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nipp' => 'required|string|max:255|unique:master_petugas,nipp',
        ]);

        \App\Models\FormPemeliharaan\MasterPetugas::create($request->all());

        return back()->with([
            'success' => "Petugas {$request->nama} berhasil ditambahkan.",
            'active_tab' => 'petugas'
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nipp' => 'required|string|max:255|unique:master_petugas,nipp,' . $id,
        ]);

        $petugas = \App\Models\FormPemeliharaan\MasterPetugas::findOrFail($id);
        $petugas->update($request->all());

        return back()->with([
            'success' => "Petugas {$request->nama} berhasil diperbarui.",
            'active_tab' => 'petugas'
        ]);
    }

    public function destroy($id)
    {
        $petugas = \App\Models\FormPemeliharaan\MasterPetugas::findOrFail($id);
        $nama = $petugas->nama;
        $petugas->delete();
        
        return back()->with([
            'success' => "Petugas {$nama} berhasil dihapus.",
            'active_tab' => 'petugas'
        ]);
    }

}
