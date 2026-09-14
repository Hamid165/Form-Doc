<?php

namespace App\Http\Controllers\FormPemeliharaan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\FormPemeliharaan\FormPemeliharaan;
use App\Models\FormPemeliharaan\FormPemeliharaanItem;
use App\Models\FormPemeliharaan\MasterPerangkat;
use App\Models\FormPemeliharaan\MasterSigner;

class FormPemeliharaanController extends Controller
{
    public function index(Request $request)
    {
        $search_forms     = $request->query('search_forms', $request->query('search')); // fallback for backward compat
        $search_perangkat = $request->query('search_perangkat');
        $search_petugas   = $request->query('search_petugas');
        $search_signer    = $request->query('search_signer');

        $forms = FormPemeliharaan::when($search_forms, function ($query, $search) {
            return $query->where('no_ref', 'like', "%{$search}%")
                         ->orWhere('lokasi', 'like', "%{$search}%")
                         ->orWhere('bulan_pemeliharaan', 'like', "%{$search}%");
        })->orderBy('created_at', 'desc')->paginate(5, ['*'], 'form_page');

        $forms->appends(['search_forms' => $search_forms]);

        $masterPerangkats = MasterPerangkat::when($search_perangkat, function ($query, $search) {
            return $query->where('kode_aset', 'like', "%{$search}%")
                         ->orWhere('jenis_perangkat', 'like', "%{$search}%");
        })->orderBy('kode_aset', 'asc')->paginate(5, ['*'], 'perangkat_page');
        $masterPerangkats->appends(['search_perangkat' => $search_perangkat]);

        $masterPetugas = \App\Models\FormPemeliharaan\MasterPetugas::when($search_petugas, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%")
                         ->orWhere('nipp', 'like', "%{$search}%");
        })->orderBy('nama', 'asc')->paginate(5, ['*'], 'petugas_page');
        $masterPetugas->appends(['search_petugas' => $search_petugas]);

