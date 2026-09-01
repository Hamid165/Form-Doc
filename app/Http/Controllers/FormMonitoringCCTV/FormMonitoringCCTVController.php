<?php

namespace App\Http\Controllers\FormMonitoringCCTV;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormMonitoringCCTV\FormMonitoringCCTV;
use App\Models\FormCctv\MasterSigner;
use App\Models\FormCctv\MasterCctv; 
use App\Models\FormMonitoringCCTV\MasterPetugas; 
use Carbon\Carbon;

class FormMonitoringCCTVController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'formulir');
        $search = $request->query('search');
        $sort = $request->query('sort', 'terbaru');
        
        $viewData = ['activeTab' => $activeTab];
        $direction = $sort === 'terlama' ? 'asc' : 'desc';

        switch ($activeTab) {
            case 'formulir':
                $query = FormMonitoringCCTV::orderBy('created_at', $direction);
                if ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('no_ref', 'like', "%{$search}%")
                          ->orWhere('business_area', 'like', "%{$search}%")
                          ->orWhere('bulan', 'like', "%{$search}%");
                    });
                }
                $viewData['formulirs'] = $query->paginate(10);
                break;
            case 'cctv':
                $query = MasterCctv::orderBy('created_at', $direction);
                if ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('id_cctv', 'like', "%{$search}%")
                          ->orWhere('lokasi', 'like', "%{$search}%");
                    });
                }
                $viewData['cctvs'] = $query->paginate(10);
                $viewData['editCctv'] = null;
                if ($request->has('edit_cctv_id')) {
                    $viewData['editCctv'] = MasterCctv::find($request->edit_cctv_id);
                }
                break;
            case 'petugas':
                $query = MasterPetugas::orderBy('created_at', $direction);
                if ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%")
                          ->orWhere('nipp', 'like', "%{$search}%");
                    });
                }
                $viewData['petugas'] = $query->paginate(10); 
                $viewData['editPetugas'] = null;
                if ($request->has('edit_petugas_id')) {
                    $viewData['editPetugas'] = MasterPetugas::find($request->edit_petugas_id);
                }
                break;
            case 'penandatangan':
                $query = MasterSigner::orderBy('created_at', $direction);
                if ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%")
                          ->orWhere('nipp', 'like', "%{$search}%");
                    });
                }
                $viewData['penandatangans'] = $query->paginate(10);
                $viewData['editSigner'] = null;
                if ($request->has('edit_signer_id')) {
                    $viewData['editSigner'] = MasterSigner::find($request->edit_signer_id);
                }
                break;
            default:
                abort(404);
        }

        return view('form-monitoring-cctv.index', $viewData);
    }

    public function create()
    {
        $signers = MasterSigner::all(); 
        $petugas = MasterPetugas::all(); 
        $cctvs = \App\Models\FormCctv\MasterCctv::all(); // Sediakan daftar dropdown CCTV

        return view('form-monitoring-cctv.create', compact('signers', 'petugas', 'cctvs'));
    }

    public function store(Request $request)
    {
        // Ambil semua data selain array items
        $data = $request->except('items');
        
        // Daftar nama kolom tanggal yang berpotensi ada di form
        $dateFields = [
            'tanggal', 'tgl_pelaksanaan_m1', 'tgl_pelaksanaan_m2', 
            'tgl_pelaksanaan_m3', 'tgl_pelaksanaan_m4', 
            'mengetahui_tanggal', 'petugas_tanggal', 'kota_tanggal'
        ];

        // Format semua tanggal utama ke YYYY-MM-DD dengan aman
        foreach ($dateFields as $field) {
            if (!empty($data[$field])) {
                $data[$field] = $this->parseIndoDate($data[$field]);
            }
        }
        $data['status'] = 'draft';

        $monitoring = FormMonitoringCCTV::create($data);

        // Proses array items (Tabel Checklist) dengan filter keamanan
        if ($request->has('items') && is_array($request->items)) {
            foreach ($request->items as $item) {
                // Konversi tanggal yang ada di DALAM tabel checklist
                if (!empty($item['tanggal'])) {
                    $item['tanggal'] = $this->parseIndoDate($item['tanggal']);
                }
                
                $monitoring->items()->create($item);
            }
        }

        return redirect()->route('form-monitoring-cctv.index', ['tab' => 'formulir'])
                         ->with('success', 'Formulir berhasil disimpan!');
    }

    public function show($id)
    {
        $monitoring = FormMonitoringCCTV::with(['items', 'mengetahui'])->findOrFail($id);
        
        return view('form-monitoring-cctv.show', compact('monitoring'));
    }

    public function edit($id)
    {
        $monitoring = FormMonitoringCCTV::with('items')->findOrFail($id);
        $signers = MasterSigner::all(); 
        $petugas = MasterPetugas::all(); 
        $cctvs = \App\Models\FormCctv\MasterCctv::all();

        // Biarkan datepicker di UI yang otomatis memformat tampilan tanggalnya
        return view('form-monitoring-cctv.edit', compact('monitoring', 'signers', 'petugas', 'cctvs'));
    }

    public function update(Request $request, $id)
    {
        $monitoring = FormMonitoringCCTV::findOrFail($id);
        $data = $request->except('items');
        
        // Format semua tanggal utama ke YYYY-MM-DD
        $dateFields = [
            'tanggal', 'tgl_pelaksanaan_m1', 'tgl_pelaksanaan_m2', 
            'tgl_pelaksanaan_m3', 'tgl_pelaksanaan_m4', 
            'mengetahui_tanggal', 'petugas_tanggal', 'kota_tanggal'
        ];

        foreach ($dateFields as $field) {
            if (!empty($data[$field])) {
                $data[$field] = $this->parseIndoDate($data[$field]);
            }
        }

        $monitoring->update($data);

        // Selalu hapus item lama, sehingga jika user menghapus semua baris, tetap tersimpan (jadi 0 baris)
        $monitoring->items()->delete(); 

        // Proses update array items dengan filter keamanan
        if ($request->has('items') && is_array($request->items)) { 
            
            foreach ($request->items as $item) {
                // Konversi tanggal di dalam item jika ada
                if (!empty($item['tanggal'])) {
                    $item['tanggal'] = $this->parseIndoDate($item['tanggal']);
                }
                $monitoring->items()->create($item);
            }
        }

        return redirect()->route('form-monitoring-cctv.index', ['tab' => 'formulir'])
                         ->with('success', 'Formulir berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $monitoring = FormMonitoringCCTV::findOrFail($id);
        $monitoring->delete();

        return redirect()->route('form-monitoring-cctv.index', ['tab' => 'formulir'])
                         ->with('success', 'Formulir berhasil dihapus!');
    }

    public function print($id)
    {
        $monitoring = FormMonitoringCCTV::with(['items', 'mengetahui'])->findOrFail($id);
        
        if (strtolower($monitoring->status) !== 'selesai') {
            $monitoring->update(['status' => 'selesai']);
        }

        // --- UBAH: Arahkan ke file print.blade.php dan set kertas ke A4 Landscape ---
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('form-monitoring-cctv.print', compact('monitoring'))
                ->setPaper('a4', 'landscape');
                
        $safe_no_ref = str_replace(['/', '\\'], '-', $monitoring->no_ref);
        return $pdf->stream('Form-Monitoring-CCTV-'.$safe_no_ref.'.pdf');
    }

    // =========================================================================
    // FUNGSI TAB MASTER DATA
    // =========================================================================

    public function storePetugas(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nipp' => 'required|string|max:255',
        ]);

        MasterPetugas::create($request->only('nama', 'nipp'));

        return redirect()->route('form-monitoring-cctv.index', ['tab' => 'petugas'])
                         ->with('success', 'Data Petugas berhasil ditambahkan!');
    }

    public function storeCctv(Request $request)
    {
        $request->validate([
            'nama_titik' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
        ]);

        MasterCctv::create([
            'id_cctv' => $request->nama_titik,
            'lokasi' => $request->lokasi
        ]);

        return redirect()->route('form-monitoring-cctv.index', ['tab' => 'cctv'])
                         ->with('success', 'Data Titik CCTV berhasil ditambahkan!');
    }

    public function updateCctv(Request $request, $id)
    {
        $request->validate([
            'nama_titik' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
        ]);

        $cctv = MasterCctv::findOrFail($id);
        
        $cctv->update([
            'id_cctv' => $request->nama_titik,
            'lokasi' => $request->lokasi
        ]);

        return redirect()->route('form-monitoring-cctv.index', ['tab' => 'cctv'])
                         ->with('success', 'Data Titik CCTV berhasil diperbarui!');
    }

    public function destroyCctv($id)
    {
        $cctv = MasterCctv::findOrFail($id);
        $cctv->delete();

        return redirect()->route('form-monitoring-cctv.index', ['tab' => 'cctv'])
                         ->with('success', 'Data Titik CCTV berhasil dihapus!');
    }

    public function storeSigner(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nipp' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
        ]);

        MasterSigner::create($request->only('nama', 'nipp', 'jabatan'));

        return redirect()->route('form-monitoring-cctv.index', ['tab' => 'penandatangan'])
                         ->with('success', 'Data Penanda Tangan berhasil ditambahkan!');
    }

    public function updatePetugas(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nipp' => 'required|string|max:255',
        ]);

        MasterPetugas::findOrFail($id)->update($request->only('nama', 'nipp'));

        return redirect()->route('form-monitoring-cctv.index', ['tab' => 'petugas'])
                         ->with('success', 'Data Petugas berhasil diperbarui!');
    }

    public function destroyPetugas($id)
    {
        MasterPetugas::findOrFail($id)->delete();
        return redirect()->route('form-monitoring-cctv.index', ['tab' => 'petugas'])
                         ->with('success', 'Data Petugas berhasil dihapus!');
    }

    public function updateSigner(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nipp' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
        ]);

        MasterSigner::findOrFail($id)->update($request->only('nama', 'nipp', 'jabatan'));

        return redirect()->route('form-monitoring-cctv.index', ['tab' => 'penandatangan'])
                         ->with('success', 'Data Penanda Tangan berhasil diperbarui!');
    }

    public function destroySigner($id)
    {
        MasterSigner::findOrFail($id)->delete();
        return redirect()->route('form-monitoring-cctv.index', ['tab' => 'penandatangan'])
                         ->with('success', 'Data Penanda Tangan berhasil dihapus!');
    }

    // =========================================================================
    // HELPER TANGGAL
    // =========================================================================

    /**
     * Konversi "26 Agustus 2026" ke "2026-08-26" (Standar DB)
     */
    private function parseIndoDate($dateString)
    {
        if (empty($dateString)) return null;

        // Jika sudah berformat YYYY-MM-DD, kembalikan langsung
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateString)) return $dateString;

        $bulanIndo = [
            'Januari' => '01', 'Februari' => '02', 'Maret' => '03',
            'April' => '04', 'Mei' => '05', 'Juni' => '06',
            'Juli' => '07', 'Agustus' => '08', 'September' => '09',
            'Oktober' => '10', 'November' => '11', 'Desember' => '12'
        ];

        // Ubah teks nama bulan menjadi angka
        $dateStr = str_ireplace(array_keys($bulanIndo), array_values($bulanIndo), $dateString);
        
        try {
            // Coba membaca format "d m Y" (contoh hasil dari proses replace: "26 08 2026")
            return Carbon::createFromFormat('d m Y', trim($dateStr))->format('Y-m-d');
        } catch (\Exception $e) {
            try {
                // Alternatif parsing dinamis jika bentuknya ada koma dll
                return Carbon::parse($dateStr)->format('Y-m-d');
            } catch (\Exception $e2) {
                return null;
            }
        }
    }
}