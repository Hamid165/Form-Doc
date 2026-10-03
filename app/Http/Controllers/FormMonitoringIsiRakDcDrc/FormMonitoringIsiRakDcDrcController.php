<?php

namespace App\Http\Controllers\FormMonitoringIsiRakDcDrc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormMonitoringIsiRakDcDrc\FormMonitoringIsiRakDcDrc;
use App\Models\FormMonitoringIsiRakDcDrc\FormMonitoringIsiRakDcDrcItem;
use App\Models\FormTemplate;

class FormMonitoringIsiRakDcDrcController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $forms = FormMonitoringIsiRakDcDrc::when($search, function ($query, $search) {
            return $query->where('no_ref', 'like', "%{$search}%")
                         ->orWhere('nomor_rak', 'like', "%{$search}%")
                         ->orWhere('kode_rak', 'like', "%{$search}%")
                         ->orWhere('lokasi', 'like', "%{$search}%")
                         ->orWhere('business_area', 'like', "%{$search}%");
        })->orderBy('created_at', 'desc')->paginate(10);

        $forms->appends(['search' => $search]);

        return view('form-monitoring-isi-rak-dc-drc.index', compact('forms', 'search'));
    }

    public function create()
    {
        $formTemplate = FormTemplate::where('nama', 'Monitoring Isi Rak DC / DRC')
            ->orWhere('nama', 'like', '%Monitoring Isi Rak%')
            ->first();

        $masterSigners = \App\Models\FormCctv\MasterSigner::all();

        return view('form-monitoring-isi-rak-dc-drc.create', compact('formTemplate', 'masterSigners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_ref' => 'nullable|string|max:255',
            'tanggal' => 'nullable|string|max:255',
            'business_area' => 'nullable|string|max:255',
            'nomor_rak' => 'nullable|string|max:255',
            'last_update' => 'nullable|string|max:255',
            'kode_rak' => 'nullable|string|max:255',
            'ukuran_rak' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'lantai' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'mengetahui_nama' => 'nullable|string|max:255',
            'mengetahui_nipp' => 'nullable|string|max:255',
            'items' => 'nullable|array',
        ]);

        $form = FormMonitoringIsiRakDcDrc::create([
            'no_ref' => $validated['no_ref'] ?? null,
            'tanggal' => $this->parseDateSafe($validated['tanggal'] ?? null),
            'business_area' => $validated['business_area'] ?? null,
            'nomor_rak' => $validated['nomor_rak'] ?? null,
            'last_update' => $validated['last_update'] ?? null,
            'kode_rak' => $validated['kode_rak'] ?? null,
            'ukuran_rak' => $validated['ukuran_rak'] ?? null,
            'lokasi' => $validated['lokasi'] ?? null,
            'lantai' => $validated['lantai'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'mengetahui_nama' => $validated['mengetahui_nama'] ?? null,
            'mengetahui_nipp' => $validated['mengetahui_nipp'] ?? null,
        ]);

        if (!empty($request->input('items')) && is_array($request->input('items'))) {
            foreach ($request->input('items') as $index => $itemData) {
                // Filter empty rows if all fields are null/blank
                $hasContent = collect($itemData)->except(['no'])->filter(fn($val) => !is_null($val) && trim($val) !== '')->isNotEmpty();
                if ($hasContent) {
                    $form->items()->create([
                        'no' => $itemData['no'] ?? ($index + 1),
                        'cable' => $itemData['cable'] ?? null,
                        'pp' => $itemData['pp'] ?? null,
                        'id_machine' => $itemData['id_machine'] ?? null,
                        'id_server_name_server' => $itemData['id_server_name_server'] ?? null,
                        'pic' => $itemData['pic'] ?? null,
                        'nic' => $itemData['nic'] ?? null,
                        'power_a' => $itemData['power_a'] ?? null,
                        'weight_kg' => $itemData['weight_kg'] ?? null,
                        'capacity_storage_gb' => $itemData['capacity_storage_gb'] ?? null,
                        'capacity_memory_gb' => $itemData['capacity_memory_gb'] ?? null,
                        'ip_address_local' => $itemData['ip_address_local'] ?? null,
                        'ip_address_public' => $itemData['ip_address_public'] ?? null,
                        'status' => $itemData['status'] ?? null,
                        'note' => $itemData['note'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('form-monitoring-isi-rak-dc-drc.index')
            ->with('success', 'Formulir Monitoring Isi Rak DC / DRC berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $form = FormMonitoringIsiRakDcDrc::with('items')->findOrFail($id);
        $formTemplate = FormTemplate::where('nama', 'Monitoring Isi Rak DC / DRC')
            ->orWhere('nama', 'like', '%Monitoring Isi Rak%')
            ->first();

        return view('form-monitoring-isi-rak-dc-drc.show', compact('form', 'formTemplate'));
    }

    public function edit(string $id)
    {
        $form = FormMonitoringIsiRakDcDrc::with('items')->findOrFail($id);
        $formTemplate = FormTemplate::where('nama', 'Monitoring Isi Rak DC / DRC')
            ->orWhere('nama', 'like', '%Monitoring Isi Rak%')
            ->first();
        $masterSigners = \App\Models\FormCctv\MasterSigner::all();

        return view('form-monitoring-isi-rak-dc-drc.edit', compact('form', 'formTemplate', 'masterSigners'));
    }

    public function update(Request $request, string $id)
    {
        $form = FormMonitoringIsiRakDcDrc::findOrFail($id);

        $validated = $request->validate([
            'no_ref' => 'nullable|string|max:255',
            'tanggal' => 'nullable|string|max:255',
            'business_area' => 'nullable|string|max:255',
            'nomor_rak' => 'nullable|string|max:255',
            'last_update' => 'nullable|string|max:255',
            'kode_rak' => 'nullable|string|max:255',
            'ukuran_rak' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'lantai' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'mengetahui_nama' => 'nullable|string|max:255',
            'mengetahui_nipp' => 'nullable|string|max:255',
            'items' => 'nullable|array',
        ]);

        $form->update([
            'no_ref' => $validated['no_ref'] ?? null,
            'tanggal' => $this->parseDateSafe($validated['tanggal'] ?? null),
            'business_area' => $validated['business_area'] ?? null,
            'nomor_rak' => $validated['nomor_rak'] ?? null,
            'last_update' => $validated['last_update'] ?? null,
            'kode_rak' => $validated['kode_rak'] ?? null,
            'ukuran_rak' => $validated['ukuran_rak'] ?? null,
            'lokasi' => $validated['lokasi'] ?? null,
            'lantai' => $validated['lantai'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'mengetahui_nama' => $validated['mengetahui_nama'] ?? null,
            'mengetahui_nipp' => $validated['mengetahui_nipp'] ?? null,
        ]);

        // Re-create items
        $form->items()->delete();

        if (!empty($request->input('items')) && is_array($request->input('items'))) {
            foreach ($request->input('items') as $index => $itemData) {
                $hasContent = collect($itemData)->except(['no'])->filter(fn($val) => !is_null($val) && trim($val) !== '')->isNotEmpty();
                if ($hasContent) {
                    $form->items()->create([
                        'no' => $itemData['no'] ?? ($index + 1),
                        'cable' => $itemData['cable'] ?? null,
                        'pp' => $itemData['pp'] ?? null,
                        'id_machine' => $itemData['id_machine'] ?? null,
                        'id_server_name_server' => $itemData['id_server_name_server'] ?? null,
                        'pic' => $itemData['pic'] ?? null,
                        'nic' => $itemData['nic'] ?? null,
                        'power_a' => $itemData['power_a'] ?? null,
                        'weight_kg' => $itemData['weight_kg'] ?? null,
                        'capacity_storage_gb' => $itemData['capacity_storage_gb'] ?? null,
                        'capacity_memory_gb' => $itemData['capacity_memory_gb'] ?? null,
                        'ip_address_local' => $itemData['ip_address_local'] ?? null,
                        'ip_address_public' => $itemData['ip_address_public'] ?? null,
                        'status' => $itemData['status'] ?? null,
                        'note' => $itemData['note'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('form-monitoring-isi-rak-dc-drc.index')
            ->with('success', 'Formulir Monitoring Isi Rak DC / DRC berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $form = FormMonitoringIsiRakDcDrc::findOrFail($id);
        $form->delete();

        return redirect()->route('form-monitoring-isi-rak-dc-drc.index')
            ->with('success', 'Formulir Monitoring Isi Rak DC / DRC berhasil dihapus.');
    }

    private function parseDateSafe($dateStr)
    {
        if (empty($dateStr)) return null;

        $dateStr = trim($dateStr);
        $dateStr = str_replace('/', '-', $dateStr);

        // dd-mm-yyyy or d-m-Y
        if (preg_match('/^(\d{1,2})-(\d{1,2})-(\d{4})$/', $dateStr, $matches)) {
            return sprintf('%04d-%02d-%02d', $matches[3], $matches[2], $matches[1]);
        }

        // yyyy-mm-dd
        if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $dateStr, $matches)) {
            return sprintf('%04d-%02d-%02d', $matches[1], $matches[2], $matches[3]);
        }

        $timestamp = strtotime($dateStr);
        return $timestamp !== false ? date('Y-m-d', $timestamp) : null;
    }
}
