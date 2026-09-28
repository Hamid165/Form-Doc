<?php

namespace App\Http\Controllers\FormSerahTerimaUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormSerahTerimaUser\MasterSerahTerimaUser;

class MasterSerahTerimaUserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nipp' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'tempat_kedudukan' => 'nullable|string|max:255',
            'personal_area' => 'nullable|string|max:255',
        ]);
        
        $nipp = $request->nipp ?: '';
        if ($nipp !== '') {
            $exists = MasterSerahTerimaUser::where('nipp', $nipp)->exists();
            if ($exists) {
                return redirect()->back()->with('error', 'Gagal! NIPP/No Identitas tersebut sudah digunakan.')->withInput();
            }
        }

        MasterSerahTerimaUser::create([
            'nama' => $request->nama,
            'nipp' => $request->nipp ?: '',
            'jabatan' => $request->jabatan ?: '',
            'tempat_kedudukan' => $request->tempat_kedudukan ?: '',
            'personal_area' => $request->personal_area ?: '',
        ]);

        return redirect()->back()->with('success', 'Data Master User berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nipp' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'tempat_kedudukan' => 'nullable|string|max:255',
            'personal_area' => 'nullable|string|max:255',
        ]);
        
        $nipp = $request->nipp ?: '';
        if ($nipp !== '') {
            $exists = MasterSerahTerimaUser::where('nipp', $nipp)->where('id', '!=', $id)->exists();
            if ($exists) {
                return redirect()->back()->with('error', 'Gagal! NIPP/No Identitas tersebut sudah digunakan.')->withInput();
            }
        }

        $user = MasterSerahTerimaUser::findOrFail($id);
        
        $user->update([
            'nama' => $request->nama,
            'nipp' => $request->nipp ?: '',
            'jabatan' => $request->jabatan ?: '',
            'tempat_kedudukan' => $request->tempat_kedudukan ?: '',
            'personal_area' => $request->personal_area ?: '',
        ]);

        return redirect()->back()->with('success', 'Data Master User berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = MasterSerahTerimaUser::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Data Master User berhasil dihapus!');
    }
}
