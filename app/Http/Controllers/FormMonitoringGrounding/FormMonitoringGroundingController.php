<?php

namespace App\Http\Controllers\FormMonitoringGrounding;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormMonitoringGrounding\FormMonitoringGrounding;
use App\Models\FormMonitoringGrounding\FormMonitoringGroundingItem;
use App\Exports\FormMonitoringGrounding\MonitoringGroundingExport;
use Maatwebsite\Excel\Facades\Excel;

class FormMonitoringGroundingController extends Controller
{
    public function index()
    {
        $forms = FormMonitoringGrounding::orderBy('created_at', 'desc')->paginate(5, ['*'], 'form_page');
        $masterSigners = \App\Models\FormCctv\MasterSigner::paginate(5, ['*'], 'signer_page');
        return view('form-monitoring-grounding.index', compact('forms', 'masterSigners'));
    }

    public function create()
    {
        $formTemplate = \App\Models\FormTemplate::where('nama', 'Monitoring Grounding')->first();
        $form = new FormMonitoringGrounding();
        $signers = \App\Models\FormCctv\MasterSigner::all();
        return view('form-monitoring-grounding.create', compact('formTemplate', 'form', 'signers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no_ref' => 'nullable|string|max:255|unique:form_monitoring_groundings,no_ref',
            'tanggal' => 'nullable|string',
            'business_area' => 'nullable|string|max:255',
            'bulan' => 'nullable|string|max:255',
            'tgl_pelaksanaan' => 'nullable|string|max:255',
            'nama_petugas' => 'nullable|string|max:255',
            'paraf_petugas' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'mengetahui_nama' => 'nullable|string|max:255',
            'mengetahui_nipp' => 'nullable|string|max:255',
            'mengetahui_jabatan' => 'nullable|string|max:255',
            'items' => 'nullable|array',
            'items.*.lokasi_grounding' => 'nullable|string|max:255',
            'items.*.nilai_grounding_standard' => 'nullable|string|max:255',
            'items.*.hasil_pengukuran' => 'nullable|string|max:255',
            'items.*.kondisi_bak_grounding' => 'nullable|string|max:255',
            'items.*.tindak_lanjut' => 'nullable|string',
        ], [
            'no_ref.unique' => 'No. Ref ":input" sudah pernah digunakan pada formulir lain. Mohon gunakan No. Ref yang berbeda.'
        ]);

        $form = FormMonitoringGrounding::create([
            'no_ref' => $validatedData['no_ref'] ?? null,
            'tanggal' => $this->parseIndonesianDate($validatedData['tanggal'] ?? null),
            'business_area' => $validatedData['business_area'] ?? null,
            'bulan' => $validatedData['bulan'] ?? null,
            'tgl_pelaksanaan' => $validatedData['tgl_pelaksanaan'] ?? null,
            'nama_petugas' => $validatedData['nama_petugas'] ?? null,
            'paraf_petugas' => $validatedData['paraf_petugas'] ?? null,
            'catatan' => $validatedData['catatan'] ?? null,
            'mengetahui_nama' => $validatedData['mengetahui_nama'] ?? null,
            'mengetahui_nipp' => $validatedData['mengetahui_nipp'] ?? null,
            'mengetahui_jabatan' => $validatedData['mengetahui_jabatan'] ?? null,
        ]);

        // Update all other forms' business area if it was provided
        if (!empty($validatedData['business_area'])) {
            FormMonitoringGrounding::where('id', '!=', $form->id)->update(['business_area' => $validatedData['business_area']]);
        }

        if (isset($validatedData['items']) && is_array($validatedData['items'])) {
            foreach ($validatedData['items'] as $index => $itemData) {
                // Skip completely empty rows
                if (empty($itemData['lokasi_grounding']) && empty($itemData['hasil_pengukuran']) && empty($itemData['kondisi_bak_grounding']) && empty($itemData['tindak_lanjut'])) {
                    continue;
                }

                FormMonitoringGroundingItem::create([
                    'form_monitoring_grounding_id' => $form->id,
                    'no' => $index + 1,
                    'lokasi_grounding' => $itemData['lokasi_grounding'] ?? null,
                    'nilai_grounding_standard' => $itemData['nilai_grounding_standard'] ?? '≤ 1 OHM',
                    'hasil_pengukuran' => $itemData['hasil_pengukuran'] ?? null,
                    'kondisi_bak_grounding' => $itemData['kondisi_bak_grounding'] ?? null,
                    'tindak_lanjut' => $itemData['tindak_lanjut'] ?? null,
                ]);
            }
        }

        return redirect()->route('form-monitoring-grounding.index')->with('success', "Formulir Monitoring Grounding Berhasil Ditambahkan.");
    }

    public function show(string $id)
    {
        $form = FormMonitoringGrounding::with('items')->findOrFail($id);
        $formTemplate = \App\Models\FormTemplate::where('nama', 'Monitoring Grounding')->first();
        return view('form-monitoring-grounding.show', compact('form', 'formTemplate'));
    }

    public function edit(string $id)
    {
        $form = FormMonitoringGrounding::with('items')->findOrFail($id);

        $items = [];
        foreach ($form->items as $item) {
            $items[$item->no - 1] = $item;
        }

        $formTemplate = \App\Models\FormTemplate::where('nama', 'Monitoring Grounding')->first();
        $signers = \App\Models\FormCctv\MasterSigner::all();

        return view('form-monitoring-grounding.edit', compact('form', 'items', 'formTemplate', 'signers'));
    }

