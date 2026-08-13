<?php

namespace App\Http\Controllers\FormItBusinessRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormItBusinessRequest\FormItBusinessRequest;

class FormItBusinessRequestController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        
        $forms = FormItBusinessRequest::when($search, function ($query, $search) {
            return $query->where('no_ref', 'like', "%{$search}%")
                         ->orWhere('deskripsi_umum', 'like', "%{$search}%");
        })->orderBy('created_at', 'desc')->paginate(10);
        
        $forms->appends(['search' => $search]);
        
        return view('form-it-business-request.index', compact('forms', 'search'));
    }

    public function create()
    {
        $formTemplate = \App\Models\FormTemplate::where('nama', 'Formulir IT Business Request')->first();
        return view('form-it-business-request.create', compact('formTemplate'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no_ref' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'jabatan' => 'nullable|string|max:255',
            'klasifikasi_permintaan' => 'nullable|string|max:255',
            'catatan_persetujuan' => 'nullable|string|max:255',
            'catatan_kondisi' => 'nullable|string',
            'distribusi_salinan' => 'nullable|string|max:255',
            'deskripsi_umum' => 'nullable|string',
            'latar_belakang' => 'nullable|string',
            'tujuan' => 'nullable|string',
            'target_waktu' => 'nullable|string',
            'pihak_terkait_internal' => 'nullable|string',
            'kategori_layanan' => 'nullable|array',
            'layanan_yang_dibutuhkan' => 'nullable|string',
            'pemohon_nama' => 'nullable|string|max:255',
            'pemohon_nipp' => 'nullable|string|max:255',
            'pemohon_jabatan' => 'nullable|string|max:255',
            'penerima_nama' => 'nullable|string|max:255',
            'penerima_nipp' => 'nullable|string|max:255',
            'penerima_jabatan' => 'nullable|string|max:255',
            'pimpinan_nama' => 'nullable|string|max:255',
            'pimpinan_nipp' => 'nullable|string|max:255',
            'pimpinan_jabatan' => 'nullable|string|max:255',
            'vp_nama' => 'nullable|string|max:255',
            'vp_nipp' => 'nullable|string|max:255',
            'vp_jabatan' => 'nullable|string|max:255',
        ]);

        $form = FormItBusinessRequest::create($validatedData);

        return redirect()->route('form-it-business-request.index')->with('success', "Formulir Berhasil Ditambahkan.");
    }

    public function show(string $id)
    {
        $form = FormItBusinessRequest::findOrFail($id);
        $formTemplate = \App\Models\FormTemplate::where('nama', 'Formulir IT Business Request')->first();
        return view('form-it-business-request.show', compact('form', 'formTemplate'));
    }

    public function edit(string $id)
    {
        $form = FormItBusinessRequest::findOrFail($id);
        $formTemplate = \App\Models\FormTemplate::where('nama', 'Formulir IT Business Request')->first();
        return view('form-it-business-request.edit', compact('form', 'formTemplate'));
    }

    public function update(Request $request, string $id)
    {
        $form = FormItBusinessRequest::findOrFail($id);
        
        $validatedData = $request->validate([
            'no_ref' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'jabatan' => 'nullable|string|max:255',
            'klasifikasi_permintaan' => 'nullable|string|max:255',
            'catatan_persetujuan' => 'nullable|string|max:255',
            'catatan_kondisi' => 'nullable|string',
            'distribusi_salinan' => 'nullable|string|max:255',
            'deskripsi_umum' => 'nullable|string',
            'latar_belakang' => 'nullable|string',
            'tujuan' => 'nullable|string',
            'target_waktu' => 'nullable|string',
            'pihak_terkait_internal' => 'nullable|string',
            'kategori_layanan' => 'nullable|array',
            'layanan_yang_dibutuhkan' => 'nullable|string',
            'pemohon_nama' => 'nullable|string|max:255',
            'pemohon_nipp' => 'nullable|string|max:255',
            'pemohon_jabatan' => 'nullable|string|max:255',
            'penerima_nama' => 'nullable|string|max:255',
            'penerima_nipp' => 'nullable|string|max:255',
            'penerima_jabatan' => 'nullable|string|max:255',
            'pimpinan_nama' => 'nullable|string|max:255',
            'pimpinan_nipp' => 'nullable|string|max:255',
            'pimpinan_jabatan' => 'nullable|string|max:255',
            'vp_nama' => 'nullable|string|max:255',
            'vp_nipp' => 'nullable|string|max:255',
            'vp_jabatan' => 'nullable|string|max:255',
        ]);

        $form->update($validatedData);

        return redirect()->route('form-it-business-request.index')->with('success', "Formulir Berhasil Diperbarui.");
    }

    public function destroy(string $id)
    {
        $form = FormItBusinessRequest::findOrFail($id);
        $form->delete();
        
        return redirect()->route('form-it-business-request.index')->with('success', "Formulir Berhasil Dihapus.");
    }
}
