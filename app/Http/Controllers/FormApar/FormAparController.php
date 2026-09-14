<?php

namespace App\Http\Controllers\FormApar;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\FormApar\FormApar;
use App\Models\FormApar\FormAparItem;
use App\Models\FormApar\MasterApar;
use App\Models\FormApar\MasterSigner;

class FormAparController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $forms = FormApar::when($search, function ($query, $search) {
            return $query->where('no_ref', 'like', "%{$search}%")
                         ->orWhere('bulan', 'like', "%{$search}%")
                         ->orWhere('petugas_name', 'like', "%{$search}%");
        })->orderBy('created_at', 'desc')->paginate(5, ['*'], 'form_page');

        $forms->appends(['search' => $search]);

        $masterApars = MasterApar::with('vendor')->where('status', 'Aktif')->orderBy('kode_aset', 'asc')->paginate(5, ['*'], 'apar_page');
        $nonActiveApars = MasterApar::with('vendor')->where('status', 'Non Aktif')->orderBy('kode_aset', 'asc')->paginate(5, ['*'], 'non_apar_page');
        $masterVendors = \App\Models\FormApar\MasterVendor::orderBy('nama_vendor', 'asc')->paginate(5, ['*'], 'vendor_page');
        $historySearch = $request->query('history_search');
        $historyDate = $request->query('history_date');
        $historyType = $request->query('history_type');

        $aparHistories = \App\Models\FormApar\AparHistory::with('masterApar')
            ->when($historySearch, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('keterangan', 'like', "%{$search}%")
                      ->orWhere('data_lama', 'like', "%{$search}%")
                      ->orWhere('data_baru', 'like', "%{$search}%")
                      ->orWhereHas('masterApar', function ($qa) use ($search) {
                          $qa->where('kode_aset', 'like', "%{$search}%");
                      });
                });
            })
            ->when($historyDate, function ($query, $date) {
                return $query->whereDate('tanggal_perubahan', $date);
            })
            ->when($historyType, function ($query, $type) {
                return $query->where('jenis_perubahan', $type);
            })
            ->orderBy('created_at', 'asc')
            ->paginate(5, ['*'], 'history_page');
        
        $aparHistories->appends([
            'history_search' => $historySearch,
            'history_date'   => $historyDate,
            'history_type'   => $historyType,
            'tab'            => 'history'
        ]);

        // Load all APARs for dropdown in History modal
        $allApars = MasterApar::where('status', 'Aktif')->orderBy('kode_aset', 'asc')->get();
        $allVendors = \App\Models\FormApar\MasterVendor::orderBy('nama_vendor', 'asc')->get();
        
        $masterSigners = MasterSigner::orderBy('nama', 'asc')->get();

        return view('form-apar.index', compact(
            'forms', 'masterApars', 'nonActiveApars', 'masterVendors', 'aparHistories', 
            'allApars', 'allVendors', 'masterSigners', 'search',
            'historySearch', 'historyDate', 'historyType'
        ));
    }

    public function create()
    {
        $masterApars = MasterApar::where('status', 'Aktif')->orderBy('kode_aset', 'asc')->get();
        $masterSigners = MasterSigner::orderBy('nama', 'asc')->get();

        return view('form-apar.create', compact('masterApars', 'masterSigners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_ref'        => 'nullable|string|max:255',
            'tanggal'       => 'nullable|date',
            'business_area' => 'nullable|string|max:255',
            'bulan'         => 'nullable|string|max:100',
            'catatan'       => 'nullable|string',
            'petugas_name'  => 'nullable|string|max:255',
            'petugas_nipp'  => 'nullable|string|max:50',
            'mengetahui_id' => 'nullable|exists:master_signers,id',
            'mengetahui_2_id' => 'nullable|exists:master_signers,id',
            'items'         => 'nullable|array',
            'items.*.master_apar_id'      => 'nullable|exists:master_apars,id',
            'items.*.waktu_pengecekan_tgl'=> 'nullable|date',
            'items.*.waktu_pengecekan_jam'=> 'nullable|string|max:10',
            'items.*.indikator_tekanan'   => 'nullable|string|max:20',
            'items.*.perlakuan_fisik'     => 'nullable|string|max:255',
            'items.*.tindak_lanjut'       => 'nullable|string',
            'items.*.paraf'               => 'nullable|string|max:100',
        ]);

        $validItems = array_filter($request->items ?? [], function($i) {
            return !empty($i['master_apar_id']);
        });

        if (count($validItems) === 0) {
            return back()->withInput()->withErrors(['items' => 'Formulir harus memiliki minimal 1 (satu) item APAR yang valid.']);
        }

        DB::transaction(function () use ($validated) {
            $form = FormApar::create([
                'no_ref'        => $validated['no_ref'] ?? null,
                'tanggal'       => $validated['tanggal'] ?? null,
                'business_area' => $validated['business_area'] ?? null,
                'bulan'         => $validated['bulan'] ?? null,
                'catatan'       => $validated['catatan'] ?? null,
                'petugas_name'  => $validated['petugas_name'] ?? null,
                'petugas_nipp'  => $validated['petugas_nipp'] ?? null,
                'mengetahui_id' => $validated['mengetahui_id'] ?? null,
                'mengetahui_2_id' => $validated['mengetahui_2_id'] ?? null,
                'status'        => 'draft',
            ]);

            if (!empty($validated['items'])) {
                foreach ($validated['items'] as $itemData) {
                    if (empty($itemData['master_apar_id'])) {
                        continue;
                    }
                    FormAparItem::create([
                        'form_apar_id'         => $form->id,
                        'master_apar_id'       => $itemData['master_apar_id'],
                        'waktu_pengecekan_tgl' => $itemData['waktu_pengecekan_tgl'] ?? null,
                        'waktu_pengecekan_jam' => $itemData['waktu_pengecekan_jam'] ?? null,
                        'indikator_tekanan'    => $itemData['indikator_tekanan'] ?? null,
                        'perlakuan_fisik'      => $itemData['perlakuan_fisik'] ?? null,
                        'tindak_lanjut'        => $itemData['tindak_lanjut'] ?? null,
                        'paraf'                => $itemData['paraf'] ?? null,
                    ]);
                }
            }
        });

        return redirect()->route('form-apar.index')
                         ->with('success', 'Formulir pemantauan APAR berhasil dibuat.');
    }

    public function show(FormApar $form_apar)
    {
        $form_apar->load('items.apar', 'mengetahui', 'mengetahui2');
        return view('form-apar.show', compact('form_apar'));
    }

    public function edit(FormApar $form_apar)
    {
        $form_apar->load('items.apar', 'mengetahui', 'mengetahui2');
        
        $selectedAparIds = $form_apar->items->pluck('master_apar_id')->filter()->toArray();
        $masterApars = MasterApar::where('status', 'Aktif')
            ->orWhereIn('id', $selectedAparIds)
            ->orderBy('kode_aset', 'asc')
            ->get();

        $masterSigners = MasterSigner::orderBy('nama', 'asc')->get();

        return view('form-apar.edit', compact('form_apar', 'masterApars', 'masterSigners'));
    }

    public function update(Request $request, FormApar $form_apar)
    {
        $validated = $request->validate([
            'no_ref'        => 'nullable|string|max:255',
            'tanggal'       => 'nullable|date',
            'business_area' => 'nullable|string|max:255',
            'bulan'         => 'nullable|string|max:100',
            'catatan'       => 'nullable|string',
            'petugas_name'  => 'nullable|string|max:255',
            'petugas_nipp'  => 'nullable|string|max:50',
            'mengetahui_id' => 'nullable|exists:master_signers,id',
            'mengetahui_2_id' => 'nullable|exists:master_signers,id',
            'items'         => 'nullable|array',
            'items.*.master_apar_id'      => 'nullable|exists:master_apars,id',
            'items.*.waktu_pengecekan_tgl'=> 'nullable|date',
            'items.*.waktu_pengecekan_jam'=> 'nullable|string|max:10',
            'items.*.indikator_tekanan'   => 'nullable|string|max:20',
            'items.*.perlakuan_fisik'     => 'nullable|string|max:255',
            'items.*.tindak_lanjut'       => 'nullable|string',
            'items.*.paraf'               => 'nullable|string|max:100',
        ]);

        $validItems = array_filter($request->items ?? [], function($i) {
            return !empty($i['master_apar_id']);
        });

        if (count($validItems) === 0) {
            return back()->withInput()->withErrors(['items' => 'Formulir harus memiliki minimal 1 (satu) item APAR yang valid.']);
        }

        DB::transaction(function () use ($validated, $form_apar) {
            $form_apar->update([
                'no_ref'        => $validated['no_ref'] ?? null,
                'tanggal'       => $validated['tanggal'] ?? null,
                'business_area' => $validated['business_area'] ?? null,
                'bulan'         => $validated['bulan'] ?? null,
                'catatan'       => $validated['catatan'] ?? null,
                'petugas_name'  => $validated['petugas_name'] ?? null,
                'petugas_nipp'  => $validated['petugas_nipp'] ?? null,
                'mengetahui_id' => $validated['mengetahui_id'] ?? null,
                'mengetahui_2_id' => $validated['mengetahui_2_id'] ?? null,
            ]);

            $form_apar->items()->delete();

            if (!empty($validated['items'])) {
                foreach ($validated['items'] as $itemData) {
                    if (empty($itemData['master_apar_id'])) {
                        continue;
                    }
                    FormAparItem::create([
                        'form_apar_id'         => $form_apar->id,
                        'master_apar_id'       => $itemData['master_apar_id'],
                        'waktu_pengecekan_tgl' => $itemData['waktu_pengecekan_tgl'] ?? null,
                        'waktu_pengecekan_jam' => $itemData['waktu_pengecekan_jam'] ?? null,
                        'indikator_tekanan'    => $itemData['indikator_tekanan'] ?? null,
                        'perlakuan_fisik'      => $itemData['perlakuan_fisik'] ?? null,
                        'tindak_lanjut'        => $itemData['tindak_lanjut'] ?? null,
                        'paraf'                => $itemData['paraf'] ?? null,
                    ]);
                }
            }
        });

        return redirect()->route('form-apar.index')
                         ->with('success', 'Formulir pemantauan APAR berhasil diperbarui.');
    }

    public function destroy(FormApar $form_apar)
    {
        $form_apar->delete();

        return redirect()->route('form-apar.index')
                         ->with('success', 'Formulir pemantauan APAR berhasil dihapus.');
    }

    public function confirm(FormApar $form_apar)
    {
        if ($form_apar->isDicetak()) {
            $form_apar->update(['status' => 'selesai']);
        }

        return back()->with('success', 'Formulir berhasil dikonfirmasi sebagai selesai.');
    }
}
