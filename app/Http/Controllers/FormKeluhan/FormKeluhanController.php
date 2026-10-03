<?php

namespace App\Http\Controllers\FormKeluhan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\FormKeluhan\FormKeluhan;
use App\Models\FormKeluhan\FormKeluhanItem;
use App\Models\FormCctv\MasterSigner;

class FormKeluhanController extends Controller
{
    private function itemRules(): array
    {
        return [
            'items' => 'nullable|array',
            'items.*.tanggal' => 'nullable|string|max:255',
            'items.*.pelanggan' => 'nullable|string|max:255',
            'items.*.sumber' => 'nullable|string|max:255',
            'items.*.deskripsi_keluhan' => 'nullable|string',
            'items.*.tindakan' => 'nullable|string',
            'items.*.verifikasi_tgl' => 'nullable|string|max:255',
            'items.*.verifikasi_pic' => 'nullable|string|max:255',
            'items.*.verifikasi_hasil' => 'nullable|string',
            'items.*.keterangan' => 'nullable|string',
        ];
    }

    private function headerRules(): array
    {
    
    return [
        'no_ref' => 'nullable|string|max:255',
        'tanggal' => 'nullable|date',
        'kota_tanggal' => 'nullable|string',
        'pelaksana_nama' => 'nullable|string|max:255',
        'pelaksana_nipp' => 'nullable|string|max:255',
        'mengetahui_jabatan' => 'nullable|string|max:255',
        'mengetahui_nama' => 'nullable|string|max:255',
        'mengetahui_nipp' => 'nullable|string|max:255',
    ];
}

    private function saveItems(FormKeluhan $form, array $items): void
    {
        foreach ($items as $index => $itemData) {
            if (
                empty($itemData['tanggal']) && empty($itemData['pelanggan']) &&
                empty($itemData['sumber']) && empty($itemData['deskripsi_keluhan']) &&
                empty($itemData['tindakan']) && empty($itemData['verifikasi_tgl']) &&
                empty($itemData['verifikasi_pic']) && empty($itemData['verifikasi_hasil']) &&
                empty($itemData['keterangan'])
            ) {
                continue;
            }

            FormKeluhanItem::create([
                'form_keluhan_id' => $form->id,
                'no' => $index,
                'tanggal' => $itemData['tanggal'] ?? null,
                'pelanggan' => $itemData['pelanggan'] ?? null,
                'sumber' => $itemData['sumber'] ?? null,
                'deskripsi_keluhan' => $itemData['deskripsi_keluhan'] ?? null,
                'tindakan' => $itemData['tindakan'] ?? null,
                'verifikasi_tgl' => $itemData['verifikasi_tgl'] ?? null,
                'verifikasi_pic' => $itemData['verifikasi_pic'] ?? null,
                'verifikasi_hasil' => $itemData['verifikasi_hasil'] ?? null,
                'keterangan' => $itemData['keterangan'] ?? null,
            ]);
        }
    }

    public function index(Request $request)
    {
        $search = $request->query('search');

        $forms = FormKeluhan::when($search, function ($query, $search) {
            return $query->where('no_ref', 'like', "%{$search}%");
        })->orderBy('created_at', 'desc')->paginate(10);

        $forms->appends(['search' => $search]);
        
        $masterSigners = MasterSigner::orderBy('nama', 'asc')->paginate(5, ['*'], 'signer_page');
        
        return view('form-keluhan.index', compact('forms', 'search', 'masterSigners'));
    }

