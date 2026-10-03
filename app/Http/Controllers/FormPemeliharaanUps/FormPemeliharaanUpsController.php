<?php

namespace App\Http\Controllers\FormPemeliharaanUps;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormPemeliharaanUps\FormPemeliharaanUps;
use App\Models\FormPemeliharaanUps\FormPemeliharaanUpsItem;
use App\Models\FormPemeliharaanUps\MasterUps;
use App\Models\FormCctv\MasterSigner;

class FormPemeliharaanUpsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $forms = FormPemeliharaanUps::when($search, function ($query, $search) {
            return $query->where('no_ref', 'like', "%{$search}%")
                         ->orWhere('nomor_inventaris', 'like', "%{$search}%")
                         ->orWhere('lokasi', 'like', "%{$search}%");
        })->orderBy('created_at', 'desc')->paginate(5, ['*'], 'form_page');

        $forms->appends(['search' => $search]);

        $masterUps = MasterUps::orderBy('nomor_inventaris', 'asc')->paginate(5, ['*'], 'ups_page');
        $masterSigners = MasterSigner::orderBy('nama', 'asc')->paginate(5, ['*'], 'signer_page');
        return view('form-pemeliharaan-ups.index', compact('forms', 'masterUps', 'masterSigners', 'search'));
    }

    public function create()
    {
        $usedIds = FormPemeliharaanUps::pluck('nomor_inventaris')->toArray();
        $masterUps = MasterUps::whereNotIn('nomor_inventaris', $usedIds)->orderBy('nomor_inventaris', 'asc')->get();
        $masterSigners = MasterSigner::orderBy('nama', 'asc')->get();
        $formTemplate = \App\Models\FormTemplate::where('nama', 'Checklist Pemeliharaan UPS')->first();
        return view('form-pemeliharaan-ups.create', compact('masterUps', 'masterSigners', 'formTemplate'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no_ref' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'business_area' => 'nullable|string|max:255',
            'nomor_inventaris' => 'nullable|string|max:255|unique:form_pemeliharaan_ups,nomor_inventaris',
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

        $form = FormPemeliharaanUps::create([
            'no_ref' => $validatedData['no_ref'] ?? null,
            'tanggal' => $validatedData['tanggal'] ?? null,
            'business_area' => $validatedData['business_area'] ?? null,
            'nomor_inventaris' => $validatedData['nomor_inventaris'] ?? null,
            'lokasi' => $validatedData['lokasi'] ?? null,
            'kota_tanggal' => $validatedData['kota_tanggal'] ?? null,
            'mengetahui_nama' => $validatedData['mengetahui_nama'] ?? null,
            'mengetahui_nipp' => $validatedData['mengetahui_nipp'] ?? null,
            'mengetahui_jabatan' => $validatedData['mengetahui_jabatan'] ?? null,
        ]);

        // Update other forms' business area if provided
        if (!empty($validatedData['business_area'])) {
            FormPemeliharaanUps::where('id', '!=', $form->id)->update(['business_area' => $validatedData['business_area']]);
        }

        if (isset($validatedData['items']) && is_array($validatedData['items'])) {
            foreach ($validatedData['items'] as $index => $itemData) {
                if (empty($itemData['tanggal']) && empty($itemData['keterangan']) && empty($itemData['paraf']) && empty($itemData['perawatan']) && empty($itemData['perbaikan'])) {
                    continue;
                }

                $no = $index;
                $perawatan = isset($itemData['perawatan']) ? 'V' : '-';
                $perbaikan = isset($itemData['perbaikan']) ? 'V' : '-';
                $jenis_kegiatan = json_encode(['perawatan' => $perawatan, 'perbaikan' => $perbaikan]);

                FormPemeliharaanUpsItem::create([
                    'form_pemeliharaan_ups_id' => $form->id,
                    'no' => $no,
                    'tanggal' => $itemData['tanggal'] ?? null,
                    'jenis_kegiatan' => $jenis_kegiatan,
                    'keterangan' => $itemData['keterangan'] ?? null,
                    'paraf' => $itemData['paraf'] ?? null,
                ]);
            }
        }

        return redirect()->route('form-pemeliharaan-ups.index')->with('success', "Formulir {$form->nomor_inventaris} Berhasil Ditambahkan.");
    }

    public function show(string $id)
    {
        $form = FormPemeliharaanUps::with('items')->findOrFail($id);
        $formTemplate = \App\Models\FormTemplate::where('nama', 'Checklist Pemeliharaan UPS')->first();
        return view('form-pemeliharaan-ups.show', compact('form', 'formTemplate'));
    }

    public function edit(string $id)
    {
        $form = FormPemeliharaanUps::with('items')->findOrFail($id);

        $items = [];
        foreach ($form->items as $item) {
            $items[$item->no - 1] = $item;
        }

        $masterUps = MasterUps::orderBy('nomor_inventaris', 'asc')->get();
        $masterSigners = MasterSigner::orderBy('nama', 'asc')->get();
        $formTemplate = \App\Models\FormTemplate::where('nama', 'Checklist Pemeliharaan UPS')->first();

        return view('form-pemeliharaan-ups.edit', compact('form', 'items', 'masterUps', 'masterSigners', 'formTemplate'));
    }

    public function update(Request $request, string $id)
    {
        $form = FormPemeliharaanUps::findOrFail($id);

        $validatedData = $request->validate([
            'no_ref' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'business_area' => 'nullable|string|max:255',
            'nomor_inventaris' => 'nullable|string|max:255',
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
            'nomor_inventaris' => $validatedData['nomor_inventaris'] ?? null,
            'lokasi' => $validatedData['lokasi'] ?? null,
            'kota_tanggal' => $validatedData['kota_tanggal'] ?? null,
            'mengetahui_nama' => $validatedData['mengetahui_nama'] ?? null,
            'mengetahui_nipp' => $validatedData['mengetahui_nipp'] ?? null,
            'mengetahui_jabatan' => $validatedData['mengetahui_jabatan'] ?? null,
        ]);

        if (!empty($validatedData['business_area'])) {
            FormPemeliharaanUps::where('id', '!=', $form->id)->update(['business_area' => $validatedData['business_area']]);
        }

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

                FormPemeliharaanUpsItem::create([
                    'form_pemeliharaan_ups_id' => $form->id,
                    'no' => $no,
                    'tanggal' => $itemData['tanggal'] ?? null,
                    'jenis_kegiatan' => $jenis_kegiatan,
                    'keterangan' => $itemData['keterangan'] ?? null,
                    'paraf' => $itemData['paraf'] ?? null,
                ]);
            }
        }

        return redirect()->route('form-pemeliharaan-ups.index')->with('success', "Formulir {$form->nomor_inventaris} Berhasil Diperbarui.");
    }

    public function destroy(string $id)
    {
        $form = FormPemeliharaanUps::findOrFail($id);
        $form->delete();
        return redirect()->route('form-pemeliharaan-ups.index')->with('success', "Formulir berhasil dihapus.");
    }

    public function parseExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            $import = new \App\Imports\FormPemeliharaanUps\FormPemeliharaanUpsItemImport;
            $collection = \Maatwebsite\Excel\Facades\Excel::toCollection($import, $request->file('file'));
            $rows = $collection->first();

            $items = [];
            foreach ($rows as $row) {
                $tanggal = $row['tanggal'] ?? null;
                if (!$tanggal) continue;

                if (is_numeric($tanggal)) {
                    $tanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggal)->format('Y-m-d');
                }

                $perawatan = strtoupper(trim($row['perawatan'] ?? '')) === 'V' ? 'V' : null;
                $perbaikan = strtoupper(trim($row['perbaikan'] ?? '')) === 'V' ? 'V' : null;

                $items[] = [
                    'tanggal' => $tanggal,
                    'perawatan' => $perawatan,
                    'perbaikan' => $perbaikan,
                    'keterangan' => $row['keterangan'] ?? '',
                    'paraf' => $row['paraf'] ?? '',
                ];
            }

            return response()->json(['success' => true, 'data' => $items]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function downloadTemplateItems()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\FormPemeliharaanUps\FormPemeliharaanUpsItemTemplateExport, 'Template_Item_UPS.xlsx');
    }
}
