<?php

namespace App\Http\Controllers\FormBackup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormBackup\FormBackup;
use App\Models\FormBackup\FormBackupItem;
use App\Models\FormBackup\MasterBackup;

class FormBackupController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        
        $forms = FormBackup::query()
        ->when($search, function ($query, $search) {
            return $query->where('no_ref', 'like', "%{$search}%")
                ->orWhere('business_area', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        $masterMetodes   = MasterBackup::query()->where('kategori', '=', 'metode')->get();
        $masterPeriodes  = MasterBackup::query()->where('kategori', '=', 'periode')->get();
        $masterRetensis  = MasterBackup::query()->where('kategori', '=', 'retensi')->get();
        $masterStatuses  = MasterBackup::query()->where('kategori', '=', 'status')->get();
        $masterPimpinans = MasterBackup::query()->where('kategori', '=', 'pimpinan')->get();
        $masterBusinessAreas = MasterBackup::where('kategori', 'business_area')->get();

        return view('form-backup.index', compact(
            'forms', 'masterMetodes', 'masterPeriodes', 
            'masterRetensis', 'masterStatuses', 'masterPimpinans', 'masterBusinessAreas'
        ));
    }

    public function create()
    {
        $masterMetodes   = MasterBackup::query()->where('kategori', '=', 'metode')->get();
        $masterPeriodes  = MasterBackup::query()->where('kategori', '=', 'periode')->get();
        $masterRetensis  = MasterBackup::query()->where('kategori', '=', 'retensi')->get();
        $masterStatuses  = MasterBackup::query()->where('kategori', '=', 'status')->get();
        $masterPimpinans = MasterBackup::query()->where('kategori', '=', 'pimpinan')->get();
        $masterBusinessAreas = MasterBackup::where('kategori', 'business_area')->get();
        return view('form-backup.create', compact(
            'masterMetodes', 'masterPeriodes', 'masterRetensis', 'masterStatuses', 'masterPimpinans', 'masterBusinessAreas'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_ref' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'business_area' => 'required|string',
        ]);

        $form = FormBackup::create($request->only([
            'no_ref', 'tanggal', 'business_area', 'doc_nomor', 'doc_tanggal', 'doc_versi',
            'kota_tanggal', 'mengetahui_nama', 'mengetahui_nipp', 'mengetahui_jabatan'
        ]));

        if ($request->has('items')) {
            foreach ($request->items as $item) {
                if (!empty($item['nama_informasi'])) {
                    $form->items()->create($item);
                }
            }
        }

        return redirect()->route('form-backup.index')->with('success', "Formulir Laporan Backup Berhasil Dibuat.");
    }

    public function show(string $id)
    {
        $form = FormBackup::with('items')->findOrFail($id);
        return view('form-backup.show', compact('form'));
    }

    public function edit(string $id)
    {
        $form = FormBackup::with('items')->findOrFail($id);
        
        $masterMetodes   = MasterBackup::query()->where('kategori', '=', 'metode')->get();
        $masterPeriodes  = MasterBackup::query()->where('kategori', '=', 'periode')->get();
        $masterRetensis  = MasterBackup::query()->where('kategori', '=', 'retensi')->get();
        $masterStatuses  = MasterBackup::query()->where('kategori', '=', 'status')->get();
        $masterPimpinans = MasterBackup::query()->where('kategori', '=', 'pimpinan')->get();
        $masterBusinessAreas = MasterBackup::where('kategori', 'business_area')->get();
        return view('form-backup.edit', compact(
            'form', 
            'masterMetodes', 'masterPeriodes', 'masterRetensis', 'masterStatuses', 'masterPimpinans', 'masterBusinessAreas'
        ));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'no_ref' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'business_area' => 'required|string',
        ]);

        $form = FormBackup::findOrFail($id);
        $form->update($request->only([
            'no_ref', 'tanggal', 'business_area', 'doc_nomor', 'doc_tanggal', 'doc_versi',
            'kota_tanggal', 'mengetahui_nama', 'mengetahui_nipp', 'mengetahui_jabatan'
        ]));

        $form->items()->delete();
        if ($request->has('items')) {
            foreach ($request->items as $item) {
                if (!empty($item['nama_informasi'])) {
                    $form->items()->create($item);
                }
            }
        }

        return redirect()->route('form-backup.index')->with('success', "Formulir Laporan Backup Berhasil Diperbarui.");
    }

    public function destroy(string $id)
    {
        $form = FormBackup::findOrFail($id);
        $form->delete();
        return redirect()->route('form-backup.index')->with('success', "Formulir Berhasil Dihapus.");
    }

    // --- FUNGSI UNTUK MASTER DATA ---

    public function storeMaster(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string',
            'nama'     => 'required|string|max:255',
            'jabatan'  => 'nullable|string|max:255',
            'nipp'     => 'nullable|string|max:255|unique:master_backups,nipp', 
        ], [
            'nipp.unique' => 'NIPP ini sudah terdaftar. Silakan gunakan NIPP lain.',
        ]);

        MasterBackup::create($request->only(['kategori', 'nama', 'jabatan', 'nipp']));

        return redirect()->back()->with('success', 'Master data berhasil ditambahkan!');
    }

    public function destroyMaster($id)
    {
        $master = MasterBackup::findOrFail($id);
        $master->delete();

        return redirect()->back()->with('success', 'Master data berhasil dihapus!');
    }

    public function updateMaster(Request $request, $id)
    {
        $request->validate([
            'nama'    => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'nipp'    => 'nullable|string|max:255|unique:master_backups,nipp,' . $id,
        ], [
            'nipp.unique' => 'NIPP ini sudah digunakan oleh data lain.',
        ]);

        $master = MasterBackup::findOrFail($id);
        $master->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'nipp' => $request->nipp,
        ]);

        return redirect()->back()->with('success', 'Data master berhasil diperbarui.');
    }
}