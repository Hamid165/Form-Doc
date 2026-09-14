<?php

namespace App\Http\Controllers\FormPcLaptopChecking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormPcLaptopChecking\FormPcLaptopChecking;
use App\Models\FormPcLaptopChecking\FormPcLaptopCheckingItem;
use App\Exports\FormPcLaptopChecking\PcLaptopCheckingExport;
use Maatwebsite\Excel\Facades\Excel;

class FormPcLaptopCheckingController extends Controller
{
    public function index()
    {
        $forms = FormPcLaptopChecking::orderBy('created_at', 'desc')->paginate(5, ['*'], 'form_page');
        $masterSigners = \App\Models\FormCctv\MasterSigner::paginate(5, ['*'], 'signer_page');
        return view('form-pc-laptop-checking.index', compact('forms', 'masterSigners'));
    }

    public function create()
    {
        $formTemplate = \App\Models\FormTemplate::where('nama', 'PC/Laptop Checking')->first();
        $form = new FormPcLaptopChecking();
        $signers = \App\Models\FormCctv\MasterSigner::all();
        return view('form-pc-laptop-checking.create', compact('formTemplate', 'form', 'signers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no_ref' => 'nullable|string|max:255|unique:form_pc_laptop_checkings,no_ref',
            'tanggal' => 'nullable|string',
            'business_area' => 'nullable|string|max:255',
            'periode_pemeriksaan' => 'nullable|string|max:255',
            'tanggal_pemeriksaan' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'mengetahui_nama' => 'nullable|string|max:255',
            'mengetahui_nipp' => 'nullable|string|max:255',
            'mengetahui_jabatan' => 'nullable|string|max:255',
            'items' => 'nullable|array',
            'items.*.nama_pengguna' => 'nullable|string|max:255',
            'items.*.unit' => 'nullable|string|max:255',
            'items.*.nda' => 'nullable|string|max:255',
            'items.*.login_strong_password' => 'nullable|string|max:255',
            'items.*.screensaver_lock' => 'nullable|string|max:255',
            'items.*.hak_akses_khusus' => 'nullable|string|max:255',
            'items.*.cleardesk' => 'nullable|string|max:255',
            'items.*.mp3_video_etc' => 'nullable|string|max:255',
            'items.*.antivirus_install' => 'nullable|string|max:255',
            'items.*.antivirus_update' => 'nullable|string|max:255',
            'items.*.full_scan_auto_schedule' => 'nullable|string|max:255',
            'items.*.os_license' => 'nullable|string|max:255',
            'items.*.sinkronisasi_ntp' => 'nullable|string|max:255',
            'items.*.label_pc' => 'nullable|string|max:255',
            'items.*.pemeriksa' => 'nullable|string|max:255',
            'items.*.pegawai_ybs' => 'nullable|string|max:255',
        ], [
            'no_ref.unique' => 'No. Ref ":input" sudah pernah digunakan pada formulir lain. Mohon gunakan No. Ref yang berbeda.'
        ]);

        $form = FormPcLaptopChecking::create([
            'no_ref' => $validatedData['no_ref'] ?? null,
            'tanggal' => $this->parseIndonesianDate($validatedData['tanggal'] ?? null),
            'business_area' => $validatedData['business_area'] ?? null,
            'periode_pemeriksaan' => $validatedData['periode_pemeriksaan'] ?? null,
            'tanggal_pemeriksaan' => $this->parseIndonesianDate($validatedData['tanggal_pemeriksaan'] ?? null),
            'catatan' => $validatedData['catatan'] ?? null,
            'mengetahui_nama' => $validatedData['mengetahui_nama'] ?? null,
            'mengetahui_nipp' => $validatedData['mengetahui_nipp'] ?? null,
            'mengetahui_jabatan' => $validatedData['mengetahui_jabatan'] ?? null,
        ]);

        // Update all other forms' business area if it was provided
        if (!empty($validatedData['business_area'])) {
            FormPcLaptopChecking::where('id', '!=', $form->id)->update(['business_area' => $validatedData['business_area']]);
        }

        if (isset($validatedData['items']) && is_array($validatedData['items'])) {
            foreach ($validatedData['items'] as $index => $itemData) {
                // Skip completely empty rows
                if (empty($itemData['nama_pengguna']) && empty($itemData['unit']) && empty($itemData['nda'])) {
                    continue;
                }

                FormPcLaptopCheckingItem::create([
                    'form_pc_laptop_checking_id' => $form->id,
                    'no' => $index + 1,
                    'nama_pengguna' => $itemData['nama_pengguna'] ?? null,
                    'unit' => $itemData['unit'] ?? null,
                    'nda' => $itemData['nda'] ?? null,
                    'login_strong_password' => $itemData['login_strong_password'] ?? null,
                    'screensaver_lock' => $itemData['screensaver_lock'] ?? null,
                    'hak_akses_khusus' => $itemData['hak_akses_khusus'] ?? null,
                    'cleardesk' => $itemData['cleardesk'] ?? null,
                    'mp3_video_etc' => $itemData['mp3_video_etc'] ?? null,
                    'antivirus_install' => $itemData['antivirus_install'] ?? null,
                    'antivirus_update' => $itemData['antivirus_update'] ?? null,
                    'full_scan_auto_schedule' => $itemData['full_scan_auto_schedule'] ?? null,
                    'os_license' => $itemData['os_license'] ?? null,
                    'sinkronisasi_ntp' => $itemData['sinkronisasi_ntp'] ?? null,
                    'label_pc' => $itemData['label_pc'] ?? null,
                    'pemeriksa' => $itemData['pemeriksa'] ?? null,
                    'pegawai_ybs' => $itemData['pegawai_ybs'] ?? null,
                ]);
            }
        }

        return redirect()->route('form-pc-laptop-checking.index')->with('success', "Formulir PC/Laptop Checking Berhasil Ditambahkan.");
    }

