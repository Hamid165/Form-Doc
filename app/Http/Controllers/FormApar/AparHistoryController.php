<?php

namespace App\Http\Controllers\FormApar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormApar\AparHistory;

class AparHistoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'master_apar_id'    => 'required|exists:master_apars,id',
            'jenis_perubahan'   => 'nullable|string|max:100',
            'data_lama'         => 'nullable|string|max:255',
            'data_baru'         => 'nullable|string|max:255',
            'kode_aset_lama'    => 'nullable|string|max:100',
            'kode_aset_baru'    => 'nullable|string|max:100',
            'tanggal_perubahan' => 'nullable|date',
            'keterangan'        => 'nullable|string',
        ]);

        $data = $request->all();
        if (empty($data['kode_aset_lama'])) {
            $data['kode_aset_lama'] = $data['data_lama'] ?? null;
        }
        if (empty($data['kode_aset_baru'])) {
            $data['kode_aset_baru'] = $data['data_baru'] ?? null;
        }
        if (empty($data['data_lama'])) {
            $data['data_lama'] = $data['kode_aset_lama'] ?? null;
        }
        if (empty($data['data_baru'])) {
            $data['data_baru'] = $data['kode_aset_baru'] ?? null;
        }

        AparHistory::create($data);

        return back()->with('success', "History perubahan aset berhasil dicatat.");
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'master_apar_id'    => 'required|exists:master_apars,id',
            'jenis_perubahan'   => 'nullable|string|max:100',
            'data_lama'         => 'nullable|string|max:255',
            'data_baru'         => 'nullable|string|max:255',
            'kode_aset_lama'    => 'nullable|string|max:100',
            'kode_aset_baru'    => 'nullable|string|max:100',
            'tanggal_perubahan' => 'nullable|date',
            'keterangan'        => 'nullable|string',
        ]);

        $data = $request->all();
        if (empty($data['kode_aset_lama'])) {
            $data['kode_aset_lama'] = $data['data_lama'] ?? null;
        }
        if (empty($data['kode_aset_baru'])) {
            $data['kode_aset_baru'] = $data['data_baru'] ?? null;
        }
        if (empty($data['data_lama'])) {
            $data['data_lama'] = $data['kode_aset_lama'] ?? null;
        }
        if (empty($data['data_baru'])) {
            $data['data_baru'] = $data['kode_aset_baru'] ?? null;
        }

        $history = AparHistory::findOrFail($id);
        $history->update($data);

        return back()->with('success', "History perubahan aset berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $history = AparHistory::findOrFail($id);
        $history->delete();

        return back()->with('success', "History perubahan aset berhasil dihapus.");
    }
}