    public function create()
    {
        $formTemplate = \App\Models\FormTemplate::where('nama', 'Pengelolaan dan Penanganan Keluhan Pelanggan')->first();
        $masterSigners = MasterSigner::orderBy('nama', 'asc')->get();
        return view('form-keluhan.create', compact('formTemplate', 'masterSigners'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(array_merge($this->headerRules(), $this->itemRules()));

        $form = FormKeluhan::create([
            'no_ref' => $validatedData['no_ref'] ?? null,
            'tanggal' => $validatedData['tanggal'] ?? null,
            'kota_tanggal' => $validatedData['kota_tanggal'] ?? null,
            'pelaksana_nama' => $validatedData['pelaksana_nama'] ?? null,
            'pelaksana_nipp' => $validatedData['pelaksana_nipp'] ?? null,
            'mengetahui_jabatan' => $validatedData['mengetahui_jabatan'] ?? null,
            'mengetahui_nama' => $validatedData['mengetahui_nama'] ?? null,
            'mengetahui_nipp' => $validatedData['mengetahui_nipp'] ?? null,]);

        if (isset($validatedData['items']) && is_array($validatedData['items'])) {
            $this->saveItems($form, $validatedData['items']);
        }

        return redirect()->route('form-keluhan.index')->with('success', "Formulir Keluhan Pelanggan Berhasil Ditambahkan.");
    }

    public function show(string $id)
    {
        $form = FormKeluhan::with('items')->findOrFail($id);
        $formTemplate = \App\Models\FormTemplate::where('nama', 'Pengelolaan dan Penanganan Keluhan Pelanggan')->first();
        return view('form-keluhan.show', compact('form', 'formTemplate'));
    }

    public function detail(string $id)
    {
        $form = FormKeluhan::with(['items' => function ($query) {
            $query->orderBy('no');
            }])->findOrFail($id);
        return view('form-keluhan.detail', compact('form'));
    }

    public function edit(string $id)
    {
        $form = FormKeluhan::with('items')->findOrFail($id);

        $items = [];
        foreach ($form->items as $item) {
            $items[$item->no] = $item;
        }

        $formTemplate = \App\Models\FormTemplate::where('nama', 'Pengelolaan dan Penanganan Keluhan Pelanggan')->first();
        $masterSigners = MasterSigner::orderBy('nama', 'asc')->get();
        return view('form-keluhan.edit', compact('form', 'items', 'formTemplate', 'masterSigners'));
    }
    
    public function update(Request $request, string $id)
    {
        $form = FormKeluhan::findOrFail($id);

        $validatedData = $request->validate(array_merge($this->headerRules(), $this->itemRules()));

       $form->update([
        'no_ref' => $validatedData['no_ref'] ?? null,
        'tanggal' => $validatedData['tanggal'] ?? null,
        'kota_tanggal' => $validatedData['kota_tanggal'] ?? null,
        'pelaksana_nama' => $validatedData['pelaksana_nama'] ?? null,
        'pelaksana_nipp' => $validatedData['pelaksana_nipp'] ?? null,
        'mengetahui_jabatan' => $validatedData['mengetahui_jabatan'] ?? null,
        'mengetahui_nama' => $validatedData['mengetahui_nama'] ?? null,
        'mengetahui_nipp' => $validatedData['mengetahui_nipp'] ?? null,
        ]);

        $form->items()->delete();

        if (isset($validatedData['items']) && is_array($validatedData['items'])) {
            $this->saveItems($form, $validatedData['items']);
        }

        return redirect()->route('form-keluhan.index')->with('success', "Formulir Keluhan Pelanggan Berhasil Diperbarui.");
    }

    public function destroy(string $id)
    {
        $form = FormKeluhan::findOrFail($id);
        $form->delete();

        return redirect()->route('form-keluhan.index')->with('success', "Formulir Keluhan Pelanggan Berhasil Dihapus.");
    }

    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate([   
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:form_keluhans,id',
        ]);

        $count = FormKeluhan::whereIn('id', $validated['ids'])->count();
        FormKeluhan::whereIn('id', $validated['ids'])->delete();

        return redirect()->route('form-keluhan.index')->with('success', "{$count} Formulir Keluhan Pelanggan Berhasil Dihapus.");
    }

    public function bulkDestroySigner(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:master_signers,id',
        ]);

        $count = MasterSigner::whereIn('id', $validated['ids'])->count();
        MasterSigner::whereIn('id', $validated['ids'])->delete();

        return back()->with('success', "{$count} Data Penandatangan berhasil dihapus.");
    }
}
