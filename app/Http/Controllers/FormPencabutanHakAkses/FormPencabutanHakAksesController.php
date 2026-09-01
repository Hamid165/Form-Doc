<?php

namespace App\Http\Controllers\FormPencabutanHakAkses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormPencabutanHakAkses\FormPencabutanHakAkses;
use App\Models\FormPencabutanHakAkses\FormPencabutanHakAksesItem;

class FormPencabutanHakAksesController extends Controller
{
    public function index()
    {
        $forms = FormPencabutanHakAkses::orderBy('created_at', 'desc')->paginate(5, ['*'], 'form_page');
        $masterPemohons = \App\Models\FormPencabutanHakAkses\MasterPemohon::orderBy('created_at', 'desc')->paginate(5, ['*'], 'master_page');
        return view('form-pencabutan-hak-akses.index', compact('forms', 'masterPemohons'));
    }

    public function create()
    {
        $formTemplate = \App\Models\FormTemplate::where('nama', 'Permohonan Pencabutan Hak Akses')->first();
        $form = new FormPencabutanHakAkses();
        // Ambil master pemohon tanpa batasan agar bisa dipakai berulang kali
        $masterPemohons = \App\Models\FormPencabutanHakAkses\MasterPemohon::orderBy('nama_pemohon', 'asc')->get();
        $bagianFungsiList = FormPencabutanHakAkses::whereNotNull('bagian_fungsi')->distinct()->pluck('bagian_fungsi');
        $kotaTanggalList = FormPencabutanHakAkses::whereNotNull('kota_tanggal_pemohon')->distinct()->pluck('kota_tanggal_pemohon');
        $jabatanMengetahuiList = FormPencabutanHakAkses::whereNotNull('jabatan_mengetahui')->distinct()->pluck('jabatan_mengetahui');
        $mengetahuiNamaList = FormPencabutanHakAkses::whereNotNull('mengetahui_nama')->distinct()->pluck('mengetahui_nama');

        return view('form-pencabutan-hak-akses.create', compact(
            'formTemplate', 'form', 'masterPemohons', 
            'bagianFungsiList', 'kotaTanggalList', 'jabatanMengetahuiList', 'mengetahuiNamaList'
        ));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no_ref' => 'nullable|string|max:255|unique:form_revocations,no_ref',
            'tanggal' => 'nullable|string',
            'business_area' => 'nullable|string|max:255',
            'tanggal_permohonan' => 'nullable|string',
            'nama_pemohon' => 'nullable|string|max:255',
            'nip_pemohon' => 'nullable|string|max:255',
            'bagian_fungsi' => 'nullable|string|max:255',
            'kota_tanggal_pemohon' => 'nullable|string|max:255',
            'status_persetujuan' => 'nullable|string|max:255',
            'kota_tanggal_setuju' => 'nullable|string|max:255',
            'jabatan_mengetahui' => 'nullable|string|max:255',
            'mengetahui_nama' => 'nullable|string|max:255',
            'items' => 'nullable|array',
            'items.*.nama_pengguna' => 'nullable|string|max:255',
            'items.*.jenis_akun' => 'nullable|string|max:255',
            'items.*.unit_kerja' => 'nullable|string|max:255',
            'items.*.alasan' => 'nullable|string',
        ], [
            'no_ref.unique' => 'No. Ref ":input" sudah pernah digunakan pada formulir lain. Mohon gunakan No. Ref yang berbeda.'
        ]);

        $form = FormPencabutanHakAkses::create([
            'no_ref' => $validatedData['no_ref'] ?? null,
            'tanggal' => $this->parseIndonesianDate($validatedData['tanggal'] ?? null),
            'business_area' => $validatedData['business_area'] ?? null,
            'tanggal_permohonan' => $this->parseIndonesianDate($validatedData['tanggal_permohonan'] ?? null),
            'nama_pemohon' => $validatedData['nama_pemohon'] ?? null,
            'nip_pemohon' => $validatedData['nip_pemohon'] ?? null,
            'bagian_fungsi' => $validatedData['bagian_fungsi'] ?? null,
            'kota_tanggal_pemohon' => $validatedData['kota_tanggal_pemohon'] ?? null,
            'status_persetujuan' => $validatedData['status_persetujuan'] ?? 'DISETUJUI',
            'kota_tanggal_setuju' => $validatedData['kota_tanggal_setuju'] ?? null,
            'jabatan_mengetahui' => $validatedData['jabatan_mengetahui'] ?? null,
            'mengetahui_nama' => $validatedData['mengetahui_nama'] ?? null,
        ]);

        // Update all other forms' business area if it was provided
        if (!empty($validatedData['business_area'])) {
            FormPencabutanHakAkses::where('id', '!=', $form->id)->update(['business_area' => $validatedData['business_area']]);
        }

        if (isset($validatedData['items']) && is_array($validatedData['items'])) {
            foreach ($validatedData['items'] as $index => $itemData) {
                // Skip completely empty rows
                if (empty($itemData['nama_pengguna']) && empty($itemData['jenis_akun']) && empty($itemData['unit_kerja']) && empty($itemData['alasan'])) {
                    continue;
                }
                
                $no = $index;
                FormPencabutanHakAksesItem::create([
                    'form_revocation_id' => $form->id,
                    'no' => $no,
                    'nama_pengguna' => $itemData['nama_pengguna'] ?? null,
                    'jenis_akun' => $itemData['jenis_akun'] ?? null,
                    'unit_kerja' => $itemData['unit_kerja'] ?? null,
                    'alasan' => $itemData['alasan'] ?? null,
                ]);
            }
        }

        return redirect()->route('form-pencabutan-hak-akses.index')->with('success', "Formulir Pencabutan Hak Akses Berhasil Ditambahkan.");
    }

    public function show(string $id)
    {
        $form = FormPencabutanHakAkses::with('items')->findOrFail($id);
        $formTemplate = \App\Models\FormTemplate::where('nama', 'Permohonan Pencabutan Hak Akses')->first();
        return view('form-pencabutan-hak-akses.show', compact('form', 'formTemplate'));
    }

    public function edit(string $id)
    {
        $form = FormPencabutanHakAkses::with('items')->findOrFail($id);
        
        $items = [];
        foreach ($form->items as $item) {
            $items[$item->no] = $item;
        }
        
        $formTemplate = \App\Models\FormTemplate::where('nama', 'Permohonan Pencabutan Hak Akses')->first();
        // Ambil master pemohon tanpa batasan agar bisa dipakai berulang kali
        $masterPemohons = \App\Models\FormPencabutanHakAkses\MasterPemohon::orderBy('nama_pemohon', 'asc')->get();
        
        $bagianFungsiList = FormPencabutanHakAkses::whereNotNull('bagian_fungsi')->distinct()->pluck('bagian_fungsi');
        $kotaTanggalList = FormPencabutanHakAkses::whereNotNull('kota_tanggal_pemohon')->distinct()->pluck('kota_tanggal_pemohon');
        $jabatanMengetahuiList = FormPencabutanHakAkses::whereNotNull('jabatan_mengetahui')->distinct()->pluck('jabatan_mengetahui');
        $mengetahuiNamaList = FormPencabutanHakAkses::whereNotNull('mengetahui_nama')->distinct()->pluck('mengetahui_nama');

        return view('form-pencabutan-hak-akses.edit', compact(
            'form', 'items', 'formTemplate', 'masterPemohons',
            'bagianFungsiList', 'kotaTanggalList', 'jabatanMengetahuiList', 'mengetahuiNamaList'
        ));
    }

    public function update(Request $request, string $id)
    {
        $form = FormPencabutanHakAkses::findOrFail($id);
        
        $validatedData = $request->validate([
            'no_ref' => 'nullable|string|max:255|unique:form_revocations,no_ref,' . $form->id,
            'tanggal' => 'nullable|string',
            'business_area' => 'nullable|string|max:255',
            'tanggal_permohonan' => 'nullable|string',
            'nama_pemohon' => 'nullable|string|max:255',
            'nip_pemohon' => 'nullable|string|max:255',
            'bagian_fungsi' => 'nullable|string|max:255',
            'kota_tanggal_pemohon' => 'nullable|string|max:255',
            'status_persetujuan' => 'nullable|string|max:255',
            'kota_tanggal_setuju' => 'nullable|string|max:255',
            'jabatan_mengetahui' => 'nullable|string|max:255',
            'mengetahui_nama' => 'nullable|string|max:255',
            'items' => 'nullable|array',
            'items.*.nama_pengguna' => 'nullable|string|max:255',
            'items.*.jenis_akun' => 'nullable|string|max:255',
            'items.*.unit_kerja' => 'nullable|string|max:255',
            'items.*.alasan' => 'nullable|string',
        ], [
            'no_ref.unique' => 'No. Ref ":input" sudah pernah digunakan pada formulir lain. Mohon gunakan No. Ref yang berbeda.'
        ]);

        $form->update([
            'no_ref' => $validatedData['no_ref'] ?? null,
            'tanggal' => $this->parseIndonesianDate($validatedData['tanggal'] ?? null),
            'business_area' => $validatedData['business_area'] ?? null,
            'tanggal_permohonan' => $this->parseIndonesianDate($validatedData['tanggal_permohonan'] ?? null),
            'nama_pemohon' => $validatedData['nama_pemohon'] ?? null,
            'nip_pemohon' => $validatedData['nip_pemohon'] ?? null,
            'bagian_fungsi' => $validatedData['bagian_fungsi'] ?? null,
            'kota_tanggal_pemohon' => $validatedData['kota_tanggal_pemohon'] ?? null,
            'status_persetujuan' => $validatedData['status_persetujuan'] ?? 'DISETUJUI',
            'kota_tanggal_setuju' => $validatedData['kota_tanggal_setuju'] ?? null,
            'jabatan_mengetahui' => $validatedData['jabatan_mengetahui'] ?? null,
            'mengetahui_nama' => $validatedData['mengetahui_nama'] ?? null,
        ]);
        
        // Update all other forms' business area if it was provided
        if (!empty($validatedData['business_area'])) {
            FormPencabutanHakAkses::where('id', '!=', $form->id)->update(['business_area' => $validatedData['business_area']]);
        }
        
        $form->items()->delete();

        if (isset($validatedData['items']) && is_array($validatedData['items'])) {
            foreach ($validatedData['items'] as $index => $itemData) {
                $no = $index;
                FormPencabutanHakAksesItem::create([
                    'form_revocation_id' => $form->id,
                    'no' => $no,
                    'nama_pengguna' => $itemData['nama_pengguna'] ?? null,
                    'jenis_akun' => $itemData['jenis_akun'] ?? null,
                    'unit_kerja' => $itemData['unit_kerja'] ?? null,
                    'alasan' => $itemData['alasan'] ?? null,
                ]);
            }
        }

        return redirect()->route('form-pencabutan-hak-akses.index')->with('success', "Formulir Pencabutan Hak Akses Berhasil Diperbarui.");
    }

    public function destroy(string $id)
    {
        $form = FormPencabutanHakAkses::findOrFail($id);
        $form->delete();
        
        return redirect()->route('form-pencabutan-hak-akses.index')->with('success', "Formulir Pencabutan Hak Akses Berhasil Dihapus.");
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
