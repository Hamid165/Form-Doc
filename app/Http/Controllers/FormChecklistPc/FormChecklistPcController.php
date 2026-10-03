<?php

namespace App\Http\Controllers\FormChecklistPc;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\FormChecklistPc\FormChecklistPc;
use App\Models\FormChecklistPc\FormChecklistPcItem;
use Barryvdh\DomPDF\Facade\Pdf;

class FormChecklistPcController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $forms = FormChecklistPc::when($search, function ($query, $search) {
            return $query->where('no_ref', 'like', "%{$search}%")
                         ->orWhere('business_area', 'like', "%{$search}%")
                         ->orWhere('pelaksana_name', 'like', "%{$search}%");
        })->orderBy('created_at', 'desc')->paginate(10);

        $forms->appends(['search' => $search]);

        return view('form-checklist-pc.index', compact('forms', 'search'));
    }

    public function create()
    {
        $checklistItems = FormChecklistPc::CHECKLIST_ITEMS;
        return view('form-checklist-pc.create', compact('checklistItems'));
    }

    protected function rules(): array
    {
        return [
            'no_ref'               => 'nullable|string|max:255',
            'tanggal'              => 'nullable|date',
            'business_area'        => 'nullable|string|max:255',
            'pelaksana_name'       => 'nullable|string|max:255',
            'tanggal_pemeriksaan'  => 'nullable|date',
            'analisa_kesimpulan'   => 'nullable|string',
            'items'                       => 'nullable|array',
            'items.*.nama_aset'          => 'nullable|string|max:255',
            'items.*.id_aset'            => 'nullable|string|max:255',
            'items.*.nipp'                => 'nullable|string|max:255',
            'items.*.checklist'           => 'nullable|array',
            'items.*.paraf'               => 'nullable|string|max:255',
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $validItems = array_filter($request->items ?? [], function ($i) {
            return !empty($i['nama_aset']);
        });

        if (count($validItems) === 0) {
            return back()->withInput()->withErrors(['items' => 'Formulir harus memiliki minimal 1 (satu) item aset.']);
        }

        DB::transaction(function () use ($validated) {
            $form = FormChecklistPc::create([
                'no_ref'              => $validated['no_ref'] ?? null,
                'tanggal'             => $validated['tanggal'] ?? null,
                'business_area'       => $validated['business_area'] ?? null,
                'pelaksana_name'      => $validated['pelaksana_name'] ?? null,
                'tanggal_pemeriksaan' => $validated['tanggal_pemeriksaan'] ?? null,
                'analisa_kesimpulan'  => $validated['analisa_kesimpulan'] ?? null,
                'status'              => 'draft',
            ]);

            $this->saveItems($form, $validated['items'] ?? []);
        });

        return redirect()->route('form-checklist-pc.index')
                         ->with('success', 'Formulir checklist PC/Notebook/Printer berhasil dibuat.');
    }

    public function show(FormChecklistPc $form_checklist_pc)
    {
        $form_checklist_pc->load('items');
        return view('form-checklist-pc.show', compact('form_checklist_pc'));
    }

    public function pdf(FormChecklistPc $form_checklist_pc)
    {
        $form_checklist_pc->load('items');

        $pdf = Pdf::loadView('form-checklist-pc.pdf', compact('form_checklist_pc'))
            ->setPaper('a3', 'landscape');

        // Tandai formulir sebagai "dicetak" begitu PDF pertama kali dibuat,
        // supaya tombol "Konfirmasi Selesai" di halaman show bisa muncul.
        if ($form_checklist_pc->isDraft()) {
            $form_checklist_pc->update(['status' => 'dicetak']);
        }

        $rawName = $form_checklist_pc->no_ref ?: (string) $form_checklist_pc->id;
        // no_ref bisa berisi karakter '/' (misal format tanggal "12/13/2026"),
        // padahal nama file tidak boleh mengandung '/' atau '\'.
        $safeName = str_replace(['/', '\\'], '-', $rawName);
        $safeName = preg_replace('/[^A-Za-z0-9\-_.]/', '-', $safeName);
        $fileName = 'checklist-pc-' . $safeName . '.pdf';

        return $pdf->stream($fileName);
    }

    public function edit(FormChecklistPc $form_checklist_pc)
    {
        $form_checklist_pc->load('items');
        $checklistItems = FormChecklistPc::CHECKLIST_ITEMS;
        return view('form-checklist-pc.edit', compact('form_checklist_pc', 'checklistItems'));
    }

    public function update(Request $request, FormChecklistPc $form_checklist_pc)
    {
        $validated = $request->validate($this->rules());

        $validItems = array_filter($request->items ?? [], function ($i) {
            return !empty($i['nama_aset']);
        });

        if (count($validItems) === 0) {
            return back()->withInput()->withErrors(['items' => 'Formulir harus memiliki minimal 1 (satu) item aset.']);
        }

        DB::transaction(function () use ($validated, $form_checklist_pc) {
            $form_checklist_pc->update([
                'no_ref'              => $validated['no_ref'] ?? null,
                'tanggal'             => $validated['tanggal'] ?? null,
                'business_area'       => $validated['business_area'] ?? null,
                'pelaksana_name'      => $validated['pelaksana_name'] ?? null,
                'tanggal_pemeriksaan' => $validated['tanggal_pemeriksaan'] ?? null,
                'analisa_kesimpulan'  => $validated['analisa_kesimpulan'] ?? null,
            ]);

            $form_checklist_pc->items()->delete();
            $this->saveItems($form_checklist_pc, $validated['items'] ?? []);
        });

        return redirect()->route('form-checklist-pc.index')
                         ->with('success', 'Formulir checklist PC/Notebook/Printer berhasil diperbarui.');
    }

    public function destroy(FormChecklistPc $form_checklist_pc)
    {
        $form_checklist_pc->delete();

        return redirect()->route('form-checklist-pc.index')
                         ->with('success', 'Formulir checklist PC/Notebook/Printer berhasil dihapus.');
    }

    public function confirm(FormChecklistPc $form_checklist_pc)
    {
        if ($form_checklist_pc->isDicetak()) {
            $form_checklist_pc->update(['status' => 'selesai']);
        }

        return back()->with('success', 'Formulir berhasil dikonfirmasi sebagai selesai.');
    }

    protected function saveItems(FormChecklistPc $form, array $items): void
    {
        foreach ($items as $itemData) {
            if (empty($itemData['nama_aset'])) {
                continue;
            }

            $checklist = [];
            foreach (FormChecklistPc::CHECKLIST_ITEMS as $key => $label) {
                $checklist[$key] = $itemData['checklist'][$key] ?? 'na';
            }

            FormChecklistPcItem::create([
                'form_checklist_pc_id' => $form->id,
                'nama_aset'            => $itemData['nama_aset'],
                'id_aset'              => $itemData['id_aset'] ?? null,
                'nipp'                 => $itemData['nipp'] ?? null,
                'checklist'            => $checklist,
                'paraf'                => $itemData['paraf'] ?? null,
            ]);
        }
    }
}