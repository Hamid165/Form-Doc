<?php

namespace App\Http\Controllers\FormKeluarMasukBarangDcDrc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormKeluarMasukBarangDcDrc\FormKeluarMasukBarangDcDrc;
use App\Models\FormKeluarMasukBarangDcDrc\FormKeluarMasukBarangDcDrcItem;
use App\Models\FormCctv\MasterSigner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FormKeluarMasukBarangDcDrcController extends Controller
{
    /**
     * FR-1: Halaman List Formulir
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $activeTab = $request->query('tab', 'formulir');

        $forms = FormKeluarMasukBarangDcDrc::with('items')
            ->when($search, function ($query, $search) {
                return $query->where('no_ref', 'like', "%{$search}%")
                    ->orWhere('nama_pemohon', 'like', "%{$search}%")
                    ->orWhere('nomor_identitas', 'like', "%{$search}%")
                    ->orWhere('business_area', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $forms->appends(['search' => $search]);

        // Load master signers for the tab
        $signers = MasterSigner::orderBy('jabatan', 'asc')->orderBy('nama', 'asc')->get();

        return view('form-keluar-masuk-barang-dc-drc.index', compact('forms', 'search', 'signers', 'activeTab'));
    }

    /**
     * Halaman buat formulir baru
     */
    public function create()
    {
        $masterSigners = MasterSigner::orderBy('nama', 'asc')->get();
        $formTemplate = \App\Models\FormTemplate::where('route_name', 'form-keluar-masuk-barang-dc-drc.index')->first();
        $noRef = FormKeluarMasukBarangDcDrc::generateNoRef();
        $kategoriOptions = FormKeluarMasukBarangDcDrcItem::kategoriOptions();

        return view('form-keluar-masuk-barang-dc-drc.create', compact('masterSigners', 'formTemplate', 'noRef', 'kategoriOptions'));
    }

    /**
     * Simpan formulir baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'nullable|date',
            'business_area' => 'nullable|string|max:255',
            'jenis' => 'required|in:masuk,keluar',
            'tanggal_masuk' => 'nullable|date',
            'jam_masuk' => 'nullable|date_format:H:i',
            'nama_pemohon' => 'required|string|max:255',
            'nomor_identitas' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'nomor_telepon' => 'nullable|string|max:50',
            'perusahaan_unit' => 'nullable|string|max:255',
            'kota_ttd' => 'nullable|string|max:255',
            'jabatan_pelaksana' => 'nullable|string|max:255',
            'nama_pelaksana' => 'nullable|string|max:255',
            'nipp_pelaksana' => 'nullable|string|max:255',
            'jabatan_mengetahui' => 'nullable|string|max:255',
            'nama_mengetahui' => 'nullable|string|max:255',
            'nipp_mengetahui' => 'nullable|string|max:255',
            // Items
            'items' => 'nullable|array',
            'items.*.nama_jenis_aset' => 'required_with:items|string|max:255',
            'items.*.part_no' => 'required_with:items|string',
            'items.*.jumlah' => 'nullable|integer|min:1',
            'items.*.satuan' => 'nullable|string|max:50',
            'items.*.merk_type' => 'nullable|string|max:255',
            'items.*.kategori_aset' => 'nullable|string|max:255',
            'items.*.lokasi_penyimpanan' => 'nullable|string|max:255',
            'items.*.owner' => 'nullable|string|max:255',
            'items.*.power_a' => 'nullable|string|max:50',
            'items.*.berat_kg' => 'nullable|numeric|min:0',
            'items.*.ukuran_u' => 'nullable|string|max:50',
            'items.*.jenis_hw_sw' => 'nullable|string|max:50',
            'items.*.kondisi_baru_bekas' => 'nullable|in:baru,bekas',
            'items.*.kondisi_baik_rusak' => 'nullable|in:baik,rusak',
            'items.*.keterangan' => 'nullable|string',
        ], [
            'nama_pemohon.required' => 'Nama Pemohon wajib diisi.',
            'items.*.nama_jenis_aset.required_with' => 'Nama/Jenis Aset pada tabel tidak boleh kosong jika baris ditambahkan.',
            'items.*.jumlah.integer' => 'Jumlah pada tabel harus berupa angka bulat.',
            'items.*.jumlah.min' => 'Jumlah pada tabel minimal 1.',
            'items.*.part_no.required_with' => 'Part No / Serial Number pada tabel wajib diisi.',
            'items.*.berat_kg.numeric' => 'Berat (KG) pada tabel harus berupa angka/desimal (Gunakan titik untuk desimal, bukan koma).'
        ]);

        $items = $request->input('items', []);
        $snErrors = [];
        if (is_array($items)) {
            foreach ($items as $index => $item) {
                $jumlah = (int) ($item['jumlah'] ?? 0);
                $partNo = trim($item['part_no'] ?? '');
                
                if ($partNo !== '') {
                    $snList = array_filter(array_map('trim', preg_split('/[\n,]+/', $partNo)));
                    $snCount = count($snList);
                    if ($snCount !== $jumlah) {
                        $snErrors["items.{$index}.part_no"] = "Ketidaksesuaian: Jumlah barang {$jumlah}, namun terdeteksi {$snCount} Serial Number. Pastikan jumlah Serial Number sama dengan Jumlah barang.";
                    } else if ($snCount > 1 && count(array_unique(array_map('strtolower', $snList))) !== $snCount) {
                        $snErrors["items.{$index}.part_no"] = "Gagal: Terdapat Serial Number yang duplikat/ganda di baris ini. Pastikan setiap Serial Number unik.";
                    }
                }
            }
        }

        if (!empty($snErrors)) {
            throw \Illuminate\Validation\ValidationException::withMessages($snErrors);
        }

        $form = FormKeluarMasukBarangDcDrc::create([
            'no_ref' => FormKeluarMasukBarangDcDrc::generateNoRef(),
            'tanggal' => $validated['tanggal'] ?? null,
            'business_area' => $validated['business_area'] ?? 'B060',
            'jenis' => $validated['jenis'],
            'tanggal_masuk' => $validated['tanggal_masuk'] ?? null,
            'jam_masuk' => $validated['jam_masuk'] ?? null,
            'nama_pemohon' => $validated['nama_pemohon'],
            'nomor_identitas' => $validated['nomor_identitas'],
            'alamat' => $validated['alamat'] ?? null,
            'nomor_telepon' => $validated['nomor_telepon'] ?? null,
            'perusahaan_unit' => $validated['perusahaan_unit'] ?? null,
            'kota_ttd' => $validated['kota_ttd'] ?? null,
            'jabatan_pelaksana' => $validated['jabatan_pelaksana'] ?? null,
            'nama_pelaksana' => $validated['nama_pelaksana'] ?? null,
            'nipp_pelaksana' => $validated['nipp_pelaksana'] ?? null,
            'jabatan_mengetahui' => $validated['jabatan_mengetahui'] ?? null,
            'nama_mengetahui' => $validated['nama_mengetahui'] ?? null,
            'nipp_mengetahui' => $validated['nipp_mengetahui'] ?? null,
            'created_by' => Auth::id() ?? 1,
        ]);

        // Simpan items
        if (isset($validated['items']) && is_array($validated['items'])) {
            foreach ($validated['items'] as $index => $itemData) {
                if (empty($itemData['nama_jenis_aset'])) {
                    continue;
                }

                $item = FormKeluarMasukBarangDcDrcItem::create([
                    'form_barang_id' => $form->id,
                    'no_urut' => $index + 1,
                    'nama_jenis_aset' => $itemData['nama_jenis_aset'],
                    'part_no' => $itemData['part_no'] ?? null,
                    'jumlah' => $itemData['jumlah'] ?? 1,
                    'satuan' => $itemData['satuan'] ?? 'Unit',
                    'merk_type' => $itemData['merk_type'] ?? '',
                    'kategori_aset' => $itemData['kategori_aset'] ?? '',
                    'lokasi_penyimpanan' => $itemData['lokasi_penyimpanan'] ?? '',
                    'owner' => $itemData['owner'] ?? null,
                    'power_a' => $itemData['power_a'] ?? null,
                    'berat_kg' => $itemData['berat_kg'] ?? null,
                    'ukuran_u' => $itemData['ukuran_u'] ?? null,
                    'jenis_hw_sw' => $itemData['jenis_hw_sw'] ?? null,
                    'kondisi_baru_bekas' => $itemData['kondisi_baru_bekas'] ?? 'baru',
                    'kondisi_baik_rusak' => $itemData['kondisi_baik_rusak'] ?? 'baik',
                    'keterangan' => $itemData['keterangan'] ?? null,
                ]);
            }
        }

        return redirect()->route('form-keluar-masuk-barang-dc-drc.index')->with('success', "Formulir {$form->no_ref} berhasil ditambahkan.");
    }

    /**
     * Detail formulir
     */
    public function show(string $id)
    {
        $form = FormKeluarMasukBarangDcDrc::with(['items', 'creator'])->findOrFail($id);
        $formTemplate = \App\Models\FormTemplate::where('route_name', 'form-keluar-masuk-barang-dc-drc.index')->first();

        return view('form-keluar-masuk-barang-dc-drc.show', compact('form', 'formTemplate'));
    }

    /**
     * Halaman edit formulir
     */
    public function edit(string $id)
    {
        $form = FormKeluarMasukBarangDcDrc::with('items')->findOrFail($id);
        $masterSigners = MasterSigner::orderBy('nama', 'asc')->get();
        $formTemplate = \App\Models\FormTemplate::where('route_name', 'form-keluar-masuk-barang-dc-drc.index')->first();
        $kategoriOptions = FormKeluarMasukBarangDcDrcItem::kategoriOptions();

        // Prepare items JSON for Alpine.js (edit mode)
        $existingItems = '[]';
        if ($form->items->count() > 0) {
            $existingItems = json_encode($form->items->map(function($item) {
                return [
                    'nama_jenis_aset' => $item->nama_jenis_aset,
                    'part_no' => $item->part_no ?? '',
                    'jumlah' => $item->jumlah,
                    'satuan' => $item->satuan,
                    'merk_type' => $item->merk_type ?? '',
                    'kategori_aset' => $item->kategori_aset ?? '',
                    'lokasi_penyimpanan' => $item->lokasi_penyimpanan ?? '',
                    'owner' => $item->owner ?? '',
                    'power_a' => $item->power_a ?? '',
                    'berat_kg' => $item->berat_kg ?? '',
                    'ukuran_u' => $item->ukuran_u ?? '',
                    'jenis_hw_sw' => $item->jenis_hw_sw ?? '',
                    'kondisi_baru_bekas' => $item->kondisi_baru_bekas ?? 'baru',
                    'kondisi_baik_rusak' => $item->kondisi_baik_rusak ?? 'baik',
                    'keterangan' => $item->keterangan ?? '',
                    'expanded' => false,
                ];
            })->values()->toArray());
        }

        return view('form-keluar-masuk-barang-dc-drc.edit', compact('form', 'masterSigners', 'formTemplate', 'kategoriOptions', 'existingItems'));
    }

    /**
     * Update formulir
     */
    public function update(Request $request, string $id)
    {
        $form = FormKeluarMasukBarangDcDrc::findOrFail($id);

        $validated = $request->validate([
            'tanggal' => 'nullable|date',
            'business_area' => 'nullable|string|max:255',
            'jenis' => 'required|in:masuk,keluar',
            'tanggal_masuk' => 'nullable|date',
            'jam_masuk' => 'nullable|date_format:H:i',
            'nama_pemohon' => 'required|string|max:255',
            'nomor_identitas' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'nomor_telepon' => 'nullable|string|max:50',
            'perusahaan_unit' => 'nullable|string|max:255',
            'kota_ttd' => 'nullable|string|max:255',
            'jabatan_pelaksana' => 'nullable|string|max:255',
            'nama_pelaksana' => 'nullable|string|max:255',
            'nipp_pelaksana' => 'nullable|string|max:255',
            'jabatan_mengetahui' => 'nullable|string|max:255',
            'nama_mengetahui' => 'nullable|string|max:255',
            'nipp_mengetahui' => 'nullable|string|max:255',
            'items' => 'nullable|array',
            'items.*.nama_jenis_aset' => 'required_with:items|string|max:255',
            'items.*.part_no' => 'required_with:items|string',
            'items.*.jumlah' => 'nullable|integer|min:1',
            'items.*.satuan' => 'nullable|string|max:50',
            'items.*.merk_type' => 'nullable|string|max:255',
            'items.*.kategori_aset' => 'nullable|string|max:255',
            'items.*.lokasi_penyimpanan' => 'nullable|string|max:255',
            'items.*.owner' => 'nullable|string|max:255',
            'items.*.power_a' => 'nullable|string|max:50',
            'items.*.berat_kg' => 'nullable|numeric|min:0',
            'items.*.ukuran_u' => 'nullable|string|max:50',
            'items.*.jenis_hw_sw' => 'nullable|string|max:50',
            'items.*.kondisi_baru_bekas' => 'nullable|in:baru,bekas',
            'items.*.kondisi_baik_rusak' => 'nullable|in:baik,rusak',
            'items.*.keterangan' => 'nullable|string',
        ], [
            'nama_pemohon.required' => 'Nama Pemohon wajib diisi.',
            'items.*.nama_jenis_aset.required_with' => 'Nama/Jenis Aset pada tabel tidak boleh kosong jika baris ditambahkan.',
            'items.*.jumlah.integer' => 'Jumlah pada tabel harus berupa angka bulat.',
            'items.*.jumlah.min' => 'Jumlah pada tabel minimal 1.',
            'items.*.part_no.required_with' => 'Part No / Serial Number pada tabel wajib diisi.',
            'items.*.berat_kg.numeric' => 'Berat (KG) pada tabel harus berupa angka/desimal (Gunakan titik untuk desimal, bukan koma).'
        ]);

        $items = $request->input('items', []);
        $snErrors = [];
        if (is_array($items)) {
            foreach ($items as $index => $item) {
                $jumlah = (int) ($item['jumlah'] ?? 0);
                $partNo = trim($item['part_no'] ?? '');
                
                if ($partNo !== '') {
                    $snList = array_filter(array_map('trim', preg_split('/[\n,]+/', $partNo)));
                    $snCount = count($snList);
                    if ($snCount !== $jumlah) {
                        $snErrors["items.{$index}.part_no"] = "Ketidaksesuaian: Jumlah barang {$jumlah}, namun terdeteksi {$snCount} Serial Number. Pastikan jumlah Serial Number sama dengan Jumlah barang.";
                    } else if ($snCount > 1 && count(array_unique(array_map('strtolower', $snList))) !== $snCount) {
                        $snErrors["items.{$index}.part_no"] = "Gagal: Terdapat Serial Number yang duplikat/ganda di baris ini. Pastikan setiap Serial Number unik.";
                    }
                }
            }
        }

        if (!empty($snErrors)) {
            throw \Illuminate\Validation\ValidationException::withMessages($snErrors);
        }

        $form->update([
            'tanggal' => $validated['tanggal'] ?? null,
            'business_area' => $validated['business_area'] ?? 'B060',
            'jenis' => $validated['jenis'],
            'tanggal_masuk' => $validated['tanggal_masuk'] ?? null,
            'jam_masuk' => $validated['jam_masuk'] ?? null,
            'nama_pemohon' => $validated['nama_pemohon'],
            'nomor_identitas' => $validated['nomor_identitas'],
            'alamat' => $validated['alamat'] ?? null,
            'nomor_telepon' => $validated['nomor_telepon'] ?? null,
            'perusahaan_unit' => $validated['perusahaan_unit'] ?? null,
            'kota_ttd' => $validated['kota_ttd'] ?? null,
            'jabatan_pelaksana' => $validated['jabatan_pelaksana'] ?? null,
            'nama_pelaksana' => $validated['nama_pelaksana'] ?? null,
            'nipp_pelaksana' => $validated['nipp_pelaksana'] ?? null,
            'jabatan_mengetahui' => $validated['jabatan_mengetahui'] ?? null,
            'nama_mengetahui' => $validated['nama_mengetahui'] ?? null,
            'nipp_mengetahui' => $validated['nipp_mengetahui'] ?? null,
        ]);


        // Hapus items lama, buat ulang
        $form->items()->delete();

        if (isset($validated['items']) && is_array($validated['items'])) {
            foreach ($validated['items'] as $index => $itemData) {
                if (empty($itemData['nama_jenis_aset'])) {
                    continue;
                }

                $item = FormKeluarMasukBarangDcDrcItem::create([
                    'form_barang_id' => $form->id,
                    'no_urut' => $index + 1,
                    'nama_jenis_aset' => $itemData['nama_jenis_aset'],
                    'part_no' => $itemData['part_no'] ?? null,
                    'jumlah' => $itemData['jumlah'] ?? 1,
                    'satuan' => $itemData['satuan'] ?? 'Unit',
                    'merk_type' => $itemData['merk_type'] ?? '',
                    'kategori_aset' => $itemData['kategori_aset'] ?? '',
                    'lokasi_penyimpanan' => $itemData['lokasi_penyimpanan'] ?? '',
                    'owner' => $itemData['owner'] ?? null,
                    'power_a' => $itemData['power_a'] ?? null,
                    'berat_kg' => $itemData['berat_kg'] ?? null,
                    'ukuran_u' => $itemData['ukuran_u'] ?? null,
                    'jenis_hw_sw' => $itemData['jenis_hw_sw'] ?? null,
                    'kondisi_baru_bekas' => $itemData['kondisi_baru_bekas'] ?? 'baru',
                    'kondisi_baik_rusak' => $itemData['kondisi_baik_rusak'] ?? 'baik',
                    'keterangan' => $itemData['keterangan'] ?? null,
                ]);


            }
        }

        return redirect()->route('form-keluar-masuk-barang-dc-drc.index')->with('success', "Formulir {$form->no_ref} berhasil diperbarui.");
    }

    /**
     * Hapus formulir
     */
    public function destroy(string $id)
    {
        $form = FormKeluarMasukBarangDcDrc::with('items')->findOrFail($id);



        $form->delete();

        return redirect()->route('form-keluar-masuk-barang-dc-drc.index')->with('success', "Formulir {$form->no_ref} berhasil dihapus.");
    }

    /**
     * Parse Excel file for item import
     */
    public function parseExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048'
        ]);

        try {
            $import = new \App\Imports\FormKeluarMasukBarangDcDrc\FormKeluarMasukBarangDcDrcItemImport();
            $data = \Maatwebsite\Excel\Facades\Excel::toCollection($import, $request->file('file'))->first();
            
            // Jika kosong, return data kosong
            if ($data->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'data' => []
                ]);
            }
            
            // Process data through import's collection method
            $formattedData = $import->collection($data);

            return response()->json([
                'success' => true,
                'data' => $formattedData
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Form Keluar Masuk Barang Parse Excel Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membaca file Excel: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download template Excel for item import
     */
    public function downloadTemplateItems()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\FormKeluarMasukBarangDcDrc\FormKeluarMasukBarangDcDrcItemTemplateExport,
            'Template_Isi_Tabel_Keluar_Masuk_Barang.xlsx'
        );
    }
}