        $masterSigners = MasterSigner::when($search_signer, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%")
                         ->orWhere('nipp', 'like', "%{$search}%")
                         ->orWhere('jabatan', 'like', "%{$search}%");
        })->orderBy('nama', 'asc')->paginate(5, ['*'], 'signer_page');
        $masterSigners->appends(['search_signer' => $search_signer]);

        return view('form-pemeliharaan.index', compact('forms', 'masterPerangkats', 'masterPetugas', 'masterSigners', 'search_forms', 'search_perangkat', 'search_petugas', 'search_signer'));
    }

    public function create()
    {
        $masterPerangkats = MasterPerangkat::orderBy('kode_aset', 'asc')->get();
        $masterPetugas    = \App\Models\FormPemeliharaan\MasterPetugas::orderBy('nama', 'asc')->get();
        $masterSigners    = MasterSigner::orderBy('nama', 'asc')->get();

        return view('form-pemeliharaan.create', compact('masterPerangkats', 'masterPetugas', 'masterSigners'));
    }

    public function store(Request $request)
    {
        $this->parseTanggal($request);

        $validated = $request->validate([
            'no_ref'             => 'required|string|max:255',
            'tanggal'            => 'required|date',
            'business_area'      => 'required|string|max:255',
            'lokasi'             => 'required|string|max:255',
            'jenis_pemeliharaan' => 'required|in:Terencana,Tak Terencana',
            'bulan_pemeliharaan' => 'required|string|max:100',
            'catatan'            => 'nullable|string',
            'petugas_id'         => 'required|exists:master_petugas,id',
            'mengetahui_id'      => 'required|exists:master_signers,id',
            'items'              => 'nullable|array',
            'items.*.master_perangkat_id' => 'nullable|exists:master_perangkats,id',
            'items.*.deskripsi'           => 'required|string|max:500',
            'items.*.pekerjaan'           => 'required|string|max:500',
            'items.*.permasalahan'        => 'nullable|string',
            'items.*.solusi'              => 'nullable|string',
            'items.*.keterangan'          => 'nullable|string',
        ]);

        $validItems = array_filter($request->items ?? [], function($i) {
            return !empty($i['master_perangkat_id']);
        });

        if (count($validItems) === 0) {
            return back()->withInput()->withErrors(['items' => 'Formulir harus memiliki minimal 1 (satu) item perangkat pemeliharaan yang valid.']);
        }

        DB::transaction(function () use ($validated) {
            $form = FormPemeliharaan::create([
                'no_ref'             => $validated['no_ref'] ?? null,
                'tanggal'            => $validated['tanggal'] ?? null,
                'business_area'      => $validated['business_area'] ?? null,
                'lokasi'             => $validated['lokasi'] ?? null,
                'jenis_pemeliharaan' => $validated['jenis_pemeliharaan'] ?? null,
                'bulan_pemeliharaan' => $validated['bulan_pemeliharaan'] ?? null,
                'catatan'            => $validated['catatan'] ?? null,
                'petugas_id'         => $validated['petugas_id'] ?? null,
                'mengetahui_id'      => $validated['mengetahui_id'] ?? null,
                'status'             => 'draft',
            ]);

            if (!empty($validated['items'])) {
                foreach ($validated['items'] as $itemData) {
                    if (empty($itemData['master_perangkat_id']) && empty($itemData['pekerjaan'])) {
                        continue;
                    }
                    FormPemeliharaanItem::create([
                        'form_pemeliharaan_id' => $form->id,
                        'master_perangkat_id'  => $itemData['master_perangkat_id'] ?? null,
                        'deskripsi'            => $itemData['deskripsi'] ?? null,
                        'pekerjaan'            => $itemData['pekerjaan'] ?? null,
                        'permasalahan'         => $itemData['permasalahan'] ?? null,
                        'solusi'               => $itemData['solusi'] ?? null,
                        'keterangan'           => $itemData['keterangan'] ?? null,
                    ]);
                }
            }
        });

        return redirect()->route('form-pemeliharaan.index')
                         ->with('success', 'Formulir pemeliharaan berhasil dibuat.');
    }

    public function show(FormPemeliharaan $form_pemeliharaan)
    {
        $form_pemeliharaan->load('items.perangkat', 'petugas', 'mengetahui');
        $template = \App\Models\FormTemplate::where('nama', 'Checklist Pemeliharaan Perangkat Jaringan')->first();
        return view('form-pemeliharaan.show', compact('form_pemeliharaan', 'template'));
    }

    public function edit(FormPemeliharaan $form_pemeliharaan)
    {
        if ($form_pemeliharaan->isSelesai()) {
            return back()->with('error', 'Formulir yang sudah selesai tidak dapat diubah.');
        }

        $form_pemeliharaan->load('items.perangkat', 'petugas', 'mengetahui');
        $masterPerangkats = MasterPerangkat::orderBy('kode_aset', 'asc')->get();
        $masterPetugas    = \App\Models\FormPemeliharaan\MasterPetugas::orderBy('nama', 'asc')->get();
        $masterSigners    = MasterSigner::orderBy('nama', 'asc')->get();

        return view('form-pemeliharaan.edit', compact('form_pemeliharaan', 'masterPerangkats', 'masterPetugas', 'masterSigners'));
    }

    public function update(Request $request, FormPemeliharaan $form_pemeliharaan)
    {
        if ($form_pemeliharaan->isSelesai()) {
            return back()->with('error', 'Formulir yang sudah selesai tidak dapat diubah.');
        }

        $this->parseTanggal($request);

        $validated = $request->validate([
            'no_ref'             => 'required|string|max:255',
            'tanggal'            => 'required|date',
            'business_area'      => 'required|string|max:255',
            'lokasi'             => 'required|string|max:255',
            'jenis_pemeliharaan' => 'required|in:Terencana,Tak Terencana',
            'bulan_pemeliharaan' => 'required|string|max:100',
            'catatan'            => 'nullable|string',
            'petugas_id'         => 'required|exists:master_petugas,id',
            'mengetahui_id'      => 'required|exists:master_signers,id',
            'items'              => 'nullable|array',
            'items.*.id'                  => 'nullable|exists:form_pemeliharaan_items,id',
            'items.*.master_perangkat_id' => 'nullable|exists:master_perangkats,id',
            'items.*.deskripsi'           => 'required|string|max:500',
            'items.*.pekerjaan'           => 'required|string|max:500',
            'items.*.permasalahan'        => 'nullable|string',
            'items.*.solusi'              => 'nullable|string',
            'items.*.keterangan'          => 'nullable|string',
        ]);

        $validItems = array_filter($request->items ?? [], function($i) {
            return !empty($i['master_perangkat_id']);
        });

        if (count($validItems) === 0) {
            return back()->withInput()->withErrors(['items' => 'Formulir harus memiliki minimal 1 (satu) item perangkat pemeliharaan yang valid.']);
        }

        DB::transaction(function () use ($validated, $form_pemeliharaan, $request) {
            $form_pemeliharaan->update([
                'no_ref'             => $validated['no_ref'] ?? null,
                'tanggal'            => $validated['tanggal'] ?? null,
                'business_area'      => $validated['business_area'] ?? null,
                'lokasi'             => $validated['lokasi'] ?? null,
                'jenis_pemeliharaan' => $validated['jenis_pemeliharaan'] ?? null,
                'bulan_pemeliharaan' => $validated['bulan_pemeliharaan'] ?? null,
                'catatan'            => $validated['catatan'] ?? null,
                'petugas_id'         => $validated['petugas_id'] ?? null,
                'mengetahui_id'      => $validated['mengetahui_id'] ?? null,
            ]);

            $submittedIds = [];

            if (!empty($validated['items'])) {
                foreach ($validated['items'] as $itemData) {
                    if (empty($itemData['master_perangkat_id']) && empty($itemData['pekerjaan'])) {
                        continue;
                    }
                    
                    if (!empty($itemData['id'])) {
                        // Update existing item
                        $item = FormPemeliharaanItem::find($itemData['id']);
                        if ($item && $item->form_pemeliharaan_id == $form_pemeliharaan->id) {
                            $item->update([
                                'master_perangkat_id'  => $itemData['master_perangkat_id'] ?? null,
                                'deskripsi'            => $itemData['deskripsi'] ?? null,
                                'pekerjaan'            => $itemData['pekerjaan'] ?? null,
                                'permasalahan'         => $itemData['permasalahan'] ?? null,
                                'solusi'               => $itemData['solusi'] ?? null,
                                'keterangan'           => $itemData['keterangan'] ?? null,
                            ]);
                            $submittedIds[] = $item->id;
                        }
                    } else {
                        // Create new item
                        $newItem = FormPemeliharaanItem::create([
                            'form_pemeliharaan_id' => $form_pemeliharaan->id,
                            'master_perangkat_id'  => $itemData['master_perangkat_id'] ?? null,
                            'deskripsi'            => $itemData['deskripsi'] ?? null,
                            'pekerjaan'            => $itemData['pekerjaan'] ?? null,
                            'permasalahan'         => $itemData['permasalahan'] ?? null,
                            'solusi'               => $itemData['solusi'] ?? null,
                            'keterangan'           => $itemData['keterangan'] ?? null,
                        ]);
                        $submittedIds[] = $newItem->id;
                    }
                }
            }

            // Delete removed items
            $form_pemeliharaan->items()->whereNotIn('id', $submittedIds)->delete();
            
            if ($request->input('action') === 'konfirmasi_selesai') {
                $form_pemeliharaan->update(['status' => 'selesai']);
            }
        });
        
        $msg = $request->input('action') === 'konfirmasi_selesai' 
            ? 'Formulir berhasil diperbarui dan dikonfirmasi Selesai.' 
            : 'Formulir pemeliharaan berhasil diperbarui.';

        return redirect()->route('form-pemeliharaan.index')
                         ->with('success', $msg);
    }

    public function destroy(FormPemeliharaan $form_pemeliharaan)
    {
        if ($form_pemeliharaan->isSelesai()) {
            return back()->with('error', 'Formulir yang sudah selesai tidak dapat dihapus.');
        }

        $form_pemeliharaan->delete();

        return redirect()->route('form-pemeliharaan.index')
                         ->with('success', 'Formulir pemeliharaan berhasil dihapus.');
    }



    public function markDicetak(FormPemeliharaan $form_pemeliharaan)
    {
        if ($form_pemeliharaan->isDraft()) {
            $form_pemeliharaan->update(['status' => 'dicetak']);
        }
        return redirect()->route('form-pemeliharaan.show', $form_pemeliharaan)->with('auto_print', true);
    }

    public function confirm(FormPemeliharaan $form_pemeliharaan)
    {
        if ($form_pemeliharaan->isDicetak()) {
            $form_pemeliharaan->update(['status' => 'selesai']);
        }

        return back()->with('success', 'Formulir berhasil dikonfirmasi sebagai selesai.');
    }

    private function parseTanggal(Request $request)
    {
        $rawTanggalOriginal = $request->input('tanggal');
        if ($rawTanggalOriginal) {
            try {
                $rawTanggal = strtolower(trim(str_replace('-', ' ', $rawTanggalOriginal)));
                if (strpos($rawTanggalOriginal, '/') !== false) {
                    $parts = explode('/', $rawTanggalOriginal);
                    if (count($parts) == 3) {
                        $request->merge(['tanggal' => "{$parts[2]}-{$parts[1]}-{$parts[0]}"]);
                        return;
                    }
                }
                
                $parts = explode(' ', $rawTanggal);
                if (count($parts) >= 3) {
                    $day = str_pad($parts[0], 2, '0', STR_PAD_LEFT);
                    $month = $parts[1];
                    $year = $parts[2];
                    $monthMap = [
                        'januari' => '01', 'jan' => '01',
                        'februari' => '02', 'feb' => '02',
                        'maret' => '03', 'mar' => '03',
                        'april' => '04', 'apr' => '04',
                        'mei' => '05',
                        'juni' => '06', 'jun' => '06',
                        'juli' => '07', 'jul' => '07',
                        'agustus' => '08', 'agu' => '08',
                        'september' => '09', 'sep' => '09',
                        'oktober' => '10', 'okt' => '10',
                        'november' => '11', 'nov' => '11',
                        'desember' => '12', 'des' => '12',
                    ];
                    foreach ($monthMap as $ind => $num) {
                        if (str_starts_with($month, $ind)) {
                            $month = $num;
                            break;
                        }
                    }
                    $request->merge(['tanggal' => "$year-$month-$day"]);
                } else {
                    $request->merge(['tanggal' => \Carbon\Carbon::parse($rawTanggalOriginal)->format('Y-m-d')]);
                }
            } catch (\Exception $e) {
                // Biarkan validasi Laravel yang menangkap error jika tanggal gagal diparsing
                $request->merge(['tanggal' => $rawTanggalOriginal]);
            }
        }
    }
}
