<?php

namespace App\Http\Controllers\FormPemeliharaan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\FormPemeliharaan\FormPemeliharaan;
use App\Models\FormPemeliharaan\FormPemeliharaanItem;
use App\Models\FormPemeliharaan\MasterPerangkat;
use App\Models\FormCctv\MasterSigner;

class FormPemeliharaanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $forms = FormPemeliharaan::when($search, function ($query, $search) {
            return $query->where('no_ref', 'like', "%{$search}%")
                         ->orWhere('lokasi', 'like', "%{$search}%")
                         ->orWhere('bulan_pemeliharaan', 'like', "%{$search}%");
        })->orderBy('created_at', 'desc')->paginate(5, ['*'], 'form_page');

        $forms->appends(['search' => $search]);

        $masterPerangkats = MasterPerangkat::orderBy('kode_aset', 'asc')->paginate(5, ['*'], 'perangkat_page');
        $masterSigners    = MasterSigner::orderBy('nama', 'asc')->get();

        return view('form-pemeliharaan.index', compact('forms', 'masterPerangkats', 'masterSigners', 'search'));
    }

    public function create()
    {
        $masterPerangkats = MasterPerangkat::orderBy('kode_aset', 'asc')->get();
        $masterSigners    = MasterSigner::orderBy('nama', 'asc')->get();

        return view('form-pemeliharaan.create', compact('masterPerangkats', 'masterSigners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_ref'             => 'nullable|string|max:255',
            'tanggal'            => 'nullable|date',
            'business_area'      => 'nullable|string|max:255',
            'lokasi'             => 'nullable|string|max:255',
            'jenis_pemeliharaan' => 'nullable|in:Terencana,Tak Terencana',
            'bulan_pemeliharaan' => 'nullable|string|max:100',
            'catatan'            => 'nullable|string',
            'petugas_name'       => 'nullable|string|max:255',
            'petugas_nipp'       => 'nullable|string|max:50',
            'mengetahui_id'      => 'nullable|exists:master_signers,id',
            'items'              => 'nullable|array',
            'items.*.master_perangkat_id' => 'nullable|exists:master_perangkats,id',
            'items.*.deskripsi'           => 'nullable|string|max:500',
            'items.*.pekerjaan'           => 'nullable|string|max:500',
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
                'petugas_name'       => $validated['petugas_name'] ?? null,
                'petugas_nipp'       => $validated['petugas_nipp'] ?? null,
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
        $form_pemeliharaan->load('items.perangkat', 'mengetahui');
        return view('form-pemeliharaan.show', compact('form_pemeliharaan'));
    }

    public function edit(FormPemeliharaan $form_pemeliharaan)
    {
        $form_pemeliharaan->load('items.perangkat', 'mengetahui');
        $masterPerangkats = MasterPerangkat::orderBy('kode_aset', 'asc')->get();
        $masterSigners    = MasterSigner::orderBy('nama', 'asc')->get();

        return view('form-pemeliharaan.edit', compact('form_pemeliharaan', 'masterPerangkats', 'masterSigners'));
    }

    public function update(Request $request, FormPemeliharaan $form_pemeliharaan)
    {
        $validated = $request->validate([
            'no_ref'             => 'nullable|string|max:255',
            'tanggal'            => 'nullable|date',
            'business_area'      => 'nullable|string|max:255',
            'lokasi'             => 'nullable|string|max:255',
            'jenis_pemeliharaan' => 'nullable|in:Terencana,Tak Terencana',
            'bulan_pemeliharaan' => 'nullable|string|max:100',
            'catatan'            => 'nullable|string',
            'petugas_name'       => 'nullable|string|max:255',
            'petugas_nipp'       => 'nullable|string|max:50',
            'mengetahui_id'      => 'nullable|exists:master_signers,id',
            'items'              => 'nullable|array',
            'items.*.master_perangkat_id' => 'nullable|exists:master_perangkats,id',
            'items.*.deskripsi'           => 'nullable|string|max:500',
            'items.*.pekerjaan'           => 'nullable|string|max:500',
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

        DB::transaction(function () use ($validated, $form_pemeliharaan) {
            $form_pemeliharaan->update([
                'no_ref'             => $validated['no_ref'] ?? null,
                'tanggal'            => $validated['tanggal'] ?? null,
                'business_area'      => $validated['business_area'] ?? null,
                'lokasi'             => $validated['lokasi'] ?? null,
                'jenis_pemeliharaan' => $validated['jenis_pemeliharaan'] ?? null,
                'bulan_pemeliharaan' => $validated['bulan_pemeliharaan'] ?? null,
                'catatan'            => $validated['catatan'] ?? null,
                'petugas_name'       => $validated['petugas_name'] ?? null,
                'petugas_nipp'       => $validated['petugas_nipp'] ?? null,
                'mengetahui_id'      => $validated['mengetahui_id'] ?? null,
            ]);

            $form_pemeliharaan->items()->delete();

            if (!empty($validated['items'])) {
                foreach ($validated['items'] as $itemData) {
                    if (empty($itemData['master_perangkat_id']) && empty($itemData['pekerjaan'])) {
                        continue;
                    }
                    FormPemeliharaanItem::create([
                        'form_pemeliharaan_id' => $form_pemeliharaan->id,
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
                         ->with('success', 'Formulir pemeliharaan berhasil diperbarui.');
    }

    public function destroy(FormPemeliharaan $form_pemeliharaan)
    {
        $form_pemeliharaan->delete();

        return redirect()->route('form-pemeliharaan.index')
                         ->with('success', 'Formulir pemeliharaan berhasil dihapus.');
    }



    public function confirm(FormPemeliharaan $form_pemeliharaan)
    {
        if ($form_pemeliharaan->isDicetak()) {
            $form_pemeliharaan->update(['status' => 'selesai']);
        }

        return back()->with('success', 'Formulir berhasil dikonfirmasi sebagai selesai.');
    }
}
