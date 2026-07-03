<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormRevocation;
use App\Models\FormRevocationItem;

class FormRevocationController extends Controller
{
    public function index()
    {
        $forms = FormRevocation::orderBy('created_at', 'desc')->get();
        return view('form-revocation.index', compact('forms'));
    }

    public function create()
    {
        return view('form-revocation.create-v2');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no_ref' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'business_area' => 'nullable|string|max:255',
            'tanggal_permohonan' => 'nullable|date',
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
        ]);

        $form = FormRevocation::create([
            'no_ref' => $validatedData['no_ref'] ?? null,
            'tanggal' => $validatedData['tanggal'] ?? null,
            'business_area' => $validatedData['business_area'] ?? null,
            'tanggal_permohonan' => $validatedData['tanggal_permohonan'] ?? null,
            'nama_pemohon' => $validatedData['nama_pemohon'] ?? null,
            'nip_pemohon' => $validatedData['nip_pemohon'] ?? null,
            'bagian_fungsi' => $validatedData['bagian_fungsi'] ?? null,
            'kota_tanggal_pemohon' => $validatedData['kota_tanggal_pemohon'] ?? null,
            'status_persetujuan' => $validatedData['status_persetujuan'] ?? 'DISETUJUI',
            'kota_tanggal_setuju' => $validatedData['kota_tanggal_setuju'] ?? null,
            'jabatan_mengetahui' => $validatedData['jabatan_mengetahui'] ?? null,
            'mengetahui_nama' => $validatedData['mengetahui_nama'] ?? null,
        ]);

        if (isset($validatedData['items']) && is_array($validatedData['items'])) {
            foreach ($validatedData['items'] as $index => $itemData) {
                $no = $index;
                FormRevocationItem::create([
                    'form_revocation_id' => $form->id,
                    'no' => $no,
                    'nama_pengguna' => $itemData['nama_pengguna'] ?? null,
                    'jenis_akun' => $itemData['jenis_akun'] ?? null,
                    'unit_kerja' => $itemData['unit_kerja'] ?? null,
                    'alasan' => $itemData['alasan'] ?? null,
                ]);
            }
        }

        return redirect()->route('form-revocation.index')->with('success', "Formulir Pencabutan Hak Akses Berhasil Ditambahkan.");
    }

    public function show(string $id)
    {
        $form = FormRevocation::with('items')->findOrFail($id);
        return view('form-revocation.show', compact('form'));
    }

    public function edit(string $id)
    {
        $form = FormRevocation::with('items')->findOrFail($id);
        
        $items = [];
        foreach ($form->items as $item) {
            $items[$item->no - 1] = $item;
        }
        
        return view('form-revocation.edit', compact('form', 'items'));
    }

    public function update(Request $request, string $id)
    {
        $form = FormRevocation::findOrFail($id);
        
        $validatedData = $request->validate([
            'no_ref' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'business_area' => 'nullable|string|max:255',
            'tanggal_permohonan' => 'nullable|date',
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
        ]);

        $form->update([
            'no_ref' => $validatedData['no_ref'] ?? null,
            'tanggal' => $validatedData['tanggal'] ?? null,
            'business_area' => $validatedData['business_area'] ?? null,
            'tanggal_permohonan' => $validatedData['tanggal_permohonan'] ?? null,
            'nama_pemohon' => $validatedData['nama_pemohon'] ?? null,
            'nip_pemohon' => $validatedData['nip_pemohon'] ?? null,
            'bagian_fungsi' => $validatedData['bagian_fungsi'] ?? null,
            'kota_tanggal_pemohon' => $validatedData['kota_tanggal_pemohon'] ?? null,
            'status_persetujuan' => $validatedData['status_persetujuan'] ?? 'DISETUJUI',
            'kota_tanggal_setuju' => $validatedData['kota_tanggal_setuju'] ?? null,
            'jabatan_mengetahui' => $validatedData['jabatan_mengetahui'] ?? null,
            'mengetahui_nama' => $validatedData['mengetahui_nama'] ?? null,
        ]);
        
        $form->items()->delete();

        if (isset($validatedData['items']) && is_array($validatedData['items'])) {
            foreach ($validatedData['items'] as $index => $itemData) {
                $no = $index;
                FormRevocationItem::create([
                    'form_revocation_id' => $form->id,
                    'no' => $no,
                    'nama_pengguna' => $itemData['nama_pengguna'] ?? null,
                    'jenis_akun' => $itemData['jenis_akun'] ?? null,
                    'unit_kerja' => $itemData['unit_kerja'] ?? null,
                    'alasan' => $itemData['alasan'] ?? null,
                ]);
            }
        }

        return redirect()->route('form-revocation.index')->with('success', "Formulir Pencabutan Hak Akses Berhasil Diperbarui.");
    }

    public function destroy(string $id)
    {
        $form = FormRevocation::findOrFail($id);
        $form->delete();
        
        return redirect()->route('form-revocation.index')->with('success', "Formulir Pencabutan Hak Akses Berhasil Dihapus.");
    }
}
