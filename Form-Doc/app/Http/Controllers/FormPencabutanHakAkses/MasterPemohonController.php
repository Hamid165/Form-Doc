<?php

namespace App\Http\Controllers\FormPencabutanHakAkses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormPencabutanHakAkses\MasterPemohon;

class MasterPemohonController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_pemohon_master' => 'required|string|max:255',
            'nip_pemohon_master' => 'nullable|string|max:255',
        ]);
        
        $nip = $request->nip_pemohon_master ?: '';
        if ($nip !== '') {
            $nipExists = MasterPemohon::where('nip_pemohon', $nip)->exists();
            if ($nipExists) {
                return redirect()->back()->with('error', 'Gagal! NIP tersebut sudah digunakan oleh data pemohon lain.')->withInput();
            }
        }

        MasterPemohon::create([
            'nama_pemohon' => $request->nama_pemohon_master,
            'nip_pemohon' => $request->nip_pemohon_master ?: '',
        ]);

        return redirect()->back()->with('success', 'Data Pemohon berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pemohon_master' => 'required|string|max:255',
            'nip_pemohon_master' => 'nullable|string|max:255',
        ]);
        
        $nip = $request->nip_pemohon_master ?: '';
        if ($nip !== '') {
            $nipExists = MasterPemohon::where('nip_pemohon', $nip)->where('id', '!=', $id)->exists();
            if ($nipExists) {
                return redirect()->back()->with('error', 'Gagal! NIP tersebut sudah digunakan oleh data pemohon lain.')->withInput();
            }
        }

        $pemohon = MasterPemohon::findOrFail($id);
        
        $oldNama = $pemohon->nama_pemohon;
        $oldNip = $pemohon->nip_pemohon;
        
        $newNama = $request->nama_pemohon_master;
        $newNip = $request->nip_pemohon_master ?: '';
        
        $pemohon->update([
            'nama_pemohon' => $newNama,
            'nip_pemohon' => $newNip,
        ]);
        
        // CASCADING UPDATE: Jika nama atau NIP berubah, update semua form historis yang terkait
        if ($oldNama !== $newNama || $oldNip !== $newNip) {
            // Update nama_pemohon dan nip_pemohon di tabel utama
            \App\Models\FormPencabutanHakAkses\FormPencabutanHakAkses::where('nama_pemohon', $oldNama)
                ->where('nip_pemohon', $oldNip)
                ->update([
                    'nama_pemohon' => $newNama,
                    'nip_pemohon' => $newNip,
                ]);
                
            // Update nama Penandatangan (Mengetahui) jika dulunya sama
            \App\Models\FormPencabutanHakAkses\FormPencabutanHakAkses::where('mengetahui_nama', $oldNama)
                ->update(['mengetahui_nama' => $newNama]);
                
            // Update nama_pengguna di dalam tabel Item Formulir
            $oldNamaPengguna = $oldNama . ($oldNip ? ' - ' . $oldNip : '');
            $newNamaPengguna = $newNama . ($newNip ? ' - ' . $newNip : '');
            
            \App\Models\FormPencabutanHakAkses\FormPencabutanHakAksesItem::where('nama_pengguna', $oldNamaPengguna)
                ->update(['nama_pengguna' => $newNamaPengguna]);
        }

        return redirect()->back()->with('success', 'Data Pemohon berhasil diperbarui dan disinkronkan!');
    }

    public function destroy($id)
    {
        $pemohon = MasterPemohon::findOrFail($id);
        $pemohon->delete();

        return redirect()->back()->with('success', 'Data Pemohon berhasil dihapus!');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            $import = new \App\Imports\FormPencabutanHakAkses\MasterPemohonImport;
            \Excel::import($import, $request->file('file'));
            
            return redirect()->back()->with('success', $import->importedCount . ' data Pemohon baru berhasil diimpor!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Pemohon Import Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat impor data. Pastikan format file benar.');
        }
    }

    public function downloadTemplate()
    {
        return \Excel::download(new \App\Exports\FormPencabutanHakAkses\MasterPemohonTemplateExport, 'Template_Data_Pemohon.xlsx');
    }
}
