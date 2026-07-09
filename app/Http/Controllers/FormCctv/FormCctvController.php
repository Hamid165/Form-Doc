<?php

namespace App\Http\Controllers\FormCctv;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // need to import base controller

use App\Models\FormCctv\FormCctv;
use App\Models\FormCctv\FormCctvItem;
use App\Models\FormCctv\MasterCctv;
use App\Models\FormCctv\MasterSigner;
class FormCctvController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        
        $forms = FormCctv::when($search, function ($query, $search) {
            return $query->where('no_ref', 'like', "%{$search}%")
                         ->orWhere('id_cctv', 'like', "%{$search}%")
                         ->orWhere('lokasi', 'like', "%{$search}%");
        })->orderBy('created_at', 'desc')->paginate(5, ['*'], 'form_page');
        
        $forms->appends(['search' => $search]);
        
        $masterCctvs = MasterCctv::orderBy('id_cctv', 'asc')->paginate(5, ['*'], 'cctv_page');
        $masterSigners = MasterSigner::orderBy('nama', 'asc')->paginate(5, ['*'], 'signer_page');
        return view('form-cctv.index', compact('forms', 'masterCctvs', 'masterSigners', 'search'));
    }

    public function create()
    {
        $usedIds = FormCctv::pluck('id_cctv')->toArray();
        $masterCctvs = MasterCctv::whereNotIn('id_cctv', $usedIds)->orderBy('id_cctv', 'asc')->get();
        $masterSigners = MasterSigner::orderBy('nama', 'asc')->get();
        $formTemplate = \App\Models\FormTemplate::where('nama', 'Pemeliharaan CCTV')->first();
        return view('form-cctv.create', compact('masterCctvs', 'masterSigners', 'formTemplate'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no_ref' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'business_area' => 'nullable|string|max:255',
            'id_cctv' => 'nullable|string|max:255|unique:form_cctvs,id_cctv',
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
        ], [
            'items.*.tanggal.distinct' => 'Tanggal kegiatan pemeliharaan tidak boleh ada yang sama.'
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
            'mengetahui_jabatan' => $validatedData['mengetahui_jabatan'] ?? null,
        ]);

        // Update all other forms' business area if it was provided
        if (!empty($validatedData['business_area'])) {
            FormCctv::where('id', '!=', $form->id)->update(['business_area' => $validatedData['business_area']]);
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
        $formTemplate = \App\Models\FormTemplate::where('nama', 'Pemeliharaan CCTV')->first();
        return view('form-cctv.show', compact('form', 'formTemplate'));
    }

    public function edit(string $id)
    {
        $form = FormCctv::with('items')->findOrFail($id);
        
        // Prepare items array indexed by $no - 1
        $items = [];
        foreach ($form->items as $item) {
            $items[$item->no - 1] = $item;
        }
        
        $masterCctvs = MasterCctv::orderBy('id_cctv', 'asc')->get();
        $masterSigners = MasterSigner::orderBy('nama', 'asc')->get();
        $formTemplate = \App\Models\FormTemplate::where('nama', 'Pemeliharaan CCTV')->first();
        
        return view('form-cctv.edit', compact('form', 'items', 'masterCctvs', 'masterSigners', 'formTemplate'));
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
            'items.*.tanggal' => 'nullable|string|max:255|distinct',
            'items.*.perawatan' => 'nullable',
            'items.*.perbaikan' => 'nullable',
            'items.*.keterangan' => 'nullable|string',
            'items.*.paraf' => 'nullable|string',
            'kota_tanggal' => 'nullable|string',
            'mengetahui_nama' => 'nullable|string|max:255',
            'mengetahui_nipp' => 'nullable|string|max:255',
            'mengetahui_jabatan' => 'nullable|string|max:255',
        ], [
            'items.*.tanggal.distinct' => 'Tanggal kegiatan pemeliharaan tidak boleh ada yang sama.'
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
            'mengetahui_jabatan' => $validatedData['mengetahui_jabatan'] ?? null,
        ]);

        // Update all other forms' business area if it was provided
        if (!empty($validatedData['business_area'])) {
            FormCctv::where('id', '!=', $form->id)->update(['business_area' => $validatedData['business_area']]);
        }
        
        $form->items()->delete(); // recreate items for simplicity

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

    public function parseExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048'
        ]);

        try {
            $import = new \App\Imports\FormCctv\FormCctvItemImport();
            $data = \Maatwebsite\Excel\Facades\Excel::toCollection($import, $request->file('file'))->first();
            
            // Format data from collection
            $formattedData = $import->collection($data);

            return response()->json([
                'success' => true,
                'data' => $formattedData
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Form CCTV Parse Excel Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membaca file Excel. Pastikan format file benar.'
            ], 500);
        }
    }

    public function downloadTemplateItems()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\FormCctv\FormCctvItemTemplateExport, 'Template_Isi_Tabel_CCTV.xlsx');
    }

    public function destroy(string $id)
    {
        $form = FormCctv::findOrFail($id);
        $form->delete();
        
        return redirect()->route('form-cctv.index')->with('success', "Formulir {$form->id_cctv} Berhasil Dihapus.");
    }
}
