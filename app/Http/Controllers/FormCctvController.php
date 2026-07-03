<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FormCctv;
use App\Models\FormCctvItem;

class FormCctvController extends Controller
{
    public function index()
    {
        $forms = FormCctv::orderBy('created_at', 'desc')->get();
        return view('form-cctv.index', compact('forms'));
    }

    public function create()
    {
        return view('form-cctv.create');
    }

    public function createV2()
    {
        return view('form-cctv.create-v2');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no_ref' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'business_area' => 'nullable|string|max:255',
            'id_cctv' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'items' => 'nullable|array',
            'items.*.tanggal' => 'nullable|string|max:255',
            'items.*.perawatan' => 'nullable',
            'items.*.perbaikan' => 'nullable',
            'items.*.keterangan' => 'nullable|string',
            'items.*.paraf' => 'nullable|string',
            'kota_tanggal' => 'nullable|string',
            'mengetahui_nama' => 'nullable|string|max:255',
            'mengetahui_nipp' => 'nullable|string|max:255',
        ]);

        $form = FormCctv::create([
            'no_ref' => $validatedData['no_ref'] ?? null,
            'tanggal' => $validatedData['tanggal'] ?? null,
            'business_area' => $validatedData['business_area'] ?? null,
            'id_cctv' => $validatedData['id_cctv'] ?? null,
            'lokasi' => $validatedData['lokasi'] ?? null,
            'kota_tanggal' => $validatedData['kota_tanggal'] ?? null,
            'mengetahui_nama' => $validatedData['mengetahui_nama'] ?? null,
            'mengetahui_nipp' => $validatedData['mengetahui_nipp'] ?? null,
        ]);

        if (isset($validatedData['items']) && is_array($validatedData['items'])) {
            foreach ($validatedData['items'] as $index => $itemData) {
                $no = $index;
                
                // Determine jenis_kegiatan based on checkboxes.
                // If both are checked, we can store a specific value, but the schema uses enum('perawatan', 'perbaikan'). 
                // Wait, if we use enum, we can't store both. Let's change how we store it or just save the first one checked.
                // Or better, let's just save JSON or modify the schema if needed.
                // Since the user asked for checkboxes, if checked = 'V', if unchecked = '-'. 
                // The current schema is enum('perawatan', 'perbaikan'). I should alter it to store checkboxes state as string or two columns.
                // Actually, let's just bypass the enum issue by updating the schema or just relying on strings if enum allows it, but enum is strict.
                // I will update the migration later, or for now, just save it as string if the DB is SQLite, but Laragon uses MySQL.
                // Let's modify the migration or use a simpler approach. I'll pass 'perawatan' or 'perbaikan' or null.
                
                $perawatan = isset($itemData['perawatan']) ? 'V' : '-';
                $perbaikan = isset($itemData['perbaikan']) ? 'V' : '-';
                $jenis_kegiatan = json_encode(['perawatan' => $perawatan, 'perbaikan' => $perbaikan]);
                
                FormCctvItem::create([
                    'form_cctv_id' => $form->id,
                    'no' => $no,
                    'tanggal' => $itemData['tanggal'] ?? null,
                    'jenis_kegiatan' => $jenis_kegiatan,
                    'keterangan' => $itemData['keterangan'] ?? null,
                    'paraf' => $itemData['paraf'] ?? null,
                ]);
            }
        }

        return redirect()->route('form-cctv.index')->with('success', "Formulir {$form->id_cctv} Berhasil Ditambahkan.");
    }

    public function show(string $id)
    {
        $form = FormCctv::with('items')->findOrFail($id);
        return view('form-cctv.show', compact('form'));
    }

    public function edit(string $id)
    {
        $form = FormCctv::with('items')->findOrFail($id);
        
        // Prepare items array indexed by $no - 1
        $items = [];
        foreach ($form->items as $item) {
            $items[$item->no - 1] = $item;
        }
        
        return view('form-cctv.edit', compact('form', 'items'));
    }

    public function update(Request $request, string $id)
    {
        $form = FormCctv::findOrFail($id);
        
        $validatedData = $request->validate([
            'no_ref' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'business_area' => 'nullable|string|max:255',
            'id_cctv' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'items' => 'nullable|array',
            'items.*.tanggal' => 'nullable|string|max:255',
            'items.*.perawatan' => 'nullable',
            'items.*.perbaikan' => 'nullable',
            'items.*.keterangan' => 'nullable|string',
            'items.*.paraf' => 'nullable|string',
            'kota_tanggal' => 'nullable|string',
            'mengetahui_nama' => 'nullable|string|max:255',
            'mengetahui_nipp' => 'nullable|string|max:255',
        ]);

        $form->update([
            'no_ref' => $validatedData['no_ref'] ?? null,
            'tanggal' => $validatedData['tanggal'] ?? null,
            'business_area' => $validatedData['business_area'] ?? null,
            'id_cctv' => $validatedData['id_cctv'] ?? null,
            'lokasi' => $validatedData['lokasi'] ?? null,
            'kota_tanggal' => $validatedData['kota_tanggal'] ?? null,
            'mengetahui_nama' => $validatedData['mengetahui_nama'] ?? null,
            'mengetahui_nipp' => $validatedData['mengetahui_nipp'] ?? null,
        ]);
        
        $form->items()->delete(); // recreate items for simplicity

        if (isset($validatedData['items']) && is_array($validatedData['items'])) {
            foreach ($validatedData['items'] as $index => $itemData) {
                $no = $index;
                
                $perawatan = isset($itemData['perawatan']) ? 'V' : '-';
                $perbaikan = isset($itemData['perbaikan']) ? 'V' : '-';
                $jenis_kegiatan = json_encode(['perawatan' => $perawatan, 'perbaikan' => $perbaikan]);
                
                FormCctvItem::create([
                    'form_cctv_id' => $form->id,
                    'no' => $no,
                    'tanggal' => $itemData['tanggal'] ?? null,
                    'jenis_kegiatan' => $jenis_kegiatan,
                    'keterangan' => $itemData['keterangan'] ?? null,
                    'paraf' => $itemData['paraf'] ?? null,
                ]);
            }
        }

        return redirect()->route('form-cctv.index')->with('success', "Formulir {$form->id_cctv} Berhasil Diperbarui.");
    }

    public function destroy(string $id)
    {
        $form = FormCctv::findOrFail($id);
        $form->delete();
        
        return redirect()->route('form-cctv.index')->with('success', "Formulir {$form->id_cctv} Berhasil Dihapus.");
    }
}
