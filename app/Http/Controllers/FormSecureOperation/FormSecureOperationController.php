<?php

namespace App\Http\Controllers\FormSecureOperation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormSecureOperation\SecureOperationIncident;
use App\Models\FormSecureOperation\MasterSignerSecure;
use App\Models\FormTemplate;

class FormSecureOperationController extends Controller
{
    public function index()
    {
        $incidents = SecureOperationIncident::latest()->get(); 
        $signers   = MasterSignerSecure::all();

        return view('form-secure-operation.index', compact('incidents', 'signers'));
    }

    public function create()
    {
        $masterSigners = MasterSignerSecure::all();
        
        // MENGAMBIL DATA KOP SURAT DARI MENU KATEGORI FORMULIR
        $kategoriForm = \App\Models\FormTemplate::where('nama', 'Secure Operation Incident')->first();
        // Mengirimkan variabel $kategoriForm ke halaman create (form.blade.php)
        return view('form-secure-operation.create', compact('masterSigners', 'kategoriForm'));
    }

    public function store(Request $request)
    {
        $mengetahui = MasterSignerSecure::updateOrCreate(
            ['nipp' => $request->mengetahui_nipp],
            [
                'nama' => $request->mengetahui_nama,
                'jabatan' => $request->mengetahui_jabatan
            ]
        );
        $request->merge(['mengetahui_id' => $mengetahui->id]);

        $pelaksana = MasterSignerSecure::updateOrCreate(
            ['nipp' => $request->pelaksana_nipp],
            [
                'nama' => $request->pelaksana_nama,
                'jabatan' => $request->pelaksana_jabatan
            ]
        );
        $request->merge(['pelaksana_id' => $pelaksana->id]);

        if ($request->filled('tanggal_ref')) {
            $request->merge(['tanggal_ref' => date('Y-m-d', strtotime($request->tanggal_ref))]);
        }
        if ($request->filled('tanggal_checklist')) {
            $request->merge(['tanggal_checklist' => date('Y-m-d', strtotime($request->tanggal_checklist))]);
        }
        if ($request->filled('tanggal_ttd')) {
            $request->merge(['tanggal_ttd' => date('Y-m-d', strtotime($request->tanggal_ttd))]);
        }
        
        $validated = $request->validate([
            'no_ref' => 'nullable|string|max:255',
            'tanggal_ref' => 'nullable|date',
            'business_area' => 'nullable|string|max:255',
            'nama_aplikasi' => 'required|string|max:255',
            'tanggal_checklist' => 'required|date',
            'deskripsi' => 'required|string',
            'versi_aplikasi' => 'required|string|max:255',
            'modul' => 'required|string|max:255',
            'fungsi' => 'required|string|max:1000',
            'incident_high_dilaporkan' => 'required|in:Ya,Tidak',
            'incident_masuk_tiket' => 'required|in:Ya,Tidak',
            'incident_tiket_closed' => 'required|in:Ya,Tidak',
            'va_dilakukan' => 'required|in:Ya,Tidak',
            'jadwal_pentest' => 'required|in:Ya,Toggle,Tidak',
            'mengetahui_id' => 'required|exists:master_signer_secure_operations,id',
            'pelaksana_id' => 'required|exists:master_signer_secure_operations,id',
            'tempat_ttd' => 'nullable|string|max:255',
            'tanggal_ttd' => 'required|date',
        ]);

        SecureOperationIncident::create($validated);

        return redirect()->route('form-secure-operation.index')->with('success', 'Formulir Incident berhasil dibuat!');
    }

    public function show($id)
    {
        $form = SecureOperationIncident::with(['mengetahui', 'pelaksana'])->find($id);
        
        if (!$form) {
            return redirect()->route('form-secure-operation.index')->with('error', 'Data Formulir tidak ditemukan!');
        }

        // MENGAMBIL DATA KOP SURAT DARI MENU KATEGORI FORMULIR
        $kategoriForm = \App\Models\FormTemplate::where('nama', 'Secure Operation Incident')->first();

        return view('form-secure-operation.show', compact('form', 'kategoriForm'));
    }

    public function edit($id)
    {
        $form = SecureOperationIncident::find($id);
        
        if (!$form) {
            return redirect()->route('form-secure-operation.index')->with('error', 'Data Formulir tidak ditemukan!');
        }

        $masterSigners = MasterSignerSecure::all();
        
        // MENGAMBIL DATA KOP SURAT DARI MENU KATEGORI FORMULIR
        $kategoriForm = \App\Models\FormTemplate::where('nama', 'Secure Operation Incident')->first();       

        return view('form-secure-operation.edit', compact('form', 'masterSigners', 'kategoriForm'));
    }

    public function update(Request $request, $id)
    {
        $incident = SecureOperationIncident::find($id);

        if (!$incident) {
            return redirect()->route('form-secure-operation.index')->with('error', 'Data Formulir tidak ditemukan!');
        }

        $mengetahui = MasterSignerSecure::updateOrCreate(
            ['nipp' => $request->mengetahui_nipp],
            [
                'nama' => $request->mengetahui_nama,
                'jabatan' => $request->mengetahui_jabatan
            ]
        );
        $request->merge(['mengetahui_id' => $mengetahui->id]);

        $pelaksana = MasterSignerSecure::updateOrCreate(
            ['nipp' => $request->pelaksana_nipp],
            [
                'nama' => $request->pelaksana_nama,
                'jabatan' => $request->pelaksana_jabatan
            ]
        );
        $request->merge(['pelaksana_id' => $pelaksana->id]);

        if ($request->filled('tanggal_ref')) {
            $request->merge(['tanggal_ref' => date('Y-m-d', strtotime($request->tanggal_ref))]);
        }
        if ($request->filled('tanggal_checklist')) {
            $request->merge(['tanggal_checklist' => date('Y-m-d', strtotime($request->tanggal_checklist))]);
        }
        if ($request->filled('tanggal_ttd')) {
            $request->merge(['tanggal_ttd' => date('Y-m-d', strtotime($request->tanggal_ttd))]);
        }

        $validated = $request->validate([
            'no_ref' => 'nullable|string|max:255',
            'tanggal_ref' => 'nullable|date',
            'business_area' => 'nullable|string|max:255',
            'nama_aplikasi' => 'required|string|max:255',
            'tanggal_checklist' => 'required|date',
            'deskripsi' => 'required|string',
            'versi_aplikasi' => 'required|string|max:255',
            'modul' => 'required|string|max:255',
            'fungsi' => 'required|string|max:255',
            'incident_high_dilaporkan' => 'required|in:Ya,Tidak',
            'incident_masuk_tiket' => 'required|in:Ya,Tidak',
            'incident_tiket_closed' => 'required|in:Ya,Tidak',
            'va_dilakukan' => 'required|in:Ya,Tidak',
            'jadwal_pentest' => 'required|in:Ya,Toggle,Tidak',
            'mengetahui_id' => 'required|exists:master_signer_secure_operations,id',
            'pelaksana_id' => 'required|exists:master_signer_secure_operations,id',
            'tempat_ttd' => 'nullable|string|max:255',
            'tanggal_ttd' => 'required|date',
        ]);

        $incident->update($validated);

        return redirect()->route('form-secure-operation.index')->with('success', 'Formulir Incident berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $incident = SecureOperationIncident::find($id);

        if (!$incident) {
            return redirect()->route('form-secure-operation.index')->with('error', 'Data Formulir tidak ditemukan!');
        }

        $incident->delete();

        return redirect()->route('form-secure-operation.index')->with('success', 'Formulir berhasil dihapus!');
    }
}