<?php

namespace App\Http\Controllers\FormLogPeminjaman;

use App\Http\Controllers\Controller;
use App\Models\FormLogPeminjaman\FormLogPeminjaman;
use App\Models\FormTemplate;
use App\Exports\FormLogPeminjaman\FormLogPeminjamanExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FormLogPeminjamanController extends Controller
{
    public function index()
    {
        $forms = FormLogPeminjaman::latest()->paginate(10);
        return view('form-log-peminjaman.index', compact('forms'));
    }

    public function create()
    {
        $template = FormTemplate::where('nama', 'Log Peminjaman Informasi / Dokumen')->first();
        $form = new FormLogPeminjaman();
        return view('form-log-peminjaman.create', compact('template', 'form'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_ref' => 'required',
            'tanggal_ref' => 'required',
            'business_area' => 'required',
            'items' => 'array'
        ]);

        $form = FormLogPeminjaman::create([
            'no_ref' => $request->no_ref,
            'tanggal_ref' => Carbon::parse($request->tanggal_ref)->format('Y-m-d'),
            'business_area' => $request->business_area,
        ]);

        if ($request->has('items')) {
            foreach ($request->items as $item) {
                $form->details()->create($item);
            }
        }

        return redirect()->route('form-log-peminjaman.index')->with('success', 'Formulir berhasil disimpan');
    }

    public function show($id)
    {
        $form = FormLogPeminjaman::with('details')->findOrFail($id);
        $template = FormTemplate::where('nama', 'Log Peminjaman Informasi / Dokumen')->first();
        return view('form-log-peminjaman.show', compact('form', 'template'));
    }

    public function edit($id)
    {
        $form = FormLogPeminjaman::with('details')->findOrFail($id);
        $template = FormTemplate::where('nama', 'Log Peminjaman Informasi / Dokumen')->first();
        $items = $form->details;
        return view('form-log-peminjaman.edit', compact('form', 'template', 'items'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'no_ref' => 'required',
            'tanggal_ref' => 'required',
            'business_area' => 'required',
            'items' => 'array'
        ]);

        $form = FormLogPeminjaman::findOrFail($id);
        $form->update([
            'no_ref' => $request->no_ref,
            'tanggal_ref' => Carbon::parse($request->tanggal_ref)->format('Y-m-d'),
            'business_area' => $request->business_area,
        ]);

        $form->details()->delete();

        if ($request->has('items')) {
            foreach ($request->items as $item) {
                $form->details()->create($item);
            }
        }

        return redirect()->route('form-log-peminjaman.index')->with('success', 'Formulir berhasil diperbarui');
    }

    public function destroy($id)
    {
        $form = FormLogPeminjaman::findOrFail($id);
        $form->delete();
        return redirect()->route('form-log-peminjaman.index')->with('success', 'Formulir berhasil dihapus');
    }

    public function downloadTemplate()
    {
        return Excel::download(new FormLogPeminjamanExport, 'template_log_peminjaman.xlsx');
    }
}