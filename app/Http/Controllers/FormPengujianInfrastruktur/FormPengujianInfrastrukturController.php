<?php

namespace App\Http\Controllers\FormPengujianInfrastruktur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormPengujianInfrastruktur\FormPengujianInfrastruktur;
use App\Models\FormPengujianInfrastruktur\FormPengujianInfrastrukturItem;
use App\Models\FormCctv\MasterSigner;

class FormPengujianInfrastrukturController extends Controller
{
    private const TEMPLATE_NAME = 'Formulir Pengujian Infrastruktur';

    public function index(Request $request)
    {
        $search = $request->query('search');

        $forms = FormPengujianInfrastruktur::when($search, function ($query, $search) {
            return $query->where('no_ref', 'like', "%{$search}%")
                         ->orWhere('objek_pengujian', 'like', "%{$search}%")
                         ->orWhere('pelaksana_pengujian', 'like', "%{$search}%");
        })->orderBy('created_at', 'desc')->paginate(10, ['*'], 'form_page');

        $forms->appends(['search' => $search]);

        $masterSigners = MasterSigner::orderBy('nama', 'asc')->paginate(10, ['*'], 'signer_page');

        return view('form-pengujian-infrastruktur.index', compact('forms', 'search', 'masterSigners'));
    }

    public function create()
    {
        $formTemplate  = \App\Models\FormTemplate::where('nama', self::TEMPLATE_NAME)->first();
        $masterSigners = MasterSigner::orderBy('nama', 'asc')->get();
        return view('form-pengujian-infrastruktur.create', compact('formTemplate', 'masterSigners'));
    }

    private function validationRules(): array
    {
        return [
            'no_ref'               => 'nullable|string|max:255',
            'tanggal'              => 'nullable|date',
            'business_area'        => 'nullable|string|max:255',
            'tanggal_pengujian'    => 'nullable|date',
            'objek_pengujian'      => 'nullable|string|max:255',
            'pelaksana_pengujian'  => 'nullable|string|max:255',
            'pelaksana_nipp'       => 'nullable|string|max:255',
            'deskripsi_pengujian'  => 'nullable|string',
            'analisa_kesimpulan'   => 'nullable|string',
            'items'                => 'nullable|array',
            'items.*.rencana_pengujian' => 'nullable|string',
            'items.*.hasil'             => 'nullable|string|in:OK,Not OK',
            'items.*.keterangan'        => 'nullable|string',
            'kota_tanggal'         => 'nullable|string|max:255',
            'mengetahui_id'        => 'nullable|exists:master_signers,id',
        ];
    }

    private function saveItems(FormPengujianInfrastruktur $form, array $items): void
    {
        foreach ($items as $index => $itemData) {
            // Skip completely empty rows
            if (empty($itemData['rencana_pengujian']) && empty($itemData['hasil']) && empty($itemData['keterangan'])) {
                continue;
            }

            FormPengujianInfrastrukturItem::create([
                'form_pengujian_infrastruktur_id' => $form->id,
                'no'                              => $index + 1,
                'rencana_pengujian'               => $itemData['rencana_pengujian'] ?? null,
                'hasil'                           => $itemData['hasil'] ?? null,
                'keterangan'                      => $itemData['keterangan'] ?? null,
            ]);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate($this->validationRules());

        // Sync mengetahui_nama & mengetahui_jabatan from master signer
        if (!empty($validatedData['mengetahui_id'])) {
            $signer = MasterSigner::find($validatedData['mengetahui_id']);
            if ($signer) {
                $validatedData['mengetahui_nama']    = $signer->nama;
                $validatedData['mengetahui_jabatan'] = $signer->jabatan;
            }
        }

        $form = FormPengujianInfrastruktur::create(collect($validatedData)->except('items')->toArray());

        if (isset($validatedData['items']) && is_array($validatedData['items'])) {
            $this->saveItems($form, $validatedData['items']);
        }

        return redirect()->route('form-pengujian-infrastruktur.index')
            ->with('success', "Formulir Pengujian Infrastruktur Berhasil Ditambahkan.");
    }

    public function show(string $id)
    {
        $form          = FormPengujianInfrastruktur::with('items', 'mengetahui')->findOrFail($id);
        $formTemplate  = \App\Models\FormTemplate::where('nama', self::TEMPLATE_NAME)->first();
        $masterSigners = MasterSigner::orderBy('nama', 'asc')->get();
        return view('form-pengujian-infrastruktur.show', compact('form', 'formTemplate', 'masterSigners'));
    }

    public function edit(string $id)
    {
        $form          = FormPengujianInfrastruktur::with('items', 'mengetahui')->findOrFail($id);
        $formTemplate  = \App\Models\FormTemplate::where('nama', self::TEMPLATE_NAME)->first();
        $masterSigners = MasterSigner::orderBy('nama', 'asc')->get();
        return view('form-pengujian-infrastruktur.edit', compact('form', 'formTemplate', 'masterSigners'));
    }

    public function update(Request $request, string $id)
    {
        $form = FormPengujianInfrastruktur::findOrFail($id);

        $validatedData = $request->validate($this->validationRules());

        // Sync mengetahui_nama & mengetahui_jabatan from master signer
        if (!empty($validatedData['mengetahui_id'])) {
            $signer = MasterSigner::find($validatedData['mengetahui_id']);
            if ($signer) {
                $validatedData['mengetahui_nama']    = $signer->nama;
                $validatedData['mengetahui_jabatan'] = $signer->jabatan;
            }
        }

        $form->update(collect($validatedData)->except('items')->toArray());

        $form->items()->delete(); // recreate items for simplicity

        if (isset($validatedData['items']) && is_array($validatedData['items'])) {
            $this->saveItems($form, $validatedData['items']);
        }

        return redirect()->route('form-pengujian-infrastruktur.index')
            ->with('success', "Formulir Pengujian Infrastruktur Berhasil Diperbarui.");
    }

    public function destroy(string $id)
    {
        $form = FormPengujianInfrastruktur::findOrFail($id);
        $form->delete();

        return redirect()->route('form-pengujian-infrastruktur.index')
            ->with('success', "Formulir Pengujian Infrastruktur Berhasil Dihapus.");
    }
}
