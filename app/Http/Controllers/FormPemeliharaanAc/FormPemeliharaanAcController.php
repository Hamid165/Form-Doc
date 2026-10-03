<?php

namespace App\Http\Controllers\FormPemeliharaanAc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\FormPemeliharaanAc\FormPemeliharaanAc;
use App\Models\FormPemeliharaanAc\FormPemeliharaanAcItem;
use App\Models\FormPemeliharaanAc\MasterAc;
use App\Models\FormCctv\MasterSigner;

class FormPemeliharaanAcController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        
        $forms = FormPemeliharaanAc::when($search, function ($query, $search) {
            return $query->where('no_ref', 'like', "%{$search}%")
                         ->orWhere('id_ac', 'like', "%{$search}%")
                         ->orWhere('lokasi', 'like', "%{$search}%");
        })->orderBy('created_at', 'desc')->paginate(5, ['*'], 'form_page');
        
        $forms->appends(['search' => $search]);
        
        $masterAcs = MasterAc::orderBy('id_ac', 'asc')->paginate(5, ['*'], 'ac_page');
        $masterSigners = MasterSigner::orderBy('nama', 'asc')->paginate(5, ['*'], 'signer_page');
        return view('form-pemeliharaan-ac.index', compact('forms', 'masterAcs', 'masterSigners', 'search'));
    }

    public function create()
    {
        $usedIds = FormPemeliharaanAc::pluck('id_ac')->toArray();
        $masterAcs = MasterAc::whereNotIn('id_ac', $usedIds)->orderBy('id_ac', 'asc')->get();
        $masterSigners = MasterSigner::orderBy('nama', 'asc')->get();
        $formTemplate = \App\Models\FormTemplate::where('nama', 'Checklist Pemeliharaan AC')->first();
        return view('form-pemeliharaan-ac.create', compact('masterAcs', 'masterSigners', 'formTemplate'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no_ref' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'business_area' => 'nullable|string|max:255',
            'id_ac' => 'nullable|string|max:255|unique:form_pemeliharaan_acs,id_ac',
            'lokasi' => 'nullable|string|max:255',
            'items' => 'nullable|array',
            'items.*.tanggal' => 'nullable|string|max:255|distinct',
            'items.*.perawatan' => 'nullable',
            'items.*.perbaikan' => 'nullable',
            'items.*.keterangan' => 'nullable|string',
            'items.*.paraf' => 'nullable|string',
            'kota_tanggal' => 'nullable|string',
            'mengetahui_nama' => 'nullable|string|max:255',
            'mengetahui_nipp' => 'nullable|string|max:255',
            'mengetahui_jabatan' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
        ], [
            'items.*.tanggal.distinct' => 'Tanggal kegiatan pemeliharaan tidak boleh ada yang sama.'
        ]);

        $form = FormPemeliharaanAc::create([
            'no_ref' => $validatedData['no_ref'] ?? null,
            'tanggal' => $validatedData['tanggal'] ?? null,
            'business_area' => $validatedData['business_area'] ?? null,
            'id_ac' => $validatedData['id_ac'] ?? null,
            'lokasi' => $validatedData['lokasi'] ?? null,
            'kota_tanggal' => $validatedData['kota_tanggal'] ?? null,
            'mengetahui_nama' => $validatedData['mengetahui_nama'] ?? null,
            'mengetahui_nipp' => $validatedData['mengetahui_nipp'] ?? null,
            'mengetahui_jabatan' => $validatedData['mengetahui_jabatan'] ?? null,
            'catatan' => $validatedData['catatan'] ?? null,
        ]);

        // Update all other forms' business area if it was provided
        if (!empty($validatedData['business_area'])) {
            FormPemeliharaanAc::where('id', '!=', $form->id)->update(['business_area' => $validatedData['business_area']]);
        }

        if (isset($validatedData['items']) && is_array($validatedData['items'])) {
            foreach ($validatedData['items'] as $index => $itemData) {
                // Skip completely empty rows
                if (empty($itemData['tanggal']) && empty($itemData['keterangan']) && empty($itemData['paraf']) && empty($itemData['perawatan']) && empty($itemData['perbaikan'])) {
                    continue;
                }

                $no = $index;
                
                $perawatan = isset($itemData['perawatan']) ? 'V' : '-';
                $perbaikan = isset($itemData['perbaikan']) ? 'V' : '-';
                $jenis_kegiatan = json_encode(['perawatan' => $perawatan, 'perbaikan' => $perbaikan]);
                
                FormPemeliharaanAcItem::create([
                    'form_pemeliharaan_ac_id' => $form->id,
                    'no' => $no,
                    'tanggal' => $itemData['tanggal'] ?? null,
                    'jenis_kegiatan' => $jenis_kegiatan,
                    'keterangan' => $itemData['keterangan'] ?? null,
                    'paraf' => $itemData['paraf'] ?? null,
                ]);
            }
        }

        return redirect()->route('form-pemeliharaan-ac.index')->with('success', "Formulir {$form->id_ac} Berhasil Ditambahkan.");
    }

    public function show(string $id)
    {
        $form = FormPemeliharaanAc::with('items')->findOrFail($id);
        $formTemplate = \App\Models\FormTemplate::where('nama', 'Checklist Pemeliharaan AC')->first();
        return view('form-pemeliharaan-ac.show', compact('form', 'formTemplate'));
    }

    public function edit(string $id)
    {
        $form = FormPemeliharaanAc::with('items')->findOrFail($id);
        
        // Prepare items array indexed by $no - 1
        $items = [];
        foreach ($form->items as $item) {
            $items[$item->no - 1] = $item;
        }
        
        $masterAcs = MasterAc::orderBy('id_ac', 'asc')->get();
        $masterSigners = MasterSigner::orderBy('nama', 'asc')->get();
        $formTemplate = \App\Models\FormTemplate::where('nama', 'Checklist Pemeliharaan AC')->first();
        
        return view('form-pemeliharaan-ac.edit', compact('form', 'items', 'masterAcs', 'masterSigners', 'formTemplate'));
    }

    public function update(Request $request, string $id)
    {
        $form = FormPemeliharaanAc::findOrFail($id);
        
        $validatedData = $request->validate([
            'no_ref' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'business_area' => 'nullable|string|max:255',
            'id_ac' => 'nullable|string|max:255|unique:form_pemeliharaan_acs,id_ac,' . $form->id,
            'lokasi' => 'nullable|string|max:255',
            'items' => 'nullable|array',
            'items.*.tanggal' => 'nullable|string|max:255|distinct',
            'items.*.perawatan' => 'nullable',
            'items.*.perbaikan' => 'nullable',
            'items.*.keterangan' => 'nullable|string',
            'items.*.paraf' => 'nullable|string',
            'kota_tanggal' => 'nullable|string',
            'mengetahui_nama' => 'nullable|string|max:255',
            'mengetahui_nipp' => 'nullable|string|max:255',
            'mengetahui_jabatan' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
        ], [
            'items.*.tanggal.distinct' => 'Tanggal kegiatan pemeliharaan tidak boleh ada yang sama.'
        ]);

        $form->update([
            'no_ref' => $validatedData['no_ref'] ?? null,
            'tanggal' => $validatedData['tanggal'] ?? null,
            'business_area' => $validatedData['business_area'] ?? null,
            'id_ac' => $validatedData['id_ac'] ?? null,
            'lokasi' => $validatedData['lokasi'] ?? null,
            'kota_tanggal' => $validatedData['kota_tanggal'] ?? null,
            'mengetahui_nama' => $validatedData['mengetahui_nama'] ?? null,
            'mengetahui_nipp' => $validatedData['mengetahui_nipp'] ?? null,
            'mengetahui_jabatan' => $validatedData['mengetahui_jabatan'] ?? null,
            'catatan' => $validatedData['catatan'] ?? null,
        ]);

        if (!empty($validatedData['business_area'])) {
            FormPemeliharaanAc::where('id', '!=', $form->id)->update(['business_area' => $validatedData['business_area']]);
        }

        // Delete existing items and recreate
        $form->items()->delete();

        if (isset($validatedData['items']) && is_array($validatedData['items'])) {
            foreach ($validatedData['items'] as $index => $itemData) {
                if (empty($itemData['tanggal']) && empty($itemData['keterangan']) && empty($itemData['paraf']) && empty($itemData['perawatan']) && empty($itemData['perbaikan'])) {
                    continue;
                }

                $no = $index;
                
                $perawatan = isset($itemData['perawatan']) ? 'V' : '-';
                $perbaikan = isset($itemData['perbaikan']) ? 'V' : '-';
                $jenis_kegiatan = json_encode(['perawatan' => $perawatan, 'perbaikan' => $perbaikan]);
                
                FormPemeliharaanAcItem::create([
                    'form_pemeliharaan_ac_id' => $form->id,
                    'no' => $no,
                    'tanggal' => $itemData['tanggal'] ?? null,
                    'jenis_kegiatan' => $jenis_kegiatan,
                    'keterangan' => $itemData['keterangan'] ?? null,
                    'paraf' => $itemData['paraf'] ?? null,
                ]);
            }
        }

        return redirect()->route('form-pemeliharaan-ac.index')->with('success', "Formulir {$form->id_ac} Berhasil Diperbarui.");
    }

    public function destroy(string $id)
    {
        $form = FormPemeliharaanAc::findOrFail($id);
        $form->delete();
        
        return redirect()->route('form-pemeliharaan-ac.index')->with('success', "Formulir {$form->id_ac} Berhasil Dihapus.");
    }

    public function parseExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048'
        ]);

        try {
            $import = new \App\Imports\FormPemeliharaanAc\FormPemeliharaanAcItemImport();
            $data = \Maatwebsite\Excel\Facades\Excel::toCollection($import, $request->file('file'))->first();
            
            // Format data from collection
            $formattedData = $import->collection($data);

            return response()->json([
                'success' => true,
                'data' => $formattedData
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Form AC Parse Excel Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membaca file Excel. Pastikan format file benar.'
            ], 500);
        }
    }

    public function downloadTemplateItems()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\FormPemeliharaanAc\FormPemeliharaanAcItemTemplateExport, 'Template_Isi_Tabel_AC.xlsx');
    }
}