    public function update(Request $request, string $id)
    {
        $form = FormMonitoringGrounding::findOrFail($id);

        $validatedData = $request->validate([
            'no_ref' => 'nullable|string|max:255|unique:form_monitoring_groundings,no_ref,' . $form->id,
            'tanggal' => 'nullable|string',
            'business_area' => 'nullable|string|max:255',
            'bulan' => 'nullable|string|max:255',
            'tgl_pelaksanaan' => 'nullable|string|max:255',
            'nama_petugas' => 'nullable|string|max:255',
            'paraf_petugas' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'mengetahui_nama' => 'nullable|string|max:255',
            'mengetahui_nipp' => 'nullable|string|max:255',
            'mengetahui_jabatan' => 'nullable|string|max:255',
            'items' => 'nullable|array',
            'items.*.lokasi_grounding' => 'nullable|string|max:255',
            'items.*.nilai_grounding_standard' => 'nullable|string|max:255',
            'items.*.hasil_pengukuran' => 'nullable|string|max:255',
            'items.*.kondisi_bak_grounding' => 'nullable|string|max:255',
            'items.*.tindak_lanjut' => 'nullable|string',
        ], [
            'no_ref.unique' => 'No. Ref ":input" sudah pernah digunakan pada formulir lain. Mohon gunakan No. Ref yang berbeda.'
        ]);

        $form->update([
            'no_ref' => $validatedData['no_ref'] ?? null,
            'tanggal' => $this->parseIndonesianDate($validatedData['tanggal'] ?? null),
            'business_area' => $validatedData['business_area'] ?? null,
            'bulan' => $validatedData['bulan'] ?? null,
            'tgl_pelaksanaan' => $validatedData['tgl_pelaksanaan'] ?? null,
            'nama_petugas' => $validatedData['nama_petugas'] ?? null,
            'paraf_petugas' => $validatedData['paraf_petugas'] ?? null,
            'catatan' => $validatedData['catatan'] ?? null,
            'mengetahui_nama' => $validatedData['mengetahui_nama'] ?? null,
            'mengetahui_nipp' => $validatedData['mengetahui_nipp'] ?? null,
            'mengetahui_jabatan' => $validatedData['mengetahui_jabatan'] ?? null,
        ]);

        // Update all other forms' business area if it was provided
        if (!empty($validatedData['business_area'])) {
            FormMonitoringGrounding::where('id', '!=', $form->id)->update(['business_area' => $validatedData['business_area']]);
        }

        $form->items()->delete();

        if (isset($validatedData['items']) && is_array($validatedData['items'])) {
            foreach ($validatedData['items'] as $index => $itemData) {
                FormMonitoringGroundingItem::create([
                    'form_monitoring_grounding_id' => $form->id,
                    'no' => $index + 1,
                    'lokasi_grounding' => $itemData['lokasi_grounding'] ?? null,
                    'nilai_grounding_standard' => $itemData['nilai_grounding_standard'] ?? '≤ 1 OHM',
                    'hasil_pengukuran' => $itemData['hasil_pengukuran'] ?? null,
                    'kondisi_bak_grounding' => $itemData['kondisi_bak_grounding'] ?? null,
                    'tindak_lanjut' => $itemData['tindak_lanjut'] ?? null,
                ]);
            }
        }

        return redirect()->route('form-monitoring-grounding.index')->with('success', "Formulir Monitoring Grounding Berhasil Diperbarui.");
    }

    public function exportExcel(string $id)
    {
        $form = FormMonitoringGrounding::with('items')->findOrFail($id);
        $formTemplate = \App\Models\FormTemplate::where('nama', 'Monitoring Grounding')->first();
        $filename = 'monitoring-grounding-' . ($form->no_ref ?: $form->id) . '.xlsx';
        // Sanitize filename
        $filename = preg_replace('/[\/\\\\]/', '-', $filename);
        return Excel::download(new MonitoringGroundingExport($form, $formTemplate), $filename);
    }

    public function destroy(string $id)
    {
        $form = FormMonitoringGrounding::findOrFail($id);
        $form->delete();

        return redirect()->route('form-monitoring-grounding.index')->with('success', "Formulir Monitoring Grounding Berhasil Dihapus.");
    }

    private function parseIndonesianDate($dateStr)
    {
        if (empty($dateStr)) return null;

        $months = [
            'Januari' => '01', 'Februari' => '02', 'Maret' => '03', 'April' => '04',
            'Mei' => '05', 'Juni' => '06', 'Juli' => '07', 'Agustus' => '08',
            'September' => '09', 'Oktober' => '10', 'November' => '11', 'Desember' => '12',
            'Jan' => '01', 'Feb' => '02', 'Mar' => '03', 'Apr' => '04',
            'Jun' => '06', 'Jul' => '07', 'Agu' => '08', 'Sep' => '09',
            'Okt' => '10', 'Nov' => '11', 'Des' => '12',
            'January' => '01', 'February' => '02', 'March' => '03', 'May' => '05',
            'June' => '06', 'July' => '07', 'August' => '08', 'October' => '10', 'December' => '12'
        ];

        $dateStr = str_replace('-', ' ', $dateStr);

        foreach ($months as $id => $num) {
            if (stripos($dateStr, $id) !== false) {
                $dateStr = str_ireplace($id, $num, $dateStr);
                $parts = array_values(array_filter(explode(' ', trim($dateStr))));
                if (count($parts) >= 3) {
                    return $parts[2] . '-' . $parts[1] . '-' . $parts[0];
                }
            }
        }

        return (strtotime($dateStr) !== false) ? date('Y-m-d', strtotime($dateStr)) : null;
    }
}