    public function show(string $id)
    {
        $form = FormPcLaptopChecking::with('items')->findOrFail($id);
        $formTemplate = \App\Models\FormTemplate::where('nama', 'PC/Laptop Checking')->first();
        return view('form-pc-laptop-checking.show', compact('form', 'formTemplate'));
    }

    public function edit(string $id)
    {
        $form = FormPcLaptopChecking::with('items')->findOrFail($id);

        $items = [];
        foreach ($form->items as $item) {
            $items[$item->no - 1] = $item;
        }

        $formTemplate = \App\Models\FormTemplate::where('nama', 'PC/Laptop Checking')->first();
        $signers = \App\Models\FormCctv\MasterSigner::all();

        return view('form-pc-laptop-checking.edit', compact('form', 'items', 'formTemplate', 'signers'));
    }

    public function update(Request $request, string $id)
    {
        $form = FormPcLaptopChecking::findOrFail($id);

        $validatedData = $request->validate([
            'no_ref' => 'nullable|string|max:255|unique:form_pc_laptop_checkings,no_ref,' . $form->id,
            'tanggal' => 'nullable|string',
            'business_area' => 'nullable|string|max:255',
            'periode_pemeriksaan' => 'nullable|string|max:255',
            'tanggal_pemeriksaan' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'mengetahui_nama' => 'nullable|string|max:255',
            'mengetahui_nipp' => 'nullable|string|max:255',
            'mengetahui_jabatan' => 'nullable|string|max:255',
            'items' => 'nullable|array',
            'items.*.nama_pengguna' => 'nullable|string|max:255',
            'items.*.unit' => 'nullable|string|max:255',
            'items.*.nda' => 'nullable|string|max:255',
            'items.*.login_strong_password' => 'nullable|string|max:255',
            'items.*.screensaver_lock' => 'nullable|string|max:255',
            'items.*.hak_akses_khusus' => 'nullable|string|max:255',
            'items.*.cleardesk' => 'nullable|string|max:255',
            'items.*.mp3_video_etc' => 'nullable|string|max:255',
            'items.*.antivirus_install' => 'nullable|string|max:255',
            'items.*.antivirus_update' => 'nullable|string|max:255',
            'items.*.full_scan_auto_schedule' => 'nullable|string|max:255',
            'items.*.os_license' => 'nullable|string|max:255',
            'items.*.sinkronisasi_ntp' => 'nullable|string|max:255',
            'items.*.label_pc' => 'nullable|string|max:255',
            'items.*.pemeriksa' => 'nullable|string|max:255',
            'items.*.pegawai_ybs' => 'nullable|string|max:255',
        ], [
            'no_ref.unique' => 'No. Ref ":input" sudah pernah digunakan pada formulir lain. Mohon gunakan No. Ref yang berbeda.'
        ]);

        $form->update([
            'no_ref' => $validatedData['no_ref'] ?? null,
            'tanggal' => $this->parseIndonesianDate($validatedData['tanggal'] ?? null),
            'business_area' => $validatedData['business_area'] ?? null,
            'periode_pemeriksaan' => $validatedData['periode_pemeriksaan'] ?? null,
            'tanggal_pemeriksaan' => $this->parseIndonesianDate($validatedData['tanggal_pemeriksaan'] ?? null),
            'catatan' => $validatedData['catatan'] ?? null,
            'mengetahui_nama' => $validatedData['mengetahui_nama'] ?? null,
            'mengetahui_nipp' => $validatedData['mengetahui_nipp'] ?? null,
            'mengetahui_jabatan' => $validatedData['mengetahui_jabatan'] ?? null,
        ]);

        // Update all other forms' business area if it was provided
        if (!empty($validatedData['business_area'])) {
            FormPcLaptopChecking::where('id', '!=', $form->id)->update(['business_area' => $validatedData['business_area']]);
        }

        $form->items()->delete();

        if (isset($validatedData['items']) && is_array($validatedData['items'])) {
            foreach ($validatedData['items'] as $index => $itemData) {
                // Skip completely empty rows
                if (empty($itemData['nama_pengguna']) && empty($itemData['unit']) && empty($itemData['nda'])) {
                    continue;
                }

                FormPcLaptopCheckingItem::create([
                    'form_pc_laptop_checking_id' => $form->id,
                    'no' => $index + 1,
                    'nama_pengguna' => $itemData['nama_pengguna'] ?? null,
                    'unit' => $itemData['unit'] ?? null,
                    'nda' => $itemData['nda'] ?? null,
                    'login_strong_password' => $itemData['login_strong_password'] ?? null,
                    'screensaver_lock' => $itemData['screensaver_lock'] ?? null,
                    'hak_akses_khusus' => $itemData['hak_akses_khusus'] ?? null,
                    'cleardesk' => $itemData['cleardesk'] ?? null,
                    'mp3_video_etc' => $itemData['mp3_video_etc'] ?? null,
                    'antivirus_install' => $itemData['antivirus_install'] ?? null,
                    'antivirus_update' => $itemData['antivirus_update'] ?? null,
                    'full_scan_auto_schedule' => $itemData['full_scan_auto_schedule'] ?? null,
                    'os_license' => $itemData['os_license'] ?? null,
                    'sinkronisasi_ntp' => $itemData['sinkronisasi_ntp'] ?? null,
                    'label_pc' => $itemData['label_pc'] ?? null,
                    'pemeriksa' => $itemData['pemeriksa'] ?? null,
                    'pegawai_ybs' => $itemData['pegawai_ybs'] ?? null,
                ]);
            }
        }

        return redirect()->route('form-pc-laptop-checking.index')->with('success', "Formulir PC/Laptop Checking Berhasil Diperbarui.");
    }

    public function exportExcel(string $id)
    {
        $form = FormPcLaptopChecking::with('items')->findOrFail($id);
        $formTemplate = \App\Models\FormTemplate::where('nama', 'PC/Laptop Checking')->first();
        $filename = 'pc-laptop-checking-' . ($form->no_ref ?: $form->id) . '.xlsx';
        // Sanitize filename
        $filename = preg_replace('/[\/\\\\]/', '-', $filename);
        return Excel::download(new PcLaptopCheckingExport($form, $formTemplate), $filename);
    }

    public function destroy(string $id)
    {
        $form = FormPcLaptopChecking::findOrFail($id);
        $form->delete();

        return redirect()->route('form-pc-laptop-checking.index')->with('success', "Formulir PC/Laptop Checking Berhasil Dihapus.");
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
